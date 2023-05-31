function load_clicks(){
    $('.btn-register').on('click', function(e) {
        $('.container-login').css({ 'display' : 'none'});
        $('.container-register').css({ 'display' : 'block'});
        $('.container-send-recover').css({ 'display' : 'none'});
        $('.container-new-password').css({ 'display' : 'none'});
    });

    $('.btn-login').on('click', function(e) {
        $('.container-login').css({ 'display' : 'block'});
        $('.container-register').css({ 'display' : 'none'});
        $('.container-send-recover').css({ 'display' : 'none'});
        $('.container-new-password').css({ 'display' : 'none'});
    });

    $('.btn-recover').on('click', function(e) {
        $('.container-login').css({ 'display' : 'none'});
        $('.container-register').css({ 'display' : 'none'});
        $('.container-send-recover').css({ 'display' : 'block'});
        $('.container-new-password').css({ 'display' : 'none'});
    });

    $('.btn-signup').on('click', function(e) {
        e.preventDefault();
        register();
    });

    $(".btn-signup").keypress(function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            e.preventDefault();
            register();
        }
    });

    $('.btn-signin').on('click', function(e) {
        e.preventDefault();
        login();
    });

    $(".btn-signin").keypress(function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            e.preventDefault();
            login();
        }
    });

    $('.btn-send-recover').on('click', function(e) {
        e.preventDefault();
        send_recover_password();
    });

    $(".btn-send-recover").keypress(function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            e.preventDefault();
            send_recover_password();
        }
    });

    $('#login_google').on('click', function(e) {
        e.preventDefault();
        social_login('google');
    });

    $('#login_github').on('click', function(e) {
        e.preventDefault();
        social_login('github');
    });
}//end_load_clicks

function social_login(param){
    authService = firebase_config();
    authService.signInWithPopup(provider_config(param))
    .then(function(result) {
        console.log(result);
        email_name = result.user.email;
        let username = email_name.split('@');

        social_user = {id: result.user.uid, username: username[0], email: result.user.email, avatar: result.user.photoURL};
        console.log(social_user);
        if (result) {
            ajaxPromise(friendlyURL("?module=login&op=social_login"), 'POST', 'JSON', social_user)
            .then(function(data) {
                localStorage.setItem("token", data[0]);
                localStorage.setItem("token_refresh", data[1]);
                toastr.success("Ha iniciado sesión con éxito");

                if (localStorage.getItem('redirect_like')) {
                    setTimeout(' window.location.href = "?module=shop"; ', 1000);
                } else {
                    setTimeout(' window.location.href = "?module=home"; ', 1000);
                }
            })
            .catch(function() {
                console.log('Error: Social login error');
            });
        }
    })
    .catch(function(error) {
        var errorCode = error.code;
        console.log(errorCode);
        var errorMessage = error.message;
        console.log(errorMessage);
        var email = error.email;
        console.log(email);
        var credential = error.credential;
        console.log(credential);
    });
}

function firebase_config(){
    if(!firebase.apps.length){
        firebase.initializeApp(config);
    }else{
        firebase.app();
    }
    return authService = firebase.auth();
}

function provider_config(param){
    if(param === 'google'){
        var provider = new firebase.auth.GoogleAuthProvider();
        provider.addScope('email');
        return provider;
    }else if(param === 'github'){
        return provider = new firebase.auth.GithubAuthProvider();
    }
}

function send_recover_password(){
    if(validate_recover_password() != 0){
        var data = $('.send-recover-form').serialize();

        ajaxPromise(friendlyURL("?module=login&op=send_recover_email"), 'POST', 'JSON', data)
        .then(function(data) {
            console.log(data);
            if(data == "error"){		
                $('#email_recover').after('<p class="error_email_recover" style="color: red">*El correo no existe</p>');
            } else{
                toastr.options.timeOut = 3000;
                toastr.success("Email sended");
                setTimeout('window.location.href = friendlyURL("?module=login")', 1000);
            }
        }).catch(function(textStatus) {
            if (console && console.log) {
                console.log("La solicitud ha fallado: " + textStatus);
            }
        }); 
    }
}

function register() {
    if (validate_register() != 0) {
        var result = $('.register-form').serialize();

        ajaxPromise(friendlyURL("?module=login&op=register"), 'POST', 'JSON', result)
            .then(function(data) {
                if(data == "error_email"){
                    $('#email_reg').after('<p class="error_email_reg" style="color: red">*El email ya esta en uso</p>');
                }else if(data == "error_username"){
                    $('#username_reg').after('<p class="error_username_reg" style="color: red">*El usuario ya esta en uso</p>');
                }else{
                    toastr.success("Correo enviado. Verifica tu cuenta");
                    setTimeout(' window.location.href = "?module=login"; ', 1000);
                }
            }).catch(function(textStatus) {
                if (console && console.log) {
                    console.log("La solicitud ha fallado: " + textStatus);
                }
            });
    }
}//end_register

