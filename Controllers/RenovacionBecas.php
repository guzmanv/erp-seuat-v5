<?php
class RenovacionBecas extends Controllers{
    public function __construct(){
        parent::__construct();
        session_start();
        /* if(empty($_SESSION['login'])){
            header('Location: '.base_url().'/login');
            die();
        } */ 
    }

    public function getReinscritos()
    {
        $data = $_GET['val'];
        $arrData = $this->model->selectAlumno($data);
        for($i = 0; $i <count($arrData); $i++){
            if($arrData[$i]['id_inscripcion'] != null)
            {
                $arrData[$i]['options'] = '<button type="button" id="'.$arrData[$i]['id'].'" class="btn btn-secondary btn-sm" rl="'.$arrData[$i]['nombre_completo'].'" onclick="seleccionarPersona(this)">Seleccionar estudiante</button>';
            }
            /* if($arrData[$i]['id_inscripcion'] == null){
                $arrData[$i]['estatus'] = '<span class="badge badge-warning">No inscrito</span>';
                $arrData[$i]['options'] = '<button type="button"  id="'.$arrData[$i]['id'].'" class="btn btn-primary btn-sm" rl="'.$arrData[$i]['nombre'].'" onclick="seleccionarPersona(this)">Seleccionar</button>';

            }else{
                $arrData[$i]['estatus'] = '<span class="badge badge-success">Inscrito</span>';
                $arrData[$i]['options'] = '<button type="button"  id="'.$arrData[$i]['id'].'" class="btn btn-secondary btn-sm" rl="'.$arrData[$i]['nombre'].'" onclick="seleccionarPersona(this)" disabled>Seleccionar</button>';

            }*/
        } 
        echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        die();
    }

    public function asignacion_becas()
    {
        $data['page_tag'] = 'Asignación becas';
        $data['page_name'] = 'Asignación becas';
        $data['page_title'] = 'Asignación becas';
        $data['page_functions_js'] = 'functions_renovacion_becas.js';
        $this->views->getView($this,'asignacion_becas',$data);
    }

    public function getAsignaciones(){
        $arrData = $this->model->selectAsignacion();
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getBecados(){
        $arrData = $this->model->selectBecados();
        for ($i=0; $i < count($arrData); $i++) { 
            $arrData['numeracion'] = $i+1;
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
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnEditSalon" onClick="fnEditarTurno('. $arrData[$i]['id'] .')" data-toggle="modal" data-target="#ModalEditTurno" title="Editar"> &nbsp;&nbsp; <i class="fas fa-pencil-alt"></i> &nbsp; Reimprimir ratificación</button>
						<div class="dropdown-divider"></div>
						<!--<a class="dropdown-item" href="#">link</a>-->
				</div>
            </div>

            </div>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }
}