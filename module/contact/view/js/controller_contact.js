function check_email() {

    var pcontact_name = /^[a-zA-Z]+[\-'\s]?[a-zA-Z]{2,51}$/;
    var pmessage = /^[0-9A-Za-z\s]{20,100}$/;
    var pmail = /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/;
    var error = false;

    $('.error_name_contact').empty();
    if(!$('#contact_name').val()){
        $('#contact_name').after('<p class="error_name_contact" style="color: red">*Tienes que escribir el nombre de usuario</p>');
        error = true;
    }else{
        if(!pcontact_name.test($('#contact_name').val())){
            $('#contact_name').after('<p class="error_name_contact" style="color: red">*El nombre debe tener más de tres carácteres</p>');
            error = true;
        }
    }

    $('.error_email_contact').empty();
    if(!$('#contact_email').val()){
        $('#contact_email').after('<p class="error_email_contact" style="color: red">*Tienes que escribir el correo electrónico</p>');
        error = true;
    }else{
        if(!pmail.test($('#contact_email').val())){
            $('#contact_email').after('<p class="error_email_contact" style="color: red">*El formato es incorrecto</p>');
            error = true;
        }
    }

    $('.error_subject_contact').empty();
    if(!$('#contact_subject').val()){
        $('#contact_subject').after('<p class="error_subject_contact" style="color: red">*Tienes que escribir el asunto</p>');
        error = true;
    }

    $('.error_message_contact').empty();
    if(!$('#contact_message').val()){
        $('#contact_message').after('<p class="error_message_contact" style="color: red">*Tienes que escribir el mensaje</p>');
        error = true;
    }else{
        if(!pmessage.test($('#contact_message').val())){
            $('#contact_message').after('<p class="error_message_contact" style="color: red">*El mensaje debe tener más de 20 carácteres</p>');
            error = true;
        }
    }
    
    if(error == true) return 0; 
}

function click_contact(){

	$(".contact-form").keypress(function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if(code == 13){
        	e.preventDefault();
            send();
        }
    });

	$('#send_contact').on('click', function(e) {
        e.preventDefault();
        send();
    }); 
}

function send(){
    if(check_email() != 0){
        var content_email = {
            name:$("#contact_name").val(), 
            email:$("#contact_email").val(), 
            subject:$("#contact_subject").val(), 
            message:$("#contact_message").val()
        }
		send_email(content_email);
	}
}

function send_email(content_email) {
	ajaxPromise(friendlyURL("?module=contact&op=send_contact_us"), 'POST', 'JSON', content_email)
	.then(function (data) {
		console.log(data);
		toastr.success('Email sended');
	}).catch(function(data) {
		console.log('Error: send contact us error');
	});
}

$(document).ready(function(){
	click_contact()
});