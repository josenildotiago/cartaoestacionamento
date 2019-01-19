<?php
session_start();
if (!isset($_SESSION['logado']) && empty($_SESSION['logado'])) {
    header("Location: login.php");
    exit;
} else {
    header("Location: ../");
    exit;
}
?>
<?php require '../pages/header.php'; ?>
<div class="wrapper">
    <div class="form-signin">
        <!-- <div class="text-center" >
            <img class="mb-4" src="../assets/images/ico.png" alt="" width="200" height="200">
        </div> -->
        <?php
        if (isset($_SESSION['msg'])) { echo $_SESSION['msg']; unset($_SESSION['msg']); } ?>
        <form class=""  method="POST" action="cadastrar.php" >
            <h2 class="text-center">Cadastro Usuários</h2>
            <label for="nome">Nome</label>
            <input class="form-control" type="text" name="nome" placeholder="Dígite seu nome e sobrenome" >
            <label for="email">E-mail</label>
            <input class="form-control" type="text" name="email" placeholder="Dígite seu email" >
            <label for="usuario">Usuário</label>
            <input class="form-control" type="text" name="usuario" placeholder="Dígite seu usuario" >
            <label for="senha">Senha</label>
            <input class="form-control" type="password" name="senha" placeholder="(min. de 6 caracteres)" >
            <input class="btn btn-lg btn-primary btn-block" type="submit" name="btnCadUsuario" value="Cadastrar">

            <a class="btn btn-lg btn-primary btn-block" href="../">Voltar</a>
            <a class="btn btn-lg btn-primary btn-block" href="sair.php">Sair</a>
        </form>
    </div>
</div>
<?php require '../pages/footer.php'; ?>
