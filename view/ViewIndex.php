<?php
if(!isset($_COOKIE["_validador"])){
    header("Location:  login");
}
?>
<!doctype html>
<html lang="pt">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="view/assets/vendor/bootstrap-4.5.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="view/assets/vendor/toastr/toastr.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/fontawesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/solid.min.css" />

    <!-- CSS Customizado -->
    <link rel="stylesheet" href="view/assets/css/style.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;800;900&display=swap" rel="stylesheet">

    <title>Sistema de Gerenciamento de Tarefas | Home</title>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary-blue">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <div class="col-md-11">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Inicio <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
        <div class="col-md-1">
            <button class="btn btn-light btn-sm rounded-circle" id="btnLogout" onclick="logout()"><i class="fas fa-sign-out-alt color-primary-blue"></i></button>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link nav-pill-rounded active" id="v-pills-home-tarefas" data-toggle="pill" href="#v-pills-tarefas" role="tab" aria-controls="v-pills-tarefas" aria-selected="true"><i class="fas fa-tasks"></i> Tarefas</a>
                <a class="nav-link nav-pill-rounded" id="v-pills-configuracoes-tab" data-toggle="pill" href="#v-pills-configuracoes" role="tab" aria-controls="v-pills-configuracoes" aria-selected="false"><i class="fas fa-cog"></i> Configurações</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="tab-content" id="v-pills-tabContent">
                <!-- Inicio: Painel de Tarefas -->
                <div class="tab-pane fade show active" id="v-pills-tarefas" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    <div class="row">
                        <div class="col-md-3 offset-md-9">
                            <button type="button" class="btn btn-sm btn-block btn-rounded bg-secondary-yellow" data-toggle="modal" data-target="#modalCadastrarTarefa">
                                <i class="fas fa-plus-circle"></i> Cadastrar Tarefa
                            </button>
                        </div>
                    </div>

                    <div class="card border-0 rounded shadow-sm mt-3">
                        <div class="card-body">
                            <ul class="list-group list-group-flush mt-3" id="listagemTarefas"></ul>
                        </div>
                    </div>
                </div>
                <!-- Fim: Painel de Tarefas -->

                <!-- Inicio: Painel de Configurações -->
                <div class="tab-pane fade" id="v-pills-configuracoes" role="tabpanel" aria-labelledby="v-pills-configuracoes-tab">
                    <div class="card p-2 border-0 shadow-sm">
                        <div class="card-body">
                            <h2 class="font-weight-bold">Alterar Dados</h2>
                            <form id="alterarEmailUsuario">
                                <div class="form-group">
                                    <label for="emailUsuario">Email</label>
                                    <input type="email" class="form-control" id="emailUsuario" name="email" aria-describedby="emailUsuario" placeholder="Digite o email" required>
                                </div>
                                <input type="hidden" class="form-control cod-usuario" name="cod">
                                <button type="submit" id="btn-alterar-email" class="btn btn-primary btn-sm btn-rounded"><i class="fas fa-save"></i> Salvar Alteração</button>
                            </form>
                            <hr>
                            <form class="mt-4" id="alterarSenhaUsuario">
                                <div class="form-group">
                                    <label for="senhaUsuario">Senha</label>
                                    <input type="password" class="form-control" id="senhaUsuario" name="senha" placeholder="********" required>
                                </div>
                                <button type="submit" id="btn-alterar-senha"  class="btn btn-primary btn-sm btn-rounded"><i class="fas fa-save"></i> Salvar Alteração</button>
                            </form>
                        </div>
                    </div>

                    <div class="card p-2 border-0 shadow-sm mt-3">
                        <div class="card-body">
                            <h2 class="font-weight-bold">Deletar conta</h2>
                            <small>O processo não pode ser revertido e todas as suas tarefas também serão deletadas automaticamente.</small>
                            <form id="deletarUsuario">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" id="codUsuario" name="cod" aria-describedby="codUsuario">
                                </div>
                                <button type="submit" class="btn btn-danger btn-sm btn-rounded" id="btn-deletar-usuario"><i class="fas fa-trash"></i> Deletar</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Fim: Painel de Configurações -->
            </div>
        </div>
    </div>
</div>

<!-- Modal: Cadastrar Tarefa -->
<div class="modal fade" id="modalCadastrarTarefa" tabindex="-1" aria-labelledby="modalCadastrarTarefa" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-secondary-yellow">
                <h5 class="modal-title font-weight-bold">Nova Tarefa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="cadastrarTarefa">
                <div class="modal-body">
                    <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tituloTarefa">Título</label>
                                    <input type="text" class="form-control" id="tituloTarefa" name="titulo" placeholder="Digite o título">
                                </div>
                                <div class="form-group">
                                    <label for="descricaoTarefa">Descrição</label>
                                    <textarea class="form-control" id="descricaoTarefa" name="descricao" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dataInicioTarefa">Data Inicio</label>
                                    <input type="datetime-local" class="form-control" name="dataInicio" id="dataInicioTarefa">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dataFimTarefa">Data Fim</label>
                                    <input type="datetime-local" class="form-control" name="dataFim" id="dataFimTarefa">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-rounded" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary btn-rounded" id="btn-cadastrar-tarefa"><i class="fas fa-save"></i> Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Alterar Tarefa -->
<div class="modal fade" id="modalAlterarTarefa" tabindex="-1" aria-labelledby="modalAlterarTarefa" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title font-weight-bold">Editar Tarefa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="alterarTarefa">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tituloTarefaAlterar">Título</label>
                                <input type="text" class="form-control" id="tituloTarefaAlterar" name="titulo" placeholder="Digite o título">
                            </div>
                            <div class="form-group">
                                <label for="descricaoTarefaAlterar">Descrição</label>
                                <textarea class="form-control" id="descricaoTarefaAlterar" name="descricao" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dataInicioTarefaAlterar">Data Inicio</label>
                                <input type="datetime-local" class="form-control" name="dataInicio" id="dataInicioTarefaAlterar">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dataFimTarefaAlterar">Data Fim</label>
                                <input type="datetime-local" class="form-control" name="dataFim" id="dataFimTarefaAlterar">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="status" id="statusTarefaAlterar">
                                <label class="custom-control-label" for="statusTarefaAlterar">Ativado</label>
                            </div>
                        </div>
                        <input type="hidden" class="form-control" id="codAlterar" name="cod">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-rounded" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary btn-rounded" id="btn-alterar-tarefa"><i class="fas fa-save"></i> Alterar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- JS e Frameworks -->
<script src="view/assets/vendor/jQuery/jquery-3.5.1.min.js"></script>
<script src="view/assets/vendor/bootstrap-4.5.3-dist/js/bootstrap.bundle.min.js"></script>
<script src="view/assets/vendor/toastr/toastr.min.js"></script>
<script src="view/assets/ajax/usuario.min.js"></script>
<script src="view/assets/ajax/tarefa.min.js"></script>
<script src="view/assets/ajax/login.min.js"></script>
</body>
</html>