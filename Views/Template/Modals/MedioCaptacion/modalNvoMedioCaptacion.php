<!-- Modal -->
<div class="modal fade" id="modalNvoMedioCaptacion" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header headerUpdate">
                <h5 class="modal-title" id="titleModalNueva">Nuevo medio de captación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-secondary">
                    <form id="formNvoMedioCap" name="formNvoMedioCap">
                        <input type="hidden" id="idMedCapNvo" name="idMedCapNvo" value="">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Nombre del medio de captación:</label>
                                    <input type="text" id="txtMedioCaptacionNvo" name="txtMedioCaptacionNvo" class="form-control form-control-sm" placeholder="Ej. Radio, Televisión, redes sociales, etc." required="">
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-outline-secondary icono-color-principal btn-inline cerrarModalMed" href="#" data-dismiss="modal" id="dimissModalEdit"><i class="fa fa-fw fa-lg fa-times-circle icono-azul" id="cancelarModalNvoMedCaptacion"></i>Cancelar</a>
                <button id="btnActionFormNvoMed" type="submit" class="btn btn-outline-secondary icono-color-principal btn-inline"><i class="fa fa-fw fa-lg fa-check-circle icono-azul"></i><span id="btnText"> Actualizar</span></button>
            </div>
            </form>
        </div>
    </div>
</div>