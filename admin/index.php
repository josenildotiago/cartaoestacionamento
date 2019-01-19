<?php
session_start();
if (!isset($_SESSION['logado']) && empty($_SESSION['logado'])) {
    header("Location: login.php");
    exit;
}else{
    header("Location: ../");
    exit;
}