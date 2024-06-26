@extends('template_dashboard')

@section('head')
<title>Artikel</title>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<link href="{{ asset('plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
@endsection

@section('container')

<h1>Artikel</h1>
<p>digunakan untuk mengelola artikel yang akan tampil website ini </p>

<div class="accordion mb-3" id="frmAcr">
    <div class="accordion-item">
        <h2 class="accordion-header" id="frm-acr-header">
            <button class="accordion-button collapsed" id="tambahForm" type="button" data-bs-toggle="collapse" data-bs-target="#bodyAcr" aria-expanded="false" aria-controls="aria-acr-controls">
                <h3>Formulir Artikel Web</h3>
            </button>
        </h2>
        <div id="bodyAcr" class="accordion-collapse collapse" aria-labelledby="frm-acr-header" data-bs-parent="#frmAcr">
            <div class="accordion-body">
                <form id="form" class="row">
                    <input type="hidden" name="id" id="id">
                    <div class="col-sm-7 mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control w-100" id="judul" name="judul" required>
                    </div>
                    <div class="col-sm-5 mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control w-100" id="slug" name="slug">
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label for="jenis_konten_id" class="form-label">Jenis</label>
                        <select class="form-control w-100" id="jenis_konten_id" name="jenis_konten_id" required></select>
                    </div>

                    <div class="col-sm-3 mb-3">
                        <label for="waktu" class="form-label">Tanggal Artikel</label>
                        <input type="text" class="form-control datepicker" id="waktu" name="waktu" value="{{ date('Y-m-d H:i:s') }}" required>
                    </div>
                    <div class="col-sm-12 mb-3">
                        <label for="editor" class="form-label">Isi Artikel</label>
                        <div id="editor-container">
                            <textarea id="editor" name="isi" required></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-9">
                            <label for="thumbnail" class="form-label">Thumbnail Artikel</label>
                            <input type="file" class="form-control w-100" id="thumbnail" name="file" accept="image/*">
                        </div>
                        <div class="col-sm-3">
                            <div id="preview-img"></div>
                        </div>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-warning btnBatal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="input-group justify-content-end">
            <button type="button" class="btn btn-sm btn-outline-secondary btnTambah" id="tambah">Tambah</button>
            <button type="button" class="btn btn-sm btn-outline-secondary btnRefresh" id="refresh">Refresh</button>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false" id="btn-paging">
                Paging
            </button>
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
                <th scope="col">Artikel Web</th>
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

@endsection

@section('script')

