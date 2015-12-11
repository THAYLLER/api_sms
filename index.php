<?php
require_once "header.php";
if($_SESSION["login"]["logado"] != "sim"){?>

	<div class="container" style="margin-top: 180px!important;">
	    <div class="row">
			<div class="col-md-4 col-md-offset-4">
	    		<div class="panel panel-default">
				  	<div class="panel-heading">
				    	<h3 class="panel-title">Faça seu login</h3>
				 	</div>
				  	<div class="panel-body">
				    	<form action="controler.php?action=logar" id="frm" method="post">
		                    <fieldset>
					    	  	<div class="form-group">
					    		    <input class="form-control usuario" placeholder="Usuário" name="usuario" data-toggle="popover" type="text">
					    		</div>
					    		<div class="form-group">
					    			<input class="form-control senha" placeholder="Password" name="senha" data-toggle="popover" type="password" value="">
					    		</div>
					    		<p style="text-align: center;">OU</p>
					    		<div class="form-group">
					    			<input class="form-control cpf" placeholder="cpf" name="cpf" type="text" data-toggle="popover" value="">
					    		</div>
					    		<input class="btn btn-lg btn-success btn-block" type="submit" value="Login">
					    	</fieldset>
				      	</form>
				    </div>
				</div>
			</div>
		</div>
	</div>
<?php 
}else{
	exit("<script>document.location='painel-index.php';</script>");
}
require_once"footer.php";?>