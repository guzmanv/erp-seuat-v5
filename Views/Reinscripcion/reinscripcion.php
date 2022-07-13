<?php
    headerAdmin($data);
    getModal("Reinscripcion/modalBuscarAlumno",$data);
?>
<div id="contentAjax"></div>
<div class="wrapper">
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-7">
                        <h1 class="m-0"><?= $data['page_title'] ?></h1>
                    </div>
                    <div class="col-sm-5">
                        <ol class="breadcrumb float-sm-right btn-block">
                            <button type="button" class="btn btn-inline btn-primary btn-sm btn-block" data-toggle="modal" data-target="#ModalFormNuevaInscripcion"><i class="fa fa-plus-circle fa-md"></i>Nuevo</button>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card card-secondary">
                                    <nav>
                                        <div class="nav nav-pills nav-fill" id="nav-tab" role="tablist">
                                            <a class="nav-link tab-nav active" id="step1-tab" data-toggle="tab" href="" onclick="fnNavTab(0)"><i class="fas fa-list"></i> Reinscripciones</a>
                                            <a class="nav-link tab-nav" id="step2-tab" data-toggle="tab" href="" onclick="fnNavTab(1)"><i class="fas fa-user"></i> Individual</a>
                                            <!-- <a class="nav-link tab-nav" id="step3-tab" data-toggle="tab" href="" onclick="fnNavTab(2)"><i class="fas fa-reply-all"></i>> Masivo</a> -->
                                            <a class="nav-link tab-nav" id="step4-tab" data-toggle="tab" href="" onclick="fnNavTab(2)"><i class="fas fa-users"></i> Grupal</a>
                                        </div>
                                    </nav>
                                    <div class="card-body"> 
                                        <div class="tab">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <p class="card-text">
                                                                <table id="table_reinscripciones" width="100%" class="col-12 table table-bordered table-striped table-hover table-sm">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Plantel</th>
                                                                            <th>Institución</th>
                                                                            <th>Plan de estudio</th>
                                                                            <th>Grado</th>
                                                                            <th>Grupo</th>
                                                                            <th>Alumnos</th>
                                                                            <th>Acciones</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        
                                                                    </tbody>
                                                                </table>
                                                            </p>
                                                        </div>
                                                    </div>  
                                                </div>
                                            </div>               
                                        </div>

                                        <div class="tab">
                                            <form id="formReinscripcion" name="formReinscripcion">
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <div class="col-md-6">
                                                            <label>Nombre del Alumno</label>
                                                            <div class="input-group mb-3">
                                                                <input type="text" class="form-control" placeholder="Nombre del alumno" id="nombreAlumno">
                                                                <div class="input-group-append">
                                                                    <a type="button" data-toggle="modal" data-target="#modalBuscarAlumno"><span class="input-group-text" id="basic-addon2">Buscar</span></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12" id="alertBuscar">
                                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                            <strong>Aviso!</strong>Busca un alumno dando click en el boton <b>Buscar</b>.
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5" id="divDatosAlumno" style="display:none">
                                                        <div class="col-md-12">
                                                            <div class="card text-center">
                                                                <label>Datos del Alumno seleccionado</label>
                                                                <div class="card-body">
                                                                    <img src="https://coderthemes.com/hyper_2/saas/assets/images/users/avatar-1.jpg" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                                                                    <h4 class="mb-0 mt-2" id="nombrePersona"></h4>
                                                                    <!-- <p class="text-muted font-14" id="categoriaPersona"></p> -->
                                                                    <button type="button" class="btn btn-primary mb-2" disabled>Historial Academico</button>
                                                                    <button type="button" class="btn btn-secondary mb-2" disabled>Enviar mensaje</button>
                                                                    <div class="text-start mt-3">
                                                                        <p class="text-muted mb-2 font-13"><strong>Plantel :</strong> <span class="ms-2" id="nombrePlantel"></span></p>
                                                                        <p class="text-muted mb-2 font-13"><strong>Carrera :</strong><span class="ms-2" id="nombreCarrera"></span></p>
                                                                        <p class="text-muted mb-2 font-13"><strong>Generación :</strong><span class="ms-2" id="nombreGeneracion"></span></p>
                                                                        <p class="text-muted mb-2 font-13"><strong>Ciclo :</strong><span class="ms-2" id="nombreCiclo"></span></p>
                                                                        <p class="text-muted mb-2 font-13"><strong>Periodo :</strong><span class="ms-2" id="nombrePeriodo"></span></p>
                                                                        <p class="text-muted mb-2 font-13"><strong>Grado y Grupo :</strong> <span class="ms-2 " id="carreraGrupo"></span></p>
                                                                        <p class="text-muted mb-1 font-13"><strong>Estatus :</strong> <span class="ms-2" id="estatus"></span></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                    <div class="col-md-7" id="divDatosReinscripcion" style="display:none">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h3>Datos de la reinscripcion</h3><br><br><br>
                                                                <label>Plantel</label>
                                                                <input type="text" class="form-control" placeholder="Plantel" value="" id="txtNombrePlantel" disabled>
                                                                <label>Carrera</label>
                                                                <input type="text" class="form-control" placeholder="Carrera" value="" id="txtNombreCarrera" disabled>
                                                                <label>Generación</label>
                                                                <input type="text" class="form-control" placeholder="Generacion" value="" id="txtNombreGeneracion" disabled>
                                                                <label>Salon compuesto</label>
                                                                <select class="custom-select" id="select_salon_compuesto" onchange="fnSelectSalonCompuesto(value)">
                                                                    <option value="">Seleccionar...</option>
                                                                    <?php foreach ($data['salon_compuesto'] as $key => $salonCompuesto) { ?>
                                                                        <option value="<?php echo($salonCompuesto['valuecomp']) ?>"><?php echo($salonCompuesto['nombre_salon_compuesto'].'  (periodo '.$salonCompuesto['nombre_periodo'].' / '.$salonCompuesto['nombre_grado'].' '.$salonCompuesto['nombre_grupo'].' / '.$salonCompuesto['nombre_turno'].' )') ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <!-- <label>Ciclo</label>
                                                                <select class="custom-select" id="select_ciclos" onchange="fnSelectCiclo(this)">
                                                                    <option value="">Seleccionar...</option>
                                                                    <?php foreach ($data['ciclos'] as $key => $value) { ?>
                                                                        <option value="<?php echo $value['id'] ?>"><?php echo $value['nombre_ciclo'] ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <label>Periodo</label>
                                                                <select class="custom-select" id="select_periodo" onchange="fnSelectPeriodo(this)">
                                                                    <option value="">Seleccionar...</option>
                                                                    <?php foreach ($data['periodos'] as $key => $value) { ?>
                                                                        <option value="<?php echo $value['id'] ?>"><?php echo $value['nombre_periodo'] ?></option>
                                                                    <?php }?>
                                                                </select>
                                                                <label>Grado</label>
                                                                <select class="custom-select" id="select_grado" onchange="fnSelectGrado(this)">
                                                                    <option value="">Seleccionar...</option>
                                                                    <?php foreach ($data['grados'] as $key => $value) { ?>
                                                                        <option value="<?php echo $value['id'] ?>"><?php echo $value['numero_natural'] ?></option>
                                                                    <?php }?>
                                                                </select>
                                                                <label>Grupo</label>
                                                                <select class="custom-select" id="select_grupo" onchange="fnSelectGrupo(this)">
                                                                    <option value="">Seleccionar...</option>
                                                                    <?php foreach ($data['grupos'] as $key => $value) { ?>
                                                                        <option value="<?php echo $value['id'] ?>"><?php echo $value['nombre_grupo'] ?></option>
                                                                    <?php }?>
                                                                </select> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 text-center">
                                                        <button type="button"id="btn_reinscribir" class="btn btn-primary col-md-6" onclick="fnReinscribir()">Reinscribir</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <p class="card-text">
                                                                <table id="table_reinscripcion_grupal" class="table table-bordered table-striped table-hover table-sm">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Plantel</th>
                                                                            <th>Carrera</th>
                                                                            <th>Grado</th>
                                                                            <th>Grupo</th>
                                                                            <th>Alumnos</th>
                                                                            <th>Estatus</th>
                                                                            <th>Acciones</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        
                                                                    </tbody>
                                                                </table>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="card" id="div_datos_reinscripcion">
                                                        <div class="card-body">
                                                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                                <strong>Aviso!</strong> Selecciona los alumnos en la tabla que desea reinscribir
                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <table class="table table-striped">
                                                                        <thead>
                                                                            <tr>
                                                                            <th><input type="checkbox" onclick="fnCheckAll(this)" aria-label="Checkbox for following text input"></th>
                                                                            <th scope="col">#</th>
                                                                            <th scope="col">Nombre</th>
                                                                            <th scope="col">Apellidos</th>
                                                                            <th scope="col">Calificación</th>
                                                                            <th scope="col">Estatus</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="table_alumnos_inscritos">

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <table class="table">
                                                                        <thead>
                                                                        <tr>
                                                                            <th class="text-center">De:</div>
                                                                            <th></div>
                                                                            <th class="text-center">A:</div>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>
                                                                                    <label>Grado</label>
                                                                                    <input type="text" id="grado_actual" class="form-control" value="" disabled>
                                                                                    <label>Grupo</label>
                                                                                    <input type="text" id="grupo_actual" class="form-control" value="" disabled>
                                                                                </td>
                                                                                <td>
                                                                                    <div style = "border-left: 2px solid black;height:150px;position:absolute;"></div>
                                                                                </td>
                                                                                <td>
                                                                                <label>Salon compuesto</label>
                                                                                <select class="custom-select" id="select_salon_compuesto" onchange="fnSelectSalonCompuesto(value)">
                                                                                    <option value="">Seleccionar...</option>
                                                                                    <?php foreach ($data['salon_compuesto'] as $key => $salonCompuesto) { ?>
                                                                                    <option value="<?php echo($salonCompuesto['valuecomp']) ?>"><?php echo($salonCompuesto['nombre_salon_compuesto'].'  (periodo '.$salonCompuesto['nombre_periodo'].' / '.$salonCompuesto['nombre_grado'].' '.$salonCompuesto['nombre_grupo'].' / '.$salonCompuesto['nombre_turno'].' )') ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                                    <!-- <label>Grado</label>
                                                                                    <select class="custom-select" id="select_grado_inscribir_grupal">
                                                                                        <option selected>Seleccionar...</option>
                                                                                        
                                                                                    </select>
                                                                                    <label>Grupo</label>
                                                                                    <select class="custom-select" id="select_grupo_inscribir_grupal">
                                                                                        <option selected>Seleccionar...</option>
                                                                                        
                                                                                    </select> -->
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <div class="col-12 text-center">
                                                                        <button type="button" class="btn btn-primary col-6" onclick="fnReinscibirGrupal()">Reinscribir</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="tab">
                                            <div class="row">
                                                <div class="form-group col-md-4">
                                                    <label>Régimen</label>
                                                    <input type="text" id="txtRegimenNuevo" name="txtRegimenNuevo" class="form-control form-control-sm" placeholder="EJ: Particular" maxlength="30" required>
                                                </div>
                                            </div>               
                                        </div> -->   
                                        <!-- <div class="tab">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <div class="card">
                                                        <div class="card-header row">
                                                            <div class="col-md-6">
                                                                <card-title>Plantel</card-title>  
                                                            </div>
                                                            <div class="col-md-6">
                                                                <a href="#" class="btn btn-primary btn-sm float-right" onclick="buscarImagenPlantel()" id="btnBuscarImagenPlantel">Buscar Imagen</a>
                                                            </div>  
                                                        </div>
                                                        <div class="form-group card-body text-center" id="huhshu" style="position:relative;" >
                                                            <span class="img-div">
                                                                <img src="<?php echo media();?>/images/img/logo-empty.png" id="profileDisplayPlantel" style="max-width:200px;">
                                                            </span>
                                                            <input type="file" name="profileImagePlantel" onChange="displayImagePlantel(this)" id="profileImagePlantel" class="form-control" style="display: none;"
                                                                accept=".png,.jpg,.jpeg,.svg" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>               
                                        </div>  -->   
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    footerAdmin($data);
?>