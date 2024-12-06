<?php
include_once '../../conexao/db.php';
session_start();

$usuario_id = $_SESSION['user']['id']; // ID do usuário logado
$tipo = $_SESSION['user']['tipo_usuario']; // Tipo do usuário logado

// Verificação de parâmetros
$id = isset($_GET['id_scrap']) ? $_GET['id_scrap'] : null; // ID do scrap passado por GET
$acao = isset($_GET['acao']) ? $_GET['acao'] : null; // Plano de Ação
$prazo = isset($_GET['prazo']) ? $_GET['prazo'] : null; 
$responsavel = isset($_GET['responsavel']) ? $_GET['responsavel'] : null; 

// Função para atualizar o scrap
function atualizarScrap($conn, $usuario_id, $id, $acao = null, $prazo = null, $responsavel = null, $campo_usuario) {
    if ($id === null) {
        return json_encode(['status' => 'erro', 'message' => 'ID do scrap não fornecido.']);
    }

    // Construir a consulta de atualização dinâmica
    $query = "UPDATE scrap SET ";

    // Adicionando parâmetros dinamicamente com base nos dados fornecidos
    $params = [];
    $types = '';
    
    if ($acao !== null) {
        $query .= "acao = ?, ";
        $params[] = $acao;
        $types .= 's'; // tipo string
    }

    if ($prazo !== null) {
        $query .= "prazo = ?, ";
        $params[] = $prazo;
        $types .= 's'; // tipo string
    }

    if ($responsavel !== null) {
        $query .= "responsavel = ?, ";
        $params[] = $responsavel;
        $types .= 's'; // tipo string
    }

    // Definir o campo do usuário (engenheiro ou coordenador)
    $query .= $campo_usuario . " = ? WHERE id = ?";
    $params[] = $usuario_id;
    $params[] = $id;
    $types .= 'ii'; // tipo int para usuario_id e id

    // Preparar e executar a consulta
    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        return json_encode(['status' => 'sucesso', 'message' => 'Scrap atualizado com sucesso!']);
    } else {
        return json_encode(['status' => 'erro', 'message' => 'Erro ao atualizar o scrap.']);
    }
}

if ($tipo == 3 || $tipo == 4) {
    // Para ambos os tipos de usuário (engenheiro e coordenador)
    if ($id === null) {
        echo json_encode(['status' => 'erro', 'message' => 'ID do scrap não fornecido.']);
    } else {
        if ($tipo == 3) {
            echo atualizarScrap($conn, $usuario_id, $id, $acao, $prazo, $responsavel, 'engenheiro_id');
        } elseif ($tipo == 4) {
            echo atualizarScrap($conn, $usuario_id, $id, $acao, $prazo, $responsavel, 'coordenador_id');
        }
    }
} else {
    echo json_encode(['status' => 'erro', 'message' => 'Ação não permitida para este tipo de usuário.']);
}
?>
