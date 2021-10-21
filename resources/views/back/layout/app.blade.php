<!DOCTYPE html>
<html lang="fr">

@include('back.include.head')

<body>
    <!-- Preloader -->
    <div class="preloader-it">
        <div class="la-anim-1"></div>
    </div>
    <!-- /Preloader -->
    <div class="wrapper theme-6-active pimary-color-pink">

        @include('back.include.nav')

        @include('back.include.sidebar')

        @yield('content')

    </div>
    <!-- /#wrapper -->
    @include('back.include.userProfil')

    @include('back.include.footer')
</body>

</html>