@extends('login-system.layouts.template')
@section('title','Register')
@push('before_style')
  <style>
    body{
      background: url('assets/img/bg-login.png');
      background-size: cover;
    }
  </style>
@endpush
@section('content')

<div class="row">
    <div class="col-12  col-md-8 offset-md-2 col-lg-8 col-xl-6 offset-xl-3">
        <div class="login-brand">
            <img src="{{ asset('assets/logo/logo-epic.png') }}" alt="logo" width="100"
                class="shadow-light rounded-circle">
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Register</h4>

            </div>

            <div class="card-body">
                <form autocomplete="off" method="POST" action="{{ url('registerpemohon/register') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="nama_lengkap">Nama Lengkap</label>
                        @if (isset($nama))

                            <input id="nama_lengkap" type="text"
                                class="form-control @error('nama_lengkap') is-invalid @enderror"
                                name="nama_lengkap" value="{{$nama}}" autofocus>
                            @else
                            <input id="nama_lengkap" type="text"
                                class="form-control @error('nama_lengkap') is-invalid @enderror"
                                name="nama_lengkap" autofocus>
                            @endif
                            @error('nama_lengkap')
                            <i class="text-danger">{{ $message }}</i>
                            @enderror
                        </div>

                        <div class="form-group col-6">
                            <label for="pekerjaan">Pekerjaan</label>

                            <input id="pekerjaan" type="text"
                                class="form-control" name="pekerjaan"
                                value="{{ old('pekerjaan') }}">
                            @if (session('pekerjaan'))
                            <small class="text-danger"><b>Pekerjaan kosong</b></small>
                            @endif

                        </div>
                       
                        <div class="form-group col-6">
                            <label for="email">Email</label>

                            <input id="email" type="email"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}">
                            @error('email')
                            <i class="text-danger">{{ $message }}</i>
                            @enderror

                        </div>
                        <div class="form-group col-6">
                            <label for="alamat">Alamat</label>

                            <textarea id="alamat" rows="20"
                                class="form-control" name="alamat"
                                value="{{ old('alamat') }}">
                            </textarea>
                            @if (session('alamat'))
                            <small class="text-danger"><b>Alamat kosong</b></small>
                            @endif
                        </div>
                        <div class="form-group col-6">
                            <label for="no_telp">Nomor Telepon</label>

                            <input id="no_telp" type="text"
                                class="form-control" name="no_telp"
                                value="{{ old('no_telp') }}">
                                @if (session('no_telp'))
                                <small class="text-danger"><b>Nomor telepon kosong</b></small>
                                @endif

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="provinsi" class="mb-2">Provinsi</label>
                            <select class="form-control form-control-sm provinsi" name="provinsiselect" id="provinsiselect" onchange="selectProvinsi()" >
                              <option>Pilih</option>
                            </select>
                            <input type="hidden" name="provinsi" id="provinsivalue">
                          </div>
                          <div class="col-md-6 mb-3">
                            <label for="tempat_lahir" class="mb-2">Tempat Lahir</label>
                            <input type="text" class="form-control form-control-sm inputtext tempat_lahir" name="tempat_lahir">
                            @if (session('tempat_lahir'))
                            <small class="text-danger"><b>Tanggal Lahir kosong</b></small>
                            @endif
                          </div>
                          <div class="col-md-6 mb-3">
                            <label for="kabupaten_kota" class="mb-2">Kabupaten / Kota</label>
                            <select class="form-control form-control-sm provinsi" name="kabupatenselect" id="kabupatenselect" onchange="selectKabupaten()" >
                              <option>Pilih</option>
                            </select>
                            <input type="hidden" name="kabupaten_kota" id="kabupatenvalue">
                          </div>
                          <div class="col-md-6 mb-3">
                            <label for="tanggal_lahir" class="mb-2">Tanggal Lahir</label>
                            <input type="date" class="form-control form-control-sm inputtext tanggal_lahir" name="tanggal_lahir">
                            @if (session('tanggal_lahir'))
                            <small class="text-danger"><b>Tanggal Lahir kosong</b></small>
                            @endif
                          </div>
                          <div class="col-md-6 mb-3">
                            <label for="kecamatan" class="mb-2">Kecamatan</label>
                            <select class="form-control form-control-sm provinsi" name="kecamatanselect" id="kecamatanselect" onchange="selectKecamatan()" >
                              <option>Pilih</option>
                            </select>
                            <input type="hidden" name="kecamatan" id="kecamatanvalue">
                          </div>
                          <div class="col-md-6 mb-3">
                            <label for="jenis_kelamin" class="mb-2">Jenis Kelamin</label>
                            <select class="form-control form-control-sm jenis_kelamin" name="jenis_kelamin" id="jenis_kelamin" >
                              <option>Pilih</option>
                              <option value="Laki-Laki">Laki - Laki</option>
                              <option value="Perempuan">Perempuan</option>
                            </select>
                            @if (session('jenis_kelamin'))
                            <small class="text-danger"><b>Jenis kelamin kosong</b></small>
                            @endif
                          </div>
                          <div class="col-md-6 mb-3">
                            <label for="kelurahan" class="mb-2">Kelurahan</label>
                            <select class="form-control form-control-sm provinsi" name="kelurahanselect" id="kelurahanselect" onchange="selectKelurahan()" >
                              <option>Pilih</option>
                            </select>
                            <input type="hidden" name="kelurahan" id="kelurahanvalue">
                          </div>
                          <div class="col-md-6 mb-3">
                            <label for="jenis_identitas" class="mb-2">Jenis Identitas</label>
                            <select class="form-control form-control-sm jenis_identitas" name="jenis_identitas" id="jenis_identitas" >
                              <option>Pilih</option>
                              <option value="KTP">KTP</option>
                              <option value="Paspor">Paspor</option>
                            </select>
                            @if (session('jenis_identitas'))
                            <small class="text-danger"><b>Jenis identitas kosong</b></small>
                            @endif
                          </div>
                          <div class="col-md-6 mb-3">
                            <label for="password" class="mb-2">Password</label>
                            <input type="password" class="form-control form-control-sm inputtext password" name="password">
                          </div>
                          <div class="col-md-6 mb-3">
                            <label for="nomor_identitas" class="mb-2">Nomor Identitas</label>
                            <input type="text" class="form-control form-control-sm inputtext nomor_identitas" name="nomor_identitas">
                          @if (session('nomor_identitas'))
                          <small class="text-danger"><b>Nomor Identitas kosong</b></small>
                          @endif
                          </div>
                          <div class="col-md-6 mb-3">
                            <label for="konfirmasi_password" class="mb-2">Konfirmasi Password</label>
                            <input type="password" class="form-control form-control-sm inputtext konfirmasi_password" name="konfirmasi_password">
                            @if (session('password'))
                            <div class="red"  style="color: red"><b> Password confirm anda tidak sama! </b></div>
                            @endif
                          </div>
                    </div>
                    
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                            Register
                        </button>
                    </div>
                    <div class="mt-2 text-muted text-center">
                        Sudah Punya Akun? <a href="loginpemohon">Masuk</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

    @include('includes.script')

