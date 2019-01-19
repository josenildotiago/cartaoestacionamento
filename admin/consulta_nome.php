<?php
session_start();
?>
<?php require '../includes/header.php'; ?>
<?php require '../includes/header.menu.php'; ?>
<div class="container-fluid col-11">
<?php if(isset($_SESSION['get'])){ echo $_SESSION['get']; unset($_SESSION['get']); } ?>
    <h3>Consulta por Nome</h3><hr>
    <div class="row">
        <div class="form-group col-10">
            <form name="frmBusca" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>?a=buscar" >
                <label>Pesquisar por Nome</label><br>
                <input type="text" name="palavra" class="form-group col-10" placeholder="PESQUISAR POR NOME" required autofocus/>
                <button class="btn btn-primary" type="submit">Buscar Nome</button>
                <!-- <input type="submit"  value="Buscar Nome"  class="btn btn-primary"  /> -->
            </form>
        </div>
        
    </div>
</div>
<div class="container-fluid" >
    <table class="table table-striped table-dark table-sm">
        <thead>
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
            <?php include_once 'carrega_nome.php'; ?>
            <div class="container row" >
                <h4 class="text-center">Encontrado(s) <span class="badge badge-danger"><?php if (isset($_SESSION['val'])) : echo $_SESSION['val']; unset($_SESSION['val']); endif; ?></span> Registro(s)</h4>
            </div>
        </tbody>
    </table>
</div>
<?php require '../includes/footer.php'; ?>