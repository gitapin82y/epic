<!-- resources/views/pdf/document.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak SK Perizinan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    
  
    <style>
        body{
            font-family: Arial, sans-serif;
            width: 100%;
        }
        .table{
            margin-top: 200px;
        }
        .description{
            text-align: justify;
        }
    </style>
</head>
<body>
    <h5 class="text-center">Surat Perizinan</h5>

    <div class="text-left row mt-4 mb-4">
        No &nbsp;&nbsp;&nbsp;:&nbsp;&nbsp; {{$data->nomor_penerbitan}}
        <br>
        Hal &nbsp;&nbsp;:&nbsp;&nbsp; {{$data->namaPerizinan}}
    </div>
    @php
        use Carbon\Carbon;
    @endphp
    <div class="text-left row my-4">
        Yang Terhormat,<br>
        {{$data->nama_lengkap}}
    </div>

    <div class="row my-4">
        Berkaitan dengan pengajuan Anda, dengan ini kami sampaikan bahwa:
    </div>
    <div class="row my-4 pl-3">
        <table>
            <tr>
                <td style="width: 148px">
                    Nama
                </td>
                <td>:</td>
                <td style="padding-left: 24px">
                    {{$data->nama_lengkap}} 
                </td>
            </tr>
            <tr>
                <td style="width: 148px">
                    Email
                </td>
                <td>:</td>
                <td style="padding-left: 24px">
                    {{$data->email}} 
                </td>
            </tr>
            <tr>
                <td style="width: 148px">
                    Jenis Perizinan
                </td>
                <td>:</td>
                <td style="padding-left: 24px">
                    {{$data->namaPerizinan}}
                </td>
            </tr>
            <tr>
                <td style="width: 148px">
                    Kategori
                </td>
                <td>:</td>
                <td style="padding-left: 24px">
                    {{$data->kategori}}
                </td>
            </tr>
            <tr>
                <td style="width: 148px">
                    Nama Surat
                </td>
                <td>:</td>
                <td style="padding-left: 24px">
                    {{$data->nama}}
                </td>
            </tr>
            <tr>
                <td style="width: 148px">
                    Alamat
                </td>
                <td>:</td>
                <td style="padding-left: 24px">
                    {{$data->alamat_lokasi}}
                </td>
            </tr>
            <tr>
                <td style="width: 148px">
                    Tanggal Pengajuan
                </td>
                <td>:</td>
                <td style="padding-left: 24px">
                    {{Carbon::parse($data->created_at)->format('d F Y')}}
                </td>
            </tr>
        </table>
    </div>

    <div class="row my-4">
        Dengan ini hasil kami sertakan hasil dari survey sebagai berikut:
    </div>
    <div class="row my-4 pl-3">
        <table>
            <tr>
                <td style="width: 148px">
                    Nama Surveyor
                </td>
                <td>:</td>
                <td style="padding-left: 24px">
                    {{$survey->nama_lengkap}} 
                </td>
            </tr>
            <tr>
                <td style="width: 148px">
                    Tanggal Survey
                </td>
                <td>:</td>
                <td style="padding-left: 24px">
                    {{Carbon::parse($survey->jadwal_survey)->format('d F Y')}} 
                </td>
            </tr>
            <tr>
                <td style="width: 148px">
                    Hasil Survey
                </td>
                <td>:</td>
                <td style="padding-left: 24px">
                    Sudah Sesuai
                </td>
            </tr>
        </table>
    </div>



    <div class="row description">
        Surat perizinan ini mencerminkan komitmen kami untuk menyediakan layanan terbaik kepada setiap pemohon. Semoga surat ini bermanfaat dan memenuhi harapan anda. Kami berharap penerbitan ini dapat membantu mencapai tujuan yang diinginkan.
    </div>

    <div class="row text-right my-4">
        {{Carbon::parse($data->updated_at)->format('d F Y')}} <br>
        <p>Hormat Kami</p>
        <p class="mt-5 pt-2">Kepala Dinas</p>
    </div>


    <table class="table">
        <thead>
          <tr class="bg-info text-white">
            <th scope="col">No</th>
            <th scope="col">Nama Kelengkapan</th>
            <th scope="col" class="text-center">Kelengkapan</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($syarats as $key => $syarat)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$syarat->nama}}</td>
                <td class="text-center pt-4"><img src="{{ asset('assets/icon/check.png') }}" alt="checklist"></td>
            </tr>   
            @endforeach
        </tbody>
      </table>

</body>
</html>