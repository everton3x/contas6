<x-app-layout>
    <x-slot name="title">
        {{ $title }}
    </x-slot>

    <div class="ui container">

        <div class="ui dividing header"> {{ $title }}</div>

        <div class="ui middle aligned list">
            @forelse ( $items as $item)
                <div class="item">
                    <div class="content">
                        <a href="{{ route($route, [$key => $item->{$key}]) }}" class="header">{{ $item->{$key} }}</a>
                    </div>
                </div>
            @empty
                <div class="item">
                    <div class="ui info message">
                        <p>Nenhum registro encontrado.</p>
                    </div>
                </div>
            @endforelse
        </div>

    </div>

</x-app-layout>
