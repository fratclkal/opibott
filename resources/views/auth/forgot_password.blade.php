<!DOCTYPE html>
<html lang="en">
    
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>

        <meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="Description" content="Valex – Laravel Admin & Dashboard Template">
        <meta name="Author" content="SPRUKO™">
        <meta name="Keywords" content="laravel admin panel, laravel admin panel template, laravel admin dashboard template, laravel bootstrap admin template, laravel ui, laravel dashboard, laravel dashboard template, admin, admin template, bootstrap dashboard, bootstrap 5 admin template, laravel blade, laravel blade template bootstrap, php laravel, laravel mix"/>

        <!-- Title -->
        <title> Şifremi Unuttum | OpiBot </title>

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

    <body class="dark-theme">

        
        <div class="error-page1 main-body">
        <!-- Loader -->
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
                            <img src="/assets/img/media/forgot.png" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
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
                                    <div class="main-card-signin d-md-flex bg-white">
                                        <div class="wd-100p">
                                            <div class="main-signin-header">
                                                <h2>Şifremi Unuttum!</h2>
                                                <h4>Lütfen Email Adresinizi Giriniz</h4>
                                                <form action="{{ route('forgot_password_post') }}" method="POST">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label>Email</label> <input class="form-control" placeholder="Email Adresinizi Giriniz" name="email" required type="text">
                                                    </div>
                                                    <button class="btn btn-main-primary btn-block" type="submit">Gönder</button>
                                                </form>
                                            </div>
                                            <div class="main-signup-footer mg-t-20">
                                                <p> <a href="{{ route('loginView') }}"> Giriş Yap</a> </p>
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
            <!-- Container closed -->
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
