<?php
class Usuario{
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

    //PEGA O ID ESPECIFICO DE CADA CONTATO
    public function getInfoLogado($id){
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            return $sql->fetch();
        }else {
            return array();
        }
    }

    //INSERINDO NO BANCO DE DADOS   Primeiro os obrigatorios
    public function adicionar($nome, $email, $usuario, $senha) {
        $emailexistente = $this->existeEmail($email);
        if(count($emailexistente) == 0){
            $sql = "INSERT INTO usuarios SET 
            nome = :nome, email = :email,
            usuario = :usuario, senha = :senha";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':nome', $nome);
            $sql->bindValue(':email', $email);
            $sql->bindValue(':usuario', $usuario);
            $sql->bindValue(':senha', md5($senha));
            $sql->execute();
            
            return TRUE;
        } else {
            return FALSE;
        }
    }
    //INSERINDO USUARIOS
    public function adicionarUsuario($nome, $cpf, $modalidade, $permissao, $caixa, $usu_login, $antes, $cnpj){
        $sql = "INSERT INTO usuario SET 
            nome = :nome, cpf = :cpf, modalidade = :modalidade, permissao = :permissao,
            caixa = :caixa, usu_login = :usu_login, antes = :antes, cnpj = :cnpj";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':cpf', $cpf);
        $sql->bindValue(':modalidade', $modalidade);
        $sql->bindValue(':permissao', $permissao);
        $sql->bindValue(':caixa', $caixa);
        $sql->bindValue(':usu_login', $usu_login);
        $sql->bindValue(':antes', $antes);
        $sql->bindValue(':cnpj', $cnpj);
        if ($sql->execute()) {
            $_SESSION['msg'] = "<div class='alert alert-success text-center' role='alert'>$nome cadastrado com sucesso!</div>";
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger text-center' role='alert'>$nome NÃO CADASTRADO NO BANCO DE DADOS!</div>";
            return false;
        }
        
    }

    //FAZ UMA BUSCA SE O EMAIL JÁ EXISTE
    private function existeEmail($email) {
        $sql = "SELECT id FROM usuarios WHERE email = :email";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':email', $email);
        $sql->execute();
        
        if ($sql->rowCount() > 0){
            $array = $sql->fetch();
        }  else {
            $array = array();
        }
        
        return $array;
    }

    public function trocarSenha($email){
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":email", $email);
        $sql->execute();

        if($sql->rowCount() > 0) {

            $sql = $sql->fetch();
            $id = $sql['id'];
        
            $token = md5(time().rand(0, 99999).rand(0, 99999));
        
            $sql = "INSERT INTO usuarios_token (id_usuario, hash, expirado_em) VALUES (:id_usuario, :hash, :expirado_em)";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id_usuario", $id);
            $sql->bindValue(":hash", $token);
            $sql->bindValue(":expirado_em", date('Y-m-d H:i', strtotime('+2 months')));
            $sql->execute();
            

            $link = "http://getranmossoro.com.br/cartaoestacionamento/admin/redefinir2.php?token=$token";
        
            $mensagem = "Clique no link para redefinir sua senha: ".$link;
        
            $assunto = "Redefinição de senha";
            $headers = 'From: naoresponda@getranmossoro.com.br'."\r\n" .
                        'X-Mailer: PHP/'.phpversion();
            $headers .= 'Content-type: text/html; charset=utf8' . "\r\n";
        
            mail($email, $assunto, $mensagem, $headers);
            $_SESSION['msg'] = "<div class='alert alert-success text-center' role='alert'>E-mail enviado para $email!</div>";
        
            //echo $mensagem;
            return true;
            //exit;
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger text-center' role='alert'>E-mail não existente no banco de dados!</div>";
            return false;
        }
    }

    public function enviarLink($token){
        $sql = "SELECT * FROM usuarios_token WHERE hash = :hash AND used = 0 AND expirado_em > NOW()";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":hash", $token);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            $id = $sql['id_usuario'];
    
            if(!empty($_POST['senha'])) {
                $senha = $_POST['senha'];
    
                $sql = "UPDATE usuarios SET senha = :senha WHERE id = :id";
                $sql = $this->pdo->prepare($sql);
                $sql->bindValue(":senha", md5($senha));
                $sql->bindValue(":id", $id);
                $sql->execute();
    
                $sql = "UPDATE usuarios_token SET used = 1 WHERE hash = :hash";
                $sql = $this->pdo->prepare($sql);
                $sql->bindValue(":hash", $token);
                $sql->execute();
    
                //echo "Senha alterada com sucesso!";
                $_SESSION['msg1'] = "<div class='alert alert-success text-center' role='alert'>Senha alterada com sucesso!</div>";
                return true;
                //header("Location: login.php");
                //exit;
            } else {
                //echo "Token inválido ou usado!";
                $_SESSION['msg'] = "<div class='alert alert-danger text-center' role='alert'>Token inválido ou usado!</div>";
                return false;
                //exit;
            }
        }
    }
}