<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand my-3">
            <a href="">
                <img src="{{asset("assets/logo/logo-epic.png")}}" alt="logo" width="50" class="shadow-light">
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="">EPIC</a>
        </div>
        <ul class="sidebar-menu pb-5">

            @if (Auth::user()->role_id ==9)
            <li class="menu-header text-black">Profil</li>

            <li class=""><a class="nav-link" href="{{ url('profil-pengguna') }}"><i class="fas fa-user"></i></i> <span>Profil Pengguna</span></a></li>
            @else
            <li class="menu-header text-black">Dashboard</li>

            <li class=""><a class="nav-link" href="{{ url('home') }}"><i class="fas fa-home"></i></i> <span>Dashboard</span></a></li>
            @endif
            @if (Auth::user()->role_id ==1)

            <li class="menu-header text-black">Master</li>

            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown "><i class="fas fa-window-restore"></i><span>Data Master</span></a>
                <ul class="dropdown-menu">
                    <li class=""><a class="nav-link" href="{{url('petugas')}}">Petugas</a></li>

                    <li class=""><a class="nav-link" href="{{ url('pemohon') }}">Pemohon</a></li>
                    <li class=""><a class="nav-link" href="{{ url('surat-jenis') }}">Jenis dan Syarat Perizinan</a></li>
                    <li class=""><a class="nav-link" href="{{ url('video-panduan') }}">Video Panduan</a></li>
                </ul>
            </li>
            @endif

        
            @if(Auth::user()->role_id != 9)
            <li class="menu-header text-black">Perizinan</li>
            <li class=""><a class="nav-link" href="{{ url('surat') }}"><i class="fas fa-file-alt"></i><span>Daftar Perizinan</span></a></li>

            <li class=""><a class="nav-link" href="{{ url('arsip') }}"><i class="fas fa-folder-open"></i><span>Arsip Perizinan</span></a></li>
            @endif

            @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 6)

            <li class="menu-header text-black">Survey</li>

            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown "><i class="fas fa-window-restore"></i><span>Survey</span></a>
                <ul class="dropdown-menu">
                    <li class=""><a class="nav-link" href="{{url('penugasan-survey')}}">Penugasan Survey</a></li>

                    <li class=""><a class="nav-link" href="{{ url('hasil-survey') }}">Hasil Survey</a></li>
                </ul>
            </li>
            @endif

            @if (Auth::user()->role_id == 1)

            <li class="menu-header text-black">Survey Kepuasan</li>

            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown "><i class="fas fa-window-restore"></i><span>Survey Kepuasan</span></a>
                <ul class="dropdown-menu">
                    <li class=""><a class="nav-link" href="{{url('hasil-kepuasan')}}">Hasil Kepuasan</a></li>

                    <li class=""><a class="nav-link" href="{{ url('survey-kepuasan/management-pertanyaan') }}">Kelola Pertanyaan</a></li>
                </ul>
            </li>
            @endif

            @if (Auth::user()->role_id == 5)

            <li class=""><a class="nav-link" href="{{ url('chatbot') }}"><i class="fas fa-file-alt"></i><span>Chatbot</span></a></li>
            @endif

            @if (Auth::user()->role_id != 1)
            <li class="menu-header text-black">Master</li>
            <li class=""><a class="nav-link" href="{{ url('video-panduan') }}"><i class="fas fa-video"></i><span>Video Panduan</span></a></li>
            @endif

            @if (Auth::user()->role_id == 7 || Auth::user()->role_id == 9 || Auth::user()->role_id == 5)

            <li class=""><a class="nav-link" href="{{ url('chat') }}"><i class="fas fa-comment"></i><span>Live Chat</span></a></li>

            @endif

            @if (Auth::user()->role_id == 9)
            <li class=""><a class="nav-link" type="button" data-toggle="modal" data-target="#penilaianApp"><i class="fas fa-star"></i><span>Penilaian App</span></a></li>            
            @endif
            
        </ul>
    </aside>
</div>
@include('modal-penilaian')