<?php
    headerAdmin($data);
    getModal('Inscripcion/modalNuevaInscripcion',$data);
?>
<div id="contentAjax"></div>
<div class="wrapper">
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-7">
                        <h1 class="m-0">  <?= $data['page_title'] ?></h1>
                    </div>
                    <div class="col-sm-5">
                        <ol class="breadcrumb float-sm-right btn-block">
                            <button type="button"  class="btn btn-inline btn-primary btn-sm btn-block" data-toggle="modal"  onclick="btnNuevoGrupoCompuesto()" data-target="#modal_form_nueva"><i class="fa fa-plus-circle fa-md"></i> Nuevo</button>
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
                               <p class="card-text">
                                    <table id="tableInscripciones" class="table table-bordered table-striped table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Plantel</th>
                                                <th>Institucion</th>
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
        </div>
    </div>
</div>
<?php footerAdmin($data); ?>


