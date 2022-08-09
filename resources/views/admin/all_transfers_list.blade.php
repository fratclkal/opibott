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
                <h4 class="content-title mb-0 my-auto">Ödemeler</h4><span
                    class="text-muted mt-1 tx-13 ms-2 mb-0">/ Onay İşlemleri</span>
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
                                    <th class="wd-lg-20p"><span>Adı Soyadı</span></th>
                                    <th class="wd-lg-20p"><span>Email</span></th>
                                    <th class="wd-lg-20p"><span>USDT Adresı</span></th>
                                    <th class="wd-lg-20p"><span>Tutar</span></th>
                                    <th class="wd-lg-20p"><span>Type</span></th>
                                    <th class="wd-lg-20p"><span>Tarih</span></th>
                                    <th class="wd-lg-20p">İşlem</th>
                                    <th class="wd-lg-20p">Seçenekler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transfer as $key => $transfers)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $transfers->name }}</td>
                                    <td>{{ $transfers->email }}</td>
                                    <td class="text-center">
                                        <span class="label text-muted d-flex">
                                            <div class="dot-label bg-gray-300 me-1"></div> {{ $transfers->wallet }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="label text-muted d-flex">
                                            <div class="dot-label bg-gray-300 me-1"></div> {{ (float)$transfers->amount /100*90 - 3 }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        {{ $transfers->type }}
                                    </td>
                                    <td class="text-center">
                                        {{ $transfers->created_at }}
                                    </td>
                                    <td class="text-{{ $transfers->status == 1 ? 'success' : ($transfers->status == 2 ? 'info' : ($transfers->status == 3 ? 'danger' : 'warning')) }} ms-2">
                                        {{ $transfers->status == 1 ? "Aktif" : ($transfers->status == 2 ? "Admin Onayında" : ($transfers->status == 3 ? "Reddedildi" : "Kullanıcı Mail Onayında")) }}
                                    </td>
                                    <td>
                                        @if($transfers->status != 1)
                                       <button class="btn btn-primary process-accept" data-id="{{$transfers->id}}">İşlem Tamamlandı</button>
                                        @endif
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <ul class="pagination mt-4 mb-0 float-end">
                        <li class="page-item page-prev disabled">
                            <a class="page-link" href="#" tabindex="-1">Prev</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                        <li class="page-item page-next">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
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

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    $('.process-accept').click(function (){
        let id = $(this).attr('data-id');

        Swal.fire({
            icon: "warning",
            title:"Emin misiniz?",
            html: "Bu işlemi onaylamak istediğinize emin misiniz?",
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonText: "Onayla",
            cancelButtonText: "İptal",
            cancelButtonColor: "#e30d0d"
        }).then((result)=> {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '{!! route('transfer_accept_manual') !!}',
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function () {
                        Swal.fire({
                            icon: "success",
                            title: "Başarılı",
                            showConfirmButton: true,
                            confirmButtonText: "Tamam"
                        });
                        window.location.reload();
                    },
                    error: function () {
                        Swal.fire({
                            icon: "error",
                            title: "Hata!",
                            html: "<div id=\"validation-errors\"></div>",
                            showConfirmButton: true,
                            confirmButtonText: "Tamam"
                        });
                        $.each(data.responseJSON.errors, function (key, value) {
                            $('#validation-errors').append('<div class="alert alert-danger">' + value + '</div>');
                        });
                    }
                })
            }
        });

    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

@endsection
