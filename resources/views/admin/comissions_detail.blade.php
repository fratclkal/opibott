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
                <h4 class="content-title mb-0 my-auto">{{ \App\Models\User::userNameGet($user_id) }} {{ strtoupper($type) }} Kazançları</h4><span
                    class="text-muted mt-1 tx-13 ms-2 mb-0">/ Tüm {{ strtoupper($type) }} Kazançlar</span>
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
                        <h4 class="card-title mg-b-0">{{ \App\Models\User::userNameGet($user_id) }} {{ strtoupper($type) }} Kazançları</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">{{ \App\Models\User::userNameGet($user_id) }} {{ strtoupper($type) }} Kazanç Detayları</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive border-top userlist-table">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-lg-8p"><span>Id</span></th>
                                    <th class="wd-lg-20p"><span>Adı Soyadı</span></th>
                                    <th class="wd-lg-20p"><span>Email</span></th>
                                    <th class="wd-lg-20p"><span>Tutar</span></th>
                                    <th class="wd-lg-20p"><span>Tarih</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($comissions as $key => $comission)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $comission->name }}</td>
                                    <td>{{ $comission->email }}</td>
                                    <td class="text-center text-warning"> {{ (float)$comission->usd_amount }} $
                                        
                                    </td>
                                    <td class="text-center">
                                        {{ $comission->created_at }}
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
