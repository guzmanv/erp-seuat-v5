<!-- Modal -->
<div class="modal fade" id="modal_form_nueva_institucion" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="title_modal_nuevo">Nueva institución</h5>
                <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <small class="text-muted pb-4">
                    Los campos con asterisco (<span class="required">*</span>) son obligatorios..
                </small><br>
                <div class="card card-secondary">
                    <nav>
                        <div class="nav nav-pills nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-link tab-nav" id="step1-tab" data-toggle="tab" href="" onclick="fnNavTab(0)">Institución</a>
                            <a class="nav-link tab-nav" id="step3-tab" data-toggle="tab" href="" onclick="fnNavTab(1)">Legal</a>
                            <a class="nav-link tab-nav" id="step5-tab" data-toggle="tab" href="" onclick="fnNavTab(2)">Logos</a>
                        </div>
                    </nav>
                    <form id="form_nueva_institucion" method = "POST" name="form_nueva_institucion" enctype="multipart/form-data">
                        <input type="hidden" id="id_institucion_nuevo" name="id_institucion_nuevo" value="">
                        <div class="card-body"> 
                                <div class="tab">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>Plantel<span class="required">*</span></label>
                                            <select class="form-control form-control-sm" id="select_plantel_nuevo" name="select_plantel_nuevo">
                                                <option value="">Seleccionar ...</option>
                                                <?php foreach ($data['planteles'] as $key => $plantel) { ?>
                                                    <option value="<?php echo $plantel['id'] ?>"><?php echo($plantel['nombre_plantel_fisico']) ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Sistema educativo <span class="required">*</span></label>
                                            <select class="form-control form-control-sm" id="select_sistema_educativo_nuevo" name="select_sistema_educativo_nuevo">
                                                <option value="" selected>Seleccionar ...</option>
                                                <?php foreach ($data['sistemas_educativos'] as $key => $value) { ?>
                                                    <option value="<?php echo $value['id'] ?>"><?php echo($value['nombre_sistema']) ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Nombre de la institución <span class="required">*</span></label>
                                            <input type="text" id="txt_nombre_nuevo" name="txt_nombre_nuevo" class="form-control form-control-sm" placeholder="EJ: Instituto de Estudios Superiores Azteca" maxlength="100">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Abreviación de la institución <span class="required">*</span></label>
                                            <input type="text" id="txt_abreviacion_nuevo" name="txt_abreviacion_nuevo" class="form-control form-control-sm" placeholder="EJ: IESAZTECA" maxlength="10">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Régimen <span class="required">*</span></label>
                                            <input type="text" id="txt_regimen_nuevo" name="txt_regimen_nuevo" class="form-control form-control-sm" placeholder="EJ: Particular" maxlength="30">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Clave del centro de trabajo <span class="required">*</span></label>
                                            <input type="text" id="txt_clave_centro_trabajo_nuevo" name="txt_clave_centro_trabajo_nuevo" class="form-control form-control-sm" placeholder="Clave del centro de trabajo" maxlength="15">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Servicio <span class="required">*</span></label>
                                            <input type="text" id="txt_servicio_nuevo" name="txt_servicio_nuevo" class="form-control form-control-sm" placeholder="EJ: Educativo" maxlength="50">
                                        </div>
                                        <div class="form-group col-md-8">
                                            <label>Categoría <span class="required">*</span></label>
                                            <input type="text" id="txt_categoria_nuevo" name="txt_categoria_nuevo" class="form-control form-control-sm" placeholder="EJ: Incorporado a Secretaría de Educación del Estado de Chiapas" maxlength="70">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Zona escolar</label>
                                            <input type="text" id="txt_zona_escolar_nuevo" name="txt_zona_escolar_nuevo" class="form-control form-control-sm" placeholder="Zona escolar" maxlength="5">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Cédula de funcionamiento</label>
                                            <input type="text" id="txt_cedula_funcionamiento_nuevo" name="txt_cedula_funcionamiento_nuevo" class="form-control form-control-sm" placeholder="Cédula de funcionamiento" maxlength="30">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Clave de institución DGP</label>
                                            <input type="text" id="txt_clave_dgp_nuevo" name="txt_clave_dgp_nuevo" class="form-control form-control-sm" placeholder="Clave de institución" maxlength="30">
                                        </div>
                                    </div>               
                                </div>   
                                <div class="tab">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <div class="card">
                                                <div class="card-header row">
                                                    <div class="col-md-6">
                                                        <card-title>Institución</card-title>  
                                                    </div>
                                                    <div class="col-md-6">
                                                        <a href="#" class="btn btn-primary btn-sm float-right" onclick="buscarImagenInstitucion()" id="btnBuscarImagenInstitucion">Buscar Imagen</a>
                                                    </div>
                                                </div>
                                                <div class="form-group card-body text-center" id="huhshu" style="position:relative;" >
                                                    <span class="img-div">
                                                        <img src="<?php echo media();?>/images/img/logo-empty.png" id="profileDisplayInstitucion" style="max-width:200px;">
                                                    </span>
                                                    <input type="file" name="profileImageInstitucion" onChange="displayImageInstitucion(this)" id="profileImageInstitucion" class="form-control" style="display: none;"
                                                        accept=".png,.jpg,.jpeg,.svg">
                                                </div>
                                            </div>
                                        </div>
                                    </div>               
                                </div>    
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row col-12">
                        <div class="col-7 text-right">
                            <span class="step"></span>
                            <span class="step"></span>
                            <span class="step"></span>
                        </div>
                        <div class="col-5">
                            <div class="float-right">
                                <div class="row">
                                    <buttom class="btn btn-outline-secondary icono-color-principal btn-inline" href="#" onclick="pasarTab(-1)"  id="btnAnterior"><i class="fas fa-fw fa-lg fa-arrow-circle-left icono-azul"></i>Anterior</buttom>
                                    <buttom class="btn btn-outline-secondary icono-color-principal btn-inline" href="#" onclick="pasarTab(1)"  id="btnSiguiente"><i class="fas fa-fw fa-lg fa-arrow-circle-right icono-azul"></i>Siguiente</buttom>
                                    <button id="btnActionFormNuevo" type="submit" class="btn btn-outline-secondary btn-primary icono-color-principal btn-inline"><i class="fa fa-fw fa-lg fa-check-circle icono-azul"></i><span id="btnText"> Guardar</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>   
            </form> 
        </div>
    </div>
</div>

