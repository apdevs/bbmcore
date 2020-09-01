<div class="btn-group btn-group-sm">
    <button type="button" class="btn btn-default btn-slt">
        {{ parsed.name|default('Seleccionar...') }}
    </button>
    {% if parsed %}
        <button type="button" class="btn bgm-yellow btn-slt-rm">
            <i class="zmdi zmdi-close c-red f-700"></i>
        </button>
    {% endif %}
</div>
<input type="hidden" name="{{ inpname|default('') }}" value="{{ parsed.id|default('') }}" />
