<x-app-layout>

    <x-slot name="title">
        Edição da despesa
    </x-slot>

    <div class="ui container">
        <x-form title="Editar despesa" action="{{ route('despesa.update') }}" method="PUT">

            <x-input.hidden name="id" value="{{ $despesa->id }}" />

            <x-input.periodo value="{{ old('periodo') ?? (session('periodo', $despesa->periodo)) }}" required autofocus />
            <x-input.descricao value="{{ old('descricao', $despesa->descricao) }}" required />
            <x-input.valor value="{{ old('valor', $despesa->valor) }}" required min="0.01" />

        </x-form>
    </div>


</x-app-layout>
