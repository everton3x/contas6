<x-app-layout>
    <x-slot name="title">
        Pesquisa de gastos
    </x-slot>

    <div class="ui container">

        {{-- {{ print_r($filter) }} --}}

        <x-form title="Pesquisa de gastos" action="{{ route('filter.gasto') }}" method="POST" submitLabel="Pesquisar">

            <div class="fields">
                <x-input.periodo value="{{ $periodo1 }}" required id="periodo1" name="periodo1"
                    label="Período inicial" />
                <x-input.periodo value="{{ $periodo2 }}" required id="periodo2" name="periodo2"
                    label="Período final" />
            </div>


            <div class="fields">
                <x-input.valor value="{{ $valor1 }}" required min="0.01" id="valor1" name="valor1"
                    label="Valor inicial" />
                <x-input.valor value="{{ $valor2 }}" required min="0.01" id="valor2" name="valor2"
                    label="Valor final" />
            </div>

            <div class="fields">

                <x-input.meio-pagamento value="{{ $mp }}" :mps="mps()" required />

                <x-input.pessoa id="credor" name="credor" label="Credor" value="{{ $credor }}"
                    :pessoas="pessoas()" required />

                <x-input.agrupador value="{{ $agrupador }}" required />

                <x-input.localizador value="{{ $localizador }}" required />
            </div>

            <x-input.observacao value="{{ $observacao }}" required />

            <div class="fields">
                <x-input.data id="pagoem1" name="pagoem1" label="Pago em Inicial" value="{{ $pagoem1 }}" />
                <x-input.data id="pagoem2" name="pagoem2" label="Pago em Final" value="{{ $pagoem2 }}" />
                <x-input.observacao id="observacao_pgto" name="observacao_pgto" value="{{ $observacao_pgto }}" required
                    label="Observação do pagamento" />
            </div>

        </x-form>

    </div>

    <br>
    <br>
    <br>

    {{-- <div class="ui container"> --}}

    <div class="ui basic menu">
        <div class="item">
            <button type="submit" class="ui green button" form="pagar">Pagar</button>
        </div>
    </div>

    <table class="ui celled striped orange table">
        <caption class="ui left aligned header">Gastos filtrados</caption>
        <thead>
            <tr>
                <th class="center aligned">
                    <input type="checkbox" id="checkall" />
                </th>
                <th class="right aligned">Período</th>
                <th class="left aligned">Despesa</th>
                <th class="left aligned">Observação</th>
                <th class="right aligned">Valor</th>
                <th class="left aligned">Meio Pgto.</th>
                <th class="left aligned">Credor</th>
                <th class="right aligned">Vencimento</th>
                <th class="left aligned">Agrupador</th>
                <th class="left aligned">Localizador</th>
                <th class="right aligned">Pago em</th>
                <th class="left aligned">Obs. Pgto.</th>
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
                <tr>
                    <td class="center aligned">
                        <input type="checkbox" name="gastos[{{ $gasto->id }}]" value="{{ $gasto->id }}"
                            class="checkable" form="pagar" data-value="{{ $gasto->valor }}" />
                    </td>
                    <td class="right aligned">{{ periodo_fmt($gasto->periodo) }}</td>
                    <td class="left aligned">
                        <a
                            href="{{ route('despesa.show', ['despesa_id' => $gasto->despesa_id]) }}">{{ $gasto->descricao }}</a>
                    </td>
                    <td class="left aligned">{{ $gasto->observacao }}</td>
                    <td class="right aligned">{{ money_fmt($gasto->valor) }}</td>
                    <td class="left aligned">{{ $gasto->mp }}</td>
                    <td class="left aligned">{{ $gasto->credor }}</td>
                    <td class="right aligned">{{ data_fmt($gasto->vencimento) }}</td>
                    <td class="left aligned">{{ $gasto->agrupador }}</td>
                    <td class="left aligned">{{ $gasto->localizador }}</td>
                    <td class="right aligned">{{ data_fmt($gasto->pagoem) }}</td>
                    <td class="left aligned">{{ $gasto->observacao_pgto }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="left aligned">Sem gastos para os filtros especificados.</td>
                </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr>
                <td class="left aligned" colspan="3">Total</td>
                <td class="right aligned" id="total" data-value="{{ $total }}">{{ money_fmt($total) }}</td>
                <td class="right aligned" id="selecionado" data-value="0.0">0,00</td>
                <td class="right aligned" id="diferenca">{{ money_fmt($total) }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    {{-- </div> --}}

    <div class="ui basic menu">
        <div class="item">
            <button type="submit" class="ui green button" form="pagar">Pagar</button>
        </div>
    </div>

    <form action="{{ route('filter.gasto.payment') }}" method="POST" id="pagar" style="display: hidden">
        @csrf
    </form>

    <script type="module">
        function money(number) {
            return number.toLocaleString('pt-BR', {
                style: 'decimal',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        function updateTotal(event) {
            let el = event.target;
            let totalSelecionado = parseFloat($('#selecionado').data('value'));
            let elValue = parseFloat(el.dataset.value);
            if (el.checked) {
                totalSelecionado += elValue;
            } else {
                totalSelecionado -= elValue;
            }

            $('#selecionado').data('value', totalSelecionado);
            $('#selecionado').text(money(totalSelecionado));

            let total = parseFloat($('#total').data('value'));
            let diferenca = total - totalSelecionado;
            $('#diferenca').text(money(diferenca));
        }

        $('.checkable').change(updateTotal);

        $('#checkall').change(function() {
            if (this.checked) {
                $('.checkable').prop('checked', true);
            } else {
                $('.checkable').prop('checked', false);
            }
        });
    </script>

</x-app-layout>
