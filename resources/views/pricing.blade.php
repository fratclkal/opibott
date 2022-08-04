@extends('layouts.master')

@section('content')

<div class="container-fluid">

    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Paket Seçimi</h4><span
                    class="text-muted mt-1 tx-13 ms-2 mb-0">/ Fiyatlar</span>
            </div>
        </div>
         
    </div> 
    <!-- breadcrumb -->

    <!-- row -->
    
  
    <!-- row -->
    <div class="row">
        <div class="col-sm-12 mb-2">
            <div class="row">
                <div class="col-md-3">
                    <label for="borsa">Borsa Seçimi Yapınız <span class="text-danger">*</span></label>
                    <select class="form-control" id="borsa" name="borsa" onchange="selectBorsa()">
                        <option value="">Borsa Seçiniz</option>
                        <option value="opiex" {{ $borsa == 'opiex' ? 'selected':'' }}>OpiEX</option>
                        <option value="btcturk" {{ $borsa == 'btcturk' ? 'selected':'' }}>BtcTurk</option>
                        <option value="binance" {{ $borsa == 'binance' ? 'selected':'' }}>Binance</option>
                    </select>
                </div>
            </div>
            
        </div>
        <h4 class="card-title mt-4">PAKETLER</h4>
        @foreach($all_packages as $key => $all_package)
        <div class="col-sm-6 col-lg-6 col-xl-3">
            <div class="card pricing-card">
                <div class="card-body text-center">
                    <div class="card-category">{{ $all_package->package_name }}</div>
                    <div class="display-5 my-4">{{ $all_package->package_amount }} $</div>
                    <ul class="list-unstyled leading-loose">
                        <li><i class="fe fe-check text-success me-2"></i><strong>{{ $all_package->type }} </strong>Gün Kullanım </li>
                        <li><i class="fe fe-check text-success me-2"></i> Max Kazanç : <span class="text-warning">{{ $borsa == 'opiex' ? $all_package->max_amount_opiex:$all_package->max_amount }}  $</span> </li>
                        <li><i class="fe fe-check text-success me-2"></i>Referans ve Binary</li>
                        <li><i class="fe fe-check text-success me-2"></i> Matching</li>
                    </ul>
                    <div class="text-center mt-6">
                        <a href="{{ route('select_package',[$all_package->id,$borsa]) }}" class="btn btn-primary btn-block">Paketi Seç</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <!-- /row -->
    


</div>

@endsection
@section('js')
<script type="text/javascript">
    function selectBorsa() {
        window.location.href = '/pricing/' + $('#borsa').val();
    }
</script>
@endsection
