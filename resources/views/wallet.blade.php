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
                <h4 class="content-title mb-0 my-auto">Cüzdanım</h4><span class="text-muted mt-1 tx-13 ms-2 mb-0">/ Transfer İşlemleri</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->

    <div class="row">
        @include('widgets.errors')
        <div class="col-lg-6 col-md-12">
            <div class="card card-img-holder">
                <div class="card-body list-icons">
                    <div class="clearfix">
                        <div class="float-end  mt-2">
											<span class="text-primary ">
												<i class="si si-credit-card tx-30"></i>
											</span>
                        </div>
                        <div class="float-start">
                            <p class="card-text text-muted mb-1">Kullanılabilir Tutar</p>
                            <h3>{{ $available_amount }} $</h3>
                        </div>
                    </div>
                    <div class="card-footer p-0">
                        <p class="text-muted mb-0 pt-4"><i
                                    class="si si-arrow-up-circle text-success me-2"></i>Toplam kazançlarınızdan geçmiş çekim işlemleriniz çıkarılmıştır.</p>
                    </div>
                </div>
            </div>
            <div class="card card-img-holder">
                <div class="card-body list-icons">
                    <div class="clearfix">
                        <div class="float-end  mt-2">
											<span class="text-primary">
												<i class="si si-chart tx-30"></i>
											</span>
                        </div>
                        <div class="float-start">
                            <p class="card-text text-muted mb-1">Paket Bilgilerim</p>
                            <h3>{{ $payment->type }} Gün -  {{ $payment->usd_amount }} $</h3>
                        </div>
                    </div>
                    <div class="card-footer p-0">
                        <p class="text-muted mb-0 pt-4"><i class="si si-exclamation text-info me-2"></i>Paketinizin bitmesine XXX gün kaldı</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
            <div class="card  box-shadow-0 ">
                <div class="card-header">
                    <h4 class="card-title mb-1">USDT Transfer</h4>
                    @if($user_wallet_info->count() > 0)
                    <p class="mb-2">TRC 20 USDT adres ve tutar girerek işlem yapınız.</p>
                    @else
                    <p class="mb-2 text-danger">Kayıtlı herhangi bir USDT adresiniz bulunmamaktadır. Transfer yapabilmek için Adreslerim kısmından USDT adresinizi kaydetmeniz gerekmektedir!</p>
                    @endif
                </div>
                <div class="card-body pt-0">
                    @if($user_wallet_info->count() > 0)
                    <form id="withdrawWalletForm" method="POST" action="{{ route("withdrawWallet") }}">
                        @csrf
                        <div class="">
                            <div class="form-group">
                                <label for="exampleInputEmail1">USDT ADRES (TRC 20)</label>
                                <div class="pos-relative">
                                <input type="hidden" name="address" value="{{ $user_wallet_info[0]->address }}">
                                <input type="text" class="form-control"  id="exampleInputEmail1" placeholder="USDT Adres" value="{{ $user_wallet_info[0]->address }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
                                    <label for="exampleInputPassword1">Tutar</label>
                                    <input class="form-control pd-r-80" min="10" name="amount" onkeyup="checkTransValue(this.value)" required="required" placeholder="Çekim tutarı min 10 $" type="number">
                                </div>
                                      
                                <div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
                                    <label for="exampleInputPassword1">Adres Şifresi</label>
                                        <input class="form-control pd-r-80" name="password" required="required" placeholder="Adres şifrenizi giriniz" type="password">
                                </div>
                            </div>
                            <p class="text-muted mb-0 pt-4 message"></p>
                            <p class="text-muted mb-0 pt-4"><i class="si si-exclamation text-info me-2"></i>Fee : %10 + 3 USDT</p>

                        </div>
                        <button type="submit" onclick="send_message()" id="btn_sutmit" class="btn btn-primary mt-3 mb-0">Transfer Yap</button>
                    </form>
                    @else
                    <a href="{{ route('myWallets') }}" class="btn btn-info mt-3 mb-0">Adres Ekle</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!--Row-->
    <div class="row row-sm">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">Ödeme Kontrol ve Onay</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">Onay Bekleyen ve tamamlanan tüm işlemler</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive border-top userlist-table">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-lg-8p"><span>Id</span></th>
                                    <th class="wd-lg-20p"><span>USDT adres</span></th>
                                    <th class="wd-lg-20p"><span>Talep Tutarı</span></th>
                                    <th class="wd-lg-20p"><span>Gönderilecek Tutar</span></th>
                                    <th class="wd-lg-20p"><span>Durumu</span></th>
                                    <th class="wd-lg-20p"><span>Tarih</span></th>
                                    <th class="wd-lg-20p">İşlem</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($withdraws as $key => $withdraw)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $withdraw->wallet }}</td>
                                    <td>{{ $withdraw->amount }}  </td>
                                    <td> {{ (float)$withdraw->amount /100*90 - 3 }} </td>
                                    <td>
                                        @if($withdraw->status == 0)
                                            <span class="badge bg-warning"> Mail Onayı Beklemede</span>
                                        @elseif($withdraw->status == 1)
                                            <span class="badge bg-success">Gönderildi</span>
                                        @elseif($withdraw->status == 2)
                                            <span class="badge bg-warning">Admin onayı beklemede</span>
                                        @elseif($withdraw->status == 3)
                                            <span class="badge bg-danger">Transfer Talebi Reddedildi</span>
                                        @endif
                                    </td>
                                    <td>{{ $withdraw->created_at }}</td>
                                    <td>
                                        @if($withdraw->status == 0)
                                            <a href="{{ route('withdrawDelete',[$withdraw->id]) }}"><button type="button" class="btn btn-danger">İptal et</button></a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
{{--                    <ul class="pagination mt-4 mb-0 float-end">--}}
{{--                        <li class="page-item page-prev disabled">--}}
{{--                            <a class="page-link" href="#" tabindex="-1">Prev</a>--}}
{{--                        </li>--}}
{{--                        <li class="page-item active"><a class="page-link" href="#">1</a></li>--}}
{{--                        <li class="page-item"><a class="page-link" href="#">2</a></li>--}}
{{--                        <li class="page-item"><a class="page-link" href="#">3</a></li>--}}
{{--                        <li class="page-item"><a class="page-link" href="#">4</a></li>--}}
{{--                        <li class="page-item"><a class="page-link" href="#">5</a></li>--}}
{{--                        <li class="page-item page-next">--}}
{{--                            <a class="page-link" href="#">Next</a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
                </div>
            </div>
        </div><!-- COL END -->
    </div>
    <!-- row closed  -->


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

    function send_message() {
        document.getElementById("btn_sutmit").disabled = true;
        document.getElementById("withdrawWalletForm").submit();
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
