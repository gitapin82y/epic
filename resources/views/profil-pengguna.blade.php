@extends('layouts.app')

@section('title','Profil Pengguna')

@section('soloStyle')
<style>
    .profile-avatar{
        width: 100px;
        height: 100px;
        border-radius: 100px;
    }
</style>
@endsection

@section('content')
<!-- partial -->
<div class="main-content">
<section class="section mt-4">
  <div class="row">
  	<div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body row justify-content-center ">
                    @if (Auth::user()->role_id == 9)
                        
                        <form action="{{ route('profil-pengguna.update', $user->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="text-center mb-4">
                            <img src="{{ asset(optional(Auth::user())->avatar ? Auth::user()->avatar : 'assets/img/avatar/avatar-1.png')  }}" class="profile-avatar" alt=""><br>
                            <div class="row justify-content-center">
                                <div class="col-md-4 col-12 mt-3">
                                    <input type="file" class="form-control" name="avatar" accept="image/*">
                                </div>
                            </div>
                        </div>


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
                                    <option value="KTP" {{ $user->jenis_identitas == 'KTP' ? 'selected' : '' }}>KTP</option>
                                    <option value="Paspor" {{ $user->jenis_identitas == 'Paspor' ? 'selected' : '' }}>Paspor</option>
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
                            <button type="button" data-toggle="modal" data-target="#changePasswordModal" class="btn btn-white mt-4 mb-4">Ubah Password</button>
                        </div>
                    @else

                    <form action="{{ route('profil-pengguna.update', $user->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="text-center mb-4">
                        <img src="{{ asset(optional(Auth::user())->avatar ? Auth::user()->avatar : 'assets/img/avatar/avatar-1.png')  }}" class="profile-avatar" alt=""><br>
                        <div class="row justify-content-center px-2">
                            <div class="col-12 mt-3">
                                <input type="file" class="form-control" name="avatar" accept="image/*">
                            </div>
                        </div>
                        <div class="row btn-update-profile mt-3 px-4">
                            <button type="submit" class="btn w-100 btn-main">Ubah Foto</button>
                        </div>
                    </div>


                        <div class="form-group col-12">
                            <label for="nama_lengkap">Nama</label>
                            <input type="text" class="form-control" id="nama_lengkap" value="{{ $user->nama_lengkap }}" disabled>
                        </div>
                
                        <div class="form-group col-12">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" value="{{ $user->email }}" disabled>
                        </div>

                        <div class="form-group col-12">
                            <label for="petugas">Petugas</label>
                            <input type="petugas" class="form-control" id="petugas" value="{{ $user->role_user }}" disabled>
                        </div>
                                                <!-- Tambahkan input lainnya sesuai kebutuhan -->
                    </form>



                    @endif


                  </div>
                  
                </div>
    </div>
</section>

  </div>
</div>
<!-- content-wrapper ends -->
<!-- Modal -->
<div id="changePasswordModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xs">
  
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header bg-main text-white p-3 align-items-center d-flex">
          <h4 class="modal-title">Ubah Password</h4>
          <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <form id="changePasswordForm" method="POST" action="update-password-pemohon">
                @csrf
          <div class="row">
            <div class="form-group w-100">
                <div class="d-block">
                    <label for="new_password" class="control-label">Kata Sandi Baru</label>
                </div>
                <div class="input-group">
                <input id="new_password" type="password"
                    class="form-control @error('password') is-invalid @enderror" value="" type="password" name="password" id="password">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fa fa-eye" id="togglePassword"></i>
                        </span>
                    </div>
                </div>
                @error('password')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group w-100">
                <div class="d-block">
                    <label for="confirm_password" class="control-label">Konfirmasi Kata Sandi Baru</label>
                </div>
                <div class="input-group">
                <input id="confirm_password" type="password"
                    class="form-control @error('password_confirmation') is-invalid @enderror" value="" type="password" name="password_confirmation" id="KataSandiBaru">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fa fa-eye" id="toggleKataSandiBaru"></i>
                        </span>
                    </div>
                </div>
                @error('password_confirmation')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
          </div>
          <div class="modal-footer p-0">
            <button class="btn btn-main w-100" id="simpan" type="submit">Simpan</button>
          </div>
        </div>
        </div>
    </form>
  
    </div>
  </div>

  

@endsection

@section('soloScript')
<script>
  @if (session('success'))
  iziToast.success({
      icon: 'fa fa-save',
      message: 'Profil Berhasil Diubah',
  });
  @endif

  @if (session('passwordUpadate'))
  iziToast.success({
      icon: 'fa fa-save',
      message: 'Password Berhasil Diubah',
  });
  @endif
</script>
<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('new_password');

    togglePassword.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        togglePassword.classList.toggle('fa-eye-slash');
    });

    const toggleKataSandiBaru = document.getElementById('toggleKataSandiBaru');
    const confirm_password = document.getElementById('confirm_password');

    toggleKataSandiBaru.addEventListener('click', function () {
        const type = confirm_password.getAttribute('type') === 'password' ? 'text' : 'password';
        confirm_password.setAttribute('type', type);
        toggleKataSandiBaru.classList.toggle('fa-eye-slash');
    });
</script>

@endsection