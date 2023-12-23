<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login | EPIC</title>

    @include('includes.style')
    <style>
        #g_id_onload {
    background-color: #dd4b39 !important; /* Warna merah Google */
    color: #fff; /* Warna teks putih */
    font-size: 18px; /* Ukuran teks */
    width: 100vw;
    /* Tambahkan gaya kustom lainnya sesuai kebutuhan */
}
    </style>
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
                <h4>Login</h4>
            </div>

            <div class="card-body">
                <form class="needs-validation" novalidate="" method="GET" action="{{ url('loginpemohon/auth') }}">
                    {{ csrf_field() }}
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email"class="form-control" type="email" name="email" id="email" placeholder="email" required autofocus="">
                        @if (session('email'))
                        <div class="red"  style="color: red"><b>Email Tidak Ada</b></div>
                      @endif
                      <div class="invalid-feedback">
                        Email belum di isi
                      </div>
    
                    </div>

                    <div class="form-group">
                        <div class="d-block">
                            <label for="password" class="control-label">Password</label>
                        </div>
                        <input id="password" type="password"
                            class="form-control" value="" type="password" name="password" id="password" required placeholder="Password">
                            <div class="invalid-feedback">
                                Password harus di isi
                              </div>
                            @if (session('password'))
                            <div class="red"  style="color: red"><b>Password Yang Anda Masukan Salah</b></div>
                            @endif
                    </div>

                    <a href="{{url('lupapassword')}}" style="float:right;" class="text-main">Lupa Kata Sandi</a>
                    <br>
                    <br>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                            Login
                        </button>
                    </div>
                    <div class="form-group">
                        {{-- <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4" > --}}
                            <a href="{{ url('login/google') }}" class="btn btn-primary btn-lg btn-block">Login with Google</a>

                    </div>
                </form>
            </div>
        </div>
        <div class="simple-footer">
            Belum punya akun? <a href="{{url('registerpemohon')}}" class="text-main">Register Sekarang</a>
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
  <script src="https://accounts.google.com/gsi/client" async defer ></script>
    <script>
        (function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
})()
    </script>

<script>

  @if (session('berhasilLogin'))
  iziToast.success({
      icon: 'fa fa-save',
      message: 'Berhasil Mendaftar, Login Sekarang!',
  });
  @endif

</script>
</body>

</html>