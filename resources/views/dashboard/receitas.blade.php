<div class="ui container">

    <table class="ui celled striped green table">
        <caption class="ui left aligned header">Receitas</caption>
        <thead>
            <tr>
                <th class="left aligned">
                    Receita
                    <a href="{{ route('receita.create') }}" class="ui right floated mini primary icon button">
                        <i class="plus icon"></i>
                    </a>
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
                        <a href="{{ route('receita.show', ['receita_id' => $receita->id]) }}">{{ $receita->descricao }}</a>
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
