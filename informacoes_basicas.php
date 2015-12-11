<?php
if (!$_SESSION) {
	session_start();
}

require_once "header.php";
require_once "classes/funcionalidades.php";
$funcionalidades = new funcionalidades();

if ($_SESSION["login"]["logado"] == "sim") {
	$_SESSION['idC'] = isset($_GET['idC'])?$_GET['idC']:"";
	$_SESSION['acao'] = isset($_GET['acao'])?$_GET['acao']:"";
	//exit($_SESSION['idC']);
	if ($_SESSION['acao'] == "editar") {
		require_once "classes/conexao.php";

		$conn = new conn();
		 $where = "idSms=".$_SESSION['idC']."";
		$campanha = $conn->read(array("*"), $where, "","campanha_sms", "fetch");

	}
	?>
<div class="container">
	<?php require_once "menu.php";?>
		<form method="post" action="controler.php?action=sms" class="form-horizontal" style="margin-top: 46px;padding-left: 196px;">
			<input type="hidden" name="idSms" value="<?php echo $_GET['idC'];?>">
			<div class="form-group">
			    <label for="nome_camp" class="col-sm-2 control-label">Nome</label>
			    <div class="col-sm-6">
			      <input type="text" class="form-control" id="nome_camp" name="nome_camp" placeholder="Nome da campanha" value="<?php echo $campanha['campanha'];?>">
			    </div>
			</div>
			<div class="form-group">
			    <label for="descricao_camp" class="col-sm-2 control-label" name="descricao" id="descricao">Descri&ccedil;&atilde;o</label>
			    <div class="col-sm-6">
			      <textarea name="descricao_camp"class="form-control" id="descricao_camp"><?php echo $campanha['descricao'];?></textarea>

			    </div>
			</div>
			<div class="form-group validade">
			    <label for="validade_camp" class="col-sm-2 control-label">Validade</label>
			    <div class="col-sm-3">
			      De <input type="text" class="data form-control " id="validadeDe_camp"  name="validadeDe_camp" value="<?=$funcionalidades->ChecaVariavel($campanha['validadeIni'], "data2");?>">
			    </div>
			    <div class="col-sm-3">
			      Para <input type="text" class="form-control data" id="validadeAte_camp"  name="validadeAte_camp" value="<?=$funcionalidades->ChecaVariavel($campanha['validadeFim'], "data2");?>">
			    </div>
			</div>
			<div class="form-group">
			    <label for="contato_camp" class="col-sm-2 control-label">contato</label>
			    <div class="col-sm-6">
			      <input type="text" class="form-control" id="contato_camp" name="contato_camp" placeholder="Informa&ccedil;&otilde;es de contato" value="<?php echo $campanha['contato'];?>">
			    </div>
			</div>
			<div class="form-group">
			    <label for="dt_limiteCupom" class="col-sm-2 control-label">Data limite do cupom do cliente</label>
			    <div class="col-sm-6">
			    	<input type="text" id="dt_limiteCupom" class="form-control data" name="dt_limiteCupom"  value="<?=$funcionalidades->ChecaVariavel($campanha['dt_limiteCupom'], "data2");?>">
			      </div>
			</div>
			<div class="form-group">
			    <label for="patrocinador_camp" class="col-sm-2 control-label">Patrocinador</label>
			    <div class="col-sm-6">
			      <input type="text" class="form-control" id="patrocinador_camp" name="patrocinador_camp" placeholder="Patrocinador" value="<?php echo $campanha['patrocinador'];?>">
			    </div>
			</div>
			<div class="form-group">
			<div class="col-sm-2"></div>
			    <div class="col-sm-3">
			      	<label for="qtd_cupons_camp" class="col-sm-4 control-label">Quantidade</label>
			      	<input type="number" class="form-control" id="qtd_cupons_camp" name="qtd_cupons_camp" placeholder="Quantidade de cupons" value="<?php echo $campanha['qtdCupons'];?>">
			    </div>
			    <div class="col-sm-3">
			    	<label for="palavras_chaves" class="col-sm-2 control-label">KEYWORD</label>
			      	<input type="text" class="form-control" id="palavras_chaves" name="palavras_chaves" placeholder="palavra chave" value="<?php echo $campanha['palavra_chave'];?>">
			    </div>
			</div>
			<div class="form-group">
			    <label for="mensagem_camp" class="col-sm-2 control-label">Mensagem</label>
			    <div class="col-sm-6">
			      <textarea name="mensagem_camp"class="form-control" id="mensagem_camp"><?php echo $campanha['mensagem'];?></textarea>
			      <a class="btn btn-info" href="javascript:$('#mensagem_camp').val($('#mensagem_camp').val()+'&CODE&');">C&oacute;digo do cupom</a>
			    	<span id="resta"></span>
			    </div>
			</div>
			<div class="form-group">
			    <label for="mensagem_camp" class="col-sm-2 control-label">Mensagem duplicada</label>
			    <div class="col-sm-6">
			      <textarea name="mensagem_encerrado"class="form-control" id="mensagem_encerrado"><?php echo $campanha['mensagem_encerrado'];?></textarea>
			   	<span id="resta2"></span>
			    </div>
			</div>
			<div class="form-group">
				<div class="col-sm-3"></div>
				<div class="col-sm-6">
					<a class="btn btn-danger btn-lg" href="painel-index.php">Voltar</a>
					<button class="btn btn-success btn-lg " type="submit">Concluir</button>
				</div>
			</div>
		</form>
</div>
<?php
} else {
	header("location:index.php");
}
require_once "footer.php";?>