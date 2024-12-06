<div style="margin-top:10;" class="modal fade" id="modalEdit" role="dialog" aria-labelledby="editLabel"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document" style="width:100%;">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card" style="">
                    <div class='card-header'>
                        <h5>Detalhes do Produto</h5>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Cimcode</label>
                                    <input type="text" class="form-control form-control-alternative"
                                        placeholder="Descrição" name="cimcode_d" id="cimcode_d" autofocus="" required=""
                                        disabled>
                                    <input id="id_produto" type="hidden">

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Linha</label>
                                    <select id="selectLinha_d" placeholder="Selecione uma Linha"></select>


                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Cliente</label>
                                    <select id="selectCliente_d" placeholder="Selecione uma Linha"></select>


                                </div>
                            </div>
                        </div>

                        <br>
                        <div class="card-footer py-4">
                            <div style="text-align: right">
                                <button id="salvarProduto" type="submit" class="btn btn-primary editModal">
                                    <i class="ni ni-folder-17"></i> Salvar
                                </button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <br>

                <div class="card" style="">
                    <div class='card-header'>
                        <h5>Vincular PartNumber</h5>
                    </div>
                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-10">
                                <div class="form-group">
                                    <label>PARTNUMBER</label>
                                    <select id="selectPartnumber" placeholder="Selecione um Partnumber"></select>
                                </div>
                            </div>
                            <div class='col-md-2' style="align-content: flex-end;">
                                <button type="button" id="saveDataPartnumber" class="btn btn-success">
                                    <i class="fa-solid fa-plus"></i> Inserir
                                </button>
                            </div>
                            <div>
                                <table id="listar-partnumber" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center" id="partnumber">PARTNUMBER</th>
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

<div class="modal fade" id="modalEdit" role="dialog" aria-labelledby="editLabel" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document" style="width:100%;">
        <div class="modal-content">
            <div class="modal-body">
                <form id="formEditProduct" action="consultas/produtos/update.php" method="POST">
                    <div class="card">
                        <div class="card-header">
                            <h5>Detalhes do Produto</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Cimcode</label>
                                        <input type="text" class="form-control form-control-alternative"
                                            placeholder="Descrição" id="cimcode_d" disabled>
                                        <input type="hidden" id="id_produto" name="id_produto">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Linha</label>
                                        <select id="selectLinha" name="linha" class="form-control">
                                            <!-- Opções serão carregadas dinamicamente -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Cliente</label>
                                        <input type="text" class="form-control form-control-alternative"
                                            placeholder="Descrição" id="cliente_d" name="cliente" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer py-4">
                            <div style="text-align: right">
                                <button id="salvarProduto" type="submit" class="btn btn-primary">
                                    <i class="ni ni-folder-17"></i> Salvar
                                </button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

        // $('#salvarProduto').hide();
        // Inicializar o Selectize Cliente
        var selectCliente = $('#selectCliente_d').selectize({
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

        // $('#salvarProduto').hide();


        // // Inicializar o Selectize linha
        var selectLinha = $('#selectLinha_d').selectize({
            maxItems: 1,
            valueField: 'id',
            labelField: 'title',
            searchField: 'title',
            options: [],
            create: false,
            load: function (query, callback) {
                $.ajax({
                    url: 'consultas/linhas/selectLinha.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        q: query
                    },
                    error: function () {
                        callback();
                    },
                    success: function (res) {
                        selectLinha[0].selectize.clearOptions();
                        selectLinha[0].selectize.addOption(res.options || []);
                        selectLinha[0].selectize.refreshOptions(false);
                    }
                });
            }
        });


        // Carregar as opções quando a página é carregada
        $.ajax({
            url: 'consultas/linhas/selectLinha.php',
            type: 'GET',
            dataType: 'json',
            success: function (res) {
                selectLinha[0].selectize.addOption(res.options || []);
                selectLinha[0].selectize.refreshOptions(false);
            }
        });
    });

    $(document).on('click', '#salvarProduto', function (e) {
    e.preventDefault();

    const idProduto = $('#id_produto').val().trim();
    const linha = $('#selectLinha_d').val().trim();
    const cliente = $('#selectCliente_d').val().trim();

    if (!linha || !cliente) {
        alertify.error('Preencha todos os campos!');
        return;
    }

    $.ajax({
        url: 'consultas/produtos/edit.php',
        type: 'POST',
        data: {
            id: idProduto,
            linha: linha,
            cliente: cliente,
        },
        success: function (response) {
            try {
                const res = JSON.parse(response);

                if (res.success) {
                    alertify.success(res.message || 'Produto atualizado com sucesso!');
                    $('#modalEdit').modal('hide');
                    updateTables();
                } else {
                    alertify.error(res.message || 'Erro ao atualizar o produto.');
                }
            } catch (error) {
                alertify.error('Erro ao processar a resposta do servidor.');
                console.error('Erro no JSON:', error);
            }
        },
        error: function (xhr, status, error) {
            alertify.error('Erro ao conectar com o servidor.');
            console.error('Erro na requisição AJAX:', error);
        }
        });
    });


    
</script>