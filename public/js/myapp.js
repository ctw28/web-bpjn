function myFormatDate(dateString){
    var date = new Date(dateString);

    // Periksa apakah objek Date valid
    if (isNaN(date.getTime())) {
        return 'Invalid Date';
    }    
    var year = date.getFullYear();
    var month = String(date.getMonth() + 1).padStart(2, '0');
    var day = String(date.getDate()).padStart(2, '0');
    var hours = String(date.getHours()).padStart(2, '0');
    var minutes = String(date.getMinutes()).padStart(2, '0');
    var seconds = String(date.getSeconds()).padStart(2, '0');
    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}

function myLabel(tmpVar){
    var tmp='';
    if (tmpVar!==null) {
        tmp=tmpVar;
    }
    return tmp;
}

function sesuaikanPengaturan(){
    var pengaturanWeb = getPengaturanWeb();
    var logo = pengaturanWeb.logo!==null ? pengaturanWeb.logo : 'images/logo.png';
    var icon = pengaturanWeb.icon!==null ? pengaturanWeb.icon : 'images/icon.png';

    var judul = pengaturanWeb.nama.trim();
    if (!document.title.includes(judul)) {
        judul += ' - ' + document.title.trim();
    }
    document.title = judul.trim();

    $('meta[name="description"]').attr('content', pengaturanWeb.deskripsi);
    $('meta[name="keywords"]').attr('content', pengaturanWeb.keywords);
    $('link[rel="shortcut icon"]').attr('href', base_url+'/'+icon);
    // $('link[rel="icon"]').attr('href', base_url+'/'+icon);
    $('#logo-web').attr('src', base_url+'/'+logo);    
    $('#nama-web').html(pengaturanWeb.nama);    
    
}

function getPengaturanWeb() {
    var pengaturanWeb = localStorage.getItem('pengaturanWeb');
    return pengaturanWeb ? JSON.parse(pengaturanWeb) : null;
}

function getInfo() {
    $.ajax({
        url: base_url+'/api/info-web',
        type: 'get',
        dataType: 'json',
        success: function(response) {
            localStorage.setItem('pengaturanWeb', JSON.stringify(response.data[0]));
        },
        error: function(error) {
            console.error(error);
        }
    });
}

function htmlCode(slug,element) {
    $(element).html(slug+' tidak ditemukan');
    $.ajax({
        url: base_url+'/api/get-html-code?is_web=true&showall=true&slug='+slug,
        type: 'get',
        dataType: 'json',
        success: function(response) {
            if(response.length>0)
                $(element).html(response[0].code);        
        },
        error: function(error) {
            console.error(error);
        }
    });
}

function slideShow(element) {
    $.ajax({
        url: base_url+'/api/get-slide-show?is_web=true&showall=true',
        type: 'get',
        dataType: 'json',
        success: function(response) {
            if(response.length > 0) {
                var carouselInner = $(element).find('.carousel-inner');
                carouselInner.empty(); 
                $.each(response, function(index, slide) {
                    var vClass = index === 0 ? 'carousel-item active' : 'carousel-item'; 
                    var path = `<img src="${slide.path}" class="d-block w-100" style="height: 450px; width: 100%;" alt="${slide.title}">`;
                    // var judul = `<h4>${slide.judul}</h4>`;
                    // var deskripsi = `<p>${myLabel(slide.deskripsi)}</p>`;
                    // var captionElement = `<div class="carousel-caption">${judul}${deskripsi}</div>`;
                    // var item = `<div class="${vClass}">${path}${captionElement}</div>`;
                    var item = `<div class="${vClass}">${path}</div>`;
                    carouselInner.append(item);
                });
            }        
        },
        error: function(error) {
            console.error(error);
        }
    });
}

$(document).ready(function() {
    var pengaturanWeb = getPengaturanWeb();
    if (!pengaturanWeb) {
        getInfo();
    } else {
        sesuaikanPengaturan();
    }

    $('.custom-code-html').each(function() {
        var slug = $(this).data('slug');
        htmlCode(slug, this);
    });    
});