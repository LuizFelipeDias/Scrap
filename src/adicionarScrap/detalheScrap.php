<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    // Destrói a sessão e redireciona para login.php
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}

include 'conexao/db.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhe Scrap</title>

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
                        <div class='col-md-2'>
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

                        <div class='col-md-2'>
                            <div class="form-group">
                                <label for="">Modelo</label>
                                <input type="text" id="modelo" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Segundo Card -->
            <div class='card' id="card_partnumber">
                <div class='card-header'>
                    <h5>Adicionar Partnumber</h5>
                </div>

                <div class='card-body'>
                    <div class="row">
                        <div class='col-md-3'>
                            <div class="form-group">
                                <label for="">Selecionar Partnumber</label>
                                <select id="selectPartnumber" placeholder="Selecione o partnumber"></select>
                                <input type="hidden" id="valor_unit_hidden">
                            </div>
                        </div>

                        <div class='col-md-3'>
                            <div class="form-group">
                                <label for="">Selecionar Falhas</label>
                                <select id="selectFalhas" placeholder="Selecione uma falha"></select>
                            </div>
                        </div>

                        <div class='col-md-3'>
                            <div class="form-group">
                                <label for="">Quantidade</label>
                                <input type="number" id="quantidade" class="form-control">
                            </div>
                        </div>

                        <div class='col-md-3'>
                            <div class="form-group">
                                <label for="">Valor Total</label>
                                <input type="text" id="total" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        

                        <div class='col-md-6'>
                            <div class="form-group">
                                <label for="">Descricao</label>
                                <input type="text" id="descricao" class="form-control" disabled>
                            </div>
                        </div>

                        <div class='col-md-6'>
                            <div class="form-group">
                                <label for="">Observação</label>
                                <textarea id="observacao" class="form-control" name="story" rows="5" cols="33">
                                </textarea>
                            </div>
                        </div>

                        <input type="hidden" id="produto_id">

                    </div>

                    <br>
                    
                    <div class="row">
                        <!-- Botão "Inserir" à esquerda -->
                        <div class="col-md-4 d-flex justify-content-start">
                            <button type="button" id="saveDataButton" class="btn btn-success">
                                <i class="fa-solid fa-plus"></i> Inserir
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

<?php include 'det-detalheScrap.php'; ?>

