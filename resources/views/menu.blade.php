@extends('template')

@section('head')
    <title>Jenis Konten</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('plugins/select2-to-tree/src/select2totree.css') }}" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single {
            height: 38px;
        }
        .select2-container .select2-selection--single .select2-selection__rendered{
            padding: .375rem .75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
        }
        .font-12{
            font-size:12px;
        }

    </style>
@endsection

@section('container')

    <h1>Menu Web</h1>
    <p>digunakan untuk mengatur menu pada tampilan utama website ini </p>

    <form id="form" class="row">
        <input type="hidden" name="id" id="id">
        <div class="col-sm-10">
          <div class="row">
                <div class="col-sm-4 mb-2">
                    <input type="text" name="nama" id="nama" class="form-control w-100" placeholder="nama menu" aria-label="menu" required>
                </div>
                <div class="col-sm-5 mb-2">
                    <input type="text" name="url" id="url" class="form-control w-100" placeholder="url tujuan" aria-label="url" required>
                </div>
                <div class="col-sm-3 mb-2">
                    <select name="menu_id" id="menu_id" class="form-control" required>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="input-group justify-content-end">
                <button type="submit" class="btn btn-outline-secondary" id="simpan">Simpan</button>
                <button type="button" class="btn btn-outline-secondary" id="refresh">Refresh</button>
            </div>
        </div>
    </form>
    <div id="data-list"></div>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('plugins/select2-to-tree/src/select2totree.js') }}"></script>
<script src="{{ asset('js/token.js') }}"></script>

<script>
    var vApiUrl='api/menu';

    loadTreeMenu();
    loadData();

    function resetForm(){
        $('#form input').val('');
        $('#form')[0].reset();
    }    

    function buildMenuTree(data, parentId) {
        var result = "<ul>";
        for (var i = 0; i < data.length; i++) {
            if (data[i].menu_id == parentId) {
                result += `<li>${data[i].nama} <span class="font-12">${data[i].url}</span> <button type="button" class="btn btn-vsm btn-danger" onclick="hapusData(${data[i].id})">x</button>`;
                result += buildMenuTree(data, data[i].id);
                result += "</li>";
            }
        }
        result += "</ul>";
        return result;
    }

    function loadTreeMenu(){
        $.ajax({
            url: 'api/load-menu-tree',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#menu_id').empty();
                $("#menu_id").select2ToTree({treeData: {dataArr: response}});
            },
            error: function() {
                alert('operasi gagal dilakukan!');
            }
        });                
    }

    function loadData(search = '') {
        $.ajax({
            url: vApiUrl+'?showall=true&search=' + search,
            method: 'GET',
            success: function(response) {
                var dataList = $('#data-list');
                dataList.empty();
                var menuTree = buildMenuTree(response, null);
                $(dataList).html(menuTree);
            }
        });
    }

    $("#form").validate({
        submitHandler: function(form) {
            var selectedPage = $('.page-item.active .page-link').data('page');
            let vType=($('#id').val()==='')?'POST':'PUT';
            let vUrl = vApiUrl;
            if(vType==='PUT')
                vUrl = vApiUrl+'/'+$('#id').val();

            $.ajax({
                url: vUrl,
                type: vType,
                data: $(form).serialize(),
                dataType: 'json',
                success: function(response) {
                    toastr.success('operasi berhasil dilakukan!', 'berhasil');
                    loadData(); // Reload list after submission
                    loadTreeMenu();
                    resetForm();
                },
                error: function() {
                    alert('operasi gagal dilakukan!');
                }
            });
        }
    });       
    
    function hapusData(id){
        var selectedPage = $('.page-item.active .page-link').data('page');
        if(confirm('apakah anda yakin?'))
            $.ajax({
                url: vApiUrl+'/' + id,
                method: 'DELETE',
                dataType: 'json',
                success: function(response) {
                    toastr.success('operasi berhasil dilakukan!', 'berhasil');
                    loadData(); // Reload list after submission
                    loadTreeMenu();
                },
                error: function() {
                    alert('operasi gagal dilakukan!');
                }
            });                
    }    
</script>
@endsection