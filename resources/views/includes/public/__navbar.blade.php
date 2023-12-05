<nav class="navbar navbar-expand-lg w-100 ">
  <div class="container-fluid container">
    <a class="navbar-brand" href="{{url('/')}}">
      <img src="{{asset('assets/public/img/logo.png')}}" alt="" />
    </a>

    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarNavDropdown"
      aria-controls="navbarNavDropdown"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div
      class="collapse navbar-collapse justify-content-end"
      id="navbarNavDropdown"
    >
      <ul class="navbar-nav align-items-center text-right">
        <li class="nav-item {{Request::is('/') ? 'active' : ''}}">
          <a class="nav-link" href="{{route('homepage')}}">Beranda</a>
        </li>
        <li class="nav-item {{Request::is('buat-permohonan') || Request::is('ajukan-perizinan') || Request::is('ajukan-syarat-perizinan') || Request::is('perizinan-berhasil-diajukan')? 'active' : ''}}">
          <a class="nav-link" href="{{route('buat-perizinan')}}"
            >Buat Permohonan</a
          >
        </li>
        <li class="nav-item {{Request::is('permohonan-saya') ? 'active' : ''}}">
          <a class="nav-link" href="{{route('list-perizinan')}}"
            >Permohonan Saya</a
          >
        </li>
        <li class="nav-item {{Request::is('lacak-perizinan') || Request::is('detail-perizinan') ? 'active' : ''}}">
          <a class="nav-link" href="{{route('lacak-perizinan')}}"
            >Lacak Perizinan</a
          >
        </li>
        @if (Auth::check())
        <li class="nav-item">
        <div class="dropdown">
          <img src="{{asset('assets/public/avatar/avatar1.png')}}" class="avatar mr-1 ms-2 me-1 ml-2" alt="">
          {{Auth::user()->nama_lengkap}}
          <i class="fa-solid fa-chevron-down ms-1 ml-1"></i>
          <div class="dropdown-content">
            <a href="#">Profil Pengguna</a>
            <a href="{{ url('arsip') }}">Arsip Perizinan</a>
            <a href="#">Ulasan</a>
            <a href="{{ url('logout') }}">Logout</a>
          </div>
        </div>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link btn btn-main px-4 py-2 ml-0 ml-md-3" href="loginpemohon"
            >Masuk</a
          >
        </li>
        @endif
      </ul>
    </div>
  </div>
</nav>