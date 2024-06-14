<x-app-layout>

    <x-slot name="title">
        Repetir despesa
    </x-slot>

    <div class="ui container">
        <x-form title="Repetir despesa" action="{{ route('despesa.repeat.confirm') }}" method="POST">

            <x-input.periodo label="Período inicial" value="{{ old('periodo') ?? (session('periodo') ?? date('Y-m')) }}" required autofocus />
            <x-input.parcelas value="{{ old('parcelas', 2) }}" required label="Repetições" />
            <x-input.descricao value="{{ old('descricao') }}" required />
            <x-input.valor value="{{ old('valor') }}" required min="0.01" />


            <div class="ui toggle checkbox" id="gastar-label">
                <input type="checkbox" tabindex="0" class="hidden" name="gastar" id="gastar">
                <label>Gastar</label>
            </div>
            <div class="ui segment disabled" id="gastar-form">
                <x-input.data id="gastoem" name="gastoem" label="Gasto em" value="{{ old('gastoem') }}" />
                <x-input.observacao value="{{ old('observacao') }}" placeholder="Observação opcional" />
                <x-input.pessoa id="credor" name="credor" label="Credor" value="{{ old('credor') }}"
                    :pessoas="pessoas()" />
                <x-input.meio-pagamento value="{{ old('mp') }}" :mps="mps()" />
                <x-input.vencimento value="{{ old('vencimento') }}" label="Vencimento inicial" />
                <x-input.agrupador value="{{ old('agrupador') }}" />
                <x-input.localizador value="{{ old('localizador') }}" />
            </div>



        </x-form>
    </div>

    <script type="module">
        $('.ui.checkbox')
            .checkbox();

        $('#gastar').change(function() {
            if (this.checked) {
                $('#gastar-label').addClass('checked');
                $('#gastar-form').removeClass('disabled');
                $('#gastoem').attr('required', '');
                $('#credor').attr('required', '');
                $('#mp').attr('required', '');
            } else {
                $('#gastar-label').removeClass('checked');
                $('#gastar-form').addClass('disabled');
                $('#gastoem').removeAttr('required');
                $('#credor').removeAttr('required');
                $('#mp').removeAttr('required');
            }
        });
    </script>
</x-app-layout>
