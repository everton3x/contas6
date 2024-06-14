<x-app-layout>

    <x-slot name="title">
        Multiplos pagamentos
    </x-slot>

    <div class="ui container">

        <x-form title="Gastos selecionados para pagamento" action="{{ route('filter.gasto.pay') }}" method="POST"
            submitLabel="Pagar">

            <table class="ui celled striped table">
                <thead>
                    <tr>
                        <th class="right aligned">Período</th>
                        <th class="left aligned">Despesa</th>
                        <th class="left aligned">Observação</th>
                        <th class="right aligned">Valor</th>
                        <th class="left aligned">Meio Pgto.</th>
                        <th class="left aligned">Credor</th>
                        <th class="right aligned">Vencimento</th>
                        <th class="left aligned">Agrupador</th>
                        <th class="left aligned">Localizador</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $total = 0.0;
                    @endphp
                    @forelse ($gastos as $gasto)
                        @php
                            $total += $gasto->valor;
                        @endphp
                        <x-input.hidden name="gasto_id[{{ $gasto->id }}]" value="{{ $gasto->id }}" />
                        <tr>
                            <td class="right aligned collapsing">{{ periodo_fmt($gasto->periodo) }}</td>
                            <td class="left aligned">
                                <a
                                    href="{{ route('despesa.show', ['despesa_id' => $gasto->despesa_id]) }}">{{ $gasto->descricao }}</a>
                            </td>
                            <td class="left aligned collapsing">{{ $gasto->observacao }}</td>
                            <td class="right aligned collapsing">{{ money_fmt($gasto->valor) }}</td>
                            <td class="left aligned collapsing">{{ $gasto->mp }}</td>
                            <td class="left aligned collapsing">{{ $gasto->credor }}</td>
                            <td class="right aligned collapsing">{{ data_fmt($gasto->vencimento) }}</td>
                            <td class="left aligned collapsing">{{ $gasto->agrupador }}</td>
                            <td class="left aligned collapsing">{{ $gasto->localizador }}</td>

                        <tr>
                            <td class="left aligned" colspan="9">
                                <div class="fields">
                                    <x-input.data id="pagoem[{{ $gasto->id }}]" name="pagoem[{{ $gasto->id }}]"
                                        label="Pago em" value="{{ $dataPgto }}" required />

                                    <x-input.observacao id="observacao_pgto[{{ $gasto->id }}]"
                                        name="observacao_pgto[{{ $gasto->id }}]"
                                        value="{{ old('observacao_pgto') }}"
                                        placeholder="Observação opcional do pagamento" />
                                </div>
                            </td>
                        </tr>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="left aligned">Sem gastos para os filtros especificados.</td>
                        </tr>
                    @endforelse
                </tbody>

                <tfoot>
                    <tr>
                        <td class="left aligned" colspan="2">Total</td>
                        <td class="right aligned">{{ money_fmt($total) }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </x-form>



</x-app-layout>
