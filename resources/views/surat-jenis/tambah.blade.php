<!-- Modal -->
<div id="tambah" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xs">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-warning" style="background-color: #499DB1 !important">
        <h4 class="modal-title text-light">Form Surat Jenis</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form id="form1" enctype="multipart/form-data">
        {{-- @csrf
        @method('post') --}}
      <div class="modal-body">
        <div class="row">
          <table class="table table_modal">
          <tr>
            <td>Nama Surat Jenis</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext nama" name="nama">
              <input type="hidden" class="form-control form-control-sm id" name="id">
            </td>
          </tr>
          <tr>
            <td>Template Dokumen Survey</td>
            <td>
              <input type="file" class="form-control form-control-sm inputtext dokumen_survey_template" name="dokumen_survey_template">
            </td>
          </tr>
          <tr>
            <td>Gambar Alur Permohonan</td>
            <td>
              <input type="file" class="form-control form-control-sm inputtext gambar_alur_permohonan" name="gambar_alur_permohonan">
            </td>
          </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" id="simpan" type="button">Process</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
      </form>
      </div>

  </div>
</div>
