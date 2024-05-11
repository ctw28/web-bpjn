<!--
 // WEBSITE: https://themefisher.com
 // TWITTER: https://twitter.com/themefisher
 // FACEBOOK: https://www.facebook.com/themefisher
 // GITHUB: https://github.com/themefisher/
-->

<!-- 
THEME: Constra - Construction Html5 Template
VERSION: 1.0.0
AUTHOR: Themefisher

HOMEPAGE: https://themefisher.com/products/constra-construction-template/
DEMO: https://demo.themefisher.com/constra/
GITHUB: https://github.com/themefisher/Constra-Bootstrap-Construction-Template

WEBSITE: https://themefisher.com
TWITTER: https://twitter.com/themefisher
FACEBOOK: https://www.facebook.com/themefisher
-->

<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Basic Page Needs
================================================== -->
    <meta charset="utf-8">
    <title>BPJN Sulawesi Tenggara</title>

    <!-- Mobile Specific Metas
================================================== -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Construction Html5 Template">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name=author content="Themefisher">
    <meta name=generator content="Themefisher Constra HTML Template v1.0">

    <!-- Favicon
================================================== -->
    <link rel="icon" type="image/png" href="{{asset('/')}}web/logo_pu.jpeg">

    <!-- CSS
================================================== -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{asset('/')}}web/plugins/bootstrap/bootstrap.min.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="{{asset('/')}}web/plugins/fontawesome/css/all.min.css">
    <!-- Animation -->
    <link rel="stylesheet" href="{{asset('/')}}web/plugins/animate-css/animate.css">
    <!-- slick Carousel -->
    <link rel="stylesheet" href="{{asset('/')}}web/plugins/slick/slick.css">
    <link rel="stylesheet" href="{{asset('/')}}web/plugins/slick/slick-theme.css">
    <!-- Colorbox -->
    <link rel="stylesheet" href="{{asset('/')}}web/plugins/colorbox/colorbox.css">
    <!-- Template styles-->
    <link rel="stylesheet" href="{{asset('/')}}web/css/style.css">
    <script>
        var base_url = "{{ url('/') }}";
    </script>
    @yield('head')
</head>