<script src="{{ asset('js/pagination.js') }}"></script>
<script src="{{ asset('js/token.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script src="{{ asset('plugins/bootstrap-material-moment/moment.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>

<script>
    var vApiUrl = base_url + '/' + 'api/konten';
    var vDataGrup = [];

    $(document).ready(function() {

        loadJenisKonten();
        loadData();

        $('.datepicker').bootstrapMaterialDatePicker({
            weekStart: 0,
            format: 'YYYY-MM-DD HH:mm:ss',
        });

        $('#editor').summernote({
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                onImageUpload: function(files) {
                    sendFile(files[0], $(this));
                }
            }
        });

        function sendFile(file, editor) {
            var data = new FormData();
            data.append("file", file);
            $.ajax({
                data: data,
                type: "POST",
                url: base_url + '/' + "api/upload-image-editor",
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    editor.summernote('insertImage', response.image);
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

        $('#thumbnail').on('change', function(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function() {
                var dataURL = reader.result;
                $('#preview-img').html('<img src="' + dataURL + '" width="100%" alt="Preview Image">');
            };
            reader.readAsDataURL(input.files[0]);
        });


        function loadJenisKonten() {
            $.ajax({
                url: base_url + '/' + 'api/get-jenis-konten?showall=true&kategori=artikel',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#jenis_konten_id').empty();
                    $.each(response, function(index, jenisKonten) {
                        $('#jenis_konten_id').append('<option value="' + jenisKonten.id + '">' + jenisKonten.nama + '</option>');
                    });
                    // console.log(response);
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

        $('.item-paging').on('click', function() {
            vPaging = $(this).data('nilai');
            loadData();
        })


        function loadData(page = 1, search = '') {
            $.ajax({
                url: vApiUrl + '?page=' + page + '&search=' + search + '&paging=' + vPaging,
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
                        var btnAksi = `<div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-primary btnGanti" data-id="${dt.id}" >Ganti</button>
                                    <button type="button" class="btn btn-danger btnHapus" data-id="${dt.id}" >Hapus</button>
                                </div>`;
                        if (dt.publikasi) {
                            // $waktu=myFormatDate(date)
                            publikasi = (dt.publikasi.is_publikasi) ? `<span class="badge text-bg-success">Terpublikasi</span>` : `<span class="badge text-bg-danger">Ditolak</span>`;
                            publikasi += `<div class="font-12">${myLabel(dt.publikasi.catatan)}</div><div class="font-12"><i class="bi bi-calendar-event"></i> ${myFormatDate(dt.publikasi.user.created_at)}</div>`;
                            publikasi += `<div><i>${dt.publikasi.user.name}</i></div>`;
                            btnAksi = '';
                        }

                        dataList.append(`
                        <tr data-id="${dt.id}"> 
                            <td>${dt.nomor}</td> 
                            <td>
                                <h5>${dt.judul}</h5>
                                <div class='font-12'><i class="bi bi-calendar-event"></i> ${dt.waktu}</div>
                                <div class='font-12'>${dt.slug}</div>
                                ${thumbnail} ${dt.pembuka}
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
                            <td>${btnAksi}</td>
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

        $('#bodyAcr').on('shown.bs.collapse', function() {
            $('#judul').focus();
        });

        function resetForm() {
            $('#form input').val('');
            $('#editor').summernote('code', '');
            $('#form')[0].reset();
            $('#preview-img').html('');
        }

        $(document).on('click', '.btnTambah', function() {
            $('html, body').scrollTop($('#tambahForm').offset().top);
            $('#bodyAcr').collapse('show'); // Menampilkan accordion
            resetForm();
            $('#judul').focus();
        });

        $('.btnBatal').on('click', function(e) {
            event.preventDefault();
            resetForm();
            $('#judul').focus();
            $('#bodyAcr').collapse('hide');
        });

        $('#tambahBaru').on('click', function(e) {
            e.preventDefault();
            resetForm();
            $('#judul').focus();
        });

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

        $("#form").validate({
            rules: {
                file: {
                    required: function(element) {
                        return $('#id').val().trim() === '';
                    }
                }
            },
            submitHandler: function(form) {
                var selectedPage = $('.page-item.active .page-link').data('page');
                var formData = new FormData($(form)[0]);
                var vUrl = vApiUrl;

                if ($('#id').val() !== '') {
                    vUrl = vApiUrl + '/' + $('#id').val();
                    formData.append("_method", "PUT");
                }

                $.ajax({
                    url: vUrl,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        resetForm();
                        loadData(selectedPage);
                        toastr.success('operasi berhasil dilakukan!', 'berhasil');
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
        });

        $(document).on('click', '.btnGanti', function() {
            var id = $(this).data('id');
            var selectedPage = $('.page-item.active .page-link').data('page');
            $.ajax({
                url: vApiUrl + '/' + id,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('html, body').scrollTop($('#tambahForm').offset().top);
                    $('#bodyAcr').collapse('show'); // Menampilkan accordion
                    $('#id').val(response.id);
                    $('#judul').val(response.judul);
                    $('#slug').val(response.slug);
                    $('#editor').summernote('code', response.isi);
                    $('#waktu').val(response.waktu);
                    $('#jenis_konten_id').val(response.jenis_konten_id);

                    if (response.thumbnail)
                        $('#preview-img').html('<img src="' + response.thumbnail + '" width="100%" alt="Preview Image">');

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

        $(document).on('click', '.btnHapus', function() {
            var id = $(this).data('id');
            var selectedPage = $('.page-item.active .page-link').data('page');
            if (confirm('apakah anda yakin?'))
                $.ajax({
                    url: vApiUrl + '/' + id,
                    method: 'DELETE',
                    dataType: 'json',
                    success: function(response) {
                        loadData(selectedPage);
                        toastr.success('operasi berhasil dilakukan!', 'berhasil');
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