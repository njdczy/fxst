<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="/{{ trim(config('menber.prefix'), '/') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">{!! config('menber.logo-mini', config('menber.name')) !!}</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>{!! config('menber.title', config('menber.title')) !!}</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <a style="text-align: center" class="logo">
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg" style="font-size: 18px">{!! config('menber.logo', config('menber.name')) !!}</span>
        </a>

        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                {!! Menber::getNavbar()->render() !!}

                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="{{ Menber::user()->avatar }}" class="user-image" alt="User Image">
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{ Menber::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="{{ Menber::user()->avatar }}" class="img-circle" alt="User Image">

                            <p>
                                {{ Menber::user()->name }}
                                <small>Member since admin {{ Menber::user()->created_at }}</small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ Menber::url('auth/setting') }}" class="btn btn-default btn-flat">{{ trans('menber::lang.setting') }}</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ Menber::url('logout') }}" class="btn btn-default btn-flat">{{ trans('menber::lang.logout') }}</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                {{--<li>--}}
                    {{--<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>--}}
                {{--</li>--}}
            </ul>
        </div>
    </nav>
</header>