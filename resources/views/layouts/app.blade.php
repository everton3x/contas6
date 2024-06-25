<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ $title }} | {{ config('app.name') }}</title>

    @vite(['resources/js/app.js', 'resources/css/fomantic/semantic.min.css', 'resources/css/fomantic/semantic.min.js', 'resources/css/app.css'])

</head>

<body accesskey-context>

    <x-navbar>

        {{ $slot }}

    </x-navbar>

    <script type="module">
        import enterastab from '/enterastab.js';
        @stack('enterastab')

        import accesskey from '/accesskey.js';
        accesskey().init();
    </script>
</body>

</html>
