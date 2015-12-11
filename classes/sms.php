<?php

class sms_novo {
	protected $descricao;
	protected $valiadeDe;
	protected $validadeAte;
	protected $contato;
	protected $patrocinador;
	protected $qtd;
	protected $msg;
	protected $data;
	protected $idSms;
	protected $dt_limiteCupom;
	public function dados($mensagem_encerrado, $dt_limiteCupom, $palavras_chaves, $nome, $descricao, $valiadeDe, $validadeAte, $contato, $patrocinador, $qtd, $msg, $data, $op, $idSms = 0) {

		$this->descricao = $descricao;
		$this->valiadeDe = $valiadeDe;
		$this->validadeAte = $validadeAte;
		$this->contato = $contato;
		$this->patrocinador = $patrocinador;
		$this->qtd = $qtd;
		$this->msg = $msg;
		$this->nome = $nome;
		$this->palavras_chaves = $palavras_chaves;
		$this->data = $data;
		$this->idSms = $idSms;
		$this->dt_limiteCupom = $dt_limiteCupom;
		$this->mensagem_encerrado = $mensagem_encerrado;
		if ($op == "atualizar") {
			$this->sms_update();
		} else {
			$this->sms();
		}

	}
	public function sms() {
		$funcionalidades = new funcionalidades();
		$conn = new conn();
		$conn->insert(array('dtCad' => $this->data,
			'campanha' => utf8_encode($this->nome),
			'palavra_chave' => $this->palavras_chaves,
			'descricao' => $this->descricao,
			'validadeIni' => $funcionalidades->ChecaVariavel($this->valiadeDe, "data"),
			'validadeFim' => $funcionalidades->ChecaVariavel($this->validadeAte, "data"),
			'patrocinador' => $this->patrocinador,
			'qtdCupons' => $this->qtd,
			'contato' => $this->contato,
			'mensagem' => $funcionalidades->removeAcentos($this->msg),
			'dt_limiteCupom' => $funcionalidades->ChecaVariavel($this->dt_limiteCupom, "data"),
			'mensagem_encerrado' => $funcionalidades->removeAcentos($this->mensagem_encerrado),
			'status' => 1,
		), "", "campanha_sms");
		exit("<script>alert('Campanha cadastrada com sucesso!');document.location.href='painel-index.php';</script>");
	}
	public function sms_update() {
		$conn = new conn();
		$funcionalidades = new funcionalidades();
		$conn->update(array(
			'campanha' => ($funcionalidades->removeAcentos($this->nome)),
			'palavra_chave' => $this->palavras_chaves,
			'descricao' => $this->descricao,
			'validadeIni' => $funcionalidades->ChecaVariavel($this->valiadeDe, "data"),
			'validadeFim' => $funcionalidades->ChecaVariavel($this->validadeAte, "data"),
			'patrocinador' => $this->patrocinador,
			'qtdCupons' => $this->qtd,
			'dt_limiteCupom' => $funcionalidades->ChecaVariavel($this->dt_limiteCupom, "data"),
			'mensagem_encerrado' => $funcionalidades->removeAcentos($this->mensagem_encerrado),
			'contato' => $this->contato,
			'mensagem' => $funcionalidades->removeAcentos(($this->msg)),
			'status' => 1,
		), "idSms = " . $this->idSms . "", "campanha_sms");
		exit("<script>alert('Campanha atualizado com sucesso!');document.location.href='painel-index.php';</script>");
	}
}