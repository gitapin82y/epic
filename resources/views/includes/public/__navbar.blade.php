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
        @if (Auth::check())
        <li class="nav-item {{Request::is('permohonan-saya') ? 'active' : ''}}">
          <a class="nav-link" href="{{route('list-perizinan')}}"
            >Permohonan Saya</a
          >
        </li>
        <li class="nav-item {{Request::is('arsip') ? 'active' : ''}}">
          <a class="nav-link" href="{{url('arsip')}}"
            >Arsip Perizinan</a
          >
        </li>
        @endif
        <li class="nav-item {{Request::is('lacak-perizinan') || Request::is('detail-perizinan') ? 'active' : ''}}">
          <a class="nav-link" href="{{route('lacak-perizinan')}}"
            >Lacak Perizinan</a
          >
        </li>
        @php
            use Carbon\Carbon;
            $notifications = DB::table('notifikasi')->where('user_id', auth()->id())->where('is_seen', 'N')->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        @endphp
        @if (Auth::check())
        <li class="nav-item dropdown notifikasi">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-bell"></i>
              <small class="badge">{{ DB::table('notifikasi')->where('user_id', auth()->id())->where('is_seen','N')->count() }}</small>
          </a>
          <!-- Dropdown Notifikasi -->
          <ul class="dropdown-menu pt-0">
              <li class="head-dropdown-notif">
                <div class="row justify-content-between d-flex">
                    <strong class="col-4 text-left">Notifikasi</strong>
                    <a href="{{route('semuaNotifikasi')}}" class="col-4 text-decoration-none text-main fw-bold justify-content-end">Lihat Semua</a>
                </div>
              </li>
              @forelse($notifications as $notification)
                  <li>
                      <strong>{{ $notification->judul }}</strong>
                      @if(strlen($notification->deskripsi) > 50)
                      <p class="my-2">
                    {{ substr($notification->deskripsi, 0, 50) }}...
                        <small><a href="{{route('semuaNotifikasi')}}" class="text-main text-decoration-none">Selengkapnya</a></small>
                      </p>
                @else
                   <p class="my-2">{{ $notification->deskripsi }}</p> 
                @endif
                      <small class="m-0 p-0 d-block text-muted">{{ Carbon::parse($notification->created_at)->format('d F Y')}}</small>
                  </li>
                  @empty
                  <li>
                    <p class="mt-4 text-center">Belum ada notifikasi terbaru</p>
                  </li>
              @endforelse
          </ul>
        </li>
        <li class="nav-item">
        <div class="dropdown">
          @if (Auth::user()->avatar)
          <img alt="image" src="{{asset(Auth::user()->avatar)}}" class="avatar mr-1 ms-2 me-1 ml-2">
          @else
          <img alt="image" src="{{asset('assets/img/avatar/avatar-1.png')}}" class="avatar mr-1 ms-2 me-1 ml-2">
          @endif
          {{Auth::user()->nama_lengkap}}
          <i class="fa-solid fa-chevron-down ms-1 ml-1"></i>
          <div class="dropdown-content">
            <a href="{{ url('profil-pengguna') }}">Profil</a>
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