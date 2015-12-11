<?
require_once "classes/conexao.php";
require_once "classes/funcionalidades.php";

if ($_SESSION["login"]["logado"] == "sim") {
$sqlWhere = isset($_GET["sqlWhere"])?stripslashes($_GET["sqlWhere"]):"";

$funcionalidades = new funcionalidades();
$conn = new conn();
if (($_GET["acao"])=='gerar') {
	header("Content-type: application/vnd.ms-excel");
	header("Content-type: application/force-download");
	header("Content-Disposition: attachment; filename=relatorios.xls");
	header("Pragma: no-cache");
} else { ?>
	<style type="text/css">
	a { text-decoration:none; }
	#botao { display:block; font-family:Arial; cursor:pointer; font-size:14px; font-weight:bold; text-align:center; border-radius:10px; border:1px solid black; margin:10px auto ; width:150px; line-height:25px; height:25px; background-color:#cccccc; color:#000000; }
	#botao:hover { border-color:#ebebeb; color:white; }
	</style>
	<a href="?acao=gerar&sqlWhere=<? echo(($sqlWhere)); ?>&sqlOrder=<? echo(($sqlOrder)); ?>"><div id="botao">Gerar Excel</div></a>
<? }

$query = $conn->read(array("*"),"$sqlWhere", "", "sms", "query");
if ($query->num_rows) {
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr> 
		<td><b>Status</b></td>
		<td><b>Data de envio</b></td>
		<td><b>Celular do cliente</b></td>
		<td><b>Mensagem </b></td>
	</tr>
	<? while ($r=$query->fetch_object()) {?>
		<tr>
			<td><?php if($r->status==1){echo "ENVIADO";}else if($r->status==3){echo "RECEBIDO";}?></td>
			<td><?php echo $r->dtEnvio;?></td>
			<td><?php echo $r->CelularCliente;?></td>
			<td><?php echo $r->mensagem?></td>
		</tr>
	<?} ?>
</table>
<?
}
} else {
	header("location:index.php");
}
?>
