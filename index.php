<?php
// Inicia a sessão
session_start();
include 'conexao/db.php';

// Obter a página solicitada da URL. Se não for especificada, carregar 'home'.
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Verifica se o usuário está logado
if (!isset($_SESSION['user'])) {
    // Redireciona para a página de login
    header('Location: index.php?page=login');
    exit();
}

// Obter informações do usuário logado
$user = $_SESSION['user'];

// Função para verificar permissão de acesso
function verificarPermissao($pagina, $user) {
    // Defina as permissões para cada página
    $permissoes = [
        'criarUsuario' => ['1','2','3','4'],
        'aprovacao' => ['1','2','3'],
        'detalheAprovacao' => ['1','2','3'],
        'clientes' => ['1','2','3'],
        'linhas' => ['1','2','3'],
        'falhas' => ['1','2','3'],
        'produtos' => ['1','2','3'],
        'partnumber' => ['1', '2','3'],
        'modelos' => ['1','2','3'],
        'adicionarScrap' => ['1','2','3'],
        'detalheScrap' => ['1','2','3'],
        'calcularScrap' => ['1','2','3'],
        'analisarScrap' => ['1','2','3'],
    ];

    // Verifica se a página tem restrições e se o tipo de usuário tem permissão
    if (isset($permissoes[$pagina])) {
        return in_array($user['tipo_usuario'], $permissoes[$pagina]);
    }

    // Caso a página não tenha restrições, permitir o acesso
    return true;
}

// Verifica se o usuário tem permissão para acessar a página
if (!verificarPermissao($page, $user)) {
    // Redireciona para a página de restrição
    header('Location: index.php?page=restricao');
    exit();
}

// Inclui a página correspondente com base no valor de $page
switch ($page) {
    case 'login':
        include 'src/auth/login.php';
        break;
    case 'criarUsuario':
        include 'src/auth/criarUsuario.php';
        break;
    case 'aprovacao':
        include 'src/aprovacao/aprovacao.php';
        break;
    case 'detalheAprovacao':
        include 'src/aprovacao/detalheAprovacao.php';
        break;
    case 'dashboard':
        include 'dashboard.php';
        break;
    case 'clientes':
        include 'src/cliente/clientes.php';
        break;
    case 'linhas':
        include 'src/linhas/linhas.php';
        break;
    case 'falhas':
        include 'src/falha/falhas.php';
        break;
    case 'produtos':
        include 'src/produto/produtos.php';
        break;
    case 'partnumber':
        include 'src/partnumber/partnumber.php';
        break;
    case 'modelos':
        include 'src/modelos/modelos.php';
        break;
    case 'adicionarScrap':
        include 'src/adicionarScrap/adicionarScrap.php';
        break;
    case 'detalheScrap':
        include 'src/adicionarScrap/detalheScrap.php';
        break;
    case 'calcularScrap':
        include 'src/adicionarScrap/calcularScrap.php';
        break;
    case 'analisarScrap':
        include 'src/adicionarScrap/analisarScrap.php';
        break;
    case 'restricao':
        include 'src/restricao/restricao.php';
        break;
    case 'logout':
        include 'src/auth/logout.php';
        break;
    default:
        include 'home.php';
        break;
}
?>
