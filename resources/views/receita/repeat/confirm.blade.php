<x-app-layout>

    <x-slot name="title">
        Confirmar repetição de receita
    </x-slot>

    <div class="ui container">

        <div class="ui info message">
            <p>Confirme as informações para a repetição da receita:</p>
        </div>


        <div class="ui segment">
            <x-form title="Repetição de receitas" action="{{ route('receita.repeat.store') }}" method="POST">
                @foreach ($receitas as $receita)
                    <x-input.periodo value="{{ old('periodo', $receita['periodo']) }}" required
                        label="Período" name="periodo[{{ $receita['parcela'] }}]" id="periodo[{{ $receita['parcela'] }}]" />
                    <x-input.parcelas value="{{ old('parcela', $receita['parcela']) }}" required label="Parcela" min="1" name="parcela[{{ $receita['parcela'] }}]" id="parcela[{{ $receita['parcela'] }}]" />
                    <x-input.descricao value="{{ old('descricao', $receita['descricao']) }}" required name="descricao[{{ $receita['parcela'] }}]" id="descricao[{{ $receita['parcela'] }}]" />
                    <x-input.pessoa value="{{ old('devedor', $receita['devedor']) }}" :pessoas="pessoas()" required name="devedor[{{ $receita['parcela'] }}]" id="devedor[{{ $receita['parcela'] }}]" label="Devedor"/>
                    <x-input.valor value="{{ old('valor', $receita['valor']) }}" required min="0.01" name="valor[{{ $receita['parcela'] }}]" id="valor[{{ $receita['parcela'] }}]" />
                    <x-input.vencimento value="{{ old('vencimento', $receita['vencimento']) }}" label="Vencimento" name="vencimento[{{ $receita['parcela'] }}]" id="vencimento[{{ $receita['parcela'] }}]" />
                    <x-input.agrupador value="{{ old('agrupador', $receita['agrupador']) }}" name="agrupador[{{ $receita['parcela'] }}]" id="agrupador[{{ $receita['parcela'] }}]" />
                    <x-input.localizador value="{{ old('localizador', $receita['localizador']) }}" name="localizador[{{ $receita['parcela'] }}]" id="localizador[{{ $receita['parcela'] }}]" />
                @endforeach
            </x-form>
        </div>


    </div>


</x-app-layout>
