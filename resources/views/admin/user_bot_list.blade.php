@extends('layouts.master')

@section('content')
<style type="text/css">
    #example1_wrapper{
        margin-top: 10px;
    } 
    .wd-mx-200{
        max-width: 200px;
    }
</style>
<div class="container-fluid">

                
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Kullanıcılar</h4><span
                    class="text-muted mt-1 tx-13 ms-2 mb-0">/ Kullanıcı Bot Bilgileri</span>
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
                        <h4 class="card-title mg-b-0">Kullanıcı Detay</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">Kullanıcı Bot Bilgileri</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive border-top userlist-table">
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-lg-8p"><span>ID</span></th>
                                    <th class="wd-lg-20p"><span>AD - SOYAD</span></th>
                                    <th class="wd-lg-20p"><span>EMAIL</span></th>
                                    <th class="wd-lg-20p"><span>BORSA</span></th>
                                    <th class="wd-lg-10p"><span>API KEY</span></th>
                                    <th class="wd-lg-10p"><span>API SECRET</span></th>
                                     <th class="wd-lg-5p"><span>Status</span></th> 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $key => $users)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $users->name }}</td>
                                    <td>{{ $users->email }}</td>
                                    <td>{{ $users->borsa }}</td>
                                    <td>{{ $users->api_key }}</td>
                                    <td>{{ $users->api_secret }}</td>
                                 
                                    <td class="text-{{ $users->status == 1 ? 'success' : 'danger' }} ms-2">
                                        {{ $users->status == 1 ? "Aktif" : "Pasif" }}
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
