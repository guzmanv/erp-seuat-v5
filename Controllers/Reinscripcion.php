<?php
	class Reinscripcion extends Controllers{

        private $idUser;
		private $rol;
        private $idPlantel;
		public function __construct(){
			parent::__construct();
			session_start();
			if(empty($_SESSION['login'])){
				header('Location: '.base_url().'/login');
				die();
			}
            $this->idUser = $_SESSION['idUser'];
			$this->rol = 'aux';
            $this->idPlantel = 1;
		}
		public function reinscripcion(){
			$data['page_tag'] = "Reinscripcion";
			$data['page_title'] = "Reinscripcion";
			$data['page_name'] = "Reinscripcion";
			$data['page_functions_js'] = "functions_reinscripcion.js";
            /* $data['ciclos'] = $this->model->selectCiclos();
            $data['periodos'] = $this->model->selectPeriodo();
            $data['grados'] = $this->model->selectGrado();
            $data['grupos'] = $this->model->selectGrupo(); */
            $data['salon_compuesto'] = $this->model->selectSalonesCompuestos();
			$this->views->getView($this,"reinscripcion",$data);
		}

        //Buscar Persona del en el Modal Inscripcion
        public function buscarPersonaModal(){
            $data = $_GET['val'];
            $arrData = $this->model->selectPersonasModal($data);
            for($i = 0; $i <count($arrData); $i++){
                $arrData[$i]['apellidos'] = $arrData[$i]['ap_paterno'].' '.$arrData[$i]['ap_materno'];
                $arrData[$i]['options'] = '<button type="button"  id="'.$arrData[$i]['id'].'" class="btn btn-secondary btn-sm" rl="'.$arrData[$i]['nombre_persona'].' '.$arrData[$i]['apellidos'].'" onclick="seleccionarPersona(this)">Seleccionar</button>';
            }
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();

        }

        public function getDatosAlumno(int $id){
            $arrData = $this->model->selectDatosAlumno($id);
            if($arrData['estatus'] == 1){
                $arrData['estatus'] = '<span class="badge badge-pill badge-success">Activo</span>';
            }else{
                $arrData['estatus'] = '<span class="badge badge-pill badge-warning">Innactivo</span>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function setReinscripcionIndividual($args)
        {
            $folio = $this->selectFolioConsecutivo($this->idPlantel);
            $arrArgs = explode(",",$args);
            $idTurno = $arrArgs[0];
            $idPlanEstudio = $arrArgs[1];
            $idPersona = $arrArgs[2];
            $idTutor = $arrArgs[3];
            $idDocumentos = $arrArgs[4];
            $idSubcampania = $arrArgs[5];
            $idSalonCompuesto = $arrArgs[6];
            $idHistorial = $arrArgs[7];
            $idGrado = $arrArgs[8];
            if($folio != ''){
                $arrResponse = $this->model->insertReinscripcion($folio,$this->idUser,$idTurno,$idPlanEstudio,$idPersona,$idTutor,$idDocumentos,$idSubcampania,$idSalonCompuesto,$idHistorial,$idGrado);
                if($arrResponse){
                    $arrResponse = array('estatus' => true, 'msg' => 'Reinscripcion realizada correctamente');
                }else{
                    $arrResponse = array('estatus' => false, 'msg' => 'No se pudo realizar la reinscripcion');
                }
            }else{
                $arrResponse = array('estatus' => false, 'msg' => 'No se pudo obtener el Folio');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function selectFolioConsecutivo($idPlantel)
        {
            $anioActual = date('Y');
            $resCodigoPlantel = $this->model->selectFolioPlantel($idPlantel);
            $folioIdentificador = $resCodigoPlantel['folio_identificador'];
            $resCountInscripciones = $this->model->selectCountInscripciones($folioIdentificador);
            $request_folio_sistema_format = str_pad($resCountInscripciones['total']+1 ,5,"0",STR_PAD_LEFT);
            $folioSistema = $folioIdentificador.$anioActual.($request_folio_sistema_format);
            return $folioSistema;

        }

        public function getReinscripciones()
        {
            $arrData = $this->model->selectReinscripciones();
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
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getInscripciones()
        {
            $arrData = $this->model->selectInscripciones();
            for($i = 0; $i<count($arrData); $i++){
                $arrData[$i]['numeracion'] = $i+1;
                $arrData[$i]['total_alumnos'] = '<h5><span class="badge badge-warning pr-2 pl-2">'.$arrData[$i]['total'].' alumnos</span></h5>';
                $values = $arrData[$i]['values_select'];
                $arrData[$i]['options'] = '<button type="button" class="btn btn-primary btn-xs" onclick="fnVerEstudiantes('.$values.')">Ver</button>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getAlumnosInscritos($args)
        {
            $arrArgs = explode(",",$args);
            $idPlantel = $arrArgs[0];
            $idInstitucion = $arrArgs[1];
            $idPlanEstudio = $arrArgs[2];
            $idGrado = $arrArgs[3];
            $idGrupo = $arrArgs[4];
            $arrData = $this->model->selectAlumnosInscritos($idPlantel,$idInstitucion,$idPlanEstudio,$idGrado,$idGrupo);
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        }
	}
?>