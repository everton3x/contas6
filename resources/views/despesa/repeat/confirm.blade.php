<x-app-layout>

    <x-slot name="title">
        Confirmar repetição de despesa
    </x-slot>

    <div class="ui container">

        <div class="ui info message">
            <p>Confirme as informações para a repetição da despesa:</p>
        </div>


        <div class="ui segment">
            <x-form title="Repetição de despesa" action="{{ route('despesa.repeat.store') }}" method="POST">
                <x-input.hidden name="gastar" value="{{ $despesas[1]['gastar'] ?? 'on' }}" />
                @foreach ($despesas as $despesa)
                    <x-input.periodo value="{{ old('periodo', $despesa['periodo']) }}" required label="Período"
                        name="periodo[{{ $despesa['parcela'] }}]" id="periodo[{{ $despesa['parcela'] }}]" />
                    <x-input.parcelas value="{{ old('parcela', $despesa['parcela']) }}" required label="Parcela"
                        min="1" name="parcela[{{ $despesa['parcela'] }}]"
                        id="parcela[{{ $despesa['parcela'] }}]" />
                    <x-input.descricao value="{{ old('descricao', $despesa['descricao']) }}" required
                        name="descricao[{{ $despesa['parcela'] }}]" id="descricao[{{ $despesa['parcela'] }}]" />
                    <x-input.valor value="{{ old('valor', $despesa['valor']) }}" required min="0.01"
                        name="valor[{{ $despesa['parcela'] }}]" id="valor[{{ $despesa['parcela'] }}]" />

                    @if ($despesa['gastar'])
                        <x-input.data value="{{ old('gastoem', $despesa['gastoem']) }}" label="Gasto em"
                            name="gastoem[{{ $despesa['parcela'] }}]" id="gastoem[{{ $despesa['parcela'] }}]" />
                        <x-input.observacao value="{{ old('observacao', $despesa['observacao']) }}"
                            name="observacao[{{ $despesa['parcela'] }}]" id="observacao[{{ $despesa['parcela'] }}]" />
                        <x-input.pessoa value="{{ old('credor', $despesa['credor']) }}" :pessoas="pessoas()" required
                            name="credor[{{ $despesa['parcela'] }}]" id="credor[{{ $despesa['parcela'] }}]"
                            label="Credor" />
                        <x-input.meio-pagamento value="{{ old('mp', $despesa['mp']) }}" :mps="mps()" required
                            name="mp[{{ $despesa['parcela'] }}]" id="mp[{{ $despesa['parcela'] }}]"
                            label="Meio de Pagamento" />
                        <x-input.vencimento value="{{ old('vencimento', $despesa['vencimento']) }}" label="Vencimento"
                            name="vencimento[{{ $despesa['parcela'] }}]" id="vencimento[{{ $despesa['parcela'] }}]" />
                        <x-input.agrupador value="{{ old('agrupador', $despesa['agrupador']) }}"
                            name="agrupador[{{ $despesa['parcela'] }}]" id="agrupador[{{ $despesa['parcela'] }}]" />
                        <x-input.localizador value="{{ old('localizador', $despesa['localizador']) }}"
                            name="localizador[{{ $despesa['parcela'] }}]"
                            id="localizador[{{ $despesa['parcela'] }}]" />
                    @endif
                @endforeach
            </x-form>
        </div>


    </div>


</x-app-layout>
