<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?= ucfirst(basename($_SERVER['PHP_SELF'], '.php')); ?> ! Harron The Intern</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/skins/_all-skins.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/_all.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

    <!-- Datatable  -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.css" />
    @yield('css')
</head>

<body class="skin-blue sidebar-mini">

    @if (!Auth::guest())
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="/" class="logo">
                <b>Harron</b>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                    @if(Auth::user()->email_verified_at == NULL)

                            @else
                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell-o" style="color: black;"></i>
                                <span class=" hidden-xs" style="color: red;">{{$notifications->count() ?? '0'}}</span>
                            </a>
                            
                                <ul class="dropdown-menu">

                                    @foreach($notifications->take(3) as $notification)

                                    <li class="user-footer">
                                        <p>{{$notification->notifiable_type}}</p>
                                        <p>{{json_decode($notification->data)->data}}</p>
                                        <a href="{{ route('notification.read', ['id'=> $notification->id])}}">
                                            <p>&times;</p>
                                        </a>
                                    </li>
                                    <br>
                                    @endforeach
                                    <li>
                                        <a href="{{ route('notifications.all')}}">Show All Unread Messages</a>
                                    </li>
                                </ul>
                            
                        </li>
                        @endif
                    </ul>
                </div>

                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">


                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->

                                @if (Auth::user()->photo == NULL)
                                <img src="{{asset('storage/default.png')}}" alt="Image" class="user-image">
                                @else
                                <img src="{{asset('storage/'.Auth::user()->name.'/'.Auth::user()->photo.'/')}}" alt="Image" class="user-image">
                                @endif
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class=" hidden-xs">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <!-- Menu Footer-->

                                @if(Auth::user()->email_verified_at == NULL)
                                <div class="pull-right">
                                    <a href="{{ url('/logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Sign out
                                    </a>
                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>

                                @else
                                <li class="user-footer">

                                    <a href="{{ route('profile.index', ['name' => Auth::user()->name?? '','id'=> Auth::user()->id])}}" class="btn btn-default btn-flat">Profile</a>

                                </li>
                               
                                <li class="user-footer">
                                    @if($profile->user_id?? '' == Auth::user()->id)
                                    <a href="{{ route('account.profile', ['id'=> Auth::user()->id])}}" class="btn btn-default btn-flat">Personal Information</a>
                                    @else

                                    @endif
                                </li>
                               
                                <li class="user-footer">

                                    <a href="{{ url('/logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Sign out
                                    </a>
                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>

                                </li>
                                @endif



                            </ul>
                        </li>
                    </ul>
                </div>

            </nav>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
        @include('layouts.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if(Auth::user()->email_verified_at == NULL)
            <div class="align-middle">
                <a href="/email/verify" style="background-color: red; font-size: 35px; color: white;">
                    Click here to verify your account before doing anything !!!
                </a>
            </div>
            @else

            @endif
            @yield('content')
        </div>

        <!-- Main Footer -->
        <footer class="main-footer" style="max-height: 100px;text-align: center">
            <strong>Harron ! The Intern </strong>
        </footer>

    </div>
    @else
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="/" class="logo">
                <b>Harron</b>
            </a>
            <nav class="navbar navbar-static-top" role="navigation">
                
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ url('/') }}">Home</a></li>

                        <!-- Right Side Of Navbar -->

                        <!-- Authentication Links -->
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    </ul>
                </div>

            </nav>

        </header>

        <!-- Left side column. contains the logo and sidebar -->
        @include('layouts.sidebar')

        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>


    @endif

    <!-- jQuery 3.1.1 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/js/adminlte.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>

    <!-- Datatable  -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>

    <!--BootBox -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>


    @stack('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            //Preview Image-----------------------------------------------------------------------//
            function PreviewImage(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#image_preview_container').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            function PreviewImage2(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#image_preview_container2').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }


            $("#photo").change(function() {
                PreviewImage(this);
            });

            $("#thumbnail").change(function() {
                PreviewImage(this);
            });

            $("#sub_photo").change(function() {
                PreviewImage(this);
            });

            $("#banner").change(function() {
                PreviewImage(this);
            });

            $("#image").change(function() {
                PreviewImage(this);
            });

            $("#comment_image").change(function() {
                PreviewImage2(this);
            });

            //Preview Image-----------------------------------------------------------------------//


        });
    </script>
</body>

</html>