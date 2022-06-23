<div class="modal fade" id="ModalRenovacionBeca" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Ratificación de beca</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-secondary">
                    <form id="formTurnoNuevo" name="formTurnoNuevo">
                        <input type="hidden" id="idTurnoNuevo" name="idTurnoNuevo" value="">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Nombre del alumno</label>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <input type="text" id="txtAlumno" name="txtAlumno" class="form-control form-control-sm" placeholder="Nombre completo del alumno" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalNombrePersona"><i class="fa fa-search"></i> Buscar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">Datos del alumno</label>
                                </div>
                            </div>
                            <div class="row">
                                <label for="">Carrera</label>
                            </div>
                            <div class="row">
                                <label for="">Semestre o cuatrimestre</label>
                            </div>
                            <div class="row">
                                <label for="">Nombre</label>
                            </div>
                            <div class="row">
                                <label for="">Dirección del alumno</label>
                            </div>
                            <div class="row">
                                <label for="">Nombre del padre o tutor</label>
                            </div>
                            <div class="row">
                                <label for="">Dirección del padre o tutor</label>
                            </div>
                            <div class="row">
                                <label for="">Teléfono fijo</label>
                            </div>
                            <div class="row">
                                <label for="">Teléfono celular</label>
                            </div>
                            <div class="row">
                                <label for="">Número de recibo de inscripción</label>
                            </div>
                            <div class="row">
                                <label for="">Promedio general del semestre o cuatrimestre cursado</label>
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