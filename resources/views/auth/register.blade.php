@extends('auth.layout.app')

@section('content')

<div class="wrapper pa-0">
    <header class="sp-header">
        <div class="sp-logo-wrap pull-left">
            <a href="index.html">
                <img class="brand-img mr-10" src="{{ asset('assets/img/logo.png') }}" alt="brand" />
                <span class="brand-text">Alek</span>
            </a>
        </div>
        <div class="form-group mb-0 pull-right">
            <span class="inline-block pr-10">Deja un compte ?</span>
            <a class="inline-block btn btn-primary  btn-rounded" href="{{  route('login') }}">Connexion</a>
        </div>
        <div class="clearfix"></div>
    </header>

    <!-- Main Content -->
    <div class="page-wrapper pa-0 ma-0 auth-page">
        <div class="container-fluid">
            <!-- Row -->
            <div class="table-struct full-width full-height">
                <div class="table-cell vertical-align-middle auth-form-wrap">
                    <div class="auth-form  ml-auto mr-auto no-float card-view pt-30 pb-30">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="mb-30">

                                    <h3 class="text-center txt-dark mb-10">Inscription</h3>
                                    <h6 class="text-center nonecase-font txt-grey">Merci d'indiquer vos informations
                                        ci-dessous</h6>
                                </div>
                                <div class="form-wrap">
                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf

                                        <div class="form-group">
                                            <label class="control-label mb-10" for="inputEmail">
                                                Username
                                            </label>
                                            <input id="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ old('name') }}" required autocomplete="name"
                                                placeholder="alek" autofocus>


                                        </div>
                                        <div class="form-group">
                                            <label class="control-label mb-10" for="inputEmail">
                                                Email
                                            </label>
                                            <input type="email" id="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" required autocomplete="email" autofocus
                                                placeholder="alek@gmail.com">
                                        </div>
                                        <div class="form-group">
                                            <label class="pull-left control-label mb-10" for="password">
                                                Mot de passe
                                            </label>
                                            <div class="clearfix"></div>
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" placeholder="********" required
                                                autocomplete="current-password">


                                        </div>

                                        <div class="form-group">
                                            <label class="pull-left control-label mb-10" for="password">
                                                Confirmer le mot de passe
                                            </label>
                                            <input id="password-confirm" type="password" class="form-control"
                                                name="password_confirmation" required autocomplete="new-password"
                                                placeholder="********" class="invalid-feedback" role="alert">

                                            <div class="clearfix"></div>
                                        </div>


                                        <div class="form-group text-center mt-10">
                                            <button type="submit" class="btn btn-primary  btn-rounded">
                                                S'inscrire !
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Row -->
        </div>

    </div>
    <!-- /Main Content -->

</div>

@endsection