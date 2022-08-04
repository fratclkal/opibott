<div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
<aside class="app-sidebar sidebar-scroll">
    <div class="main-sidebar-header active">
        <a class="desktop-logo logo-light active" href="index.html"><img src="/assets/img/brand/opbotlogo.png" class="main-logo" alt="logo"></a>
        <a class="desktop-logo logo-dark active" href="index.html"><img src="/assets/img/brand/opbotlogo.png" class="main-logo dark-theme" alt="logo"></a>
        <a class="logo-icon mobile-logo icon-light active" href="index.html"><img src="/assets/img/brand/opbotlogo.png" class="logo-icon" alt="logo"></a>
        <a class="logo-icon mobile-logo icon-dark active" href="index.html"><img src="/assets/img/brand/opbotlogo.png" class="logo-icon dark-theme" alt="logo"></a>
    </div>
    <div class="main-sidemenu">
        <div class="app-sidebar__user clearfix">
            <div class="dropdown user-pro-body">
                <div class="">
                    <img alt="user-img" class="avatar avatar-xl brround" src="/assets/img/faces/user.png"><span class="avatar-status profile-status bg-green"></span>
                </div>
                <div class="user-info">
                    <h4 class="fw-semibold mt-3 mb-0">{{ Auth::user()->name }}</h4>
                    <span class="mb-0 text-muted">Hoşgeldiniz</span>
                </div>
            </div>
        </div>
        <ul class="side-menu">
            <li class="side-item side-item-category ">OpiBot</li>
           
            <li class="slide">
                <a class="side-menu__item" href="/homePage"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/><path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/></svg><span class="side-menu__label">Dashboard</span><span class="badge bg-success text-light" id="bg-side-text"></span></a>
            </li>
            @if(Auth::user()->payment == '1' )
            <li class="side-item side-item-category">Hesabım</li>
            <li class="slide">
                <a class="side-menu__item" href="/profile"><i class="fa fa-user  me-2"></i><span class="side-menu__label">Profilim</span></a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('user_bot_settings') }}"><i class="fe fe-settings  me-2"></i><span class="side-menu__label">Bot Ayarları</span></a>
            </li>   
            @endif
            @if(Auth::user()->payment == '1' )
            <li class="side-item side-item-category">Ekibim</li>
             <li class="slide">
                <a class="side-menu__item" href="{{ route('teamList') }}"><i class="fa fa-users  me-2"></i><span class="side-menu__label">Ekibim</span></a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('SettlementTreeIndex') }}"><i class="fa fa-sitemap  me-2"></i><span class="side-menu__label">Binary Ağacı</span></a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('AwaitingSettlement') }}"><i class="fa fa-balance-scale  me-2"></i><span class="side-menu__label">Bekleyen Yerleşimler</span></a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('myteam') }}"><i class="fa fa-user-plus  me-2"></i><span class="side-menu__label">Aktif/Pasif Kayıtlar</span></a>
            </li>
            @endif
            <li class="slide">
                <a class="side-menu__item" href="/pricing"><i class="fa fa-arrow-circle-up  me-2"></i><span class="side-menu__label">Paket Yükselt</span></a>
            </li>

            @if(Auth::user()->payment == '1' )
            <li class="side-item side-item-category">Cüzdan</li>
            <li class="slide">
                <a class="side-menu__item" href="/wallet"><i class="fa fa-wallet  me-2"></i><span class="side-menu__label">Cüzdanım</span></a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('myWallets') }}"><i class="fa fa-wallet  me-2"></i><span class="side-menu__label">Adreslerim</span></a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('allComissions') }}"><i class="fa fa-signal  me-2"></i><span class="side-menu__label">Kazanç Detay</span></a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="#"><i class="fa fa-recycle  me-2"></i><span class="side-menu__label">Matching Detay</span></a>
            </li>
            @endif
            
            @if(Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
            <li class="side-item side-item-category">Admin</li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('payment_list') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/><path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/></svg>
                    <span class="side-menu__label">Onay Bekleyen Ödemeler</span>
                    <span class="badge bg-success text-light" id="bg-side-text"></span>
                </a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('transfer_list') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/><path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/></svg>
                    <span class="side-menu__label">Onay Bekleyen Transferler</span>
                    <span class="badge bg-success text-light" id="bg-side-text"></span>
                </a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('all_transfer_list') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/><path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/></svg>
                    <span class="side-menu__label">Tüm Transferler</span>
                    <span class="badge bg-success text-light" id="bg-side-text"></span>
                </a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('user_list') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/><path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/></svg>
                    <span class="side-menu__label">Tüm Kullanıcılar</span>
                    <span class="badge bg-success text-light" id="bg-side-text"></span>
                </a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('user_bot_list') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/><path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/></svg>
                    <span class="side-menu__label">Kullanıcı Bot Bilgileri</span>
                    <span class="badge bg-success text-light" id="bg-side-text"></span>
                </a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('users_comissions') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/><path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/></svg>
                    <span class="side-menu__label">Tüm Kullanıcı Kazançları</span>
                    <span class="badge bg-success text-light" id="bg-side-text"></span>
                </a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('users_balance') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/><path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/></svg>
                    <span class="side-menu__label">Kullanıcı Bakiyeleri</span>
                    <span class="badge bg-success text-light" id="bg-side-text"></span>
                </a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{ route('total_turnover') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/><path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/></svg>
                    <span class="side-menu__label">Gelir - Gider Detayları</span>
                    <span class="badge bg-success text-light" id="bg-side-text"></span>
                </a>
            </li>

            @endif
         <br>
         <br>
         <br>
        </ul>
    </div>
</aside>