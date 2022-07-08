<div class="modal fade" id="modal_form_nueva_inscripcion" data-backdrop="static" data-keyboard="true" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nueva inscripción</h5>
                <button type="button" class="close cerrarModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-secondary">
                    <form id="form_nueva_inscripcion" name="form_nueva_inscripcion" class="needs-validation">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Plantel</label>
                                    <select class="form-control form-control-sm" id="list_plantel"
                                        name="list_plantel" onchange="fnSelectPlantel(value)">
                                        <option value="">Seleccionar...</option> 
                                        <?php foreach ($data['planteles'] as $key => $plantel) { ?>
                                            <option value="<?php echo $plantel['id'] ?>"><?php echo($plantel['nombre_plantel_fisico'].' ('.$plantel['municipio'].')') ?></option>
                                        <?php }?>                                  
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Institución</label>
                                    <select class="form-control form-control-sm" id="list_institucion"
                                        name="list_institucion" onchange="fnSelectInstitucion(value)">
                                        <option value="">Seleccionar...</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Nivel educativo</label>
                                    <select class="form-control form-control-sm" id="list_nivel_educativo"
                                        name="list_nivel_educativo" onchange="fnSelectNivelEducativo(value)">
                                        <option value="">Seleccionar...</option>
                                        <?php foreach ($data['niveles_educativos'] as $key => $nivel) { ?>
                                            <option value="<?php echo($nivel['id']) ?>"><?php echo($nivel['nombre_nivel_educativo']) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="card col-12">
                                    <div class="d-flex form-group justify-content-end">
                                        <input type="text" class="form-control col-md-6 form-control-sm" id="input_nombre_alumno" onkeyup="fnFiltrarAlumno(value)" placeholder="Nombre del alumno">
                                    </div>
                                    <div class="overflow-auto" style="height:250px">
                                        <p class="card-text">
                                            <table  class="table table-bordered table-striped table-hover table-sm">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center"><input type="checkbox" id="check_all" onclick="fnCheckAll(this)"></th>
                                                        <th>#</th>
                                                        <th>Nombre</th>
                                                        <th>Apellido paterno</th>
                                                        <th>Apellido materno</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table_preeinscripcion">
                                                    
                                                </tbody>
                                            </table>
                                        </p>
                                    </div>
                                </div>
                                <div class="card col-12">
                                    <div class="text-center"><label>Datos para la inscripción</label></div>
                                    <div class="form-group row p-2">
                                        <div class="form-group col-12">
                                            <label>Salon compuesto</label>
                                            <select class="form-control form-control-sm" id="select_salon_compuesto">
                                                <option value="">Seleccionar...</option>
                                                <?php foreach ($data['salones_compuestos'] as $key => $salonCompuesto) { ?>
                                                    <option value="<?php echo($salonCompuesto['id']) ?>"><?php echo($salonCompuesto['nombre_salon_compuesto'].'  (periodo '.$salonCompuesto['nombre_periodo'].' / '.$salonCompuesto['nombre_grado'].' '.$salonCompuesto['nombre_grupo'].' / '.$salonCompuesto['nombre_turno'].' )') ?></option>
                                                <?php } ?>
                                            </select>       
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-outline-secondary icono-color-principal btn-inline cerrarModal" href="#"
                    data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle icono-azul"></i>Cancelar</a>
                <button id="btnActionForm" type="submit"
                    class="btn btn-outline-secondary btn-primary icono-color-principal btn-inline"><i
                        class="fa fa-fw fa-lg fa-check-circle icono-azul"></i><span id="btnText">
                        Guardar</span></button>
            </div>
            </form>
        </div>
    </div>
</div>