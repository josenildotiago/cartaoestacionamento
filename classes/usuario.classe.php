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
        $sql = "SELECT * FROM usu_cadastro WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            return $sql->fetch();
        }else {
            return array();
        }
    }
    public function getInfoLogadoPendente($id){
        $sql = "SELECT * FROM usu_cadastro_pendencias WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            return $sql->fetch();
        }else {
            return array();
        }
    }

    //INSERINDO NO BANCO DE DADOS
    public function adicionar($nome, $sexo, $cpf, $nascimento, $cep, $rua, $numero, $cidade, $bairro, $uf, $ibge, $usuario, $antigo, $obs) {
        $emailexistente = $this->existeCpf($cpf);
        if(count($emailexistente) == 0){
            $sql = "INSERT INTO usu_cadastro SET nome = :nome, sexo = :sexo, cpf = :cpf, nacimento = :nacimento, cep = :cep, rua = :rua, numero = :numero, cidade = :cidade, bairro = :bairro, uf = :uf, ibge = :ibge, usuario = :usuario, id_antigo = :id_antigo, obs = :obs";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':nome', $nome);
            $sql->bindValue(':sexo', $sexo);
            $sql->bindValue(':cpf', $cpf);
            $sql->bindValue(':nacimento', $nascimento);
            $sql->bindValue(':cep', $cep);
            $sql->bindValue(':rua', $rua);
            $sql->bindValue(':numero', $numero);
            $sql->bindValue(':cidade', $cidade);
            $sql->bindValue(':bairro', $bairro);
            $sql->bindValue(':uf', $uf);
            $sql->bindValue(':ibge', $ibge);
            $sql->bindValue(':usuario', $usuario);
            $sql->bindValue(':id_antigo', $antigo);
            $sql->bindValue(':obs', $obs);
            $sql->execute();
            $_SESSION['msg'] = "<div class='alert alert-success text-center' role='alert'>$nome cadastrado com sucesso!
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button>
            </div>";
            return TRUE;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger text-center' role='alert'>O CPF $cpf JÁ EXISTE NO BANCO DE DADOS!
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button>
            </div>";
            return FALSE;
        }
    }

    //INSERINDO NO BANCO DE DADOS
    public function editar($nome, $sexo, $cpf, $nascimento, $cep, $rua, $numero, $cidade, $bairro, $uf, $ibge, $usuario, $antigo, $obs, $id) {
        $sql = "UPDATE usu_cadastro SET nome = :nome, sexo = :sexo, cpf = :cpf, nacimento = :nacimento, cep = :cep, rua = :rua, numero = :numero, cidade = :cidade, bairro = :bairro, uf = :uf, ibge = :ibge, usuario = :usuario, id_antigo = :id_antigo, obs = :obs WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':sexo', $sexo);
        $sql->bindValue(':cpf', $cpf);
        $sql->bindValue(':nacimento', $nascimento);
        $sql->bindValue(':cep', $cep);
        $sql->bindValue(':rua', $rua);
        $sql->bindValue(':numero', $numero);
        $sql->bindValue(':cidade', $cidade);
        $sql->bindValue(':bairro', $bairro);
        $sql->bindValue(':uf', $uf);
        $sql->bindValue(':ibge', $ibge);
        $sql->bindValue(':usuario', $usuario);
        $sql->bindValue(':id_antigo', $antigo);
        $sql->bindValue(':obs', $obs);
        if ($sql->execute()) {
            $_SESSION['msg'] = "<div class='alert alert-success text-center' role='alert'>$nome Alterado com sucesso!
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button>
            </div>";
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger text-center' role='alert'>$nome NÃO CADASTRADO NO BANCO DE DADOS!
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button>
            </div>";
            return false;
        }
}
    // DELETAR PENDENCIA
    public function deletarPendencia($id){
        $sql = "DELETE FROM usu_cadastro_pendencias WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        if ($sql->execute()) {
            $_SESSION['msg'] = "<div class='alert alert-success text-center' role='alert'>$nome Deletado com sucesso!
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button>
            </div>";
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger text-center' role='alert'>$nome NÃO CADASTRADO NO BANCO DE DADOS!
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button>
            </div>";
            return false;
        }
    }
   // MOVENDO LINHA PARA EMITIDOS
   public function moverPendencia($id) {
    $sql = "INSERT INTO usu_cadastro (nome, sexo, cpf, nacimento, cep, rua, numero, cidade, bairro, uf, ibge, usuario, id_antigo, obs) SELECT nome, sexo, cpf, nacimento, cep, rua, numero, cidade, bairro, uf, ibge, usuario, id_antigo, obs FROM usu_cadastro_pendencias WHERE id = :id";
    $sql = $this->pdo->prepare($sql);
    $sql->bindValue(':id', $id);
    if ($sql->execute()) {
        $sql = "DELETE FROM usu_cadastro_pendencias WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        if ($sql->execute()) {
            $_SESSION['msg'] = "<div class='alert alert-success text-center' role='alert'>$nome Aprovado com sucesso!
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button>
            </div>";
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger text-center' role='alert'>$nome NÃO CADASTRADO NO BANCO DE DADOS!
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button>
            </div>";
            return false;
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger text-center' role='alert'>$nome NÃO CADASTRADO NO BANCO DE DADOS!
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
        </button>
        </div>";
        return false;
    }

} 
    //INSERINDO NO BANCO DE DADOS
    public function editarPendencia($nome, $sexo, $cpf, $nascimento, $cep, $rua, $numero, $cidade, $bairro, $uf, $ibge, $usuario, $antigo, $obs, $id) {
        $sql = "UPDATE usu_cadastro_pendencias SET nome = :nome, sexo = :sexo, cpf = :cpf, nacimento = :nacimento, cep = :cep, rua = :rua, numero = :numero, cidade = :cidade, bairro = :bairro, uf = :uf, ibge = :ibge, usuario = :usuario, id_antigo = :id_antigo, obs = :obs WHERE id = :id";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':sexo', $sexo);
        $sql->bindValue(':cpf', $cpf);
        $sql->bindValue(':nacimento', $nascimento);
        $sql->bindValue(':cep', $cep);
        $sql->bindValue(':rua', $rua);
        $sql->bindValue(':numero', $numero);
        $sql->bindValue(':cidade', $cidade);
        $sql->bindValue(':bairro', $bairro);
        $sql->bindValue(':uf', $uf);
        $sql->bindValue(':ibge', $ibge);
        $sql->bindValue(':usuario', $usuario);
        $sql->bindValue(':id_antigo', $antigo);
        $sql->bindValue(':obs', $obs);
        if ($sql->execute()) {
            $_SESSION['msg'] = "<div class='alert alert-success text-center' role='alert'>$nome Alterado com sucesso!
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button>
            </div>";
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger text-center' role='alert'>$nome NÃO CADASTRADO NO BANCO DE DADOS!
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button>
            </div>";
            return false;
        }
}

    //INSERINDO USUARIOS
    public function adicionarUsuario($nome, $sexo, $cpf, $nascimento, $cep, $rua, $numero, $cidade, $bairro, $uf, $ibge, $usuario, $antigo, $obs){
        $sql = "INSERT INTO usu_cadastro SET nome = :nome, sexo = :sexo, cpf = :cpf, nacimento = :nacimento, cep = :cep, rua = :rua, numero = :numero, cidade = :cidade, bairro = :bairro, uf = :uf, ibge = :ibge, usuario = :usuario, id_antigo = :id_antigo, obs = :obs";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':sexo', $sexo);
        $sql->bindValue(':cpf', $cpf);
        $sql->bindValue(':nacimento', $nascimento);
        $sql->bindValue(':cep', $cep);
        $sql->bindValue(':rua', $rua);
        $sql->bindValue(':numero', $numero);
        $sql->bindValue(':cidade', $cidade);
        $sql->bindValue(':bairro', $bairro);
        $sql->bindValue(':uf', $uf);
        $sql->bindValue(':ibge', $ibge);
        $sql->bindValue(':usuario', $usuario);
        $sql->bindValue(':id_antigo', $antigo);
        $sql->bindValue(':obs', $obs);
        if ($sql->execute()) {
            $_SESSION['msg'] = "<div class='alert alert-success text-center' role='alert'>$nome cadastrado com sucesso!
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button>
            </div>";
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger text-center' role='alert'>$nome NÃO CADASTRADO NO BANCO DE DADOS!
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button>
            </div>";
            return false;
        }
        
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
        
            $link = "http://localhost/projetox/inativo-2.0/admin/redefinir2.php?token=".$token;
        
            $mensagem = "Clique no link para redefinir sua senha:<br/>".$link;
        
            $assunto = "Redefinição de senha";
        
            $headers = 'From: seuemail@seusite.com.br'."\r\n" .
                        'X-Mailer: PHP/'.phpversion();
        
            //mail($email, $assunto, $mensagem, $headers);
        
            echo $mensagem;
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

    //FAZ UMA BUSCA SE O CPF JÁ EXISTE
    private function existeCpf($cpf) {
        $sql = "SELECT id FROM usu_cadastro WHERE cpf = :cpf";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':cpf', $cpf);
        $sql->execute();
        
        if ($sql->rowCount() > 0){
            $array = $sql->fetch();
        }  else {
            $array = array();
        }
        
        return $array;
    }

    //FAZ UMA BUSCA SE O CPF JÁ EXISTE
    private function existeCpf2($cpf) {
        $sql = "SELECT cpf FROM usu_cadastro WHERE cpf = :cpf";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':cpf', $cpf);
        $sql->execute();
        
        if ($sql->rowCount() > 0){
            $array = $sql->fetch();
        }  else {
            $array = array();
        }
        
        return $array;
    }
}