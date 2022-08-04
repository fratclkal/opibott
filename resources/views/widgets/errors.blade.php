@if ($errors->any())
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Başarılı!</strong>İşlem başarıyla gerçekleştirildi!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if(session('sendMailWithdraw'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Başarılı!</strong>Transfer talebiniz mail onayına gönderilmiştir, lütfen mailinizi kontrol ediniz!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if(session('succesDelete'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Başarılı!</strong>Transfer talebiniz başarıyla silinmiştir!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Hata!</strong> Beklenmedik bir hata oluştu!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session('errorpass'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Hata!</strong> Eski şifre eşleşmedi!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session('falseNickName'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Hata!</strong> Nickname daha önce kullanıldı!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session('not_found_user'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Hata!</strong> Kulanıcı bulunamadı!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session('errorpass'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Hata!</strong> Şifre yanlış girildi!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session('ballanceError'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Yetersiz Bakiye!</strong>Bu işlem için bakiyeniz yeterli değildir!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
