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
    var icon = pengaturanWeb.icon!==null ? pengaturanWeb.icon : 'images/logo.png';

    var judul = pengaturanWeb.nama.trim();
    if (!document.title.includes(judul)) {
        judul += ' - ' + document.title.trim();
    }
    document.title = judul.trim();

    $('meta[name="description"]').attr('content', pengaturanWeb.deskripsi);
    $('meta[name="keywords"]').attr('content', pengaturanWeb.keywords);
    $('link[rel="shortcut icon"]').attr('href', icon);
    $('link[rel="icon"]').attr('href', icon);
    $('#logo-web').attr('src', logo);    
}

function getPengaturanWeb() {
    var pengaturanWeb = localStorage.getItem('pengaturanWeb');
    return pengaturanWeb ? JSON.parse(pengaturanWeb) : null;
}

function getInfo() {
    $.ajax({
        url: 'api/info-web',
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

$(document).ready(function() {
    var pengaturanWeb = getPengaturanWeb();
    if (!pengaturanWeb) {
        getInfo();
    } else {
        sesuaikanPengaturan();
    }
});