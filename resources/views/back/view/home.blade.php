@extends('back.layout.app')

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@section('content')
<!-- Main Content -->
<div class="page-wrapper" id="app">
    <div class="container-fluid pt-10">
        <!-- Title -->
        <div class="row heading-bg">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h5 class="txt-dark">Dashboard</h5>
            </div>
        </div>
        <!-- /Title -->
        <!-- Row -->
        <div class="row">
            @isset($market)
            @php $i = 1 @endphp
            @foreach($market as $key => $data)
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0 bg-gradient{{ $i++ }}">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-8 text-center pl-0 pr-0 data-wrap-left">
                                            <span class="txt-light block counter">
                                                <span id="currency_{{$key}}">
                                                    {!! floatval($data) !!}
                                                </span>
                                                €
                                            </span>
                                            <span class="weight-500 uppercase-font block txt-light">
                                                {{ $key }}
                                            </span>
                                        </div>
                                        <div class="col-xs-4 text-center  pl-0 pr-0 pt-25  data-wrap-right">
                                            <img class="iconCrypto"
                                                src={{ asset("assets/img/".strtolower($key).".png") }} />
                                            <div id="sparkline_1" class="sp-small-chart"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endisset
        </div>
        <!-- Row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">Soldes</h6>
                        </div>
                        <div class="balanceTotal" id="currentBalance">{{ $balance['EUR.TOTAL'] ?? 0 }} €</div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="table-wrap">
                                <div class="table-responsive">
                                    <table id="datable_1" class="table table-hover display  pb-30">
                                        <thead>
                                            <tr>
                                                <th>Actif</th>
                                                <th>Valeur €</th>
                                                <th>Montant</th>
                                                <th>Prix</th>
                                                <th>Chgt prix 24h</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @isset($balance)
                                            @foreach($balance as $key => $data )
                                            @if (str_contains($key, "."))
                                            @continue
                                            @endif
                                            <tr>
                                                <td>{{ $key }}</td>
                                                <td>{{  $data['devise'] }}€</td>
                                                <td>{{ $data['crypto'] }}</td>
                                                <td>{{ floatval($market[ucfirst($key)]) }}€</td>
                                                <td>8%</td>
                                            </tr>
                                            @endforeach
                                            @endisset
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Row -->

    </div>

    <!-- Footer -->
    <footer class="footer container-fluid pl-30 pr-30">
        <div class="row">
            <div class="col-sm-12">
                <p>{{ \Carbon\Carbon::now()->format("Y") }} &copy; Alek company</p>
            </div>
        </div>
    </footer>
    <!-- /Footer -->

</div>
<!-- /Main Content -->
@endsection

@section('script')
<script src="{{ asset('js/app.js') }}"></script>
<script>
    console.log("Listening ...");
    window.Echo.channel('get-currency-{{ Auth::user()->id }}').listen('loadDataKraken', function(e) {
        console.log(e.balance.original, e.balance.original['EUR.TOTAL']);
        var oldBalance = isNaN(parseInt($("#currentBalance").html())) ? (parseInt($("#currentBalance").html().split("&nbsp;")[1])) : (parseInt($("#currentBalance").html()))
        var newBalance = parseFloat(e.balance.original['EUR.TOTAL']);

        var newValueBitcoin = parseFloat(e.market.original.XXBTZEUR);
        var newValueEthereum = parseFloat(e.market.original.XETHZEUR);
        var newValueLitecoin = parseFloat(e.market.original.XLTCZEUR);
        var newValueRipple = parseFloat(e.market.original.XXRPZEUR);
        
        var oldValueBitcoin = isNaN(parseFloat($("#currency_Bitcoin").html())) ? (parseFloat($("#currency_Bitcoin").html().split("&nbsp;")[1])) : (parseFloat($("#currency_Bitcoin").html()));
        var oldValueEthereum = isNaN(parseFloat($("#currency_Ethereum").html())) ? (parseFloat($("#currency_Ethereum").html().split("&nbsp;")[1])) : (parseFloat($("#currency_Ethereum").html()));
        var oldValueLitecoin = isNaN(parseFloat($("#currency_Litecoin").html())) ? (parseFloat($("#currency_Litecoin").html().split("&nbsp;")[1])) : (parseFloat($("#currency_Litecoin").html()));
        var oldValueRipple = isNaN(parseFloat($("#currency_Ripple").html())) ? (parseFloat($("#currency_Ripple").html().split("&nbsp;")[1])) : (parseFloat($("#currency_Ripple").html()));
      
        console.log(oldValueBitcoin <= newValueBitcoin, oldValueBitcoin, newValueBitcoin);
        $("#currency_Bitcoin").html((oldValueBitcoin <= newValueBitcoin ? "<i class='fa fa-arrow-up text-success'></i>&nbsp;" : "<i class='fa fa-arrow-down text-danger'></i>&nbsp;") + parseFloat(newValueBitcoin).toFixed(1));
        $("#currency_Ethereum").html((oldValueEthereum <= newValueEthereum ? "<i class='fa fa-arrow-up text-success'></i>&nbsp;" : "<i class='fa fa-arrow-down text-danger'></i>&nbsp;") + parseFloat(newValueEthereum).toFixed(1));
        $("#currency_Litecoin").html((oldValueLitecoin <= newValueLitecoin ? "<i class='fa fa-arrow-up text-success'></i>&nbsp;" : "<i class='fa fa-arrow-down text-danger'></i>&nbsp;") + parseFloat(newValueLitecoin).toFixed(1));
        $("#currency_Ripple").html((oldValueRipple <= newValueRipple ? "<i class='fa fa-arrow-up text-success'></i>&nbsp;" : "<i class='fa fa-arrow-down text-danger'></i>&nbsp;") + parseFloat(newValueRipple).toFixed(3));
        $("#currentBalance").html((oldBalance <= newBalance ? "<i class='fa fa-arrow-up text-success'></i>&nbsp;" : "<i class='fa fa-arrow-down text-danger'></i>&nbsp;") + parseInt(newBalance) + "€");
    });

</script>
@endsection