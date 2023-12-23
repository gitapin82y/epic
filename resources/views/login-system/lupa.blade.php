<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Lupa | EPIC</title>

    @include('includes.style')
</head>
<body>
    <div id="app">

  <!-- Modal -->
<div id="modalotp" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-warning py-4" style="background-color: #499DB1 !important">
        <h4 class="modal-title text-light">Verifikasi Kode OTP</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body bg-light">
            <div class="form-group">
                <label for="otp">Masukkan Kode OTP</label>
                <input id="otp"class="form-control" type="number" name="otp" id="otp" autofocus="">
                <div class="red" id="redotp" style="color: red; display:none;"><b>Kode OTP Salah!</b></div>
                *Masukkan kode OTP yang telah dikirim ke email anda
            </div>
            

            <div class="form-group">
            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4" onclick="confirmotp()">
             Konfirmasi
            </button>
            </div>

            <center id="kirimotp" style="display:none;">
            <div class="form-group">
            <a  class="btn-lg btn-block" style="font-size:14px; cursor:pointer;" tabindex="4" onclick="kirimotp()">
              Kirim Ulang Kode OTP
            </a>
            </div>
            </center>

            <div class="mt-2 text-muted text-center" id="containercounter">
                 Mohon tunggu dalam <span id="counterotp">60</span> detik untuk kirim ulang kode otp
            </div>
      </div>
      </div>
     </div>
  </div>
</div>

 <section class="section">
<div class="d-flex flex-wrap align-items-stretch">
    <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
        <div class="login-brand">
            <img src="{{asset("assets/logo/logo-epic.png")}}" alt="logo" width="100" class="shadow-light rounded-circle">
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <h4>Lupa Kata Sandi</h4>
            </div>

            <div class="card-body">
                <form class="needs-validation" novalidate="" method="GET" action="{{ url('dolupa') }}">
                    {{ csrf_field() }}
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email"class="form-control" type="email" name="email" id="email" placeholder="Email" autofocus="">
                        @if (session('email'))
                        <div class="red"  style="color: red"><b>Akun tidak ditemukan!</b></div>
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

<script>
    var email = ""
    @if (session('showmodal'))
    email = "{{Session::get('showmodal')}}"
    $("#modalotp").modal("show");
    @endif

    var count = 60, timer = setInterval(function() {
    $("#counterotp").html(count--);
    if(count == -1) {
        clearInterval(timer);
        $("#kirimotp").css("display", "");
        $("#containercounter").css("display", "none");
    }
    }, 1000);

    function kirimotp() {
      $.ajax({
      url: baseUrl + '/kirimotp',
      data: {email : email},
      dataType:'json',
      success:function(data){
      }
      });
    }

    function confirmotp() {
      let otp = $("#otp").val();
      $.ajax({
      url: baseUrl + '/confirmotp',
      data: {otp : otp},
      dataType:'json',
      success:function(data){
        if (data.status == 1) {
            window.location.href = "{{ url('/') }}" + "/changepassword?otp="+otp+"&email="+email;
        } else {
            $("#redotp").css("display", "");
        }
      }
      });
    }
</script>
</html>