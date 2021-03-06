<?php
  headerAdmin($data);
  getModal('SalonesCompuestos/modalNuevoSalonesCompuestos',$data); 
  getModal('SalonesCompuestos/modalEditSalonesCompuestos',$data); 
?>

<div id="contentAjax"></div>
<div class="wrapper">


  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-7">
            <h1 class="m-0">  <?= $data['page_title'] ?>
              
            </h1>
          </div>
          <div class="col-sm-5">
            <ol class="breadcrumb float-sm-right btn-block">
            <button type="button" onclick="openModal();" class="btn btn-inline btn-primary btn-sm btn-block"><i class="fa fa-plus-circle fa-md"></i> Nuevo</button>
            <!--<button type="button" onclick="openModal();" class="btn btn-inline btn-primary btn-sm btn-block" data-toggle="modal" data-target="#ModalFormRol"><i class="fa fa-plus-circle fa-md"></i> Nuevo</button>-->
              <!--<li class="breadcrumb-item"><i class="fa fa-home fa-md"></i><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><a href="<?= base_url(); ?>/roles"><?= $data['page_title'] ?></a></li>-->
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
                <h3 class="card-title">Listado de salones compuestos</h3>
                <p class="card-text">
                <table id="tableSalonesCompuestos" class="table table-bordered table-striped table-hover table-sm">
                  <thead>
                  <tr>
                    <th width="7%">#</th>
                    <th width="20%">Nombre S. C.</th>
                    <th width="10%">Periodos</th>
                    <th width="10%">Año ciclo</th>
                    <th width="8%">Grados</th>
                    <th width="10%">Grupos</th>
                    <th width="15%">Instituciones</th>
                    <th width="12%">Turnos</th>
                    <th width="10%">Salones</th>
                    <th width="8%">Estatus</th>
                    <th width="17%">Acciones</th>
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