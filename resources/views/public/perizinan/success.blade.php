@extends('layouts.public')
@section('title','Ajukan Syarat Perizinan')

@push('extra_style')
<style>
    body {
      background-color: #f3f8fb;
    }
  </style>
@endpush

@section('content')
<div
class="row col-12 justify-content-center mt-5 pt-5"
id="berhasil-mengajukan"
>
<div class="col-md-6 col-12">
  <div class="content row justify-content-center text-center">
    <img src="{{'assets/public/icon/success.png'}}" style="width:300px;" alt="" />
    <h3 class="align-self-center mt-4">
      Permohonan Perizinan Berhasil Diajukan
    </h3>
    <div class="col-12">
      <a href="generate-pdf?noSurat={{ request()->input('noSurat') }}" target="_blank" class="btn btn-main w-100 mt-4"
        >Cetak Nomor Registrasi</a
      >
    </div>
    <div class="col-12">
      
      <a href="{{route('list-perizinan')}}" class="btn btn-white w-100 mt-4"
        >Lihat Permohonan</a
      >
    </div>
  </div>
</div>
</div>
@endsection
