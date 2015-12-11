<?php
require_once "classes/conexao.php";
require_once "classes/funcionalidades.php";

$acao = isset($_POST['acao']) ? $_POST['acao'] : "";
$campanha = isset($_POST['campanha']) ? $_POST['campanha'] : "";
$idSms = isset($_POST['idSms']) ? $_POST['idSms'] : "";
$conn = new conn();

if ($acao == "altera_status") {
	$status = $conn->read(array("status"), "idSms=" . $idSms . " LIMIT 1", "", "campanha_sms", "fetch");
	if ($status['status'] == 1) {
		$atualiza = $conn->update(array('status' => 0), "idSms=" . $idSms . "", "campanha_sms");
		if ($atualiza) {
			exit("ok;");
		} else {
			exit("erro;");
		}
	}

} else if ($acao == "dar_baixa") {

	$conn->update(array("status" => 4,"msgFim_enviado" => 0), "idCampanha = '" . $campanha . "'", "sms");
	$status = $conn->read(array("status"), "campanha='" . $campanha . "'  AND idCupom = " . $_POST["idCupom"] . " LIMIT 1", "", "cupom", "fetch");
	if ($status['status'] == 0) {
		$atualiza = $conn->update(array('status' => 1, 'dtBaixa' => date("Y-m-d"), 'usuario_acao' => $_SESSION["login"]["usuario"]), "campanha='" . $campanha . "' AND idCupom = " . $_POST["idCupom"] . "", "cupom");
		if ($atualiza) {
			exit("ok;");
		} else {
			exit("erro;");
		}
	}

}