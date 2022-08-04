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
                <h4 class="content-title mb-0 my-auto">Adreslerim</h4><span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Adres İşlemleri</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->

    <div class="row">
        @include('widgets.errors')
        <div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
            <div class="card  box-shadow-0 ">
                <div class="card-header">
                    <h4 class="card-title mb-1">USDT Adres Ekle/Güncelle</h4>
                    <p class="mb-2">Buradan USDT adresinizi ekleyebilir ya da mevcut USDT adresinizi güncelleyebilirsiniz.</p>
                </div>
                <div class="card-body pt-0">
                    <form id="withdrawWalletForm" method="POST" action="{{ route('myWalletsPost') }}">
                        @csrf
                        <div class="">
                            <div class="form-group">
                                <label for="exampleInputEmail1">USDT ADRES (TRC 20)</label>
                                <div class="pos-relative">
                                <input type="text" class="form-control" name="address" required="required" placeholder="USDT Adres" value="{{ $user_wallet_info->count() > 0 ? $user_wallet_info[0]->address:'' }}">
                                    <div class="d-flex pos-absolute t-5 r-10"><img alt="" class="wd-30" src="assets/img/usdt.png"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Adres Şifresi</label>
                                    <input class="form-control pd-r-80" name="password" required="required" placeholder="Adres şifrenizi giriniz" type="password">
                            </div>

                        </div>
                        <button type="submit" id="btn_sutmit" class="btn btn-primary mt-3 mb-0">Kaydet</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>

@endsection
@section('js')
<script type="text/javascript">
    function copyToClipboard() {
        let url = "http://" + '{{ $_SERVER["SERVER_NAME"] }}' + '{{ $_SERVER["REQUEST_URI"] }}' + 'register/{{Auth::user()->sponsor_id}}';
        var copyhelper = document.createElement("input");
        copyhelper.className = 'copyhelper'
        document.body.appendChild(copyhelper);
        copyhelper.value = url;
        copyhelper.select();
        document.execCommand("copy");
        document.body.removeChild(copyhelper);
        swal('Kopyalandı', url, 'success')
    }

    function checkTransValue(amount){
        const transferAmount  = (amount - (amount * 0.1) - 3).toFixed(2);
        if(transferAmount > 10)
        document.getElementsByClassName("message")[0].innerHTML = `Gönderilecek tutar: ~ ${transferAmount}`;
        else
            document.getElementsByClassName("message")[0].innerHTML = ``;
    }
</script>

@endsection
