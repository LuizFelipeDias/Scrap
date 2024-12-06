<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Análise Scrap</title>
    <style>

        .card-header {
            font-size: 18px;
            font-weight: bold;
        }

        .table th,
        .table td {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

        body {
            background: linear-gradient(135deg, #969696, #ffffff);
            color: #333;
        }

        .card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .table thead th {
            background-color: #007bff;
            color: white;
        }

        .table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        #listar-scrap td,

        #listar-scrap th {
            text-align: center;
        }

        #listar-detScrap td,

        #listar-detScrap th {
            text-align: center;
        }

        #valorTotal {
            font-weight: bold;
            font-size: 18px;
        }

    </style>
</head>

<?php include 'header.php'; ?>
<?php include 'menu.php'; ?>

<div class='dashboard-app'>
    <header class='dashboard-toolbar'><a class="menu-toggle"><i class="fas fa-bars"></i></a></header>
    <div class='dashboard-content'>
        <div class='container'>

            <p>TOTAL: <span id="valorTotal">0</span></p>

            <div class="row mt-1">
                <div class="col-xl-12 mb-5 mb-xl-0">
                    <div class="card shadow">
                        <div class="card-header border-0 bg-gradient-visteon-barra">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="mb-0">Scraps Cadastrados</h5>
                                </div>
                                <div class="row">
                                    <!-- Botão "Inserir" à esquerda -->
                                        <div class="col-md-4 d-flex justify-content-start">
                                            <button type="button" id="saveDataButton" class="btn btn-success">
                                                <i class="fa-solid fa-plus"></i> Enviar
                                                </button>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="listar-scrap" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="checkbox"></th>
                                        <th scope="col" class="text-center">SERIAL</th>
                                        <th scope="col" class="text-center">AREA</th>
                                        <th scope="col" class="text-center">REINCIDENTE</th>
                                        <th scope="col" class="text-center">CIMCODE</th>
                                        <th scope="col" class="text-center">TOTAL</th>
                                        <th scope="col" class="text-center">USUÁRIO</th>
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

<?php include 'det-calcularScrap.php'; ?>

<script>

    $(document).ready(function () {

        // Inicializa o DataTable
        var table = $('#listar-scrap').DataTable({
            "processing": true,
            "serverSide": true,
            "destroy": true,
            "ajax": {
                "url": "consultas/scrapAnalisar/table.php"
            },
            "columns": [
                {
                    "data": null,
                    "render": function (data, type, row) {
                        return `<input type="checkbox" class="scrap-checkbox" id= "check" data-id="${row.id}" data-total="${row.total}">`;
                    },
                    "orderable": false,
                    "searchable": false
                },
                { "data": "serial" },
                { "data": "area" },
                { "data": "reincidente" },
                { "data": "produto" },
                { "data": "total" },
                { "data": "usuario" },
                { "data": "id", "visible": false }
            ],
            "language": {
                url: 'http://localhost:8080/scrap/assets/js/dataTables-pt-BR.json'
            }
        });

        // Evita abrir o modal ao clicar no checkbox
        $('#listar-scrap tbody').on('click', 'tr', function (e) {
            if ($(e.target).is('input[type="checkbox"]')) {
                return; // Não faz nada se o checkbox for clicado
            }

            // Obtém dados da linha e abre o modal
            var data = table.row(this).data();
            if (data) {
                fetchScrapDetails(data.id);
            }
        });

        // Função para carregar detalhes do scrap
        function fetchScrapDetails(scrapID) {
            $.ajax({
                url: 'consultas/scrap/consultaDetail.php',
                method: 'GET',
                data: { id: scrapID },
                dataType: 'json',
                success: function (response) {
                    if (response.error) {
                        alert(response.error);
                    } else {
                        // Preenche os campos com os dados do scrap
                        $('#serial').text(response.serial);
                        $('#area').val(response.area);
                        $('#turno').val(response.turno);
                        $('#reincidente').val(response.reincidente);
                        $('#produto').val(response.produto);
                        $('#causa').val(response.causa);
                        $('#acao').val(response.acao);
                        $('#data').val(response.data);
                        $('#usuario').val(response.usuario);
                        $('#scrapID').val(scrapID);
                    }
                    $("#modalScrap").modal("show");
                }
            });

            // criando tabela de linha com DataTable
            var detTable = $('#listar-detScrap').DataTable({
                "processing": true,
                "serverSide": true,
                "destroy": true, // Permite recriar o DataTable se ele já estiver inicializado
                "ajax": {
                    "url": "consultas/scrapDet/table.php",
                    "data": function (d) {
                        d.scrapID = scrapID; // Adiciona o parâmetro scrapID na requisição
                    }
                },
                "columns": [
                    { "data": "partnumber_id" },
                    { "data": "falhas_id" },
                    { "data": "quantidade" },
                    { "data": "valor_t" },
                    { "data": "observacao" },
                    { "data": "id", "visible": false } // Oculte a coluna id
                ],
                "language": {
                    url: 'http://localhost:8080/scrap/assets/js/dataTables-pt-BR.json'
                }
            });
        }

       // Seleciona/deseleciona todos os checkboxes
       $('#checkbox').on('change', function () {
            $('.scrap-checkbox').prop('checked', this.checked);
            calcularSoma();
        });

        // Atualiza o total ao marcar/desmarcar checkboxes
        $(document).on('change', '.scrap-checkbox', calcularSoma);

        // Função para calcular o total
        function calcularSoma() {
            let soma = 0;
            $('.scrap-checkbox:checked').each(function () {
                soma += parseFloat($(this).data('total')) || 0; // Pega o valor de total da linha
                id = $(this).data('id'); // Pega o valor de total da linha,
                console.log(id)
            });
            $('#valorTotal').text(soma.toFixed(2)); // Exibe a soma formatada com 2 casas decimais
        }

        $('#saveDataButton').on('click', function() {
            // Obtém os ids selecionados
            var idsSelecionados = [];
            $('.scrap-checkbox:checked').each(function() {
                idsSelecionados.push($(this).data('id'));
            });

            // Verifica se há ids selecionados
            if (idsSelecionados.length > 0) {
                // Envia a requisição para atualizar o status
                $.ajax({
                    url: 'consultas/scrap/updateStatus.php',  // O caminho para o script PHP
                    method: 'POST',
                    data: {
                        ids: idsSelecionados,
                        novoStatus: 3 // Exemplo, altere conforme necessário
                    },
                    success: function(response) {
                        try {
                            // Verifica se a resposta é um objeto JSON válido
                            var jsonResponse = JSON.parse(response);
                            
                            if (jsonResponse.success) {
                                alert('Status atualizado com sucesso!');
                            } else {
                                alert('Erro ao atualizar o status. Tente novamente.');
                            }
                        } catch (e) {
                            // Caso a resposta não seja um JSON válido
                            alert('Erro ao processar a resposta. Tente novamente.');
                        }
                    },
                    error: function() {
                        alert('Erro de comunicação. Tente novamente.');
                    }
                });
            } else {
                alert('Nenhum item selecionado.');
            }
        });


    });

</script>

<?php include 'footer.php'; ?>
