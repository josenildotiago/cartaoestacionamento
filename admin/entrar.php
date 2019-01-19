<?php session_start(); ?>
<?php require '../classes/login.classe.php'; ?>
<?php require '../classes/usuario.classe.logar.php'; ?>
<?php
$u = new Logar();
if (isset($_POST['email']) && !empty($_POST['email'])) {
    $email = addslashes($_POST['email']);
    $senha = addslashes($_POST['senha']);
    if($u->login($email, $senha)) {
        $id = $_SESSION['logado'];
        $usu = new Usuario();
        $usuario = $usu->getInfoLogado($id);
        $nome = $usuario['nome'];
        ?>
        <?php
        $_SESSION['msg'] = "<div class='alert alert-success text-center' role='alert'>$nome Logado Com Sucesso!
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
        </button></div>";
        ?>
        <script type="text/javascript">window.location.href="../";</script>
        <?php
    } else {
        ?>
        <?php
        $_SESSION['msg'] = "<div class='alert alert-danger text-center' role='alert'>E-mail e/ou senha errado!
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
        </button></div>";
        ?>
        <script type="text/javascript">window.location.href="login.php";</script>
        <?php
    }
}
?>