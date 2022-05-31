<!-- Modal -->
<div class="modal fade" id="modal_form_edit_plantel" data-backdrop="static" data-keyboard="true" tabindex="-1"
    role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModalEdit">Editar plantel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <small class="text-muted pb-4">
                    Los campos con asterisco (<span class="required">*</span>) son obligatorios..
                </small>
                <div class="card card-secondary">
                    <form id="form_plantel_edit" name="form_plantel_edit">
                        <input type="hidden" id="id_edit" name="id_edit" value="">
                        <div class="card-body row">
                            <div class="form-group col-12">
                                <label>Nombre <span class="required">*</span></label>
                                <input type="text" id="txt_nombre_edit" name="txt_nombre_edit" class="form-control form-control-sm"
                                    placeholder="EJ: Tuxtla" maxlength="100" required>
                            </div>
                            <div class="form-group col-4">
                                <label>Estado <span class="required">*</span></label>
                                <select class="form-control form-control-sm" id="select_estado_edit" name="select_estado_edit" onchange="estadoSeleccionadoEdit(value)" required>
                                    <option value="">Seleccionar ...</option>
                                    <?php foreach ($data['lista_estados'] as $key => $estado) { ?>
                                        <option value="<?= $estado['id'] ?>"><?= $estado['nombre'] ?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label>Municipio <span class="required">*</span></label>
                                <select class="form-control form-control-sm" id="select_municipio_edit" name="select_municipio_edit" onchange="municipioSeleccionadoEdit(value)" required>
                                    <option value="">Seleccionar ...</option>
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label>Localidad <span class="required">*</span></label>
                                <select class="form-control form-control-sm" id="select_localidad_edit" name="select_localidad_edit" required>
                                    <option value="">Seleccionar ...</option>
                                </select>
                            </div>
                            <div class="form-group col-12">
                                <label>Colonia <span class="required">*</span></label>
                                <input type="text" id="txt_colonia_edit" name="txt_colonia_edit" class="form-control form-control-sm"
                                    placeholder="Colonia" maxlength="70" required>
                            </div>
                            <div class="form-group col-12">
                                <label>Domicilio <span class="required">*</span></label>
                                <input type="text" id="txt_domicilio_edit" name="txt_domicilio_edit" class="form-control form-control-sm"
                                    placeholder="Colonia" maxlength="150" required>
                            </div>
                            <div class="form-group col-4">
                                <label>Codigo postal <span class="required">*</span></label>
                                <input type="text" id="txt_codigo_postal_edit" name="txt_codigo_postal_edit" class="form-control form-control-sm" onkeypress="return validarNumeroInput(event)"
                                    placeholder="Codigo postal" maxlength="6" required>
                            </div>
                            <div class="form-group col-4">
                                <label>Latitud</label>
                                <input type="text" id="txt_latitud_edit" name="txt_latitud_edit" class="form-control form-control-sm"
                                    placeholder="Latitud" maxlength="40">
                            </div>
                            <div class="form-group col-4">
                                <label>Longitud</label>
                                <input type="text" id="txt_longitud_edit" name="txt_longitud_edit" class="form-control form-control-sm"
                                    placeholder="Longitud" maxlength="20">
                            </div>
                            <div class="form-group col-4">
                                <label>Estatus</label>
                                <select class="form-control form-control-sm" id="select_estatus_edit" name="select_estatus_edit">
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                </select>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-outline-secondary icono-color-principal btn-inline" href="#" data-dismiss="modal"
                    id="dimissModalEdit"><i class="fa fa-fw fa-lg fa-times-circle icono-azul"></i>Cancelar</a>
                <button id="btnActionFormEdit" type="submit"
                    class="btn btn-outline-secondary btn-primary icono-color-principal btn-inline"><i
                        class="fa fa-fw fa-lg fa-check-circle icono-azul"></i><span id="btnText">
                        Guardar</span></button>
            </div>
            </form>
        </div>
    </div>
</div>