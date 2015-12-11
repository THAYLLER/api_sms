<?php
/**
 *@author Thayller Vilela Cintra
 *@link http://pxwstudio.com.br/fazendaDiamantina/
 *@package funcionalidades
 */
//namespace funcoes\funcionalidades;

class funcionalidades {
	public function ChecaVariavel($conteudo = '', $tipo = "padrao", $qt = 0) {
		if ($qt) {
			$conteudo = left($conteudo, $qt);
		}
		//limita qt de caracteres
		//$conteudo = utf8_encode($conteudo); //coloca no formato UTF-8
		$conteudo = trim($conteudo); //Retira espaço no ínicio e final da string
		if ($tipo == 'inverte') {
			$conteudo = stripslashes($conteudo);
		} else {
			//funcao nao esta ativada
			if (!get_magic_quotes_gpc()) {
				$conteudo = addslashes($conteudo);
			}
			//Retorna a string com escapes (\)
		}
		if ($tipo != "texto") {
			$conteudo = strip_tags($conteudo);
		}
		//Retira as tags HTML e PHP de uma string
		if ($tipo == "padrao") {
		} elseif ($tipo == "decimal") {
			if ($conteudo != '0.00') {
				$conteudo = strtr($conteudo, ",", ".");
				$conteudo = strtr($conteudo, ".", "");
			}
		} elseif ($tipo == "numero") {
			if ($conteudo != "") {
				$conteudo = intval($conteudo);
			}

		} elseif ($tipo == "data") {
			$conteudo = $this->cData2($conteudo);
			// coloca pontos e traços no CPF
		} elseif ($tipo == "data2") {
			$conteudo = $this->cData3($conteudo);
			// coloca pontos e traços no CPF
		} elseif ($tipo == "cpf") {
			$conteudo = left($conteudo, 3) . "." . substr($conteudo, 3, 3) . "." . substr($conteudo, 6, 3) . "-" . right($conteudo, 2);
		} elseif ($tipo == "email") {
			//testa email
			if (eregi("([\._0-9A-Za-z-]+)@([0-9A-Za-z-]+)(\.[0-9A-Za-z\.]+)", $email, $match)) {
				$conteudo = 1;
			}

		} elseif ($tipo == "digitos") {
			$conteudo = str_replace(",", "", $conteudo);
			$conteudo = str_replace(".", "", $conteudo);
			$conteudo = str_replace("_", "", $conteudo); //retira caractere - (traços)
			$conteudo = str_replace("-", "", $conteudo); //retira caractere - (traços)
			$conteudo = str_replace("(", "", $conteudo); //retira abre parenteses
			$conteudo = str_replace(")", "", $conteudo); //retira fecha parenteses
			$conteudo = str_replace(" ", "", $conteudo); //retira espaços
		} elseif ($tipo == "telefone") {
			$conteudo = str_replace("_", "", $conteudo); //retira caractere - (traços)
			$conteudo = str_replace("-", "", $conteudo); //retira caractere - (traços)
			$conteudo = str_replace("(", "", $conteudo); //retira abre parenteses
			$conteudo = str_replace(")", "", $conteudo); //retira fecha parenteses
			$conteudo = str_replace(" ", "", $conteudo); //retira espaços
		}
		return $conteudo;
	}
	public function cData1($strData) {
		if (preg_match("#-#", $strData) == 1) {
			$strData = implode('/', array_reverse(explode('-', $strData)));
		}
		return $strData;
	}
	// recebe a data no formato aaaa-mm-dd e converte a para dd/mm/aaaa
	public function cData2($strData) {
		if (preg_match("#/#", $strData) == 1) {
			$strData = implode('-', array_reverse(explode('/', $strData)));
		}
		return $strData;
	}
	function cData3($data) {
		if (count(explode("/", $data)) > 1) {
			return implode("-", array_reverse(explode("/", $data)));
		} elseif (count(explode("-", $data)) > 1) {
			return implode("/", array_reverse(explode("-", $data)));
		}
	}
	// recebe dataHora no formato do banco de dados mysql e converte no formato normal
	public function cDataHora1($strData) {
		if (preg_match("#-#", $strData) == 1) {
			$strData2 = implode('/', array_reverse(explode('-', left($strData, 10))));
			$strData = $strData2 . right($strData, 9);
		}
		return $strData;
	}
	// converte data e hora em formato para o banco de dados mysql
	public function cDataHora2($strData) {
		if (preg_match("#/#", $strData) == 1) {
			$strData2 = implode('-', array_reverse(explode('/', left($strData, 10))));
			$strData = $strData2 . right($strData, 9);
		}
		return $strData;
	}
	/*
ÍÎÌÏĪ = I
	*/
	function removeAcentos($str) {
	    $from  = "áàãâäéêèëēėíîìïīóõôòöōúüùûūçÁÀÃÂÄÉÊÈËĒĖÍÎÌÏĪÓÕÔÒÖŌÚÜÙÛŪÇ";
	    $to      = "aaaaaeeeeeeiiiiioooooouuuuucAAAAAEEEEEEIIIIIOOOOOOUUUUUC";
	    $keys = array();	
	    $values = array();
	    preg_match_all('/./u', $from, $keys);
	    preg_match_all('/./u', $to, $values);
	    $mapping = array_combine($keys[0], $values[0]);
	    return strtr($str, $mapping);
	}
	public function fdecimal($conteudo = '', $qt = 2, $tp = 1) {
		if (!$conteudo) {
			$conteudo = 0;
		}

		if ($tp == 1) {
			$conteudo = number_format($conteudo, $qt, ',', '.');
		} elseif ($tp == 3) {
			$conteudo = number_format($conteudo, $qt, '.', '');
		} elseif ($tp == 4) {
			//retira pontos e virgulas, deixa somente números
			$conteudo = number_format($conteudo, $qt, '', '');
		} else {
			$conteudo = left($conteudo, strlen($conteudo) - $qt) . "," . right($conteudo, $qt);
		}
		return $conteudo;
	}
	//função para mostrar msg calculando o prazo de entrega
	public function mostraPrazoEntrega($prazoEntrega = '') {
		if ($prazoEntrega) {
			if ($prazoEntrega >= 4) {
				$prazoEntregaDe = $prazoEntrega - 2;
			} elseif ($prazoEntrega >= 2) {
				$prazoEntregaDe = $prazoEntrega - 1;
			} else {
				$prazoEntregaDe = $prazoEntrega;
			}
			$prazoEntregaAte = $prazoEntrega + 1;
			return "de " . $prazoEntregaDe . " até " . $prazoEntregaAte . " dias úteis";
		}
	}
	public function enviaEmail($texto = '', $titulo = 'Notificação', $emailTo = '', $emailReply = '') {
		/**
		 *@param texto que será enviado por email, tipo, para quem será enviado e se tem que repetir o envio
		 *@return não tem retorno
		 */
		if ($emailTo && $texto) {
			$corpo = '
			<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
			<html>
				<head>
					<title>Notificação por e-mail - ' . $_SESSION["config"]["nome_loja"] . '</title>
					<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
					<style type="text/css">
					* { color:black; }
					body { font-size:12px; font-family:Tahoma,Arial; }
					a { text-decoration:none; font-weight:bold; }
					a:hover { text-decoration:underline; }
					.geral { width:100%; margin:0; padding:0; border:0; }
					.titulo { height:40px; font-size:16px; font-weight:bold; background:#E0E0E0; }
					.rodape { height:15px; background:#E0E0E0; }
					.main { margin:20px 40px; }
					h1 { font-size:18px; }
					h2 { font-size:14px; }
					h3 { font-size:12px; }
					p { margin:10px 0; font-size:12px; }
					</style>
				</head>
				<body>
					<table style="display:table;" width="600" height="119" border="0" align="center" cellpadding="0" cellspacing="0" id="Table_01">
					  <tr>
						<td height="119">
							<a href="' . $_SESSION["config"]["url_site"] . '" target="_blank"><img src="' . $_SESSION["config"]["url_site"] . 'uploads/layout/' . $_SESSION["layout"]["logoBranco"] . '" alt="' . $_SESSION["config"]["nome_loja"] . '" style="display:block;" width="250" height="97" border="0"></a>
						</td>
					  </tr>
					</table>
					<table style="display:table;" width="600" height="37" border="0" align="center" cellpadding="0" cellspacing="0" id="Table_01">
					  <tr>';
			$corpo .= '</tr>
					</table>
					<table style="display:table;" width="600" border="0" align="center" cellpadding="0" cellspacing="0" id="Table_01">
					  <tr>
						<td>
							<br />
							<h1>' . $titulo . '</h1>
							' . $texto . '
							<br /><br />
						</td>
					  </tr>
					</table>
					<table style="display:table;" width="600" height="113" border="0" align="center" cellpadding="0" cellspacing="0" id="Table_01">
					  <tr>
						<td height="19"><hr width="100%" size="1" /></td>
					  </tr>
					  <tr>
						<td width="176" valign="top"><table style="display:table;" width="135" height="68" border="0" align="center" cellpadding="0" cellspacing="4" id="Table_01">
							<tr>
							  <td height="19" colspan="3"><font color="#666666" size="2" face="Arial, Helvetica, sans-serif">Redes Sociais</font></td>
							</tr>
							<tr valign="top">
							  <td height="49">';
			if ($_SESSION["config"]["linkFacebook"]) {
				$corpo .= '<a href="' . $_SESSION["config"]["linkFacebook"] . '" target="_blank"><img src="' . $_SESSION["config"]["url_site"] . 'img/iconFace.jpg" alt="Curta Nossa P&aacute;gina" width="45" height="45" border="0"></a>';
			}

			if ($_SESSION["config"]["linkTwitter"]) {
				$corpo .= '<a href="' . $_SESSION["config"]["linkTwitter"] . '" target="_blank"><img src="' . $_SESSION["config"]["url_site"] . 'img/iconTw.jpg" alt="Siga-nos" width="45" height="45" border="0"></a>';
			}

			if ($_SESSION["config"]["linkGooglePlus"]) {
				$corpo .= '<a href="' . $_SESSION["config"]["linkGooglePlus"] . '" target="_blank"><img src="' . $_SESSION["config"]["url_site"] . 'img/iconG+.png" alt="Nossa P&aacute;gina no Google+" width="45" height="45" border="0"></a>';
			}

			$corpo .= '</td>
							</tr>
						  </table></td>
					  </tr>
					  <tr>
						<td height="19">
							<hr width="100%" size="1" />
							<h2>Possui alguma dúvida?</h2>';
			if ($_SESSION["config"]["sac_horaAtend"]) {
				$corpo .= '<p><b>Horários de atendimento ao cliente:</b>
									<br />' . $_SESSION["config"]["sac_horaAtend"] . '</p>';
			}
			$corpo .= '<p><b>Escolha abaixo a forma de contato desejada:</b>';
			if ($_SESSION["config"]["codigo_chat"]) {
				$corpo .= '<br /><b>On-line: </b>Acesse o Chat para falar com um dos nossos atendentes';
			}

			if ($_SESSION["config"]["fone_sac"] || $_SESSION["config"]["sac_maistelefones"]) {
				$corpo .= '<br /><b>Telefones: </b>' . $_SESSION["config"]["fone_sac"] . ' - ' . $_SESSION["config"]["sac_maistelefones"] . '';
			}

			if ($_SESSION["config"]["fone_whatsapp"]) {
				$corpo .= '<br />Atendimento via <b>WhatsApp: ' . $_SESSION["config"]["fone_whatsapp"] . '</b><img src="' . $_SESSION["config"]["url_site"] . 'img/iconZap.png" width="16" />';
			}

			$corpo .= '<br /><b>E-mail: </b><a href="mailto:' . $_SESSION["config"]["email_sac"] . '" target="_blank">' . $_SESSION["config"]["email_sac"] . '</a>';
			$corpo .= '</p>
							<p>
								<b>' . $_SESSION["config"]["razaoLoja"] . '</b> - ';
			if ($_SESSION["config"]["cnpjLoja"]) {
				$corpo .= 'CNPJ: ' . $_SESSION["config"]["cnpjLoja"] . '<br />';
			}

			if ($_SESSION["config"]["enderecoLoja"]) {
				$corpo .= $_SESSION["config"]["enderecoLoja"] . ', ' . $_SESSION["config"]["bairroLoja"] . ' - CEP: ' . $_SESSION["config"]["cepLoja"] . ', <b>' . $_SESSION["config"]["cidadeLoja"] . '</b>';
			}

			$corpo .= '</p>
							<hr width="100%" size="1" />
						</td>
					  </tr>
					</table>
				</body>
			</html>';

			// pega emailTo especial
			switch ($emailTo) {
				case 'adm':$emailTo = $_SESSION["config"]["email_sac"];
					break;case 'tec':$emailTo = $_SESSION["config"]["email_tec"];}
			$headers = "MIME-Version: 1.1\nContent-type: text/html; charset=iso-8859-1\nFrom: SAC - " . $_SESSION["config"]["nome_loja"] . " <" . $_SESSION["config"]["email_sac"] . ">\nReturn-Path: SAC - " . $_SESSION["config"]["nome_loja"] . " <" . $_SESSION["config"]["email_dispara"] . ">";
			if ($emailReply) {
				$headers .= '\nReply-To: $emailReply';
			} else {
				$headers .= '\nReply-To: ' . $_SESSION["config"]["email_sac"];
			}

			return mail($emailTo, $titulo . " - Loja " . $_SESSION["config"]["nome_loja"], $corpo, $headers, "-r" . $_SESSION["config"]["email_dispara"]);
		}
	}
}