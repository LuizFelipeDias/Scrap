<div style="margin-top:10;" class="modal fade" id="modalScrap" role="dialog" aria-labelledby="editLabel"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document" style="width:100%;">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card" style="">
                    <div class='card-header'>
                        <h5>SCRAP: <b id="serial"></b></h5>
                    </div>

                <div class='card-body'>
                    <div class="row">
                        <div class='col-md-3'>
                            <div class="form-group">
                                <label for="">Area</label>
                                <input type="text" id="area" class="form-control" disabled>
                                <input type="hidden" id="scrapID">
                            </div>
                        </div>

                        <div class='col-md-3'>
                            <div class="form-group">
                                <label for="">Reincidente</label>
                                <input type="text" id="reincidente" class="form-control" disabled>
                            </div>
                        </div>

                        <div class='col-md-3'>
                            <div class="form-group">
                                <label for="">Turno</label>
                                <input type="text" id="turno" class="form-control" disabled>
                            </div>
                        </div>

                        <div class='col-md-3'>
                            <div class="form-group">
                                <label for="">Produto</label>
                                <input type="text" id="produto" class="form-control" disabled>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class='col-md-3'>
                            <div class="form-group">
                                <label for="">Causa Raiz</label>
                                <textarea id="causa" class="form-control" name="story" rows="5" cols="33">
                                </textarea>
                            </div>
                        </div>

                        <div class='col-md-3'>
                            <div class="form-group">
                                <label for="">Plano de Ação</label>
                                <textarea id="acao" class="form-control" name="story" rows="5" cols="33">
                                </textarea>
                            </div>
                        </div>

                        <div class='col-md-3'>
                            <div class="form-group">
                                <label for="">Data</label>
                                <input type="text" id="data" class="form-control" disabled>
                            </div>
                        </div>

                        <div class='col-md-3'>
                            <div class="form-group">
                                <label for="">Responsável</label>
                                <input type="text" id="usuario" class="form-control" disabled>
                            </div>
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
                                    <h5>Scraps Vinculados</h5>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="listar-detScrap" class="display" style="width:100%">
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

     // criando tabela de linha com DataTable
     var table = $('#listar-detScrap').DataTable({
                "processing": true,
                "serverSide": true,
                "destroy": true, // Permite recriar o DataTable se ele já estiver inicializado
                "ajax": {
                    "url": "consultas/scrapDet/table.php",
                    "data": function (d) {
                        var scrapID = $('#scrapID').val();
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
</script>
    