@extends('layouts.app')

@section('title','Profil Pengguna')
@section('content')
<!-- partial -->
<div class="main-content">
<section class="section mt-4">
  <div class="row">
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body row">
                        <form action="{{ route('profil-pengguna.update', $user->id) }}" method="post">
                            @csrf
                            @method('put')
                     <div class="row col-12">
                            <div class="form-group col-md-6 col-12">
                                <label for="nama_lengkap">Nama</label>
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ $user->nama_lengkap }}">
                            </div>
                    
                            <div class="form-group col-md-6 col-12">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                            </div>
                    
                            <div class="form-group col-md-6 col-12">
                                <label for="no_telp">Nomor Telepon</label>
                                <input type="text" class="form-control" id="no_telp" name="no_telp" value="{{ $user->no_telp }}">
                            </div>
                    
                            <div class="form-group col-md-6 col-12">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ $user->tanggal_lahir }}">
                            </div>
                    
                            <div class="form-group col-md-6 col-12">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                    <option value="Laki-Laki" {{ $user->jenis_kelamin == 'Laki-Laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ $user->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                    
                            <div class="form-group col-md-6 col-12">
                                <label for="jenis_identitas">Jenis Identitas</label>
                                <select class="form-control" id="jenis_identitas" name="jenis_identitas">
                                    <option value="ktp" {{ $user->jenis_identitas == 'KTP' ? 'selected' : '' }}>KTP</option>
                                    <option value="sim" {{ $user->jenis_identitas == 'Paspor' ? 'selected' : '' }}>Paspor</option>
                                    <!-- Tambahkan opsi lainnya sesuai kebutuhan -->
                                </select>
                            </div>
                    
                            <div class="form-group col-md-6 col-12">
                                <label for="nomor_identitas">Nomor Identitas</label>
                                <input type="text" class="form-control" id="nomor_identitas" name="nomor_identitas" value="{{ $user->nomor_identitas }}">
                            </div>
                    
                            <div class="form-group col-md-6 col-12">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}">
                            </div>
                    
                            <div class="form-group col-md-6 col-12">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ $user->alamat }}</textarea>
                            </div>
                    
                                <div class="form-group col-md-6 col-12">
                                    <label for="provinsi">Provinsi</label>
                                    <input type="text" class="form-control" id="provinsi" name="provinsi" value="{{ $user->provinsi }}">
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label for="kabupaten_kota">Kota</label>
                                    <input type="text" class="form-control" id="kabupaten_kota" name="kabupaten_kota" value="{{ $user->kabupaten_kota }}">
                                </div>

                    

                                <div class="form-group col-md-6 col-12">
                                    <label for="kecamatan">Kecamatan</label>
                                    <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ $user->kecamatan }}">
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label for="kelurahan">Kelurahan</label>
                                    <input type="text" class="form-control" id="kelurahan" name="kelurahan" value="{{ $user->kelurahan }}">
                                </div>

                    
                            <div class="form-group col-md-6 col-12">
                                <label for="pekerjaan">Pekerjaan</label>
                                <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="{{ $user->pekerjaan }}">
                            </div>
                        </div>
                    
                            <!-- Tambahkan input lainnya sesuai kebutuhan -->
                    <div class="row btn-update-profile">
                        <button type="submit" class="btn btn-main">Simpan Perubahan</button>
                    </div>
                        </form>
                        <div class="row btn-update-profile col-12 mx-0 px-0">
                            <button type="submit" class="btn btn-white mt-4 mb-4">Ubah Password</button>
                        </div>
                  </div>
                  
                </div>
    </div>
</section>

  </div>
</div>
<!-- content-wrapper ends -->
@endsection

@section('soloScript')
<script>
  @if (session('success'))
  iziToast.success({
      icon: 'fa fa-save',
      message: 'Perubahan Berhasil Disimpan!',
  });
  @endif
</script>
@endsection