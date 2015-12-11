<?php
	$usuario = 'montnet';
	$senha 	= 'Qym56fMu';

	$url = "http://api.infobip.com/api/v3/sendsms/xml";
	
$header[] = "
Host: api.infobip.com
Content-Type: application/xml
Accept: */*";

$xml = "
<SMS>
	<authentication>
		<username>".$usuario."</username>
		<password>".$senha."</password>
	</authentication>
	<message>
		<sender>Infobip</sender>
		<text>Hello</text>
		<recipients>
			<gsm>5516992924139</gsm>
			<gsm>5516992924139</gsm>
			<gsm>5516992924139</gsm>
		</recipients>
	</message>
</SMS>
";
$ch = curl_init();
// Seta opçoes e parâmetro
$options = array(CURLOPT_URL => $url,
				 CURLOPT_HTTPHEADER => $header,
				 CURLOPT_SSL_VERIFYPEER => false,
				 CURLOPT_POST => true,
				 CURLOPT_POSTFIELDS => utf8_encode($xml),
				 CURLOPT_RETURNTRANSFER => true
				);

curl_setopt_array($ch, $options);

// Executa cURL
$response = curl_exec($ch);
print_r($response);

// Fecha conexao cURL
curl_close($ch);

// Transforma string em elemento XML
$responseXml = simplexml_load_string($response);
exit("status: ".$responseXml->Resposta->Status);
