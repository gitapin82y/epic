<!-- Modal -->
<div id="detail" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-warning py-4" style="background-color: #499DB1 !important">
        <h4 class="modal-title text-light">Detail Surat Perizinan</h4>
        <button type="button" class="close" data-dismiss="modal" onclick="closeModal()">&times;</button>
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
          <strong>Nama Pemohon</strong>
          <p id="nama_pemohon" class="mt-1"></p>
         </div>
         <div class="col-6">
          <strong>Email</strong>
          <p id="email" class="mt-1"></p>
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
          <button class="btn btn-warning btn-md w-100 mb-3 border-0 shadown-none" id="validasi" type="button"  style="background-color: #499DB1 !important">
         @if (Auth::user()->role_id == 5)
           
            Validasi
            @else 
            Verifikasi
            @endif
          </button>
          <button class="btn btn-md w-100 text-warning " id="showModalTolak" type="button"  style="color: #499DB1 !important; bg-color:white !important;border:1px solid #499DB1 !important;">
            Tolak
          </button>
        </div>
         @endif
         @if (Auth::user()->role_id == 3)
         <div class="col-12 mt-4">
          <input type="hidden" class="form-control form-control-sm id" name="id" id="id">
          <button class="btn btn-main btn-md w-100 mb-3 border-0 shadown-none" id="terbitkan" type="button"  style="background-color: #499DB1 !important">
        
            Terbitkan
          </button>
          <button class="btn btn-md w-100 text-warning " id="showModalTolakDiterbitkan" type="button"  style="color: #499DB1 !important; bg-color:white !important;border:1px solid #499DB1 !important;border-radius:25px">
            Tolak
          </button>
        </div>
         @endif
         {{-- surveyor --}}
         @if (Auth::user()->role_id == 7)
         <div class="col-12 mt-4">
          <a href="#" target="_blank" class="btn btn-main btn-md w-100 mb-3 border-0 text-white text-decoration-none shadown-none" id="template-laporan-survey" style="background-color: #499DB1 !important">
            Template Laporan Survey
          </a>
        </div>
         @endif
        </div>
      </div>
      </div>

  </div>
</div>
