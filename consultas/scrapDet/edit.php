<?php
include_once '../../conexao/db.php';
	$partnumber_d = $_REQUEST['partnumber_d'];
	$falha_d = $_REQUEST['falha_d'];
    $quantidade = $_REQUEST['quantidade_d'];
    $valor_t_d = $_REQUEST['valor_t_d'];
	$observacao_d = $_REQUEST['observacao_d'];
	$id = $_REQUEST['id'];

    $query = "UPDATE scrap_pn SET
			partnumber = '$partnumber_d',
			falha = '$falha_d',
            quantidade = '$quantidade_d'
            valor_t = '$valor_t_d'
            observacao = '$observacao_d'
			WHERE id = $id
		";
$return_query = mysqli_query($conn, $query);


echo (json_encode($query));
