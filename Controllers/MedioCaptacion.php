<?php

class MedioCaptacion extends Controllers{

    function __construct()
    {
        parent::__construct();
        session_start();
        if(empty($_SESSION['login'])){
            header('Location: '.base_url().'/login');
            die();
        }
    }

    public function MedioCaptacion(){
        $data['page_tag'] = "Medios de captación";
        $data['page_title'] = "Medios de captación";
        $data['page_name'] = "medio_captacion";
        $data['page_functions_js'] = "functions_mediocaptacion.js";
        $this->views->getView($this,"mediocaptacion",$data);
    }

    public function getMediosCaptacion(){
        $arrData = $this->model->selectMediosCaptacion();
        for ($i=0; $i < count($arrData); $i++) 
        { 
            $arrData[$i]['numeracion'] = $i + 1;
            if ($arrData[$i]['estatus'] == 1) 
            {
                $arrData[$i]['estatus'] = '<span class="badge badge-primary">Activo</span>';
            } else 
            {
                $arrData[$i]['estatus'] = '<span class="badge badge-secondary">Inactivo</span>';
            }
            $arrData[$i]['options'] = '<div class="text-center">
            <div class="btn-group">
                <button type="" class="btn btn-outline-secondary btn-xs icono-color-principal dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-layer-group"></i> &nbsp; Acciones
                </button>
                <div class="dropdown-menu">
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnEditSalon" onClick="fnEditarMedCap('.$arrData[$i]['id'].')" data-toggle="modal" data-target="#modalEditMedioCaptacion" title="Editar"> &nbsp;&nbsp; <i class="fas fa-pencil-alt"></i> &nbsp; Editar</button>
						<div class="dropdown-divider"></div>
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnDelSalon" onClick="fnEliminarMedCap('.$arrData[$i]['id'].')" title="Eliminar"> &nbsp;&nbsp; <i class="far fa-trash-alt "></i> &nbsp; Eliminar</button>
						<!--<a class="dropdown-item" href="#">link</a>-->
				</div>
            </div>

            </div>'; 
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    }


    public function getMedioCaptacion(int $id)
    {
        $idMedio = intval(strClean($id));
        if($idMedio > 0){
            $arrData = $this->model->selectMedioCaptacion($idMedio);
            if(empty($arrData)){
                $arrResponse = array('estatus' => false, 'msg' => 'Datos no encontrados');
            }
            else{
                $arrResponse = array('estatus' => true, 'data'=>$arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setMedioCaptacion()
    {
        $idMedioEdit = 0;
        $idMedioNvo = 0;

        if(isset($_POST['idMedCapNvo'])){
            $idMedioNvo  = intval($_POST['idMedioCapNvo']);
        }
        if(isset($_POST['idMedCapEdit'])){
            $idMedioEdit = intval($_POST['idMedCapEdit']);
        }

        if($idMedioNvo == 1)
        {
            $strMedio = strClean($_POST['txtMedioCaptacionNvo']);
            //$arrData = $this->model->insertMedio($strMedio);
            /* if($arrData['estatus'] != TRUE)
            {
                $arrResponse = array('estatus'=> true, 'msg'=> '¡Datos guardados correctamente!');
            }
            else
            {
                $arrResponse = array('estatus'=> false, 'msg' => 'Atención, el medio ya existe');
            } */
        }
        echo json_encode($$_POST, JSON_UNESCAPED_UNICODE);
        die();
    }
}