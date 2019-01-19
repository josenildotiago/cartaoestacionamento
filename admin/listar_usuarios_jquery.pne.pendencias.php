<?php
session_start();

?>
<?php
include_once "conexao.php";

$pagina = filter_input(INPUT_POST, 'pagina', FILTER_SANITIZE_NUMBER_INT);
$qnt_result_pg = filter_input(INPUT_POST, 'qnt_result_pg', FILTER_SANITIZE_NUMBER_INT);
//calcular o inicio visualização
$inicio = ($pagina * $qnt_result_pg) - $qnt_result_pg;

if (isset($_SESSION['frase'])) {
	$ordem = $_SESSION['frase'];
}else {
	$ordem = "DESC";
}

//consultar no banco de dados
$result_usuario = "SELECT * FROM usu_cadastro_pne_pendencias ORDER BY id $ordem LIMIT $inicio, $qnt_result_pg";
$resultado_usuario = mysqli_query($conn, $result_usuario);


//Verificar se encontrou resultado na tabela "usuarios"
if(($resultado_usuario) AND ($resultado_usuario->num_rows != 0)){
	?>
	<div class="col-md-12">
	<div class="table-responsive" >
		<table class="table table-striped table-bordered table-hover table-sm">
			<thead class="thead-dark">
				<tr>
					<th>ID</th>
					<th>Nome</th>
					<th>Sexo</th>
					<th>CPF</th>
					<th>Nascimento</th>
					<th>CEP</th>
					<th>Rua</th>
					<th>N°</th>
					<th>Cidade</th>
					<th>Bairro</th>
					<th>UF</th>
					<th>Ações</th>
				</tr>
			</thead>
			<tbody>
				<?php
				while($row_usuario = mysqli_fetch_assoc($resultado_usuario)){
					?>
					<tr>
					<?php $id = $row_usuario['id'];
					?>
						<th><?php echo $row_usuario ['id']; ?></th>
						<td><?php echo $row_usuario ['nome']; ?></td>
						<td><?php echo $row_usuario ['sexo']; ?></td>
						<td><?php echo $row_usuario ['cpf']; ?></td>
						<td><?php echo $row_usuario ['nacimento']; ?></td>
						<td><?php echo $row_usuario ['cep']; ?></td>
						<td><?php echo $row_usuario ['rua']; ?></td>
						<td><?php echo $row_usuario ['numero']; ?></td>
						<td><?php echo $row_usuario ['cidade']; ?></td>
						<td><?php echo $row_usuario ['bairro']; ?></td>
						<td><?php echo $row_usuario ['uf']; ?></td>
						<td><?php echo "<a class='btn btn-primary btn-sm' href='editar.pne.php?id=$id' ><i class='fas fa-user-edit' ></i></a>"; ?></td>
					</tr>
					
					<?php
				}?>
				</tbody>
			</table>
		</div>
	</duv>
	<?php
	//Paginação - Somar a quantidade de usuários
	$result_pg = "SELECT COUNT(id) AS num_result FROM usu_cadastro_pne";
	$resultado_pg = mysqli_query($conn, $result_pg);
	$row_pg = mysqli_fetch_assoc($resultado_pg);

	//Quantidade de pagina
	$quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg);

	//Limitar os link antes depois
	$max_links = 6;

	echo '<nav aria-label="paginacao">';
	echo '<ul class="pagination">';
	echo '<li class="page-item">';
	echo "<span class='page-link'><a href='#' onclick='listar_usuario(1, $qnt_result_pg)'>Primeira</a> </span>";
	echo '</li>';
	for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
		if($pag_ant >= 1){
			echo "<li class='page-item'><a class='page-link' href='#' onclick='listar_usuario($pag_ant, $qnt_result_pg)'>$pag_ant </a></li>";
		}
	}
	echo '<li class="page-item active">';
	echo '<span class="page-link">';
	echo "$pagina";
	echo '</span>';
	echo '</li>';

	for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
		if($pag_dep <= $quantidade_pg){
			echo "<li class='page-item'><a class='page-link' href='#' onclick='listar_usuario($pag_dep, $qnt_result_pg)'>$pag_dep</a></li>";
		}
	}
	echo '<li class="page-item">';
	echo "<span class='page-link'><a href='#' onclick='listar_usuario($quantidade_pg, $qnt_result_pg)'>Última</a></span>";
	echo '</li>';
	echo '</ul>';
	echo '</nav>';

}else{
	echo "<div class='alert alert-danger' role='alert'>Nenhum usuário encontrado!</div>";
}
?>