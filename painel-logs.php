<?php
if (!$_SESSION) {
	session_start();
}
require_once "classes/conexao.php";
require_once "classes/funcionalidades.php";
require_once "header.php";

$funcionalidades = new funcionalidades();
$conn = new conn();

$sms = $conn->read(array("*"), "idCampanha = " . $_GET['idCamp'] ."" , "", "sms", "query");
$sqlWhere = "1=1";
if (isset($_GET['idCampanha'])|| $_GET['idCampanha'] !="") {$sqlWhere .= " AND idCampanha = '" . $_GET['idCampanha'] . "'";}

?>
<div class="container">
<?php if ($_SESSION["login"]["logado"] == "sim") {
	require_once "menu.php";?>

    <!--<h3>The columns titles are merged with the filters inputs thanks to the placeholders attributes</h3>
    <hr>
    <p>Inspired by this <a href="http://bootsnipp.com/snippets/featured/panel-tables-with-filter">snippet</a></p>-->
    <div class="row" style="padding-left: 350px;padding-right: 350px;">
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title">Gerenciador de logs</h3>
            </div>
            <div class="pull-right">
                <a href="painel-relatorios.php" class="btn btn-warning">Voltar </a>
            </div>
            <table class="table">
                <thead>
                    <tr class="filters">
                        <th><input type="text" class="form-control" placeholder="Log" disabled></th>
                    </tr>
                    <th>
                        <a href="logs_excel.php?sqlWhere=<? echo($sqlWhere); ?>" title="Gerar excel com os registros listados" alt="Gerar excel com os registros listados" target="_blank"><img src="img/icon_excel.png" alt="Gerar excel com todos cadastros de newsletter" title="Gerar excel com todos cadastros de newsletter" /></a>
                    </th>
                </thead>
                <tbody>
                     <?php while ($r = $sms->fetch_assoc()) {?>
                        <tr>
                                <td style="text-align: center;">
                                    <?php if($r['status']==1){echo "ENVIADO";}else if($r['status']==3){echo "RECEBIDO";};?><br>
                                    <?php echo $r['CelularCliente'].",".$funcionalidades->ChecaVariavel($r['dtEnvio'],"data2");?><br>
                                    <?php echo $r['mensagem'];?>
                                </td>
                        </tr>
                     <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php } else {
	header("location:index.php");
}
require_once "footer.php";?>