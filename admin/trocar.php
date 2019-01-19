<?php
session_start();
require '../classes/usuario.classe.logar.php';
if(!empty($_POST['email'])) {

    $email = $_POST['email'];

    $e = new Usuario();
    if ($e->trocarSenha($email) == true) {
        header("Location: login.php");
    }else {
        header("Location: login.php");
    }
}