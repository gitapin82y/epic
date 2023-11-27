@extends('login-system.layouts.template')
@section('title','Register')

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
                <form action="" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="nama_lengkap">Nama Lengkap</label>
                            <input id="nama_lengkap" type="text"
                                class="form-control @error('nama_lengkap') is-invalid @enderror"
                                name="nama_lengkap" value="{{ old('nama_lengkap') }}" autofocus>

                            @error('nama_lengkap')
                            <i class="text-danger">{{ $message }}</i>
                            @enderror
                        </div>

                        <div class="form-group col-6">
                            <label for="username">Username</label>
                            <input id="username" type="text"
                                class="form-control @error('username') is-invalid @enderror" name="username"
                                value="{{ old('username') }}">
                            @error('username')
                            <i class="text-danger">{{ $message }}</i>
                            @enderror

                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="password" class="d-block">Password</label>
                            <input id="password" type="password"
                                class="form-control pwstrength @error('password') is-invalid @enderror"
                                name="password">
                            @error('password')
                            <i class="text-danger">{{ $message }}</i>
                            @enderror
                        </div>
                        <div class="form-group col-6">
                            <label for="password_confirmation" class="d-block">Konfirmasi Password</label>
                            <input id="password_confirmation" type="password"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                name="password_confirmation">
                            @error('password_confirmation')
                            <i class="text-danger">{{ $message }}</i>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-4">
                            <label for="nik">NIK</label>
                            <input id="nik" type="text"
                                class="form-control @error('nik') is-invalid @enderror" name="nik"
                                value="{{ old('nik') }}" autofocus>

                            @error('nik')
                            <i class="text-danger">{{ $message }}</i>
                            @enderror
                        </div>
                        <div class="form-group col-8">
                            <label for="alamat">Alamat</label>
                            <input id="alamat" type="text"
                                class="form-control @error('alamat') is-invalid @enderror" name="alamat"
                                value="{{ old('alamat') }}" autofocus>

                            @error('alamat')
                            <i class="text-danger">{{ $message }}</i>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-12">
                            <label for="gender">Jenis Kelamin</label>
                            <select class="custom-select" name="jenis_kelamin">
                                <option value="l" selected id="gender">Laki-Laki</option>
                                <option value="p">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                            Register
                        </button>
                    </div>
                    <div class="mt-2 text-muted text-center">
                        Sudah Punya Akun? <a href="/login">Masuk</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="simple-footer">
            Copyright &copy; EPIC 2023
        </div>
    </div>
</div>


@endsection
