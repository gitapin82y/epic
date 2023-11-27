<div class="main-sidebar" >
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
            <li class="menu-header text-black">Dashboard</li>
            <li class=""><a class="nav-link" href=""><i
                        class="fas fa-home"></i></i> <span>Dashboard</span></a></li>


            <li class="menu-header text-black">Laporan</li>
            <li class=""><a class="nav-link"
                    href=""><i class="fas fa-file-alt"></i><span>Perizinan</span></a></li>

                    <li class="menu-header text-black">Master</li>
                    <li
                        class="nav-item dropdown">
                        <a href="#" class="nav-link has-dropdown "><i class="fas fa-window-restore"></i><span>Master Akun</span></a>
                        <ul class="dropdown-menu">
                            <li class=""><a class="nav-link"
                                    href="{{url('/petugas')}}">Petugas</a></li>
                                    
                                    <li class=""><a class="nav-link"
                                        href="">sub menu 2</a></li>
                        </ul>
                    </li>
        

        </ul>
    </aside>
</div>
