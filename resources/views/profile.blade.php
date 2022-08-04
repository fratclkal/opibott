@extends('layouts.master')

@section('content')
<style type="text/css">
    #example1_wrapper{
        margin-top: 10px;
    }
</style>
<div class="container-fluid">

                
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">Hesabım</h4><span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Profil Bilgilerim</span>
        </div>
    </div>
    
</div>
<!-- breadcrumb -->
    <!-- row -->
    <div class="row row-sm">
        <div class="col-lg-4">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="ps-0">
                        <div class="main-profile-overview">
                            <div class="main-img-user profile-user">
                                <img alt="" src="assets/img/faces/user.png"><a
                                    class="fas fa-camera profile-edit" href="JavaScript:void(0);"></a>
                            </div>
                            <div class="d-flex justify-content-between mg-b-20">
                                <div>
                                    <h5 class="main-profile-name">{{ Auth::user()->name }}</h5>
                                    <p class="main-profile-name-text">Hesap Bilgilerim</p>
                                </div>
                            </div>
                            <h6>Hakkımda</h6>
                             
                            <div class="row">
                                <div class="col-md-4 col mb20">
                                    
                                    <h6 class="text-small text-muted mb-0">Kariyeriniz</h6>
                                    
                                   
                                    <h5>{{ Auth::user()->career == 1 ? "1.Kariyer" :  (Auth::user()->career=='2' ?  '2.Kariyer': (Auth::user()->career=='3' ?  '3.Kariyer': 'Starter') ) }}</h5>
                                </div>
                                <div class="col-md-4 col mb20">
                                    
                                    <h6 class="text-small text-muted mb-0">Ülke</h6>
                                    <h5>{{ \App\Models\User::countryGet(Auth::user()->country) }}</h5>
                                </div>
                                <div class="col-md-4 col mb20">
                                
                                    <h6 class="text-small text-muted mb-0">Şehir</h6>
                                    <h5>{{ \App\Models\User::cityGet(Auth::user()->city) }}</h5>
                                </div>
                            </div>

                        </div><!-- main-profile-overview -->
                    </div>
                </div>
            </div>
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="main-content-label tx-13 mg-b-25">
                        İletişim Bilgileriniz
                    </div>
                   
                    <div class="main-profile-contact-list">
                        <div class="media">
                            <div class="media-icon bg-primary-transparent text-primary">
                                <i class="icon ion-md-phone-portrait"></i>
                            </div>
                            <div class="media-body">
                                <span>Telefon</span>
                                <div>
                                {{ Auth::user()->gsm }}
                                </div>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-icon bg-success-transparent text-success">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <div class="media-body">
                                <span>E-Posta</span>
                                <div>
                                {{ Auth::user()->email }}
                                </div>
                            </div>
                        </div>
                    
                    </div><!-- main-profile-contact-list -->
                   
                </div>
            </div>
            <div class="card mg-b-20">
                <div class="card-body">
                    <label class="main-content-label tx-13 mg-b-20">Sosyal Medya Hesaplarımız</label>
                    <div class="main-profile-social-list">
                        <div class="media">
                            <div class="media-icon bg-primary-transparent text-primary">
                                <i class="icon ion-logo-facebook"></i>
                            </div>
                            <div class="media-body">
                                <span>Facebook</span> <a href="#">facebook.com/opibot</a>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-icon bg-success-transparent text-success">
                                <i class="icon ion-logo-twitter"></i>
                            </div>
                            <div class="media-body">
                                <span>Twitter</span> <a href="#">twitter.com/opibot</a>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-icon bg-info-transparent text-info">
                                <i class="icon ion-logo-instagram"></i>
                            </div>
                            <div class="media-body">
                                <span>Instagram</span> <a href="#">instagram.com/opibot</a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- Col -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4 main-content-label">Hesap Bilgileriniz</div>
                    <form method="POST" action="{{ route('profileEdit') }}" class="form-horizontal">
                        @csrf
                        @include('widgets.errors')
                        <div class="mb-4 main-content-label">Profil</div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Ad Soyad</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" readonly placeholder="User Name" value="{{ Auth::user()->name }}">
                                </div>
                            </div>
                        </div>
                    
                    
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Kullanıcı Adı</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" readonly placeholder="Nick Name" value="{{ Auth::user()->user_name }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Sponsorunuz</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" readonly placeholder="Designation" value="{{ \App\Models\User::userNameGet(Auth::user()->upline_id) }}">
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 main-content-label">İletişim Bilgileri</div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Email</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" readonly placeholder="Email" value="{{ Auth::user()->email }}">
                                </div>
                            </div>
                        </div>
                    
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Telefon</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" readonly placeholder="phone number" value="{{ Auth::user()->gsm }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4 main-content-label">şifre Güncelleme</div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Eski Şifre</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="password" class="form-control" name="currentpassword" placeholder="Mevcut şifrenizi giriniz" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Yeni Şifre</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="password" class="form-control" name="password" placeholder="8-15 Karakter" >
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Yeni Şifre Tekrar </label>
                                </div>
                                <div class="col-md-9">
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="8-15 Karakter" >
                                </div>
                            </div>
                        </div>


                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Bilgileri Güncelle</button>
                        </div>
                        
                    
                    </form>
                </div>

            
            </div>
        </div>
        <!-- /Col -->
    </div>
    <!-- row closed -->


</div>

@endsection
@section('js')

@endsection
