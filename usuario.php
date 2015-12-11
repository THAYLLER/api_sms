<?php
require_once "header.php";
require_once "menu.php";
if ($_SESSION["login"]["logado"] == "sim") {
} else {
  header("location:index.php");
}

if ($_GET['acao'] == "editar") {
	$usuario = $conn->read(array("*"), "id = '" . $_GET["idUsuaio"] . "'", null, "usuario", "fetch");
}
$acao = isset($_GET['acao']) ? $_GET['acao'] : "cadastrar_usuario";
$txtBotao = isset($_GET['acao']) ? "Alterar" : "Cadastrar";
?>
<form class="form-horizontal" action="controler.php?action=<?echo  $acao;?>" method="POST">
<input type="hidden" name="idCliente" value="<?echo $usuario["id"];?>">
<fieldset>

<!-- Form Name -->
<legend>Cadastro do Usuário</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="idUsuario">Usuário</label>
  <div class="col-md-5">
  <input id="idUsuario" name="idUsuario" type="text" placeholder="Login do usuario" class="form-control input-md" required="" value="<?echo $usuario['usuario'];?>">

  </div>
</div>

<!-- Password input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="idSenha">Senha</label>
  <div class="col-md-5">
    <input id="idSenha" name="idSenha" type="password" placeholder="Digite a senha" class="form-control input-md" value="">

  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="cpf">CPF</label>
  <div class="col-md-5">
    <input id="cpf" name="cpf" type="text" placeholder="Digite a senha" class="form-control input-md" value="<?echo $usuario['cpf'];?>">

  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="validador">Faz validação?</label>
  <div class="col-md-5">
    <select name="validador" class="form-control input-md" required>
          <option value="">Selecione</option>
          <option value="0" <?if($usuario['faz_validacao']==0) echo "SELECTED";?>>Não</option>
           <option value="1" <?if($usuario['faz_validacao']==1)echo "SELECTED"; ?>>Sim</option>
        </select>
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="validador">Status</label>
  <div class="col-md-5">
    <select name="status" class="form-control input-md" required>
          <option value="">Selecione</option>
          <option value="0" <?if($usuario['status']==0) echo "SELECTED";?>>Inativo</option>
           <option value="1" <?if($usuario['status']==1)echo "SELECTED"; ?>>Ativo</option>
        </select>
  </div>
</div>
<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="idConfirmar"></label>
  <div class="col-md-8">
    <button id="idConfirmar" name="idConfirmar" class="btn btn-primary"><?echo  $txtBotao;?></button>
    <a href="painel-usuarios.php" id="idCancelar" name="idCancelar" class="btn btn-danger">Cancelar</a>
  </div>
</div>

</fieldset>
</form>
<? } else {
  header("location:index.php");
}
require_once"footer.php";?>