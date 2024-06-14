<x-app-layout>

    <x-slot name="title">
        Edição do gasto
    </x-slot>

    <div class="ui container">

        <div class="ui fluid card">
            <div class="content">
                <a class="header" href="{{ route('despesa.show', ['despesa_id' => $despesa->id]) }}">{{ $despesa->descricao }}</a>
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
        <x-form title="Editar gasto" action="{{ route('gasto.update', ['despesa_id' => $despesa->id]) }}" method="PUT">

            <x-input.hidden name="despesa_id" value="{{ $despesa->id }}" />
            <x-input.hidden name="id" value="{{ $gasto->id }}" />

                <x-input.valor value="{{ old('valor', $gasto->valor) }}" required min="0.01" autofocus />
                <x-input.data id="gastoem" name="gastoem" label="Gasto em" value="{{ old('gastoem', $gasto->gastoem) }}" required />
                <x-input.observacao value="{{ old('observacao', $gasto->observacao) }}" placeholder="Observação opcional" />
                <x-input.pessoa id="credor" name="credor" label="Credor" value="{{ old('credor', $gasto->credor) }}" :pessoas="pessoas()" required />
                <x-input.meio-pagamento value="{{ old('mp', $gasto->mp) }}" :mps="mps()" required />
                <x-input.vencimento value="{{ old('vencimento', $gasto->vencimento) }}" />
                <x-input.agrupador value="{{ old('agrupador', $gasto->agrupador) }}" />
                <x-input.localizador value="{{ old('localizador', $gasto->localizador) }}" />
                <x-input.data id="pagoem" name="pagoem" label="Pago em" value="{{ old('pagoem', $gasto->pagoem) }}" />
                <x-input.observacao id="observacao_pgto" name="observacao_pgto" value="{{ old('observacao_pgto', $gasto->observacao_pgto) }}" placeholder="Observação opcional do pagamento" />

            <x-slot name="extraButtons">
                <a href="{{ route('despesa.show', ['despesa_id' => $despesa->id]) }}" class="ui button">Voltar</a>
            </x-slot>

        </x-form>
    </div>



</x-app-layout>
