@extends('layouts.master')
@section('css')
    <link href="{{asset('backoffice/assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{asset('backoffice/assets/plugins/datatable/responsivebootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{asset('backoffice/assets/plugins/datatable/fileexport/buttons.bootstrap4.min.css')}}"
          rel="stylesheet">
@endsection
@section('content')
<div class="container-fluid">
                
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Ekip Yerleştir</h4> 
                    
            </div>
            <p class="tx-12 mb-0 text-muted">Binary'de yerleşim bekleyen kişiler ile ilgili işlem yapabilirsiniz</p>
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
                                    <th>Kullanıcı Adı</th>
                                    <th>Tel No</th>
                                    <th>Tarih</th>
                                    <th>İşlem</th>
                                </tr>
                            </thead>
                            <tbody class="custom-cls-no-br">
                                @foreach($getpassivemember as $data)
                                    <tr>
                                        <td class="text-center text-lg text-medium">{{ $data->name }}</td>
                                        <td class="text-center text-lg text-medium">{{ $data->gsm }}</td>
                                        <td class="text-center text-lg text-medium">{{ $data->created_at }}</td>
                                        <td class="text-center text-lg text-medium">
                                            <a href="{{ route('SettlementTreeIndex',[$data->sponsor_id,\App\Models\User::find($data->upline_id)->sponsor_id]) }}"> 
                                                <button class="btn ripple btn-info btn-with-icon"><i
                                                        class="fe fe-folder"></i> Yerleşim Yap
                                                </button></a>
                                        </td>
                                    </tr>
                                @endforeach
                                 
                            </tbody>
                        </table>
                    </div>
                     
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->


</div> 
@endsection

