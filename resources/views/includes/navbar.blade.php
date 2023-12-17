<nav class="navbar navbar-expand-lg main-navbar">
  <form class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
      <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
    </ul>
  </form>
  <ul class="navbar-nav navbar-right">
    @if(Auth::user()->role_id == 9)
    <li class="nav-item mt-1 {{Request::is('/') ? 'active' : ''}}">
      <a class="nav-link" href="{{route('homepage')}}">Beranda</a>
    </li>
    <li class="nav-item mt-1 {{Request::is('buat-permohonan') || Request::is('ajukan-perizinan') || Request::is('ajukan-syarat-perizinan') || Request::is('perizinan-berhasil-diajukan')? 'active' : ''}}">
      <a class="nav-link" href="{{route('buat-perizinan')}}"
        >Buat Permohonan</a
      >
    </li>
    <li class="nav-item mt-1 {{Request::is('permohonan-saya') ? 'active' : ''}}">
      <a class="nav-link" href="{{route('list-perizinan')}}"
        >Permohonan Saya</a
      >
    </li>
    <li class="nav-item mt-1 {{Request::is('arsip') ? 'active' : ''}}">
      <a class="nav-link" href="{{url('arsip')}}"
        >Arsip Perizinan</a
      >
    </li>
    <li class="nav-item mt-1 {{Request::is('lacak-perizinan') || Request::is('detail-perizinan') ? 'active' : ''}}">
      <a class="nav-link" href="{{route('lacak-perizinan')}}"
        >Lacak Perizinan</a
      >
    </li>
    @endif
    @php
    use Carbon\Carbon;
    $notifications = DB::table('notifikasi')->where('user_id', auth()->id())->where('is_seen', 'N')->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
    @endphp
    <li class="nav-item dropdown notifikasi pt-1">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-bell"></i>
          <small class="badge">{{ DB::table('notifikasi')->where('user_id', auth()->id())->where('is_seen','N')->count() }}</small>
      </a>
      <!-- Dropdown Notifikasi -->
      <ul class="dropdown-menu pt-0">
          <li class="head-dropdown-notif">
            <div class="row justify-content-between d-flex">
                <strong class="col-4 text-left">Notifikasi</strong>
                <a href="{{ url('semua-notifikasi') }}" class="col-4 text-decoration-none text-main justify-content-end"><strong>Lihat Semua</strong></a>
            </div>
          </li>
          @forelse($notifications as $notification)
              <li>
                  <strong>{{ $notification->judul }}</strong>
                  @if(strlen($notification->deskripsi) > 50)
                  <p class="my-2">
                {{ substr($notification->deskripsi, 0, 50) }}...
                    <small><a href="semua-notifikasi" class="text-main text-decoration-none">Selengkapnya</a></small>
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
    <li class="dropdown"><a href="#" data-toggle="dropdown"
        class="nav-link dropdown-toggle nav-link-lg nav-link-user">

        @if (Auth::user()->avatar)
        <img alt="image" src="{{asset(Auth::user()->avatar)}}" class="rounded-circle mr-1 navbarFotoProfile">
        @else
        <img alt="image" src="{{asset('assets/img/avatar/avatar-1.png')}}" class="rounded-circle mr-1 navbarFotoProfile">
        @endif
        <div class="d-sm-none nameUser d-lg-inline-block">@php
         echo Auth::user()->nama_lengkap;
        @endphp</div>
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <a href="{{ url('profil-pengguna')}}" class="dropdown-item has-icon">
          <i class="far fa-user"></i> Profile
        </a>
        <div class="dropdown-divider"></div>
      <a href="{{ url('logout') }}" class="dropdown-item has-icon text-danger">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </div>
    </li>
  </ul>
</nav>