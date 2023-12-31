@extends('layouts.app')

@section('title','Petugas')

@section('soloStyle')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
body {
    background-color: #f3f8fb;
}
#map {
    height: 35vh;
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
@include('hasil-survey.tolak')

<div class="main-content">
    <section class="section mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-blue">
                        <h5>
                            Laporan Survey (No Surat : {{ $data->surat_id }})
                        </h5>
                    </div>
                <div class="card-body">
                  
                    {{-- <form id="form1" >
                        @csrf
                        @method('post') --}}
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="foto_survey">Foto Survey</label>
                                <br>
                                <input type="hidden" class="form-control" id="id" name="id" value="{{ $data->surat_id }}">
                                <input type="hidden" class="form-control" id="jadwal_survey" name="jadwal_survey" value="@php
                            use Carbon\Carbon;
                                
                                echo Carbon::now('Asia/Jakarta'); @endphp">

                                <img src="{{ asset($data->foto_survey) }}" alt="" class="w-100">
                            </div>
                            <div class="form-group col-6">
                                <label for="map">Alamat pada Peta</label>
                                <div id="map"></div>
                                
                            </div>
                            <div class="form-group col-6">
                                <strong for="longitude">longitude</strong>
                                <p class="" id="longitude">{{ $data->longitude }}</p>

                            </div>
                            <div class="form-group col-6">
                                <strong for="latitude">latitude</strong>
                                <p class="" id="latitude">{{ $data->latitude }}</p>

                            </div>
                            <div class="form-group col-6">
                                <strong>Nama Surveyor</strong>
                                <p class="" >{{ $data->nama_surveyor }}</p>

                            </div>
                            <div class="form-group col-6">
                                <strong>Email</strong>
                                <p class="" >{{ $data->email_surveyor }}</p>

                            </div>
                         
                            <div class="form-group col-6">
                                <strong>Tanggal Survey</strong>
                                <p class="" >{{ $data->jadwal_survey }}</p>

                            </div>
                            <div class="form-group col-6">
                                <strong>Status Survey</strong>
                                <p class="" >{{ $data->status }}</p>

                            </div>
                            <div class="form-group col-6">
                                <strong>Hasil Laporan</strong>
                                <br>
                                <a href="{{ asset($data->dokumen_survey) }}" class="text-light bg-main btn btn-md" style="background-color:#499DB1" target="_blank">Lihat Dokumen</a>
                                {{-- <p class="" >{{ $data->dokumen_survey }}</p> --}}

                            </div>
                           
                            {{-- <div class="form-group col-6">
                                <label for="dokumen_survey">Upload Dokumen Hasil Survey</label>
                              

                                <input type="file" class="form-control" id="dokumen_survey" name="dokumen_survey">
                            </div> --}}
                            <div class="form-group col-6">
                                <strong for="alamat_survey">Alamat</strong>
                                <p class="" >{{ $data->alamat_survey }}</p>
                            </div>
                           
                            
                        </div>
                        @if(Auth::user()->role_id == 6 && $data->status == 'Sudah Disurvey')

                        <div class="row btn-update-profile mt-4 col-12">
                            <button type="button" class="btn btn-main text-light col-12" id="simpan">Verifikasi Survey</button>
                            <button type="button" class="btn col-12 mt-4" id="showModalTolak" style="background-color: white !important; color:#499DB1 !important; border: 1px solid #499DB1; border-radius:25px">Tolak Survey</button>
                        </div>
                        @endif
                    {{-- </form> --}}
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
var latitude = document.getElementById("latitude").textContent; // Default latitude
var longitude = document.getElementById("longitude").textContent; // Default longitude
var idSurat = "{{ $data->surat_id }}";



// function askForLocation() {
//     if (navigator.geolocation) {
//         navigator.geolocation.getCurrentPosition(showPosition, handleError);
//     } else {
//         alert("Geolocation is not supported by this browser.");
//     }
// }

// function showPosition(position) {
//     latitude = position.coords.latitude;
//     longitude = position.coords.longitude;
//     document.getElementById("longitude").value = longitude;
//     document.getElementById("latitude").value = latitude;

//     initializeMap();
// }
initializeMap();

function initializeMap() {
    var map = L.map('map').setView([latitude, longitude], 17);
    var tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    var marker = L.marker([latitude, longitude]).addTo(map);

    
}

// function handleError(error) {
//     switch (error.code) {
//         case error.PERMISSION_DENIED:
//             alert("User denied the request for Geolocation.");
//             break;
//         case error.POSITION_UNAVAILABLE:
//             alert("Location information is unavailable.");
//             break;
//         case error.TIMEOUT:
//             alert("The request to get user location timed out.");
//             break;
//         case error.UNKNOWN_ERROR:
//             alert("An unknown error occurred.");
//             break;
//     }
// }

// askForLocation();

$('#simpan').click(function(){
   
    var formData = {
        'id' : idSurat
    }
    console.log({formData})
    iziToast.question({
      close: false,
  		overlay: true,
  		displayMode: 'once',
  		title: 'Verifikasi Hasil Survey',
  		message: 'Apakah anda yakin ?',
  		position: 'center',
  		buttons: [
  			['<button><b>Ya</b></button>', function (instance, toast) {
    $.ajax({
        url: baseUrl + '/surat/verifikasi-survey',
        type: 'POST',
        data: JSON.stringify(formData),
        contentType: 'application/json',
        // processData: false,
        headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
        success:function(data){
            if (data.status == 1) {
                iziToast.success({
                    icon: 'fa fa-save',
                    message: 'Data Berhasil Diverifikasi!',
                });
                let id = data.id;
                window.location.href = baseUrl + '/survey/hasil-survey';

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
}, true],
  			['<button>Tidak</button>', function (instance, toast) {
  				instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
  			}],
  		]
  	});
  })


  $('#showModalTolak').click(function(){
   var tes = document.getElementById("id").value ;
  //  console.log({tes})
   $('.id').val(tes);
   $('.alasan_ditolak').val("");
//    $('#detail').modal('hide'); 
   $('#showTolak').modal('show');
      // }
    // });
    
  })

  $('#dikembalikanProcess').click(function(){
    iziToast.question({
      close: false,
  		overlay: true,
  		displayMode: 'once',
  		title: 'Tolak Hasil Survey',
  		message: 'Apakah anda yakin ?',
  		position: 'center',
  		buttons: [
  			['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url:baseUrl + '/surat/tolak-survey',
            data:$('.table_modal :input').serialize(),
            dataType:'json',
            success:function(data){
              if (data.status == 1) {
          iziToast.success({
              icon: 'fa fa-save',
              message: 'Surat Berhasil Ditolak!',
          });
        //   reloadall();
   $('#showTolak').modal('hide');
   window.location = baseUrl+ "/survey/hasil-survey"

        }else if(data.status == 2){
          iziToast.warning({
              icon: 'fa fa-info',
              message: 'Surat Gagal Ditolak!',
          });
        }

              reloadall();
            }
          });
  			}, true],
  			['<button>Tidak</button>', function (instance, toast) {
  				instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
  			}],
  		]
  	});
  })


</script>
@endsection
