@extends('layouts.master')

@section('content')

<div class="container-fluid">
                
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Ödeme Sayfası</h4><span
                    class="text-muted mt-1 tx-13 ms-2 mb-0">/ Paket Ödemeleri</span>
                    
            </div>
            <p class="tx-12 mb-0 text-muted">Seçmiş olduğunuz Bot Kiralama paketinin ödemesini buradan yapabilirsiniz.</p>
        </div>
     
    </div>
    <!-- breadcrumb -->

    <!-- row opened -->
    <div class="row">
        <div class="col-xl-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <!-- Shopping Cart-->
                    <div class="product-details table-responsive text-nowrap">
                        <table class="table table-bordered table-hover mb-0 text-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-start">Paket</th>
                                    <th>Paket Tutarı</th>
                                    <th>Ödediğiniz Tutar</th>
                                    <th>Borsa</th>
                                    <th>Süresi</th>
                                    <th>Durum</th>
                                    @if($payment->is_pay == 0)
                                    <th><a class="btn btn-sm btn-outline-danger" href="#">İptal Et</a>
                                    </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="custom-cls-no-br">
                                <tr>
                                    <td>
                                        <div class="media">
                                            <div class="card-aside-img">
                                                <img src="assets/img/faces/user.png" alt="img"
                                                    class="h-60 w-60">
                                            </div>
                                            <div class="media-body">
                                                <div class="card-item-desc mt-0">
                                                    <h6 class="fw-semibold mt-0 text-uppercase text-warning">{{ $package->package_name }}
                                                    </h6>
                                                    <dl class="card-item-desc-1 text-info">
                                                        <dt>Kazanç : </dt>
                                                        <dd class="text-info">Max. {{ $payment->borsa == 'opiex' ? $package->max_amount_opiex:$package->max_amount }} $</dd>
                                                    </dl>
                                                    <dl class="card-item-desc-1 text-info">
                                                        <dt>Kazanç Türleri : </dt>
                                                        <dd class="text-info">Referans, Matching, Binary</dd>
                                                    </dl>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                 
                                    <td class="text-center text-lg text-medium">{{ $package->package_amount }} $</td>
                                    <td class="text-center text-lg text-medium">{{ $totalPayment }} $</td>
                                    <td class="text-center text-lg text-medium">{{ $payment->borsa == 'opiex' ? 'OpiEX':strtoupper($payment->borsa) }} </td>
                                    <td class="text-center text-lg text-medium">{{ $package->type }} Gün</td>
                                    <td class="text-center text-lg text-medium {{ $payment->is_pay == 1 ? 'text-success':($payment->is_pay == 2 ? 'text-warning':'text-danger') }}">{{ $payment->is_pay == 1 ? 'Ödendi':($payment->is_pay == 2 ? 'Ödeme Kontrol Ediliyor':'Ödeme Bekliyor') }}
                                        @if($payment->is_pay == 3 ) 
                                        <br> 
                                        <span class="text-warning">Ödemeniz SİSTEM tarafından reddedildi. Lütfen ödemenizi kontrol ediniz. <br> Eksik tutarı gönderip aşağıdan tx kodunu onaylatınız!
                                        </span>
                                        @endif
                                    </td>
                                    @if($payment->is_pay == 0)
                                    <td class="text-center"><a class="remove-from-cart" href="{{ route('delete_package',$payment->id) }}"
                                            data-bs-toggle="tooltip" title=""
                                            data-bs-original-title="Sil ve Geri Git"><i
                                                class="fa fa-trash"></i></a></td>
                                    @endif
                                </tr>
                                 
                            </tbody>
                        </table>
                    </div>
                    <div class="main-content-label mg-b-5 text-danger mt-2">
                        **BOTTAN ELDE ETTİĞİNİZ KAZANÇ {{ $package->max_amount }}$ TUTARINA ULAŞTIĞINDA BOTUNUZ İŞLEM YAPMAYI DURDURUR VE PASİF HALE GEÇER. KAZANÇ SAĞLAMAK İÇİN BOTUNUZU TEKRAR AKTİF HALE GETİREBİLİR VEYA  YENİ BİR PAKET SEÇEBİLİRSİNİZ.
                    </div>
                    @if(($payment->is_pay == 0 || $payment->is_pay == 3) && $payment->status == 'passive')

                    <div class="col-lg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="main-content-label mg-b-5">
                                    USDT ile Ödeme
                                </div>
                                <p class="mg-b-20">Lütfen aşağıdaki USDT adresine <span class="bg-danger ">TRC20</span> ağı ile gönderim yapınız. Ardından TX kodunu kaydederek işleminizi tamamlayınız</p>
                                @error('tx')
                                    <div class="alert alert-danger">TX kodunu doğru ve eksiksiz girdiğinizden emin olunuz!</div>
                                @enderror
                                <form action="{{ route('pay_package') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-10 col-lg-8 col-xl-6 mx-auto d-block">
                                            <div class="card card-body pd-20 pd-md-40 border shadow-none">
                                                <h5 class="card-title mg-b-20">Ödeme İşlemi</h5>
                                                <div class="form-group">
                                                    <label class="main-content-label tx-11 tx-medium tx-gray-600">Transfer yapılacak USDT adres (TRC20)</label> 
                                                    <div class="pos-relative">
                                                        <input class="form-control pd-r-80" required="required"placeholder="TSC5qCiWLCCfJc9Dj4hZ7mvizagHtw1gBm" readonly type="text">
                                                        <div class="d-flex pos-absolute" style="top: 1px;right: 0px;">
                                                            <button onclick="copyToClipboard()" class="btn btn-indigo btn-icon"><i class="fa fa-copy"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="main-content-label tx-11 tx-medium tx-gray-600">TX Kod</label>
                                                    <div class="pos-relative">
                                                        <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                                                        <input class="form-control pd-r-80" name="tx" required="required" type="text">
                                                        <div class="d-flex pos-absolute t-5 r-10"></div>
                                                    </div>
                                                </div>
                                     
                                                <div class="form-group mg-b-20">
                                                    <label class="ckbox"><input checked type="checkbox" disabled><span class="tx-13">İşlemin doğruluğunu onaylıyorum</span></label>
                                                </div>
                                                <button class="btn btn-main-primary btn-block" type="submit">Kaydet</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>   
                            </div>
                        </div>
                    </div>
                    @endif
                     
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->


</div>

@endsection

@section('js')
<script type="text/javascript">
    function copyToClipboard() {
        let wallet = 'TSC5qCiWLCCfJc9Dj4hZ7mvizagHtw1gBm';
        var copyhelper = document.createElement("input");
        copyhelper.className = 'copyhelper'
        document.body.appendChild(copyhelper);
        copyhelper.value = wallet;
        copyhelper.select();
        document.execCommand("copy");
        document.body.removeChild(copyhelper);
        swal("Kopyalandı ! Lütfen TRC20 ağı ile gönderim yapınız" , wallet, 'success')
    }
</script>

@endsection