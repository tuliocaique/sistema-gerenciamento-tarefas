async function getToken(){
    let result = null;
    try {
        result = await $.ajax({
            type: "GET",
            url: "api/token",
            dataType: "json"
        });
        return result["refreshToken"];
    } catch (error) {
        $(location).attr('href', 'login');
    }
}


/**
 * @param {string} token
 */
async function getTarefas(token){
    $.ajax({
        type: "GET",
        url: "api/tarefa",
        dataType: "json",
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', "Bearer " +token);
        },
        success: function (result) {
            if(result.success){
                $.each(result.tarefas, function(index, valor) {
                    let statusTarefa = '<span class="badge badge-success">Ativa</span>';
                    if(valor.status === '0')
                        statusTarefa = '<span class="badge badge-secondary">Inativa</span>';
                    $("#listagemTarefas").append('<li class="list-group-item p-4">\n' +
                        '                            <h4 class="font-weight-bold">'+valor.titulo+'</h4>\n' +
                        '                            <p>'+valor.descricao+'</p>\n' +
                        '                            <p class="text-muted text-uppercase">'+statusTarefa+' Inicio: '+valor.dataInicio+' | Fim: '+valor.dataFim+'</p>\n' +
                        '                            <button class="btn btn-sm btn-primary btn-rounded pl-3 pr-3" data-toggle="modal" data-target="#modalAlterarTarefa" data-cod="'+valor.cod+'" onclick="gerenciarTarefa(this.getAttribute(\'data-cod\'), \'editar\')"><i class="fas fa-edit"></i> Editar</button>\n' +
                        '                            <button class="btn btn-sm btn-danger btn-rounded pl-3 pr-3" data-cod="'+valor.cod+'" onclick="gerenciarTarefa(this.getAttribute(\'data-cod\'), \'apagar\')"><i class="fas fa-trash"></i> Apagar</button>\n' +
                        '                        </li>');
                });
            } else {
                $("#listagemTarefas").append('<li class="list-group-item">'+result.message+'</li>');
            }
        },
        error:function (result, status, xhr) {
            //toastr.error(result);
        }
    });
}

/**
 * @param {string} cod
 * @param {string} acao
 */
async function gerenciarTarefa(cod, acao){
    if(acao === 'editar'){
        getToken()
            .then( (token) => getDadosTarefa(token, cod));
    }else if(acao === 'apagar'){
        getToken()
            .then( (token) => deletarTarefa(token, cod));
    }
}

/**
 * @param {string} token
 * @param {string} cod
 */
async function getDadosTarefa(token, cod){
    $.ajax({
        type: "GET",
        url: "api/tarefa",
        data: {cod: cod},
        contentType: "application/json",
        dataType: "json",
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', "Bearer " +token);
        },
        success: function (result) {
            if(result.success){
                $("#codAlterar").val(cod);
                $("#tituloTarefaAlterar").val(result.tarefa.titulo);
                $("#descricaoTarefaAlterar").val(result.tarefa.descricao);
                $("#dataInicioTarefaAlterar").val(new Date(result.tarefa.dataInicio).toJSON().slice(0,19));
                $("#dataFimTarefaAlterar").val(new Date(result.tarefa.dataFim).toJSON().slice(0,19));
                if(result.tarefa.status === '1')
                    $("#statusTarefaAlterar").prop('checked', true);
            } else {
                toastr.error(result['message']);
            }
        },
        error:function (result) {
            toastr.error(result);
        }
    });
}


/**
 * @param {string} token
 */
async function cadastrarTarefa(token){
    let btnCadastrarTarefa = $("#btn-cadastrar-tarefa");
    let form = $("#cadastrarTarefa").serialize();
    $.ajax({
        type: "POST",
        url: "api/tarefa",
        data: form,
        contentType: "application/json",
        dataType: "json",
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', "Bearer " +token);
            btnCadastrarTarefa.addClass('disabled');
            btnCadastrarTarefa.html('<div class="spinner-border text-light" role="status"><span class="sr-only">Loading...</span></div> <span>Deletando</span>');
        },
        success: function (result) {
            if(result.success){
                toastr.success(result['message']);
                $('#modalCadastrarTarefa').modal('toggle');
                $('#cadastrarTarefa').trigger("reset");
                $("#listagemTarefas").empty();
                getToken()
                    .then( (data) => getTarefas(data));
            } else {
                console.error(result);
                toastr.error(result['message']);
            }
        },
        error:function (result) {
            toastr.error(result);
        },
        complete:function () {
            btnCadastrarTarefa.removeClass('disabled');
            btnCadastrarTarefa.html('Cadastrar');
        }
    });
}

/**
 * @param {string} token
 */
async function alterarTarefa(token){
    let form = $( "#alterarTarefa" ).serialize();
    let btnAlterarTarefa = $("#btn-alterar-tarefa");
    $.ajax({
        type: "PUT",
        url: "api/tarefa",
        data: form,
        contentType: "application/json",
        dataType: "json",
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', "Bearer " +token);
            btnAlterarTarefa.addClass('disabled');
            btnAlterarTarefa.html('<div class="spinner-border text-light" role="status"><span class="sr-only">Loading...</span></div> <span>Alterando...</span>');
        },
        success: function (result) {
            toastr.success(result['message']);
            $('#modalAlterarTarefa').modal('toggle');
            $('#alterarTarefa').trigger("reset");
            $("#listagemTarefas").empty();
            getToken()
                .then( (data) => getTarefas(data));
        },
        error:function (result) {
            toastr.error(result);
        },
        complete:function (){
            btnAlterarTarefa.removeClass('disabled');
            btnAlterarTarefa.html('Alterar');
        }
    });
}


/**
 * @param {string} token
 * @param {string} cod
 */
async function deletarTarefa(token, cod){
    $.ajax({
        type: "DELETE",
        url: "api/tarefa",
        data: {cod: cod},
        contentType: "application/json",
        dataType: "json",
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', "Bearer " +token);
        },
        success: function (result) {
            if(result.success){
                toastr.success(result['message']);
                $("#listagemTarefas").empty();
                getToken()
                    .then( (data) => getTarefas(data));
            } else {
                toastr.error(result['message']);
            }
        },
        error:function (result) {
            toastr.error(result);
        }
    });
}


/**
 * @param {string} token
 */
async function iniciarTarefa(token){
    await getTarefas(token);
}
$(document).ready(function () {
    getToken()
        .then( (data) => iniciarTarefa(data));

    $("#cadastrarTarefa").submit(function(event) {
        getToken()
            .then((data) => cadastrarTarefa(data));
        event.preventDefault();
    });

    $("#alterarTarefa").submit(function(event) {
        getToken()
            .then((data) => alterarTarefa(data));
        event.preventDefault();
    });
});


