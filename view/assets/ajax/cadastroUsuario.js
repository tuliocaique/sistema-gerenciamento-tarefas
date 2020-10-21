async function cadastrarUsuario(){
    let form = $("#cadastrarUsuario").serialize();
    let btnCadastrarUsuario = $("#btn-cadastrar-usuario");
    $.ajax({
        type: "POST",
        url: "api/usuario",
        data: form,
        dataType: "json",
        beforeSend: function () {
            btnCadastrarUsuario.addClass('disabled');
            btnCadastrarUsuario.html('<div class="spinner-border text-light" role="status"><span class="sr-only">Loading...</span></div> <span>Aguarde</span>');
        },
        success: function (result) {
            if(result.success){
                toastr.success(
                    'Você será redirecionado para o login',
                    result['message'],
                    {
                        timeOut: 3000,
                        fadeOut: 3000,
                        onHidden: function () {
                            $(location).delay(2000).attr('href', 'login');
                        }
                    }
                );
            } else {
                toastr.error(result['message']);
                btnCadastrarUsuario.removeClass('disabled');
                btnCadastrarUsuario.html('<i class="fas fa-user-plus"></i> Cadastrar');
            }
        },
        error:function (result) {
            toastr.error(result);
        }
    });
}

$(document).ready(function () {
    $("#cadastrarUsuario").submit(function(event) {
        cadastrarUsuario();
        event.preventDefault();
    });
});