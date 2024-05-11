@extends('frontend/template')


@section('head')
<style>
    .bg-breadcrumb {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(../frontend/assets/img/banner-bpjn-2.png);
    }
</style>
@endsection
@section('content')
<div id="banner-area" class="banner-area" style="background-image:url(/web/images/banner/banner1.jpg)">
    <div class="banner-text">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="banner-heading">
                        <h1 class="banner-title" id="kategori">{{$kategori}}</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Beranda</a></li>
                                <li class="breadcrumb-item"><a href="#">{{$kategori}}</a></li>
                            </ol>
                        </nav>
                    </div>
                </div><!-- Col end -->
            </div><!-- Row end -->
        </div><!-- Container end -->
    </div><!-- Banner text end -->
</div><!-- Banner area end -->

<section id="main-container" class="main-container">
    <div class="container">
        <div class="row">

            <div class="col-lg-8 mb-5 mb-lg-0">

                <div class="post-content post-single">
                    <div class="post-media post-image">
                        <img id="gambar" loading="lazy" class="img-fluid" alt="post-image">
                    </div>

                    <div class="post-body">
                        <div class="entry-header">
                            <div class="post-meta">
                                <span class="post-author">
                                    <i class="far fa-user"></i><a href="#"> Admin</a>
                                </span>
                                <span class="post-cat">
                                    <i class="far fa-folder-open"></i><a href="#"> <span id="jenis"></span></a>
                                </span>
                                <span class="post-meta-date"><i class="far fa-calendar"></i> June 14, 2016</span>
                                <span class="post-comment"><i class="far fa-comment"></i> <span id="komen"></span><a href="#" class="comments-link">Comments</a></span>
                            </div>
                            <h2 class="entry-title" id="judul">

                            </h2>
                        </div><!-- header end -->

                        <div class="entry-content" id="konten-isi">

                        </div>

                        <div class="tags-area d-flex align-items-center justify-content-between">

                            <div class="share-items">
                                <ul class="post-social-icons list-unstyled">
                                    <li class="social-icons-head">Share:</li>
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fab fa-google-plus"></i></a></li>
                                    <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                                </ul>
                            </div>
                        </div>

                    </div><!-- post-body end -->
                </div><!-- post content end -->


                <!-- Post comment start -->
                <div id="comments" class="comments-area">
                    <h3 class="comments-heading">07 Komentar</h3>

                    <ul class="comments-list">

                    </ul><!-- Comments-list ul end -->
                </div><!-- Post comment end -->

                <div class="comments-form border-box">
                    <h3 class="title-normal">Add a comment</h3>

                    <form role="form">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="message"><textarea class="form-control required-field" id="message" placeholder="Your Comment" rows="10" required></textarea></label>
                                </div>
                            </div><!-- Col 12 end -->

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name"><input class="form-control" name="name" id="name" placeholder="Your Name" type="text" required></label>
                                </div>
                            </div><!-- Col 4 end -->

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email"><input class="form-control" name="email" id="email" placeholder="Your Email" type="email" required></label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="website"><input class="form-control" id="website" placeholder="Your Website" type="text" required></label>
                                </div>
                            </div>

                        </div><!-- Form row end -->
                        <div class="clearfix">
                            <button class="btn btn-primary" type="submit" aria-label="post-comment">Post Comment</button>
                        </div>
                    </form><!-- Form end -->
                </div><!-- Comments form end -->
            </div><!-- Content Col end -->

            <div class="col-lg-4">

                <div class="sidebar sidebar-right">
                    <div class="widget recent-posts">
                        <h3 class="widget-title">{{$kategori}}</h3>
                        <ul class="list-unstyled" id="lainnya-list">

                        </ul>

                    </div><!-- Recent post end -->




                </div><!-- Sidebar end -->
            </div><!-- Sidebar Col end -->

        </div><!-- Main row end -->

    </div><!-- Conatiner end -->
</section><!-- Main container end -->
@endsection
@section('scripts')
<script>
    var slug = '{{ $slug }}';
    showKonten()
    async function showKonten() {
        let url = `${base_url}/api/list-konten?showall=1&is_web=1&slug=${slug}`
        let fetchRequest = await fetch(url)
        response = await fetchRequest.json()
        console.log(response);
        let data = response[0]
        let thumbnail = (data.thumbnail !== null) ? base_url + '/' + data.thumbnail : "{{ url('images/thumbnail.jpg') }}";

        document.querySelector('#gambar').src = thumbnail
        document.querySelector('#gambar').setAttribute('width', '100%')
        document.querySelector('#judul').innerText = data.judul
        document.querySelector('#jenis').innerText = data.jeniskonten.nama
        document.querySelector('#kategori').innerText = data.jeniskonten.nama
        document.querySelector('#konten-isi').innerHTML = data.isi
        // document.querySelector('#konten-isi').innerHTML = data.isi
        showLainnya(data.jeniskonten.slug)
        // document.getElementById('aplikasi-terkait').innerHTML = response[0].code

    }
    async function showLainnya(jenis) {

        let url = `${base_url}/api/list-konten?publikasi=1&is_web=true&limit=5&jenis=${jenis}`
        let fetchRequest = await fetch(url)
        response = await fetchRequest.json()
        console.log(response);
        // return 
        let contents = '';
        response.map((data, index) => {
            let thumbnail = (data.thumbnail !== null) ? base_url + '/' + data.thumbnail : "{{ url('images/thumbnail.jpg') }}";
            let link = '{{ route("konten",[":kategori",":slug"]) }}';
            link = link.replace(':kategori', data.jeniskonten.slug)
            link = link.replace(':slug', data.slug)
            if (jenis == "berita")
                contents += `
                        <li class="d-flex align-items-center">
                            <div class="posts-thumb">
                                <a href="#"><img loading="lazy" alt="img" src="${thumbnail}"></a>
                            </div>
                            <div class="post-info">
                                <h4 class="entry-title">
                                    <a href="${link}">${data.judul}</a>
                                </h4>
                            </div>
                        </li>`
            else
                contents += `<li><a href="${link}">${data.judul}</a></li>`
        })
        document.querySelector('#lainnya-list').innerHTML = ''
        document.querySelector('#lainnya-list').innerHTML = contents
    }
</script>
@endsection