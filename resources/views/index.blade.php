@extends('layouts.master')

@section('content')

    <div class="container-fluid">

        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <div>
                    <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Hoşgeldiniz!</h2>
                </div>
            </div>
            <div class="main-dashboard-header-right">
                <div class="btn ripple btn-success-gradient" onclick="copyToClipboard()">
                    Referans Linki Kopyala!
                </div>
            </div>
        </div>
        <!-- breadcrumb -->

        <!-- row -->
        <div class="row row-sm">
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-primary-gradient">
                    <div class="ps-3 pt-3 pe-3 pb-2 pt-0">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">TOPLAM GELİR</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 fw-bold mb-1 text-white">{{ number_format(($referance_usdt + $binary_usdt + $matching_usdt) ,2) }}
                                        USDT</h4>
                                    <p class="mb-0 tx-12 text-white op-7">Bu güne kadar olan toplam geliriniz</p>
                                </div>
                                <span class="float-end my-auto ms-auto">
                                <i class="fas fa-arrow-circle-up text-white"></i>
                                <span class="text-white op-7"></span>
                            </span>
                            </div>
                        </div>
                    </div>
                    <span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-danger-gradient">
                    <div class="ps-3 pt-3 pe-3 pb-2 pt-0">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">REFERANS GELİRİ</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 fw-bold mb-1 text-white">{{ number_format(($referance_usdt) ,2) }}
                                        USDT</h4>
                                    <p class="mb-0 tx-12 text-white op-7">Bu güne kadar olan toplam referans
                                        geliriniz</p>
                                </div>
                                <span class="float-end my-auto ms-auto">
                                <i class="fas fa-arrow-circle-up text-white"></i>
                                <span class="text-white op-7"></span>
                            </span>
                            </div>
                        </div>
                    </div>
                    <span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-success-gradient">
                    <div class="ps-3 pt-3 pe-3 pb-2 pt-0">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">BINARY GELİRİ</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 fw-bold mb-1 text-white">{{ number_format(($binary_usdt) ,2) }}
                                        USDT</h4>
                                    <p class="mb-0 tx-12 text-white op-7">Bu güne kadar olan toplam binary geliriniz</p>
                                </div>
                                <span class="float-end my-auto ms-auto">
                                <i class="fas fa-arrow-circle-up text-white"></i>
                                <span class="text-white op-7"></span>
                            </span>
                            </div>
                        </div>
                    </div>
                    <span id="compositeline3"
                          class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
                <div class="card overflow-hidden sales-card bg-warning-gradient">
                    <div class="ps-3 pt-3 pe-3 pb-2 pt-0">
                        <div class="">
                            <h6 class="mb-3 tx-12 text-white">MATCHING GELİRİ</h6>
                        </div>
                        <div class="pb-0 mt-0">
                            <div class="d-flex">
                                <div class="">
                                    <h4 class="tx-20 fw-bold mb-1 text-white">{{ number_format(($matching_usdt) ,2) }}
                                        USDT</h4>
                                    <p class="mb-0 tx-12 text-white op-7">Bu güne kadar olan toplam matching
                                        geliriniz</p>
                                </div>
                                <span class="float-end my-auto ms-auto">
                                <i class="fas fa-arrow-circle-up text-white"></i>
                                <span class="text-white op-7"></span>
                            </span>
                            </div>
                        </div>
                    </div>
                    <span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
                </div>
            </div>
        </div>
        <div class="row row-sm">
            @if(auth()->user()->payment == 1)
                <div class="col-lg-6 col-md-6 col-xl-4">
                    <!--Page Widget Error-->
                    <div class="card bd-0 mg-b-20">
                        <div class="card-body text-success">
                            <div class="main-error-wrapper">
                                <i class="si si-check mg-b-20 tx-50"></i>
                                <h4 class="mg-b-20">Botunuz Aktif</h4>
                                <a class="btn btn-outline-success btn-sm" href="#">Detaylar için tıklayınız</a>
                            </div>
                        </div>
                    </div>
                    @else
                        <div class="col-lg-6 col-md-6 col-xl-4">
                            Page Widget Error
                            <div class="card bd-0 mg-b-20">
                                <div class="card-body text-danger">
                                    <div class="main-error-wrapper">
                                        <i class="si si-close mg-b-20 tx-50"></i>
                                        <h4 class="mg-b-20">Botunuz Aktif Değil</h4>
                                        <a class="btn btn-outline-danger btn-sm" href="/pricing">Aktif etmek için
                                            tıklayınız</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <!--Page Widget Error-->
                        </div>
                        <div class="col-sm-12 col-md-12 col-xl-4 col-lg-6">
                            <div class="card custom-card">
                                <div class="card-body text-center">
                                    <div>
                                        <h6 class="card-title">Botunuzun Bitiş Süresi</h6>
                                    </div>
                                    <img src="assets/img/media/illustrate1.png" alt="counter-image"
                                         class="wd-160 ht-160 ">
                                    <div class="mt-3">
                                        <span id="timer-countinbetween" class="tx-26 mb-0"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-12 col-lg-6 col-sm-12">
						<div class="card">
							<div class="card-body">
								<div class="plan-card text-center">
									<i class="fas fa-thumbs-up plan-icon text-primary"></i>
									<h6 class="text-drak text-uppercase mt-2">Kariyeriniz</h6>
									<h2 class="mb-2">{{ Auth::user()->career == 1 ? "1.Kariyer" :  (Auth::user()->career=='2' ?  '2.Kariyer': (Auth::user()->career=='3' ?  '3.Kariyer': 'Starter') ) }}</h2>
									
									<span class="text-muted">Daha üst kariyerlerde Matching kazançları artmaktadır.</span>
								</div>
							</div>
						</div>
					</div>
                </div>
                <!-- row closed -->

                <!-- row closed -->

                <!-- row opened -->
                <div class="row row-sm">
                    <div class="col-xl-4 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header pb-1">
                                <h3 class="card-title mb-2">Son Ekip Kayıtları</h3>
                                <p class="tx-12 mb-0 text-muted">Ekibine yeni dahil olan kişilerin detaylarını
                                    görebilirsiniz.</p>
                            </div>
                            <div class="card-body p-0 customers mt-1">
                                <div class="list-group list-lg-group list-group-flush">
                                    @foreach($lastTeamMembers as $lastTeamMember)
                                        <div class="list-group-item list-group-item-action" href="#0">
                                            <div class="media mt-0">
                                                <img class="avatar-lg rounded-circle my-auto me-3"
                                                     src="assets/img/faces/user.png"
                                                     alt="Image description">
                                                <div class="media-body">
                                                    <div class="d-flex align-items-center">
                                                        <div class="mt-0">
                                                            <h5 class="mb-1 tx-15">{{ $lastTeamMember->name }}</h5>
                                                            <p class="mb-0 tx-13 text-muted">Ref
                                                                ID: {{ $lastTeamMember->sponsor_id }} </p>
                                                        </div>
                                                        <span class="ms-auto wd-45p fs-16 mt-2">
                                            <span class="text-{{ $lastTeamMember->payment == 1 ? 'success' : 'danger' }} ms-2">{{ $lastTeamMember->payment == 1 ? "Aktif" : "Pasif" }}</span>
                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-12 col-lg-6">
                        <div class="card">
                            <div class="card-header pb-1">
                                <h3 class="card-title mb-2">Son Kazançlar</h3>
                                <p class="tx-12 mb-0 text-muted">Sistemden elde ettiğiniz son gelirlerin özetlerini
                                    takip
                                    edebilirsiniz.
                                    Detaylar için cüzdan bölümünü inceleyiniz
                                </p>
                            </div>
                            <div class="product-timeline card-body pt-2 mt-1">
                                <ul class="timeline-1 mb-0">
                                    @foreach($comissions as $comission)
                                        <li class="mt-0" id="mrg-8"><i
                                                    class="ti-pie-chart bg-primary-gradient text-white product-icon"></i>
                                            <span
                                                    class="fw-semibold mb-4 tx-14 ">{{ $comission->type }} Geliri</span>
                                            <p class="mb-0 text-muted tx-12">{{ $comission->usd_amount }} USDT </p>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-12 col-lg-6">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h3 class="card-title mb-2">Flash Out</h3>
                                <p class="tx-12 mb-0 text-muted">Günlük max 1000 $ Binary ve Matching geliri durumunu
                                    takip
                                    edebilirsiniz. </p>
                            </div>
                            <div class="card-body sales-info ot-0 pb-0 pt-0">
                                <div id="chartFlashOut" class="ht-150"></div>
                                <div class="row sales-infomation pb-0 mb-0 mx-auto wd-100p">
                                    <div class="col-md-3 col">
                                        <p class="mb-0 d-flex"><span class="legend bg-primary brround"></span>Kazanılan
                                        </p>
                                        <h3 class="mb-1">{{ $flashOut }} $</h3>
                                        <div class="d-flex">
                                            <p class="text-muted ">Son 24 saat</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col"></div>
                                    <div class="col-md-3 col">
                                        <p class="mb-0 d-flex"><span class="legend bg-info brround"></span>Kalan</p>
                                        <h3 class="mb-1">{{ $kalanFlashOut }} $</h3>
                                        <div class="d-flex">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--    <div class="card ">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center pb-2">
                                                <p class="mb-0">Total Sales</p>
                                            </div>
                                            <h4 class="fw-bold mb-2">$7,590</h4>
                                            <div class="progress progress-style progress-sm">
                                                <div class="progress-bar bg-primary-gradient wd-80p" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="78"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-4 mt-md-0">
                                            <div class="d-flex align-items-center pb-2">
                                                <p class="mb-0">Active Users</p>
                                            </div>
                                            <h4 class="fw-bold mb-2">$5,460</h4>
                                            <div class="progress progress-style progress-sm">
                                                <div class="progress-bar bg-danger-gradient wd-75" role="progressbar"  aria-valuenow="45" aria-valuemin="0" aria-valuemax="45"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                    </div>
                </div>
                <!-- row close -->


        </div>
        @endsection
        @section('js')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
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
                var flashout = Number('{{ $flashOut }}');
                var flashoutPercent = flashout/10;
                
                var options = {
                  series: [flashoutPercent],
                  chart: {
                  height: 350,
                  type: 'radialBar',
                  offsetY: -10
                },
                plotOptions: {
                  radialBar: {
                    startAngle: -135,
                    endAngle: 135,
                    dataLabels: {
                      name: {
                        fontSize: '16px',
                        color: undefined,
                        offsetY: 120
                      },
                      value: {
                        offsetY: 76,
                        fontSize: '22px',
                        color: undefined,
                        formatter: function (val) {
                          return val + "%";
                        }
                      }
                    }
                  }
                },
                fill: {
                  type: 'gradient',
                  gradient: {
                      shade: 'dark',
                      shadeIntensity: 0.15,
                      inverseColors: false,
                      opacityFrom: 1,
                      opacityTo: 1,
                      stops: [0, 50, 65, 91]
                  },
                },
                stroke: {
                  dashArray: 4
                },
                labels: ['Flash Out'],
                };

                var chart = new ApexCharts(document.querySelector("#chartFlashOut"), options);
                chart.render();
            </script>

@endsection
