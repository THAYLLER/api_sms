<?php
if (!$_SESSION) {
	session_start();
}
require_once "classes/conexao.php";
require_once "classes/funcionalidades.php";
require_once "header.php";

$funcionalidades = new funcionalidades();
$conn = new conn();

$sqlWhere = "1=1";
if (isset($_GET['Keyword']) || $_GET['Keyword'] != "") {$sqlWhere .= " AND palavra_chave LIKE '%" . $_GET['Keyword'] . "%'";}
if (isset($_GET['patrocinador']) || $_GET['patrocinador'] != "") {$sqlWhere .= " AND patrocinador LIKE '%" . $_GET['patrocinador'] . "%'";}
if (isset($_GET['capanha']) || $_GET['capanha'] != "") {$sqlWhere .= " AND idSms = '" . $_GET['capanha'] . "'";}
if (isset($_GET['dtCad']) || $_GET['dtCad'] != "") {$sqlWhere .= " AND dtCad LIKE '%" . $_GET['dtCad'] . "%'";}

$sms = $conn->read(array("*"), "" . $sqlWhere . "", "", "campanha_sms", "query");
$capanha = isset($_GET['capanha']) ? $_GET['capanha'] : "";
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
                <h3 class="panel-title">Gerenciador de relatorios</h3>
            </div>
            <div class="pull-right">
                <a href="painel-index.php" class="btn btn-warning">Voltar </a>
            </div>
            <table class="table">
                <thead>
                 <form action="?" method="get">
                    <tr class="filters">
                        <th><select name="campanha" >
                         <form action="?" method="get">

                            <option value="">SELECIONE</option>
                            <?php
$campanhas = $conn->read(array("idSms", "campanha"), "", "", "campanha_sms", "query");
	while ($r = $campanhas->fetch_assoc()) {?>
                                        <option value="<?php echo $r['idSms'];?>" <?if($capanha == $r['idSms']){echo "SELECTED";}?>><?php echo $r['campanha'];?></option>
                                 <?php }
	?>
                        </select>
                        <button type="subimit">Selecionar</button></th>
                        </form>
                        <th>
                            <a href="relatorios_excel.php?sqlWhere=<? echo($sqlWhere); ?>" title="Gerar excel com os registros listados" alt="Gerar excel com os registros listados" target="_blank"><img src="img/icon_excel.png" alt="Gerar excel com todos cadastros de newsletter" title="Gerar excel com todos cadastros de newsletter" /></a>
                        </th>
                    </tr>
                	<tr class="filters">
                            <form action="?" method="get">
                                <th></th>
                                <th><input type="text" class="form-control" name="Keyword" placeholder="Keyword" ></th>
                                <th><input type="text" class="form-control" name="patrocinador" placeholder="Patrocinador" ></th>
                                <th><input type="text" class="form-control data" name="dtCad" placeholder="Data de cadastro" ></th>
                                <th><button class='btn btn-default glyphicon glyphicon-search'> Buscar</button></th>
                                <th></th>
                            </form>
                    </tr>
                    </form>
                    <tr class="filters">
                        <th><input type="text" class="form-control" placeholder="Status Camanha" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Keyword" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Patrocinador" disabled></th>
                         <th><input type="text" class="form-control" placeholder="Data de cadastro" disabled></th>
                         <th><input type="text" class="form-control" placeholder="Logs da campanha" disabled></th>
                    </tr>
                </thead>
                <tbody>
                     <?php while ($r = $sms->fetch_assoc()) {
		?>
                          <tr>
                                <td><?php if ($r['status'] == 1) {?><p class="success" style="background-color: #459B45;text-align: center;color: white;">Ativo</p><?php } else {?><p class="warning" style="background-color: #FE3A2B;text-align: center;color: white;">Inativo</p><?php }
		?></td>
                                <td><?php echo $r['palavra_chave'];?></td>
                                <td><?php echo $r['patrocinador'];?></td>
                                <td><?php echo $funcionalidades->ChecaVariavel($r['dtCad'], "data2");?></td>
                                <td><a href="painel-logs.php?idCamp=<?php echo $r['idSms'];?>" id="cancelar_cupom"><img style="width: 30px;" src="img/160.png" alt="logs"></a></td>
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