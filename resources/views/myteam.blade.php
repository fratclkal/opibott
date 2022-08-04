@extends('layouts.master')
@section('css')
    <link rel="stylesheet" href="{{ asset('/assets/css/jquery-ui.css') }}">
    <style type="text/css">
        .si-minus{
            display: none !important;
        }
        .si-plus{
            margin-right: 3px;
        }
    </style>
@endsection
@section('content')

<div class="container-fluid">
                
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">Ekibim</h4><span
                    class="text-muted mt-1 tx-13 ms-2 mb-0">/ Ekip Yerleşimi</span>
            </div>
            <p class="mg-b-20">Tüm ekibinizin yerleşimini ve detaylarını görebilirsiniz.</p>
        </div>
         
    </div>
    <!-- breadcrumb -->

    <!-- row -->
    <div class="row">
        <div class="col-md-12">
             
            <div class="card">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        Tüm ekibinizin yerleşimini ve detaylarını görebilirsiniz
                    </div>
                    <p class="mg-b-20">Ekip dağılımını görmek için + butonuna tıklayabilirsiniz.</p>
                    <div class="row">
                         @if(isset($users[Auth::user()->sponsor_id]) AND !empty($users[Auth::user()->sponsor_id]) )
                        <div class="container-fluid animatedParent animateOnce my-3">

                            <div class="card">
                                <div class="tab-content my-3" id="v-pills-tabContent">
                                    <div class="tab-pane animated fadeInUpShort show active" id="v-pills-all" role="tabpanel" aria-labelledby="v-pills-all-tab">
                                        <div class="row my-3">
                                            <div class="col-md-12">
                                                <div class="teamlist">
                                                    <ul class="accordion" style="list-style: none;">
                                                        @foreach($users[Auth::user()->sponsor_id] as $write)
                                                            <?php
                                                            $icon=null;
                                                                $icon='<i class="si si si-plus "></i>';
                                                            //}
                                                            ?>

                                                            <li style="display: flex">

                                                                <a href="javascript:;" class="clicks" id="{{ $write['id'] }}"><i class="si si si-plus "></i></a>{{ $write['fullname'] }}
                                                            </li>

                                                        @endforeach
                                                    </ul>
                                                </div>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="container-fluid pt-5">
                            <div class="text-center p-5">
                                <i class="icon-note-important s-64 text-primary"></i>
                                <h4 class="my-3">Ekibiniz yok</h4>
                                <p>Ekip oluşturmak için aşağıdaki butona tıklayın</p>
                                <a href="{{ route('addNewMemberIndex') }}" class="btn btn-primary shadow btn-lg"><i class="icon-plus-circle mr-2 "></i>Yeni bayi kaydet</a>
                            </div>
                        </div>
                    @endif

                     

                         
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row -->


</div>

@endsection
@section('js')
<script src="{{ asset('/assets/js/team.js') }}"></script>
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
