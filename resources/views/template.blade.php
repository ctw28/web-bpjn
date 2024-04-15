<!DOCTYPE html>
<html lang="en">
<head>
  @include('partials_head')
  @yield('head')
</head>
<body>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Dashboard Website</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ url('/') }}">Halaman Depan Web</a>
          </li>
          @auth
          <li class="nav-item">
            <a class="nav-link" href="#">Dashboard</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Konten
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="{{ route('konten-web') }}">Artikel</a></li>
              <li><a class="dropdown-item" href="{{ route('file-web') }}">File</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarAdmin" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Administrator
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarAdmin">
              <li><a class="dropdown-item" href="{{ route('verifikasi-konten') }}">Verifikasi Konten</a></li>
              <li><a class="dropdown-item" href="{{ route('verifikasi-file') }}">Verifikasi File</a></li>
              <li><a class="dropdown-item" href="{{ route('verifikasi-komentar') }}">Verifikasi Komentar</a></li>
              <li><a class="dropdown-item" href="#">Kotak Saran</a></li>
              <li><a class="dropdown-item" href="{{ route('menu') }}">Menu</a></li>
              <hr class="dropdown-divider">
              <li><a class="dropdown-item" href="{{ route('pengaturan-web') }}">Pengaturan Web</a></li>
              <li><a class="dropdown-item" href="{{ route('jenis-konten') }}">Jenis Konten</a></li>
              <li><a class="dropdown-item" href="{{ route('grup') }}">Grup</a></li>
              <li><a class="dropdown-item" href="{{ route('akun') }}">Akun</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="javascript:;" onclick="logoutApi()">Keluar</a>
          </li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main content -->
  <div class="main-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-10 mx-auto"> <!-- Menggunakan mx-auto untuk membuat konten berada di tengah -->
            @yield('container')
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->

    <!-- Footer -->
    @include('partials_footer')    
    @yield('script')

</body>
</html>
