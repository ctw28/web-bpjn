@extends('template_website')

@section('head')
    <title>Halaman Utama</title>
@endsection

@section('container')

<!-- Konten Utama -->
<div class="container mt-10">
    <div id="slideWeb" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="{{ url('images/1.jpg') }}" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
          <img src="{{ url('images/2.jpg') }}" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="{{ url('images/3.jpg') }}" class="d-block w-100" alt="...">
          </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#slideWeb" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#slideWeb" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>

    <!-- Pengumuman -->
    <div class="mt-3" id="pengumuman" style="display: none;">
      <h2>Pengumuman</h2>
      <div class="row" id="card-pengumuman">
      </div>
    </div>

    <!-- Tentang Kami -->
    <div class="text-bg-secondary p-3 mt-3" style="text-align: center;">
      <h2>Tentang Kami</h2>
      <div id="tentang-kami"></div>
    </div>

    <!-- List Berita Terbaru -->
    <div class="mt-3" id="berita" style="display: none;">
      <h2>Berita Terbaru</h2>
      <div class="row" id="card-berita">
      </div>
      <ul class="list-group" id="list-berita">
      </ul>
    </div>
  
    <!-- List Download Terbaru -->
    <div class="mt-3" id="file">
      <h2>Download Terbaru</h2>
      <ul class="list-group" id="list-file">
      </ul>
    </div>

    <!-- Map Lokasi Kantor -->
    <div class="row mt-3">
      <div class="col-md-9 custom-code-html" data-slug="peta-lokasi"></div>
      <div class="col-md-3"> 
        <div class="custom-code-html" data-slug="visitor"></div>
        <div class="custom-code-html" data-slug="link-terkait"></div>
    </div>
    </div>

  </div>
@endsection

@section('script')
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
                  var link='{{ url("konten-read") }}'+'/'+konten.slug; 
                  var statistik=`<span class="badge text-bg-info">
                                      <i class="bi bi-view-list"></i> ${konten.jumlah_akses}  
                                      <i class="bi bi-hand-thumbs-up"></i> ${konten.likedislike_count}  
                                      <i class="bi bi-chat-right-text"></i> ${konten.komentar_count}
                                  </span>`;
                  $('.row #card-pengumuman').append(`
                    <div class="col-md-${col_len}">
                      <div class="card mb-3">
                        <img src="${thumbnail}" class="card-img-top" alt="${konten.judul}">
                        <div class="card-body">
                          <h5 class="card-title">${konten.judul}</h5>
                          <div>${konten.user.name} - ${konten.jeniskonten.nama}</div>
                          <div class="font-12">${konten.waktu}</div>
                          <div>${statistik}</div>

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
                  var link='{{ url("konten-read") }}'+'/'+konten.slug; 

                  var statistik=`<span class="badge text-bg-info">
                                      <i class="bi bi-view-list"></i> ${konten.jumlah_akses}  
                                      <i class="bi bi-hand-thumbs-up"></i> ${konten.likedislike_count}  
                                      <i class="bi bi-chat-right-text"></i> ${konten.komentar_count}
                                  </span>`;

                  if (index < 2) {
                    $('.row #card-berita').append(`
                      <div class="col-md-${col_len}">
                        <div class="card mb-3">
                          <img src="${thumbnail}" class="card-img-top" alt="${konten.judul}">
                          <div class="card-body">
                            <h5 class="card-title">${konten.judul}</h5>
                            <div>${konten.user.name} - ${konten.jeniskonten.nama}</div>
                          <div class="font-12">${konten.waktu}</div>
                          <div>${statistik}</div>
                            <p class="card-text">${konten.pembuka}</p>
                            <a href="${link}" class="btn btn-primary">Baca Selengkapnya</a>
                          </div>
                        </div>
                      </div>`);
                  } else {
                    $('#list-berita').append(`
                      <li class="list-group-item">
                        <img src="${thumbnail}" width="150px" style="float:left;margin:5px;">
                        <a href="${link}">${konten.judul}</a>
                        <div>${konten.user.name} - ${konten.jeniskonten.nama}</div>
                        <div class="font-12">${konten.waktu}</div>
                        <div>${statistik}</div>
                      </li>`);
                  }
                });  
              }          
            },
            error: function() {
              alert('berita tidak ditemukan!');
            }
        });
      }  
      
      function tentangKami(){ 
        $.ajax({
            url: 'api/list-konten?slug=tentang-kami&is_web=1&publikasi=1&showall=1',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
              console.log(response);
              $('#tentang-kami').html(response[0].isi);
            },
            error: function() {
              console.log('berita tidak ditemukan!');
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
                  var linkfile='{{ url("/") }}'+'/'+konten.path;
                  var link='{{ url("file-read") }}'+'/'+konten.slug; 

                  var statistik=`<span class="badge text-bg-info">
                                      <i class="bi bi-view-list"></i> ${konten.jumlah_akses}  
                                      <i class="bi bi-hand-thumbs-up"></i> ${konten.likedislike_count}  
                                      <i class="bi bi-chat-right-text"></i> ${konten.komentar_count}
                                  </span>`;

                  $('#list-file').append(`
                    <li class="list-group-item">
                      <a href="${link}">${konten.judul}</a>
                      <div>${konten.user.name} - ${konten.jeniskonten.nama}</div>
                      <div class="font-12">${konten.waktu}</div>
                      <div>
                        <a href="${linkfile}" target="_blank"><i class="bi bi-box-arrow-down"></i></a>
                        ${statistik}
                      </div>
                    </li>`);
                });  
              }         
            },
            error: function() {
              alert(jenis+' tidak ditemukan!');
            }
        });
      }      

      $(document).ready(function() {
        pengumuman();
        tentangKami();
        berita();
        file();
        slideShow('#slideWeb');
      });
    </script>
@endsection
