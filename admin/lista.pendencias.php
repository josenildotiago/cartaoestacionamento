<?php
session_start();

?>
<?php require '../includes/header.php'; ?>
<?php require '../includes/header.menu.php'; ?>
<div class="container col-md-12" >
    <h1>Lista de Usuários pendentes por ordem</h1>
    <div class="container-fluid" >
    <div class="d-flex flex-row-reverse" >
        <div class="btn-group btn-sm" >
        <h5>Organizar Por Ordem:</h5><p>&nbsp;&nbsp;&nbsp;&nbsp;</p>
        <a class="btn btn-group btn-info btn-sm" href="?ordem=asc"> ASC </a>
        <a class="btn btn-group btn-info btn-sm" href="?ordem=desc"> DEC </a>
        </div>
    </div>
</div>
<?php
if (isset($_GET['ordem'])) {
    $_SESSION['frase'] = $_GET['ordem'];
}else {
    $_SESSION['frase'] = "DESC";
}
?>
<p class="col-12"></p>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<span id="conteudo"></span>
<script>
var qnt_result_pg = 50;
var pagina = 1;

    $(document).ready(function(){
        listar_usuario(pagina, qnt_result_pg);
    });

    function listar_usuario(pagina, qnt_result_pg){
    var dados = {
        pagina : pagina,
        qnt_result_pg : qnt_result_pg
    }
    $.post('listar_usuarios_jquery.pendencias.php', dados, function(retorna){
        $("#conteudo").html(retorna);
    });
    }
</script>
</div>
<?php require '../includes/footer.php'; ?>