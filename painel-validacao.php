<?php
if (!$_SESSION) {
    session_start();
}
  require_once "classes/conexao.php";
  require_once "classes/funcionalidades.php";
require_once"header.php";


    $funcionalidades = new funcionalidades();
    $conn = new conn();
    $produtos = isset($_GET['codigo']) ? $conn->read(array("*"),"codigo_cupom =  '".$_GET['codigo']."'","","cupom","query"):0;?>
<div class="container">
<?php if($_SESSION["login"]["logado"] == "sim"){
 require_once"menu.php";?>

    <!--<h3>The columns titles are merged with the filters inputs thanks to the placeholders attributes</h3>
    <hr>
    <p>Inspired by this <a href="http://bootsnipp.com/snippets/featured/panel-tables-with-filter">snippet</a></p>-->
    <div class="row">
        <div class="panel panel-primary filterable">
            <div class="panel-heading">
                <h3 class="panel-title">Gerenciador de cupons</h3>
            </div>
            <table class="table">
                <thead>
                	<tr class="filters">
                        <form action="?" method="get">
                            <th></th>
                            <th></th>
                            <th><input type="text" class="form-control" placeholder="Código do cupom" name="codigo" id="codigo"></th>
                            <th></th>
                            <th></th>
                             <th><button class='btn btn-default glyphicon glyphicon-search'> Buscar</button></th>
                        </form>
                    </tr>
                    <tr class="filters">
                        <th><input type="text" class="form-control" placeholder="Status" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Camanha" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Usuário que fez a baixa" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Válidade" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Código do cupom" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Data da baixa" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Opções" disabled></th>
                    </tr>
                </thead>
                <tbody>
                     <?php
                            if($produtos != 0){
                                 while ($r = $produtos->fetch_assoc()) {
                                    $c = $conn->read(array("campanha"),$sqlWhere,"","campanha_sms","fetch");?>
                                      <tr>
                                            <td><?php if($r['status']== 0){?><p class="success" style="background-color: #459B45;text-align: center;color: white;">Não baixado</p><?php }else if($r['status']== 1){ ?><p class="warning" style="background-color: #FE3A2B;text-align: center;color: white;">Baixado</p><?php }else if($r['status']== 2){ ?><p class="warning" style="background-color: #FE3A2B;text-align: center;color: white;">Vencido</p><?php } ?></td>
                                            <td><?php echo $c['campanha'];?></td> 
                                            <td><?php echo $r['usuario_acao'];?></td>
                                            <td><?php echo $r['dtvalidade'];?></td>
                                            <td><?php echo $r['codigo_cupom'];?></td>
                                            <td><?php echo $funcionalidades->ChecaVariavel($r['dtCad'],"data2");?></td>
                                            <td>
                                                <input type="hidden" name="idCupom" id="idCupom" value="<?echo $r['idCupom'];?>">
                                                <input type="hidden" name="campanha" id="campanha" value="<?echo $r['campanha'];?>">
                                                <a href="javascript:baixar();" id="cancelar_cupom"><img src="img/excluir.png" alt="excluir"></a>
                                            </td>
                                    </tr>
                                 <?}
                                }
                   //  }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php }else{
    header("location:index.php");
} 
require_once"footer.php";?>