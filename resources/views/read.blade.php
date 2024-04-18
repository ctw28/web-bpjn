@extends('template_website')

@section('head')
    <title>Detail Konten</title>
@endsection

@section('container')

    <h1 id="konten-judul">Detail Konten</h1>
    <div id="konten-terbit"></div>
    <div class="mb-3" id="konten-statistik"></div>
    {{-- <div class="row">
        <div class="col-sm-12">
            <div class="input-group justify-content-end">
                <button type="button" class="btn btn-sm btn-outline-secondary btnRefresh" id="refresh">Refresh</button>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-md-9 mb-3" >
            <div class="mb-3">
                <img src="{{ url('images/thumbnail.jpg') }}" id="konten-thumbnail" width="100%">
            </div>
            <div class="mb-3" id="konten-isi"></div>
        </div>
        <div class="col-md-3 mb-3">
            <h4 class="card-title" id="judul-lain">Konten Lain</h4>
            <div class="card" style="width: 18rem;">
                <ul class="list-group" id="konten-lain">
                </ul>
            </div>            
        </div>
    </div>    
@endsection

@section('script')

<script src="{{ asset('js/myapp.js') }}"></script>
<script>
var slug='{{ $slug }}';
$(document).ready(function() {
    readSlug();

    function readSlug() {
        $.ajax({
            url: base_url+'/api/list-konten?showall=1&is_web=1&slug='+ slug,
            method: 'GET',
            success: function(response) {
                if(response.length>0){
                    var dt=response[0];
                    var thumbnail=(dt.thumbnail!==null)?dt.thumbnail:'images/thumbnail.jpg';
                    var statistik=`<span class="badge text-bg-info">
                                        <i class="bi bi-view-list"></i> ${dt.jumlah_akses}  
                                        <i class="bi bi-hand-thumbs-up"></i> ${dt.likedislike.length}  
                                        <i class="bi bi-chat-right-text"></i> ${dt.komentar.length}
                                    </span>`;
                    $('#konten-terbit').html(`
                        <div>${dt.user.name} - ${dt.jeniskonten.nama}</div>
                        <div class="font-12">${dt.waktu}</div>
                    `);
                    $('#konten-judul').html(dt.judul);
                    $('#konten-statistik').html(statistik);
                    $('#konten-isi').html(dt.isi);
                    $('#konten-thumbnail').attr('href',base_url+'/'+thumbnail);
                    $('#judul-lain').html(dt.jeniskonten.nama+' Lainnya');
                    readKontenLain(dt.jeniskonten.slug);
                }else{
                    window.location.replace(base_url);
                }
            }
        });
    }

    function readKontenLain(jenis) {
        $('#konten-lain').html('');
        $.ajax({
            url: base_url+'/api/list-konten?publikasi=1&is_web=true&limit=10&jenis='+ jenis,
            method: 'GET',
            success: function(response) {
                console.log(response);
                if(response.length>0){
                    response.forEach(function(konten, index) {
                    var link=base_url+'/read/'+konten.slug; 
                        $('#konten-lain').append(`<li class="list-group-item"><a href="${link}">${konten.judul}</a></li>`);
                    });  
                }else{
                    // window.location.replace(base_url);
                }
            }
        });
    }    

});

</script>
@endsection
