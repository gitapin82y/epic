<!-- Modal -->
<div id="showTolak" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xs">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-warning"  style="background-color: #499DB1 !important">
        <h4 class="modal-title">Form Pemohon</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <table class="table table_modal">
          <tr>
            <td>Alasan Dikembalikan</td>
            <td>
              <textarea class="form-control form-control-sm inputtext alasan_dikembalikan px-auto" name="alasan_dikembalikan" rows=5 value="">
              </textarea>
              {{-- <input type="text" class="form-control form-control-sm inputtext alasan_ditolak" name="alasan_ditolak"> --}}


              <input type="hidden" class="form-control form-control-sm id inputtext" name="id">
            </td>
          </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" id="dikembalikanProcess" type="button">Kirim</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
        </div>
      </div>
      </div>

  </div>
</div>