<body>
    <div class="body-inner">

        <div id="top-bar" class="top-bar">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-8">
                        <ul class="top-info text-center text-md-left">
                            <li>
                                <a href="https://binamarga.pu.go.id"><i class="fa fa-arrow-circle-left "></i> web binarmarga</a>
                            </li>
                        </ul>
                    </div>
                    <!--/ Top info end -->

                    <div class="col-lg-4 col-md-4 top-social text-center text-md-right">
                        <span id="date-time"></span>
                        <!-- <ul class="list-unstyled">
                            <li>
                                <a title="Facebook" href="{{asset('/')}}web/https://facebbok.com/themefisher.com">
                                    <span class="social-icon"><i class="fab fa-facebook-f"></i></span>
                                </a>
                                <a title="Twitter" href="{{asset('/')}}web/https://twitter.com/themefisher.com">
                                    <span class="social-icon"><i class="fab fa-twitter"></i></span>
                                </a>
                                <a title="Instagram" href="{{asset('/')}}web/https://instagram.com/themefisher.com">
                                    <span class="social-icon"><i class="fab fa-instagram"></i></span>
                                </a>
                                <a title="Linkdin" href="{{asset('/')}}web/https://github.com/themefisher.com">
                                    <span class="social-icon"><i class="fab fa-github"></i></span>
                                </a>
                            </li>
                        </ul> -->
                    </div>
                    <!--/ Top social end -->
                </div>
                <!--/ Content row end -->
            </div>
            <!--/ Container end -->
        </div>
        <!--/ Topbar end -->
        <!-- Header start -->
        <header id="header" class="header-two">
            <div class="site-navigation">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <nav class="navbar navbar-expand-lg navbar-light p-0">

                                <div class="logo">
                                    <a class="d-block" href="{{url('/')}}">
                                        <img loading="lazy" src="{{asset('/')}}web/logo_pu.jpeg" alt="Logo"> BPJN Sulawesi Tenggara
                                    </a>
                                </div><!-- logo end -->

                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>

                                <div id="navbar-collapse" class="collapse navbar-collapse">
                                    <ul class="nav navbar-nav ml-auto align-items-center" id="show-menu">

                                    </ul>
                                </div>
                            </nav>
                        </div>
                        <!--/ Col end -->
                    </div>
                    <!--/ Row end -->
                </div>
                <!--/ Container end -->

            </div>
            <!--/ Navigation end -->
        </header>
        <!--/ Header end -->


        @yield('content')


        <footer id="footer" class="footer bg-overlay">
            <div class="footer-main">
                <div class="container">
                    <div class="row justify-content-between">
                        <div class="col-lg-4 col-md-6 footer-widget footer-about">
                            <h3 class="widget-title">Tentang Kami</h3>
                            <b id="nama-kantor"></b>
                            <br> <i class="fa fa-map"></i> <span class="text-right" id="alamat-kantor"></span>
                            <br> <i class="fa fa-envelope"></i> <span class="text-right" id="email-kantor">09:00 - 12:00</span>
                            <br> <i class="fa fa-phone"></i> <span class="text-right" id="telp-kantor">09:00 - 12:00</span>
                        </div><!-- Col end -->

                        <div class="col-lg-8 col-md-6 footer-widget mt-5 mt-md-0">
                            <div class="custom-code-html" data-slug="peta-lokasi"></div>

                        </div><!-- Col end -->

                        <!-- <div class="col-lg-3 col-md-6 mt-5 mt-lg-0 footer-widget">
                            <h3 class="widget-title">Services</h3>
                            <ul class="list-arrow">
                                <li><a href="{{asset('/')}}web/service-single.html">Pre-Construction</a></li>
                                <li><a href="{{asset('/')}}web/service-single.html">General Contracting</a></li>
                                <li><a href="{{asset('/')}}web/service-single.html">Construction Management</a></li>
                                <li><a href="{{asset('/')}}web/service-single.html">Design and Build</a></li>
                                <li><a href="{{asset('/')}}web/service-single.html">Self-Perform Construction</a></li>
                            </ul>
                        </div> -->
                    </div><!-- Row end -->
                </div><!-- Container end -->
            </div><!-- Footer main end -->

            <div class="copyright">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="copyright-info">
                                <span>Copyright &copy; <script>
                                        document.write(new Date().getFullYear())
                                    </script>, Designed &amp; Developed by <a href="{{asset('/')}}web/https://themefisher.com">Themefisher</a></span>
                            </div>
                        </div>


                    </div><!-- Row end -->

                    <div id="back-to-top" data-spy="affix" data-offset-top="10" class="back-to-top position-fixed">
                        <button class="btn btn-primary" title="Back to Top">
                            <i class="fa fa-angle-double-up"></i>
                        </button>
                    </div>

                </div><!-- Container end -->
            </div><!-- Copyright end -->
        </footer><!-- Footer end -->


        <!-- Javascript Files
  ================================================== -->

        <!-- initialize jQuery Library -->
        <script src="{{asset('/')}}web/plugins/jQuery/jquery.min.js"></script>
        <!-- Bootstrap jQuery -->
        <script src="{{asset('/')}}web/plugins/bootstrap/bootstrap.min.js" defer></script>
        <!-- Slick Carousel -->
        <script src="{{asset('/')}}web/plugins/slick/slick.min.js"></script>
        <script src="{{asset('/')}}web/plugins/slick/slick-animation.min.js"></script>
        <!-- Color box -->
        <script src="{{asset('/')}}web/plugins/colorbox/jquery.colorbox.js"></script>
        <!-- shuffle -->
        <script src="{{asset('/')}}web/plugins/shuffle/shuffle.min.js" defer></script>


        <!-- Google Map API Key-->
        <script src="{{asset('/')}}web/https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU" defer></script>
        <!-- Google Map Plugin-->
        <script src="{{asset('/')}}web/plugins/google-map/map.js" defer></script>

        <!-- Template custom -->
        <script src="{{asset('/')}}web/js/script.js"></script>
        <script src="{{ asset('js/myapp.js') }}"></script>

        <script>
            showWebInfo()

            async function showWebInfo() {
                let url = `${base_url}/api/info-web`
                let fetchRequest = await fetch(url)
                response = await fetchRequest.json()
                console.log(response);
                document.getElementById('nama-kantor').innerText = response.data[0].nama
                document.getElementById('alamat-kantor').innerText = response.data[0].alamat
                document.getElementById('email-kantor').innerText = response.data[0].email
                document.getElementById('telp-kantor').innerText = response.data[0].helpdesk
            }

            showMenu()
            async function showMenu() {
                let url = `${base_url}/api/load-menu-tree`
                let fetchRequest = await fetch(url)
                response = await fetchRequest.json()
                let contents = ''
                response.map((data, index) => {
                    if (index != 0) {
                        if (!data.inc) {
                            contents += `<li class=""nav-item">
                                            <a class="nav-link" href="${data.url}">${data.text}</a>
                                        </li>`
                        } else {
                            contents += ` <li class="nav-item dropdown">
                                            <a href="{{asset('/')}}web/#" class="nav-link dropdown-toggle" data-toggle="dropdown">${data.text} <i class="fa fa-angle-down"></i></a>
                                            <ul class="dropdown-menu" role="menu">
                                                
                                            `
                            data.inc.map(submenu => {
                                contents += `<li><a href="${base_url}/${submenu.url}">${submenu.text}</a></li>`
                            })
                            contents += `   </ul>
                                        </li>`
                        }
                    }
                })
                document.querySelector('#show-menu').innerHTML = contents

            }
            showSlide()


            function showSlide() {
                $.ajax({
                    url: base_url + '/api/get-slide-show?is_web=true&showall=true',
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        if (response.length > 0) {
                            var carouselInner = document.querySelector('#slide');
                            let item = ''
                            $.each(response, function(index, slide) {
                                item += `
                                        <div class="banner-carousel-item" style="background-image:url(${slide.path}">
                                            <div class="container">
                                                <div class="box-slider-content">
                                                    <div class="box-slider-text">
                                                        <h2 class="box-slide-title">Selamat Datang</h2>
                                                        <h3 class="box-slide-sub-title">Website Resmi BPJN Sulawesi Tenggara</h3>
                                                     
                                                       
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`;
                            });
                            $('#slide').slick('slickAdd', item);
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
                return;
            }
            tampilDateTime()

            function tampilDateTime() {
                var date = new Date();
                var tahun = date.getFullYear();
                var bulan = date.getMonth();
                var tanggal = date.getDate();
                var hari = date.getDay();
                var jam = date.getHours();
                var menit = date.getMinutes();
                var detik = date.getSeconds();
                switch (hari) {
                    case 0:
                        hari = "Minggu";
                        break;
                    case 1:
                        hari = "Senin";
                        break;
                    case 2:
                        hari = "Selasa";
                        break;
                    case 3:
                        hari = "Rabu";
                        break;
                    case 4:
                        hari = "Kamis";
                        break;
                    case 5:
                        hari = "Jum'at";
                        break;
                    case 6:
                        hari = "Sabtu";
                        break;
                }
                switch (bulan) {
                    case 0:
                        bulan = "Januari";
                        break;
                    case 1:
                        bulan = "Februari";
                        break;
                    case 2:
                        bulan = "Maret";
                        break;
                    case 3:
                        bulan = "April";
                        break;
                    case 4:
                        bulan = "Mei";
                        break;
                    case 5:
                        bulan = "Juni";
                        break;
                    case 6:
                        bulan = "Juli";
                        break;
                    case 7:
                        bulan = "Agustus";
                        break;
                    case 8:
                        bulan = "September";
                        break;
                    case 9:
                        bulan = "Oktober";
                        break;
                    case 10:
                        bulan = "November";
                        break;
                    case 11:
                        bulan = "Desember";
                        break;
                }
                var tampilTanggal = hari + ", " + tanggal + " " + bulan + " " + tahun;
                var tampilWaktu = "Jam: " + jam + ":" + menit + ":" + detik;
                document.querySelector('#date-time').innerHTML = `${tampilTanggal}, ${tampilWaktu}`
            }
        </script>
        @yield('scripts')
    </div><!-- Body inner end -->
</body>

</html>