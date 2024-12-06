<?php

// Incluir a conexao com o banco de dados
include_once '../../conexao/conexaoPDO.php';

// Receber os dados da requisição
$dados_requisicao = $_REQUEST;

// Lista de colunas da tabela
$colunas = [
    0 => 'id',
    1 => 'serial',
    2 => 'area',
    3 => 'reincidente',
    4 => 'produto_id',
    5 => 'engenheiro',
    6 => 'coordenador'
];

// Definir a base da consulta
$query_scrap = "SELECT 
    scrap.id,
    scrap.serial,
    ELT(scrap.area, 'SMD', 'FA') AS area,
    ELT(scrap.reincidente, 'Sim', 'Não') AS reincidente,
    ELT(scrap.turno, 'COMERCIAL', 'ESPECIAL') AS turno,
    (SELECT produto.cimcode FROM produto WHERE produto.id = scrap.produto_id LIMIT 1) AS produto_id,
    -- Aqui o CASE para o engenheiro
    CASE 
        WHEN scrap.engenheiro_id IS NULL THEN 'Aguardando Aprovação'
        ELSE 'Aprovado'
    END AS engenheiro_status,
    (SELECT usuario.nome FROM usuario WHERE usuario.id = scrap.engenheiro_id LIMIT 1) AS engenheiro,
    -- Aqui o CASE para o coordenador
    CASE 
        WHEN scrap.coordenador_id IS NULL THEN 'Aguardando Aprovação'
        ELSE 'Aprovado'
    END AS coordenador_status
FROM scrap
WHERE scrap.status = 0 ";

// Adicionar filtro de pesquisa, caso exista
if (!empty($dados_requisicao['search']['value'])) {
    $searchValue = "%" . $dados_requisicao['search']['value'] . "%";
    $query_scrap .= " 
        OR scrap.serial LIKE :searchValue 
        OR scrap.area LIKE :searchValue 
        OR scrap.reincidente LIKE :searchValue 
        OR scrap.turno LIKE :searchValue
        OR (SELECT produto.cimcode FROM produto WHERE produto.id = scrap.produto_id) LIKE :searchValue
        OR (SELECT usuario.nome FROM usuario WHERE usuario.id = scrap.engenheiro_id) LIKE :searchValue
        OR (SELECT usuario.nome FROM usuario WHERE usuario.id = scrap.coordenador_id) LIKE :searchValue";
}

// Ordenar os registros
$orderColumnIndex = $dados_requisicao['order'][0]['column']; // Índice da coluna de ordenação
$orderDir = $dados_requisicao['order'][0]['dir']; // Direção da ordenação (ASC ou DESC)
$query_scrap .= " ORDER BY " . $colunas[$orderColumnIndex] . " " . $orderDir;

// Limitar a quantidade de registros a serem retornados
$query_scrap .= " LIMIT :inicio, :quantidade";

// Preparar a QUERY para buscar os registros
$result_scrap = $conn->prepare($query_scrap);
$result_scrap->bindParam(':inicio', $dados_requisicao['start'], PDO::PARAM_INT);
$result_scrap->bindParam(':quantidade', $dados_requisicao['length'], PDO::PARAM_INT);

// Acessa o IF quando há parâmetros de pesquisa   
if (!empty($dados_requisicao['search']['value'])) {
    $result_scrap->bindParam(':searchValue', $searchValue, PDO::PARAM_STR);
}

// Executar a QUERY para buscar os registros
$result_scrap->execute();
$dados = [];

// Recuperar os registros e adicionar no array
// Recuperar os registros e adicionar no array
while ($row_scrap = $result_scrap->fetch(PDO::FETCH_ASSOC)) {
    $dados[] = [
        'id' => $row_scrap['id'],
        'serial' => $row_scrap['serial'],
        'area' => $row_scrap['area'],
        'reincidente' => $row_scrap['reincidente'],
        'turno' => $row_scrap['turno'],
        'engenheiro_status' => $row_scrap['engenheiro_status'],
        'produto_id' => $row_scrap['produto_id'],
        'coordenador_status' => $row_scrap['coordenador_status'],
        'engenheiro' => $row_scrap['engenheiro'],
        // Verificar se o coordenador está presente
        'coordenador' => $row_scrap['coordenador'] ?? 'Não atribuído' // Caso coordenador seja null, exibe "Não atribuído"
    ];
}


// Obter a quantidade total de registros sem filtros (para o total de registros)
$query_qnt_scrap = "SELECT COUNT(id) AS qnt_scrap FROM scrap";
$result_qnt_scrap = $conn->prepare($query_qnt_scrap);
$result_qnt_scrap->execute();
$row_qnt_scrap = $result_qnt_scrap->fetch(PDO::FETCH_ASSOC);

// Criar o array de informações a serem retornadas para o Javascript
$resultado = [
    "draw" => intval($dados_requisicao['draw']), // Para cada requisição é enviado um número como parâmetro
    "recordsTotal" => intval($row_qnt_scrap['qnt_scrap']), // Quantidade total de registros no banco de dados
    "recordsFiltered" => intval($row_qnt_scrap['qnt_scrap']), // Total de registros após o filtro (se houver)
    "data" => $dados // Array com os dados retornados da tabela scrap
];

// Retornar os dados em formato de objeto para o JavaScript
echo json_encode($resultado);

?>
