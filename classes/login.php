<?php
if (!$_SESSION) {
	session_start();
}
/**
 *@author Thayller Vilela Cintra
 *@link http://pxwstudio.com.br/fazendaDiamantina/
 *@package login
 */

class login {
	public $usuario;
	public $senha;
	public $cpf;
	public $path;

	public function dados($usuario = "", $senha = "", $cpf = "", $path) {
		$this->usuario = $usuario;
		$this->senha = $senha;
		$this->cpf = $cpf;
		$this->path = $path;

		$this->tratar_dados();
	}
	private function tratar_dados() {
		$funcoes = new funcionalidades();

		$this->usuario = $funcoes->ChecaVariavel($this->usuario);
		$this->senha = $funcoes->ChecaVariavel($this->senha);
		$this->cpf = $funcoes->ChecaVariavel($this->cpf, "digitos");

		$this->validacao();
	}
	private function validacao() {
		$conn = new conn();

		if ($this->cpf != "" && $this->usuario == "" && $this->senha == "") {
			if($this->cpf == ""){
				exit("<script>alert('Preencha algum dos campos para logar'); document.location='index.php';</script>");
			}else{
				$this->path = $this->path != "" ? $this->path : "painel-validacao.php";
				$where = " cpf = '" . $this->cpf . "' AND faz_validacao = 1 AND status = 1";
			}
		} else {
			if($this->usuario == "" || $this->senha == ""){
				exit("<script>alert('Preencha algum dos campos para logar'); document.location='index.php';</script>");
			}else{
				$this->senha = sha1($this->senha);
				$this->path = $this->path != "" ? $this->path : "painel-index.php";
				$where = " senha = '" . $this->senha . "' AND status = 1";
			}
		}
		$cliente = $conn->read(array("id", "usuario"), $where, null, "usuario", "fetch");

		if ($cliente) {
			$_SESSION["login"] = array();
			$_SESSION["login"]["logado"] = "sim";
			$_SESSION["login"]["id"] = $cliente['id'];
			$_SESSION["login"]["usuario"] = $cliente['usuario'];

			//print_r($_SESSION["login"]["usuario"]);exit();

			if ($_SESSION["pedido_temp"]["usando"]) {
				exit("<script>alert('Login efetuado com sucesso.'); document.location='pedido.php?acao=addProd';</script>");
			}
			exit("<script>alert('Login efetuado com sucesso.'); document.location='" . $this->path . "';</script>");
		} else {
			unset($_SESSION["login"]);
			echo ("<script>alert('Usuário ou senha inválida!'); history.back();</script>");
		}
	}
	function logoff() {
		unset($_SESSION["login"]);
		exit("<script>alert('Saiu do sistema!'); document.location='index.php';</script>");
	}
}