<?php
session_start();
require 'classes/usuario.classe.logar.php';
if (isset($_SESSION['logado']) && !empty($_SESSION['logado'])) {
    
} else {
    header("Location: admin/login.php");
    exit;
}
?>
<?php
$id = $_SESSION['logado'];
$a = new Usuario();
$b = $a->getInfoLogado($id);
$_SESSION['nomelogado'] = $b['nome'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cartão Estacionamento</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/signin.css" rel="stylesheet">
    <link rel="icon" href="assets/img/img/favicon.ico">
</head>
<body>
    <div class="container responsive-table">
    <?php if (isset($_SESSION['msg'])) { echo $_SESSION['msg']; unset($_SESSION['msg']); } ?>
        <div class="form-signin">
            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                <div class="card-header">Cadastro Idoso</div>
                <div class="card-body">
                    <h5 class="card-title">Cartão Estacionamento do Idoso</h5>
                    <p class="card-text"></p>
                    <a href="admin/idoso.php" class="btn btn-dark">Acessar</a>
                </div>
            </div>
            <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                <div class="card-header">Cadastro PNE</div>
                <div class="card-body">
                    <h5 class="card-title">Pessoas com Dificuldades de Locomoção</h5>
                    <p class="card-text"></p>
                    <a href="admin/pne.php" class="btn btn-primary">Acessar</a>
                </div>
            </div>
            <div class="z-depth-5" style="max-width: 18rem;" >
                <div class="z-depth-5">
                    <div class="alert alert-success text-center">
                        <?php echo "Olá ".$_SESSION['nomelogado'];?>
                    </div> 
                </div>
            </div>
            <div class="bg-white mb-3" style="max-width: 18rem;">
                <div class="breadcrumb bg-white">
                    <!-- <a class="btn btn-lg btn-primary btn-block" href="#">Criar Usuários</a> -->
                    <a href="sair.php" class="btn btn-lg btn-primary btn-block">Sair</a>
                    <a class="btn btn-lg btn-primary btn-block" href="../index.html">Página Principal</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>