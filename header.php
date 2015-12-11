<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Painel SMS</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">

	<link rel="stylesheet" href="css/estilo.css">

	<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
	<script type="text/javascript" language="JavaScript" src="js/jquery.min.js"></script>
	<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
	<script type="text/javascript" language="JavaScript" src="js/jquery.maskMoney.js"></script>
	<script type="text/javascript" language="JavaScript" src="js/jquery.validate.js"></script>
	<script type="text/javascript" language="JavaScript" src="js/jquery.numeric.pack.js"></script>
	<script type="text/javascript" language="JavaScript" src="js/jquery.floatnumber.js"></script>
	<script type="text/javascript" language="JavaScript" src="js/jquery.maskedinput-1.2.2.js"></script>
	<script type="text/javascript" src="js/funcoes.js"></script>
	<!-- Latest compiled and minified JavaScript
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script> -->

</head>
<body>
<?php
include_once "classes/conexao.php";
$conn = new conn();
$conn->update(array('status' => 0), "validadeFim < " . date("Y-m-d") . "", "campanha_sms");
$conn->update(array('status' => 2), "dtvalidade < " . date("Y-m-d") . "", "cupom");

?>