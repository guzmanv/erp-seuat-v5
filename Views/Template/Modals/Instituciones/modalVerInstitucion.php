<!-- Modal -->
<div class="modal fade" id="ModalVerPlantel" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titModal">Ver institución</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="card card-light">
                        <div class="card-header">
                            <label><i class="far fa-building text-secondary"></i> Institución</label>
                        </div> 
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Nombre de la institución</label>
                                    <input type="text" id="txtNombreInstitucionVer" class="form-control form-control-sm" disabled >
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Nombre del plantel</label>
                                    <select class="form-control form-control-sm" id="select_plantel_ver" disabled>
                                        <?php foreach ($data['planteles'] as $key => $plantel) { ?>
                                            <option value="<?php echo $plantel['id'] ?>"><?php echo($plantel['nombre_plantel_fisico']) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Nombre del Sistema</label>
                                    <select class="form-control form-control-sm" id="select_sistema_educativo_ver" disabled>
                                        <?php foreach ($data['sistemas_educativos'] as $key => $value) { ?>
                                            <option value="<?php echo $value['id'] ?>"><?php echo($value['nombre_sistema']) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Abreviación de la institución</label>
                                    <input type="text" id="txtAbreviacionInstitucionVer" class="form-control form-control-sm" disabled>
                                </div>
                            </div>
                        </div>
                    </div>    
                    <div class="card card-light">
                        <div class="card-header">
                            <label><i class="fas fa-balance-scale text-secondary"></i> Legal</label>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Régimen</label>
                                    <input type="text" id="txtRegimenVer"  class="form-control form-control-sm"  disabled>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Clave del centro de trabajo</label>
                                    <input type="text" id="txtClaveCentroTrabajoVer" class="form-control form-control-sm"  disabled>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Servicio</label>
                                    <input type="text" id="txtServicioVer"  class="form-control form-control-sm"  disabled>
                                </div>
                                <div class="form-group col-md-8">
                                    <label>Categoría</label>
                                    <input type="text" id="txtCategoriaVer"  class="form-control form-control-sm" disabled>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Zona escolar</label>
                                    <input type="text" id="txtZonaEscolarVer" class="form-control form-control-sm"  disabled>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Cédula de funcionamiento</label>
                                    <input type="text" id="txtCedulaFuncionamientoVer"  class="form-control form-control-sm"  maxlength="5" disabled>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Clave de institución DGP</label>
                                    <input type="text" id="txtClaveInstitucionDGPVer"  class="form-control form-control-sm"  maxlength="5" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-light">
                        <div class="card-header">
                            <label><i class="far fa-image text-secondary"></i> Logos</label>
                        </div>  
                        <div class="card-body">
                            <div class="row d-flex justify-content-between">
                                <div class="form-group col-md-5">
                                    <div class="card">
                                        <div class="card-header row">
                                            <div class="col-6">
                                                <card-title>Institución</card-title>  
                                            </div>
                                        </div>
                                        <div class="form-group card-body text-center" id="huhshu" style="position:relative;" >
                                            <span class="img-div">
                                                <img src="<?php echo media();?>/images/img/logo-empty.png" id="profileInstitucionVer" style="max-width:200px;">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>         
                    </div>
            </div>        
            <div class="modal-footer">
                <a class="btn btn-outline-secondary icono-color-principal btn-inline" href="#" data-dismiss="modal" id="dimissModal"><i class="fa fa-fw fa-lg fa-times-circle icono-azul"></i>Cancelar</a>
            </div>
        </div>
    </div>
</div>