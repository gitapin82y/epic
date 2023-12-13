@extends('layouts.app')

@section('title','Petugas')

@section('soloStyle')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
body {
    background-color: #f3f8fb;
}
#map {
    height: 50vh;
    width: 100%;
    z-index: 1;
}
</style>
<script src="{{asset('assets\js\sweetalert2.all.min.js')}}"></script>

{{-- data table + ui design --}}
<link rel="stylesheet" href="{{asset('assets\DataTables-1.10.21\css\dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets\DataTables-1.10.21\css\jquery.dataTables.min.css')}}">
{{-- end data table --}}
@endsection

@section('content')
<div class="main-content">
    <section class="section mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-blue">
                        <h5>
                            Laporan Survey (No Surat : {{ $data->id }})
                        </h5>
                    </div>
                <div class="card-body">
                  
                    <form id="form1" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="foto_survey">Foto Survey</label>
                                <input type="hidden" class="form-control" id="id" name="id" value="{{ $data->id }}">
                                <input type="hidden" class="form-control" id="jadwal_survey" name="jadwal_survey" value="@php
                            use Carbon\Carbon;
                                
                                echo Carbon::now('Asia/Jakarta'); @endphp">

                                <input type="file" class="form-control" id="foto_survey" name="foto_survey">
                            </div>
                            <div class="form-group col-6">
                                <label for="dokumen_survey">Upload Dokumen Hasil Survey</label>
                              

                                <input type="file" class="form-control" id="dokumen_survey" name="dokumen_survey">
                            </div>
                            <div class="form-group col-12">
                                <label for="alamat_survey">Alamat</label>
                                <textarea class="form-control" id="alamat_survey" name="alamat_survey">{{ $data->alamat_survey }}</textarea>
                            </div>
                            <div class="form-group col-12">
                                <label for="map">Alamat pada Peta</label>
                                <div id="map"></div>
                                
                            </div>
                            <div class="form-group col-6">
                                <label for="longitude">longitude</label>
                                <input type="text" class="form-control" id="longitude" name="longitude"  readonly>
                            </div>
                            <div class="form-group col-6">
                                <label for="latitude">latitude</label>
                                <input type="text" class="form-control" id="latitude" name="latitude" readonly>
                            </div>
                        </div>
                        <div class="row btn-update-profile mt-4">
                            <button type="button" class="btn btn-main text-light" id="simpan">Selanjutnya</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </section>
    </div>
@endsection

@section('soloScript')

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>


<script>
var latitude = -7.3360141; // Default latitude
var longitude = 112.7028162; // Default longitude

function askForLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, handleError);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

function showPosition(position) {
    latitude = position.coords.latitude;
    longitude = position.coords.longitude;
    document.getElementById("longitude").value = longitude;
    document.getElementById("latitude").value = latitude;

    initializeMap();
}

function initializeMap() {
    var map = L.map('map').setView([latitude, longitude], 17);
    var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    var marker = L.marker([latitude, longitude]).addTo(map);

    
}

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

askForLocation();

$('#simpan').click(function(){
    var formData = new FormData($('#form1')[0]);
    console.log('form1',  JSON.stringify(formData));
    
    $.ajax({
        url: baseUrl + '/kirim-laporan',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success:function(data){
            if (data.status == 1) {
                // iziToast.success({
                //     icon: 'fa fa-save',
                //     message: 'Data Berhasil Disimpan!',
                // });
                let id = data.id;
                window.location.href = baseUrl + '/survey/penugasan-survey';

                // reloadall();
            } else if(data.status == 2){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: data.message,
                });
            } else if (data.status == 3){
                iziToast.success({
                    icon: 'fa fa-save',
                    message: 'Data Berhasil Diubah!',
                });
                reloadall();
            } else if (data.status == 4){
                iziToast.warning({
                    icon: 'fa fa-info',
                    message: 'Data Gagal Diubah!',
                });
            }
        }
    });
});

</script>
@endsection
