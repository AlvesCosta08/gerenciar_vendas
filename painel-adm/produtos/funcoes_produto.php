<?php
require_once("../../conexao.php");

function verificarDuplicidade($pdo, $item, $codigo, $id = null) {
    $query = $pdo->prepare("SELECT * FROM produtos WHERE item = :item AND (:id IS NULL OR id != :id)");
    $query->bindValue(":item", $item);
    $query->bindValue(":id", $id);
    $query->execute();
    if ($query->rowCount() > 0) {
        return 'Produto já Cadastrado!';
    }

    $query = $pdo->prepare("SELECT * FROM produtos WHERE codigo = :codigo AND (:id IS NULL OR id != :id)");
    $query->bindValue(":codigo", $codigo);
    $query->bindValue(":id", $id);
    $query->execute();
    if ($query->rowCount() > 0) {
        return 'Código de Referência já Cadastrado!';
    }

    return null;
}

function processarImagem($id = null) {
    if (empty($_FILES['foto']['name'])) {
        return $id === null ? "sem-foto.jpg" : null;
    }

    $nome_img = date('d-m-Y-H-i-s') . '-' . $_FILES['foto']['name'];
    $nome_img = preg_replace('/[ :]+/', '-', $nome_img);
    $caminho = '../../img/produtos/' . $nome_img;
    $ext = pathinfo($nome_img, PATHINFO_EXTENSION);

    if (!in_array(strtolower($ext), ['jpg', 'jpeg'])) {
        throw new Exception('Extensão de Imagem não permitida, use somente imagem jpg!!');
    }

    move_uploaded_file($_FILES['foto']['tmp_name'], $caminho);
    return $nome_img;
}
?>
