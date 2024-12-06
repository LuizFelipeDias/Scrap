<?php
session_start();
include '../../conexao/db.php';

header('Content-Type: application/json'); // Define o cabeçalho para JSON

// Corrigindo o nome do campo para 'partnumber'
$partnumber = $_POST['partnumber'];
$valor_unit = $_POST['valor_unit'];
$descricao = $_POST['descricao'];

$sql = "INSERT INTO partnumber (partnumber, valor_unit, descricao) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sss', $partnumber, $valor_unit, $descricao);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Dados inseridos com sucesso.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao inserir dados.']);
}

?>
