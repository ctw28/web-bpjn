@extends('template_dashboard')

@section('head')
<title>Verifikasi File</title>
@endsection

@section('container')

<h1>Verifikasi File</h1>
<p>digunakan untuk verifikasi file pada website</p>


<div class="row">
    <div class="col-sm-12">
        <div class="input-group justify-content-end">
            <button type="button" class="btn btn-sm btn-outline-secondary btnRefresh" id="refresh">Refresh</button>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false" id="btn-paging">
                Paging
            </button>
            <ul class="dropdown-menu dropdown-menu-end" id="list-select-paging">
            </ul>

        </div>
    </div>
</div>

<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link item-tab active" aria-current="page" href="javascript:;" data-publikasi="2">Diajukan</a>
    </li>
    <li class="nav-item">
        <a class="nav-link item-tab" href="javascript:;" data-publikasi="1">Diterima</a>
    </li>
    <li class="nav-item">
        <a class="nav-link item-tab" href="javascript:;" data-publikasi="0">Ditolak</a>
    </li>
</ul>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">File Web</th>
                <th scope="col">Penulis</th>
                <th scope="col">Kategori/ Status Publikasi</th>
                <th scope="col">Statistik</th>
                <th scope="col">Waktu</th>
                <th scope="col">Aksi</th>
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

<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Verifikasi File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formFile">
                    <div class="row">
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="slug" id="slug">
                        <input type="hidden" name="jenis_konten_id" id="jenis_konten_id">
                        <input type="hidden" name="waktu" id="waktu">
                        <div class="col-sm-12 mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" class="form-control w-100" id="judul" name="judul" required>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi Dokumen</label>
                            <textarea class="form-control w-100" id="deskripsi" name="deskripsi" rows="4"></textarea>
                        </div>
                    </div>
                </form>

                <form id="formVerifikasi">
                    <div class="row">
                        <input type="hidden" name="id" id="formVerifikasi_id">
                        <input type="hidden" name="file_id" id="file_id">
                        <div class="col-sm-12 mb-3">
                            <hr>
                            <h3>Verifikasi</h3>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label for="is_publikasi" class="form-label">Status Publikasi</label>
                            <select class="form-control w-100" id="is_publikasi" name="is_publikasi" required>
                                <option value="1">Terima</option>
                                <option value="0">Tolak</option>
                            </select>
                        </div>
                        <div class="col-sm-8 mb-3">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea class="form-control w-100" rows="4" id="catatan" name="catatan"></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btnSimpan">Simpan</button>
            </div>
        </div>
    </div>
</div>



@endsection

@section('script')

<script src="{{ asset('js/pagination.js') }}"></script>
<script src="{{ asset('js/token.js') }}"></script>

