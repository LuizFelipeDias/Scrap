<?php

// Incluir a conexao com o banco de dados
include_once '../../conexao/conexaoPDO.php';

// Receber os dados da requisição
$dados_requisicao = $_REQUEST;

// Lista de colunas da tabela
$colunas = [
    0 => 'id',
    1 => 'descricao',
    2 => 'cliente_id',
];

// Obter a quantidade de registros no banco de dados
$query_qnt_modelos = "SELECT COUNT(id) AS qnt_modelos FROM modelo";

// Acessa o IF quando há parâmetros de pesquisa   
if(!empty($dados_requisicao['search']['value'])) {
    $query_qnt_modelos .= " WHERE descricao LIKE :descricao ";
    $query_qnt_modelos .= "OR (select clientes.descricao from clientes where clientes.id = modelo.cliente_id ) LIKE :cliente_id ";
}

// Preparar a QUERY
$result_qnt_modelos = $conn->prepare($query_qnt_modelos);

// Acessa o IF quando há parâmetros de pesquisa   
if(!empty($dados_requisicao['search']['value'])) {
    $valor_pesq = "%" . $dados_requisicao['search']['value'] . "%";
    $result_qnt_modelos->bindParam(':descricao', $valor_pesq, PDO::PARAM_STR);
    $result_qnt_modelos->bindParam(':cliente', $valor_pesq, PDO::PARAM_STR);
}

// Executar a QUERY responsável em retornar a quantidade de registros no banco de dados
$result_qnt_modelos->execute();
$row_qnt_modelos = $result_qnt_modelos->fetch(PDO::FETCH_ASSOC);

// Recuperar os registros do banco de dados
$query_modelos = "SELECT id,
                    descricao,
                    (SELECT clientes.descricao FROM clientes WHERE clientes.id = modelo.cliente_id) AS cliente
                FROM modelo";

// Acessa o IF quando há parâmetros de pesquisa
if(!empty($dados_requisicao['search']['value'])) {
    $query_modelos .= " WHERE descricao LIKE :descricao ";
    $query_qnt_modelos .= "OR (select clientes.descricao from clientes where clientes.id = modelo.cliente_id ) LIKE :cliente_id ";

}

// Ordenar os registros
$query_modelos .= " ORDER BY " . $colunas[$dados_requisicao['order'][0]['column']] . " " . $dados_requisicao['order'][0]['dir'] . " LIMIT :inicio , :quantidade";

// Preparar a QUERY
$result_modelos = $conn->prepare($query_modelos);
$result_modelos->bindParam(':inicio', $dados_requisicao['start'], PDO::PARAM_INT);
$result_modelos->bindParam(':quantidade', $dados_requisicao['length'], PDO::PARAM_INT);

// Acessa o IF quando há parâmetros de pesquisa   
if(!empty($dados_requisicao['search']['value'])) {
    $valor_pesq = "%" . $dados_requisicao['search']['value'] . "%";
    $result_modelos->bindParam(':descricao', $valor_pesq, PDO::PARAM_STR);
    $result_modelos->bindParam(':cliente', $valor_pesq, PDO::PARAM_STR);
}

// Executar a QUERY
$result_modelos->execute();
$dados = [];

while ($row_modelos = $result_modelos->fetch(PDO::FETCH_ASSOC)) {
    extract($row_modelos);
    $registro = [];
    $registro[] = $descricao;
    $registro[] = $cliente; // Certifique-se de usar o alias correto aqui
    $registro[] = $id;
    $dados[] = $registro;
}


// Cria o array de informações a serem retornadas para o Javascript
$resultado = [
    "draw" => intval($dados_requisicao['draw']), // Para cada requisição é enviado um número como parâmetro
    "recordsTotal" => intval($row_qnt_modelos['qnt_modelos']), // Quantidade de registros que há no banco de dados
    "recordsFiltered" => intval($row_qnt_modelos['qnt_modelos']), // Total de registros quando houver pesquisa
    "data" => $dados // Array de dados com os registros retornados da tabela usuario
];

// Retornar os dados em formato de objeto para o JavaScript
echo json_encode($resultado);
?>
