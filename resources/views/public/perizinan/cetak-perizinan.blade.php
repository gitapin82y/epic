<!-- resources/views/pdf/document.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak SK Perizinan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.18.0/font/bootstrap-icons.css">
    
  
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
    <h5 class="text-center">Surat</h5>

    <div class="text-left row mt-4 mb-5">
        No &nbsp;&nbsp;&nbsp;:&nbsp;&nbsp; {{$data->nomor_penerbitan}}
        <br>
        Hal &nbsp;&nbsp;:&nbsp;&nbsp; {{$data->namaPerizinan}}
    </div>
    @php
        use Carbon\Carbon;
    @endphp
    <div class="text-left row my-5">
        Yang Terhormat,<br>
        {{$data->nama_lengkap}}
    </div>

    <div class="row my-4">
        Sehubungan dengan permohonan anda, dengan ini kami beritahukan bahwa:
    </div>
    <div class="row my-4 pl-3">
        Nama &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp; {{$data->nama_lengkap}} <br>
        Email &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp; {{$data->email}} <br>
        Kategori &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp; {{$data->kategori}} <br>
        Nama Instansi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp; {{$data->nama}} <br>
        Alamat Lokasi &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp; {{$data->alamat_lokasi}} <br>
        Tanggal Pengajuan &nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;{{Carbon::parse($data->created_at)->format('d F Y')}} <br>
    </div>


    <div class="row description">
        Kami mengucapkan terima kasih atas kepercayaan yang telah Saudara/i berikan. Penerbitan surat permohonan ini menjadi bukti komitmen kami dalam memberikan pelayanan terbaik kepada setiap pemohon. Semoga surat ini dapat memberikan manfaat dan memenuhi harapan Saudara/i.
        <br>
Kami juga ingin menyampaikan apresiasi kami atas kerjasama yang baik dari pihak Saudara/i selama proses pengajuan surat permohonan. Semua dokumen yang Saudara/i serahkan telah kami periksa dengan seksama, dan kami berharap bahwa penerbitan ini dapat membantu mencapai tujuan yang diinginkan.
    </div>

    <div class="row text-right my-4">
        {{Carbon::parse($data->updated_at)->format('d F Y')}} <br>
        Hormat Kami,
        <br><br><br><br>
        Admin Kepala Dinas
    </div>


    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Kelengkapan</th>
            <th scope="col">Kelengkapan</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($syarats as $key => $syarat)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$syarat->nama}}</td>
                <td><img src="{{ asset('assets/icon/checklist.png') }}" alt="checklist"></td>
            </tr>   
            @endforeach
        </tbody>
      </table>

</body>
</html>