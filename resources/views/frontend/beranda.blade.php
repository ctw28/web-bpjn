@extends('frontend/template')

@section('head')
<script>
    // document.addEventListener('DOMContentLoaded', function() {
</script>
<style>
    .news-container {
        width: 100%;
        overflow: hidden;
        color: #fff;
    }

    .news-ticker {
        white-space: nowrap;
    }
</style>
@endsection
@section('content')
<div class="banner-carousel banner-carousel-2 mb-0" id="slide">
</div>
<div class="col-12" style="background-color:#2c3e50; padding: 10px" id="konten">
    <div class="container">

        <div class="row">
            <div class="col-1">
                <span style="border-radius:10px; background-color: #fba026; padding:1% 5%; color:#000">
                    PENGUMUMAN
                </span>
            </div>
            <div class="col-10" style="margin-left:5%">
                <div class="btn-group" role="group">
                    <a style="color: #fff; margin-right:10%" href="#" id="prevButton"><i class="fas fa-chevron-left"></i></a>
                    <div class="news-container">
                        <div id="newsTicker" class="news-ticker"></div>
                    </div>
                    <a style="color: #fff; margin-left:10%" href="#" id="nextButton"><i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-12" style="background-color:#cbd6c9; padding: 10px">
    <div class="container">
        <div class="row" style="vertical-align:middle">
            <div class="col-1" style="vertical-align:middle">
                <span style="color: #000;" style="vertical-align:middle">PENCARIAN</span>
            </div>
            <div class="col-7" style="margin-left:5%">
                <div class="row">
                    <div class="col-9">
                        <input style="background:#fff" type="text" class="form-control form-control-name" style="padding: 5px 10px" placeholder="Cari berita/pengumuman/galeri di sini">
                    </div>
                    <div class="col-3">
                        <button style="color: #fff;" type="button" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Cari</button>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 text-center text-lg-end">
                <div class="d-flex align-items-center justify-content-end">
                    <a id="instagram" href="#" class="btn btn-light btn-square border rounded-circle nav-fill me-3"><i class="fab fa-instagram"></i></a>
                    <a id="youtube" href="#" class="btn btn-light btn-square border rounded-circle nav-fill me-3"><i class="fab fa-youtube"></i></a>
                    <a id="facebook" href="#" class="btn btn-light btn-square border rounded-circle nav-fill me-3"><i class="fab fa-facebook-f"></i></a>
                    <a id="twitter" href="#" class="btn btn-light btn-square border rounded-circle nav-fill me-3"><i class="fab fa-twitter"></i></a>
                </div>
            </div>

        </div>
    </div>
</div>
<section id="news" class="news">
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <!-- <h2 class="section-title">Work of Excellence</h2> -->
                <h3 class="section-sub-title">Berita Terbaru</h3>
            </div>
        </div>
        <!--/ Title row end -->

        <div class="row" id="berita-container">


        </div>
        <!--/ Content row end -->

        <div class="general-btn text-center mt-4">
            <a class="btn btn-primary" href="{{route('web','berita')}}">Lihat Semua Berita</a>
        </div>

    </div>
    <!--/ Container end -->
</section>

<section id="project-area" class="project-area solid-bg">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-12">
                <!-- <h2 class="section-title">Work of Excellence</h2> -->
                <h3 class="section-sub-title">PROJEK KAMI</h3>
            </div>
        </div>
        <!--/ Title row end -->

        <div class="row">

            <div class="col-12">
                <div class="row" id="projek">
                    <!-- <div class="col-1 shuffle-sizer"></div> -->
                    <!-- <div ></div> -->
                </div><!-- shuffle end -->
            </div>

            <div class="col-12">
                <div class="general-btn text-center">
                    <a class="btn btn-primary" href="{{route('web','proyek')}}">Lihat Semua Proyek</a>
                </div>
            </div>

        </div><!-- Content row end -->
    </div>
    <!--/ Container end -->
</section><!-- Project area end -->

@endsection