<script src="{{asset('assets/node_modules/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('assets/node_modules/select2/dist/js/select2.min.js')}}"></script>
<script src="{{asset('assets/js/off-canvas.js')}}"></script>
<script src="{{asset('assets/js/hoverable-collapse.js')}}"></script>
<script src="{{asset('assets/js/misc.js')}}"></script>
<script>
@if (session('gagalLogin'))
  iziToast.warning({
      icon: 'fa fa-info',
      message: 'Terdapat Kesalahan, Periksa kembali!',
  });
  @endif
</script>
<script>
    $(document).ready(function(){
      provinsi();
    })
    
    function provinsi() {
      $.ajax({
        url: "https://twilight-frost-2680.fly.dev/prov",
        method: "get",
        dataType:'json',
        success:function(data){
          var x = document.getElementById("provinsiselect");
  
          for (let i = 0; i < data.data.length; i++) {
            var option = document.createElement("option");
            option.text = data.data[i].name;
            option.value = data.data[i].id;
            x.add(option);
          }
        }
      });
    }
  
    function selectProvinsi() {
      var value = $('#provinsiselect').find(":selected").val();
      var name = $('#provinsiselect').find(":selected").text();
  
      $("#provinsivalue").val(name)
  
      $.ajax({
        url: "https://twilight-frost-2680.fly.dev/prov/"+value,
        method: "get",
        dataType:'json',
        success:function(data){
          $('#kabupatenselect').find('option:not(:first)').remove();
          var x = document.getElementById("kabupatenselect");
  
          for (let i = 0; i < data.kabupaten.length; i++) {
            var option = document.createElement("option");
            option.text = data.kabupaten[i].name;
            option.value = data.kabupaten[i].id;
            x.add(option);
          }
        }
      });
    }
  
    function selectKabupaten() {
      var value = $('#kabupatenselect').find(":selected").val();
      var name = $('#kabupatenselect').find(":selected").text();
  
      $("#kabupatenvalue").val(name)
  
      $.ajax({
        url: "https://twilight-frost-2680.fly.dev/kab/"+value,
        method: "get",
        dataType:'json',
        success:function(data){
          $('#kecamatanselect').find('option:not(:first)').remove();
          var x = document.getElementById("kecamatanselect");
  
          for (let i = 0; i < data.kecamatan.length; i++) {
            var option = document.createElement("option");
            option.text = data.kecamatan[i].name;
            option.value = data.kecamatan[i].id;
            x.add(option);
          }
        }
      });
    }
  
    function selectKecamatan() {
      var value = $('#kecamatanselect').find(":selected").val();
      var name = $('#kecamatanselect').find(":selected").text();
  
      $("#kecamatanvalue").val(name)
  
      $.ajax({
        url: "https://twilight-frost-2680.fly.dev/kec/"+value,
        method: "get",
        dataType:'json',
        success:function(data){
          $('#kelurahanselect').find('option:not(:first)').remove();
          var x = document.getElementById("kelurahanselect");
  
          for (let i = 0; i < data.kelurahan.length; i++) {
            var option = document.createElement("option");
            option.text = data.kelurahan[i].name;
            option.value = data.kelurahan[i].id;
            x.add(option);
          }
        }
      });
    }
  
    function selectKelurahan() {
      var value = $('#kelurahanselect').find(":selected").val();
      var name = $('#kelurahanselect').find(":selected").text();
  
      $("#kelurahanvalue").val(name)
    }
    
    $('select').select2({
      width: '100%'
    });
  
    </script>
