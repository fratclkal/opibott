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
        .circle5,
        .circle4 {
            width: 70px;
            height: 70px;
        }
        .circle5 .images_wrapper img,
        .circle4 .images_wrapper img {
            margin: -16px 0 0;
        }
        .circle5 wrap_content,
        .circle4 .wrap_content{
            margin: 0 0 0 -15px;
        }

        .circle10,
        .circle11,
        .addCircle{
            width: 60px;
            height: 60px;
        }
        .circle10 .images_wrapper img,
        .circle11 .images_wrapper img,
        .addCircle .images_wrapper img {
            margin: -26px 0 0;
        }
        .circle10 .wrap_content,
        .circle11 .wrap_content,
        .addCircle .wrap_content{
            margin: -12px 0 0px -22px
        }
        .circle16,
        .circle15,
        .circle21,
        .circle40{
            width: 50px;
            height: 50px;
        }
        .circle16 .images_wrapper img,
        .circle15 .images_wrapper img,
        .circle21 .images_wrapper img,
        .circle40 .images_wrapper img {
            margin: -36px 0 0;
        }
        .circle16 .wrap_content,
        .circle15 .wrap_content,
        .circle21 .wrap_content,
        .circle40 .wrap_content{
            margin: -20px 0 0px -22px;
            font-size: 9px;
            width: 90px;
            min-width: 100%;
        }
        .circle21 .wrap_content,
        .circle40 .wrap_content{
            margin: 15px 0 0px -22px;
        }
        @media screen and (max-width: 750px) {

            .binary-genealogy-level-0 .no_padding.parent-wrapper{
                display: flex;
                align-items: flex-start;
                justify-content: center;
            }
            .no_padding.parent-wrapper .binary-level-width-100 {
                width: 900px;
                transform: scale(0.8);

            }
        }
        @media screen and (max-width: 600px) {
            .line2 .binar-hr-line-right,
            .line2 .binar-hr-line-left{
                width: 50px;
            }
            .line2 .binar-hr-line-right{
                margin-left: -22px;
            }
            .line2 .binar-hr-line-left{
                margin-right: -25px;

            }
            .line2 .binary-level-width-50,
            .line2 .binary-level-width-25,
            .line2 .binary-level-width-12,
            .line2 .binary-level-width-6 {
                width: 50px;
            }
        }
        @media screen and (max-width: 450px) {
            .line2{
                display: flex;
                justify-content: space-between;
            }
            .line2 .node-right-item{
                order:1;
            }
            .wrap_content {
                background: #836513;
                border-radius: 0px;
                color: #fff;
                display: block;
                font-size: 12px;
                height: auto;
                line-height: 23px;
                margin: 0 0 0 -4px;
                min-width: 100px;
                position: relative;
                width: auto;
                z-index: 1;
                width: 85px;
                font-size: 10px;
                min-width: 100%;
            }
            .circle5 wrap_content, .circle4 .wrap_content {
                margin: 0 0 0 -8px;
            }
            .circle10 .wrap_content, .circle11 .wrap_content, .addCircle .wrap_content {
                margin: -12px 0 0px -8px;
            }
        }

    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">Binary A??ac??</h4><span
                        class="text-muted mt-1 tx-13 ms-2 mb-0">/ Ekibim</span>

                </div>
                <p class="tx-12 mb-0 text-muted">Ekibinizin Binary yerle??imini g??rebilir ve ekleme yapabilirsiniz.</p>
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
