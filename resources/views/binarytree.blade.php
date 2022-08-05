@extends('layouts.master')
@section('css')
    <link rel="stylesheet" href="{{ asset('/assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/tree.css') }}">
    <style>
        .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; }
        .se-pre-con {
            display: none;
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('https://panel.opibot.io/assets/load2.gif') center no-repeat #fff;
        }

    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">Binary Ağacı</h4><span
                        class="text-muted mt-1 tx-13 ms-2 mb-0">/ Ekibim</span>

                </div>
                <p class="tx-12 mb-0 text-muted">Ekibinizin Binary yerleşimini görebilir ve ekleme yapabilirsiniz.</p>
            </div>

        </div>
        <!-- Row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="region region-content">
                    <div id="block-system-main" class="block block-system clearfix">
                        <div class="binary-genealogy-tree binary_tree_extended">
                            <div class="binary-genealogy-level-0 clearfix">
                                <div class="no_padding parent-wrapper clearfix">
                                    <div class="node-centere-item binary-level-width-100">
                                        {{\App\Http\Controllers\PageController\TeamController::createTree($usersData,$allTree,$teamTreeCode,$teamTreeCode,$countryList,$addTreeWeeCode,$allCareerList,$searchWeeCode)}}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
        <div class="se-pre-con"></div>
    </div>

@endsection
@section('js')
    <script>
        function goBack() {
            window.history.back()
        }
    </script>
    <script src="{{ asset('/assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('/assets/js/settlement_tree.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
    <script>
        $('.hide-button').on('click', function() {
            $(".se-pre-con").css("display", "block");
        });
        let error = `{{ Session::get('error') }}`;
        if(error){
            swal('', error, 'warning');
        }
    </script>

@endsection
