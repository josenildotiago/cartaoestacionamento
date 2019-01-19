<?php
session_start();
if (!isset($_SESSION['logado']) && empty($_SESSION['logado'])) {
    
} else {
    header("Location: ../");
}
?>
<?php require '../pages/header.php'; ?>
<div class="wrapper">
    <form class="form-signin" action="trocar.php" method="POST">
        <div class="center">
            <img src="../assets/images/ico.png" alt="" width="200" height="210"/>
        </div>
        <h2 class="form-signin-heading">Esqueceu a Senha?</h2>
        <h6 class="form-signin-heading text-center text-warning">Enviaremos um link para seu E-mail</h6>
        <input type="text" class="form-control" name="email" placeholder="Email" required autofocus />
        <br>
        <br>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Enviar</button>
        <a class="btn btn-lg btn-primary btn-block" href="../">Voltar</a>
        <!-- <a class="btn btn-lg btn-primary btn-block" href="../admin/cadastrar-usuarios.php">Cadastrar Usuario</a> -->
    </form>
</div>
<?php require '../pages/footer.php'; ?>