<?php
session_start();
require '../classes/usuario.classe.pne.php';
$a = new Usuario();
//$usu = $a->getInfoLogado($_SESSION['logado']);

$id = $_SESSION['editar'];
$nome = addslashes(strtoupper($_POST['nome']));
$sexo = addslashes(strtoupper($_POST['sexo']));
$cpf = addslashes($_POST['cpf']);
$nascimento = addslashes(strtoupper($_POST['nacimento']));
$cep = addslashes($_POST['cep']);
$rua = addslashes(strtoupper($_POST['rua']));
$numero = strtoupper($_POST['numero']);
$cidade = addslashes(strtoupper($_POST['cidade']));
$bairro = addslashes(strtoupper($_POST['bairro']));
$uf = addslashes(strtoupper($_POST['uf']));
$ibge = addslashes($_POST['ibge']);
$usuario = addslashes(strtoupper($_SESSION['nomelogado']));
$antigo = addslashes(strtoupper($_POST['ids_ant']));
$obs = addslashes(strtoupper($_POST['obs']));

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
$u->editar($nome, $sexo, $cpf, $nascimento, $cep, $rua, $numero, $cidade, $bairro, $uf, $ibge, $usuario, $antigo, $obs, $id);
header("Location: pne.php");
?>