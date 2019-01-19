<?php
require 'config.php';
require '../classes/usuario.classe.logar.php';
require '../pages/header.php';
if(!empty($_GET['token'])) {
	$token = $_GET['token'];

	$sql = "SELECT * FROM usuarios_token WHERE hash = :hash AND used = 0 AND expirado_em > NOW()";
	$sql = $pdo->prepare($sql);
	$sql->bindValue(":hash", $token);
	$sql->execute();

	if($sql->rowCount() > 0) {
		$sql = $sql->fetch();
		$id = $sql['id_usuario'];

		if(!empty($_POST['senha'])) {
			$senha = $_POST['senha'];

			$sql = "UPDATE usuarios SET senha = :senha WHERE id = :id";
			$sql = $pdo->prepare($sql);
			$sql->bindValue(":senha", md5($senha));
			$sql->bindValue(":id", $id);
			$sql->execute();

			$sql = "UPDATE usuarios_token SET used = 1 WHERE hash = :hash";
			$sql = $pdo->prepare($sql);
			$sql->bindValue(":hash", $token);
			$sql->execute();

			//echo "<div class='alert alert-success text-center' role='alert'>Senha alterada com sucesso!</div>";
			$_SESSION['msg'] = "<div class='alert alert-success text-center' role='alert'>Senha alterada com sucesso!</div>";
			?>
        		<script type="text/javascript">window.location.href="login.php";</script>
        	<?php
			//exit;
		}

		?>
		<div class="wrapper">
			<?php if (isset($_SESSION['msg'])) { echo $_SESSION['msg']; unset($_SESSION['msg']); } ?>
			<form class="form-signin" method="POST">
				<div class="center">
					<img src="../assets/images/ico.png" alt="" width="200" height="210"/>
				</div>
				<h2 class="form-signin-heading">Digite a nova senha</h2>

				<input type="password" class="form-control" name="senha" placeholder="senha" required autofocus />
				<br>
				<br>
				<button class="btn btn-lg btn-primary btn-block" type="submit">Trocar Senha</button>
				<a class="btn btn-lg btn-primary btn-block" href="../">Voltar</a>
				<!-- <a class="btn btn-lg btn-primary btn-block" href="../admin/cadastrar-usuarios.php">Cadastrar Usuario</a> -->
			</form>
		</div>
		<?php



	} else {
		echo "<div class='alert alert-danger text-center' role='alert'>Token inválido ou usado!</div>";
		//exit;
	}
}
require '../pages/footer.php'; ?>