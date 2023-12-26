@extends('layouts.public')
@section('title','Ajukan Perizinan')

@push('extra_style')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

<style>
body {
    background-color: #f3f8fb;
  }
  .readonly{
    background-color: #dfdfdf !important;
  }

  #map {
          height: 50vh;
    /* height: 100%; */
    width: 100%;
    z-index: 1;
    /* overflow: hidden; */
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
        <span id="error_kategori" class="text-danger"></span>
      </div>
      <div class="form-group my-3">
        <label for="nama_perizinan">Nama Instansi</label>
        <input
          type="text"
          class="form-control"
          id="nama_perizinan"
          name="nama"
        />
        <span id="error_nama" class="text-danger"></span>
      </div>
      <div class="form-group my-3">
        <label for="alamat">Alamat</label>
        <textarea class="form-control" name="alamat_lokasi" id="alamat" rows="3"></textarea>
        <span id="error_alamat" class="text-danger"></span>
      </div>
      <div class="form-group">
        <div id="map" class="" ></div>

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
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
  var latitude = ''; // Default latitude
var longitude = ''; // Default longitude

function askForLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition, handleError);
  } else {
    alert("Geolocation is not supported by this browser.");
  }
}

// Tanggapan ketika lokasi ditemukan
function showPosition(position) {
  latitude = position.coords.latitude;
  longitude = position.coords.longitude;

  // Memperbarui nilai elemen HTML dengan longitude dan latitude terbaru
  document.getElementById("longitude").value = longitude;
  document.getElementById("latitude").value = latitude;

  console.log({ latitude, longitude }); // Menampilkan nilai latitude dan longitude ke konsol

  // Setelah lokasi ditemukan, inisialisasi peta dan marker
  initializeMap();
}

// Inisialisasi peta dan marker setelah lokasi ditemukan
function initializeMap() {
  var map = L.map('map').setView([latitude, longitude], 17);
  var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
  }).addTo(map);

  var marker = L.marker([latitude, longitude], { draggable: true }).addTo(map);

  // Fungsi yang dipanggil saat marker digeser
  function onMarkerDrag(event) {
    var marker = event.target;
    var position = marker.getLatLng();
    latitude = position.lat;
    longitude = position.lng;

    updatePopupContent();
    document.getElementById("longitude").value = longitude;
    document.getElementById("latitude").value = latitude;
  }

  // Fungsi untuk memperbarui konten popup marker
  function updatePopupContent() {
    marker.setPopupContent(`Latitude: ${latitude}<br>Longitude: ${longitude}`);
  }

  // Panggil fungsi saat marker digeser
  marker.on('drag', onMarkerDrag);

  // Fungsi yang dipanggil saat peta diklik
  function onMapClick(event) {
    var clickedLatLng = event.latlng;
    latitude = clickedLatLng.lat;
    longitude = clickedLatLng.lng;

    marker.setLatLng(clickedLatLng);
    updatePopupContent();
  }

  // Panggil fungsi saat peta diklik
  map.on('click', onMapClick);

  // Inisialisasi konten popup
  updatePopupContent();
}

// Panggil fungsi untuk meminta lokasi saat halaman dimuat
askForLocation();

// Tanggapan jika terjadi kesalahan
function handleError(error) {
  switch (error.code) {
    case error.PERMISSION_DENIED:
      alert("User denied the request for Geolocation.");
      break;
    case error.POSITION_UNAVAILABLE:
      alert("Location information is unavailable.");
      break;
    case error.TIMEOUT:
      alert("The request to get user location timed out.");
      break;
    case error.UNKNOWN_ERROR:
      alert("An unknown error occurred.");
      break;
  }
}
  $(document).ready(function () {
      $('#form1').submit(function (e) {
          e.preventDefault();

      var kategori = $('#kategori_perizinan').val();
      var nama = $('#nama_perizinan').val();
      var alamat = $('#alamat').val();


      $('#error_kategori').text('');
      $('#error_nama').text('');
      $('#error_alamat').text('');

      let validasi = false;

      if (kategori === null || kategori === "") {
        $('#error_kategori').text('Kategori perizinan diperlukan.');
        validasi = true;
      }
      if (nama === '') {
        $('#error_nama').text('Nama Instansi diperlukan.');
        validasi = true;
      }
      if (alamat === '') {
        $('#error_alamat').text('Alamat diperlukan.');
        validasi = true;
      }

      if(validasi){
        iziToast.warning({
              icon: 'fa fa-info',
              message: 'Data Gagal disimpan!',
          });
        return;
      }

     

          var formData = $(this).serializeArray();

          sessionStorage.setItem('form1Data', JSON.stringify(formData));
          window.location.href = 'ajukan-syarat-perizinan';
      });
  });
</script>

@endpush