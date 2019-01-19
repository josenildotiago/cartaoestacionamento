<?php
session_start();
require '../classes/usuario.classe.pne.php';
$id = addslashes($_GET['id']);
$u = new Usuario();
$usuario = $u->getInfoLogado($id);
$data = $usuario['nacimento'];
$d = DateTime::createFromFormat('d/m/Y', $data);

?>






<?php require '../includes/header.php'; ?>
<?php require '../includes/header.menu.pne.php'; ?>

<div class="container theme-showcase" role="main"" >
    <br>
    <h1>Dados do Usuário</h1>
    <div class="media form-row">
        <div class="form-row col">
            <div class="col-2">
                IDS:<input value="<?php echo $usuario['id']; ?>" type="text" class="form-control" placeholder="Sem Resultado" style="text-transform: uppercase" readonly>
            </div>
            <div class="col-3">
                IDS Antigo:<input value="<?php echo $usuario['id_antigo']; ?>" type="text" class="form-control" placeholder="Sem Resultado" style="text-transform: uppercase" readonly>
            </div>
            <div class="col col">
                Cadastrador:<input value="<?php echo $usuario['usuario']; ?>" type="text" class="form-control" placeholder="Sem Resultado" style="text-transform: uppercase" readonly>
            </div>
            <div class="col col-8">
                Nome:<input value="<?php echo $usuario['nome']; ?>" type="text" class="form-control" placeholder="Sem Resultado" style="text-transform: uppercase" readonly>
            </div>
            <div class="col col-1">
                Sexo:<input value="<?php echo $usuario['sexo']; ?>" type="text" class="form-control" placeholder="Sem Resultado" style="text-transform: uppercase" readonly>
            </div>
            <div class="col col">
            <?php if($d && $d->format('d/m/Y')== $data): ?>
            <?php
            // Separa em dia, mês e ano
            list($dia, $mes, $ano) = explode('/', $data);

            // Descobre que dia é hoje e retorna a unix timestamp
            $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            // Descobre a unix timestamp da data de nascimento do fulano
            $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);

            // Depois apenas fazemos o cálculo já citado :)
            $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
            ?>
                Idade:<input value="<?php echo $idade." Anos"; ?>" id="dataano" type="text" class="form-control" placeholder="Sem Resultado" style="text-transform: uppercase" readonly>
                <?php else: ?>
                Idade:<input value="DATA NÃO LEGÍVEL" id="dataano" type="text" class="form-control" placeholder="Sem Resultado" style="text-transform: uppercase" readonly>
                <?php endif; ?>
            </div>
            <div class="col col-8">
                Endereço:<input value="<?php echo $usuario['rua']; ?>" type="text" class="form-control" placeholder="Sem Resultado" style="text-transform: uppercase" readonly>
            </div>
            <div class="col col-4">
                Número:<input value="<?php echo $usuario['numero']; ?>" type="text" class="form-control" placeholder="Sem Resultado" style="text-transform: uppercase" readonly>
            </div>
            <div class="col col-6">
                Bairro:<input value="<?php echo $usuario['bairro']; ?>" type="text" class="form-control" placeholder="Sem Resultado" style="text-transform: uppercase" readonly>
            </div>
            <div class="col col-6">
                Cidade:<input value="<?php echo $usuario['cidade']; ?>" type="text" class="form-control" placeholder="Sem Resultado" style="text-transform: uppercase" readonly>
            </div>
            <div class="col col-1">
                UF:<input value="<?php echo $usuario['uf']; ?>" type="text" class="form-control" placeholder="Sem Resultado" style="text-transform: uppercase" readonly>
            </div>
            <div class="col col-2">
                CEP:<input value="<?php echo $usuario['cep']; ?>" type="text" class="form-control" placeholder="Sem Resultado" style="text-transform: uppercase" readonly>
            </div>
            <div class="col col-3">
                CPF:<input value="<?php echo $usuario['cpf']; ?>" type="text" class="form-control" placeholder="Sem Resultado" style="text-transform: uppercase" readonly>
            </div>
            <div class="col col-2">
                Data Nasc.:<input value="<?php echo $usuario['nacimento']; ?>" type="text" class="form-control" placeholder="Sem Resultado" style="text-transform: uppercase" readonly>
            </div>
            <div class="col col">
                Data Cadastro:<input value="<?php echo $usuario['data']; ?>" id="age" type="text" class="form-control" placeholder="Sem Resultado" style="text-transform: uppercase" readonly>
            </div>
            <div class="col col-12">
                Observações:<textarea id="obs" onfocus="aoClicarOb()" onblur="aoSairOb()" class="form-control" name="obs" rows="1" data-length="120" placeholder="Observações" style="text-transform: uppercase" readonly ><?php echo $usuario['obs']; ?></textarea>
            </div>
            <p class="col col-12" ></p>
            <div class="col" >
                <a href="editar.pne.php?id=<?php echo $usuario['id']; ?>" class="btn btn-primary">Editar</a>
                <a href="imprimir.pne.php?id=<?php echo $usuario['id']; ?>" class="btn btn-primary" target="_blank" >Imprimir</a>
                <a href="../index.php" class="btn btn-primary">Voltar</a>
                <a href="../sair.php" class="btn btn-danger">Sair</a>
            </div>
        </div>
        <img src="../assets/img/perfil.jpg" class="ml-3" alt="...">
</div>
<?php require '../includes/footer.pne.php'; ?>