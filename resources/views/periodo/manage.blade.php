<x-app-layout>
    <x-slot name="title">
        Períodos
    </x-slot>

    <div class="ui container">

        <div class="ui two column centered grid">
            <div class="row">
                <div class="column">
                    @if (!is_null(first_opened()))
                        <div class="ui fluid card">
                            <div class="content">
                                <div class="header">Fechar período</div>
                                <div class="description">
                                    <p>Primeiro período aberto: {{ periodo_fmt(first_opened()) }}</p>
                                    <p>
                                        <a href="{{ route('periodo.close', ['periodo' => first_opened()]) }}"
                                            class="ui green button">Fechar</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="column">
                    @if (!is_null(last_closed()))
                        <div class="ui fluid card">
                            <div class="content">
                                <div class="header">Reabrir período</div>
                                <div class="description">
                                    <p>Último período fechado: {{ periodo_fmt(last_closed()) }}</p>
                                    <p>
                                        <a href="{{ route('periodo.open', ['periodo' => last_closed()]) }}"
                                            class="ui red button">Reabrir</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>


            <div class="row">
                <div class="column">
                        <div class="ui fluid card">
                            <div class="content">
                                <div class="header">Conciliar período</div>
                                <div class="description">
                                    <p>Conciliação entre os resultados do período e o resultado calculado.</p>
                                    <p>
                                        <a href="{{ route('periodo.reconcile') }}"
                                            class="ui primary button">Conciliar</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="column">
                    {{-- @if (!is_null(last_closed()))
                        <div class="ui fluid card">
                            <div class="content">
                                <div class="header">Reabrir período</div>
                                <div class="description">
                                    <p>Último período fechado: {{ periodo_fmt(last_closed()) }}</p>
                                    <p>
                                        <a href="{{ route('periodo.open', ['periodo' => last_closed()]) }}"
                                            class="ui red button">Reabrir</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif --}}
                </div>
            </div>

        </div>

    </div>

</x-app-layout>
