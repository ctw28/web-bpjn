@extends('template_website')

@section('head')
    <title>Halaman Utama</title>
@endsection

@section('container')

<!-- Konten Utama -->
<div class="container mt-10">
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

    <div class="mt-2" id="pengumuman" style="display: none;">
      <h2>Pengumuman</h2>
      <div class="row" id="card-pengumuman">
      </div>
    </div>

    <!-- List Berita Terbaru -->
    <div class="mt-5" id="berita" style="display: none;">
      <h2>Berita Terbaru</h2>
      <div class="row" id="card-berita">
          <div class="col-md-6">
              <div class="card mb-3">
                  <img src="{{ url('images/thumbnail.jpg') }}" class="card-img-top" alt="Thumbnail Berita 1">
                  <div class="card-body">
                      <h5 class="card-title">Judul Berita 1</h5>
                      <p class="card-text">Deskripsi singkat tentang Berita 1.</p>
                      <a href="#" class="btn btn-primary">Baca Selengkapnya</a>
                  </div>
              </div>
          </div>
          <div class="col-md-6">
              <div class="card mb-3">
                  <img src="{{ url('images/thumbnail.jpg') }}" class="card-img-top" alt="Thumbnail Berita 2">
                  <div class="card-body">
                      <h5 class="card-title">Judul Berita 2</h5>
                      <p class="card-text">Deskripsi singkat tentang Berita 2.</p>
                      <a href="#" class="btn btn-primary">Baca Selengkapnya</a>
                  </div>
              </div>
          </div>
      </div>
      <ul class="list-group" id="list-berita">
        <li class="list-group-item">Berita 3</li>
        <li class="list-group-item">Berita 4</li>
        <li class="list-group-item">Berita 5</li>
        <li class="list-group-item">Berita 6</li>
      </ul>
    </div>
  
    <!-- List Download Terbaru -->
    <div class="mt-5" id="file">
      <h2>Download Terbaru</h2>
      <ul class="list-group" id="list-file">
        <li class="list-group-item">Download 1</li>
        <li class="list-group-item">Download 2</li>
      </ul>
    </div>

    <!-- Map Lokasi Kantor -->
    <div class="mt-5">
      <h2>Map Lokasi Kantor Kami</h2>
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
    <script>
      function pengumuman(){ 
        $.ajax({
            url: 'api/list-konten?jenis=pengumuman&is_web=true&limit=3&publikasi=1',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
              // console.log(response);
              var col_len=(response.length>2)?4:(12/response.length);
              if (response && response.length > 0) {
                $('#pengumuman').show();
                $('#card-pengumuman').html('');
                response.forEach(function(konten, index) {
                  var thumbnail=(konten.thumbnail!==null)?konten.thumbnail:"{{ url('images/thumbnail.jpg') }}";
                  var link='{{ url("read") }}'+'/'+konten.slug; 

                  $('.row #card-pengumuman').append(`
                    <div class="col-md-${col_len}">
                      <div class="card mb-3">
                        <img src="${thumbnail}" class="card-img-top" alt="${konten.judul}">
                        <div class="card-body">
                          <h5 class="card-title">${konten.judul}</h5>
                          <p class="card-text">${konten.pembuka}</p>
                          <a href="${link}" class="btn btn-primary">Baca Selengkapnya</a>
                        </div>
                      </div>
                    </div>`);
                });
              }
            },
            error: function() {
              alert('pengumuman tidak ditemukan!');
            }
        });
      }    

      function berita(){ 
        $.ajax({
            url: 'api/list-konten?jenis=berita&is_web=true&limit=6&publikasi=1',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
              // console.log(response);
              var col_len=(response.length>1)?6:12;
              if (response && response.length > 0) {
                $('#berita').show();
                $('#card-berita').html('');
                $('#list-berita').html('');
                response.forEach(function(konten, index) {
                  var thumbnail=(konten.thumbnail!==null)?konten.thumbnail:"{{ url('images/thumbnail.jpg') }}";
                  var link='{{ url("read") }}'+'/'+konten.slug; 
                  if (index < 2) {
                    $('.row #card-berita').append(`
                      <div class="col-md-${col_len}">
                        <div class="card mb-3">
                          <img src="${thumbnail}" class="card-img-top" alt="${konten.judul}">
                          <div class="card-body">
                            <h5 class="card-title">${konten.judul}</h5>
                            <p class="card-text">${konten.pembuka}</p>
                            <a href="${link}" class="btn btn-primary">Baca Selengkapnya</a>
                          </div>
                        </div>
                      </div>`);
                  } else {
                    $('#list-berita').append(`<li class="list-group-item"><a href="${link}">${konten.judul}</a></li>`);
                  }
                });  
              }          
            },
            error: function() {
              alert('berita tidak ditemukan!');
            }
        });
      }  
      
      function file(){
        $.ajax({
            url: 'api/list-file?is_web=true&limit=7&publikasi=1',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
              if (response && response.length > 0) {
                $('#file').show();
                $('#list-file').html('');
                response.forEach(function(konten, index) {
                  var link='{{ url("/") }}'+'/'+konten.path; 
                    $('#list-file').append(`<li class="list-group-item"><a href="${link}" target="_blank">${konten.judul}</a></li>`);
                });  
              }          
            },
            error: function() {
              alert(jenis+' tidak ditemukan!');
            }
        });
      }      

      $(document).ready(function() {
        berita();
        pengumuman();
        file();
      });
    </script>
@endsection
