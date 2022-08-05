@extends('layouts.master')
@section('css')
    <link rel="stylesheet" href="{{ asset('/assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/css/tree.css') }}">
    <link rel="stylesheet" href="{{asset('accordion/assets/css/style.css')}}">
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
            <div id="data-div">

            </div>
            <div class="col-12 accordion">
                <h5 class="me-first"></h5>

                <ul class="accordion-menu" id="accordion_menu_1">

                </ul>
            </div>
        </div>
        <br><br><br><br><br><br><br>
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
    <script type="text/javascript" src="{{asset('accordion/assets/js/main.js')}}"></script>


    <script>
        var str = '';

            let first_item_name = $('.node-depth-0-name').html();
            $('.me-first').html(first_item_name);

            var id_arr = [];
            var child_data = {};

            $.each($('.parent-wrapper .clearfix'), function (index, value){
                if ($(value).attr('data-id-node-user')){
                    id_arr.push($(value).attr('data-id-node-user'));
                }
            });

            console.log(id_arr);

            var arr = [];

            $.each(id_arr, (index,value) => {

                arr[$('*[data-id-node-user-my="'+value+'"]').html()] = [];

                try {
                    arr[$('*[data-id-node-user-my="'+value+'"]').html()].push($('*[data-id-node-parent-user="'+value+'"] > .node-right-item .node-name-link')[0].innerHTML);
                }catch (e){
                    arr[$('*[data-id-node-user-my="'+value+'"]').html()].push('Boş');
                }
                try {
                    arr[$('*[data-id-node-user-my="'+value+'"]').html()].push($('*[data-id-node-parent-user="'+value+'"] > .node-left-item .node-name-link')[0].innerHTML);
                }catch (e){
                    arr[$('*[data-id-node-user-my="'+value+'"]').html()].push('Boş');
                }

                console.log('dsa');


            });
            var ids = [];
            $.each($('.node-name-link'), (index, value) => {
                ids[$(value).html()] = $(value).attr('data-id-node-user-my-sponsor-id');
            });




            makeTree(arr, first_item_name);

            console.log(str);
            $('#accordion_menu_1').html(str);

            init_accordion_tree(document.getElementById('accordion_menu_1'));



        function makeTree(arr_, item_name){
            $.each(arr_[item_name], (index,value) => {
                str += '<li>\n' +
                    '                        <a href="#/"><i onclick="openBinary('+ids[value]+')">Binary Tree Link - </i><p>'+value+'</p> <i data-sponsor-id="'+ids[value]+'" class="tooltipwork-responsive"> Data Link</i></a>\n';

                if (arr_[value]){
                    str += '<ul class="accordion-menu" >'
                    makeTree(arr_, value);
                    str += '</ul>\n';
                }

                str += '</li>\n';
            });
        }
        if ($(window).width() < 767)
        {
            $('.region-content').hide();
            $('#data-div').show();
            $('.accordion').show();
        }else{
            $('.region-content').show();
            $('#data-div').hide();
            $('.accordion').hide();
        }

        $( window ).resize(function() {
            if ($(window).width() < 767)
            {
                $('.region-content').hide();
                $('#data-div').show();
                $('.accordion').show();
            }else{
                $('.region-content').show();
                $('#data-div').hide();
                $('.accordion').hide();
            }
        });

        function openBinary(sponsor_id){
            let url = '{{route('SettlementTreeIndex')}}/' + sponsor_id;
            window.location.href = url;
        }

    </script>

@endsection
