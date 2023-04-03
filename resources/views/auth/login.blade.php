<!DOCTYPE html>
<html lang="en">


<!-- auth-login.html  21 Nov 2019 03:49:32 GMT -->

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Otika - Admin Dashboard Template</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/bootstrap-social/bootstrap-social.css') }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('assets/img/favicon.ico') }}" />

    <style>
        .background-image {

            /* background-image: url("https://media.self.com/photos/628e481b77d608f44f5f5abe/1:1/w_3481,h_3481,c_limit/what-is-pilates.jpeg"); */
            /* background-image: url("https://cdn.shopify.com/s/files/1/1564/6971/articles/Sweat_PilatesWorkout_HERO_en2c9a9f421248b7efb7594cc9c27de25b_b5aec066-beed-4b27-a291-3175968afc04_1024x1024.jpg?v=1614644515"); */
            /* background-image: url("https://img.freepik.com/fotos-premium/jovem-garota-fazendo-pilates-exercicios-com-uma-cama-de-reformador-instrutor-magro-bonito-da-aptidao-no-reformador_124865-5993.jpg"); */
            background-image: url("{{ asset('img/background.jpg') }}");

            /* Full height */
            height: 100%;

            /* Center and scale the image nicely */
            background-position: left;
            background-repeat: no-repeat;
            background-size: cover;

        }
    </style>
</head>

<body class="background-image">
    
    <div class="loader"></div>
    <div id="app" >
        <section class="section">
            <div class="container mt-5 vh-100">
                <div class="row align-items-center h-100">
                    <div
                        class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">

                        <div class="card card-primary">

                            <div class="card-header">
                                <h4>Login</h4>
                            </div>

                            <div class="card-body">

                                {{-- <img src="{{ asset('img/logo.png') }}" alt="" height="100" class="mx-auto mx-auto d-block mb-4"> --}}

                                <form method="POST" action="{{ route('login') }}">

                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" class="form-control" name="email" tabindex="1"
                                            required autofocus>
                                        @if($errors->has('email'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('email') }}
                                        </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Password</label>
                                            <div class="float-right">
                                                <a href="auth-forgot-password.html" class="text-small">
                                                    Esqueceu sua senha?
                                                </a>
                                            </div>
                                        </div>
                                        <input id="password" type="password" class="form-control" name="password"
                                            tabindex="2" required>
                                        @if($errors->has('password'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('password') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="remember" class="custom-control-input"
                                                tabindex="3" id="remember-me">
                                            <label class="custom-control-label" for="remember-me">Manter-me
                                                Conectado</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            Login
                                        </button>
                                    </div>
                                </form>

                                <!-- Validation Errors -->
                                @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">{{ $error }}</div>
                                @endforeach

                                {{-- !-- Session Status --> --}}
                                {{-- <x-auth-session-status class="mb-4" :status="session('status')" /> --}}

                                <!-- Validation Errors -->
                                {{-- <x-auth-validation-errors class="mb-4" :errors="$errors" /> --}}

                                {{-- <div class="text-center mt-4 mb-3">
                                    <div class="text-job text-muted">Login With Social</div>
                                </div>
                                <div class="row sm-gutters">
                                    <div class="col-6">
                                        <a class="btn btn-block btn-social btn-facebook">
                                            <span class="fab fa-facebook"></span> Facebook
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a class="btn btn-block btn-social btn-twitter">
                                            <span class="fab fa-twitter"></span> Twitter
                                        </a>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="mt-5 text-muted text-center">
                            Ainda não tem acesso? <a href="{{ route('register') }}">Registre-se</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>



    {{-- <div class="container vh-100">
        <div class="row align-items-center h-100">
            <div class="col-6 mx-auto">
                <div class="jumbotron">
                    I'm vertically centered
                </div>
            </div>
        </div>
    </div> --}}


    <!-- General JS Scripts -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <!-- JS Libraies -->
    <!-- Page Specific JS File -->
    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <!-- Custom JS File -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>
</body>


<!-- auth-login.html  21 Nov 2019 03:49:32 GMT -->

</html>