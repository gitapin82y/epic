@extends('layouts.public')
@section('title','Lacak Perizinan')

@push('extra_style')
<style>
body {
    background-color: #f3f8fb;
  }
</style>
@endpush

@section('content')
<div class="row col-12 justify-content-center" id="lacak-perizinan">
    <div class="col-md-6 col-12">
      <div class="content">
        <h3 class="text-center">Lacak Perizinan</h3>
        <form id="trackPermissionForm">
          @csrf
          <div class="form-group mb-5 mt-4">
            <label for="no_regis">Nomor Surat</label>
            <input
              type="text"
              class="form-control"
              id="no_regis"
              name="no_regis"
              aria-describedby="emailHelp"
            />
            <div class="invalid-feedback" id="errorContainer"></div>
          </div>
          <button
            type="button"
            class="btn btn-main mt-5 w-100" id="trackPermissionBtn"
          >
            Lacak Perizinan
          </button>
        </form>
      </div>
    </div>
  </div>


      <!-- Modal -->
      <div class="modal fade" id="permissionModal" tabindex="-1" aria-labelledby="permissionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-main text-white">
                    <h5 class="modal-title" id="permissionModalLabel">Hasil Lacak Perizinan</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <div
                  class="row col-12 justify-content-center mt-2"
                  id="detail-perizinan"
                  >
                  <div class="col-12">
                    <div class="content border-main">
                      <h4 class="text-center">Status</h4>
                      <h1 class="text-center text-main status"></h1>
                    </div>
                    <div class="content border-main">
                      <div class="mb-3">
                        <h4 class="text-center">Nomor Registrasi</h4>
                        <h1 class="text-center no_surat text-main"></h1>
                      </div>
                      <div class="my-3">
                        <h5 class="text-center">Jenis Perizinan</h5>
                        <p class="text-center nama_perizinan"></p>
                      </div>
                      <div class="my-3">
                        <h5 class="text-center">Tanggal</h5>
                        <p class="text-center tanggal"></p>
                      </div>
                      <div class="my-3">
                        <h5 class="text-center">Alamat</h5>
                        <p class="text-center alamat">
                        </p>
                      </div>
                      <div class="my-3">
                        <h5 class="text-center">Jadwal Survey</h5>
                        <p class="text-center jadwal_survey"></p>
                      </div>
                    </div>
                  </div>
                  </div>
                </div>
            </div>
        </div>
    </div>

  
@endsection

{{-- {{(!$data->jadwal_survey) ? 'Belum Tersedia' : $data->jadwal_survey}} --}}
@push('extra_script')
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

<script
src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
crossorigin="anonymous"
></script>
<script>
  
  $(document).ready(function () {
      $('#trackPermissionBtn').on('click', function () {
          var no_regis = $('#no_regis').val();
          $('#errorContainer').empty();

          $.ajax({
              url: baseUrl+'/lacak-perizinan',
              type: 'POST',
              data: { _token: "{{ csrf_token() }}", no_regis: no_regis },
              success: function (response) {
                console.log(response);
                  if (response.status == 'success') {
                    $('.status').html(response.data.status);
                    $('.no_surat').html(response.data.id);
                    $('.nama_perizinan').html(response.data.nama_perizinan);
                    $('.tanggal').html(response.data.created_at);
                    $('.alamat').html(response.data.alamat_lokasi);
                    if(response.data.jadwal_survey !== null){
                      $('.jadwal_survey').html(response.data.jadwal_survey);
                    }else{
                      $('.jadwal_survey').html('Belum Tersedia');
                    }
                      $('#permissionModal').modal('show');
                  } else {
                      $('#errorContainer').text(response.message);
                      $('#no_regis').addClass('is-invalid');
                  }
              },
              error: function (xhr, textStatus, errorThrown) {
                  console.log(xhr.responseText);
              }
          });
      });

      // Clear validation on input focus
      $('#no_regis').on('focus', function () {
          $('#errorContainer').empty();
          $(this).removeClass('is-invalid');
      });
  });
</script>
@endpush
