<!-- Modal -->
<div id="detailPenugasan" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xs">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h4 class="modal-title">Form Petugas</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <table class="table table_modal">
          <tr>
            <td>Penugasan Surveyor</td>
            <td>
              <input type="hidden" class="form-control form-control-sm id" name="id">
              <input type="hidden" class="form-control form-control-sm is_acc_penjadwalan" name="is_acc_penjadwalan">
              <input type="hidden" class="form-control form-control-sm is_reschedule" name="is_reschedule">
              <select class="form-control form-control-lg form-select inputtext user_id" name="user_id" id="user_id" disabled>
                <option disabled>Pilih</option>
                @foreach ($surveyors as $key => $value)
                <option value="{{$value->id}}">{{$value->nama_lengkap}}</option>
              @endforeach
              </select>
            </td>
          </tr>
          <tr>
            <td>Jadwal Survey</td>
            <td>
              <input type="date" class="form-control form-control-sm inputtext jadwal_survey" name="jadwal_survey" disabled>

            </td>
          </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>
      </div>
      </div>

  </div>
</div>
