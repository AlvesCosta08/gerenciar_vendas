<?php 

require_once('../conexao.php');
require_once('verificar-permissao.php');

$saldoMesF = 0;
$totalVendasMF = 0;
$receberMesF = 0;
$pagarMesF = 0;


$hoje = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$dataInicioMes = $ano_atual."-".$mes_atual."-01";

$data_atual = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$data_inicio_mes = $ano_atual."-".$mes_atual."-01";
$data_inicio_ano = $ano_atual."-01-01";

$data_ontem = date('Y-m-d', strtotime("-1 days",strtotime($data_atual)));
$data_amanha = date('Y-m-d', strtotime("+1 days",strtotime($data_atual)));


if($mes_atual == '04' || $mes_atual == '06' || $mes_atual == '09' || $mes_atual == '11'){
	$dataMesFinal = $ano_atual.'-'.$mes_atual.'-30';
}else if($mes_atual == '02'){
	$bissexto = date('L', @mktime(0, 0, 0, 1, 1, $ano_atual));
	if($bissexto == 1){
		$dataMesFinal = $ano_atual.'-'.$mes_atual.'-29';
	}else{
		$dataMesFinal = $ano_atual.'-'.$mes_atual.'-28';
	}

}else{
	$dataMesFinal = $ano_atual.'-'.$mes_atual.'-31';
}





