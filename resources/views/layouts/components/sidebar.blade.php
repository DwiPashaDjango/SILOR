    <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand mt-3">
            <div class="container">
              <img src="{{ asset('img/logo.png') }}" alt="logo" width="50" class="logo">
              <div class="title">
                <a href="#">
                  SILOR
                </a>
                
              </div>
            </div>
          </div>
          <div class="subtitle">
            <center>
              <span>(Sistem Informasi LogBook Residen)</span>
            </center>
          </div>
          <div class="sidebar-brand sidebar-brand-sm mt-3">
            <img src="{{ asset('img/logo.jpg') }}" alt="logo" width="50" class="">
          </div>
          <hr class="divide">
          <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{request()->is('dashboard') ? 'active' : ''}}"><a class="nav-link" href="{{route('dashboard')}}"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>
            @role('Admin')
              <li class="menu-header">Master Data</li>
              <li class="{{request()->is('admin/dosens') ? 'active' : ''}}"><a class="nav-link" href="{{route('dosens')}}"><i class="fas fa-user"></i> <span>Data Dosen</span></a></li>
              <li class="{{request()->is('admin/mahasiswas') ? 'active' : ''}}"><a class="nav-link" href="{{route('mhs')}}"><i class="fas fa-users"></i> <span>Data Mahasiswa</span></a></li>
              <li class="{{request()->is('admin/semesters*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin.semesters')}}"><i class="fas fa-list"></i> <span>Data Semester</span></a></li>
              <li class="{{request()->is('admin/matkuls*') ? 'active' : ''}}"><a class="nav-link" href="{{route('matkuls')}}"><i class="fas fa-book"></i> <span>Data Mata Kuliah</span></a></li>
              <li class="{{request()->is('admin/indikators*') ? 'active' : ''}}"><a class="nav-link" href="{{route('indikators')}}"><i class="fas fa-chart-line"></i> <span>Data Indikator Nilai</span></a></li>
              <li class="{{request()->is('admin/asesments*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin.asesments')}}"><i class="fas fa-chart-pie"></i> <span>Data Asesment</span></a></li>
            @endrole

            @role('Dosen')
              <li class="menu-header">Menu</li>
              <li class="{{request()->is('dosens/mahasiswas*') ? 'active' : ''}}"><a class="nav-link" href="{{route('dosen.mhs')}}"><i class="fas fa-users"></i> <span>List Mahasiswa</span></a></li>
              <li class="{{request()->is('dosens/reports*') ? 'active' : ''}}"><a class="nav-link" href="{{route('dosen.report')}}"><i class="fas fa-file"></i> <span>Laporan Kasus</span></a></li>
              <li class="{{request()->is('dosens/seminars*') ? 'active' : ''}}"><a class="nav-link" href="{{route('dosen.seminars')}}"><i class="fas fa-book"></i> <span>Seminar Mahasiswa</span></a></li>
              <li class="{{request()->is('dosens/jurnals*') ? 'active' : ''}}"><a class="nav-link" href="{{route('dosen.jurnals')}}"><i class="fas fa-journal-whills"></i> <span>Jurnal Mahasiswa</span></a></li>
              <li class="{{request()->is('dosens/asesments*') ? 'active' : ''}}"><a class="nav-link" href="{{route('dosen.asesments')}}"><i class="fas fa-chart-pie"></i> <span>Self Asesment</span></a></li>
            @endrole

            @role('Mahasiswa')
              <li class="menu-header">Menu</li>
              <li class="dropdown {{request()->is('portal/list*') ? 'active' : ''}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-layer-group"></i> <span>Daftar Nilai Mahasiswa</span></a>
                <ul class="dropdown-menu">
                  <li class="{{request()->is('portal/list/matkuls') ? 'active' : ''}}"><a class="nav-link" href="{{route('mhs.matkuls')}}">List Mata Kuliah</a></li>
                  <li class="{{request()->is('portal/list/matkuls/not-graduated') ? 'active' : ''}}"><a class="nav-link" href="{{route('mhs.matkuls.show')}}">Mata Kuliah Belum Lulus</a></li>
                </ul>
              </li>
              <li class="dropdown {{request()->is('portal/loogbook*') ? 'active' : ''}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-layer-group"></i> <span>LoogBook</span></a>
                <ul class="dropdown-menu">
                  <li class="{{request()->is('portal/loogbook/create') ? 'active' : ''}}"><a class="nav-link" href="{{route('mhs.loogbook.create')}}">Input LoogBook</a></li>
                  <li class="{{request()->is('portal/loogbook/list') ? 'active' : ''}}"><a class="nav-link" href="{{route('mhs.loogbook')}}">List LoogBook</a></li>
                </ul>
              </li>
              <li class="dropdown {{request()->is('portal/report*') ? 'active' : ''}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-layer-group"></i> <span>Laporan Kasus</span></a>
                <ul class="dropdown-menu">
                  <li class="{{request()->is('portal/report/uploads') ? 'active' : ''}}"><a class="nav-link" href="{{route('mhs.report.uploads')}}">Input Laporan Kasus</a></li>
                  <li class="{{request()->is('portal/report/presentation') ? 'active' : ''}}"><a class="nav-link" href="{{route('mhs.report.uploads.presentase')}}">Laporan Dipersentasekan</a></li>
                  <li class="{{request()->is('portal/report/list') ? 'active' : ''}}"><a class="nav-link" href="{{route('mhs.report.list')}}">List Laporan Kasus</a></li>
                </ul>
              </li>
              <li class="dropdown {{request()->is('portal/seminars*') ? 'active' : ''}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-layer-group"></i> <span>Seminar</span></a>
                <ul class="dropdown-menu">
                  <li class="{{request()->is('portal/seminars/uploads') ? 'active' : ''}}"><a class="nav-link" href="{{route('mhs.seminar.uploads')}}">Input Data Seminar</a></li>
                  <li class="{{request()->is('portal/seminars/list*') ? 'active' : ''}}"><a class="nav-link" href="{{route('mhs.seminar.list')}}">List Data Seminar</a></li>
                </ul>
              </li>
              <li class="dropdown {{request()->is('portal/jurnals*') ? 'active' : ''}}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-layer-group"></i> <span>Jurnal Reading</span></a>
                <ul class="dropdown-menu">
                  <li class="{{request()->is('portal/jurnals/uploads') ? 'active' : ''}}"><a class="nav-link" href="{{route('mhs.jurnal.uploads')}}">Input Jurnal</a></li>
                  <li class="{{request()->is('portal/jurnals/list*') ? 'active' : ''}}"><a class="nav-link" href="{{route('mhs.jurnal.list')}}">Daftar Jurnal</a></li>
                  <li class="{{request()->is('portal/jurnals/approved*') ? 'active' : ''}}"><a class="nav-link" href="{{route('mhs.jurnal.paid')}}">Daftr Jurnal Diterima</a></li>
                </ul>
              </li>
              <li class="{{request()->is('portal/asesments/list*') ? 'active' : ''}}"><a class="nav-link" href="{{route('mhs.asesment.list')}}"><i class="fas fa-chart-line"></i> <span>Self Asesment</span></a></li>
            @endrole
          </ul>    
        </aside>
    </div>