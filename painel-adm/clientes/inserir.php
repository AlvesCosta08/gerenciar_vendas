<?php 
require_once("../../conexao.php");

$nomeFantasia = $_POST['nome_fantasia'];
$razaoSocial = $_POST['razao_social'];
$cnpjCpf = $_POST['cnpj_cpf'];
$inscricaoEstadual = $_POST['inscricao_estadual'];
$email = $_POST['email'];
$endereco = $_POST['endereco'];
$cep = $_POST['cep'];
$cidadeEstado = $_POST['cidade_estado'];
$telefone = $_POST['telefone'];

$id = $_POST['id'];
$antigo = $_POST['antigo'];

if($antigo != $cnpjCpf){
    // EVITAR DUPLICIDADE NO CNPJ/CPF
    $query_con = $pdo->prepare("SELECT * FROM clientes WHERE cnpj_cpf = :cnpj_cpf");
    $query_con->bindValue(":cnpj_cpf", $cnpjCpf);
    $query_con->execute();
    $res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
    if(@count($res_con) > 0){
        echo 'O CNPJ/CPF do cliente já está cadastrado!';
        exit();
    }
}

if($id == ""){
    // Inserir novo cliente
    $res = $pdo->prepare("INSERT INTO clientes SET 
        nome_fantasia = :nome_fantasia,
        razao_social = :razao_social,
        cnpj_cpf = :cnpj_cpf,
        inscricao_estadual = :inscricao_estadual,
        email = :email,
        endereco = :endereco,
        cep = :cep,
        cidade_estado = :cidade_estado,
        telefone = :telefone
    ");
} else {
    // Atualizar cliente existente
    $res = $pdo->prepare("UPDATE clientes SET 
        nome_fantasia = :nome_fantasia,
        razao_social = :razao_social,
        cnpj_cpf = :cnpj_cpf,
        inscricao_estadual = :inscricao_estadual,
        email = :email,
        endereco = :endereco,
        cep = :cep,
        cidade_estado = :cidade_estado,
        telefone = :telefone
        WHERE id = :id
    ");
    $res->bindValue(":id", $id);
}

// Vincular valores aos parâmetros
$res->bindValue(":nome_fantasia", $nomeFantasia);
$res->bindValue(":razao_social", $razaoSocial);
$res->bindValue(":cnpj_cpf", $cnpjCpf);
$res->bindValue(":inscricao_estadual", $inscricaoEstadual);
$res->bindValue(":email", $email);
$res->bindValue(":endereco", $endereco);
$res->bindValue(":cep", $cep);
$res->bindValue(":cidade_estado", $cidadeEstado);
$res->bindValue(":telefone", $telefone);

$res->execute();
echo 'Salvo com Sucesso!';
?>
