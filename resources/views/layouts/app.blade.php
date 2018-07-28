<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <!-- <li><a href="{{ route('login') }}">Login</a></li> -->
                            <li>
                                <a href="javascript::void(0);" data-toggle="modal" data-target="#Login">Login</a>
                            </li>
                            <li>
                                <a href="javascript::void(0);" data-toggle="modal" data-target="#SignUp">Register</a>
                            </li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Include register model popup content -->
        @include('layouts.loginmodel')
        <!-- Include register model popup content -->
        @include('layouts.registermodel')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        var baseURL = '<?php echo URL::to('/'); ?>';
    </script>

    <script type="text/javascript">
        //Do registration
        $('body').on('click', '#submitForm', function(){
            var registerForm = $("#Register");
            var formData = registerForm.serialize();
            $( '#name-error' ).html( "" );
            $( '#email-error' ).html( "" );
            $( '#password-error' ).html( "" );

            $.ajax({
                url:baseURL+'/register',
                type:'POST',
                data:formData,
                success:function(data) {
                    if(data.errors) {
                        if(data.errors.name){
                            $( '#name-error' ).html( data.errors.name[0] );
                        }
                        if(data.errors.email){
                            $( '#email-error' ).html( data.errors.email[0] );
                        }
                        if(data.errors.password){
                            $( '#password-error' ).html( data.errors.password[0] );
                        }
                        
                    }
                    if(data.success) {
                        $('#success-msg').removeClass('hide');
                        setInterval(function(){ 
                            $('#SignUp').modal('hide');
                            $('#success-msg').addClass('hide');
                        }, 3000);
                    }
                },
                error:function(data) {
                    console.log('err');
                }
            });
        });

        //Do Login
        $('body').on('click', '#loginForm', function(){
            var loginForm = $("#LoginFormID");
            var formData = loginForm.serialize();

            $( '#email-error' ).html( "" );
            $( '#password-error' ).html( "" );
            $( '#failed-error' ).html( "" );

            $.ajax({
                url:baseURL+'/login',
                type:'POST',
                data:formData,
                success:function(data) {
                    if(data.errors) {
                        if(data.errors.email){
                            $( '#email-error' ).html( data.errors.email[0] );
                        }
                        if(data.errors.password){
                            $( '#password-error' ).html( data.errors.password[0] );
                        }
                        if(data.errors.failed){
                            $( '#failed-error' ).html( data.errors.failed );
                        }                        
                    }
                    if(data.success) {
                        $('#Login').modal('hide');
                        window.location.href = baseURL+'/home';
                    }
                },
                error:function(data) {
                    console.log('err');
                }
            });
        });
    </script>
</body>
</html>
