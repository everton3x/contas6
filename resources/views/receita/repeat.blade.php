<x-app-layout>

    <x-slot name="title">
        Criar receita repetida
    </x-slot>

    <div class="ui container">
        <x-form title="Receita repetida" action="{{ route('receita.repeat.confirm') }}" method="POST">

            <x-input.periodo value="{{ old('periodo') ?? (session('periodo') ?? date('Y-m')) }}" required autofocus label="Período inicial" />
            <x-input.parcelas value="{{ old('parcelas', 2) }}" required label="Repetições" />
            <x-input.descricao value="{{ old('descricao') }}" required />
            <x-input.pessoa id="devedor" name="devedor" label="Devedor" value="{{ old('devedor') }}" :pessoas="pessoas()" required />
            <x-input.valor value="{{ old('valor') }}" required min="0.01" />
            <x-input.vencimento value="{{ old('vencimento') }}" label="Vencimento inicial" />
            <x-input.agrupador value="{{ old('agrupador') }}"/>
            <x-input.localizador value="{{ old('localizador') }}" />

        </x-form>
    </div>


</x-app-layout>
