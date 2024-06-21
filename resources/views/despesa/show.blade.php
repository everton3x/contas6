<x-app-layout>

    <x-slot name="title">
        Detalhes da despesa
    </x-slot>

    <div class="ui container">

        <div class="ui fluid card">
            <div class="content">
                <div class="header">{{ $despesa->descricao }}</div>
            </div>
            <div class="content">
                <a class="ui sub header" href="{{ route('periodo.go', $despesa->periodo) }}">{{ periodo_fmt($despesa->periodo) }}</a>


                <div class="ui fluid cards">
                    <div class="card">
                        <div class="content">
                            <div class="description">
                                Previsto
                            </div>
                            <div class="right floated header">
                                {{ money_fmt($despesa->valor) }}
                                <a href="{{ route('despesa.previsao.adjust', $despesa->id) }}" class="ui right floated mini icon button">
                                    <i class="equals icon"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="content">
                            <div class="description">
                                Gasto
                            </div>
                            <div class="right floated header">
                                {{ money_fmt($despesa->totalGasto()) }}
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="content">
                            <div class="description">
                                A gastar
                            </div>
                            <div class="right floated header">
                                {{ money_fmt($despesa->totalAGastar()) }}
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="content">
                            <div class="description">
                                Pago
                            </div>
                            <div class="right floated header">
                                {{ money_fmt($despesa->totalPago()) }}
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="content">
                            <div class="description">
                                A pagar
                            </div>
                            <div class="right floated header">
                                {{ money_fmt($despesa->totalAPagar()) }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="ui borderless menu">
            <div class="item">
                <a class="ui primary button" href="{{ route('gasto.create', ['despesa_id' => $despesa->id]) }}">Gastar</a>
            </div>
            <div class="right menu">
                <div class="item">
                    <a class="ui teal button" href="{{ route('despesa.edit', ['despesa_id' => $despesa->id]) }}">Editar</a>
                </div>
                <div class="item">
                    <a class="ui red button" href="{{ route('despesa.delete', ['despesa_id' => $despesa->id]) }}">Apagar</a>
                </div>
            </div>
        </div>



        <table class="ui celled striped table">
            <caption class="ui left aligned header">Gastos</caption>
            <thead>
                <tr>
                    <th class="left aligned collapsing">Gasto em</th>
                    <th class="right aligned collapsing">Valor</th>
                    <th class="left aligned">Credor</th>
                    <th class="left aligned collapsing">Meio de Pagamento</th>
                    <th class="left aligned collapsing">Observação</th>
                    <th class="left aligned collapsing">Vencimento</th>
                    <th class="left aligned collapsing">Agrupador</th>
                    <th class="left aligned collapsing">Localizador</th>
                    <th class="right aligned collapsing">Pago em</th>
                    <th class="left aligned collapsing">Observação do pagamento</th>
                    <th class="center aligned collapsing">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ( $despesa->gastos as $gasto)
                    <tr>
                        <td class="left aligned">{{ data_fmt($gasto->gastoem) }}</td>
                        <td class="right aligned">{{ money_fmt($gasto->valor) }}</td>
                        <td class="left aligned"><a href="{{ route('pessoa.show', $gasto->credor) }}">{{ $gasto->credor }}</a></td>
                        <td class="left aligned"><a href="{{ route('mp.show', $gasto->mp) }}">{{ $gasto->mp }}</a></td>
                        <td class="left aligned">{{ $gasto->observacao }}</td>
                        <td class="left aligned">{{ data_fmt($gasto->vencimento) }}</td>
                        <td class="left aligned"><a href="{{ route('agrupador.show', $gasto->agrupador) }}">{{ $gasto->agrupador }}</a></td>
                        <td class="left aligned"><a href="{{ route('localizador.show', $gasto->localizador) }}">{{ $gasto->localizador }}</a></td>
                        <td class="left aligned">{{ data_fmt($gasto->pagoem) }}</td>
                        <td class="left aligned">{{ $gasto->observacao_pgto }}</td>
                        <td class="center aligned">
                            <div class="ui spaced buttons">
                                <a href="{{ route('gasto.payment', ['despesa_id' => $despesa->id, 'gasto_id' => $gasto->id]) }}" class="ui green icon button">
                                    <i class="donate icon"></i>
                                </a>
                                <a href="{{ route('gasto.edit', ['despesa_id' => $despesa->id, 'gasto_id' => $gasto->id]) }}" class="ui teal icon button">
                                    <i class="edit icon"></i>
                                </a>
                                <a href="{{ route('gasto.delete', ['despesa_id' => $despesa->id, 'gasto_id' => $gasto->id]) }}" class="ui red icon button">
                                    <i class="trash icon"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="left aligned">Sem gastos para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>

            <tfoot>
                <tr>
                    <th class="left aligned">Total</th>
                    <th class="right aligned">{{ money_fmt($despesa->totalGasto()) }}</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>

    </div>

</x-app-layout>
