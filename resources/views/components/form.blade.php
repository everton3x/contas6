@php
    switch (strtoupper($method)) {
        case 'POST':
        case 'PUT':
        case 'PATCH':
            $formMethod = 'POST';
            break;

        case 'GET':
        case 'DELETE':
            $formMethod = 'GET';
            break;

        default:
            # code...
            break;
    }
@endphp
<div class="ui dividing header">{{ $title }}</div>

<form action="{{ $action }}" method="{{ $formMethod }}" class="ui form" onsubmit="javascript:document.getElementById('btnSubmit').disabled = true;">
    @csrf
    @method($method)


    <div class="ui blue segment">
        {{ $slot }}
    </div>

    <div class="ui borderless menu">
        <div class="item">
            <button id="btnSubmit" type="submit" class="ui primary button">{{ $attributes->get('submitLabel') ?? 'Salvar'}}</button>
        </div>
        @isset($extraButtons)
            <div class="item">
                {{ $extraButtons }}
            </div>
        @endisset
    </div>
</form>

@push('enterastab')
    enterastab(document.querySelectorAll(".ui.form input, .ui.form textarea, .ui.form select, .ui.form .button")).init();
@endpush
