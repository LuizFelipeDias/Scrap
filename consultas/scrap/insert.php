<?php
session_start();
include '../../conexao/db.php';

$usuario_id = $_SESSION['user']['id']; // Assumindo que o ID do usuário está na sessão

header('Content-Type: application/json');

// Dados do POST
$area = $_POST['area'];
$modelo = $_POST['modelo_id'];
$turno = $_POST['turno'];
$produto = isset($_POST['produto_id']) && $_POST['produto_id'] !== '' ? $_POST['produto_id'] : null; // Trata produto_id como NULL se não for enviado ou estiver vazio
$reincidente = $_POST['reincidente'];
$causa = $_POST['causa'];

// Validação de chaves estrangeiras
function validarChaveEstrangeira($conn, $tabela, $coluna, $valor) {
    if (is_null($valor)) {
        return true; // `NULL` é permitido
    }
    $sql = "SELECT COUNT(*) FROM $tabela WHERE $coluna = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $valor);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count > 0;
}

if (!validarChaveEstrangeira($conn, 'modelo', 'id', $modelo)) {
    echo json_encode(['success' => false, 'message' => 'Modelo inválido.']);
    exit();
}

if (!is_null($produto) && !validarChaveEstrangeira($conn, 'produto', 'id', $produto)) {
    echo json_encode(['success' => false, 'message' => 'Produto inválido.']);
    exit();
}

// Inserção de dados na tabela 'scrap'
$sql = "INSERT INTO scrap (area, modelo_id, turno, produto_id, reincidente, usuario_id, causa, created_at, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), 0)";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Erro na preparação da consulta.']);
    exit();
}

$stmt->bind_param('iiiisis', $area, $modelo, $turno, $produto, $reincidente, $usuario_id, $causa);

if ($stmt->execute()) {
    $last_id = $conn->insert_id;

    // Atualização do serial
    $serial = 'SC' . $last_id;
    $update_sql = "UPDATE scrap SET serial = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    if ($update_stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Erro na preparação da consulta de update.']);
        exit();
    }

    $update_stmt->bind_param('si', $serial, $last_id);

    if ($update_stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Dados inseridos e serial atualizado com sucesso.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao atualizar o serial: ' . $update_stmt->error]);
    }

    $update_stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao inserir dados: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
