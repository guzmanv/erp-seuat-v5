<?php
headerAdmin($data);
getModal('Becas/modalNuevaBeca', $data);
getModal('Becas/modalEditBeca', $data);
?>
<div class="wrapper">
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-7">
                        <h1 class="m-0"> <?= $data['page_title'] ?></h1>
                    </div>
                    <div class="col-sm-5">
                        <ol class="breadcrumb float-sm-right btn-block">
                            <button type="button" id="btnNuevoTurno" class="btn btn-inline btn-primary btn-sm btn-block" data-toggle="modal" data-target="#ModalNuevaBeca"><i class="fa fa-plus-circle fa-md"></i> Nueva beca</button>
                        </ol>
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
                                    <table id="tableBecas" class="table table-bordered table-hover table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre de beca</th>
                                                <th>Porcentaje de descuento</th>
                                                <th>Estatus</th>
                                                <th>Periodo</th>
                                                <th>Carrera</th>
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