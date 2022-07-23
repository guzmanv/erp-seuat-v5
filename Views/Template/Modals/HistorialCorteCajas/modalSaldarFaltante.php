<div class="modal fade" id="modal-saldar-faltante" data-backdrop="static" data-keyboard="true" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Saldar Faltantes</h5>
                <button type="button" class="close cerrarModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-secondary">
                    <form id="form-saldar-faltante" name="form-saldar-faltante" class="needs-validation">
                        <input type="hidden" id="id-dinero-caja" name="id-dinero-caja" value="">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="txt-nombre-caja">Nombre caja</label>
                                <input type="text" id="txt-nombre-caja" name="txt-nombre-caja" class="form-control"
                                    disabled>
                            </div>
                            <div class="form-group">
                                <label for="txt-recibido-por">Recibido por:</label>
                                <input type="text" id="txt-recibido-por" name="txt-recibido-por" class="form-control"
                                    disabled>
                            </div>
                            <div class="form-group">
                                <label for="txt-entregado-por">Entregado por:</label>
                                <input type="text" id="txt-entregado-por" name="txt-entregado-por" class="form-control"
                                    disabled>
                            </div>
                            <div class="col-12 text-center">
                                <label>Faltante</label>
                                <h1><b><span id="txt-cantidad-faltante"></span></b></h1>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
            <button id="btnActionForm" type="submit"
                    class="btn btn-outline-secondary btn-primary icono-color-principal btn-inline"><i
                        class="fa fa-fw fa-lg fa-check-circle icono-azul"></i><span id="btnText">
                        Saldar faltante</span></button>
                <a class="btn btn-outline-secondary icono-color-principal btn-inline cerrarModal" href="#"
                    data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle icono-azul"></i>Cancelar</a>
            </div>
            </form>
        </div>
    </div>
</div>