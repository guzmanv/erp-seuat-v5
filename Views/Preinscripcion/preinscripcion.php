<?php
    headerAdmin($data);
    getModal("Preinscripcion/modalNuevaInscripcion",$data);
    getModal("Preinscripcion/modalDocumentacion",$data);
    getModal("Preinscripcion/modalEditInscripcion",$data);
    getModal("Preinscripcion/modalListaInscritos",$data);
;
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
                            <?php 
                                if($data['rol'] == 'admin' || $data['rol'] == 'superadmin' || $data['new'] == false){

                                }else{ ?>
                                    <button type="button" onclick="fnNuevaInscripcion()" class="btn btn-inline btn-primary btn-sm btn-block" data-toggle="modal" data-target="#ModalFormNuevaInscripcion"><i class="fa fa-plus-circle fa-md"></i>Nuevo</button>
                                <?php }
                            ?>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <?php if($data['rol'] == 'admin' || $data['rol'] == 'superadmin'){ ?>
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-6">
                                        <select class="custom-select" id="listPlantelDatatable" onchange="fnPlantelSeleccionadoDatatable(value)">
                                            <option selected>Todos</option>
                                            <?php 
                                                foreach ($data['planteles'] as $key => $plantel) {
                                                    ?>
                                                        <option value="<?php echo $plantel['id'] ?>"><?php echo $plantel['nombre_plantel_fisico'].' ( '.$plantel['municipio'].' )' ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <?php }else {  ?>
                            <div class="card" style="display: none;">
                                <div class="card-body">
                                    <div class="col-md-6">
                                        <select class="custom-select" id="listPlantelDatatable" onchange="fnPlantelSeleccionadoDatatable(value)">
                                        <?php 
                                                foreach ($data['planteles'] as $key => $plantel) {
                                                    if($plantel['id'] == $data['idPlantel']){  //Plantel Tuxtla
                                                        ?>
                                                            <option value="<?php echo $plantel['id'] ?>"><?php echo $plantel['nombre_plantel_fisico'].' ( '.$plantel['municipio'].' )' ?></option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title" id="nombrePlantelDatatable"></h2>
                                <p class="card-text">
                                    <table id="tableInscripciones" class="table table-bordared table-hover table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre de la Carrera</th>
                                                <th>Nivel Educativo</th>
                                                <th>Grado</th> 
                                                <th>Plan</th>
                                                <th>Turno</th>
                                                <th>Grupo</th>
                                                <th>Total inscritos</th>
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
        </div>
    </div>
</div>
<?php
    footerAdmin($data);
?>