<script>
    var vPublikasi = 2;
    var vApiUrl = 'api/file';
    var vDataGrup = [];

    var myModalForm = new bootstrap.Modal(document.getElementById('modalForm'), {
        keyboard: false
    });


    $(document).ready(function() {

        loadData();

        function resetForm() {
            $('#formFile input').val('');
            $('#formVerifikasi input').val('');
            $('#formFile')[0].reset();
            $('#formVerifikasi')[0].reset();
        }

        $('.item-tab').click(function() {
            $('.item-tab').removeClass('active');
            $(this).addClass('active');
            vPublikasi = $(this).data('publikasi');
            loadData();
        });

        $('.item-paging').on('click', function() {
            vPaging = $(this).data('nilai');
            loadData();
        })


        function loadData(page = 1, search = '') {
            $.ajax({
                url: vApiUrl + '?page=' + page + '&search=' + search + '&paging=' + vPaging + '&publikasi=' + vPublikasi,
                method: 'GET',
                success: function(response) {
                    var dataList = $('#data-list');
                    var pagination = $('#pagination');
                    dataList.empty();

                    $.each(response.data, function(index, dt) {
                        var hakakses = '';
                        var thumbnail = (dt.thumbnail) ? `<img src="${dt.thumbnail}" width="125px" style="float:left;margin:5px;">` : "";

                        // console.log(dt.aturgrup);
                        var publikasi = '<span class="badge text-bg-warning">Belum diperiksa</span>';
                        if (dt.publikasi) {
                            // $waktu=myFormatDate(date)
                            publikasi = (dt.publikasi.is_publikasi) ? `<span class="badge text-bg-success">Terpublikasi</span>` : `<span class="badge text-bg-danger">Ditolak</span>`;
                            publikasi += `<div class="font-12">${myLabel(dt.publikasi.catatan)}</div><div class="font-12"><i class="bi bi-calendar-event"></i> ${myFormatDate(dt.publikasi.user.created_at)}</div>`;
                            publikasi += `<div><i>${dt.publikasi.user.name}</i></div>`;
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
                                <div>${dt.jeniskonten.nama}</div>
                                ${publikasi}
                            </td> 
                            <td>
                                <span class="badge text-bg-info">
                                    <i class="bi bi-view-list"></i> ${dt.jumlah_akses}  
                                    <i class="bi bi-hand-thumbs-up"></i> ${dt.likedislike_count}  
                                    <i class="bi bi-chat-right-text"></i> ${dt.komentar_count}
                                </span>
                            </td> 
                            <td>${dt.updated_at_format}</td> 
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-primary btnVerifikasi" data-id="${dt.id}" >Verifikasi</button>
                                </div>
                            </td>
                        </tr>`);
                    });

                    renderPagination(response, pagination);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status === 401 && errorThrown === "Unauthorized") {
                        forceLogout('Akses ditolak! login kembali');
                    } else {
                        alert('operasi gagal dilakukan!');
                    }
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
        $('.cari-data').click(function() {
            var search = $("#search-input").val();
            if (search.length > 3) {
                loadData(1, search);
            } else if (search.length === 0) {
                loadData(1, '');
            }
        });

        $('#btnSimpan').on('click', function(event) {
            var selectedPage = $('.page-item.active .page-link').data('page');
            simpanKonten(selectedPage);
        });

        function simpanKonten(selectedPage) {
            if ($("#formFile").valid() && $("#formVerifikasi").valid()) { // Validasi form konten berita
                if (confirm('apakah anda yakin?')) {
                    $.ajax({
                        url: vApiUrl + '/' + $('#id').val(),
                        type: 'PUT',
                        data: $("#formFile").serialize(),
                        dataType: 'json',
                        success: function(response) {
                            toastr.success('operasi berhasil dilakukan!', 'berhasil');
                            verifikasiKonten(selectedPage);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            if (jqXHR.status === 401 && errorThrown === "Unauthorized") {
                                forceLogout('Akses ditolak! login kembali');
                            } else {
                                alert('operasi gagal dilakukan!');
                            }
                        }
                    });
                }
            }
        }

        function verifikasiKonten(selectedPage) {
            let vType = ($('#formVerifikasi_id').val() === '') ? 'POST' : 'PUT';
            let vUrl = 'api/publikasi';
            if (vType === 'PUT')
                vUrl = vUrl + '/' + $('#formVerifikasi_id').val();

            $.ajax({
                url: vUrl,
                type: vType,
                data: $("#formVerifikasi").serialize(),
                dataType: 'json',
                success: function(response) {
                    myModalForm.hide();

                    loadData(selectedPage);
                    toastr.success('publikasi berhasil dilakukan!', 'berhasil');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status === 401 && errorThrown === "Unauthorized") {
                        forceLogout('Akses ditolak! login kembali');
                    } else {
                        alert('operasi gagal dilakukan!');
                    }
                }
            });
        }

        $(document).on('click', '.btnVerifikasi', function() {
            var id = $(this).data('id');
            var selectedPage = $('.page-item.active .page-link').data('page');
            resetForm();
            $.ajax({
                url: vApiUrl + '/' + id,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#id').val(response.id);
                    $('#file_id').val(response.id);
                    $('#judul').val(response.judul);
                    $('#slug').val(response.slug);
                    $('#catatan').val(response.catatan);
                    $('#waktu').val(response.waktu);
                    $('#jenis_konten_id').val(response.jenis_konten_id);

                    if (response.publikasi) {
                        $('#formVerifikasi_id').val(response.publikasi.id);
                        $('#catatan').val(response.publikasi.catatan);
                        $('#is_publikasi').val(response.publikasi.is_publikasi);
                    }

                    myModalForm.show();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status === 401 && errorThrown === "Unauthorized") {
                        forceLogout('Akses ditolak! login kembali');
                    } else {
                        alert('operasi gagal dilakukan!');
                    }
                }
            });
        });

    });
</script>
@endsection