<?php
class Logar{
    private $pdo;
    public function __construct(){
        $host = "localhost";
        $user = "root";
        $pass = "";
        $db = "db_banco";
        $dsn = "mysql:host={$host};dbname={$db}";
        $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        try{
            $this->pdo = new PDO($dsn,$user,$pass,$options);
        }
        catch(PDOException $e){
            echo "ERRO AO CONECTAR AO BANCO, CAUSA: ". $e->getMessage();
        }
    //echo "CONACTADO AO BANCO";
    }
    public function login($email, $senha){
        $sql = $this->pdo->prepare("SELECT id FROM usuarios WHERE email = :email AND senha = :senha");
		$sql->bindValue(":email", $email);
		$sql->bindValue(":senha", md5($senha));
		$sql->execute();

		if($sql->rowCount() > 0) {
			$dado = $sql->fetch();
			$_SESSION['logado'] = $dado['id'];
			return true;
		} else {
			return false;
		}
    }
} 