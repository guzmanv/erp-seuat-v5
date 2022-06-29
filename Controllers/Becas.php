<?php

class Becas extends Controllers{

    public function __construct()
    {
        parent::__construct();
        session_start();
        if(empty($_SESSION['login'])){
            header('Location: '.base_url().'/login');
            die();
        }
    }

    public function becas(){
        $data['page_tag'] = "Tabulador de becas";
        $data['page_title'] = "Tabulador de becas";
        $data['page_name'] = "Tabulador de becas";
        $data['periodo'] = $this->model->selectPeriodo();
        $data['carreras'] = $this->model->selectCarrera();
        $data['institucion'] = $this->model->selectInstituciones();
        $data['nivel_educativo'] = $this->model->selectNivel();
        $data['planteles'] = $this->model->selectPlanteles();
        $this->views->getView($this,"becas",$data);
    }

    public function getBecas(){
        $arrData = $this->model->selectBecas();
        for ($i=0; $i <count($arrData) ; $i++) { 
            $arrData[$i]['numeracion'] = $i+1;
            if($arrData[$i]['estatus'] == 1)
            {
                $arrData[$i]['estatus'] = '<span class="badge badge-primary">Activo</span>';
            }
            else
            {
                $arrData[$i]['estatus'] = '<span class="badge badge-primary">Inactivo</span>';
            }
            $arrData[$i]['options'] = '<div class="text-center">
                <div class=""btn-group">
                    <button type="" class="btn btn-outline-secondary btn-xs icono-color-principal dropdown-toggle" data-bd-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-layer-group"></i> &nbsp; Acciones</button>
                <div class="dropdown-menu">
                    <button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal" data-toggle="modal" data-target="#ModalEditarBeca" title="Editar"> &nbsp;&nbsp; <i class="fas fa-pencil-alt"></i> &nbsp; Editar</button>
                    <div class="dropdown-divider"></div>
                    <button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnDel" title="Eliminar"> &nbsp; Eliminar </button>
                </div>
            </div>
            </div>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    }

    public function setBecas(){
        $idBecaNuevo = 0;
        $idBecaEdit = 0;
        if(isset($_POST['idBecaNueva']))
        {
            $idBecaNuevo = intval($_POST['idBecaNueva']);
        }
        if(isset($_POST['idBecaEdit']))
        {
            $idBecaEdit = intval($_POST['idBecaEdit']);
        }
        if($idBecaNuevo == 1)
        {
            $nombreBeca = strClean($_POST['txtNuevaBeca']); 
            $descBeca = intval($_POST['txtPorcentaje']);
            $periodo = intval($_POST['slctPeriodo']);
            $carrera = intval($_POST['slctCarrera']);

            $arrData = $this->model->insertBeca($nombreBeca, $descBeca, $periodo, $carrera);

            if($arrData['estatus'] != TRUE)
            {
                $arrResponse = array('estatus' => true, 'msg' => '¡Beca agregada correctamente!');
            }
            else
            {
                $arrResponse = array('estatus' => false, 'msg' => '¡Atención la beca ya existe!');
            }
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    /* public function getTurnos()
    {
        $arrData = $this->model->selectTurnos();
        for($i=0; $i<count($arrData); $i++)
        {
            $arrData[$i]['numeracion'] = $i + 1;
            if($arrData[$i]['estatus'] == 1)
            {
                $arrData[$i]['estatus'] = '<span class="badge badge-primary">Activo</span>';
            }
            else
            {
                $arrData[$i]['estatus'] = '<span class="badge badge-secondary">Inactivo</span>';
            }
            $arrData[$i]['options'] = '<div class="text-center">
            <div class="btn-group">
                <button type="" class="btn btn-outline-secondary btn-xs icono-color-principal dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-layer-group"></i> &nbsp; Acciones
                </button>
                <div class="dropdown-menu">
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnEditSalon" onClick="fnEditarTurno('. $arrData[$i]['id'] .')" data-toggle="modal" data-target="#ModalEditTurno" title="Editar"> &nbsp;&nbsp; <i class="fas fa-pencil-alt"></i> &nbsp; Editar</button>
						<div class="dropdown-divider"></div>
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnDelSalon" onClick="fnEliminarTurno('.$arrData[$i]['id'].')" title="Eliminar"> &nbsp;&nbsp; <i class="far fa-trash-alt "></i> &nbsp; Eliminar</button>
						<!--<a class="dropdown-item" href="#">link</a>-->
				</div>
            </div>

            </div>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    } */
}