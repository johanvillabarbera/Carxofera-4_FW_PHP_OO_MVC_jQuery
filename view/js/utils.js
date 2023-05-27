//================AJAX PROMISE================
function ajaxPromise(sUrl, sType, sTData, sData = undefined) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: sUrl,
            type: sType,
            dataType: sTData,
            data: sData
        }).done((data) => {
            resolve(data);
        }).fail((jqXHR, textStatus, errorThrow) => {
            reject(errorThrow);
        }); 
    });
}

/* FRIENDLY URL */
function friendlyURL(url) {
    var link = "";
    url = url.replace("?", "");
    url = url.split("&");
    cont = 0;
    for (var i = 0; i < url.length; i++) {
    	cont++;
        var aux = url[i].split("=");
        link += "/" + aux[1];	
    }
    return "http://localhost/4_FW_PHP_OO_MVC_jQuery_v2" + link;
}


//================LOAD-HEADER================
function load_menu() {
    $('.contact-link').empty();
    $('.home-link').empty();
    $('.shop-link').empty();
    $('.login-icon').empty();
    $('<div></div>').html('<a href="' + friendlyURL("?module=contact") + '" class="nav-item nav-link contact-link">Contact</a>').appendTo('.navbar-nav');
    $('<div></div>').html('<a href="' + friendlyURL("?module=home") + '" class="nav-item nav-link home-link">Home</a>').appendTo('.navbar-nav');
    $('<div></div>').html('<a href="' + friendlyURL("?module=shop") + '" class="nav-item nav-link shop-link">Shop</a>').appendTo('.navbar-nav');
    $('<div></div>').html('<a href="' + friendlyURL("?module=login") + '" class="nav-item nav-link login-icon">Login</a>').appendTo('.navbar-nav');
    var token = localStorage.getItem('token');
    if (token) {
        ajaxPromise(friendlyURL("?module=login&op=data_user"), 'POST', 'JSON', { 'token': token })
            .then(function(data) {
                $('.profile-dropdown').hide();
                $('.login-icon').hide();
                $('<div></div>').attr({ 'class': 'profile-dropdown' }).attr({ 'style': 'margin-top: 15px;' }).appendTo('.navbar-nav')
                    .html(
                        '<a href="#" class="display-picture"><img src="'+ data[0].avatar +'" alt=""></a>' +
                        '<div class="profile-dropdown">' + 
                        '<div class="card-profile" style="display: none;">' +
                        '<ul>' +
                        '<li><a style="color: black;">'+ data[0].username +'</li></a>' +
                        '<li><a href="#" class="logout-icon" style="color:#fff">Logout</li></a>' +
                        '</ul>' +
                        '</div>' +
                        '</div>'
                    );

                $(document).mouseup(function(e) {
                    $('.display-picture').on('click', function(e) {
                        $('.card-profile').toggle();
                    });

                    var container = $('.card-profile');

                    if (!container.is(e.target) && container.has(e.target).length === 0) 
                    {
                        container.hide();
                    }
                });

                $('<a class="cart-icon" href="?module=cart"><i class="fa-solid fa-cart-shopping"></i></a>').appendTo('.cart');
            }).catch(function() {
                console.log("Error al cargar los datos del user");
            });
    } else {
        $('.profile-dropdown').hide();
        $('.login-icon').show();
    }
}

//================CLICK-LOGOUT================
function click_logout() {
    $(document).on('click', '.logout-icon', function() {
        toastr.success("Logout succesfully");
        setTimeout('logout(); ', 1000);
    });
}

//================LOG-OUT================
function logout() {
    ajaxPromise(friendlyURL("?module=login&op=logout"), 'POST', 'JSON')
        .then(function(data) {
            localStorage.removeItem('token');
            localStorage.removeItem('token_refresh');
            window.location.href = "?module=home";
        }).catch(function() {
            console.log('Something has occured');
        });
}

$(document).ready(function() {
    load_menu();
    click_logout();
});