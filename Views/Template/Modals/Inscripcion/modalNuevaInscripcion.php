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
                                        name="list_nivel_educativo">
                                        <option value="">Seleccionar...</option>
                                        <?php foreach ($data['niveles_educativos'] as $key => $nivel) { ?>
                                            <option value="<?php echo($nivel['id']) ?>"><?php echo($nivel['nombre_nivel_educativo']) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <p class="card-text">
                                    <table  class="table table-bordered table-striped table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre</th>
                                                <th>Apellido paterno</th>
                                                <th>Apellido materno</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_preeinscripcion">
                                            
                                        </tbody>
                                    </table>
                                </p>
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