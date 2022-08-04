<!DOCTYPE html>
<html lang="en">
    
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <head>
        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="Description" content="OpiBot – Arbitraj Botu">
        <meta name="Author" content="QZEN">
        <meta name="Keywords" content="opibot"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Title -->
        <title> Şifre Sıfırlama | OpiBot </title>

        <!--- Favicon --->
        <link rel="icon" href="/assets/img/brand/favicon.png" type="image/x-icon"/>

        <!--- Icons css --->
        <link href="/assets/plugins/icons/icons.css" rel="stylesheet">

        <!-- Bootstrap css -->
        <link href="/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!--- Right-sidemenu css --->
        <link href="/assets/plugins/sidebar/sidebar.css" rel="stylesheet">

        <!-- P-scroll bar css-->
        <link href="/assets/plugins/perfect-scrollbar/p-scrollbar.css" rel="stylesheet" />

        <!-- Sidemenu css -->
        <link rel="stylesheet" href="/assets/css/sidemenu.css">

        <!--- Style css --->
        <link href="/assets/css/style.css" rel="stylesheet">
        <link href="/assets/css/boxed.css" rel="stylesheet">
        <link href="/assets/css/dark-boxed.css" rel="stylesheet">
        
        <!---Skinmodes css-->
        <link href="/assets/css/skin-modes.css" rel="stylesheet">

        <!--- Dark-mode css --->
        <link href="/assets/css/style-dark.css" rel="stylesheet">

        <!-- Sidemenu-respoansive-tabs css -->
        <link href="/assets/plugins/sidemenu-responsive-tabs/sidemenu-responsive-tabs.css" rel="stylesheet">

        
        
        <!--- Animations css --->
        <link href="/assets/css/animate.css" rel="stylesheet">

        <!---Switcher css-->
        <link href="/assets/switcher/css/switcher.css" rel="stylesheet">
        <link href="/assets/switcher/demo.css" rel="stylesheet">
    </head>

    <body class="dark-theme ">

        
        <div class="error-page1 main-body text-dark">

            <div id="global-loader">
                <img src="/assets/img/loader.svg" class="loader-img" alt="Loader">
            </div>
            <!-- /Loader -->

            <!-- Page -->
            <div class="page">
                    
                <div class="container-fluid">
                    <div class="row no-gutter">
                        <!-- The image half -->
                        <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
                            <div class="row wd-100p mx-auto text-center">
                                <div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
                                    <img src="/assets/img/media/reset.png" class="my-auto ht-xl-80p wd-md-100p wd-xl-50p ht-xl-60p mx-auto" alt="logo">
                                </div>
                            </div>
                        </div>
                        <!-- The content half -->
                        <div class="col-md-6 col-lg-6 col-xl-5 bg-white">
                            <div class="login d-flex align-items-center py-2">
                                <!-- Demo content-->
                                <div class="container p-0">
                                    <div class="row">
                                        <div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
                                            <div class="mb-5 d-flex">
                                                <a href="/"><img src="/assets/img/brand/favicon.png" class="sign-favicon-a ht-40" alt="logo">
                                                <img src="/assets/img/brand/favicon-white.png" class="sign-favicon-b ht-40" alt="logo">
                                                </a>
                                                <h1 class="main-logo1 ms-1 me-0 my-auto tx-28">OpiBot</h1>
                                            </div>
                                            <div class="main-card-signin d-md-flex">
                                                <div class="wd-100p">
                                                    <div class="main-signin-header">
                                                        <div class="">
                                                            <h2>Tekrar Hoşgeldiniz!</h2>
                                                            <h4 class="text-start">Şifrenizi Sıfırlayın</h4>
                                                            @error('password')
                                                                <div class="alert alert-danger">Şifreler eşleşmiyor!</div>
                                                            @enderror
                                                            <form action="/reset_password_post" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="email" value="{{ $email }}">
                                                                <input type="hidden" name="token" value="{{ $token }}">
                                                                <div class="form-group text-start">
                                                                    <label>Yeni Şifre</label>
                                                                    <input class="form-control" placeholder="Yeni şifrenizi giriniz" required name="password" type="password">
                                                                </div>
                                                                <div class="form-group text-start">
                                                                    <label>Yeni Şifre Tekrar</label>
                                                                    <input class="form-control" name="password_confirmation" placeholder="Yeni şifrenizi tekrar giriniz" required type="password">
                                                                </div>
                                                                <button type="submit" class="btn ripple btn-main-primary btn-block">Şifreyi Sıfırla</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="main-signup-footer mg-t-20">
                                                        <p>Zaten bir hesabınız var mı? <a href="{{ route('loginView') }}">Giriş Yapın</a></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- End -->
                            </div>
                        </div><!-- End -->
                    </div>
                </div>


            </div>
        </div>

        <!--- JQuery min js --->
        <script src="/assets/plugins/jquery/jquery.min.js"></script>

        <!--- Bootstrap Bundle js --->
        <script src="/assets/plugins/bootstrap/js/popper.min.js"></script>
        <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!--- Ionicons js --->
        <script src="/assets/plugins/ionicons/ionicons.js"></script>

        <!--- Moment js --->
        <script src="/assets/plugins/moment/moment.js"></script>

        <!-- P-scroll js -->
        <script src="/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

        <!--- Eva-icons js --->
        <script src="/assets/plugins/eva-icons/eva-icons.min.js"></script>

        <!--- Rating js --->
        <script src="/assets/plugins/rating/jquery.rating-stars.js"></script>
        <script src="/assets/plugins/rating/jquery.barrating.js"></script>

        <!--- JQuery sparkline js --->
        <script src="/assets/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>

        
        
        <!--- Custom js --->
        <script src="/assets/js/custom.js"></script>

        <!-- Switcher js -->
        <script src="/assets/switcher/js/switcher.js"></script>
        
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script type="text/javascript">
            let error = `{{ Session::get('error') }}`;
            if(error){
                swal('', error, 'warning');
            }

            let success = `{{ Session::get('success') }}`;
            if(success){
                swal('', success, 'success');
            }

        </script>
    </div>

    </body>
</html>
