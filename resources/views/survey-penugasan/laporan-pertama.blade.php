<!-- Modal -->
<div id="tambah" class="modal fade" role="dialog">
  <div class="modal-dialog modal-xs">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h4 class="modal-title">Laporan Survey</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body ">
        <div class="modal-body-map">
        <div id="map" class="" ></div>
        </div>

        <div class="row">

          <table class="table table_modal">
            {{-- <div id="map" class="" ></div> --}}

          <tr>
            <td>Foto Survey</td>
            <td>
              <input type="hidden" class="form-control form-control-sm id" name="id">
              <input type="file" class="form-control form-control-sm inputtext foto_survey" name="foto_survey">

            </td>
          </tr>
          <tr>
            <td>Alamat</td>
            <td>
              <textarea style="border: 0; padding: 10px; font-weight:bold;" class="form-control form-control-sm inputtext alamat" name="alamat" id="alamat" cols="57" rows="10" placeholder="Jl. Kenangan Bersamamu"></textarea>
            </td>
          </tr>
          <tr>
            <td>Alamat</td>
            <td class="">
              <div  class="form-control bg-primary" >
          {{-- <div id="map" class="" ></div> --}}

              </div>

            </td>
          </tr>
          {{-- <tr>
            <td>
              <div id="mapid" class="form-control "></div>
            </td>
          </tr> --}}
          <tr>
            <td>Longitude</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext longitude" name="longitude" disabled>
            </td>
          </tr>
          <tr>
            <td>Latitude</td>
            <td>
              <input type="text" class="form-control form-control-sm inputtext latitude" name="latitude" disabled>
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

