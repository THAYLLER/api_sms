<?php
if (!$_SESSION) {
    session_start();
}
  require_once "classes/conexao.php";
  require_once "classes/funcionalidades.php";
require_once"header.php";


    $funcionalidades = new funcionalidades();
    $conn = new conn();
    /*
    $sqlWhere = " WHERE 1=1";
        if ($dataB!="") { $sqlWhere .= " AND b.data LIKE '%".cData2($dataB)."%'"; }
        if ($tipoB!="") { $sqlWhere .= " AND b.tipo='".$tipoB."'"; }
        if ($nomeB!="") { $sqlWhere .= " AND b.nome LIKE '%".$nomeB."%'"; }
        if ($statusB!="" || $statusB=="0") { $sqlWhere .= " AND b.status='".$statusB."'"; }
     */
    $produtos = $conn->read(array("*"),"","status ASC","usuario","query");?>
<div class="container">
<?php if($_SESSION["login"]["logado"] == "sim"){
 require_once"menu.php";?>

    <!--<h3>The columns titles are merged with the filters inputs thanks to the placeholders attributes</h3>
    <hr>
    <p>Inspired by this <a href="http://bootsnipp.com/snippets/featured/panel-tables-with-filter">snippet</a></p>-->
    <div class="row">
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title">Usuários</h3>
            </div>
            <div class="pull-right" style="padding-right: 35%;">
                <a href="painel-index.php" class="btn btn-warning">Voltar </a>
            	<a href="usuario.php" class="btn btn-success">Novo usuário</a>
            </div>
            <table class="table">
                <thead>
                	<!--<tr class="filters">
                        <th><input type="text" class="form-control" placeholder="Status" ></th>
                        <th><input type="text" class="form-control" placeholder="Data de cadastro" ></th>
                        <th><input type="text" class="form-control" placeholder="Camanha" ></th>
                        <th><input type="text" class="form-control" placeholder="Validade" ></th>
                        <th><input type="text" class="form-control" placeholder="Palavra(s)" ></th>
                        <th><input type="text" class="form-control" placeholder="Assinantes ativos" ></th>
                        <th><span class='btn btn-default glyphicon glyphicon-search'> Buscar</span></th>
                        <th></th>
                    </tr>-->
                    <tr class="filters">
                        <th><input type="text" class="form-control" placeholder="Status" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Data de cadastro" disabled></th>
                        <th><input type="text" class="form-control" placeholder="usuario" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Validador" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Opções" disabled></th>
                    </tr>
                </thead>
                <tbody>
                     <?php while ($r = $produtos->fetch_assoc()) {?>
                          <tr>
                                <td><?php if($r['status']== 1){?><p class="success" style="background-color: #459B45;text-align: center;color: white;">Ativo</p><?php }else{?><p class="warning" style="background-color: #FE3A2B;text-align: center;color: white;">Inativo</p><?php }?></td>
                                <td><?php echo $r['dtCad'];?></td>
                                <td><?php echo $r['usuario'];?></td>
                                <td><?php if($r['faz_validacao']== 1){?><p class="success" style="background-color: #459B45;text-align: center;color: white;">Sim</p><?php }else{?><p class="warning" style="background-color: #FE3A2B;text-align: center;color: white;">Não</p><?php }?></td>
                                <td>
                                    <input type="hidden" name="idUsuaio" id="idUsuaio" value="<?echo $r['id'];?>">

                                    <a href="usuario.php?acao=editar&idUsuaio=<?echo $r['id'];?>"><img src="img/editar.png" alt="editar"></a>
                                </td>
                        </tr>
                     <?}?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php }else{
    header("location:index.php");
}
require_once"footer.php";?>