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

    public function getMedioCatpacion(int $idMedio)
    {
        $intIdMedio = intval($idMedio);
        if($intIdMedio > 0)
        {
            $arrData = $this->model->selectMedioCaptacion();
            if(empty($arrData)){
                $arrResponse = array('estatus' => true, 'msg' => 'Datos no encontrados');
            }
            else
            {
                
            }
        }
        

    }
}