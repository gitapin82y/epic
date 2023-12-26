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
              <input type="text" class="form-control form-control-sm inputtext nama_lengkap" name="nama_lengkap" readonly>
              <input type="hidden" class="form-control form-control-sm id"  name="id">
            </td>
          </tr>
          <tr>
            <td>Username</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext username" readonly name="username">

            </td>
          </tr>
          <tr>
            <td>Password</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext password" readonly name="password">
            </td>
          </tr>
          <tr>
            <td>Email</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext email" readonly name="email">
            </td>
          </tr>
          <tr>
            <td>Jenis Identitas</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext jenis_identitas" readonly name="jenis_identitas">
            </td>
          </tr>
          <tr>
            <td>Nomor Identitas</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext nomor_identitas" readonly name="nomor_identitas">
            </td>
          </tr>
          <tr>
            <td>Jenis Kelamin</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext jenis_kelamin" readonly name="jenis_kelamin">
            </td>
          </tr>
          <tr>
            <td>Tempat Lahir</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext tempat_lahir" readonly name="tempat_lahir">
            </td>
          </tr>
          <tr>
            <td>Tanggal Lahir</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext tanggal_lahir" readonly name="tanggal_lahir">
            </td>
          </tr>
          <tr>
            <td>Provinsi</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext provinsi" readonly name="provinsi">
            </td>
          </tr>
          <tr>
            <td>Kabupaten / Kota</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext kabupaten_kota" readonly name="kabupaten_kota">
            </td>
          </tr>
          <tr>
            <td>Kecamatan</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext kecamatan" readonly name="kecamatan">
            </td>
          </tr>
          <tr>
            <td>Kelurahan</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext kelurahan" readonly name="kelurahan">
            </td>
          </tr>
          <tr>
            <td>Alamat</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext alamat" readonly name="alamat">
            </td>
          </tr>
          <tr>
            <td>No. Telp</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext no_telp" readonly name="no_telp">
            </td>
          </tr>
          <tr>
            <td>Pekerjaan</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext pekerjaan" readonly name="pekerjaan">
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
