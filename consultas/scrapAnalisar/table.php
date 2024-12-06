<?php
// Incluir a conexão com o banco de dados
include_once '../../conexao/conexaoPDO.php';

// Receber os dados da requisição
$dados_requisicao = $_REQUEST;

// Lista de colunas da tabela
$colunas = [
    0 => 'id',
    1 => 'serial',
    2 => 'reincidente',
    3 => 'area',
    4 => 'valor_t',
    5 => 'usuario_id',
];

// Obter a quantidade de registros no banco de dados
$query_qnt_scrap_analise = "SELECT COUNT(sc.id) AS qnt_scrap_analise FROM scrap sc WHERE sc.status = 2";

// Adicionar condição de pesquisa
if (!empty($dados_requisicao['search']['value'])) {
    $query_qnt_scrap_analise .= " AND (sc.serial LIKE :serial
                     OR ELT(sc.reincidente, 'SIM', 'NÃO') LIKE :reincidente
                     OR ELT(sc.area, 'SMD', 'FA') LIKE :area
                     OR (SELECT cimcode FROM produto WHERE produto.id = sc.produto_id) LIKE :produto
                     OR (SELECT SUM(sp.valor_t) FROM scrap_pn sp WHERE sp.scrap_id = sc.id) LIKE :total
                     OR (SELECT nome FROM usuario WHERE usuario.id = sc.usuario_id) LIKE :usuario)";
}

// Preparar a QUERY para contar os registros
$result_qnt_scrap_analise = $conn->prepare($query_qnt_scrap_analise);

// Associar os parâmetros de pesquisa
if (!empty($dados_requisicao['search']['value'])) {
    $valor_pesq = "%" . $dados_requisicao['search']['value'] . "%";
    $result_qnt_scrap_analise->bindParam(':serial', $valor_pesq, PDO::PARAM_STR);
    $result_qnt_scrap_analise->bindParam(':reincidente', $valor_pesq, PDO::PARAM_STR);
    $result_qnt_scrap_analise->bindParam(':area', $valor_pesq, PDO::PARAM_STR);
    $result_qnt_scrap_analise->bindParam(':produto', $valor_pesq, PDO::PARAM_STR);
    $result_qnt_scrap_analise->bindParam(':total', $valor_pesq, PDO::PARAM_STR);
    $result_qnt_scrap_analise->bindParam(':usuario', $valor_pesq, PDO::PARAM_STR);
}

// Executar a QUERY para contar os registros
$result_qnt_scrap_analise->execute();
$row_qnt_scrap_analise = $result_qnt_scrap_analise->fetch(PDO::FETCH_ASSOC);

// Recuperar os registros do banco de dados
$query_scrap_analise = "SELECT 
                            sc.id,
                            sc.serial,
                            ELT(sc.reincidente, 'SIM', 'NÃO') AS reincidente,
                            ELT(sc.area, 'SMD', 'FA') AS area,
                            (SELECT cimcode FROM produto WHERE produto.id = sc.produto_id) AS produto,
                            (SELECT nome FROM usuario WHERE usuario.id = sc.usuario_id) AS usuario,
                            (
                                SELECT SUM(sp.valor_t) 
                                FROM scrap_pn sp 
                                WHERE sp.scrap_id = sc.id
                            ) AS total
                        FROM scrap sc WHERE sc.status = 2";

// Adicionar condição de pesquisa
if (!empty($dados_requisicao['search']['value'])) {
    $query_scrap_analise .= " AND (sc.serial LIKE :serial
                     OR ELT(sc.reincidente, 'SIM', 'NÃO') LIKE :reincidente
                     OR ELT(sc.area, 'SMD', 'FA') LIKE :area
                     OR (SELECT cimcode FROM produto WHERE produto.id = sc.produto_id) LIKE :produto
                     OR (SELECT SUM(sp.valor_t) FROM scrap_pn sp WHERE sp.scrap_id = sc.id) LIKE :total
                     OR (SELECT nome FROM usuario WHERE usuario.id = sc.usuario_id) LIKE :usuario)";
}

// Ordenar os registros
$query_scrap_analise .= " ORDER BY " . $colunas[$dados_requisicao['order'][0]['column']] . " " . $dados_requisicao['order'][0]['dir'] . " LIMIT :inicio , :quantidade";

// Preparar a QUERY para buscar os registros
$result_scrap_analise = $conn->prepare($query_scrap_analise);

// Associar os parâmetros de ordenação e limite
$result_scrap_analise->bindParam(':inicio', $dados_requisicao['start'], PDO::PARAM_INT);
$result_scrap_analise->bindParam(':quantidade', $dados_requisicao['length'], PDO::PARAM_INT);

// Associar os parâmetros de pesquisa
if (!empty($dados_requisicao['search']['value'])) {
    $valor_pesq = "%" . $dados_requisicao['search']['value'] . "%";
    $result_scrap_analise->bindParam(':serial', $valor_pesq, PDO::PARAM_STR);
    $result_scrap_analise->bindParam(':reincidente', $valor_pesq, PDO::PARAM_STR);
    $result_scrap_analise->bindParam(':area', $valor_pesq, PDO::PARAM_STR);
    $result_scrap_analise->bindParam(':produto', $valor_pesq, PDO::PARAM_STR);
    $result_scrap_analise->bindParam(':total', $valor_pesq, PDO::PARAM_STR);
    $result_scrap_analise->bindParam(':usuario', $valor_pesq, PDO::PARAM_STR);
}

// Executar a QUERY
$result_scrap_analise->execute();
$dados = [];

// Ler os registros retornados do banco de dados e atribuir no array
while ($row_scrap_analise = $result_scrap_analise->fetch(PDO::FETCH_ASSOC)) {
    $dados[] = [
        'serial' => $row_scrap_analise['serial'],
        'reincidente' => $row_scrap_analise['reincidente'],
        'area' => $row_scrap_analise['area'],
        'produto' => $row_scrap_analise['produto'],
        'total' => $row_scrap_analise['total'],
        'usuario' => $row_scrap_analise['usuario'],
        'id' => $row_scrap_analise['id']
    ];
}

// Criar o array de informações a serem retornadas para o Javascript
$resultado = [
    "draw" => intval($dados_requisicao['draw']), // Para cada requisição é enviado um número como parâmetro
    "recordsTotal" => intval($row_qnt_scrap_analise['qnt_scrap_analise']), // Quantidade de registros que há no banco de dados
    "recordsFiltered" => intval($row_qnt_scrap_analise['qnt_scrap_analise']), // Total de registros quando houver pesquisa
    "data" => $dados // Array de dados com os registros retornados da tabela scrap
];

// Retornar os dados em formato de objeto para o JavaScript
echo json_encode($resultado);

?>
