<!-- Modal -->
<div id="tolak" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xs">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h4 class="modal-title">Form Pemohon</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <table class="table table_modal">
          <tr>
            <td>Alasan Ditolak</td>
            <td>
              <textarea class="form-control form-control-sm inputtext alasan_ditolak px-auto" name="alasan_ditolak" rows=5 value="ssp">
              </textarea>
              {{-- <input type="text" class="form-control form-control-sm inputtext alasan_ditolak" name="alasan_ditolak"> --}}


              <input type="hidden" class="form-control form-control-sm id inputtext" name="id">
            </td>
          </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" id="tolakProcess" type="button">Process</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>
      </div>
      </div>

  </div>
</div>
