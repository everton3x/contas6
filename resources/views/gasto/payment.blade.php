<x-app-layout>

    <x-slot name="title">
        Pagamento
    </x-slot>

    <div class="ui container">

        <div class="ui fluid card">
            <div class="content">
                <a class="header"
                    href="{{ route('despesa.show', ['despesa_id' => $despesa->id]) }}">{{ $despesa->descricao }}</a>
            </div>
            <div class="content">
                <a class="ui sub header"
                    href="{{ route('periodo.go', $despesa->periodo) }}">{{ periodo_fmt($despesa->periodo) }}</a>
            </div>
        </div>

    </div>

    <br>
    <br>

    <div class="ui container">
        <x-form title="Pagamento" action="{{ route('gasto.pay', ['despesa_id' => $despesa->id]) }}" method="PUT">

            <x-input.hidden name="despesa_id" value="{{ $despesa->id }}" />
            <x-input.hidden name="id" value="{{ $gasto->id }}" />

            <x-input.data id="pagoem" name="pagoem" label="Pago em" value="{{ old('pagoem', $gasto->pagoem) }}" autofocus required />
            <x-input.observacao id="observacao_pgto" name="observacao_pgto"
                value="{{ old('observacao_pgto', $gasto->observacao_pgto) }}"
                placeholder="Observação opcional do pagamento" />

            <x-slot name="extraButtons">
                <a href="{{ route('despesa.show', ['despesa_id' => $despesa->id]) }}" class="ui button">Voltar</a>
            </x-slot>

        </x-form>
    </div>



</x-app-layout>
