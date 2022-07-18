<!-- Modal -->
<div class="modal fade" id="modalConfirmarRenovacion" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">Nombre del alumno</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Datos del estudiante</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><i class="fa fa-graduation-cap" aria-hidden="true"></i> Carrera</td>
                                    <td>
                                        <span class="font-weight-bold text-success" id="lblCarreraAsig"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-clipboard" aria-hidden="true"></i> Semestre o cuatrimestre a cursar</td>
                                    <td>
                                        <span class="font-weight-bold text-success" id="lblGradoAsig"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-location-arrow" aria-hidden="true"></i> Dirección del estudiante</td>
                                    <td>
                                        <span class="font-weight-bold text-success" id="direccion_estudianteAsig"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><i class="fa fa-user" aria-hidden="true"></i> Nombre del tutor</td>
                                    <td>
                                        <span class="font-weight-bold text-success" id="nombre_tutorAsig"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Teléfono fijo</td>
                                    <td>
                                        <span class="font-weight-bold text-success" id="telefonoFijoAsig"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Télefono celular</td>
                                    <td>
                                        <span class="font-weight-bold text-success" id="telefonoCelAsig"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Promedio</td>
                                    <td>
                                        <span class="font-weight-bold text-success" id="promedioAsig"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Folio de reinscripción</td>
                                    <td>
                                        <div class="form-inline">
                                          <input type="text" class="form-control-sm" name="" id="" aria-describedby="helpId" placeholder="">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary icono-color-principal btn-inline" href="#" data-dismiss="modal" id="dimissModalNuevoSalon"><i class="fa fa-fw fa-lg fa-times-circle icono-azul" id="cancelarModalRenBeca"></i>Cancelar</button>
                <button id="btnActionFormRen" type="submit" class="btn btn-outline-secondary  btn-primary icono-color-principal btn-inline"><i class="fa fa-fw fa-lg fa-check-circle icono-azul"></i><span id="btnText"> Renovar</span></button>
            </div>
        </div>
    </div>
</div>