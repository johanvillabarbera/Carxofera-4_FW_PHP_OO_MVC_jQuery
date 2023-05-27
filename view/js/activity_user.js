function protecturl() {
    var token = localStorage.getItem('token');
    ajaxPromise(friendlyURL("?module=login&op=controluser"), 'POST', 'JSON', { 'token': token })
        .then(function(data) {
            if (data == "Correct_User") {
                console.log("CORRECTO-->El usuario coincide con la session");
            } else if (data == "Wrong_User") {
                console.log("INCORRECTO--> Estan intentando acceder a una cuenta");
                logout_auto();
            }
        })
        .catch(function() { console.log("ANONYMOUS_user") });
}

function control_activity() {
    var token = localStorage.getItem('token');
    if (token) {
        ajaxPromise(friendlyURL("?module=login&op=activity"), 'POST', 'JSON')
            .then(function(response) {
                if (response == "inactivo") {
                    console.log("usuario INACTIVO");
                    logout_auto();
                } else {
                    console.log("usuario ACTIVO")
                }
            });
    } else {
        console.log("No hay usario logeado");
    }
}

function refresh_token() {
    var token = localStorage.getItem('token');
    var token_refresh = localStorage.getItem('token_refresh');
    if (token) {
            ajaxPromise(friendlyURL("?module=login&op=refresh_token"), 'POST', 'JSON', { 'token': token , 'token_refresh': token_refresh})
            .then(function(data_token) {
                if(data_token != 'No_Refresh'){
                    console.log("Refresh token correctly");
                    localStorage.setItem("token_refresh", data_token);
                    load_menu();
                }
            });
    }
}

function refresh_cookie() {
    ajaxPromise(friendlyURL("?module=login&op=refresh_cookie"), 'POST', 'JSON')
        .then(function(response) {
            console.log("Refresh cookie correctly");
        });
}

function logout_auto() {
    toastr.warning("Se ha cerrado la cuenta por seguridad!!");
    setTimeout('logout(); ', 1000);
}

$(document).ready(function() {
    setInterval(function() { control_activity() }, 600000); //10min= 600000
    protecturl();
    setInterval(function() { refresh_token() }, 600000);
    setInterval(function() { refresh_cookie() }, 600000);
});