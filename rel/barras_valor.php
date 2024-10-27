<?php 
require_once("../conexao.php"); 

$codigo = $_GET['codigo'];
$item = $_GET['item'];
$valor = $_GET['valor'];
$valor = number_format($valor, 2, ',', '.');
require_once('classe_barras.php');

?>

<style>

		@page {
			margin: 8px;

		}

		.margem{
			margin-right:10px;
			display: inline-block;
			font-size:14px;
			text-align:center;
			letter-spacing: 2px;
		}

		.linhacodigos{
			margin-bottom:10px;

		}
</style>

<?php for($i2=0; $i2<$linhas_etiquetas_pag; $i2++){ ?>

<div class="linhacodigos">

<?php for($i=0; $i<$etiquetas_por_linha; $i++){ ?>

<span class="margem">
<small><small><?php echo $item ?> <br>R$ <?php echo $valor ?></small></small>
<br>
<?php 
echo geraCodigoBarra($codigo, $largura_cod_barras, $altura_cod_barras); 
?> 
<br>
<?php echo $codigo ?>
</span>

<?php } ?>


</div>

<?php } ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="icon" type="image/png" href="vendor/login/images/icons/favicon.ico" />
</head>
<body>
	
</body>
</html>

