<?php
require_once("funcoes_produto.php");

$id = $_POST['id'];
$categoria = $_POST['categoria'];
$codigo = $_POST['codigo'];
$item = $_POST['item'];
$unidade = $_POST['unidade'];
$preco_unitario = str_replace(',', '.', $_POST['preco_unitario']);
$quantidade = $_POST['quantidade'];
$estoque_min = $_POST['estoque_min'];
$valor_compra = str_replace(',', '.', $_POST['valor_compra']);
$ipi = $_POST['ipi'];
$percentual_custo = $_POST['percentual_custo'];
$data = $_POST['data'];

try {
    $duplicidade = verificarDuplicidade($pdo, $item, $codigo, $id);
    if ($duplicidade) {
        echo $duplicidade;
        exit();
    }

    $foto = processarImagem($id);

    $query = "UPDATE produtos SET 
        categoria = :categoria, 
        item = :item, 
        unidade = :unidade, 
        preco_unitario = :preco_unitario, 
        quantidade = :quantidade, 
        estoque_min = :estoque_min, 
        valor_compra = :valor_compra, 
        ipi = :ipi, 
        percentual_custo = :percentual_custo, 
        data = :data";
    
    if ($foto !== null) {
        $query .= ", foto = :foto";
    }
    
    $query .= " WHERE id = :id";
    $res = $pdo->prepare($query);

    $res->bindValue(":categoria", $categoria);
    $res->bindValue(":item", $item);
    $res->bindValue(":unidade", $unidade);
    $res->bindValue(":preco_unitario", $preco_unitario);
    $res->bindValue(":quantidade", $quantidade);
    $res->bindValue(":estoque_min", $estoque_min);
    $res->bindValue(":valor_compra", $valor_compra);
    $res->bindValue(":ipi", $ipi);
    $res->bindValue(":percentual_custo", $percentual_custo);
    $res->bindValue(":data", $data);
    if ($foto !== null) {
        $res->bindValue(":foto", $foto);
    }
    $res->bindValue(":id", $id, PDO::PARAM_INT);
    $res->execute();

    echo 'Produto atualizado com sucesso!';
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
}
?>
