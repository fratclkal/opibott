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
                <h4 class="content-title mb-0 my-auto">Kazançlarım</h4><span
                    class="text-muted mt-1 tx-13 ms-2 mb-0">/ Kazanç Detayları</span>
            </div>
        </div>
         
    </div>
    <!-- breadcrumb -->

    <!--Row-->
    <div class="row row-sm">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">Kazançlar</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">Bütün kazançlarınızın totalini bu sayfada görebilirsiniz.</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive border-top userlist-table">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-lg-20p text-center"><span>Kazanç Türü</span></th>
                                    <th class="wd-lg-20p text-center"><span>Kazanç Tutarı</span></th>
                                    <th class="wd-lg-20p text-center"><span>Tarih</span></th>
                                    <th class="wd-lg-20p text-center">İşlem</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($comissions as $key => $comission)
                                <tr>
                                    <td class="text-center">{{ $comission->type }}</td>
                                    <td class="text-center">{{ $comission->totalAmount }}</td>
                                    <td class="text-center">
                                        {{ $comission->created_at }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('comissionsDetails',$comission->type) }}" class="btn btn-info">Kazanç Detayı</a>
                                    </td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
</script>

@endsection
