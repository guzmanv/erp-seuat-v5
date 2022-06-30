<div class="modal fade" id="ModalNuevaBeca" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nueva beca</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-secondary">
                    <form id="formNuevaBeca" name="formNuevaBeca">
                        <input type="hidden" id="idBecaNueva" name="idBecaNueva" value="">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-7">
                                    <label>Nombre de la beca</label>
                                    <input type="text" id="txtNuevaBeca" name="txtNuevaBeca" class="form-control form-control" placeholder="EJ: Beca Trabajo Social" name="" required="">
                                </div>
                                <div class="form-group col-md-5">
                                    <label>Descuento(%) de la beca</label>
                                    <input type="text" id="txtPorcentaje" name="txtPorcentaje" class="form-control form-control" placeholder="EJ: Número en decimal 0.48, 0.40, etc..." required="">
                                </div>
                            </div>
                            <div class="row">
                            <div class="form-group col-md-4">
                                    <div class="form-group">
                                        <label>Periodo:</label>
                                        <select class="form-control" name="slctPeriodo" id="slctPeriodo">
                                            <option selected>Seleccionar...</option>
                                            <?php
                                            foreach ($data['periodo'] as $value) {
                                            ?>
                                                <option value="<?php echo $value['id'] ?>"><?php echo $value['nombre_periodo'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="form-group">
                                        <label>Plantel:</label>
                                        <select class="form-control" name="slctPlantel" id="slctPlantel" onchange="fnElegirInstitucion(value)">
                                            <option selected>Seleccionar...</option>
                                            <?php
                                            foreach ($data['planteles'] as $value) {
                                            ?>
                                                <option value="<?php echo $value['id'] ?>"><?php echo $value['nombre_plantel_fisico'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="form-group">
                                        <label>Institucion:</label>
                                        <select class="form-control" name="slctInstitucion" id="slctInstitucion">
                                            <option selected>Seleccionar...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <div class="form-group">
                                        <label>Nivel educativo:</label>
                                        <select class="form-control" name="slctNivel" id="slctNivel">
                                            <option selected>Seleccionar...</option>
                                            <?php
                                            foreach ($data['nivel_educativo'] as $value) {
                                            ?>
                                                <option value="<?php echo $value['id'] ?>"><?php echo $value['nombre_nivel_educativo'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="form-group">
                                        <label>Carrera:</label>
                                        <select class="form-control" name="slctCarrera" id="slctCarrera">
                                            <option selected>Seleccionar...</option>
                                        </select>
                                    </div>
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