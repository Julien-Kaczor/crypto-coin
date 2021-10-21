<!-- Left Sidebar Menu -->
<div class="fixed-sidebar-left">
    <ul class="nav navbar-nav side-nav nicescroll-bar">

        <!-- User Profile -->
        <li>
            <div class="user-profile text-center">
                <img src="../../../assets/img/user1.png" alt="user_auth" class="user-auth-img img-circle" />
                <div class="dropdown mt-5">
                    <a href="#" class="dropdown-toggle pr-0 bg-transparent" data-toggle="dropdown">
                        {{ Auth::user()->name }} </a>

                </div>
            </div>
        </li>
        <!-- /User Profile -->
        <li class="navigation-header">
            <span>Accueil</span>
            <i class="zmdi zmdi-more"></i>
        </li>
        <li>
            <a href="{{ route('home') }}" data-toggle="collapse" data-target="#ui_dr">
                <div class="pull-left">
                    <i class="icon-screen-desktop mr-30"></i>

                    <span class="right-nav-text">Dashboard</span></div>
                <div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="ui_dr" class="collapse collapse-level-1 two-col-list">
                <li>
                    <a href="#">
                        Cours
                        <i class="icon-chart"></i>
                    </a>
                </li>
                <li>
                    <a href="#">
                        Achat
                        <i class="ti-shopping-cart"></i>
                    </a>
                </li>
                <li>
                    <a href=" #">
                        Vente
                        <i class="icon-earphones-alt"></i>
                    </a>
                </li>
                <li>
                    <a href="#">
                        Historique
                        <i class="icon-note"></i>
                    </a>
                </li>

            </ul>
        </li>
    </ul>
</div>
<!-- /Left Sidebar Menu -->