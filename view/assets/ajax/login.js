function login(){
    let form = $( "#login" ).serialize();
    let btnLogin = $("#btn-login");
    $.ajax({
        type: "POST",
        url: "./api/login",
        data: form,
        dataType: "json",
        beforeSend: function () {
            btnLogin.addClass('disabled');
            btnLogin.html('<div class="spinner-border text-light" role="status"><span class="sr-only">Loading...</span></div> <span>Entrando</span>');
        },
        success: function (result) {
            if(result.success){
                toastr.success(
                    'Aguarde...',
                    result['message'],
                    {
                        timeOut: 3000,
                        fadeOut: 3000,
                        onHidden: function () {
                            $(location).delay(1000).attr('href', './home');
                        }
                    }
                );
            } else {
                toastr.error('Verifique seu email e senha');
                btnLogin.removeClass('disabled');
                btnLogin.html('<i class="fas fa-sign-in-alt"></i> Login');
            }
        },
        error:function (result) {
            toastr.error('Verifique seu email e senha');
            btnLogin.removeClass('disabled');
            btnLogin.html('<i class="fas fa-sign-in-alt"></i> Login');
        }
    });
}

function logout(){
    let btnLogin = $("#btn-login");
    $.ajax({
        type: "DELETE",
        url: "api/login",
        dataType: "json",
        beforeSend: function () {
            btnLogin.addClass('disabled');
        },
        success: function (result) {
            if(result.success){
                $(location).delay(1000).attr('href', 'login');
            } else {
                toastr.error(result.message);
                btnLogin.removeClass('disabled');
            }
        },
        error:function (result) {
            toastr.error(result);
            btnLogin.removeClass('disabled');
        }
    });
}


$(document).ready(function () {
    $("#login").submit(function(event) {
        login();
        event.preventDefault();
    });
});