<div style="margin-top:50px;" class="modal fade" id="modalDet" role="dialog" aria-labelledby="editLabel"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document" style="width:80%;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editLabel">Editar Scrap</h4>
            </div>
            <div class="modal-body">

                <div class="row">

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Partnumber</label>
                            <input type="text" class="form-control form-control-alternative" placeholder="Descrição"
                                name="partnumber_d" id="partnumber_d" autofocus="" required="" disabled>
                                <input id="id_partnumber" type="hidden">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Falha</label>
                            <input type="text" class="form-control form-control-alternative" placeholder="Falha"
                                name="falha_d" id="falha_d" autofocus="" required="" disabled>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Valor Total</label>
                            <input type="text" class="form-control form-control-alternative" placeholder="Valor"
                                name="valor" id="valor_d" autofocus="" required="" disabled>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Quantidade</label>
                            <input type="text" class="form-control form-control-alternative" placeholder=""
                                name="quantidade_d" id="quantidade_d" autofocus="" required="" disabled>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Observação</label>
                            <input type="text" class="form-control form-control-alternative" placeholder="Descrição"
                                name="observacao_d" id="observacao_d" autofocus="" required="" disabled>
                        </div>
                    </div>

                </div>


                <div class="card-footer py-4">
                    <div style="text-align: right">
                        <button id="excluirPartnumber " type="submit" class="btn btn-danger excluirPartnumber">
                            <i class="ni ni-folder-17"></i> Deletar
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>