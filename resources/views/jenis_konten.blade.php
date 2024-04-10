@extends('template')

@section('head')
    <title>Jenis Konten</title>
@endsection

@section('container')

    <h1>Jenis Konten Web</h1>
    <p>digunakan untuk mengatur jenis konten web, apakah termasuk artikel atau file yang akan digunakan pada website ini </p>

    <div class="row">
        <div class="col-sm-12">
            <div class="input-group justify-content-end">
                <button type="button" class="btn btn-sm btn-outline-secondary" id="tambah" onclick="tambah()">Tambah</button>
                <button type="button" class="btn btn-sm btn-outline-secondary" id="refresh">Refresh</button>
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
                    <th scope="col">Jenis Konten</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">User</th>
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

<script>
    var vApiUrl='api/jenis-konten';

    function tambah(){
        $('#data-list').prepend(`
            <tr data-id="">
                <td></td>
                <td><input type="text" class="form-control" name="nama[]"></td>
                <td>
                    <select class="form-control" name="kategori[]">
                        <option value='ARTIKEL'>Artikel</option>
                        <option value='FILE'>File</option>
                    </select>
                </td>
                <td><textarea class="form-control" name="deskripsi[]"></textarea></td>
                <td></td>
                <td></td>
                <td>
                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-success simpan-baris" onclick="simpanBaris(this)">Simpan</button>
                        <button type="button" class="btn btn-warning batal-baris" onclick="batalBaris(this)">Batal</button>
                    </div>
                </td>
            </tr>
        `);
        resetNomorUrut();
    }

    function resetNomorUrut() {
        var nomor=1;
        $('#data-list tr').each(function(index) {
            $(this).find('td:first').text(nomor);
            nomor++;
        });
    }

    function batalBaris(button) {
        $(button).closest('tr').remove();
        resetNomorUrut();
    }

    function simpanBaris(button) {
        var baris = $(button).closest('tr');
        var postData = {
            nama: baris.find("input[name='nama[]']").val(),
            kategori: baris.find("select[name='kategori[]']").val(),
            deskripsi: baris.find("textarea[name='deskripsi[]']").val()
        };

        $.ajax({
            url: vApiUrl,
            type: 'post',
            data: postData,
            dataType: 'json',
            success: function(response) {
                toastr.success('operasi berhasil dilakukan!', 'berhasil');
                baris.attr("data-id", response.id); 
                baris.find("td:eq(1)").text(response.nama); 
                baris.find("td:eq(2)").text(response.kategori); 
                baris.find("td:eq(3)").text(response.deskripsi); 
                baris.find("td:eq(4)").text(response.user.name); 
                baris.find("td:eq(5)").text(response.updated_at_format);
                baris.find("td:eq(6)").html(`<div class="btn-group btn-group-sm" role="group">
                                                <button type="button" class="btn btn-danger" onclick="hapusData(${response.id})">Hapus</button>
                                            </div>`);



                //---------------- sembunyikan inputan -------------------
                baris.find("input[name='nama[]'], select[name='kategori[]'], textarea[name='deskripsi[]'], .simpan-baris, .batal-baris").hide();
            },
            error: function() {
                alert('operasi gagal dilakukan!');
            }
        });
    }

    var oldValue="";
    $('#data-list').on('dblclick', 'td', function() {        
        var $td = $(this);
        var $tr = $td.closest('tr');
        var index = $td.index();
        var content = $td.text().trim();
        oldValue = content; 

        $tr.find('td').each(function(i, cell) {
            var $cell = $(cell);
            if (i === index) {
                switch (index) {
                    case 1:
                        $cell.html('<input type="text" class="form-control" value="' + content + '">');
                        break;
                    case 2:
                        $cell.html('<select class="form-control"><option value="ARTIKEL">Artikel</option><option value="FILE">File</option></select>');
                        break;
                    case 3:
                        $cell.html('<textarea class="form-control">' + content + '</textarea>');
                        break;
                    default:
                        break;
                }
                $cell.find('input, select, textarea').first().focus();
            }
        });
    });    

    $('#data-list').on('focusout', 'input, textarea, select', function() {
        var tr = $(this).closest('tr');
        var id = $(tr).attr('data-id');
        var newValue = $(this).val();
        // console.log('id '+id);
        if(id!==''){
            $(this).closest('td').html(newValue);
            var nama = $(tr).find('td:nth-child(2)').text();
            var kategori = $(tr).find('td:nth-child(3)').text();
            var deskripsi = $(tr).find('td:nth-child(4)').text();    

            // console.log('old : '+oldValue+' ,new : '+newValue);
            if(oldValue!==newValue)
                $.ajax({
                    url: vApiUrl+'/'+id,
                    type: 'PUT',
                    data: {
                        nama:nama,
                        kategori:kategori,
                        deskripsi:deskripsi,
                    },
                    dataType: 'json',
                    success: function(response) {
                        toastr.success('operasi berhasil dilakukan!', 'berhasil');
                    },
                    error: function() {
                        alert('operasi gagal dilakukan!');
                    }
                });  
        } 
    });  

    $('.item-paging').on('click', function() {
        vPaging=$(this).data('nilai');
        loadData();
    })

    loadData();


    function loadData(page = 1, search = '') {
        $.ajax({
            url: vApiUrl+'?page=' + page + '&search=' + search + '&paging=' + vPaging,
            method: 'GET',
            success: function(response) {
                var dataList = $('#data-list');
                var pagination = $('#pagination');
                dataList.empty();

                $.each(response.data, function(index, dt) {

                    dataList.append(`<tr data-id="${dt.id}"> 
                            <td>${dt.nomor}</td> 
                            <td>${dt.nama}</td> 
                            <td>${dt.kategori}</td> 
                            <td>${dt.deskripsi}</td> 
                            <td>${dt.user.name}</td> 
                            <td>${dt.updated_at_format}</td> 
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-danger" onclick="hapusData(${dt.id})" >Hapus</button>
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
    })

    function hapusData(id){
        var selectedPage = $('.page-item.active .page-link').data('page');
        if(confirm('apakah anda yakin?'))
            $.ajax({
                url: vApiUrl+'/' + id,
                method: 'DELETE',
                dataType: 'json',
                success: function(response) {

                    loadData(selectedPage);
                    toastr.success('operasi berhasil dilakukan!', 'berhasil');
                },
                error: function() {
                    alert('operasi gagal dilakukan!');
                }
            });                
    }

</script>
@endsection
