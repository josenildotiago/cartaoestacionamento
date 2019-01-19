<?php
session_start();
if (isset($_SESSION['logado'])) {
    
} else {
    $_SESSION['msg'] = "
    <div class='alert alert-danger text-center' role='alert'>Necessário Fazer Login Primeiro!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
    </button></div>";
    header("Location: admin/login.php");
    exit;
}
unset($_SESSION['logado']);
unset($_SESSION['nomelogado']);
$_SESSION['msg'] = "
<div class='alert alert-success text-center' role='alert'>Usuário Deslogado Com Sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
<span aria-hidden='true'>&times;</span>
</button></div>";
header("Location: index.php");
exit;