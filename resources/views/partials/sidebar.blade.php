 <aside class="main-sidebar sidebar-light-primary elevation-4">
     <!-- Brand Logo -->
     <a href="{{ route('dashboard') }}" class="brand-link bg-primary bg-light">

         <img src="{{ Storage::url('') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
         <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <div class="user-panel mt-3 pb-3 mb-3 d-flex">
             <div class="image">
                 @if (auth()->user()->path_image == 'default.jpg')
                     <img src="{{ asset('assets/images/not.png') }}" class="img-circle elevation-2" alt="User Image">
                 @else
                     <img src="{{ Storage::url(auth()->user()->path_image ?? '') }}" class="img-circle elevation-2"
                         alt="User Image">
                 @endif
             </div>
             <div class="info">
                 <a href="javascript:void(0)" class="d-block">{{ auth()->user()->name }}</a>
             </div>
         </div>

         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                 data-accordion="false">

                 <li class="nav-item">
                     <a href="{{ route('dashboard') }}"
                         class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                         <i class="nav-icon fas fa-tachometer-alt"></i>
                         <p>
                             Dashboard
                         </p>
                     </a>
                 </li>

                 @if (Auth()->user()->hasRole('admin'))
                     <li class="nav-header">MASTER DATA</li>
                     <li class="nav-item">
                         <a href="{{ route('pemilihan.store') }}"
                             class="nav-link {{ request()->is('pemilihan*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-calendar-alt"></i>
                             <p>
                                 Jadwal Pemilihan
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ route('kelas.index') }}" class="nav-link {{ request()->is('kelas*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-university"></i>
                             <p>
                                 Data Kelas
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="" class="nav-link {{ request()->is('voters*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-users"></i>
                             <p>
                                 Data Siswa
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="" class="nav-link {{ request()->is('admin/perlengkapan*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-user"></i>
                             <p>
                                 Data Kandidat
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="" class="nav-link {{ request()->is('admin/perlengkapan*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-pencil-alt"></i>
                             <p>
                                 Data Voting
                             </p>
                         </a>
                     </li>

                     <li class="nav-header">LAPORAN</li>
                     <li class="nav-item">
                         <a href="" class="nav-link {{ request()->is('admin/report*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-file-pdf"></i>
                             <p>
                                 Rekapitulasi Voting
                             </p>
                         </a>
                     </li>
                 @endif

                 @if (auth()->user()->hasRole('admin'))
                     <li class="nav-header">MANAJEMEN PENGGUNA</li>
                     <li class="nav-item">
                         <a href="" class="nav-link {{ request()->is('admin/setting') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-users"></i>
                             <p>
                                 Data Pengguna
                             </p>
                         </a>
                     </li>
                     <li class="nav-header">PENGATURAN APLIKASI</li>
                     <li class="nav-item">
                         <a href="" class="nav-link {{ request()->is('admin/setting') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-cogs"></i>
                             <p>
                                 Setting
                             </p>
                         </a>
                     </li>
                 @else
                 @endif
                 <li class="nav-header">MANAJEMEN AKUN</li>
                 <li class="nav-item">
                     <a href="" class="nav-link {{ request()->is('user/profile') ? 'active' : '' }}">
                         <i class="nav-icon fas fa-user"></i>
                         <p>
                             Profil
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="" class="nav-link {{ request()->is('user/profile/password') ? 'active' : '' }}">
                         <i class="nav-icon fas fa-unlock"></i>
                         <p>
                             Ubah Password
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="javascript:void(0)" class="nav-link"
                         onclick="document.querySelector('#form-logout').submit()">
                         <i class="nav-icon fas fa-sign-in-alt"></i>
                         <p>
                             Logout
                         </p>
                     </a>
                     <form action="{{ route('logout') }}" method="post" id="form-logout">
                         @csrf
                     </form>
                 </li>
             </ul>
         </nav>
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>
