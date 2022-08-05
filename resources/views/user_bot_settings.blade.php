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
            <h4 class="content-title mb-0 my-auto">Bot Ayarları</h4><span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Bot Bilgilerim</span>
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
                                <img alt="" src="assets/img/faces/user.png">
                            </div>
                            <div class="d-flex justify-content-between mg-b-20">
                                <div>
                                    <h5 class="main-profile-name">{{ Auth::user()->name }}</h5>
                                    <p class="main-profile-name-text">Bot Bilgilerim</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 col mb20">

                                    <h6 class="text-small text-muted mb-0">Başlangıç Tarihi</h6>


                                    <h5>{{  \Carbon\Carbon::parse($payment->payment_date)->format("d.m.Y") }}</h5>
                                </div>
                                <div class="col-md-4 col mb20">

                                    <h6 class="text-small text-muted mb-0">Bitiş Tarihi</h6>
                                    <h5>
                                        @if($payment->type == 'monthly')
                                            {{  \Carbon\Carbon::parse($payment->payment_date)->addMonth()->format("d.m.Y") }}
                                        @elseif($payment->type == 'yearly')
                                            {{  \Carbon\Carbon::parse($payment->payment_date)->addMonths(12)->format("d.m.Y") }}
                                        @endif
                                    </h5>
                                </div>
                                <div class="col-md-4 col mb20">

                                    <h6 class="text-small text-muted mb-0">Durum</h6>
                                    <h5 class="{{ Auth::user()->payment == 1 ? 'text-success':'text-danger' }}">{{ Auth::user()->payment == 1 ? 'Botunuz Aktif':'Botunuz Pasif' }}</h5>
                                </div>
                            </div>

                        </div><!-- main-profile-overview -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Col -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4 main-content-label">Bot Ayarlarınız</div>
                    <form method="POST" id="settings_form" action="{{ route('change_user_bot_settings') }}" class="form-horizontal">
                        @csrf
                        @include('widgets.errors')
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">APi Key</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" name="api_key" required class="form-control" placeholder="Api Key" value="{{ $setting ? $setting->api_key:'' }}">
                                </div>
                            </div>
                        </div>


                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Api Secret (Varsa)</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="api_secret" placeholder="Api Secret" value="{{ $setting ? $setting->api_secret:'' }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Ip Adres (Varsa)</label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="ip_address" placeholder="Ip Adres" value="{{ $setting ? $setting->ip_address:'' }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Borsa</label>
                                </div>
                                <div class="col-md-9">
                                    <select class="form-control" name="market" id="market">
                                        <option value="Binance">Binance</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="btn ripple btn-warning-gradient" id='confirm_alert'> Kaydet </div>
                            <button type="submit" style="display: none;" class="btn btn-primary waves-effect waves-light">
                            Kaydet
                        </button>
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
<script type="text/javascript">
    $('#confirm_alert').click(function () {
        swal({
          title: "İşlemi Onaylıyor musunuz?",
          text: "Lütfen girdiğiniz bilgilerin doğruluğundan emin olun!",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn btn-danger",
          confirmButtonText: "Kaydet",
          cancelButtonText: "İptal",
          closeOnConfirm: false
        },
        function(){
          $("#settings_form").submit();
        });
    });

</script>
@endsection
