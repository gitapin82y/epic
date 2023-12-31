<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login | EPIC</title>

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
                <h4>Login</h4>
            </div>

            <div class="card-body">
                <form class="needs-validation" novalidate="" method="GET" action="{{ url('login') }}">
                    {{ csrf_field() }}
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email"class="form-control" type="email" name="email" id="email" placeholder="Email" autofocus="">
                        @if (session('email'))
                        <div class="red"  style="color: red"><b>Email Tidak Ada</b></div>
                      @endif
                      @error('email')
                      <div class="red"  style="color: red"><b>{{ $message }}</b></div>
                      @enderror
    
                    </div>

                    <div class="form-group w-100">
                        <div class="d-block">
                            <label for="password" class="control-label">Password</label>
                        </div>
                        <div class="input-group">
                        <input class="form-control" type="password" name="password" id="password" required placeholder="Password">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fa fa-eye" id="togglePassword"></i>
                                </span>
                            </div>
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

<script>
  localStorage.setItem("selected", 0)
  const togglePassword = document.getElementById('togglePassword');
  const passwordInput = document.getElementById('password');

  console.log(passwordInput)

    togglePassword.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        togglePassword.classList.toggle('fa-eye-slash');
    });
</script>

</html>