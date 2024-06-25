<div class="ui container">

    <table class="ui celled striped red table">
        <caption class="ui left aligned header">Despesas</caption>
        <thead>
            <tr>
                <th class="left aligned">
                    Despesa
                    <a href="{{ route('despesa.create') }}" class="ui right floated mini primary icon button" accesskey="ctrl+d">
                        <i class="plus icon"></i>
                        <span class="hidden-on-mobile"><u>D</u>espesa</span>
                    </a>
                </th>
                <th class="right aligned collapsing">Previsto</th>
                <th class="right aligned collapsing">Gasto</th>
                <th class="right aligned collapsing">A gastar</th>
            </tr>
        </thead>

        <tbody>
            @php
                $totalPrevisto = 0.0;
                $totalGasto = 0.0;
                $totalAGastar = 0.0;
            @endphp
            @forelse ($despesas as $despesa)
                @php
                    $totalPrevisto += $despesa->valor;
                    $totalGasto += $despesa->totalGasto();
                    $totalAGastar += $despesa->totalAGastar();
                @endphp
                <tr @class(['negative' => $despesa->totalAGastar() < 0.0])>
                    <td class="left aligned">
                        <a href="{{ route('despesa.show', ['despesa_id' => $despesa->id]) }}">{{ $despesa->descricao }}</a>
                    </td>
                    <td class="right aligned">{{ money_fmt($despesa->valor) }}</td>
                    <td class="right aligned">{{ money_fmt($despesa->totalGasto()) }}</td>
                    <td class="right aligned">{{ money_fmt($despesa->totalAGastar()) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="left aligned">Sem despesas para o período.</td>
                </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr>
                <td class="left aligned">Total</td>
                <td class="right aligned">{{ money_fmt($totalPrevisto) }}</td>
                <td class="right aligned">{{ money_fmt($totalGasto) }}</td>
                <td class="right aligned">{{ money_fmt($totalAGastar) }}</td>
            </tr>
        </tfoot>
    </table>

</div>
