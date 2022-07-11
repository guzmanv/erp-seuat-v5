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
	}
?>