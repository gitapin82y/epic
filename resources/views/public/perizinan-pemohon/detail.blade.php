<!-- Modal -->
<div id="detail" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-main text-white py-2">
        <h4 class="modal-title">Detail Surat Perizinan</h4>
        <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
      </div>
      <div class="modal-body bg-light">
        <div class="row table_modal">
         <div class="col-12">
          <strong>Jenis Perizinan</strong>
          <p id="jenis_perizinan" class="mt-1"></p>
         </div>
         <div class="col-6">
          <strong>Nomor Surat</strong>
          <p id="surat_id" class="mt-1"></p>
         </div>
         <div class="col-6">
          <strong>Status</strong><br>
          <b id="status_surat" class="mt-1"></b>
         </div>
         <div class="col-6">
          <strong>Tanggal</strong>
          <p id="tanggal_pengajuan" class="mt-1"></p>
         </div>
         <div class="col-6">
          <strong>Jadwal Survey</strong>
          <p id="jadwal_survey" class="mt-1"></p>
         </div>
         <div class="col-12">
          <strong>Alamat</strong>
          <p id="alamat_lokasi" class="mt-1"></p>
         </div>
         <div class="col-12">
          <strong>Dokumen Syarat Perizinan</strong>
         </div>
         <div class="col-12" id="nama_surat_syarat">
         </div>
         @if (Auth::user()->role_id == 5 || Auth::user()->role_id == 6)
         <div class="col-12">
          <input type="hidden" class="form-control form-control-sm id" name="id" id="id">
          <button class="btn btn-main btn-md w-100 mb-3" id="validasi" type="button">
         @if (Auth::user()->role_id == 5)
           
            Validasi
            @else 
            Verifikasi
            @endif
          </button>
          <button class="btn btn-light btn-md w-100 text-main border border-main" id="showModalTolak" type="button">
            Tolak
          </button>
        </div>
         @endif

        <div class="col-12">
          <a href="javascript:void(0)" target="_blank" class="btn btn-main w-100 mt-4" id="cetakNoRegis"
          >Cetak Nomor Registrasi</a
        >
        </div>


        <div class="col-12">
          <button class="btn btn-main w-100 mt-4" id="chatSurveyor" type="button" onclick="chatSurveyor()">
              Chat Surveyor
          </button>
        </div>

        <div class="col-12">
         <button class="btn btn-main w-100 mt-4" id="chatOperator" type="button" type="button" onclick="chatSurveyor({{$data->id}})">
            Chat Operator
         </button>
        </div>

        
        </div>
      </div>
      </div>

  </div>
</div>
