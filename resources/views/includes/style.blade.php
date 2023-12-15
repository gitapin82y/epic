<!-- General CSS Files -->

<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/fontawesome/css/all.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" integrity="sha512-O03ntXoVqaGUTAeAmvQ2YSzkCvclZEcPQu1eqloPaHfJ5RuNGiS4l+3duaidD801P50J28EHyonCV06CUlTSag==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Template CSS -->
<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/components.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/bootstrap-datepicker3.min.css')}}">
{{-- css sendiri --}}
<link rel="stylesheet" href="{{asset('assets/css/all-style.css')}}">

<style>
    .select2-container{
        width: 100% !important;
    }

    .btn-main{
        background-color:#499db1 !important;
  color: white !important;
  padding: 10px 30px;
  border-radius: 60px;
    }
    .btn-white {
  color: #499db1;
  background-color: white;
  padding: 10px 30px;
  border: 1px solid #499db1 !important;
  border-radius: 60px;
}
.btn-white:hover {
  color: #499db1;
  border: 1px solid #499db1;
}
    .bg-main{
        background-color: #499db1;
    }
    .btn-update-profile{
        justify-content: center;
    }


    /* dashboard perizinan card*/
    .semua-perizinan{
      background-color: #9081EF;
    }
    .perizinan-masuk{
      background-color: #6FDC6C;
    }
.icon-card-dashboard{
  margin-bottom: 12px;
}
.main-content .card-wrap .card-header h4,
.main-content .card-wrap .card-body {
  color: white;
}
    .perizinan-terlambat{
      background-color: #EA7F7F;
    }

    .perizinan-dikembalikan{
      background-color: #FBC168;
    }

    .perizinan-diterbitkan{
      background-color: #48C8E5;
    }


    
    /* style notifikasi */

    .head-dropdown-notif{
      border-bottom: 1px solid #dbdbdb;
    }
        /* Tampilkan dropdown content saat menu dihover */
        .dropdown:hover .dropdown-content {
          display: block;
        }



        /* Styling untuk icon notifikasi */
.notifikasi .nav-link .fa-bell {
    font-size: 1.5rem;
}

/* Styling untuk badge notifikasi */
.notifikasi .nav-link .badge {
    background-color: rgb(255, 83, 83);
    color: #fff;
    border-radius: 50%;
    padding: 0.25rem 0.45rem;
    position: absolute;
    top: 0;
    right: 2px;
}

/* Styling untuk dropdown notifikasi */
.notifikasi .dropdown-menu {
    display: none;
    left:-350px !important;
    position: absolute;
    border: none;
    border-radius: 10px;
    background-color: #fff;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    z-index: 1;
    width: 400px !important;
}
.notifikasi .dropdown-toggle::after{
  display: none;
}
.notifikasi:hover .dropdown-menu {
    display: block;

    cursor:default;
}

/* Styling untuk item notifikasi di dropdown */
.notifikasi .dropdown-menu li {
    padding: 10px;
}

/* Styling untuk notifikasi yang sudah dilihat */
.notifikasi .dropdown-menu .text-muted {
    color: #777;
}
</style>