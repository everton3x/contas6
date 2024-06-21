@php
    switch ($route) {
        case 'pessoa.list':
            $title = 'Pessoas';
            break;
        case 'agrupador.list':
            $title = 'Agrupadores';
            break;
        case 'localizador.list':
            $title = 'Localizadores';
            break;
        case 'mp.list':
            $title = 'Meios de pagamento';
            break;

        default:
            throw new \Exception("Rota inválida", 1);

            break;
    }
@endphp
<x-app-layout>
    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <div class="ui container">
        <div class="ui dividing header">
            <div class="content">
                Detalhes para {{ $item }}
                <div class="sub header">{{ $title }}</div>
            </div>
        </div>
    </div>

    <div class="ui basic menu">
        <div class="item">
            <a href="{{ route($route) }}" class="ui button">Voltar</a>
        </div>
    </div>

    <br>
    <br>
    @if ($route !== 'mp.list')
        <div class="ui container">

            <table class="ui celled striped green table">
                <caption class="ui left aligned header">Receitas</caption>
                <thead>
                    <tr>
                        <th class="left aligned">
                            Receita
                        </th>
                        <th class="right aligned collapsing">Previsto</th>
                        <th class="right aligned collapsing">Recebido</th>
                        <th class="right aligned collapsing">A receber</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $totalPrevisto = 0.0;
                        $totalRecebido = 0.0;
                        $totalAReceber = 0.0;
                    @endphp
                    @forelse ($receitas as $receita)
                        @php
                            $totalPrevisto += $receita->valor;
                            $totalRecebido += $receita->totalRecebido();
                            $totalAReceber += $receita->totalAReceber();
                        @endphp
                        <tr @class(['negative' => $receita->totalAReceber() < 0.0])>
                            <td class="left aligned">
                                <a
                                    href="{{ route('receita.show', ['receita_id' => $receita->id]) }}">{{ $receita->descricao }}</a>
                            </td>
                            <td class="right aligned">{{ money_fmt($receita->valor) }}</td>
                            <td class="right aligned">{{ money_fmt($receita->totalRecebido()) }}</td>
                            <td class="right aligned">{{ money_fmt($receita->totalAReceber()) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="left aligned">Sem receitas para o período.</td>
                        </tr>
                    @endforelse
                </tbody>

                <tfoot>
                    <tr>
                        <td class="left aligned">Total</td>
                        <td class="right aligned">{{ money_fmt($totalPrevisto) }}</td>
                        <td class="right aligned">{{ money_fmt($totalRecebido) }}</td>
                        <td class="right aligned">{{ money_fmt($totalAReceber) }}</td>
                    </tr>
                </tfoot>
            </table>

        </div>


        <br>
        <br>
    @endif


    <div class="ui container">

        <table class="ui celled striped red table">
            <caption class="ui left aligned header">Gastos</caption>
            <thead>
                <tr>
                    <th class="left aligned">Período</th>
                    <th class="left aligned">Gasto em</th>
                    <th class="right aligned">Valor</th>
                    <th class="left aligned">Credor</th>
                    <th class="left aligned">Meio de Pagamento</th>
                    <th class="left aligned">Observação</th>
                    <th class="left aligned">Vencimento</th>
                    <th class="left aligned">Agrupador</th>
                    <th class="left aligned">Localizador</th>
                    <th class="right aligned">Pago em</th>
                    <th class="left aligned">Observação do pagamento</th>
                    <th class="center aligned">Ações</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalGasto = 0.0;
                @endphp
                @forelse ($gastos as $gasto)
                    @php
                        $totalGasto += $gasto->valor;
                    @endphp
                    <tr>
                        <td class="left aligned collapsing">{{ periodo_fmt($gasto->despesa->periodo) }}</td>
                        <td class="left aligned collapsing">{{ data_fmt($gasto->gastoem) }}</td>
                        <td class="right aligned collapsing">{{ money_fmt($gasto->valor) }}</td>
                        <td class="left aligned collapsing">{{ $gasto->credor }}</td>
                        <td class="left aligned collapsing">{{ $gasto->mp }}</td>
                        <td class="left aligned collapsing">{{ $gasto->observacao }}</td>
                        <td class="left aligned collapsing">{{ data_fmt($gasto->vencimento) }}</td>
                        <td class="left aligned collapsing">{{ $gasto->agrupador }}</td>
                        <td class="left aligned collapsing">{{ $gasto->localizador }}</td>
                        <td class="left aligned collapsing">{{ data_fmt($gasto->pagoem) }}</td>
                        <td class="left aligned collapsing">{{ $gasto->observacao_pgto }}</td>
                        <td class="center aligned collapsing">
                            <div class="ui spaced buttons">
                                <a href="{{ route('despesa.show', ['despesa_id' => $gasto->despesa->id]) }}"
                                    class="ui blue icon button">
                                    <i class="money bill icon"></i>
                                </a>
                                <a href="{{ route('gasto.payment', ['despesa_id' => $gasto->despesa->id, 'gasto_id' => $gasto->id]) }}"
                                    class="ui green icon button">
                                    <i class="donate icon"></i>
                                </a>
                                <a href="{{ route('gasto.edit', ['despesa_id' => $gasto->despesa->id, 'gasto_id' => $gasto->id]) }}"
                                    class="ui teal icon button">
                                    <i class="edit icon"></i>
                                </a>
                                <a href="{{ route('gasto.delete', ['despesa_id' => $gasto->despesa->id, 'gasto_id' => $gasto->id]) }}"
                                    class="ui red icon button">
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
                    <th colspan="2" class="left aligned">Total</th>
                    <th class="right aligned">{{ money_fmt($totalGasto) }}</th>
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
