define([
	'msgBus',
	'build/templates',
	'swig',
	'underscore',
	'numeral',
	'core/libs/fecha',
	'moment'
],

function (bus, templates, swig, _, numeral, fecha, moment) {

	templates.cache = templates.cache || {};

	var folder = '/templates/';

	numeral.dinero = function (monto) {
		return numeral(monto).format('$0,0.00');
	};

	numeral.cantidad = function (monto) {
		return numeral(monto).format('0,0.[000]');
	};

	numeral.entero = function (monto) {
		return numeral(monto).format('0,0');
	};

	moment.DATE_FORMAT = 'YYYY-MM-DD';
	moment.FULLDATE_FORMAT = 'YYYY-MM-DD HH:mm';

	swig.setDefaults({
		cache: {
			/** Bug, agregar nombre de modulo a "name" */
			get: function (key) {
				var name, index = key.indexOf(folder);

				name = index >= 0 ? key.slice(index + folder.length) : key;

				if (templates[name]) {
					return function (data) {
						return swig.run(templates[name], data || {});
					};
				}

				return templates.cache[name] || null;
			},

			set: function (key, val) {
				templates.cache[key] = val;
			}
		}
	});

	function isFilled(input) {
		return input != undefined && input != null && _.trim(input) != '';
	}

	function is(item, values) {
		items = _.isArray(values) ? values : [values];

		return _.contains(items, item);
	}

	swig.setFilter('isFilled', isFilled);

	swig.setFilter('orDefault', function (input, defaultvalue) {
		return isFilled(input) ? input : (defaultvalue || '');
	});

	swig.setFilter('is', is);

	swig.setFilter('isAdminOrEmployee', function (user, values) {
		if (user.type == 'employee' && user.employee) {
			var position = user.employee.position;

			return is(position, 'administrador') || is(position, values);
		}

		return user.type == 'developer';
	});

	swig.setFilter('short', function (input,n) { return input.short(n); });

	swig.setFilter('fixed', function (input, n) {
		n = n || 2;

		return parseFloat(input).toFixed(n);
	});

	swig.setFilter('numeral', function (input, format) {
		if (input === null || typeof input === 'undefined')
		{
			return input;
		}

		return numeral(input).format(format);
	});

	swig.setFilter('dinero', function (input) {
		if (input === null || typeof input === 'undefined')
		{
			return input;
		}

		return numeral(input).format('$0,0.00');
	});

	swig.setFilter('pluck', _.pluck);

	swig.setFilter('unique', _.unique.bind(_));

	swig.setFilter('id', _.uniqueId.bind(_));

	swig.setFilter('percentTag', function (input) {
		switch (true) {
			case (input < 51): return 'danger';
			case (input < 71): return 'warning';
			case (input < 91): return 'info';
			case (input < 100): return 'primary';
			case (input == 100): return 'success';
			default: return 'default';
		}
	});

	swig.setFilter('range', function (input) {
		return _.range(1, 1 + input);
	});

	swig.setFilter('fecha', function (input, format, parse) {
		format = format || 'default';
		parse = parse || 'YYYY-MM-DD HH:mm';

		var _fecha = fecha.parse(input, parse);

		return fecha.format(_fecha, format);
	});

	swig.setFilter('moment', function (input, format, parse) {
		format = format || 'LL';
		parse = parse || 'YYYY-MM-DD HH:mm';

		return moment(input, parse).format(format);
	});

	swig.setFilter('fromnow', function (input, parse, extra_days) {
		parse = parse || 'YYYY-MM-DD HH:mm';
		extra_days = extra_days || 0;

		return moment(input, parse).add(extra_days, 'day').fromNow();
	});

	swig.setFilter('momentParse', function (input, format, parse) {
		format = format || 'LL';
		parse = parse || 'YYYY-MM-DD HH:mm';

		return moment(input, parse);
	});

	swig.setFilter('momentIs', function (date, tipo, fecha, precision) {
		switch (tipo) {
			case 'before': return date.isBefore(fecha, precision);
			case 'after': return date.isAfter(fecha, precision);
		}
	});

	swig.setFilter('diffFrom', function (date, tipo, fecha) {
		fecha = moment(fecha);

		return fecha.diff(date, tipo || 'days');
	});

	swig.setFilter('percent', function (input) {
		return input ? input / 100 : 0;
	});

	swig.setFilter('sum', function (items) {
		return _.reduce(items, function (sum, item) {
			return sum + item;
		}, 0);
	});

	swig.setFilter('contains', function (items, value) {
		return _.contains(items, value);
	});

	swig.setFilter('replace', function (input, searchvalue, newvalue) {
		return input.replace(searchvalue, newvalue);
	});

	function getTemplate(template) {
		if (_.isFunction(template))
		{
			return template;
		}

		return templates[template+'.swig'] || function () {
			return 'Template -'+template+'- not found';
		};
	}

	function render(template, data) {
		return swig.run(getTemplate(template), data);
	}

	function compile(template, data) {
		if (_.isArray(template))
		{
			template = template.join('');
		}

		var tpl = swig.compile(template);

		return _.isObject(data)? tpl(data) : tpl;
	}

	return {
		render: render,
		compile: compile,
		get: getTemplate,
		setLocals: function (data) {
			swig.setDefaults({ locals: data });
		}
	};

});
