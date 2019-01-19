<?php
session_start();
require '../classes/usuario.classe.php';
require ('../classes/rpdf.php');
include ('../fpdf/font/helvetica.php');

$id = $_GET['id'];
$u = new Usuario();
$usuario = $u->getInfoLogado($id);


$nome = $usuario['nome'];
$data = $usuario['nacimento'];
//$id = $_POST['id'];
$data = date('d/m/Y', strtotime('+1year'));
date_default_timezone_set('America/Sao_Paulo');
/*$date = date('d/m/Y');*/

$pdf=new RPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
//$pdf->TextWithRotation(50,65,'Hello',45,-45);
$pdf->SetFontSize(12);
//$pdf->TextWithDirection(110,50,'world!','L');
//$pdf->TextWithDirection(110,50,'world!','U');
//$pdf->TextWithDirection(110,50,'world!','R');
$pdf->TextWithDirection(81,21,'NOME: '.$nome,'D');
$pdf->TextWithDirection(99,45,$data,'D');
$pdf->TextWithDirection(113,70,'IDS '.$id,'D');
$pdf->Output();
?>