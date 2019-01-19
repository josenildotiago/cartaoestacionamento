<?php session_start(); ?>
<?php
if (!isset($_SESSION['logado']) && empty($_SESSION['logado'])) {
    
} else {
    header("Location: ../index.php");
}
?>
<?php require '../pages/header.php'; ?>
<div class="container" >
</div>
    <div class="wrapper">
        <form class="form-signin" action="entrar.php" method="POST">
        <?php if (isset($_SESSION['msg'])) { echo $_SESSION['msg']; unset($_SESSION['msg']); } ?>
        <?php if (isset($_SESSION['msg1'])) { echo $_SESSION['msg1']; unset($_SESSION['msg1']); } ?>
            <div class="center">
                <img src="../assets/images/ico.png" alt="" width="200" height="210"/>
            </div>
            <h2 class="form-signin-heading">Entre com seu login</h2>
            <input type="text" class="form-control" name="email" placeholder="Email" required autofocus />
            <div>
                <span class="btn-show-pass">
                <i class="fa fa fa-eye"></i>
                </span>
                <input type="password" class="form-control" name="senha" placeholder="Senha" required />     
            </div>
            <label class="checkbox">
                <input type="checkbox" value="remember-me" id="rememberMe" name="rememberMe"> lembre-me
            </label>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
            <a class="btn btn-lg btn-primary btn-block" href="esqueci-a-senha.php">Esqueceu Senha</a>  
        </form>
    </div>
<?php require '../pages/footer.php'; ?>