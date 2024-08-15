<x-app-layout>

    <x-slot name="title">
        Parcelar receita
    </x-slot>

    <div class="ui container">
        <x-form title="Nova receita parcelada" action="{{ route('receita.parcel.confirm') }}" method="POST">

            <x-input.periodo value="{{ old('periodo') ?? (session('periodo') ?? date('Y-m')) }}" required autofocus label="Período inicial" />
            <x-input.parcelas value="{{ old('parcelas', 2) }}" required label="Repetições" />
            <x-input.descricao value="{{ old('descricao') }}" required />
            <x-input.pessoa value="{{ old('devedor') }}" :devedores="pessoas()" required />
            <x-input.valor value="{{ old('valor') }}" required min="0.01" />
            <x-input.tipo-valor required />
            <x-input.vencimento value="{{ old('vencimento') }}" label="Vencimento inicial" required />
            <x-input.agrupador value="{{ old('agrupador') }}" required />
            <x-input.localizador value="{{ old('localizador') }}" />

        </x-form>
    </div>


</x-app-layout>
