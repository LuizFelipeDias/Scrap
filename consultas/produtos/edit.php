<?php
	include_once '../../conexao/db.php';

	$id = $_POST['id'];
	$linha = $_POST['linha'];
	$cliente = $_POST['cliente'];

	$response = array();

	if (!$id || !$linha || !$cliente) {
		$response['success'] = false;
		$response['message'] = 'Todos os campos devem ser preenchidos.';
		echo json_encode($response);
		exit;
	}

	$query = "UPDATE produto SET
				linha_id = '$linha',
				cliente_id = '$cliente'
			WHERE id = $id";

	if (mysqli_query($conn, $query)) {
		if (mysqli_affected_rows($conn) > 0) {
			$response['success'] = true;
			$response['message'] = 'Produto atualizado com sucesso.';
		} else {
			$response['success'] = false;
			$response['message'] = 'Nenhuma linha foi alterada. Verifique os valores informados.';
		}
	} else {
		$response['success'] = false;
		$response['message'] = 'Erro ao executar a query: ' . mysqli_error($conn);
	}

	echo json_encode($response);
?>
