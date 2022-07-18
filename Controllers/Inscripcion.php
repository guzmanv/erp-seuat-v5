<?php
    class Inscripcion extends Controllers{
        private $idUser;
		private $rol;
        private $idPlantel;
		public function __construct()
		{
			parent::__construct();
			session_start();
		    if(empty($_SESSION['login']))
		    {
			    header('Location: '.base_url().'/login');
			    die();
		    }
			$this->idUser = $_SESSION['idUser'];
			$this->rol = 'aux';
            $this->idPlantel = 1;
		}
        //Mostrar vista de ingresos
        public function inscripcion(){
            $data['page_id'] = 10;
            $data['page_tag'] = "Inscripcion";
            $data['page_title'] = "Inscripcion";
            $data['page_content'] = "";
            $data['planteles'] = $this->model->selectPlanteles();
            $data['niveles_educativos'] = $this->model->selectNivelesEducativos();
            $data['salones_compuestos'] = $this->model->selectSalonesCompuestos();
            $data['page_functions_js'] = "functions_inscripcion.js";
            $this->views->getView($this,"inscripcion",$data);
            
        }
        public function getInscripciones()
        {
            $arrData = $this->model->selectInscripciones();
            for($i = 0; $i<count($arrData); $i++){
                $arrData[$i]['numeracion'] = $i+1;
                $arrData[$i]['total_alumnos'] = '<h5><span class="badge badge-warning pr-2 pl-2">'.$arrData[$i]['total'].' alumnos</span></h5>';
                $arrData[$i]['options'] = '<div class="text-center">
				<div class="btn-group">
					<button type="button" class="btn btn-outline-secondary btn-xs icono-color-principal dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-layer-group"></i> &nbsp; Acciones
					</button>
					<div class="dropdown-menu">
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal" onClick="fnVerListaInscritos('.$arrData[$i]['id_plantel'].')"  title="Ver"> &nbsp;&nbsp; <i class="fas fa-eye icono-azul"></i> &nbsp; Ver alumnos</button>
						<div class="dropdown-divider"></div>
						
					</div>
				</div>
				</div>';
            }
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getPreinscritos($args)
        {
            $arrArgs = explode(",",$args);
            $idPlantel = $arrArgs[0];
            $idInstitucion = $arrArgs[1];
            $idNivelEducativo = $arrArgs[2];
            $idPlanEstudios = $arrArgs[3];
            if($idPlantel == 'null' && $idInstitucion == 'null' && $idNivelEducativo == 'null' && $idPlanEstudios == 'null'){
                $arrData = $this->model->selectPreinscritos(null,null,null,null);
            }else if($idPlantel != 'null' && $idInstitucion == 'null' && $idNivelEducativo == 'null' && $idPlanEstudios == 'null'){
                $arrData = $this->model->selectPreinscritos($idPlantel,null,null,null); 
            }else if($idPlantel != 'null' && $idInstitucion != 'null' && $idNivelEducativo == 'null' && $idPlanEstudios == 'null'){
                $arrData = $this->model->selectPreinscritos($idPlantel,$idInstitucion,null,null);
            }else if($idPlantel != 'null' && $idInstitucion != 'null' && $idNivelEducativo != 'null' && $idPlanEstudios == 'null'){
                $arrData = $this->model->selectPreinscritos($idPlantel,$idInstitucion,$idNivelEducativo,null);
            }else if($idPlantel != 'null' && $idInstitucion != 'null' && $idNivelEducativo != 'null' && $idPlanEstudios != 'null'){
                $arrData = $this->model->selectPreinscritos($idPlantel,$idInstitucion,$idNivelEducativo,$idPlanEstudios);
            }
            for($i = 0; $i<count($arrData); $i++){
                $arrData[$i]['numeracion'] = $i+1;
                $idPersona = $arrData[$i]['id_personas'];
                $resEstatusCta = $this->selectEstatusEdoCta($idPersona);
                $arrData[$i]['observacion'] = $resEstatusCta;
                $arrData[$i]['estatus'] = ($resEstatusCta == '')?true:false;
                $arrData[$i]['options'] = "";
            }
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function getInstituciones(int $idPlantel)
        {
            $responseInstituciones = $this->model->selectInstituciones($idPlantel);
            echo json_encode($responseInstituciones,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function setInscripcion($args)
        {
            $arrArgs = explode(",",$args);
            $idSalonCompuesto = $arrArgs[0];
            $arrAlumnos = json_decode(base64_decode($arrArgs[1]));
            $num_max_alumno = 2;
            if(count($arrAlumnos) > 0){
                if(count($arrAlumnos) <= $num_max_alumno){
                    foreach ($arrAlumnos as $key => $alumno) {
                        $idPersona = $alumno;
                        $response = $this->model->insertInscripcion($idPersona,$idSalonCompuesto,$this->idUser);
                    }
                    $arrResponse = array('estatus' => true, 'msg' => 'Se completó correctamente la inscripción.');
                }else{
                    $arrResponse = array('estatus' => false, 'msg' => 'El numero maximo de alumnos admitidas es '.$num_max_alumno.'.');
                } 
            }else{
                $arrResponse = array('estatus' => false, 'msg' => 'Al menos selecciona un alumno.');
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function selectEstatusEdoCta(int $idPersona)
        {
            $arrData = $this->model->selectEstatusEdoCta($idPersona);
            $totalEdoCta = count($arrData);
            if($totalEdoCta == 0){
                return "<a class='badge badge-danger'>Deuda en caja</a>";
            }else{
                return "";
            }
        }
        public function getPlanEstudios($args)
        {
            $arrArgs = explode(",",$args);
            $idPlantel = $arrArgs[0];
            $idInstitucion = $arrArgs[1];
            $idNivelEducativo = $arrArgs[2];
            if($idPlantel != 'null' || $idInstitucion != ''|| $idNivelEducativo != ''){
                $arrPlanEstudios = $this->model->selectPlanEstudios($idPlantel,$idInstitucion,$idNivelEducativo);
            }
            echo json_encode($arrPlanEstudios,JSON_UNESCAPED_UNICODE);
            die();
        }
    }
?>