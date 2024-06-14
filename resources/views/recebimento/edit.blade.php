<x-app-layout>

    <x-slot name="title">
        Edição do recebimento
    </x-slot>

    <div class="ui container">

        <div class="ui fluid card">
            <div class="content">
                <a class="header" href="{{ route('receita.show', ['receita_id' => $receita->id]) }}">{{ $receita->descricao }}</a>
            </div>
            <div class="content">
                <a class="ui sub header"
                    href="{{ route('periodo.go', $receita->periodo) }}">{{ periodo_fmt($receita->periodo) }}</a>
                <div class="meta">
                    <a href="{{ route('pessoa.show', $receita->devedor) }}">{{ $receita->devedor }}</a>
                </div>
            </div>
        </div>

    </div>

    <br>
    <br>

    <div class="ui container">
        <x-form title="Editar recebimento" action="{{ route('recebimento.update', ['receita_id' => $receita->id]) }}" method="PUT">

            <x-input.hidden name="receita_id" value="{{ $receita->id }}" />
            <x-input.hidden name="id" value="{{ $recebimento->id }}" />

            <x-input.valor value="{{ old('valor', $recebimento->valor) }}" required min="0.01" autofocus />
            <x-input.data value="{{ old('data', $recebimento->data) }}" required />
            <x-input.observacao value="{{ old('observacao', $recebimento->observacao) }}" placeholder="Observação opcional" />

            <x-slot name="extraButtons">
                <a href="{{ route('receita.show', ['receita_id' => $receita->id]) }}" class="ui button">Voltar</a>
            </x-slot>

        </x-form>
    </div>



</x-app-layout>
