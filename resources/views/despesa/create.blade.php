<x-app-layout>

    <x-slot name="title">
        Criar despesa
    </x-slot>

    <div class="ui container">
        <x-form title="Nova despesa" action="{{ route('despesa.store') }}" method="POST">

            <x-input.periodo value="{{ old('periodo') ?? (session('periodo') ?? date('Y-m')) }}" required autofocus />
            <x-input.descricao value="{{ old('descricao') }}" required />
            <x-input.valor value="{{ old('valor') }}" required min="0.01" />
        </x-form>
    </div>


</x-app-layout>
