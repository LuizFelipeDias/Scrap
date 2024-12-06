<?php
session_start();
include '../../conexao/db.php';

$usuario_id =$_SESSION['user']['id']; // Assumindo que você armazenou o ID do usuário na sessão

header('Content-Type: application/json'); // Define o cabeçalho para JSON

// Corrigindo o nome do campo para 'cimcode'
$cliente = $_POST['cliente_id'];
$descricao = $_POST['descricao'];
$sql = "INSERT INTO modelo (cliente_id, descricao) VALUES (?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param('is', $cliente, $descricao);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Dados inseridos com sucesso.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao inserir dados.']);
}

?>
