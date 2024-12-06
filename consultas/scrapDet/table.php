<?php

// Incluir a conexão com o banco de dados
include_once '../../conexao/conexaoPDO.php';

// Receber os dados da requisição
$dados_requisicao = $_REQUEST;

// Verificar se o parâmetro 'scrapID' foi enviado
if (isset($dados_requisicao['scrapID']) && !empty($dados_requisicao['scrapID'])) {
    $scrap_id = intval($dados_requisicao['scrapID']);
} else {
    // Retornar erro caso o 'scrapID' não seja fornecido
    echo json_encode([
        ""
    ]);
    exit;
}

// Lista de colunas da tabela
$colunas = [
    0 => 'id',
    1 => 'partnumber_id',
    2 => 'falhas_id',
    3 => 'quantidade',
    4 => 'valor_t',
    5 => 'observacao'
];

// Obter a quantidade de registros no banco de dados
$query_qnt_scrap_pn = "SELECT COUNT(scrap_pn.id) AS qnt_scrap_pn
                       FROM scrap_pn
                       INNER JOIN partnumber ON scrap_pn.partnumber_id = partnumber.id
                       INNER JOIN falhas ON scrap_pn.falhas_id = falhas.id
                       WHERE scrap_pn.scrap_id = :scrap_id";

// Preparar a QUERY para contar os registros
$result_qnt_scrap_pn = $conn->prepare($query_qnt_scrap_pn);
$result_qnt_scrap_pn->bindParam(':scrap_id', $scrap_id, PDO::PARAM_INT);
$result_qnt_scrap_pn->execute();
$row_qnt_scrap_pn = $result_qnt_scrap_pn->fetch(PDO::FETCH_ASSOC);

// Recuperar os registros do banco de dados
$query_scrap_pn = "SELECT scrap_pn.id,
                          partnumber.partnumber AS partnumber_id,
                          falhas.descricao AS falhas_id,
                          scrap_pn.quantidade,
                          scrap_pn.valor_t,
                          scrap_pn.observacao
                   FROM scrap_pn
                   INNER JOIN partnumber ON scrap_pn.partnumber_id = partnumber.id
                   INNER JOIN falhas ON scrap_pn.falhas_id = falhas.id
                   WHERE scrap_pn.scrap_id = :scrap_id";

// Acessa o IF quando há parâmetros de pesquisa
if (!empty($dados_requisicao['search']['value'])) {
    $valor_pesq = "%" . $dados_requisicao['search']['value'] . "%";
    $query_scrap_pn .= " AND (partnumber.partnumber LIKE :search_value
                          OR falhas.descricao LIKE :search_value
                          OR scrap_pn.quantidade LIKE :search_value
                          OR scrap_pn.valor_t LIKE :search_value
                          OR scrap_pn.observacao LIKE :search_value)";
}

// Ordenar os registros
$query_scrap_pn .= " ORDER BY " . $colunas[$dados_requisicao['order'][0]['column']] . " " . $dados_requisicao['order'][0]['dir'] . " LIMIT :inicio, :quantidade";

// Preparar a QUERY para buscar os registros
$result_scrap_pn = $conn->prepare($query_scrap_pn);
$result_scrap_pn->bindParam(':scrap_id', $scrap_id, PDO::PARAM_INT);
$result_scrap_pn->bindParam(':inicio', $dados_requisicao['start'], PDO::PARAM_INT);
$result_scrap_pn->bindParam(':quantidade', $dados_requisicao['length'], PDO::PARAM_INT);

if (!empty($dados_requisicao['search']['value'])) {
    $result_scrap_pn->bindParam(':search_value', $valor_pesq, PDO::PARAM_STR);
}

// Executar a QUERY
$result_scrap_pn->execute();
$dados = [];

// Ler os registros retornados do banco de dados e atribuir no array 
while ($row_scrap_pn = $result_scrap_pn->fetch(PDO::FETCH_ASSOC)) {
    $dados[] = [
        'partnumber_id' => $row_scrap_pn['partnumber_id'],
        'falhas_id' => $row_scrap_pn['falhas_id'],
        'quantidade' => $row_scrap_pn['quantidade'],
        'valor_t' => $row_scrap_pn['valor_t'],
        'observacao' => $row_scrap_pn['observacao'],
        'id' => $row_scrap_pn['id']
    ];
}

// Criar o array de informações a serem retornadas para o JavaScript
$resultado = [
    "draw" => intval($dados_requisicao['draw']),
    "recordsTotal" => intval($row_qnt_scrap_pn['qnt_scrap_pn']),
    "recordsFiltered" => intval($row_qnt_scrap_pn['qnt_scrap_pn']),
    "data" => $dados
];

// Retornar os dados em formato JSON para o JavaScript
echo json_encode($resultado);

?>
