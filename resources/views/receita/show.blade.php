<x-app-layout>

    <x-slot name="title">
        Detalhes da receita
    </x-slot>

    <div class="ui container">

        <div class="ui fluid card">
            <div class="content">
                <div class="header">{{ $receita->descricao }}</div>
            </div>
            <div class="content">
                <a class="ui sub header" href="{{ route('periodo.go', $receita->periodo) }}">{{ periodo_fmt($receita->periodo) }}</a>
                <div class="meta">
                    <a href="{{ route('pessoa.show', $receita->devedor) }}">{{ $receita->devedor }}</a>
                </div>


                <div class="ui fluid cards">
                    <div class="card">
                        <div class="content">
                            <div class="description">
                                Previsto
                            </div>
                            <div class="right floated header">
                                {{ money_fmt($receita->valor) }}
                                <a href="{{ route('receita.previsao.adjust', $receita->id) }}" class="ui right floated mini icon button">
                                    <i class="equals icon"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="content">
                            <div class="description">
                                Recebido
                            </div>
                            <div class="right floated header">
                                {{ money_fmt($receita->totalRecebido()) }}
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="content">
                            <div class="description">
                                A receber
                            </div>
                            <div class="right floated header">
                                {{ money_fmt($receita->totalAReceber()) }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="extra content">
                @isset($receita->agrupador)
                    <a class="ui basic label" href="{{ route('agrupador.show', $receita->agrupador) }}">
                        <div class="detail">agrupador</div>
                        {{ $receita->agrupador }}
                    </a>
                @endisset


                @isset($receita->localizador)
                    <a class="ui basic label" href="{{ route('localizador.show', $receita->localizador) }}">
                        <div class="detail">localizador</div>
                        {{ $receita->localizador }}
                    </a>
                @endisset

                @isset($receita->localizador)
                    <div class="ui basic label">
                        <div class="detail">vencimento</div>
                        {{ data_fmt($receita->vencimento) }}
                    </div>
                @endisset

            </div>
        </div>

        <div class="ui borderless menu">
            <div class="item">
                <a class="ui primary button" href="{{ route('recebimento.create', ['receita_id' => $receita->id]) }}" accesskey="ctrl+r"><u>R</u>eceber</a>
            </div>
            <div class="right menu">
                <div class="item">
                    <a class="ui teal button" href="{{ route('receita.edit', ['receita_id' => $receita->id]) }}">Editar</a>
                </div>
                <div class="item">
                    <a class="ui red button" href="{{ route('receita.delete', ['receita_id' => $receita->id]) }}">Apagar</a>
                </div>
            </div>
        </div>



        <table class="ui celled striped table">
            <caption class="ui left aligned header">Recebimentos</caption>
            <thead>
                <tr>
                    <th class="left aligned collapsing">Data</th>
                    <th class="right aligned collapsing">Valor</th>
                    <th class="left aligned">Observação</th>
                    <th class="center aligned collapsing">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ( $receita->recebimentos as $recebimento)
                    <tr>
                        <td class="left aligned">{{ data_fmt($recebimento->data) }}</td>
                        <td class="right aligned">{{ money_fmt($recebimento->valor) }}</td>
                        <td class="left aligned">{{ $recebimento->observacao }}</td>
                        <td class="center aligned">
                            <div class="ui spaced buttons">
                                <a href="{{ route('recebimento.edit', ['receita_id' => $receita->id, 'recebimento_id' => $recebimento->id]) }}" class="ui teal icon button">
                                    <i class="edit icon"></i>
                                </a>
                                <a href="{{ route('recebimento.delete', ['receita_id' => $receita->id, 'recebimento_id' => $recebimento->id]) }}" class="ui red icon button">
                                    <i class="trash icon"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="left aligned">Sem recebimentos para mostrar.</td>
                    </tr>
                @endforelse
            </tbody>

            <tfoot>
                <tr>
                    <th class="left aligned">Total</th>
                    <th class="right aligned">{{ money_fmt($receita->totalRecebido()) }}</th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>

    </div>

</x-app-layout>