@section('scripts')
<script>
    showPengumuman()
    showBerita()
    // showAplikasiTerkait()

    // showGaleri()
    showMediaSosial()
    async function showMediaSosial() {
        let url = `${base_url}/api/info-web`
        let fetchRequest = await fetch(url)
        response = await fetchRequest.json()
        // console.log('gg');
        console.log(response);
        document.getElementById('instagram').setAttribute('href', response.data[0].ig)
        document.getElementById('facebook').setAttribute('href', response.data[0].fb)
        document.getElementById('youtube').setAttribute('href', response.data[0].youtube)
        document.getElementById('twitter').setAttribute('href', response.data[0].twitter)
    }
    async function showGaleri() {
        var url = `${base_url}/api/list-galeri?is_web=true&showall=true`;
        console.log(url);
        let fetchRequest = await fetch(url)
        response = await fetchRequest.json()
        console.log(response);
        let contents = ''
        response.map(data => {
            contents += `
            <div class="col-md-6 col-lg-6 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                <div class="team-item rounded">
                    <div class="team-img rounded-top h-100">
                        <img src="{{asset('/')}}${data.path}" class="img-fluid rounded-top w-100" alt="">

                    </div>
                    <div class="team-content text-center border border-primary border-top-0 rounded-bottom p-4">
                        <h5>Nama Galeri</h5>
                        <p class="mb-0">tanggal</p>
                    </div>
                </div>
            </div>
            `
        })
        document.querySelector('#galeri').innerHTML = contents
    }



    async function showAplikasiTerkait() {
        let url = `${base_url}/api/get-html-code?is_web=true&showall=true&slug=aplikasi-terkait`
        let fetchRequest = await fetch(url)
        response = await fetchRequest.json()
        // console.log();
        document.getElementById('aplikasi-terkait').innerHTML = response[0].code

    }
    async function showPengumuman() {
        const newsTicker = document.getElementById('newsTicker');
        let url = `${base_url}/api/list-konten?jenis=pengumuman&is_web=true&limit=3&publikasi=1`
        let fetchRequest = await fetch(url)
        response = await fetchRequest.json()
        console.log(response);
        var headlines = [];
        response.map((data, index) => {
            var urlread = `${base_url}/konten/${data.jeniskonten.slug}/${data.slug}`

            headlines[index] = `<a style="color:#fff" href="${urlread}">${data.judul}</a>`
        })
        let index = 0;

        function displayHeadline() {
            newsTicker.innerHTML = `${headlines[index]}`;
        }
        document.getElementById('nextButton').addEventListener('click', function() {
            index = (index + 1) % headlines.length;
            displayHeadline();
        });
        document.getElementById('prevButton').addEventListener('click', function() {
            index = (index - 1 + headlines.length) % headlines.length;
            displayHeadline();
        });
        displayHeadline();
    }
    async function showBerita() {
        let url = `${base_url}/api/list-konten?jenis=berita&is_web=true&limit=6&publikasi=1`
        let fetchRequest = await fetch(url)
        response = await fetchRequest.json()
        console.log(response);
        // return 
        let contents = '';
        response.map((data, index) => {
            let thumbnail = (data.thumbnail !== null) ? data.thumbnail : "{{ url('images/thumbnail.jpg') }}";
            let link = '{{ route("konten",[":kategori",":slug"]) }}';
            link = link.replace(':kategori', data.jeniskonten.slug)
            link = link.replace(':slug', data.slug)
            contents += ` <div class="col-lg-4 col-md-6 mb-4">
                            <div class="latest-post">
                                <div class="latest-post-media">
                                    <a href="${link}" class="latest-post-img">
                                        <img loading="lazy" class="img-fluid" src="${thumbnail}" alt="img">
                                    </a>
                                </div>
                                <div class="post-body">
                                    <h4 class="post-title">
                                        <a href="${link}" class="d-inline-block">${data.judul}</a>
                                    </h4>
                                    <div class="latest-post-meta">
                                        <span class="post-item-date">
                                            <i class="fa fa-clock-o"></i> ${data.waktu}
                                            <i class="fa fa-eye-o"></i> ${data.komentar_count}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>`
        })
        document.querySelector('#berita-container').innerHTML = ''
        document.querySelector('#berita-container').innerHTML = contents
    }
    showProjek()
    async function showProjek() {
        let url = `${base_url}/api/list-konten?jenis=proyek&is_web=true&limit=6&publikasi=1`
        let fetchRequest = await fetch(url)
        response = await fetchRequest.json()
        console.log(response);
        // return 
        let contents = '';
        response.map((data, index) => {
            let thumbnail = (data.thumbnail !== null) ? data.thumbnail : "{{ url('images/thumbnail.jpg') }}";
            let link = '{{ route("konten",[":kategori",":slug"]) }}';
            link = link.replace(':kategori', data.jeniskonten.slug)
            link = link.replace(':slug', data.slug)
            contents += ` 
                    <div class="col-lg-4 col-md-6">
                        <div class="project-img-container">
                            <a class="gallery-popup" href="${link}" aria-label="project-img">
                                <img class="img-fluid" src="${thumbnail}" alt="project-img">
                            </a>
                            <div class="project-item-info">
                                <div class="project-item-info-content">
                                    <h4 class="project-item-title">
                                        <a href="${link}">${data.judul}</a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>`
        })
        // document.querySelector('#projek').innerHTML = ''
        document.querySelector('#projek').innerHTML = contents
    }
</script>
@endsection