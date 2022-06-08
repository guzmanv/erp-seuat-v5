<div class="modal fade" id="ModalFormEditPlantel" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title">Editar plantel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-secondary">
                    <nav>
                        <div class="nav nav-pills nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-link tab-navEdit" id="step1-tabEdit" data-toggle="tab" href="" onclick="fnNavTabEdit(0)">Institucion</a>
                            <a class="nav-link tab-navEdit" id="step3-tabEdit" data-toggle="tab" href="" onclick="fnNavTabEdit(1)">Legal</a>
                            <a class="nav-link tab-navEdit" id="step5-tabEdit" data-toggle="tab" href="" onclick="fnNavTabEdit(2)">Logos</a>
                        </div>
                    </nav>
                    <form id="formEditInstitucion" method = "POST" name="formEditInstitucion" enctype="multipart/form-data">
                        <input type="hidden" id="idInstitucionEdit" name="idInstitucionEdit" value="">
                        <div class="card-body"> 
                                <div class="tabEdit">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>Nombre de la institución <span class="required">*</span></label>
                                            <input type="text" id="txt_nombre_edit" name="txt_nombre_edit" class="form-control form-control-sm" placeholder="EJ: Instituto de Estudios Superiores Azteca" maxlength="100">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Plantel<span class="required">*</span></label>
                                            <select class="form-control form-control-sm" id="select_plantel_edit" name="select_plantel_edit">
                                                <option value="">Seleccionar ...</option>
                                                <?php foreach ($data['planteles'] as $key => $plantel) { ?>
                                                    <option value="<?php echo $plantel['id'] ?>"><?php echo($plantel['nombre_plantel_fisico']) ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Sistema educativo <span class="required">*</span></label>
                                            <select class="form-control form-control-sm" id="select_sistema_educativo_edit" name="select_sistema_educativo_edit">
                                                <option value="" selected>Seleccionar ...</option>
                                                <?php foreach ($data['sistemas_educativos'] as $key => $value) { ?>
                                                    <option value="<?php echo $value['id'] ?>"><?php echo($value['nombre_sistema']) ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Abreviación de la institución <span class="required">*</span></label>
                                            <input type="text" id="txt_abreviacion_edit" name="txt_abreviacion_edit" class="form-control form-control-sm" placeholder="EJ: IESAZTECA" maxlength="10">
                                        </div>
                                    </div>
                                </div>
                                <div class="tabEdit">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label>Régimen</label>
                                            <input type="text" id="txtRegimenEdit" name="txtRegimenEdit" class="form-control form-control-sm" placeholder="EJ: Particula" maxlength="30" >
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Clave del centro de trabajo</label>
                                            <input type="text" id="txtClaveCentroTrabajoEdit" name="txtClaveCentroTrabajoEdit" class="form-control form-control-sm" placeholder="Clave del centro de trabajo" maxlength="15" >
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Servicio</label>
                                            <input type="text" id="txtServicioEdit" name="txtServicioEdit" class="form-control form-control-sm" placeholder="EJ: Educativo" maxlength="50" >
                                        </div>
                                        <div class="form-group col-md-8">
                                            <label>Categoría</label>
                                            <input type="text" id="txtCategoriaEdit" name="txtCategoriaEdit" class="form-control form-control-sm" placeholder="EJ: Incorporado a Secretaría de Educación del Estado de Chiapas" maxlength="70" >
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Zona escolar</label>
                                            <input type="text" id="txtZonaEscolarEdit"  name="txtZonaEscolarEdit" class="form-control form-control-sm" placeholder="Zona escolar" maxlength="5">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Cédula de funcionamiento</label>
                                            <input type="text" id="txtCedulaFuncionamientoEdit" name="txtCedulaFuncionamientoEdit" class="form-control form-control-sm" placeholder="Cédula de funcionamiento"" maxlength="30">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Clave de institución DGP</label>
                                            <input type="text" id="txtClaveInstitucionDGPEdit" name="txtClaveInstitucionDGPEdit" class="form-control form-control-sm" placeholder="Clave de institución" maxlength="30">
                                        </div>
                                    </div>               
                                </div>   
                                <div class="tabEdit">
                                    <div class="row">
                                        <div class="form-group col-md-5">
                                            <div class="card">
                                                <div class="card-header row">
                                                    <div class="col-md-6">
                                                        <card-title>Plantel</card-title>  
                                                    </div>
                                                    <div class="col-md-6">
                                                        <a href="#" class="btn btn-warning btn-sm float-right" onclick="buscarImagenInstitucionEdit()" id="btnBuscarImagenInstitucionEdit">Cambiar</a>
                                                    </div>
                                                </div>
                                                <div class="form-group card-body text-center"  style="position:relative;" >
                                                    <span class="img-div">
                                                        <img src="<?php echo media();?>/images/img/logo-empty.png" id="profileDisplayInstitucionEdit" style="max-width:200px;">
                                                    </span>
                                                    <input type="file" name="profileImageInstitucion" onChange="displayImageInstitucionEdit(this)" id="profileImageInstitucionEdit" class="form-control" style="display: none;"
                                                        accept=".png,.jpg,.jpeg,.svg">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <select class="custom-select" id="select_estatus_edit" name="select_estatus_edit">
                                                <option value="1">Activo</option>
                                                <option value="2">Inactivo</option>
                                            </select>
                                        </div>
                                    </div>               
                                </div>    
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row col-12">
                        <div class="col-6 text-right">
                            <span class="stepEdit"></span>
                            <span class="stepEdit"></span>
                            <span class="stepEdit"></span>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <div class="row">
                                    <buttom class="btn btn-outline-secondary icono-color-principal btn-inline" href="#" onclick="pasarTabEdit(-1)"  id="btnAnteriorEdit"><i class="fas fa-fw fa-lg fa-arrow-circle-left icono-azul"></i>Anterior</buttom>
                                    <buttom class="btn btn-outline-secondary icono-color-principal btn-inline" href="#" onclick="pasarTabEdit(1)"  id="btnSiguienteEdit"><i class="fas fa-fw fa-lg fa-arrow-circle-right icono-azul"></i>Siguiente</buttom>
                                    <button id="btnActionFormEdit" type="submit" class="btn btn-outline-secondary btn-primary icono-color-principal btn-inline"><i class="fa fa-fw fa-lg fa-check-circle icono-azul"></i><span id="btnText"> Actualizar</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>   
            </form> 
        </div>
    </div>
</div>

