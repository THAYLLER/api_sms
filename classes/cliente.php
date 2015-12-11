<?php
if (!$_SESSION) {
	session_start();
}
/**
 *@author Thayller Vilela Cintra
 *@link http://pxwstudio.com.br/fazendaDiamantina/
 *@package cliente
 */
class novo_cliente {

	protected $usuário;
	protected $sexo;

	public function dados($op = "", $idCliente = "", $usuario, $senha = "", $cpf, $validador, $data, $status) {
		$this->usuario = $usuario;
		$this->senha = $senha;
		$this->data = $data;
		$this->op = $op;
		$this->idCliente = $idCliente;
		$this->cpf = $cpf;
		$this->validador = $validador;
		$this->status = $status;
		$this->validacao();
	}
	private function sha_senha($senha) {
		return sha1($senha);
	}
	private function seleciona_senhaAntiga($idCliente) {
		$conn = new conn();
		return $conn->read(array("senha"), "id='" . $idCliente . "' LIMIT 1", "", "usuario", "fetch");

	}
	private function validacao() {
		$funcoes = new funcionalidades();
		$this->usuario = $funcoes->ChecaVariavel($this->usuario, "texto");
		$this->senha = $this->senha == "" ? $this->senha : $this->sha_senha($this->senha);
		$this->data = $this->data;

		$conn = new conn();
		if ($this->op != "alterar") {
			$conn->insert(array('dtCad' => $this->data,
				'dtAlt' => $this->data,
				'dtCad' => $this->data,
				'usuario' => $this->usuario,
				'senha' => $this->senha,
				'cpf' => $this->cpf,
				'faz_validacao	' => $this->validador,
				'status' => $this->status,
			), "", "usuario"
			);

			exit("<script>alert('Seu cadastro foi efetuado com sucesso!');document.location.href='painel-index.php';</script>");
		} else {
			if ($this->senha == "") {
				$conn->update(array('dtAlt' => $this->data,
					'usuario' => $this->usuario,
					'cpf' => $this->cpf,
					'faz_validacao	' => $this->validador,
					'status' => $this->status), "id=" . $this->idCliente . "", "usuario"
				);
			} else {
				$conn->update(array('dtAlt' => $this->data,
					'usuario' => $this->usuario,
					'senha' => $this->senha,
					'cpf' => $this->cpf,
					'faz_validacao	' => $this->validador,
					'status' => $this->status), "id=" . $this->idCliente . "", "usuario"
				);
			}
			exit("<script>alert('Seu cadastro foi alterado com sucesso!');document.location.href='painel-index.php';</script>");
		}
	}
}