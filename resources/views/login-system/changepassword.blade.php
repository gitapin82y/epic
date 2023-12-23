<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Change Password | EPIC</title>

    @include('includes.style')
</head>
<body>
    <div id="app">
 <section class="section">
<div class="d-flex flex-wrap align-items-stretch">
    <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
        <div class="login-brand">
            <img src="{{asset("assets/logo/logo-epic.png")}}" alt="logo" width="100" class="shadow-light rounded-circle">
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Ganti Kata Sandi</h4>
            </div>

            <div class="card-body">
                <form class="needs-validation" novalidate="" method="GET" action="{{ url('dochangepassword') }}">
                    {{ csrf_field() }}
                    
                    <input type="hidden" name="otp" value="{{ $data->otp }}">
                    <input type="hidden" name="email" value="{{ $data->email }}">

                    <div class="form-group">
                        <div class="d-block">
                            <label for="password" class="control-label">Password</label>
                        </div>
                        <input id="password" type="password"
                            class="form-control" value="" type="password" name="password" id="password" required placeholder="Password">
                    </div>

                    <div class="form-group">
                        <div class="d-block">
                            <label for="password" class="control-label">Konfirmasi Password</label>
                        </div>
                        <input id="password" type="password"
                            class="form-control" value="" type="password" name="confirmpassword" id="confirmpassword" required placeholder="Konfirmasi Password">
                            @if (session('password'))
                            <div class="red"  style="color: red"><b>Password Tidak Sama</b></div>
                            @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                            Ubah Sekarang
                        </button>
                    </div>
                    <div class="mt-2 text-muted text-center">
                        Ingat Kata Sandi? <a href="{{ url('loginpemohon') }}">Login Sekarang</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="simple-footer">
            Copyright &copy; EPIC 2023
        </div>
    </div>
<div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom" data-background="{{ asset('assets/img/bg-login.png') }}">
    <div class="absolute-bottom-left index-2">
    </div>
  </div>
</div>
</section>
    </div>

  @include('includes.script')
  
  @include('sweetalert::alert')
</body>
</html>