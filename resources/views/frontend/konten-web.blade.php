@extends('frontend/template')


@section('head')
<style>
    .bg-breadcrumb {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(/frontend/assets/img/banner-bpjn-2.png);
    }
</style>
@endsection
@section('content')

<section id="main-container" class="main-container">
    <div class="container">
        <div class="row">
            <h1>Semua {{ $kategori }}</h1>

            <div class="table-responsive">
                <table class="table">
                    <tbody id="data-list">
                        <!-- Data pesan akan dimuat di sini -->
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center" id="pagination">
                </ul>
            </nav>
        </div>
    </div>
</section>
@endsection
@section('scripts')

<script src="{{ asset('js/pagination.js') }}"></script>

<script>
    var vApiUrl = base_url;
    var vDataGrup = [];
    var vKategori = '{{"konten-web/".$kategori}}';
    var endPointList = base_url + '{{"/api/list-konten?jenis=".$kategori}}';

    $(document).ready(function() {
        loadData();
        // getMenu();

        $('.item-paging').on('click', function() {
            vPaging = $(this).data('nilai');
            loadData();
        })

        // function getMenu() {
        //     $.ajax({
        //         url: base_url + '/api/get-menu?search=' + vKategori + '&showall=true',
        //         method: 'GET',
        //         dataType: 'json',
        //         success: function(response) {
        //             vApiUrl = vApiUrl + '/' + endPointList;
        //             loadData();
        //         },
        //         error: function() {
        //             alert(jenis + ' tidak ditemukan!');
        //         }
        //     });
        // }

        function loadData(page = 1, search = '') {
            $.ajax({
                url: endPointList + '&is_web=true&publikasi=1&page=' + page + '&search=' + search,
                method: 'GET',
                success: function(response) {
                    var dataList = $('#data-list');
                    var pagination = $('#pagination');
                    dataList.empty();

                    $.each(response.data, function(index, dt) {
                        var hakakses = '';
                        var thumbnail = (dt.thumbnail !== null) ? dt.thumbnail : "images/thumbnail.jpg";
                        var urlread = base_url + '/konten-read/' + dt.slug;
                        dataList.append(`
                        <tr data-id="${dt.id}"> 
                            <td>
                                <img src="${base_url+'/'+thumbnail}" width="150px" style="float:left;margin:5px;">
                                <h5><a href="${urlread}">${dt.judul}</a></h5>                                
                                <div class='font-12'>${dt.slug}</div>
                                ${dt.pembuka}
                            </td> 
                            <td>
                                <div>${dt.user.name} - ${dt.jeniskonten.nama}</div>
                                <div class='font-12'><i class="bi bi-calendar-event"></i> ${dt.waktu}</div>
                                <div>
                                    <span class="badge text-bg-info">
                                        <i class="bi bi-view-list"></i> ${dt.jumlah_akses}  
                                        <i class="bi bi-hand-thumbs-up"></i> ${dt.likedislike_count}  
                                        <i class="bi bi-chat-right-text"></i> ${dt.komentar_count}
                                    </span>
                                </div>
                            </td> 
                        </tr>`);
                    });

                    renderPagination(response, pagination);
                }
            });
        }

        // Handle page change
        $(document).on('click', '.page-link', function() {
            var page = $(this).data('page');
            var search = $('#search-input').val();
            // alert(page);
            loadData(page, search);
        });

        // Handle search form submission
        $('.cari-data').click(function() {
            var search = $("#search-input").val();
            if (search.length > 3) {
                loadData(1, search);
            } else if (search.length === 0) {
                loadData(1, '');
            }
        });

    });
</script>
@endsection