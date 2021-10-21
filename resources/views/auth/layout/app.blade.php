<!DOCTYPE html>
<html lang="en">


@include('auth.include.head')

<body>
    <!--Preloader-->
    <div class="preloader-it">
        <div class="la-anim-1"></div>
    </div>
    <!--/Preloader-->

    @yield('content')
    <!-- /#wrapper -->

    <!-- JavaScript -->

    <!-- jQuery -->

    @include('auth.include.footer')

    @foreach ($errors->all() as $error)
    <script>
        $(document).ready(function() {
		    $.toast({
                heading: 'Erreur !',
                text: '{!! $error !!}',
                position: 'top-right',
                loaderBg:'#fec107',
                icon: 'error',
                hideAfter: 5000
            });
        });
    </script>
    @endforeach

</body>

</html>