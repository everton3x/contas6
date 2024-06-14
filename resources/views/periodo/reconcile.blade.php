<x-app-layout>
    <x-slot name="title">
        Conciliação
    </x-slot>

    <div class="ui container">

        <x-form title="Conciliação" action="{{ route('periodo.reconcile') }}" method="GET" submitLabel="Conciliar">
            <x-input.periodo value="{{ $periodo }}" required autofocus />
            <x-input.valor value="{{ $disponivel ?? 0 }}" label="Disponível" name="disponivel" id="disponivel" />
            <x-input.valor value="{{ $aReceber }}" label="(+) A Receber" name="areceber" id="areceber" readonly />
            <x-input.valor value="{{ $aGastar }}" label="(-) A Gastar" name="agastar" id="agastar" readonly />
            <x-input.valor value="{{ $aPagar }}" label="(-) A Pagar" name="apagar" id="apagar" readonly />
            <x-input.valor value="{{ $resultadoCalculado }}" label="(=) Resultado Calculado" name="calculado"
                id="calculado" readonly />
            <x-input.valor value="{{ $resultado }}" label="(+/-) Resultado" name="resultado" id="resultado"
                readonly />
            <x-input.valor value="{{ $diferenca }}" label="(=) Diferença" name="diferenca" id="diferenca" readonly />

            @if ($diferenca != 0.0)
                <x-slot name="extraButtons">
                    <button type="submit" class="ui red button" form="adjust">Ajustar</button>
                </x-slot>
                @endif
            </x-form>
            <form action="{{ route('periodo.reconcile.adjust') }}" method="POST" id="adjust">
                @csrf
                <x-input.hidden value="{{ $periodo }}" name="periodo" />
                <x-input.hidden value="{{ $diferenca }}" name="diferenca" />
            </form>
    </div>

</x-app-layout>