$query = $pdo->query("SELECT * from produtos");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$totalProdutos = @count($res);

	$query = $pdo->query("SELECT * from fornecedores");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$totalFornecedores = @count($res);

	$query = $pdo->query("SELECT * from produtos where quantidade < estoque_min");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$totalEstoqueBaixo = @count($res);

	$vendas_rs = 0;
	$query = $pdo->query("SELECT * from vendas where data = curDate()");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$totalVendasDia = @count($res);
	if($totalVendasDia > 0){ 
		for($i=0; $i < $totalVendasDia; $i++){
			$vendas_rs += $res[$i]['valor'];
		}
		$vendas_rs = number_format($vendas_rs, 2, ',', '.');
	}


	$contas_receber_vencidas_rs = 0;
	$query = $pdo->query("SELECT * from contas_receber where vencimento < curDate() and pago != 'Sim'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$contas_receber_vencidas = @count($res);
	if($contas_receber_vencidas > 0){ 
		for($i=0; $i < $contas_receber_vencidas; $i++){
			$contas_receber_vencidas_rs += $res[$i]['valor'];
		}
		$contas_receber_vencidas_rs = number_format($contas_receber_vencidas_rs, 2, ',', '.');
	}



	$query = $pdo->query("SELECT * from contas_receber where vencimento = curDate() and pago != 'Sim'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$contas_receber_hoje = @count($res);

	$contas_pagar_vencidas_rs = 0;
	$query = $pdo->query("SELECT * from contas_pagar where vencimento < curDate() and pago != 'Sim'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$contas_pagar_vencidas = @count($res);
	if($contas_pagar_vencidas > 0){ 
		for($i=0; $i < $contas_pagar_vencidas; $i++){
			$contas_pagar_vencidas_rs += $res[$i]['valor'];
		}
		$contas_pagar_vencidas_rs = number_format($contas_pagar_vencidas_rs, 2, ',', '.');
	}


	$query = $pdo->query("SELECT * from contas_pagar where vencimento = curDate() and pago != 'Sim'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$contas_pagar_hoje = @count($res);


	//produtos vencendo
	$query = $pdo->query("SELECT * from alerta_vencimentos where data_alerta <= curDate() ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$alerta_produtos = @count($res);


	$entradasM = 0;
	$saidasM = 0;
	$saldoM = 0;
	$query = $pdo->query("SELECT * from movimentacoes where data >= '$dataInicioMes' and data <= curDate() ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){ 

		for($i=0; $i < $total_reg; $i++){
			foreach ($res[$i] as $key => $value){	}


				if($res[$i]['tipo'] == 'Entrada'){

					$entradasM += $res[$i]['valor'];
				}else{

					$saidasM += $res[$i]['valor'];
				}

				$saldoMes = $entradasM - $saidasM;

				$entradasMF = number_format($entradasM, 2, ',', '.');
				$saidasMF = number_format($saidasM, 2, ',', '.');
				$saldoMesF = number_format($saldoMes, 2, ',', '.');

				if($saldoMesF < 0){
					$classeSaldoM = 'text-danger';
				}else{
					$classeSaldoM = 'text-success';
				}

			}

		}



		$totalPagarM = 0;
		$query = $pdo->query("SELECT * from contas_pagar where data_pgto >= '$dataInicioMes' and data_pgto <= curDate() and pago = 'Sim'");
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$pagarMes = @count($res);
		$total_reg = @count($res);
		if($total_reg > 0){ 

			for($i=0; $i < $total_reg; $i++){
				foreach ($res[$i] as $key => $value){	}

					$totalPagarM += $res[$i]['valor'];
				$pagarMesF = number_format($totalPagarM, 2, ',', '.');

			}
		}


		$totalReceberM = 0;
		$query = $pdo->query("SELECT * from contas_receber where data_pgto >= '$dataInicioMes' and data_pgto <= curDate() and pago = 'Sim'");
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$receberMes = @count($res);
		$total_reg = @count($res);
		if($total_reg > 0){ 

			for($i=0; $i < $total_reg; $i++){
				foreach ($res[$i] as $key => $value){	}

					$totalReceberM += $res[$i]['valor'];
				$receberMesF = number_format($totalReceberM, 2, ',', '.');

			}
		}





		$totalVendasM = 0;
		$query = $pdo->query("SELECT * from vendas where data >= '$dataInicioMes' and data <= curDate() and status = 'Concluída'");
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$total_reg = @count($res);
		if($total_reg > 0){ 

			for($i=0; $i < $total_reg; $i++){
				foreach ($res[$i] as $key => $value){	}

					$totalVendasM += $res[$i]['valor'];
				$totalVendasMF = number_format($totalVendasM, 2, ',', '.');

			}
		}

		?>




<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="../vendor/css/home.css">
</head>
<body>
<div class="container-fluid">
    <section id="minimal-statistics">
        <div class="row mb-2">
            <div class="col-12 mt-3 mb-1">
                <h4 class="text-uppercase">Estatísticas do Sistema</h4>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mb-4">
            <!-- Card Total de Produtos -->
            <div class="col">
                <div class="card">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon col-3">
                            <i class="bi bi-bar-chart-line-fill text-success fs-1"></i>
                        </div>
                        <div class="text col-9 text-end">
                            <h3><span class="text-success"><?php echo @$totalProdutos ?></span></h3>
                            <span>Total de Produtos</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Estoque Baixo -->
            <div class="col">
                <a class="text-dark" href="index.php?pagina=estoque" style="text-decoration: none;">
                    <div class="card">
                        <div class="card-body d-flex align-items-center">
                            <div class="icon col-3">
                                <i class="bi bi-bar-chart-line-fill text-danger fs-1"></i>
                            </div>
                            <div class="text col-9 text-end">
                                <h3><?php echo @$totalEstoqueBaixo ?></h3>
                                <span>Estoque Baixo</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Card Total Fornecedores -->
            <div class="col">
                <div class="card">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon col-3">
                            <i class="bi bi-bar-chart-line-fill fs-1"></i>
                        </div>
                        <div class="text col-9 text-end">
                            <h3><span class="<?php echo $classeSaldo ?>"><?php echo @$totalFornecedores ?></span></h3>
                            <span>Total Fornecedores</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Total Vendas Dia -->
            <div class="col">
                <div class="card">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon col-3">
                            <i class="bi bi-cash fs-1 text-success"></i>
                        </div>
                        <div class="text col-9 text-end">
                            <h3><?php echo @$totalVendasDia ?></h3>
                            <span>Total Vendas Dia</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="stats-subtitle">
        <div class="row mb-2">
            <div class="col-12 mt-3 mb-1">
                <h4 class="text-uppercase">Estatísticas Mensais</h4>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 g-4 mb-4">
            <!-- Card Saldo Total -->
            <div class="col">
                <div class="card">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon col-2">
                            <i class="bi bi-calendar2-date text-primary fs-1"></i>
                        </div>
                        <div class="text col-10 text-end">
                            <h4>Saldo Total</h4>
                            <span>Total Arrecadado este Mês</span>
                            <h2><span class="<?php echo $classeSaldoM ?>">R$ <?php echo $saldoMesF ?></span></h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Contas Pagas -->
            <div class="col">
                <div class="card">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon col-2">
                            <i class="bi bi-calendar-week-fill text-danger fs-1"></i>
                        </div>
                        <div class="text col-10 text-end">
                            <h4>Contas Pagas</h4>
                            <span>Total de <?php echo $pagarMes ?> Contas no Mês</span>
                            <h2>R$ <?php echo @$pagarMesF ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</body>
</html>

