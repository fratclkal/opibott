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
                <h4 class="content-title mb-0 my-auto">Muhasebe</h4><span
                    class="text-muted mt-1 tx-13 ms-2 mb-0">/ Gelir - Gider Detayları</span>
            </div>
        </div>
         
    </div>
    <!-- breadcrumb -->

    <!--Row-->
    <div class="row row-sm">
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-primary-gradient">
                <div class="ps-3 pt-3 pe-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">Toplam Paket Tutarları</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 fw-bold mb-1 text-white">${{ number_format($total_package_info[0]->usd_amount,'2','.',',') }}</h4>
                                <p class="mb-0 tx-12 text-white op-7">Son 20 Günün Grafiği</p>
                            </div>
                            <span class="float-end my-auto ms-auto">
                                <i class="fe fe-package text-white"></i>
                                <span class="text-white op-7"> {{ $total_package_info[0]->package_count }} Paket</span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline" class="pt-1">
                    @foreach($last20_package as $key => $package)
                        {{ $package->package_count }} ,
                    @endforeach
                    {{ $last20_package[count($last20_package)-1]->package_count }}
                </span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-danger-gradient">
                <div class="ps-3 pt-3 pe-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">Dağıtılan Toplam Kazançlar</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 fw-bold mb-1 text-white">${{ number_format($total_comission_info[0]->usd_amount,'2','.',',') }}</h4>
                                <p class="mb-0 tx-12 text-white op-7">Toplamda {{ $total_comission_info[0]->user_count }} kişiye kazanç dağıtıldı</p>
                            </div>
                            <span class="float-end my-auto ms-auto">
                                <i class="fas fa-arrow-circle-down text-white"></i>
                                <span class="text-white op-7"> {{ number_format($total_comission_info[0]->usd_amount*100/$total_package_info[0]->usd_amount,'2','.','') }}%</span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline2" class="pt-1">
                    @foreach($last20_comission as $key => $comission)
                        {{ $comission->comission_count }} ,
                    @endforeach
                    {{ $last20_comission[count($last20_comission)-1]->comission_count }}
                </span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-success-gradient">
                <div class="ps-3 pt-3 pe-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">Toplam Fee Geliri</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 fw-bold mb-1 text-white">${{ number_format($withdraw_info[0]->fee_amount,'2','.',',') }}</h4>
                                <p class="mb-0 tx-12 text-white op-7">Onaylanmış transferlerden kesilen fee tutarları toplamı</p>
                            </div>
                            <span class="float-end my-auto ms-auto">
                                <i class="fas fa-arrow-circle-up text-white"></i>
                                <span class="text-white op-7"> {{ number_format($withdraw_info[0]->fee_amount*100/$total_comission_info[0]->usd_amount,'2','.','') }}%</span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline3" class="pt-1">
                    @foreach($last20_withdraw as $key => $withdraw)
                        {{ $withdraw->withdraw_count }} ,
                    @endforeach
                    {{ $last20_withdraw[count($last20_withdraw)-1]->withdraw_count }}
                </span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-warning-gradient">
                <div class="ps-3 pt-3 pe-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">Toplam Çekim Tutarı</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 fw-bold mb-1 text-white">${{ number_format($withdraw_info[0]->withdraw_amount,'2','.',',') }}</h4>
                                <p class="mb-0 tx-12 text-white op-7">Onaylanmış transferlerin toplam tutarı</p>
                            </div>
                            <span class="float-end my-auto ms-auto">
                                <i class="fas fa-arrow-circle-down text-white"></i>
                                <span class="text-white op-7"> {{ number_format($withdraw_info[0]->withdraw_amount*100/$total_comission_info[0]->usd_amount,'2','.','') }}%</span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline4" class="pt-1">
                    @foreach($last20_withdraw as $key => $withdraw)
                        {{ $withdraw->withdraw_count }} ,
                    @endforeach
                    {{ $last20_withdraw[count($last20_withdraw)-1]->withdraw_count }}
                </span>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 col-xl-6">
            <div class="card card-table-two">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mb-1">PAKET BİLGİLERİ</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
                <span class="tx-12 tx-muted mb-3 ">Paketler Detay Tablosu.</span>
                <div class="table-responsive country-table">
                    <table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
                        <thead>
                            <tr>
                                <th class="wd-lg-25p">Paket Tipi</th>
                                <th class="wd-lg-25p tx-right">Paket Tutarı</th>
                                <th class="wd-lg-25p tx-right">Max Paket Kazancı</th>
                                <th class="wd-lg-25p tx-right">Toplam Paket Sayısı</th>
                                <th class="wd-lg-25p tx-right">Toplam Tutar</th>
                                <th class="wd-lg-25p tx-right">Durum</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 

                                $active_package_count = 0; 
                                $active_package_amount = 0; 
                                $passive_package_count = 0; 
                                $passive_package_amount = 0; 

                            @endphp
                            @foreach($payments as $payment)
                                @if($payment->is_pay == 1)
                                    @php 
                                        $active_package_count+= $payment->package_count;
                                        $active_package_amount+= $payment->total_amount;
                                    @endphp
                                @elseif($payment->is_pay == 0)
                                    @php 
                                        $passive_package_count+= $payment->package_count; 
                                        $passive_package_amount+= $payment->total_amount; 
                                    @endphp
                                @endif
                            <tr>
                                <td class="text-warning">{{ $payment->type == 'monthly' ? 'Aylık':'Yıllık' }}</td>
                                <td class="tx-right tx-medium tx-inverse">{{ $payment->package_amount }}</td>
                                <td class="tx-right tx-medium tx-inverse">{{ $payment->max_amount }}</td>
                                <td class="tx-right tx-medium tx-inverse">{{ $payment->package_count }}</td>
                                <td class="tx-right tx-medium tx-info">${{ $payment->total_amount }}</td>
                                <td class="tx-right tx-medium {{ $payment->is_pay == 1 ? 'tx-success':'tx-danger' }}">{{ $payment->is_pay == 1 ? 'Aktif':'Pasif' }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class="text-danger">AKTİF PAKETLER</td>
                                <td class="tx-center">-</td>
                                <td class="tx-center">-</td>
                                <td class="tx-right tx-medium tx-inverse">{{ $active_package_count }}</td>
                                <td class="tx-right tx-medium tx-success">${{ $active_package_amount }}</td>
                                <td class="tx-center">-</td>
                            </tr>
                            <tr>
                                <td class="text-danger">PASİF PAKETLER</td>
                                <td class="tx-center">-</td>
                                <td class="tx-center">-</td>
                                <td class="tx-right tx-medium tx-inverse">{{ $passive_package_count }}</td>
                                <td class="tx-right tx-medium tx-success">${{ $passive_package_amount }}</td>
                                <td class="tx-center">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 col-xl-6">
            <div class="card card-table-two">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title mb-1">KAZANÇ DAĞILIM BİLGİLERİ</h4>
                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
                <span class="tx-12 tx-muted mb-3 ">Kazanç Detay Tablosu.</span>
                <div class="table-responsive country-table">
                    <table class="table table-striped table-bordered mb-0 text-sm-nowrap text-lg-nowrap text-xl-nowrap">
                        <thead>
                            <tr>
                                <th class="wd-lg-25p">Kazanç Tipi</th>
                                <th class="wd-lg-25p tx-right">Kazanç Sayısı</th>
                                <th class="wd-lg-25p tx-right">Toplam Kazanç Tutarı</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($comissions as $comission)
                            <tr>
                                <td class="text-warning">{{ $comission->type }}</td>
                                <td class="tx-right tx-medium tx-inverse">{{ $comission->type_count }}</td>
                                <td class="tx-right tx-medium tx-info">${{ $comission->total_amount }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
</script>

@endsection
