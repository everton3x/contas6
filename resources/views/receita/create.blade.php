<x-app-layout>

    <x-slot name="title">
        Criar receita
    </x-slot>

    <div class="ui container">
        <x-form title="Nova receita" action="{{ route('receita.store') }}" method="POST">

            <x-input.periodo value="{{ old('periodo') ?? (session('periodo') ?? date('Y-m')) }}" required autofocus />
            <x-input.descricao value="{{ old('descricao') }}" required />
            <x-input.pessoa id="devedor" name="devedor" label="Devedor" value="{{ old('devedor') }}" :pessoas="pessoas()" required />
            <x-input.valor value="{{ old('valor') }}" required min="0.01" />
            <x-input.vencimento value="{{ old('vencimento') }}" />
            <x-input.agrupador value="{{ old('agrupador') }}" />
            <x-input.localizador value="{{ old('localizador') }}" />

        </x-form>
    </div>


</x-app-layout>
