<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modelos</title>

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

        .table-status-3 {
            background-color: #d4edda;
        }

        
        #listar-modelos td, #listar-modelos th {
            text-align: center;
            vertical-align: middle;
        }


    </style>
    
</head>

<?php include 'header.php'; ?>
<?php include 'menu.php'; ?>

<div class='dashboard-app'>
    <header class='dashboard-toolbar'><a class="menu-toggle"><i class="fas fa-bars"></i></a></header>
    <div class='dashboard-content'>
        <div class='container'>
            <div class='card'>
                <div class='card-header'>
                    <h5>Adicionar Modelo</h5>
                </div>
                <div class='card-body'>
                    <div class="row">
                        <div class='col-md-4'>
                            <div class="form-group">
                                <label for="">Adicionar Descrição</label>
                                <input type="text" id="descricaoInput" class="form-control"
                                    placeholder="Insira a descrição">
                            </div>

                        </div>

                        <div class='col-md-4'>
                            <div class="form-group">
                                <label for="">Adicionar Cliente</label>
                                <select id="selectCliente" placeholder="Selecione um Cliente"></select>

                            </div>
                        </div>


                    </div>
                    <br>
                    <div class="row">
                        <div class='col-md-4'>
                            <button type="button" id="saveDataButton" class="btn btn-success">
                                <i class="fa-solid fa-plus"></i> Inserir
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <br>

            <!-- Tabela de Modelos Cadastrados -->
            <div class="row mt-1">
                <div class="col-xl-12 mb-5 mb-xl-0">
                    <div class="card shadow">
                        <div class="card-header border-0 bg-gradient-visteon-barra">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="mb-0">Modelos Cadastrados</h5>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="listar-modelos" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center" id="descricao">DESCRIÇÃO</th>
                                        <th scope="col" class="text-center" id="cliente">CLIENTE</th>
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


</div>



<?php include 'detalhe-produto.php'; ?>


<script>

    $(document).ready(function () {

        // Inicializar o Selectize Cliente
        var selectCliente = $('#selectCliente').selectize({
            maxItems: 1,
            valueField: 'id',
            labelField: 'title',
            searchField: 'title',
            options: [],
            create: false,
            load: function (query, callback) {
                $.ajax({
                    url: 'consultas/cliente/selectCliente.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        q: query
                    },
                    error: function () {
                        callback();
                    },
                    success: function (res) {
                        selectCliente[0].selectize.clearOptions();
                        selectCliente[0].selectize.addOption(res.options || []);
                        selectCliente[0].selectize.refreshOptions(false);
                    }
                });
            }
        });


        // Carregar as opções quando a página é carregada
        $.ajax({
            url: 'consultas/cliente/selectCliente.php',
            type: 'GET',
            dataType: 'json',
            success: function (res) {
                selectCliente[0].selectize.addOption(res.options || []);
                selectCliente[0].selectize.refreshOptions(false);
            }
        });

        // criando tabela de linha com Datatable
        var table = $('#listar-modelos').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "consultas/modelos/table.php",
            language: {
                url: 'http://localhost:8080/scrap/assets/js/dataTables-pt-BR.json',
            },
        });
    });

    document.getElementById('saveDataButton').addEventListener('click', function () {
        const button = this;
        button.disabled = true; // Desativa o botão para evitar múltiplos cliques
        const descricao = document.getElementById('descricaoInput').value.trim();
        const cliente = document.getElementById('selectCliente').value.trim();

        if (descricao === "" || cliente === "") {
            alertify.error('Por favor, preencha todos os campos antes de inserir!');
            button.disabled = false; // Reativa o botão
            return;
        }

        fetch('consultas/modelos/insert.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                'descricao': descricao,
                'cliente_id': cliente,
            })
        })
            .then(response => {
                button.disabled = false; // Reativa o botão
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alertify.success(data.message); // Mostra a mensagem de sucesso
                    // Limpa os campos de entrada
                    document.getElementById('descricaoInput').value = '';
                    document.getElementById('selectCliente').value = '';
                    // Atualiza as tabelas
                    updateTables();
                } else {
                    alertify.error(data.message); // Mostra a mensagem de erro
                }
            })
            .catch(error => {
                button.disabled = false; // Reativa o botão
                console.error('Erro:', error);
                // alertify.error('Erro ao salvar os dados!');
            });
    });


</script>
<?php include 'footer.php'; ?>