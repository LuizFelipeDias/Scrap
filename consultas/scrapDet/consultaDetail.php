<?php
	include_once '../../conexao/conexaoPDO.php';

    $id = $_REQUEST['id'];

	$sql = "SELECT id,
                    quantidade,
                    observacao,
                    valor_t,
                    (select falhas.descricao from falhas where falhas.id = scrap_pn.falhas_id) AS falhas, 
                    (select partnumber.partnumber from partnumber where partnumber.id = scrap_pn.partnumber_id) AS partnumber
            FROM scrap_pn 
            WHERE id  = '$id'";

   $result_qnt_material = $conn->prepare($sql);
   $result_qnt_material->execute();
   $row_qnt_material = $result_qnt_material->fetch(PDO::FETCH_ASSOC);
   // var_dump($row_qnt_material);

   echo json_encode($row_qnt_material);

?>