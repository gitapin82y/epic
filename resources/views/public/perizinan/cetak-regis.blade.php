<!-- resources/views/pdf/document.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Document</title>
    <style>
        body{
            font-family: Arial, sans-serif;
            background-color: #F3F8FB;
            width: 100%;
        }
        .card{
            position: relative;
            left: 50%;
            top: 45%;
            transform: translate(-50%,-50%);
            border-radius: 20px;
            padding: 40px 0px ;
            /* border-radius: 10px;
            margin-top: 10px */
            background-color: rgb(255, 255, 255);
            width: 80%;
            justify-coitemsntent: center;
            text-align: center;
        }
        .nomor{
            font-weight: bold;
            color: #499db1;
        }
    </style>
</head>
<body>
    <div class="card">
        <img src="{{asset('assets/public/img/logo.png')}}" alt="">
        <p>EPIC</p>
        <br>
        <img src="data:image/png;base64, {!! $qrcode !!}">
        <h4>Nomor Registrasi</h4>
        <h1 class="nomor">{{$data->id}}</h1>
        <h4>Nama Instansi</h4>
        <p>{{$data->nama}}</p>
        <h4>Jenis Perizinan</h4>
        <p>{{$namaPerizinan}}</p>
</div>
</body>
</html>