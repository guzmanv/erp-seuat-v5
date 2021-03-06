<div class="modal fade" id="ModalNuevaBeca" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Editar beca</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-secondary">
                    <form id="formEditBeca" name="formEditBeca">
                        <input type="hidden" id="idBecaEdit" name="idBecaEdit" value="">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-7">
                                    <label>Nombre de la beca</label>
                                    <input type="text" id="txtEditBeca" name="txtEditBeca" class="form-control form-control-sm" placeholder="EJ: Beca Trabajo Social" name="" required="">
                                </div>
                                <div class="form-group col-md-5">
                                    <label>Descuento(%) de la beca</label>
                                    <input type="text" id="txtEditPorc" name="txtEditPorc" class="form-control form-control-sm" placeholder="EJ: 27,30,35..." required="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <div class="form-group">
                                        <label>Periodo escolar:</label>
                                        <select class="form-control" name="slctPeriodoEdit" id="slctPeriodoEdit">
                                            <option selected>Seleccionar...</option>

                                            <!-- <option value=""></option>
                                            <option value=""></option>
                                            <option value=""></option> -->
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="form-group">
                                        <label>Carrera:</label>
                                        <select class="form-control" name="slctCarreraEdit" id="slctCarreraedit">
                                            <option selected>Seleccionar...</option>
                                            <!-- <option></option>
                                            <option></option>
                                            <option></option> -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label>Estatus</label>
                                    <select name="slctEstatusBecaEdit" id="slctEstatusBecaEdit" class="form-control form-control-sm" required>
                                        <option value="">Selecciona el estatus de la categor??a</option>
                                        <option value="1">Activo</option>
                                        <option value="2">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-outline-secondary icono-color-principal btn-inline" href="#" data-dismiss="modal" id="dimissModalNuevoSalon"><i class="fa fa-fw fa-lg fa-times-circle icono-azul" id="cancelarModalNTurno"></i>Cancelar</a>
                <button id="btnActionFormNuevo" type="submit" class="btn btn-outline-secondary icono-color-principal btn-inline"><i class="fa fa-fw fa-lg fa-check-circle icono-azul"></i><span id="btnText"> Guardar</span></button>
            </div>
            </form>
        </div>
    </div>
</div>