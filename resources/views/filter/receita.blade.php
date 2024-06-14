<x-app-layout>
    <x-slot name="title">
        Pesquisa de receitas
    </x-slot>

    <div class="ui container">

        <x-form title="Pesquisa de receitas" action="{{ route('filter.receita') }}" method="POST" submitLabel="Pesquisar">

            <div class="fields">
                <x-input.periodo value="{{ $periodo1 }}" required autofocus id="periodo1" name="periodo1" label="Período inicial"/>
                <x-input.periodo value="{{ $periodo2 }}" required autofocus id="periodo2" name="periodo2" label="Período final"/>
            </div>


            <div class="fields">
                <x-input.valor value="{{ $valor1 }}" required min="0.01" id="valor1" name="valor1" label="Valor inicial"/>
                <x-input.valor value="{{ $valor2 }}" required min="0.01" id="valor2" name="valor2" label="Valor final"/>
            </div>

            <div class="fields">
                <x-input.pessoa id="devedor" name="devedor" label="Devedor" value="{{ $devedor }}" :pessoas="pessoas()" required />

                <x-input.agrupador value="{{ $agrupador }}" required />

                <x-input.localizador value="{{ $localizador }}" required />
            </div>

        </x-form>

    </div>

    <div class="ui container">

        <table class="ui celled striped green table">
            <caption class="ui left aligned header">Receitas filtradas</caption>
            <thead>
                <tr>
                    <th class="right aligned">Período</th>
                    <th class="left aligned">Receita</th>
                    <th class="right aligned">Previsto</th>
                    <th class="left aligned">Devedor</th>
                    <th class="right aligned">Vencimento</th>
                    <th class="left aligned">Agrupador</th>
                    <th class="left aligned">Localizador</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $totalPrevisto = 0.0;
                @endphp
                @forelse ($receitas as $receita)
                    @php
                        $totalPrevisto += $receita->valor;
                    @endphp
                    <tr>
                        <td class="right aligned collapsing">{{ periodo_fmt($receita->periodo) }}</td>
                        <td class="left aligned">
                            <a href="{{ route('receita.show', ['receita_id' => $receita->id]) }}">{{ $receita->descricao }}</a>
                        </td>
                        <td class="right aligned collapsing">{{ money_fmt($receita->valor) }}</td>
                        <td class="left aligned collapsing">{{ $receita->devedor }}</td>
                        <td class="right aligned collapsing">{{ data_fmt($receita->vencimento) }}</td>
                        <td class="left aligned collapsing">{{ $receita->agrupador }}</td>
                        <td class="left aligned collapsing">{{ $receita->localizador }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="left aligned">Sem receitas para os filtros especificados.</td>
                    </tr>
                @endforelse
            </tbody>

            <tfoot>
                <tr>
                    <td class="left aligned" colspan="2">Total</td>
                    <td class="right aligned">{{ money_fmt($totalPrevisto) }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

    </div>



</x-app-layout>
