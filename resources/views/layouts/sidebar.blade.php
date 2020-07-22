<aside class="main-sidebar" id="sidebar-wrapper">
    {{Auth::user()->role}}
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                @if (Auth::user()->photo == NULL)
                <img src="{{asset('storage/default.png')}}" alt="Image" class="user-image">
                @else
                <img src="{{asset('storage/'.Auth::user()->name.'/'.Auth::user()->photo.'/')}}" alt="Image" class="user-image">
                @endif

            </div>
            <div class="pull-left info">
                @if (Auth::guest())
                <p>Annynomous</p>
                @else
                <p>{{ Auth::user()->name}}</p>
                @endif
                <!-- Status -->

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>

            </div>
            <hr>
        </div>
        <hr>
        <div class="user-panel">
            <!-- Status -->
            <a href="/"><i class="fa fa-circle text-info"></i> Home</a>
        </div>
        <hr>
        @if(Auth::user()->role == "manager")
        <div class="user-panel">
            <a href="{{ route('manager.community.homepage')}}"><i class="fa fa-circle text-info"></i> Community</a>
        </div>
        @else
        <div class="user-panel">
            <a href="{{ route('community.homepage')}}"><i class="fa fa-circle text-info"></i> Community</a>
        </div>
        @endif
        <hr>
        @if(Auth::user()->email_verified_at == NULL)


        @else
  
        @if (Auth::user()->role == "admin")
        <div class="user-panel">

            <!-- Status -->
            <a href="{{ route('admin.dashboard', ['id'=>Auth::user()->id])}}"><i class="fa fa-circle text-info"></i> DashBoard</a>


        </div>
        <hr>
        <div class="user-panel">

            <!-- Status -->
            <a href="{{ route('admin.export.user')}}"><i class="fa fa-circle text-info"></i> Export Users list</a>

        </div>
        <hr>
        <div class="user-panel">

            <!-- Status -->
            <a href="{{ route('admin.export.thread')}}"><i class="fa fa-circle text-info"></i> Export threads List</a>

        </div>
        @else

        @endif
        <!-- Sidebar Menu -->
        <hr>
        <ul class="sidebar-menu" data-widget="tree">
            @include('layouts.menu')
        </ul>
        <!-- /.sidebar-menu -->
        @endif
    </section>
    <!-- /.sidebar -->
</aside>