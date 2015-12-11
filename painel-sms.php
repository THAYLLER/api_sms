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
$r = $conn->read(array("campanha"), "idSms = ".$_GET['idCamp']."", "status DESC", "campanha_sms", "fetch");
$sms = $conn->read(array("*"), "idCampanha = ".$_GET['idCamp']."", "status DESC", "sms", "query");
?>
<div class="container">
<?php if ($_SESSION["login"]["logado"] == "sim") {
	require_once "menu.php";?>

    <!--<h3>The columns titles are merged with the filters inputs thanks to the placeholders attributes</h3>
    <hr>
    <p>Inspired by this <a href="http://bootsnipp.com/snippets/featured/panel-tables-with-filter">snippet</a></p>-->
    <div class="row">
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title"><?echo $r['campanha'];?></h3>
            </div>
            <div class="pull-right">
                <a href="painel-index.php" class="btn btn-warning">Voltar </a>
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
                        <th><input type="text" class="form-control" placeholder="Data de envio" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Numero do cliente" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Mensagem" disabled></th>
                    </tr>
                </thead>
                <tbody>
                     <?php while ($r = $sms->fetch_assoc()) {
		$campanha = $conn->read(array("campanha"), "", "", "campanha_sms", "fetch");?>
                          <tr>
                                <td><?php if ($r['status'] == 1) {?><p class="success" style="background-color: #459B45;text-align: center;color: white;">Recebido</p><?php } else if ($r['status'] == 3) {?><p class="warning" style="background-color: #FE3A2B;text-align: center;color: white;">Enviado</p><?php }
		?></td>
                                <td><?php echo $funcionalidades->cDataHora2($r['dtEnvio']);?></td>
                                <td><?php echo $r['CelularCliente'];?></td>
                                <td><?php echo $r['mensagem'];?></td>
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