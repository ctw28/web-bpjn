@extends('template_website')

@section('head')
    <title>Halaman Utama</title>
@endsection

@section('container')

<!-- Konten Utama -->
<div class="container mt-10">
    <!-- Gambar Berganti-ganti -->
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="{{ url('images/1.jpg') }}" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
          <img src="{{ url('images/2.jpeg') }}" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="{{ url('images/3.jpg') }}" class="d-block w-100" alt="...">
          </div>
          <!-- Tambahkan lebih banyak gambar jika diperlukan -->
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>

    <!-- List Berita Terbaru -->
    <div class="mt-5">
      <h2>List Berita Terbaru</h2>
      <ul class="list-group">
        <li class="list-group-item">Berita 1</li>
        <li class="list-group-item">Berita 2</li>
        <!-- Tambahkan lebih banyak berita jika diperlukan -->
      </ul>
    </div>

    <!-- List Download Terbaru -->
    <div class="mt-5">
      <h2>List Download Terbaru</h2>
      <ul class="list-group">
        <li class="list-group-item">Download 1</li>
        <li class="list-group-item">Download 2</li>
        <!-- Tambahkan lebih banyak item download jika diperlukan -->
      </ul>
    </div>

    <!-- Map Lokasi Kantor -->
    <div class="mt-5">
      <h2>Map Lokasi Kantor Kami</h2>
      <!-- Tambahkan map disini -->
    </div>

    <!-- Tentang Kami -->
    <div class="mt-5">
      <h2>Tentang Kami</h2>
      <p>Tulis teks tentang perusahaan Anda di sini.</p>
    </div>
  </div>
@endsection

@section('script')
    <script src="{{ asset('js/myapp.js') }}"></script>
    <script src="{{ asset('js/pagination.js') }}"></script>
    <script>


    </script>
@endsection
