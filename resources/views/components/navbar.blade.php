{{-- Navbar toggler --}}
<div class="ui top fixed menu">
    <a class="item toggler">
        <i class="sidebar icon"></i>
        {{-- Menu --}}
    </a>
    <a class="header item hidden-on-mobile" href="{{ route('welcome') }}">{{ config('app.name') }} Hook</a>
    <a class="item hidden-on-mobile" href="{{ route('welcome') }}">{{ periodo_fmt(session('periodo') ?? date('Y-m')) }}</a>
    <div class="right item">
        <form class="ui form" method="POST" action="{{ route('periodo.select') }}">
            @csrf
            <div class="inline fields">
                <a class="ui icon button" href="{{ route('periodo.previous') }}">
                    <i class="left chevron icon"></i>
                </a>
                <div class="item">
                    <div class="ui input">
                        <input type="month" name="periodo" id="periodo" value="{{ old('periodo') ?? session('periodo') ?? date('Y-m') }}" required onchange="this.form.submit()">
                    </div>
                </div>
                <a class="ui icon button" href="{{ route('periodo.next') }}">
                    <i class="right chevron icon"></i>
                </a>
            </div>
        </form>
    </div>
</div>{{-- Navbar toggler --}}

{{-- Navbar --}}
<div class="ui inverted vertical sidebar menu">
    <br class="hidden-on-desktop">
    <br class="hidden-on-desktop">
    <br class="hidden-on-desktop">
    <br class="hidden-on-desktop">
    <br class="hidden-on-desktop">

    <a class="item" href="{{ route('welcome') }}">
        / Início
    </a>
    <div class="item">
        <div class="header">/ Receitas</div>
        <div class="menu">
            <a class="item" href="{{ route('receita.create') }}">&nbsp;&nbsp;&nbsp;&nbsp;Nova</a>
            <a class="item" href="{{ route('receita.repeat') }}">&nbsp;&nbsp;&nbsp;&nbsp;Repetir</a>
            <a class="item" href="{{ route('receita.parcel') }}">&nbsp;&nbsp;&nbsp;&nbsp;Parcelar</a>
        </div>
    </div>
    <div class="item">
        <div class="header">/ Despesas</div>
        <div class="menu">
            <a class="item" href="{{ route('despesa.create') }}">&nbsp;&nbsp;&nbsp;&nbsp;Nova</a>
            <a class="item" href="{{ route('despesa.repeat') }}">&nbsp;&nbsp;&nbsp;&nbsp;Repetir</a>
            <a class="item" href="{{ route('despesa.parcel') }}">&nbsp;&nbsp;&nbsp;&nbsp;Parcelar</a>
        </div>
    </div>
    <div class="item">
        <div class="header">/ Pesquisas</div>
        <div class="menu">
            <a class="item" href="{{ route('filter.receita') }}">&nbsp;&nbsp;&nbsp;&nbsp;Receita</a>
            <a class="item" href="{{ route('filter.despesa') }}">&nbsp;&nbsp;&nbsp;&nbsp;Despesa</a>
            <a class="item" href="{{ route('filter.gasto') }}">&nbsp;&nbsp;&nbsp;&nbsp;Gasto</a>
        </div>
    </div>
    <a class="item" href="{{ route('periodo.manage') }}">
        / Períodos
    </a>
    <a class="item" href="{{ route('mp.list') }}">
        / Meios de pagamento
    </a>
    <a class="item" href="{{ route('pessoa.list') }}">
        / Pessoas
    </a>
    <a class="item" href="{{ route('agrupador.list') }}">
        / Agrupadores
    </a>
    <a class="item" href="{{ route('localizador.list') }}">
        / Localizadores
    </a>
    <div class="item">
        <div class="header">/ Usuário</div>
        <div class="menu">
            <a class="item" href="{{ route('logout') }}">&nbsp;&nbsp;&nbsp;&nbsp;Logout</a>
        </div>
    </div>

</div>
<div class="pusher">
    <br>
    <br>
    <br>
    <br>



    <div class="ui basic segment">

        @if ($errors->any())
        <div class="ui error message container">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif

        @if (session('success'))
        <div class="ui positive message container">{{ session('success') }}</div>
        @endif

        @if (session('warning'))
        <div class="ui warning message container">{{ session('warning') }}</div>
        @endif


        {{ $slot }}
    </div>
</div>{{-- Navbar --}}

<script type="module">
    $('.ui.sidebar')
        .sidebar('setting', 'transition', 'scale down')
        .sidebar('attach events', '.toggler')
    ;
</script>
