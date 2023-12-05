@extends('layouts.public')
@section('title','Ajukan Perizinan')

@push('extra_style')
<style>
body {
    background-color: #f3f8fb;
  }
  .readonly{
    background-color: #dfdfdf !important;
  }
</style>
@endpush

@section('content')
<div
class="row col-12 justify-content-center mt-5 pt-5"
id="ajukan-perizinan"
>
<div class="col-md-6 col-12">
  <div class="content mt-5">
    <h3 class="text-center mb-5">Ajukan {{$perizinan->nama}}</h3>
    <form id="form1">
      <input
      type="hidden"
      class="form-control"
      name="surat_jenis_id"
      value="{{$perizinan->id}}"
    />
    <input
    type="hidden"
    class="form-control"
    name="nama_perizinan"
    value="{{$perizinan->nama}}"
  />
      <div class="form-group my-3">
        <label for="kategori_perizinan">Kategori Perizinan</label>
        
        <select class="form-select" name="kategori" id="kategori_perizinan">
          <option disabled selected>Pilih Kategori</option>
          <option value="TK">TK</option>
          <option value="PAUD">PAUD</option>
          <option value="SD">SD</option>
          <option value="SMP">SMP</option>
        </select>
      </div>
      <div class="form-group my-3">
        <label for="nama_perizinan">Nama</label>
        <input
          type="text"
          class="form-control"
          id="nama_perizinan"
          name="nama"
        />
      </div>
      <div class="form-group my-3">
        <label for="alamat">Alamat</label>
        <textarea class="form-control" name="alamat_lokasi" id="alamat" rows="3"></textarea>
      </div>
      <div class="form-group my-3">
        <label for="longitude">Longitude</label>
        <input
        value="112.7028162"

          type="text"
          class="form-control readonly"
          id="longitude"
          name="longitude"
          readonly
        />
      </div>
      <div class="form-group my-3">
        <label for="latitude">Latitude</label>
        <input
          value="-7.3360141"
          type="text"
          class="form-control readonly"
          id="latitude"
          name="latitude"
          readonly
        />
      </div>
      <button
        type="submit"
        class="btn btn-main mt-5 w-100"
      >
        Lanjut
      </butt>
    </form>
  </div>
</div>
</div>
@endsection

@push('extra_script')
<script>
  $(document).ready(function () {
      $('#form1').submit(function (e) {
          e.preventDefault();

          var formData = $(this).serializeArray();

          sessionStorage.setItem('form1Data', JSON.stringify(formData));
          window.location.href = 'ajukan-syarat-perizinan';
      });
  });
</script>

@endpush