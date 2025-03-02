<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('core/dist/img/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Edgy</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('core/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{Auth()->user()->name}}</a>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
       with font-awesome or any other icon font library -->

                <li class="nav-item">
                    <a href="{{ url('/dashboard') }}" class="nav-link active">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/trades') }}" class="nav-link">
                        <i class="fas fa-chart-line nav-icon"></i>
                        <p>Trades</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/accounts') }}" class="nav-link">
                        <i class="fas fa-wallet nav-icon"></i>
                        <p>Accounts</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/weekly-forecasts') }}" class="nav-link">
                        <i class="fas fa-calendar-alt nav-icon"></i>
                        <p>Weekly Forecasts</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/lessons') }}" class="nav-link">
                        <i class="fas fa-book nav-icon"></i>
                        <p>Lessons</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/pairs') }}" class="nav-link">
                                <i class="fas fa-exchange-alt nav-icon"></i>
                                <p>Pairs</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/kill-zones') }}" class="nav-link">
                                <i class="fas fa-clock nav-icon"></i>
                                <p>Kill Zones</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/entry-checklists') }}" class="nav-link">
                                <i class="fas fa-check-square nav-icon"></i>
                                <p>Entry Checklists</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/trading-plans') }}" class="nav-link">
                                <i class="fas fa-tasks nav-icon"></i>
                                <p>Trading Plans</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/prop-firms') }}" class="nav-link">
                                <i class="fas fa-building nav-icon"></i>
                                <p>Prop Firms</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('/users') }}" class="nav-link">
                                <i class="fas fa-users nav-icon"></i>
                                <p>Users</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('profile.edit') }}" class="nav-link">
                        <i class="fas fa-user nav-icon"></i>
                        <p>Profile</p>
                    </a>
                </li>
                <li class="nav-item" id="logout_button">
                    <a href="javascript:void(0)" class="nav-link bg-danger">
                        <i class="fas fa-sign-out-alt nav-icon"></i>
                        <p>Logout</p>
                    </a>
                </li>
                <form id="logout_form" method="POST" action="{{ route('logout') }}">
                    @csrf
                </form>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>


@push('custom-scripts')
    <script>
        $('body').on('click', '#logout_button', function() {
            var button = $(this);
            button.prop('disabled', true); // Disable the button
            $('#logout_form').submit(); // Submit the form
        });
    </script>
@endpush
