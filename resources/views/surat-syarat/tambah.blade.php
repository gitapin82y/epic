<!-- Modal -->
<div id="tambah" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xs">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-warning" style="background-color: #499DB1 !important">

        <h4 class="modal-title text-light">Form Surat Syarat</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <table class="table table_modal">
          <tr>
            <td>Nama Syarat</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext nama" name="nama">
              <input type="hidden" class="form-control form-control-sm id" name="id">
            </td>
          </tr>
          <tr>
            <td>Surat Jenis</td>
            <td>
              <select class="form-control form-control-sm surat_jenis_id inputtext" name="surat_jenis_id" id="surat_jenis_id" >
                <option disabled selected value="">Pilih</option>
                @foreach ($suratJenis as $key => $value)
                <option value="{{$value->id}}">{{$value->nama}}</option>
              @endforeach
              </select>
            </td>
          </tr>
          <tr>
            <td>Template Surat (file)</td>
            <td>
              <input type="file" class="form-control inputtext syarat_template" name="syarat_template">
             
            </td>
          </tr>
          </table>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" id="simpan" type="button">Process</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
      </div>

  </div>
</div>
