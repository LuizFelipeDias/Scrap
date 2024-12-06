<?php 
    // Verifica se a sessão não está ativa antes de iniciar
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>
    

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aprovação Scrap</title>

    <style>
        .card-header {
            font-size: 18px;
            /* Tamanho da fonte da cabeçalho */
            font-weight: bold;
        }

        .table th,
        .table td {
            font-size: 18px;
            /* Tamanho da fonte da tabela */
            font-weight: bold;
            align-content: center;
        }

        .table td {
            font-size: 18px;
            /* Tamanho da fonte do conteúdo da tabela */
            font-weight: bold;
        }

        body {
            background: linear-gradient(135deg, #969696, #ffffff);
            /* Gradiente de laranja */
            color: #333;
        }

        .card {
            background: rgba(255, 255, 255, 0.9);
            /* Fundo das cartas com leve transparência */
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #007bff;
            /* Azul padrão */
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            /* Azul mais escuro no hover */
        }

        .table thead th {
            background-color: #007bff;
            /* Azul para o cabeçalho da tabela */
            color: white;
        }

        .table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.2);
            /* Efeito de hover nas linhas da tabela */
        }

        /* Cores de status */
        .cancelada {
            background: linear-gradient(to bottom, white, #ff3838);
            /* Amarelo suave */
        }

        /* Cores de status */
        .table-status-2 {
            background: linear-gradient(to bottom, white, #f9e261);
            /* Amarelo suave */
        }

        .table-status-3 {
            background-color: #d4edda;
            /* Verde suave */
        }

        .btn-aprovar {
            float: right;
            /* Alinha o botão à direita */
            margin-top: 10px;
            /* Adiciona um pequeno espaçamento superior */
        }


        .table-status-3 {
            background-color: #d4edda;
        }

        #listar-scrap td,
        #listar-scrap th {
            text-align: center;
        }
    </style>
</head>

<?php include 'header.php'; ?>
<?php include 'menu.php'; ?>



<div class='dashboard-app'>
    <header class='dashboard-toolbar'><a class="menu-toggle"><i class="fas fa-bars"></i></a></header>
    <div class='dashboard-content'>
        <div class='container'>
            <!-- Primeiro Card -->
            <div class='card mb-4'>
                <!-- Classe 'mb-4' adiciona um espaçamento entre os cards -->
                <div class='card-header'>
                    <h5>SCRAP: <b id="serial"></b></h5>
                </div>

                <div class='card-body'>
                    <div class="row">
                        <div class='col-md-3'>
                            <div class="form-group">
                                <label for="">Area</label>
                                <input type="text" id="area" class="form-control" disabled>
                                <input type="hidden" id="produto_id">
                            </div>
                        </div>

                        <div class='col-md-2'>
                            <div class="form-group">
                                <label for="">Reincidente</label>
                                <input type="text" id="reincidente" class="form-control" disabled>
                            </div>
                        </div>

                        <div class='col-md-2'>
                            <div class="form-group">
                                <label for="">Turno</label>
                                <input type="text" id="turno" class="form-control" disabled>
                            </div>
                        </div>

                        <div class='col-md-2'>
                            <div class="form-group">
                                <label for="">Produto</label>
                                <input type="text" id="produto" class="form-control" disabled>
                            </div>
                        </div>

                        <div class='col-md-3'>
                            <div class="form-group">
                                <label for="">Modelo</label>
                                <input type="text" id="modelo" class="form-control" disabled>
                            </div>

                        </div>

                    </div>
                    <div class="row">
                        <div class='col-md-6'>
                            <div class="form-group">
                                <label for="">Plano de Ação</label>
                                <textarea type="text" id="acao" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class='col-md-3'>
                            <div class="form-group">
                                <label for="">Responsável</label>
                                <input type="text" id="responsavel" class="form-control" >
                            </div>
                        </div>
                        <div class='col-md-3'>
                            <div class="form-group">
                                <label for="">Prazo</label>
                                <input type="date" id="prazo" class="form-control" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class='col-md-2'>
                            
                            <button id="aprovar" type="submit" class="btn btn-outline-success btn-aprovar">
                                <i class="bi bi-floppy"></i> Aprovar scrap
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row mt-1">
                <div class="col-xl-12 mb-5 mb-xl-0">
                    <div class="card shadow">
                        <div class="card-header border-0 bg-gradient-visteon-barra">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="mb-0">Scraps Cadastrados</h5>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="listar-scrap" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center" id="part">PARTNUMBER</th>
                                        <th scope="col" class="text-center" id="fal">FALHA</th>
                                        <th scope="col" class="text-center" id="quant">QUANTIDADE</th>
                                        <th scope="col" class="text-center" id="vt">VALOR TOTAL</th>
                                        <th scope="col" class="text-center" id="obs">OBSERVAÇÃO</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>



<script>
    $(document).ready(function () {
        // Função para obter o ID da URL
        function getScrapIdFromUrl() {
            const params = new URLSearchParams(window.location.search);
            return params.get('id');
        }

        // Captura o ID do scrap
        const scrapID = getScrapIdFromUrl();

        if (scrapID) {
            // Faz a requisição AJAX para obter os detalhes do scrap
            $.ajax({
                url: 'consultas/aprovacao/consultaDetail.php',
                method: 'GET',
                data: {
                    id: scrapID
                },
                dataType: 'json',
                success: function (response) {
                    if (response.error) {
                        alert(response
                            .error); // Exibe uma mensagem de erro se o scrap não for encontrado
                    } else {
                        // Preenche os campos com os dados do scrap
                        $('#serial').text(response.serial);
                        $('#area').val(response.area);
                        $('#reincidente').val(response.reincidente);
                        $('#turno').val(response.turno);
                        $('#acao').val(response.acao);
                        $('#modelo').val(response.modelo);
                        $('#produto').val(response.produto);
                        // Supondo que response.prazo seja uma string no formato 'dd-mm-yyyy'
                        var prazo = response.prazo;

                        // Converter o formato 'dd-mm-yyyy' para 'yyyy-mm-dd'
                        var partes = prazo.split('-');
                        var prazoFormatado = partes[2] + '-' + partes[1] + '-' + partes[0];

                        // Preencher o campo de data com o valor formatado
                        $('#prazo').val(prazoFormatado);
                        $('#responsavel').val(response.responsavel);
                        // $('#produto').val(response.produto);
                        $('#produto_id').val(response.produto_id);

                        // Somente agora inicializamos o selectize com as opções do produto_id
                        // carregarPartnumbers(response.produto_id);
                    }
                },
                error: function () {
                    alert("Erro ao buscar os detalhes do scrap.");
                }
            });
        } else {
            alert("ID do scrap não especificado na URL.");
        }

        $(document).ready(function () {
            // criando tabela de linha com DataTable
            var table = $('#listar-scrap').DataTable({
                "processing": true,
                "serverSide": true,
                "destroy": true, // Permite recriar o DataTable se ele já estiver inicializado
                "ajax": {
                    "url": "consultas/scrapDet/table.php",
                    "data": function (d) {
                        d.scrapID = scrapID; // Adiciona o parâmetro scrapID na requisição
                    }
                },
                "columns": [{
                        "data": "partnumber_id"
                    },
                    {
                        "data": "falhas_id"
                    },
                    {
                        "data": "quantidade"
                    },
                    {
                        "data": "valor_t"
                    },
                    {
                        "data": "observacao"
                    },
                    {
                        "data": "id",
                        "visible": false
                    } // Oculte a coluna id
                ],
                "language": {
                    url: 'http://localhost:8080/scrap/assets/js/dataTables-pt-BR.json'
                }
            });
        });
        $(document).on('click', '#aprovar', function (e) {
            e.preventDefault(); // Evita o comportamento padrão do botão (se for submit)

            const id_scrap = scrapID;
            $.getJSON('consultas/aprovacao/confirmacao.php', {
                id_scrap: id_scrap, // Envia o ID do scrap
                acao: $('#acao').val(),
                prazo: $('#prazo').val(),
                responsavel: $('#responsavel').val(),
                ajax: 'true'
            }, function (j) {
                // Verifica se a resposta tem o status de sucesso
                if (j.status === 'sucesso') {
                    alertify.success(j.message);  // Exibe a mensagem de sucesso da resposta
                    updateTables(); // Atualiza as tabelas após a aprovação
                } else {
                    alertify.error(j.message);  // Exibe a mensagem de erro da resposta
                }
            }).fail(function () {
                alertify.error('Erro na aprovação do scrap!');
            });

                const $button = $(this); // Salva o botão clicado no contexto jQuery

                // Desabilita o botão para evitar múltiplos cliques
                $button.prop('disabled', true);

                // Reabilita o botão após 10 segundos
                setTimeout(() => {
                    $button.prop('disabled', false);
                }, 10000); // 10 segundos
        });
    });
</script>

<?php include 'footer.php'; ?>