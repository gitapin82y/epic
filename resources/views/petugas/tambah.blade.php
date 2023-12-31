<!-- Modal -->
<div id="tambah" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xs">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-main text-white p-3 align-items-center d-flex">
        <h4 class="modal-title">Form Petugas</h4>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <table class="table table_modal">
          <tr>
            <td>Nama Lengkap</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext nama_lengkap" name="nama_lengkap">
              <input type="hidden" class="form-control form-control-sm id" name="id">
              <span class="error-message text-danger" id="error_nama_lengkap"></span>
            </td>
          </tr>
          <tr>
            <td>Role</td>
            <td>
              <select class="form-control form-control-sm role_id select2" name="role" id="role_id" >
                <option disabled>Pilih</option>
                @foreach ($roles as $key => $value)
                <option value="{{$value->id}}">{{$value->nama}}</option>
              @endforeach
            </select>
            <span class="error-message text-danger" id="error_role"></span>
            </td>
          </tr>
          <tr>
            <td>Email</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext email" name="email">
              <span class="error-message text-danger" id="error_email"></span>
            </td>
          </tr>
          <tr>
            <td>Username</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext username" name="username">
              <span class="error-message text-danger" id="error_username"></span>
            </td>
          </tr>
          <tr>
            <td>Password</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext password" name="password">
              <span class="error-message text-danger" id="error_password"></span>
            </td>
          </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" id="simpan" type="button">Process</button>
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
        </div>
      </div>
      </div>

  </div>
</div>
