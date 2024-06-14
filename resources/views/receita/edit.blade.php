<x-app-layout>

    <x-slot name="title">
        Edição da receita
    </x-slot>

    <div class="ui container">
        <x-form title="Editar receita" action="{{ route('receita.update') }}" method="PUT">

            <x-input.hidden name="id" value="{{ $receita->id }}" />

            <x-input.periodo value="{{ old('periodo') ?? (session('periodo', $receita->periodo)) }}" required autofocus />
            <x-input.descricao value="{{ old('descricao', $receita->descricao) }}" required />
            <x-input.pessoa value="{{ old('devedor', $receita->devedor) }}" :devedores="pessoas()" required id="devedor" name="devedor" label="Devedor"/>
            <x-input.valor value="{{ old('valor', $receita->valor) }}" required min="0.01" />
            <x-input.vencimento value="{{ old('vencimento', $receita->vencimento) }}" />
            <x-input.agrupador value="{{ old('agrupador', $receita->agrupador) }}" />
            <x-input.localizador value="{{ old('localizador, $receita->localizador') }}" />

        </x-form>
    </div>


</x-app-layout>
