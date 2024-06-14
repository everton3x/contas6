<x-app-layout>
    <x-slot name="title">
        Pesquisa de despesas
    </x-slot>

    <div class="ui container">

        <x-form title="Pesquisa de despesas" action="{{ route('filter.despesa') }}" method="POST" submitLabel="Pesquisar">

            <div class="fields">
                <x-input.periodo value="{{ $periodo1 }}" required autofocus id="periodo1" name="periodo1" label="Período inicial"/>
                <x-input.periodo value="{{ $periodo2 }}" required autofocus id="periodo2" name="periodo2" label="Período final"/>
            </div>


            <div class="fields">
                <x-input.valor value="{{ $valor1 }}" required min="0.01" id="valor1" name="valor1" label="Valor inicial"/>
                <x-input.valor value="{{ $valor2 }}" required min="0.01" id="valor2" name="valor2" label="Valor final"/>
            </div>

        </x-form>

    </div>

    <div class="ui container">

        <table class="ui celled striped red table">
            <caption class="ui left aligned header">Despesas filtradas</caption>
            <thead>
                <tr>
                    <th class="right aligned">Período</th>
                    <th class="left aligned">Despesa</th>
                    <th class="right aligned">Previsto</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $totalPrevisto = 0.0;
                @endphp
                @forelse ($despesas as $despesa)
                    @php
                        $totalPrevisto += $despesa->valor;
                    @endphp
                    <tr>
                        <td class="right aligned collapsing">{{ periodo_fmt($despesa->periodo) }}</td>
                        <td class="left aligned collapsing">
                            <a href="{{ route('despesa.show', ['despesa_id' => $despesa->id]) }}">{{ $despesa->descricao }}</a>
                        </td>
                        <td class="right aligned collapsing">{{ money_fmt($despesa->valor) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="left aligned">Sem despesas para os filtros especificados.</td>
                    </tr>
                @endforelse
            </tbody>

            <tfoot>
                <tr>
                    <td class="left aligned" colspan="2">Total</td>
                    <td class="right aligned">{{ money_fmt($totalPrevisto) }}</td>
                </tr>
            </tfoot>
        </table>

    </div>



</x-app-layout>
