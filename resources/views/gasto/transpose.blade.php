<x-app-layout>

    <x-slot name="title">
        Transposição do gasto
    </x-slot>

    <div class="ui container">

        <div class="ui fluid card">
            <div class="content">
                <a class="header"
                    href="{{ route('despesa.show', ['despesa_id' => $despesa->id]) }}">{{ $despesa->descricao }}</a>
            </div>
            <div class="content">
                <a class="ui sub header"
                    href="{{ route('periodo.go', $despesa->periodo) }}">{{ periodo_fmt($despesa->periodo) }}</a>
            </div>
        </div>

    </div>

    <br>
    <br>

    <div class="ui container">
        <x-form title="Selecione o período"
            action="{{ route('gasto.transpose', ['despesa_id' => $despesa->id, 'gasto_id' => $gasto->id]) }}"
            method="GET">
            <x-input.periodo value="{{ $periodo }}" required />
        </x-form>
    </div>

    <div class="ui container">
        <x-form title="Selecione a despesa para receber o gasto" action="{{ route('gasto.transpose.store') }}"
            method="PUT">

            <x-input.hidden name="gasto_id" value="{{ $gasto->id }}" />

            <table class="ui celled striped table">
                <thead>
                    <tr>
                        <th class="center aligned">#</th>
                        <th>Descricão</th>
                        <th class="right aligned">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($target as $item)
                        <tr>
                            <td class="center aligned">
                                <div class="field">
                                    <div class="ui radio checkbox">
                                        <input type="radio" name="despesa_id" id="despesa_id"
                                            value="{{ $item->id }}">
                                    </div>
                                </div>
                            </td>
                            <td>{{ $item->descricao }}</td>
                            <td class="right aligned">{{ money_fmt($item->valor) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">Nenhuma despesa para este período.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <x-slot name="extraButtons">
                <a href="{{ route('despesa.show', ['despesa_id' => $despesa->id]) }}" class="ui button">Voltar</a>
            </x-slot>

        </x-form>
    </div>

    <script type="module">
        $('.ui.radio.checkbox')
            .checkbox();
    </script>

</x-app-layout>
