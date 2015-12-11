<?php
include_once "classes/conexao.php";
include_once "classes/funcionalidades.php";
include_once "classes/login.php";
include_once "classes/sms.php";
include_once "classes/cliente.php";

$logar = new login();
if ($_GET['action'] == "logar") {
	$logar->dados($_POST['usuario'], $_POST['senha'], $_POST['cpf'], "");
} else if ($_GET['action'] == "logoff") {
	$logar->logoff();
} else if ($_GET['action'] == "cadastrar_usuario") {
	$cliente = new novo_cliente();
	$cliente->dados("", "", $_POST['idUsuario'], $_POST['idSenha'], $_POST['cpf'], $_POST['validador'], date("Y-m-d H:i:s"), $_POST['status']);
} else if ($_GET['action'] == "editar") {
	$cliente = new novo_cliente();
	$cliente->dados("alterar", $_POST['idCliente'], $_POST['idUsuario'], $_POST['idSenha'], $_POST['cpf'], $_POST['validador'], date("Y-m-d H:i:s"), $_POST['status']);
} else if ($_GET['action'] == "sms" && !$_POST['idSms']) {
	$gerenciamento = new sms_novo();
	$gerenciamento->dados($_POST['mensagem_encerrado'],$_POST['dt_limiteCupom'],$_POST['palavras_chaves'], $_POST['nome_camp'], $_POST['descricao_camp'], $_POST['validadeDe_camp'], $_POST['validadeAte_camp'], $_POST['contato_camp'], $_POST['patrocinador_camp'], $_POST['qtd_cupons_camp'], $_POST['mensagem_camp'], date("Y-m-d H:i:s"), "", 0);
} else if ($_GET['action'] == "sms" && $_POST['idSms']) {
	$gerenciamento = new sms_novo();
	$gerenciamento->dados($_POST['mensagem_encerrado'],$_POST['dt_limiteCupom'],$_POST['palavras_chaves'], $_POST['nome_camp'], $_POST['descricao_camp'], $_POST['validadeDe_camp'], $_POST['validadeAte_camp'], $_POST['contato_camp'], $_POST['patrocinador_camp'], $_POST['qtd_cupons_camp'], $_POST['mensagem_camp'], date("Y-m-d H:i:s"), "atualizar", $_POST['idSms']);
} else {
	exit("erro");
}