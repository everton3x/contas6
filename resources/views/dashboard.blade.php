<x-app-layout>
    <x-slot name="title">
        Dashboard
    </x-slot>

    @include('dashboard.receitas', ['receitas' => $receitas])

    <div class="ui divider"></div>

    @include('dashboard.despesas', ['despesas' => $despesas])

    <div class="ui divider"></div>

    @include('dashboard.resultados')
</x-app-layout>
