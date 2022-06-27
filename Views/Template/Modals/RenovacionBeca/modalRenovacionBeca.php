<div class="modal fade" id="ModalRenovacionBeca" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ratificación de becas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-secondary">
                    <form id="formNuevaRenovacion" name="formNuevaRenovacion">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Nombre del alumno</label>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <input type="text" id="txtAlumno" name="txtAlumno" class="form-control form-control-sm" placeholder="Nombre completo del alumno" readonly require>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalBuscarNombreAlumno"><i class="fa fa-search"></i> Buscar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>
                                        <h5>Datos del alumno</h5>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Carrera:</label> <b id="carreraRenBeca">Ing. en sistemas computacionales</b>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Semestre o cuatrimestre:</label> <b id="cuatrimestreRenBeca">2do. Cuatrimestre</b>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Nombre completo:</label> <b id="nomCompletoRenBeca">Nombre prueba ApellidoPat ApellidoMat</b>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Dirección del alumno:</label> <b id="direccionAlumRenBeca">Dirección conocida</b>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Nombre del padre o tutor:</label> <b id="nomTutorRenBeca">Nombre prueba ApellidoPat ApellidoMat</b>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Dirección del padre o tutor:</label> <b id="direccionTutorRenBeca">Dirección conocida</b>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Teléfono fijo:</label> <b id="telFijoRenBeca">9610000000</b>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Teléfono celular:</label> <b id="telCelRenBeca">9610000000</b>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Número de recibo de reinscripción:</label> <input type="text">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Promedio general del semestre o cuatrimestre cursado:</label><b id="promedio">9.5</b>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary icono-color-principal btn-inline" href="#" data-dismiss="modal" id="dimissModalNuevoSalon"><i class="fa fa-fw fa-lg fa-times-circle icono-azul" id="cancelarModalRenBeca"></i>Cancelar</button>
                <button id="btnActionFormRen" type="submit" class="btn btn-outline-secondary  btn-primary icono-color-principal btn-inline"><i class="fa fa-fw fa-lg fa-check-circle icono-azul"></i><span id="btnText"> Renovar</span></button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalBuscarNombreAlumno" tabindex="-1" role="dialog" aria-labelledby="modalNombrePersonaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNombrePersonaNLabel">Buscar alumno</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control form-control-sm" id="busquedaPersona" placeholder="Nombre de la Persona" maxlength="100" autocomplete="off" onKeyUp="buscarAlumno();" />
                <br>
                <table id="tablePersonas" class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Nombre Alumno</th>
                            <th>Estatus</th>
                            <th width="15%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" id="cerrarModalBuscarPersona">Cerrar</button>
            </div>
        </div>
    </div>
</div>