function validate_register() {
    var username_exp = /^[a-zA-Z0-9]{5,}$/g;
    var email_exp = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
    var password_exp = /^(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9!@#$%^&*]{8,}$/;
    var error = false;

    //Comprobación de username
    $('.error_username_reg').empty();
    if(!$('#username_reg').val()){
        $('#username_reg').after('<p class="error_username_reg" style="color: red">*Tienes que escribir el usuario</p>');
        error = true;
    }else if($('#username_reg').val().length < 5){
        $('#username_reg').after('<p class="error_username_reg" style="color: red">*El usuario tiene que tener 5 caracteres como minimo</p>');
        error = true;
    }else if(!username_exp.test($('#username_reg').val())){
        $('#username_reg').after('<p class="error_username_reg" style="color: red">*No se pueden poner caracteres especiales</p>');
        error = true;
    }

    //Comprobación de email
    $('.error_email_reg').empty();
    if(!$('#email_reg').val()){
        $('#email_reg').after('<p class="error_email_reg" style="color: red">*Tienes que escribir el correo</p>');
        error = true;
    }else if(!email_exp.test($('#email_reg').val())){
        $('#email_reg').after('<p class="error_email_reg" style="color: red">*El formato del mail es invalido</p>');
        error = true;
    }

    //Comprobación de password1
    $('.error_password_reg1').empty();
    if(!$('#password_reg1').val()){
        $('#password_reg1').after('<p class="error_password_reg1" style="color: red">*Tienes que escribir la contraseña</p>');
        error = true;
    }else if($('#password_reg1').val().length < 8){
        $('#password_reg1').after('<p class="error_password_reg1" style="color: red">*La contraseña tiene que tener 8 caracteres como minimo</p>');
        error = true;
    }else if(!password_exp.test($('#password_reg1').val())){
        $('#password_reg1').after('<p class="error_password_reg1" style="color: red">*Debe de contener mayusculas, minusculas y simbolos especiales</p>');
        error = true;
    }//end_if

    //Comprobación de password2
    $('.error_password_reg2').empty();
    if(!$('#password_reg2').val()){
        $('#password_reg2').after('<p class="error_password_reg2" style="color: red">*Tienes que repetir la contraseña</p>');
        error = true;
    }else if($('#password_reg2').val().length < 8){
        $('#password_reg2').after('<p class="error_password_reg2" style="color: red">*La contraseña tiene que tener 8 caracteres como minimo</p>');
        error = true;
    }else if($('#password_reg2').val() != $('#password_reg1').val()){
        $('#password_reg2').after('<p class="error_password_reg2" style="color: red">*Las contraseñas no coinciden</p>');
        error = true;
    }

    if (error == true) {
        return 0;
    }
}//end_validate_register

function login() {
    if (validate_login() != 0) {
        var result = $('.login-form').serialize();
        ajaxPromise(friendlyURL("?module=login&op=login"), 'POST', 'JSON', result)
            .then(function(data) {
                if (data == "error_user") {
                    $('#username_log').after('<p class="error_username_log" style="color: red">*El usario no existe</p>');
                } else if (data == "error_password") {
                    $('#password_log').after('<p class="error_password_log" style="color: red">*La contraseña es incorrecta</p>');
                } else if (data == "error_verify"){
                    toastr.options.timeOut = 3000;
                    toastr.error("Verifica la cuenta"); 
                } else {
                    localStorage.setItem("token", data[0]);
                    localStorage.setItem("token_refresh", data[1]);
                    toastr.success("Ha iniciado sesión con éxito");

                    if (localStorage.getItem('redirect_like')) {
                        setTimeout(' window.location.href = "?module=shop"; ', 1000);
                    } else {
                        setTimeout(' window.location.href = "?module=home"; ', 1000);
                    }
                }
            }).catch(function(textStatus) {
                if (console && console.log) {
                    console.log("La solicitud ha fallado: " + textStatus);
                }
            });
    }
}//end_login

function validate_login() {
    var error = false;

    //Comprobación de username
    $('.error_username_log').empty();
    if(!$('#username_log').val()){
        $('#username_log').after('<p class="error_username_log" style="color: red">*Tienes que escribir el usuario</p>');
        error = true;
    }else if($('#username_log').val().length < 5){
        $('#username_log').after('<p class="error_username_log" style="color: red">*El usuario tiene que tener 5 caracteres como minimo</p>');
        error = true;
    }

    //Comprobación de password
    $('.error_password_log').empty();
    if(!$('#password_log').val()){
        $('#password_log').after('<p class="error_password_log" style="color: red">*Tienes que escribir la contraseña</p>');
        error = true;
    }else if($('#password_log').val().length < 8){
        $('#password_log').after('<p class="error_password_log" style="color: red">*La contraseña tiene que tener 8 caracteres como minimo</p>');
        error = true;
    }

    if (error == true) {
        return 0;
    }
}//end_validate_login

function validate_recover_password(){
    var email_exp = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;
    var error = false;

    //Comprobación de email
    $('.error_email_recover').empty();
    if(!$('#email_recover').val()){
        $('#email_recover').after('<p class="error_email_recover" style="color: red">*Tienes que escribir el correo</p>');
        error = true;
    }else if(!email_exp.test($('#email_recover').val())){
        $('#email_recover').after('<p class="error_email_recover" style="color: red">*El formato del mail es invalido</p>');
        error = true;
    }

    if (error == true) return 0;
}

function load_form_new_password(){
    var token_email = localStorage.getItem('token_email');
    localStorage.removeItem('token_email');
    $('.container-login').css({ 'display' : 'none'});
    $('.container-register').css({ 'display' : 'none'});
    $('.container-send-recover').css({ 'display' : 'none'});
    $('.container-new-password').css({ 'display' : 'block'});

    ajaxPromise(friendlyURL("?module=login&op=verify_token"), 'POST', 'JSON', {token_email: token_email})
    .then(function(data) {
        console.log(data);
        if(data == "verify"){
            console.log('verified');
            click_new_password(token_email); 
        }else {
            console.log("error");
        }
    })
    .catch(function() {
      console.log('Error: verify token error');
    });   
}

function click_new_password(token_email){
    $(".btn-new-password").keypress(function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if(code==13){
        	e.preventDefault();
            send_new_password(token_email);
        }
    });

    $('.btn-new-password').on('click', function(e) {
        e.preventDefault();
        send_new_password(token_email);
    }); 
}

