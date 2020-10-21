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

    <title>Sistema de Gerenciamento de Tarefas | Cadastrar</title>
</head>
<body>

<div class="container h-100">
    <div class="row justify-content-center h-100 align-items-center">
        <div class="col-md-6">
            <div class="authincation-content">
                <div class="row no-gutters">
                    <div class="col-xl-12">
                        <div class="rounded shadow-lg" style="padding: 50px 50px;">
                            <form id="cadastrarUsuario" method="post">
                                <div class="form-group">
                                    <label class="font-weight-bold" for="emailUsuario">Email</label>
                                    <input type="email" class="form-control" id="emailUsuario" name="email" aria-describedby="emailUsuario" placeholder="Digite o email">
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold" for="senhaUsuario">Senha</label>
                                    <input type="password" class="form-control" id="senhaUsuario" name="senha" placeholder="*******">
                                </div>
                                <button type="submit" class="btn btn-primary btn-block bg-primary-blue" id="btn-cadastrar-usuario"><i class="fas fa-user-plus"></i> Cadastrar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- JS e Frameworks -->
<script src="view/assets/vendor/jQuery/jquery-3.5.1.min.js"></script>
<script src="view/assets/vendor/bootstrap-4.5.3-dist/js/bootstrap.bundle.min.js"></script>
<script src="view/assets/vendor/toastr/toastr.min.js"></script>
<script src="view/assets/ajax/cadastroUsuario.min.js"></script>
</body>
</html>