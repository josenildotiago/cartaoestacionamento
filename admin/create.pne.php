<?php
session_start();
require '../classes/usuario.classe.pne.php';
$a = new Usuario();
//$usu = $a->getInfoLogado($_SESSION['logado']);


$nome = addslashes($_POST['nome']);
$sexo = addslashes($_POST['sexo']);
$cpf = addslashes($_POST['cpf']);
$nascimento = addslashes($_POST['nacimento']);
$cep = addslashes($_POST['cep']);
$rua = addslashes($_POST['rua']);
$numero = addslashes($_POST['numero']);
$cidade = addslashes($_POST['cidade']);
$bairro = addslashes($_POST['bairro']);
$uf = addslashes($_POST['uf']);
$ibge = addslashes($_POST['ibge']);
$usuario = addslashes($_SESSION['nomelogado']);
$antigo = addslashes($_POST['ids_ant']);
$obs = addslashes($_POST['obs']);

$nome = mb_strtoupper($nome);
$sexo = mb_strtoupper($sexo);
$rua = mb_strtoupper($rua);
$cidade = mb_strtoupper($cidade);
$bairro = mb_strtoupper($bairro);
$uf = mb_strtoupper($uf);
$usuario = mb_strtoupper($usuario);
$antigo = mb_strtoupper($antigo);
$obs = mb_strtoupper($obs);

$u = new Usuario();
$u->adicionar($nome, $sexo, $cpf, $nascimento, $cep, $rua, $numero, $cidade, $bairro, $uf, $ibge, $usuario, $antigo, $obs);
header("Location: pne.php");
?>