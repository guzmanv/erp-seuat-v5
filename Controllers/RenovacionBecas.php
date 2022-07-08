<?php
class RenovacionBecas extends Controllers{
    public function __construct(){
        parent::__construct();
        session_start();
        if(empty($_SESSION['login'])){
            header('Location: '.base_url().'/login');
            die();
        }
    }

    public function asignacion_becas()
    {
        $data['page_tag'] = 'Asignación becas';
        $data['page_name'] = 'Asignación becas';
        $data['page_title'] = 'Asignación becas';
        $data['page_functions_js'] = 'functions_renovacion_becas.js';
        $this->views->getView($this,'asignacion_becas',$data);
    }

    public function buscarAlumnoModal()
    {
        $data = $_GET['val'];
        $arrData = $this->model->selectAlumnoModal($data,$this->idPlantel);
    }

    public function buscarPersonaModal(){
        $data = $_GET['val'];
        
    }
    /* public function buscarPersonaModal(){
        $data = $_GET['val'];
        $arrData = $this->model->selectPersonasModal($data,$this->idPlantel);
        for($i = 0; $i <count($arrData); $i++){
            if($arrData[$i]['id_inscripcion'] == null){
                $arrData[$i]['estatus'] = '<span class="badge badge-warning">No inscrito</span>';
                $arrData[$i]['options'] = '<button type="button"  id="'.$arrData[$i]['id'].'" class="btn btn-primary btn-sm" rl="'.$arrData[$i]['nombre'].'" onclick="seleccionarPersona(this)">Seleccionar</button>';

            }else{
                $arrData[$i]['estatus'] = '<span class="badge badge-success">Inscrito</span>';
                $arrData[$i]['options'] = '<button type="button"  id="'.$arrData[$i]['id'].'" class="btn btn-secondary btn-sm" rl="'.$arrData[$i]['nombre'].'" onclick="seleccionarPersona(this)" disabled>Seleccionar</button>';

            }
        } 
        echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        die();

    } */
}