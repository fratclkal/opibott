<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<h1>Sevgili {{$data["name"]}}, yeni transfer talebin oluşturulmuştur!</h1>
<hr/>
<p>
    <b>Transfer edilecek cüzdan:</b> <span>{{$data["wallet"]}}</span>
</p>
<p>
    <b>Transfer edilecek tutar:</b> <span>{{$data["amount"]}} USDT</span>
</p>
<p>
    <b>Kesilecek transfer ücreti:</b> <span>{{$data["fee"]}} USDT</span>
</p>
<p>
    <a href="{{route('withdraw_mail_confirmation',$data["withdraw_id"],$data["token"])}}" target="_blank">Onaylamak için lütfen tıklayınız</a>
</p>
</body>
</html>
