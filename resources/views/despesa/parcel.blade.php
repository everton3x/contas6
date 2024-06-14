<x-app-layout>

    <x-slot name="title">
        Parcelar despesa
    </x-slot>

    <div class="ui container">
        <x-form title="Parcelar despesa" action="{{ route('despesa.parcel.confirm') }}" method="POST">

            <x-input.periodo label="Período inicial" value="{{ old('periodo') ?? (session('periodo') ?? date('Y-m')) }}"
                required autofocus />
            <x-input.parcelas value="{{ old('parcelas', 2) }}" required label="Repetições" />
            <x-input.descricao value="{{ old('descricao') }}" required />
            <x-input.valor value="{{ old('valor') }}" required min="0.01" />
            <x-input.tipo-valor required />
            <x-input.data id="gastoem" name="gastoem" label="Gasto em" value="{{ old('gastoem') }}" required />
            <x-input.observacao value="{{ old('observacao') }}" placeholder="Observação opcional" />
            <x-input.pessoa id="credor" name="credor" label="Credor" value="{{ old('credor') }}" :pessoas="pessoas()"
                required />
            <x-input.meio-pagamento value="{{ old('mp') }}" :mps="mps()" required />
            <x-input.vencimento value="{{ old('vencimento') }}" label="Vencimento inicial" />
            <x-input.agrupador value="{{ old('agrupador') }}" />
            <x-input.localizador value="{{ old('localizador') }}" />


        </x-form>
    </div>

</x-app-layout>
