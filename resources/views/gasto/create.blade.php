<x-app-layout>

    <x-slot name="title">
        Gastar
    </x-slot>

    <div class="ui container">

        <div class="ui fluid card">
            <div class="content">
                <a class="header" href="{{ route('despesa.show', ['despesa_id' => $despesa->id]) }}">{{ $despesa->descricao }}</a>
            </div>
            <div class="content">
                <a class="ui sub header"
                    href="{{ route('periodo.go', $despesa->periodo) }}">{{ periodo_fmt($despesa->periodo) }}
                </a>
            </div>

            <div class="extra content">
                <div class="ui mini statistics">
                    <div class="statistic">
                      <div class="value">
                        {{ money_fmt($despesa->valor) }}
                      </div>
                      <div class="label">
                        Previsto
                      </div>
                    </div>
                    <div class="statistic">
                      <div class="value">
                        {{ money_fmt($despesa->gastos->sum('valor')) }}
                      </div>
                      <div class="label">
                        Gasto
                      </div>
                    </div>
                    <div class="statistic">
                      <div class="value">
                        {{ money_fmt($despesa->valor - $despesa->gastos->sum('valor')) }}
                      </div>
                      <div class="label">
                        A Gastar
                      </div>
                    </div>
                  </div>
            </div>
        </div>

    </div>

    <br>
    <br>

    <div class="ui container">
        <x-form title="Novo gasto" action="{{ route('gasto.store', ['despesa_id' => $despesa->id]) }}" method="POST">

            <x-input.hidden name="despesa_id" value="{{ $despesa->id }}" />

            <x-input.valor value="{{ old('valor') }}" required min="0.01" autofocus />
            <x-input.data id="gastoem" name="gastoem" label="Gasto em" value="{{ old('gastoem') }}" required />
            <x-input.observacao value="{{ old('observacao') }}" placeholder="Observação opcional" />
            <x-input.pessoa id="credor" name="credor" label="Credor" value="{{ old('credor') }}" :pessoas="pessoas()" required />
            <x-input.meio-pagamento value="{{ old('mp') }}" :mps="mps()" required />
            <x-input.vencimento value="{{ old('vencimento') }}" />
            <x-input.agrupador value="{{ old('agrupador') }}" />
            <x-input.localizador value="{{ old('localizador') }}" />
            <x-input.data id="pagoem" name="pagoem" label="Pago em" value="{{ old('pagoem') }}" />
            <x-input.observacao id="observacao_pgto" name="observacao_pgto" value="{{ old('observacao_pgto') }}" placeholder="Observação opcional do pagamento" />


            <x-slot name="extraButtons">
                <a href="{{ route('despesa.show', ['despesa_id' => $despesa->id]) }}" class="ui button">Voltar</a>
            </x-slot>

        </x-form>
    </div>



</x-app-layout>
