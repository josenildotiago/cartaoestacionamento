<?php 
include_once 'conexao.php';
$a = isset( $_GET['a'] ) ? $_GET['a'] : null;
// Verificamos se a ação é de busca
if ($a == "buscar") {
	// Pegamos a palavra
	$palavra = trim($_POST['palavra']);
	// Verificamos no banco de dados produtos equivalente a palavra digitada
	$querySelect = $conn->query("SELECT * FROM usu_cadastro WHERE nome LIKE '%".$palavra."%' ORDER BY nome");
while ($registros = $querySelect->fetch_assoc()):
	$id = $registros['id'];
	$nome = $registros['nome'];
	$sexo = $registros['sexo'];
	$cpf = $registros['cpf'];
	$nascimento = $registros['nacimento'];
	$cep = $registros['cep'];
	$rua = $registros['rua'];
	$numero = $registros['numero'];
	$cidade = $registros['cidade'];
	$bairro = $registros['bairro'];
	$uf = $registros['uf'];
	echo "<tr>";
    echo "  <td>$id</td>
            <td>$nome</td>
            <td>$sexo</td>
            <td>$cpf</td>
            <td>$nascimento</td>
            <td>$cep</td>
            <td>$rua</td>
            <td>$numero</td>
            <td>$cidade</td>
            <td>$bairro</td>
            <td>$uf</td>
            <td><a class='btn btn-primary btn-sm' href='editar.php?id=$id' role='button'>Editar</a>
            <a class='btn btn-success btn-sm' href='visualizar.php?id=$id' role='button'>Visualizar</a>";
    echo "</tr>";
endwhile;
	$affected_rows = mysqli_affected_rows($conn);
	if ($affected_rows == 0) {
		$palavra = mb_strtoupper($palavra);
		$_SESSION['get'] = "<p class='alert alert-danger 'role='alert'>".'Nenhum nome '.$palavra.' encontrado nos registros!'."</p>";
		?>
        <script type="text/javascript">window.location.href="consulta_nome.php";</script>
        <?php
		//header ("Location: consulta_nome.php");
	}
	$_SESSION['val'] = $affected_rows;
}