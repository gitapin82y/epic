<!-- Modal -->
<div id="tambah" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xs">

    <!-- Modal content-->
    <div class="modal-content ">
      <div class="modal-header bg-warning" style="background-color: #499DB1 !important">
        <h4 class="modal-title text-white">Form Pemohon</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <table class="table table_modal">
          <tr>
            <td>Nama Lengkap</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext nama_lengkap border border-dark border-1" name="nama_lengkap" disabled>
              <input type="hidden" class="form-control form-control-sm id" name="id">
            </td>
          </tr>
          <tr>
            <td>Username</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext username border-dark border-1" name="username" disabled>

            </td>
          </tr>
          </table>
        </div>
        <div class="modal-footer">
          {{-- <button class="btn btn-primary"  type="button">Process</button> --}}
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
      </div>

  </div>
</div>
