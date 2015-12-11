<?php

include_once "classes/conexao.php";
include_once "classes/funcionalidades.php";
$conn = new conn();
function token() {
	$tamanho = 6;
	$maiusculas = true;
	$numeros = true;
	$simbolos = false;
	// Caracteres de cada tipo
	$lmai = 'ABCDEFGHIJKLMNPQRSTUVWXYZ';
	$num = '1234567890';
	$simb = '!@#$%*-';
	// Variaveis internas
	$retorno = '';
	$caracteres = '';
	// Agrupamos todos os caracteres que poderão ser utilizados
	if ($maiusculas) {
		$caracteres .= $lmai;
	}

	if ($numeros) {
		$caracteres .= $num;
	}

	if ($simbolos) {
		$caracteres .= $simb;
	}

	// Calculamos o total de caracteres possíveis
	$len = strlen($caracteres);
	for ($n = 1; $n <= $tamanho; $n++) {
		// Criamos um número aleatório de 1 até $len para pegar um dos caracteres
		$rand = mt_rand(1, $len);
		// Concatenamos um dos caracteres na variável $retorno
		$retorno .= $caracteres[$rand - 1];
	}
	return $retorno;
}
function converteComandosTxt($txt, $campanha, $dtvalidade) {
	//altera variaveis
	$conn = new conn();
	$codigo = token();
	$conn->insert(array('dtCad' => date("Y-m-d"),
		'campanha' => $campanha,
		'codigo_cupom' => $codigo,
		'dtvalidade' => $dtvalidade,
		'usuario_acao' => $_SESSION["login"]["usuario"],
		'status' => 0,
	), "", "cupom");
	$txt = str_replace("&CODE&", $codigo, $txt);
	return $txt;
}
if ($_GET['receiver'] && $_GET['sender'] && $_GET['when'] && $_GET['text']) {
	$chave = $conn->read(array("idSms", "palavra_chave", "campanha"), "status = 1 AND qtdCupons > 0", "", "campanha_sms", "query");
	while ($palavra_chave = $chave->fetch_assoc()) {
		$campanha = $palavra_chave['idSms'];

		$txtMaiusculo = strtoupper($_GET['text']);
		$txtPMaiusculo = ucfirst($_GET['text']);
		$txtMinusculo = strtolower($_GET['text']);
		if ((preg_match('/^' . $palavra_chave['palavra_chave'] . '/', $txtMaiusculo, $matches, PREG_OFFSET_CAPTURE)) || (preg_match('/^' . $palavra_chave['palavra_chave'] . '/', $txtMinusculo, $matches, PREG_OFFSET_CAPTURE)) || (preg_match('/^' . $palavra_chave['palavra_chave'] . '/', $txtPMaiusculo, $matches, PREG_OFFSET_CAPTURE))) {
			$dados = $conn->read(array("*"), "idSms = '" . $palavra_chave['idSms'] . "' AND status = 1", "", "campanha_sms", "fetch");
			$celular = $conn->read(array("*"), "CelularCliente = '" . $_GET['sender'] . "' AND idCampanha = ".$palavra_chave['idSms']." AND status != 4", "msgFim_enviado ASC ", "sms", "fetch");
			if (count($celular) != 0) {
				$mensagem = $dados['mensagem_encerrado'];
				$msgFim_enviado = 1;
			} else {
				$msgFim_enviado = 0;
				$time_inicial = (date("Y-m-d"));
				$time_final = ($dados['dt_limiteCupom']);
				$diferenca = strtotime($time_final) - strtotime($time_inicial);
				$dias = floor($diferenca / (60 * 60 * 24) * (-1));
				$dtvalidade = date('Y-m-d', strtotime("+" . $dias . " days", strtotime(date("Y-m-d"))));
				$conn->insert(array('dtCad' => date("Y-m-d"),
					'idCampanha' => $palavra_chave['idSms'],
					'CelularCliente' => $_GET['sender'],
					'dtEnvio' => $_GET['when'],
					'mensagem' => $_GET['text'],
					'status' => 1,
				), "", "sms");

				$mensagem = converteComandosTxt($dados["mensagem"], $campanha, $dtvalidade);

			}
			echo $mensagem ;
		//exit("dadafrg ".$msgFim_enviado);
			if($msgFim_enviado < 1 ){
				$usuario = 'montnet';
				$senha = 'Qym56fMu';

				$celulares = explode(";", $_POST['celular']);

				$url = "http://api.infobip.com/api/v3/sendsms/xml";

				$xmlString = "
					   <SMS>
					     <authentification>
					    <username>" . $usuario . "</username>
					    <password>" . $senha . "</password>
					     </authentification>
					     <message>
					    <sender>" . $dados["campanha"] . "</sender>
					    <text>" . $mensagem . "</text>
					    <flash></flash>
					    <type></type>
					    <wapurl></wapurl>
					    <binary></binary>
					    <datacoding></datacoding>
					    <esmclass></esmclass>
					    <srcton></srcton>
					    <srcnpi></srcnpi>
					    <destton></destton>
					    <destnpi></destnpi>
					    <ValidityPeriod></ValidityPeriod>
					     </message>
					     <recipients>
					     <gsm>" . $_GET['sender'] . "</gsm>
					    </recipients>
					   </SMS>  ";
				$fields = "XML=" . urlencode($xmlString);

				//  in this example, POST request was made using PHP's CURL
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

				//  response of the POST request
				$response = curl_exec($ch);
				curl_close($ch);
				$cupons_qtd = $palavra_chave['qtdCupons'] - 1;
				$dados = $conn->update(array("qtdCupons" => $cupons_qtd), "idSms = '" . $palavra_chave['idSms'] . "'", "", "campanha_sms");
				$conn->insert(array('dtCad' => date("Y-m-d"),
						'idCampanha' => $palavra_chave['idSms'],
						'CelularCliente' => $_GET['sender'],
						'dtEnvio' => $_GET['when'],
						'mensagem' => $mensagem,
						'status' => 3,
						'msgFim_enviado' => $msgFim_enviado,
					), "", "sms");
			}
		}
		if (preg_match('/^SAIR/', $txt, $matches, PREG_OFFSET_CAPTURE) || preg_match('/^PARAR/', $txt, $matches, PREG_OFFSET_CAPTURE)) {
			$dados = $conn->delete("CelularCliente = '" . $_GET['sender'] . "'", "", "sms");

		}
	}

}
