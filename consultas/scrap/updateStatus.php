<?php
    // Inclua a conexão com o banco de dados
    include_once '../../conexao/conexaoPDO.php';

    // Verifica se os dados foram enviados via POST
    if (isset($_POST['ids']) && isset($_POST['novoStatus'])) {
        $ids = $_POST['ids'];  // Os IDs dos itens selecionados
        $novoStatus = $_POST['novoStatus'];  // O novo status a ser atualizado

        // Prepara a consulta SQL para atualizar o status
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "UPDATE scrap SET status = ?, updated_at = NOW() WHERE id IN ($placeholders)";
        // Prepara e executa a query
        $stmt = $conn->prepare($sql);
        $params = array_merge([$novoStatus], $ids);  // Insere o novo status e os IDs dos itens
        $stmt->execute($params);

        // Verifica se a atualização foi bem-sucedida
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true]);  // Resposta de sucesso
        } else {
            echo json_encode(['success' => false]);  // Resposta de erro
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Dados inválidos.']);
    }

?>
