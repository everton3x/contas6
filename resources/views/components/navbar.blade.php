{{-- Navbar toggler --}}
<div class="ui top fixed menu">
    <a class="item toggler" accesskey="ctrl+m">
        <i class="sidebar icon"></i>
        <span class="hidden-on-mobile"><u>M</u>enu</span>
        {{-- Menu --}}
    </a>
    <a class="header item hidden-on-mobile" href="{{ route('welcome') }}">{{ config('app.name') }}</a>
    <a class="item hidden-on-mobile" href="{{ route('welcome') }}" accesskey="ctrl+Home">
        {{ periodo_fmt(session('periodo') ?? date('Y-m')) }}
        <div class="left bottom floating ui label">home</div>
    </a>
    <div class="right item">
        <form class="ui form" method="POST" action="{{ route('periodo.select') }}">
            @csrf
            <div class="inline fields">
                <div class="item">
                    <a class="ui icon button field" href="{{ route('periodo.previous') }}" accesskey="f9">
                        <i class="left chevron icon"></i>
                        <span class="hidden-on-mobile">F9</span>
                    </a>
                </div>
                <div class="item">
                    <div class="ui input">
                        <input type="month" name="periodo" id="periodo" value="{{ old('periodo') ?? session('periodo') ?? date('Y-m') }}" required onchange="this.form.submit()" accesskey="f10" onclick="this.select()">
                    </div>
                    <div class="ui left pointing label">F10</div>
                </div>
                <div class="item">
                    <a class="ui icon button field" href="{{ route('periodo.next') }}" accesskey="f11">
                        <span class="hidden-on-mobile">F11</span>
                        <i class="right chevron icon"></i>
                    </a>
                </div>
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

    <a class="item" href="{{ route('welcome') }}" accesskey="alt+0">
        / Início <span class="hidden-on-mobile ui black label">alt+0</span>
    </a>
    <div class="item">
        <div class="header">/ Receitas</div>
        <div class="menu">
            <a class="item" href="{{ route('receita.create') }}" accesskey="alt+1">&nbsp;&nbsp;&nbsp;&nbsp;Nova<span class="hidden-on-mobile ui black label">alt+1</span></a>
            <a class="item" href="{{ route('receita.repeat') }}" accesskey="alt+2">&nbsp;&nbsp;&nbsp;&nbsp;Repetir<span class="hidden-on-mobile ui black label">alt+2</span></a>
            <a class="item" href="{{ route('receita.parcel') }}" accesskey="alt+3">&nbsp;&nbsp;&nbsp;&nbsp;Parcelar<span class="hidden-on-mobile ui black label">alt+3</span></a>
        </div>
    </div>
    <div class="item">
        <div class="header">/ Despesas</div>
        <div class="menu">
            <a class="item" href="{{ route('despesa.create') }}" accesskey="alt+4">&nbsp;&nbsp;&nbsp;&nbsp;Nova <span class="hidden-on-mobile ui black label">alt+4</span></a>
            <a class="item" href="{{ route('despesa.repeat') }}" accesskey="alt+5">&nbsp;&nbsp;&nbsp;&nbsp;Repetir <span class="hidden-on-mobile ui black label">alt+5</span></a>
            <a class="item" href="{{ route('despesa.parcel') }}" accesskey="alt+6">&nbsp;&nbsp;&nbsp;&nbsp;Parcelar <span class="hidden-on-mobile ui black label">alt+6</span></a>
        </div>
    </div>
    <div class="item">
        <div class="header">/ Pesquisas</div>
        <div class="menu">
            <a class="item" href="{{ route('filter.receita') }}" accesskey="alt+7">&nbsp;&nbsp;&nbsp;&nbsp;Receita <span class="hidden-on-mobile ui black label">alt+7</span></a>
            <a class="item" href="{{ route('filter.despesa') }}" accesskey="alt+8">&nbsp;&nbsp;&nbsp;&nbsp;Despesa <span class="hidden-on-mobile ui black label">alt+8</span></a>
            <a class="item" href="{{ route('filter.gasto') }}" accesskey="alt+9">&nbsp;&nbsp;&nbsp;&nbsp;Gasto <span class="hidden-on-mobile ui black label">alt+9</span></a>
        </div>
    </div>
    <a class="item" href="{{ route('periodo.manage') }}" accesskey="alt+p">
        / Períodos <span class="hidden-on-mobile ui black label">alt+p</span>
    </a>
    <a class="item" href="{{ route('mp.list') }}" accesskey="alt+m">
        / Meios de pagamento <span class="hidden-on-mobile ui black label">alt+m</span>
    </a>
    <a class="item" href="{{ route('pessoa.list') }}" accesskey="alt+o">
        / Pessoas <span class="hidden-on-mobile ui black label">alt+o</span>
    </a>
    <a class="item" href="{{ route('agrupador.list') }}" accesskey="alt+a">
        / Agrupadores <span class="hidden-on-mobile ui black label">alt+a</span>
    </a>
    <a class="item" href="{{ route('localizador.list') }}" accesskey="alt+l">
        / Localizadores <span class="hidden-on-mobile ui black label">alt+l</span>
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
