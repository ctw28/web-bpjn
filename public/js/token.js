var authToken=localStorage.getItem('access_token');
$.ajaxSetup({
    headers: {
        'Authorization': 'Bearer ' + authToken
    }
});

function cekToken() {
    $.ajax({
        url: base_url + '/' + 'api/cek-token',
        method: 'get',
        success: function(response) {
            console.log(response);
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
