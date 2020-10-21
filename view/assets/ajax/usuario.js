async function getToken(){
    let result = null;
    try {
        result = await $.ajax({
            type: "GET",
            url: "api/token",
            dataType: "json"
        });
    } catch (error) {
        $(location).attr('href', 'login');
    }
    return result["refreshToken"];
}


/**
 * @param {string} token
 */
async function getDadosUsuario(token){
    $.ajax({
        type: "GET",
        url: "api/usuario",
        dataType: "json",
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', "Bearer " +token);
        },
        success: function (result) {
            $("#emailUsuario").val(result.usuario.email);
            $(".cod-usuario").val(result.usuario.cod);
        },
        error:function (result) {
            //toastr.error(result);
        }
    });
}

/**
 * @param {string} token
 */
async function deletarUsuario(token){
    let btnDeletarUsuario = $("#btn-deletar-usuario");
    $.ajax({
        type: "DELETE",
        url: "api/usuario",
        contentType: "application/json",
        dataType: "json",
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', "Bearer " +token);
            btnDeletarUsuario.addClass('disabled');
            btnDeletarUsuario.html('<div class="spinner-border text-light" role="status"><span class="sr-only">Loading...</span></div> <span>Deletando</span>');
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
                            $(location).delay(1000).attr('href', 'login');
                        }
                    }
                );
            } else {
                toastr.error(result['message']);
                btnDeletarUsuario.removeClass('disabled');
                btnDeletarUsuario.html('Login');

            }        },
        error:function (result) {
            btnDeletarUsuario.removeClass('disabled');
            btnDeletarUsuario.html('Deletar');
            toastr.error(result);
        }
    });
}

/**
 * @param {string} token
 */
async function alterarEmailUsuario(token){
    let form = $( "#alterarEmailUsuario" ).serialize();
    let btnAlterarEmail = $("#btn-alterar-email");
    $.ajax({
        type: "PUT",
        url: "api/usuario",
        data: form,
        contentType: "application/json",
        dataType: "json",
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', "Bearer " +token);
            btnAlterarEmail.addClass('disabled');
            btnAlterarEmail.html('<div class="spinner-border text-light" role="status"><span class="sr-only">Loading...</span></div> <span>Deletando</span>');
        },
        success: function (result) {
            if(result.success){
                toastr.success(result['message']);
            } else {
                toastr.error(result['message']);
            }
        },
        error:function (result) {
            toastr.error(result);
        },
        complete:function (){
            btnAlterarEmail.removeClass('disabled');
            btnAlterarEmail.html('<i class="fas fa-save"></i> Salvar Alteração');
        }
    });
}

/**
 * @param {string} token
 */
async function alterarSenhaUsuario(token){
    let form = $("#alterarSenhaUsuario").serialize();
    let btnAlterarSenha = $("#btn-alterar-senha");
    $.ajax({
        type: "PUT",
        url: "api/usuario",
        data: form,
        contentType: "application/json",
        dataType: "json",
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', "Bearer " +token);
            btnAlterarSenha.addClass('disabled');
            btnAlterarSenha.html('<div class="spinner-border text-light" role="status"><span class="sr-only">Loading...</span></div> <span>Deletando</span>');
        },
        success: function (result) {
            if(result.success){
                toastr.success(result['message']);
            } else {
                toastr.error(result['message']);
            }
        },
        error:function (result) {
            toastr.error(result);
        },
        complete: function (){
            btnAlterarSenha.removeClass('disabled');
            btnAlterarSenha.html('<i class="fas fa-save"></i> Salvar Alteração');
        }
    });
}

/**
 * @param {string} token
 */
async function iniciarUsuario(token){
    await getDadosUsuario(token);
}

$(document).ready(function () {
    getToken()
        .then( (data) => iniciarUsuario(data));

    $("#deletarUsuario").submit(function(event) {
        getToken()
            .then((data) => deletarUsuario(data));
        event.preventDefault();
    });

    $("#alterarEmailUsuario").submit(function(event) {
        getToken()
            .then((data) => alterarEmailUsuario(data));
        event.preventDefault();
    });

    $("#alterarSenhaUsuario").submit(function(event) {
        getToken()
            .then((data) => alterarSenhaUsuario(data));
        event.preventDefault();
    });
});