<script>
    
    $(document).ready(function () {

        function updateTables() {
        // Supondo que você esteja utilizando DataTables
            $('#listar-scrap').DataTable().ajax.reload(); // Recarrega os dados da tabela
        }
        
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
                url: 'consultas/scrap/consultaDetail.php',
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
                        $('#produto').val(response.produto);
                        $('#produto_id').val(response.produto_id);
                        $('#modelo').val(response.modelo);
                        
                        if(response.status == 1){
                            $('#card_partnumber').hide();
                        }
                        // Somente agora inicializamos o selectize com as opções do produto_id
                        carregarPartnumbers();
                    }
                },
                error: function () {
                    alert("Erro ao buscar os detalhes do scrap.");
                }
            });
            
        } else {
            alert("ID do scrap não especificado na URL.");
        }

        // Função para calcular o valor total com precisão de uma casa decimal
        function calcularTotal() {
            const valorUnitario = parseFloat($('#valor_unit_hidden').val().replace(',', '.')) || 0;
            const quantidade = parseFloat($('#quantidade').val().replace(',', '.')) || 0;

            // Multiplica e converte para uma precisão de uma casa decimal
            const total = (valorUnitario * quantidade).toFixed(1);

            // Define o valor no campo total sem substituir o ponto por vírgula
            $('#total').val(total); // Mantém o ponto como separador decimal
        }


        // Adiciona o evento de mudança no campo quantidade
        $('#quantidade').on('input', calcularTotal);

        // Adiciona o evento de mudança no campo selectPartnumber para recalcular o total
        $('#selectPartnumber').on('change', calcularTotal);

        // Função para carregar o selectPartnumber com base no produto_id
        var selectPartnumber = $('#selectPartnumber').selectize({
            maxItems: 1,
            valueField: 'id',
            labelField: 'title',
            searchField: 'title',
            options: [],
            create: false,
            load: function (query, callback) {
                // if (!produto_id) {
                //     callback();
                //     return;
                // }

                $.ajax({
                    url: 'consultas/scrap/selectPartProd.php',
                    type: 'POST',
                    dataType: 'json',
                    // data: {
                    //     produto_id: produto_id // Passa o ID do produto selecionado
                    // },
                    error: function () {
                        callback();
                    },
                    success: function (res) {
                        console.log(res);
                        selectPartnumber[0].selectize.clearOptions();
                        selectPartnumber[0].selectize.addOption(res.options || []);
                        selectPartnumber[0].selectize.refreshOptions(false);
                    }
                });
            },
            onChange: function (value) {
                // Limpa o input hidden existente, caso já tenha um
                // Busca a opção selecionada para obter o valor_unit
                var selectedOption = selectPartnumber[0].selectize.options[value];
                if (selectedOption) {
                    // Atualiza o valor do input hidden existente
                    $('#valor_unit_hidden').val(selectedOption.valor_unit);
                    $('#descricao').val(selectedOption.descricao);
                } else {
                    // Limpa o valor do input hidden caso nenhuma opção esteja selecionada
                    $('#valor_unit_hidden').val('');
                    $('#descricao').val('');
                }
            }
        });
        var selectFalhas = $('#selectFalhas').selectize({
            maxItems: 1,
            valueField: 'id',
            labelField: 'title',
            searchField: 'title',
            options: [],
            create: false,
            load: function (query, callback) {
                // if (!produto_id) {
                //     callback();
                //     return;
                // }

                $.ajax({
                    url: 'consultas/falhas/selectFalhas.php',
                    type: 'POST',
                    dataType: 'json',
                    error: function () {
                        callback();
                    },
                    success: function (res) {
                        selectFalhas[0].selectize.clearOptions();
                        selectFalhas[0].selectize.addOption(res.options || []);
                        selectFalhas[0].selectize.refreshOptions(false);
                    }
                });
            }
        });
        $.ajax({
            url: 'consultas/scrap/selectPartProd.php',
            type: 'GET',
            dataType: 'json',
            // data: {
            //     produto_id: produto_id
            // },
            success: function (res) {
                selectPartnumber[0].selectize.addOption(res.options || []);
                selectPartnumber[0].selectize.refreshOptions(false);
            }
        });
        $.ajax({
            url: 'consultas/falhas/selectFalhas.php',
            type: 'GET',
            dataType: 'json',
            success: function (res) {
                selectFalhas[0].selectize.addOption(res.options || []);
                selectFalhas[0].selectize.refreshOptions(false);
            }
        });
        function carregarPartnumbers() {

            // Carregar as opções ao inicializar o selectize, caso o produto_id já esteja definido
            if (produto_id) {
            }
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

            $('#listar-scrap tbody').on('click', 'tr', function () {
                var data = table.row(this).data(); // Obtém os dados da linha clicada
                var scrapID = data.id; // Supondo que 'id' é o campo que contém o ID do scrap
                
                // Exibe o modal
                $("#modalDet").modal("show");

                $.ajax({
                    url: 'consultas/scrapDet/consultaDetail.php',
                    type: 'post',
                    dataType: 'json',
                    data: {
                        id: scrapID // Passa o scrapID para a requisição AJAX
                    },
                    success: function (dados) {
                        $("#id_partnumber").val(dados.id);
                        $("#partnumber_d").val(dados.partnumber);
                        $("#falha_d").val(dados.falhas);
                        $("#valor_d").val(dados.valor_t);
                        $("#quantidade_d").val(dados.quantidade);
                        $("#observacao_d").val(dados.observacao);
                    },
                    error: function () {
                        // Caso ocorra erro, limpa os campos
                        $("#partnumber_d").val('');
                        $("#falha_d").val('');
                        $("#valor_d").val('');
                        $("#quantidade_d").val('');
                        $("#observacao_d").val('');
                    }
                })
            });

            // Ação de excluir
            $(document).on('click', '.excluirPartnumber', function (e) {
                e.preventDefault();
                const id = $("#id_partnumber").val(); // Captura o ID do partnumber a ser excluído

                alertify.confirm("Excluir", "Deseja excluir este registro?", function () {
                    $.ajax({
                        url: 'consultas/scrapDet/delete.php',
                        type: 'POST',
                        data: {
                            id: id
                        },
                        success: function () {
                            alertify.success('Excluído com sucesso!');
                            $("#modalDet").modal("hide"); // Fechar o modal
                            updateTables();
                        },
                        error: function () {
                            alertify.error('Erro ao excluir!');
                        }
                    });
                }, function () {
                    alertify.error('Exclusão cancelada!');
                });
                updateTables();
            });
        });
            

        document.getElementById('saveDataButton').addEventListener('click', function () {
            

            const scrap_id = scrapID;
            const partnumber = document.getElementById('selectPartnumber').value.trim();
            const falhas = document.getElementById('selectFalhas').value.trim();
            const quantidade = document.getElementById('quantidade').value.trim();
            const valor_t = document.getElementById('total').value.trim();
            const observacao = document.getElementById('observacao').value.trim();
    
            
    
            if (partnumber === "" || falhas === "" || quantidade === "" || valor_t === "" || observacao === "") {
                alertify.error('Por favor, preencha todos os campos antes de inserir!');
            } else {
                fetch('consultas/scrapDet/insert.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: new URLSearchParams({
                            'scrap': scrap_id,
                            'partnumber': partnumber,
                            'falhas': falhas,
                            'quantidade': quantidade,
                            'valor_t': valor_t,
                            'observacao': observacao,
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alertify.success(data.message); // Mostra a mensagem de sucesso
                            // Limpa os campos de entrada
                            document.getElementById('partnumber_id').value = '';
                            document.getElementById('falha').value = '';
                            document.getElementById('quantidade').value = '';
                            document.getElementById('total').value = '';
                            document.getElementById('quantidade').value = '';
                            document.getElementById('observacao').value = '';
                        // Atualiza as tabelas
                        updateTables(); // Chama a função para atualizar as tabelas após inserção
                        } else {
                            alertify.error(data.message); // Mostra a mensagem de erro
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        // alertify.error('Erro ao salvar os dados!');
                    });
            }
        });
    })
</script>

<?php include 'footer.php'; ?>