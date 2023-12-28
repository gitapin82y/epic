@extends('layouts.public')
@section('title','Ajukan Syarat Perizinan')

@push('extra_style')
<style>
    body {
      background-color: #f3f8fb;
    }
    .inputfile {
      width: 0.1px;
      height: 0.1px;
      opacity: 0;
      overflow: hidden;
      position: absolute;
      z-index: -1;
    }
    .inputfile + label {
      font-weight: 300;
      color: black;
      border-radius: 10px;
      border: 1px solid rgb(179, 179, 179);
      background-color: white;
      display: inline-block;
    }
    .inputfile + label * {
      pointer-events: none;
    }
    .inputfile + label {
      cursor: pointer; /* "hand" cursor */
    }
    .inputfile:focus + label {
      outline: 1px dotted #000;
      outline: -webkit-focus-ring-color auto 5px;
    }
  </style>
@endpush

@section('content')

<div
class="row col-12 justify-content-center mt-5 pt-5"
id="ajukan-perizinan"
>
<div class="col-md-6 col-12">
  <div class="content mt-5">
    <h3 class="text-center mb-5">Upload Dokumen Syarat <br> 
      <div id="jenis_perizinan" class="mt-2"></div>
    </h3>
    <form id="form2" action="create-perizinan" method="post" enctype="multipart/form-data">
      @csrf

      <div id="syarat_perizinan_container"></div>

      <button
        type="submit"
        class="btn btn-main mt-2 w-100"
      >
        Ajukan Perizinan
      </button>
    </form>
  </div>
</div>
</div>
@endsection

@push('extra_script')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  $(document).ready(function () {
    
      var form1Data = JSON.parse(sessionStorage.getItem('form1Data'));
      $('#jenis_perizinan').html(form1Data[1].value);

      var jenisPerizinan = form1Data.find(item => item.name === 'surat_jenis_id').value;
      getSyaratPerizinan(jenisPerizinan);

      $('#form2').submit(function (e) {
          e.preventDefault();

          // Simpan data dari form 1 dan dokumen ke database
          var formData = new FormData(this);
          formData.append('id', form1Data.find(item => item.name === 'id').value);
          formData.append('surat_jenis_id', form1Data.find(item => item.name === 'surat_jenis_id').value);
          formData.append('nama', form1Data.find(item => item.name === 'nama').value);
          formData.append('kategori', form1Data.find(item => item.name === 'kategori').value);
          formData.append('alamat_lokasi', form1Data.find(item => item.name === 'alamat_lokasi').value);
          formData.append('longitude', form1Data.find(item => item.name === 'longitude').value);
          formData.append('latitude', form1Data.find(item => item.name === 'latitude').value);
          console.log(formData);

          $.ajax({
              type: 'POST',
              url: 'create-perizinan',
              data: formData,
              contentType: false,
              processData: false,
              success: function (response) {
                  sessionStorage.removeItem('form1Data');
                  window.location.href = 'perizinan-berhasil-diajukan?noSurat='+response.suratId;
              },
              error: function (error) {
                  console.error(error);
                  alert('Terjadi kesalahan saat menyimpan data.');
              }
          });
      });


        // Fungsi untuk mendapatkan syarat perizinan dari server
        function getSyaratPerizinan(jenisPerizinan) {
                $.ajax({
                    type: 'GET',
                    url: 'get-data-perizinan',
                    data: {
                        jenis_perizinan: jenisPerizinan
                    },
                    success: function (data) {
                        // Tampilkan syarat perizinan di dalam container
                        displaySyaratPerizinan(data);
                    },
                    error: function (error) {
                        console.error(error);
                        alert('Terjadi kesalahan saat mengambil data syarat perizinan.');
                    }
                });
            }

            // Fungsi untuk menampilkan syarat perizinan dalam bentuk label dan input file
            function displaySyaratPerizinan(syaratPerizinan) {
                var container = $('#syarat_perizinan_container');
                container.empty();

                // Iterasi melalui data syaratPerizinan dan tampilkan label dan input file
                $.each(syaratPerizinan, function (index, item) {
                    container.append(' <div class="form-group mb-5"><label for="syarat' + (index + 1) + '">' + item.nama + ':</label><div class="d-flex mt-2"><input type="file" class="form-control" name="syarat' + (index + 1) + '" required accept=".pdf, .jpg, .jpeg, .png"> <a href="'+item.syarat_template+'" target="_blank"><img src="assets/public/icon/lihat-template-syarat.png" class="ms-2" width="38px"></a></div></div>');
                });
            }
  });
</script>
@endpush
