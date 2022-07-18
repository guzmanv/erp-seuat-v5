<div class="modal fade" id="ModalRenovacionBeca" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ratificación de becas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <table id="tabla-asig-becas" class="table table-bordered table-hover table-striped table-md">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre del alumno</th>
                                <th>Carrera</th>
                                <th>Grado</th>
                                <th>Plan</th>
                                <th>Promedio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <a class="btn btn-outline-secondary icono-color-principal btn-inline" href="#" data-dismiss="modal" id="dimissModalRenovacion"><i class="fa fa-fw fa-lg fa-times-circle icono-azul" id="cancelarRenovacion"></i>Cancelar</a>
            </div>
        </div>
    </div>
</div>

<!-- <div class="modal fade" id="ModalRenovacionBeca" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog" aria-hidden="true">
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
                                    <label>Buscar alumno</label>
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
                        </div>
                        <div class="row">
                                <div class="col-md-12">
                                    <label>
                                        <h5>Datos del alumno</h5>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <table id="tabla-asig-becas" class="table table-bordered table-hover table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Carrera</th>
                                            <th>Grado</th>
                                            <th>Periodo</th>
                                            <th>Modalidad</th>
                                            <th>Promedio</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
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
</div> -->


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
                <table id="tableReinscritos" class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Nombre Alumno</th>
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




<!-- <div class="card card-widget widget-user-2">
                                <div class="widget-user-header bg-primary">
                                    <div class="widget-user-image">
                                        <img class="img-circle elevation-2" src="../dist/img/user7-128x128.jpg" alt="User Avatar">
                                    </div>
                                    <h3 class="widget-user-username">Emmanuel Espinoza Estrada</h3>
                                </div>
                                <div class="card-footer p-0">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <label class="nav-link">
                                                Carrera <span class="float-right badge bg-info"></span>
                                            </label>
                                        <li class="nav-item">
                                            <label class="nav-link">
                                                Semestre <span class="float-right badge bg-success"></span>
                                            </label>
                                        </li>
                                        <li class="nav-item">
                                            <label class="nav-link">
                                                Dirección del alumno <span class="float-right badge bg-success"></span>
                                            </label>
                                        </li>
                                        <li class="nav-item">
                                            <label class="nav-link">
                                                Nombre del padre o tutor <span class="float-right badge bg-success"></span>
                                            </label>
                                        </li>
                                        <li class="nav-item">
                                            <label class="nav-link">
                                                Dirección del padre o tutor <span class="float-right badge bg-success"></span>
                                            </label>
                                        </li>
                                        <li class="nav-item">
                                            <label class="nav-link">
                                                Teléfono de casa  <span class="float-right badge bg-success"></span>
                                            </label>
                                        </li>
                                        <li class="nav-item">
                                            <label class="nav-link">
                                                Teléfono celular <span class="float-right badge bg-success"></span>
                                            </label>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#" class="nav-link">
                                                Promedio <span class="text-md float-right badge bg-success">8.0</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div> -->