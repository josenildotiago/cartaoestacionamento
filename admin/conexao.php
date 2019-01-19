<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$dbname = "db_banco";


//Criar a conexão com o banco de dados

$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);
$conn->set_charset('utf8');

if (!$conn) {
  die("falha na conexao: " . mysqli_connect_error());
}else {
  
}