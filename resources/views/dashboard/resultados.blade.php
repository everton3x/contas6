{{-- @php

@endphp --}}
<div class="ui container">

    <table class="ui celled striped blue table">
        <caption class="ui left aligned header">Resultados</caption>
        <thead>
            <tr>
                <th class="left aligned">
                    Resultado
                </th>
                <th class="right aligned collapsing">Valor</th>
            </tr>
        </thead>

        <tbody>
            <tr @class(['positive' => $resultadoMes > 0, 'negative' => $resultadoMes < 0])>
                <td class="left aligned">do Mês</td>
                <td class="right aligned">{{ money_fmt($resultadoMes) }}</td>
            </tr>
            <tr @class(['positive' => $resultadoAnterior > 0, 'negative' => $resultadoAnterior < 0])>
                <td class="left aligned">do Mês Anterior</td>
                <td class="right aligned">{{ money_fmt($resultadoAnterior) }}</td>
            </tr>
            <tr @class(['positive' => $resultadoAcumulado > 0, 'negative' => $resultadoAcumulado < 0])>
                <td class="left aligned">Acumulado</td>
                <td class="right aligned">{{ money_fmt($resultadoAcumulado) }}</td>
            </tr>
        </tbody>
    </table>

</div>
