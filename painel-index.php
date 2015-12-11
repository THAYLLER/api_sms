<?php
if (!$_SESSION) {
	session_start();
}
require_once "classes/conexao.php";
require_once "classes/funcionalidades.php";
require_once "header.php";

$funcionalidades = new funcionalidades();
$conn = new conn();
/*
$sqlWhere = " WHERE 1=1";
if ($dataB!="") { $sqlWhere .= " AND b.data LIKE '%".cData2($dataB)."%'"; }
if ($tipoB!="") { $sqlWhere .= " AND b.tipo='".$tipoB."'"; }
if ($nomeB!="") { $sqlWhere .= " AND b.nome LIKE '%".$nomeB."%'"; }
if ($statusB!="" || $statusB=="0") { $sqlWhere .= " AND b.status='".$statusB."'"; }
 */
$produtos = $conn->read(array("*"), "", "status ASC", "campanha_sms", "query");?>
<div class="container">
<?php if ($_SESSION["login"]["logado"] == "sim") {
	require_once "menu.php";?>

    <!--<h3>The columns titles are merged with the filters inputs thanks to the placeholders attributes</h3>
    <hr>
    <p>Inspired by this <a href="http://bootsnipp.com/snippets/featured/panel-tables-with-filter">snippet</a></p>-->
    <div class="row">
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title">Gerenciador de cupons</h3>
            </div>
            <div class="pull-right"style="padding-right: 35%;">
                <a href="painel-relatorios.php" class="btn btn-success">Relatório</a>
                <a href="informacoes_basicas.php" class="btn btn-warning">Criar novo cupom</a>
                <a href="painel-usuarios.php" class="btn btn-info">Lista de usuários</a>
            </div>
            <table class="table">
                <thead>
                	<!--<tr class="filters">
                        <th><input type="text" class="form-control" placeholder="Status" ></th>
                        <th><input type="text" class="form-control" placeholder="Data de cadastro" ></th>
                        <th><input type="text" class="form-control" placeholder="Camanha" ></th>
                        <th><input type="text" class="form-control" placeholder="Validade" ></th>
                        <th><input type="text" class="form-control" placeholder="Palavra(s)" ></th>
                        <th><input type="text" class="form-control" placeholder="Assinantes ativos" ></th>
                        <th><span class='btn btn-default glyphicon glyphicon-search'> Buscar</span></th>
                        <th></th>
                    </tr>-->
                    <tr class="filters">
                        <th><input type="text" class="form-control" placeholder="Status" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Data de cadastro" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Campanha" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Keyword" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Opções" disabled></th>
                    </tr>
                </thead>
                <tbody>
                     <?php while ($r = $produtos->fetch_assoc()) {
		?>
                          <tr>
                                <td><?php if ($r['status'] == 1) {?><p class="success" style="background-color: #459B45;text-align: center;color: white;">Ativo</p><?php } else {?><p class="warning" style="background-color: #FE3A2B;text-align: center;color: white;">Inativo</p><?php }
		?></td>
                                <td><?php echo $r['dtCad'];?></td>
                                <td><?php echo $r['campanha'];?></td>
                                <td><?php echo $r['palavra_chave'];?></td>
                                <td>
                                    <input type="hidden" name="idSms" id="idSms" value="<?php echo $r['idSms'];?>">
                                    <a href="javascript:cancelar(<?php echo $r['idSms'];?>);" id="cancelar_cupom" style="padding-left: 15px;"><img src="img/excluir.png" alt="excluir"></a>
                                    <a href="informacoes_basicas.php?idC=<?php echo $r['idSms'];?>&acao=editar" style="padding-left: 15px;"><img src="img/editar.png" alt="editar"></a>
                                    <a href="painel-sms.php?idCamp=<?php echo $r['idSms'];?>" style="padding-left: 15px;"><img src="img/ver.png" alt="visualizar"></a>
                                </td>
                        </tr>
                     <?php }
	?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php } else {
	header("location:index.php");
}
require_once "footer.php";?>