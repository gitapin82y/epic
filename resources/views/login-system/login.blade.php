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
                <form action="" method="POST" class="needs-validation" novalidate="">
                    @csrf
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input id="username" type="username" class="form-control @error('username') is-invalid @enderror"
                            name="username" tabindex="1" value="{{old('username')}}" autofocus>
                            @error('username')
                            <i class="text-danger">{{ $message }}</i>
                            @enderror
    
                    </div>

                    <div class="form-group">
                        <div class="d-block">
                            <label for="password" class="control-label">Password</label>
                        </div>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password"
                            tabindex="2">
                        @error('password')
                            <i class="text-danger">{{ $message }}</i>
                        @enderror

                    </div>
                    <div class="form-group">
                        <a href="/dashboard" class="btn btn-primary btn-lg btn-block" tabindex="4">
                            Login
                        </a>
                    </div>
                    <div class="mt-2 text-muted text-center">
                        Tidak Punya Akun? <a href="/register">Daftar</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="simple-footer">
            Copyright &copy; EPIC 2023
        </div>
   

    </div>
<div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom" data-background="{{ asset('assets/img/unsplash/login-bg.jpg') }}">
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