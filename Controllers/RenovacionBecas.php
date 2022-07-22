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
        $arrData = $this->model->selectReinscritos();
        for ($i = 0; $i < count($arrData); $i++) {
                $arrData[$i]['numeracion'] = $i+1;
                $arrData[$i]['promedio'] = '<span class="badge badge-success">'.$arrData[$i]['promedio'].'</span>';
                $arrData[$i]['options'] =
                '<div class="text-center">
                    <div class="btn-group">
                        <button type="" class="btn btn-outline-secondary btn-xs icono-color-principal dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-layer-group"></i> &nbsp; Acciones</button>
                        <div class="dropdown-menu">
                            <button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnEditSalon" data-toggle="modal" data-target="#modalConfirmarRenovacion" onclick="fnRatificar('.$arrData[$i]['id'].')" title="RenovarBeca"> &nbsp;&nbsp; <i class="fas fa-pencil-alt"></i> &nbsp; Ratificar beca</button>
                        </div>
                    </div>
                </div>';
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

    public function getEstudianteAsig(int $idInscripcion)
    {
        $intIdIns = $idInscripcion;
        if($intIdIns > 0)
        {
            $data['datosEstudiante'] = $this->model->selectAlumnoAsignacion($intIdIns);
            $data['datosBeca'] = $this->model->selectBecaAsignar();
            if($data['datosEstudiante']['id_plan_estudios'] == $data['datosBeca']['id_plan_estudios']){
                if($data['datosEstudiante']['id_periodos'] == $data['datosBeca']['id_periodos']){
                    if($data['datosEstudiante']['promedio'] == $data['datosBeca']['promedio']){
                        $data['montos'] = $this->model->selectMontos($data['datosBeca']['id_plan_estudios'],$data['datosBeca']['id_periodos']);
                        
                        for ($i=0; $i < count($data['montos']) ; $i++) {
                            $data[$i]['montos']['monto_descuento'] = ($data[$i]['montos']['cobro_total']*$data['datosBeca']['porcentaje_descuento'])/100;
                            //$montos = ($data[$i]['montos']['cobro_total'] * $data['datosBeca']['porcentaje_descuento']) / 100;
                            //$data['monto_con_descuentos']['montodescontado'] = ($data[$i]['montos']['cobro_total'] * $data['datosBeca']['porcentaje_descuento']) / 100;
                        }
                    }
                }
            }
        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function getAsignaciones(){
        $arrData = $this->model->selectAsignacion();
        for ($i=0; $i < count($arrData); $i++) { 
            $arrData['numeracion'] = $i + 1;
            $arrData['options'] = '<div class="text-center">
            <div class="btn-group">
                <button type="" class="btn btn-outline-secondary btn-xs icono-color-principal dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-layer-group"></i> &nbsp; Acciones
                </button>
                <div class="dropdown-menu">
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnEditSalon" title="Editar"> &nbsp;&nbsp; <i class="fas fa-pencil-alt"></i> &nbsp; Reimprimir ratificación</button>
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