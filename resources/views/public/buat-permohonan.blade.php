@extends('layouts.public')
@section('title','Permohonan Saya')

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
id="buat-perizinan"
>
<div class="col-md-11 col-12">
  <div class="content row justify-content-between px-0">
    <h4 class="align-self-center fw-bold ms-2">Pilih Perizinan</h4>

    <div class="row justify-content-start ms-1">
      @foreach ($jenisPerizinanOptions as $jenisPerizinanOption)
      <a href="javascript:void(0)" class="jenis-perizinan-link option btn btn-white col-md-3 col-12 m-2" data-id="{{ $jenisPerizinanOption->id }}" data-nama="{{ $jenisPerizinanOption->nama }}" data-gambar-alur="{{ $jenisPerizinanOption->gambar_alur_permohonan }}">
          {{ $jenisPerizinanOption->nama }}
      </a>
    @endforeach
    </div>
    
  </div>

  <div id="showContent">
  <div class="content">
    <img src="" id="gambarAlur" class="w-100" alt="">
  </div>
  <div class="content px-5">
    <div class="row px-2 justify-content-between">
      <h4 class="align-self-center col-12 col-md-6">Panduan Permohonan Perizinan</h4>
      @if (Auth::check())
        <a href="#" class="btn ajukanPerizinan btn-main col-12 col-md-4 px-4 py-3"
        >Syarat Lengkap? Ajukan Permohonan</a
      >
      @else
      <a href="{{url('loginpemohon')}}" class="btn btn-main col-12 col-md-4 px-4 py-3"
      >Syarat Lengkap? Ajukan Permohonan</a
    >
      @endif

    </div>
    <div class="row mt-5">
      <table class="table" id="table_perizinan">
        <thead>
          <tr>
            <th scope="col" style="width: 100px;">No</th>
            <th scope="col">Syarat Perizinan</th>
          </tr>
        </thead>
        <tbody>
          {{-- data perizinan --}}
        </tbody>
      </table>
    </div>
  </div>
</div>

</div>
</div>
@endsection

@push('extra_script')
<script>
  $(".option").click(function (e) {
    $("#showContent").css({ opacity: 1 });
    $(".option").removeClass('btn-main');
    $(this).addClass('btn-main');
  });
</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  $(document).ready(function () {
        $('.jenis-perizinan-link').click(function (e) {
                e.preventDefault();

                var jenisPerizinanId = $(this).data('id');
                $('.ajukanPerizinan').attr('href', 'ajukan-perizinan?jenis=' + jenisPerizinanId);

                var namaPerizinan = $(this).data('nama');
                $('#namaPerizinan').html(namaPerizinan);

                var gambarAlur = $(this).data('gambar-alur');
                $('#gambarAlur').attr('src', gambarAlur);

                $.ajax({
                    type: 'GET',
                    url: 'get-data-perizinan',
                    data: {
                        jenis_perizinan: jenisPerizinanId
                    },
                    success: function (data) {
                        // Update tabel dengan data perizinan baru
                        updateTable(data);
                        
                    }
                });
            });

      function updateTable(data) {
          // Logika untuk memperbarui tabel dengan data perizinan baru
          // ...

          // Contoh sederhana: Menambahkan baris baru untuk setiap entri perizinan
          var table = $('#table_perizinan tbody');
          table.empty();

          
          $.each(data, function (index, item) {
              table.append('<tr><td style="width: 100px;">' + (index + 1) + '</td><td>' + item.nama + '<a href='+item.syarat_template+' target="__blank" class="text-main">( Lihat Template Dokumen )</a></td></tr>');
          });
      }
  });
</script>
@endpush
