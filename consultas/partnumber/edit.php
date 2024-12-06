<?php
include_once '../../conexao/db.php';
	$partnumber_d = $_REQUEST['partnumber_d'];
	$valor_d = $_REQUEST['valor_d'];
	$descricao_d = $_REQUEST['descricao_d'];
	$id = $_REQUEST['id'];

    $query = "UPDATE partnumber SET
			partnumber = '$partnumber_d',
			valor_unit = '$valor_d',
			descricao = '$descricao_d'
			WHERE id = $id
		";
$return_query = mysqli_query($conn, $query);


echo (json_encode($query));