function send_new_password(token_email){
    if(validate_new_password() != 0){
        var data = {token_email: token_email, password : $('#password_new1').val()};
        ajaxPromise(friendlyURL("?module=login&op=new_password"), 'POST', 'JSON', data)
        .then(function(data) {
            console.log(data);
            if(data == "done"){
                toastr.options.timeOut = 3000;
                toastr.success('New password changed');
                setTimeout('window.location.href = friendlyURL("?module=login")', 1000);
            } else {
                toastr.options.timeOut = 3000;
                toastr.error('Error seting new password');
            }
        })
        .catch(function() {
          console.log('Error: New password error');
        }); 
    }
}

function validate_new_password() {
    var password_exp = /^(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9!@#$%^&*]{8,}$/;
    var error = false;

    //Comprobación de password1
    $('.error_password_new1').empty();
    if(!$('#password_new1').val()){
        $('#password_new1').after('<p class="error_password_new1" style="color: red">*Tienes que escribir la contraseña</p>');
        error = true;
    }else if($('#password_new1').val().length < 8){
        $('#password_new1').after('<p class="error_password_new1" style="color: red">*La contraseña tiene que tener 8 caracteres como minimo</p>');
        error = true;
    }else if(!password_exp.test($('#password_new1').val())){
        $('#password_new1').after('<p class="error_password_new1" style="color: red">*Debe de contener mayusculas, minusculas y simbolos especiales</p>');
        error = true;
    }//end_if

    //Comprobación de password2
    $('.error_password_new2').empty();
    if(!$('#password_new2').val()){
        $('#password_new2').after('<p class="error_password_new2" style="color: red">*Tienes que repetir la contraseña</p>');
        error = true;
    }else if($('#password_new2').val().length < 8){
        $('#password_reg2').after('<p class="error_password_new2" style="color: red">*La contraseña tiene que tener 8 caracteres como minimo</p>');
        error = true;
    }else if($('#password_new2').val() != $('#password_new1').val()){
        $('#password_new2').after('<p class="error_password_new2" style="color: red">*Las contraseñas no coinciden</p>');
        error = true;
    }

    if (error == true) {
        return 0;
    }
}//end_validate_new_password

function load_content() {
    let path = window.location.pathname.split('/');
    if(path[4] === 'recover'){
        localStorage.setItem("token_email", path[5]);
        window.location.href = friendlyURL("?module=login&op=recover_view");
    }else if (path[4] === 'verify') {
        ajaxPromise(friendlyURL("?module=login&op=verify_email"), 'POST', 'JSON', {token_email: path[5]})
        .then(function(data) {
            console.log(data);
            toastr.options.timeOut = 3000;
            toastr.success('Email verified');
            setTimeout('window.location.href = friendlyURL("?module=home")', 1000);
        })
        .catch(function() {
          console.log('Error: verify email error');
        });
    }else if (path[4] === 'view') {
        $(".login-wrap").show();
        $(".forget_html").hide();
    }else if (path[3] === 'recover_view') {
        load_form_new_password();
    }
}

$(document).ready(function() {
    load_content();
    load_clicks();
});