define([
	'msgBus',
	'underscore',
	'core/app',
],

function (bus, _, App) {

	var SltButton = App.ItemView.extend({
		template: 'core::sltbutton',

		options: {
			event_name: 'selector:select',
			parser: function (selection) {
				return _.pick(selection, 'id', 'name')
			}
		},

		behaviors: function () {
			return {
				Selector: {
					selector: this.getOption('selector'),
					options: this.getOption('options'),
					event_name: this.getOption('event_name')
				}
			};
		},

		initialize: function (options) {
			this.selection = options.preselect;
			this.event_name = options.event_name;

			this.on(this.event_name, this.setSelection);
			this.on('selection:clear', this.cleanSelection);
		},

		setSelection: function (selection) {
			this.selection = selection;

			this.render();
		},

		cleanSelection: function () {
			this.setSelection(null);
		},

		serializeData: function () {
			if (! this.selection) {
				return {
					inpname: this.getOption('inpname')
				};
			}

			var parser = this.getOption('parser');

			return {
				selection: this.selection,
				parsed: parser(this.selection),
				inpname: this.getOption('inpname')
			};
		}
	});

	return SltButton;
});
