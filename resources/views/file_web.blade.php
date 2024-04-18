@extends('template_website')

@section('head')
    <title>File Web</title>
@endsection

@section('container')

    <h1>File Web {{ $kategori }}</h1>

    <div class="row">
        <div class="col-sm-12">
            <div class="input-group justify-content-end">
                <button type="button" class="btn btn-sm btn-outline-secondary btnRefresh" id="refresh">Refresh</button>
                <ul class="dropdown-menu dropdown-menu-end" id="list-select-paging">
                </ul>

            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">File Dokumen Web</th>
                    <th scope="col">Statistik</th>
                    <th scope="col">Waktu</th>
                </tr>
            </thead>
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
    
@endsection

@section('script')

<script src="{{ asset('js/myapp.js') }}"></script>
<script src="{{ asset('js/pagination.js') }}"></script>

<script>

var vApiUrl=base_url;
var vDataGrup=[];
var vKategori='{{ "file-web/".$kategori }}';

$(document).ready(function() {
    // loadData();
    getMenu();

    $('.item-paging').on('click', function() {
        vPaging=$(this).data('nilai');
        loadData();
    })

    function getMenu(){
        $.ajax({
            url: base_url+'/api/get-menu?search='+vKategori+'&showall=true',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                vApiUrl=vApiUrl+'/'+response[0].endpoint;
                loadData();
                // console.log(response);
            },
            error: function() {
                alert(jenis+' tidak ditemukan!');
            }
        });
    }      

    function loadData(page = 1, search = '') {
        $.ajax({
            url: vApiUrl+'&page=' + page + '&search=' + search,
            method: 'GET',
            success: function(response) {
                var dataList = $('#data-list');
                var pagination = $('#pagination');
                dataList.empty();

                $.each(response.data, function(index, dt) {
                    var hakakses='';
                        
                        // console.log(dt.aturgrup);
                        var publikasi='<span class="badge text-bg-warning">Belum diperiksa</span>';
                        var btnAksi=`<div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-primary btnGanti" data-id="${dt.id}" >Ganti</button>
                                        <button type="button" class="btn btn-danger btnHapus" data-id="${dt.id}" >Hapus</button>
                                    </div>`;
                        if(dt.publikasi){
                            // $waktu=myFormatDate(date)
                            publikasi=(dt.publikasi.is_publikasi)?`<span class="badge text-bg-success">Terpublikasi</span>`:`<span class="badge text-bg-danger">Ditolak</span>`;
                            publikasi+=`<div class="font-12">${myLabel(dt.publikasi.catatan)}</div><div class="font-12"><i class="bi bi-calendar-event"></i> ${myFormatDate(dt.publikasi.user.created_at)}</div>`;
                            publikasi+=`<div><i>${dt.publikasi.user.name}</i></div>`;
                            btnAksi='';
                        }
                        
                        dataList.append(`
                            <tr data-id="${dt.id}"> 
                                <td>${dt.nomor}</td> 
                                <td>
                                    <h5>${dt.judul}</h5>
                                    <div class='font-12'><i class="bi bi-calendar-event"></i> ${dt.waktu}</div>
                                    <div class='font-12'>${dt.slug}</div>
                                    <a href='${dt.path}' target='_blank'><i class="bi bi-box-arrow-down"></i> Download File Dokumen</a>
                                </td> 
                                <td>${dt.user.name}</td> 
                                <td>
                                    <span class="badge text-bg-info">
                                        <i class="bi bi-view-list"></i> ${dt.jumlah_akses}  
                                        <i class="bi bi-hand-thumbs-up"></i> ${dt.likedislike.length}  
                                        <i class="bi bi-chat-right-text"></i> ${dt.komentar.length}
                                    </span>
                                </td> 
                                <td>${dt.updated_at_format}</td> 
                                <td>${btnAksi}</td>
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
        loadData(page, search);
    });

    $('#refresh').on('click', function(e) {
        loadData();
    });

    // Handle search form submission
    $('.cari-data').click(function(){
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
