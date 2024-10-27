<?php 
require_once("../../conexao.php");

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

// Função para verificar duplicidade apenas ao inserir
function verificarDuplicidade($pdo, $item, $codigo) {
    // Verificação de duplicidade do item
    $query_con_item = $pdo->prepare("SELECT * FROM produtos WHERE item = :item");
    $query_con_item->bindValue(":item", $item);
    $query_con_item->execute();
    if ($query_con_item->rowCount() > 0) {
        return 'Produto já Cadastrado!';
    }

    // Verificação de duplicidade do código de referência
    $query_con_codigo = $pdo->prepare("SELECT * FROM produtos WHERE codigo = :codigo");
    $query_con_codigo->bindValue(":codigo", $codigo);
    $query_con_codigo->execute();
    if ($query_con_codigo->rowCount() > 0) {
        return 'Código de Referência já Cadastrado!';
    }

    return null;
}

// Função para processar a imagem
function processarImagem() {
    if (@$_FILES['foto']['name'] == "") {
        return "sem-foto.jpg"; // Valor padrão para novos registros
    }

    $nome_img = date('d-m-Y-H-i-s') . '-' . @$_FILES['foto']['name'];
    $nome_img = preg_replace('/[ :]+/', '-', $nome_img);
    $caminho = '../../img/produtos/' . $nome_img;
    $imagem_temp = @$_FILES['foto']['tmp_name'];
    $ext = pathinfo($nome_img, PATHINFO_EXTENSION);

    if (in_array(strtolower($ext), ['jpg', 'jpeg'])) {
        move_uploaded_file($imagem_temp, $caminho);
        return $nome_img;
    } else {
        throw new Exception('Extensão de Imagem não permitida, use somente imagem jpg!!');
    }
}

try {
    // Processar a imagem
    $foto = processarImagem();

    // Verificação de duplicidade
    $duplicidade = verificarDuplicidade($pdo, $item, $codigo);
    if ($duplicidade) {
        echo $duplicidade;
        exit();
    }

    // Inserção
    $res = $pdo->prepare("INSERT INTO produtos 
        (categoria, codigo, foto, item, unidade, preco_unitario, quantidade, estoque_min, valor_compra, ipi, percentual_custo, data) 
        VALUES 
        (:categoria, :codigo, :foto, :item, :unidade, :preco_unitario, :quantidade, :estoque_min, :valor_compra, :ipi, :percentual_custo, :data)");
    
    $res->bindValue(":categoria", $categoria);
    $res->bindValue(":codigo", $codigo);
    $res->bindValue(":foto", $foto);
    $res->bindValue(":item", $item);
    $res->bindValue(":unidade", $unidade);
    $res->bindValue(":preco_unitario", $preco_unitario);
    $res->bindValue(":quantidade", $quantidade);
    $res->bindValue(":estoque_min", $estoque_min);
    $res->bindValue(":valor_compra", $valor_compra);
    $res->bindValue(":ipi", $ipi);
    $res->bindValue(":percentual_custo", $percentual_custo);
    $res->bindValue(":data", $data);
    $res->execute();

    echo 'Salvo com Sucesso!';
} catch (PDOException $e) {
    echo 'Erro: ' . $e->getMessage();
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
}
?>









