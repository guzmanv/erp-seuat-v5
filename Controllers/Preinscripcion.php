
<?php
    class Preinscripcion extends Controllers{
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
        //Funcion para mostrar Vista(Admision)
        public function admision(){
            $data['page_id'] = 10;
            $data['page_tag'] = "Preinscripcion";
            $data['page_title'] = "Preinscripciones";
            $data['page_content'] = "";
            $data['planteles'] = $this->model->selectPlanteles();
            $data['sistemas_educativos'] = $this->model->selectSistemasEducativos();
            $data['grados'] = $this->model->selectGrados();
            $data['subcampanias'] = $this->model->selectSubcampanias();
            $data['turnos'] = $this->model->selectturnos();
            $data['niveles_educativos'] = $this->model->selectNivelesEducativos();
            $data['promocion_inscripcion'] = $this->model->selectPromocionesInscripcion();
            $data['page_functions_js'] = "functions_preinscripciones_admision.js";
            $data['rol'] = $this->rol;
            $data['idPlantel'] = $this->idPlantel;
            $this->views->getView($this,"preinscripcion",$data);
        }
        //Funcion para mostrar Vista(ControlEscolar)
        public function controlescolar(){
            $data['page_id'] = 10;
            $data['page_tag'] = "Preinscripcion";
            $data['page_title'] = "Preinscripciones";
            $data['page_content'] = "";
            $data['planteles'] = $this->model->selectPlanteles();
            $data['grados'] = $this->model->selectGrados();
            $data['subcampanias'] = $this->model->selectSubcampanias();
            $data['niveles_educativos'] = $this->model->selectNivelesEducativos();
            $data['turnos'] = $this->model->selectturnos();
            $data['rol'] = $this->rol;
            $data['idPlantel'] = $this->idPlantel;
            $data['promocion_inscripcion'] = $this->model->selectPromocionesInscripcion();
            //$data['promocion_colegiatura'] = $this->model->selectPromocionesColegiatura(null);
            $data['page_functions_js'] = "functions_preinscripciones_controlescolar.js";
            $this->views->getView($this,"preinscripcion",$data);
            
        }
        //Obtener Lista de Inscripciones(Admision)
        public function getInscripcionesAdmision(){
            $idPlantel = $_GET['plantel'];
            if($idPlantel == 'Todos'){
                $arrInscripciones = $this->model->selectInscripcionesAdmision();
                for($i = 0; $i<count($arrInscripciones); $i++){
                    $arrInscripciones[$i]['numeracion'] = $i+1;
                    if($arrInscripciones[$i]['nombre_grupo'] == null){
                        $arrInscripciones[$i]['nombre_grupo'] = "Sin grupo";
                    }
                    $arrInscripciones[$i]['total'] = '<h5><span class="badge badge-secondary pr-2 pl-2">'.$arrInscripciones[$i]['total'].'</span></h5>';
                    $arrInscripciones[$i]['options'] = '<button type="button"  id="'.$arrInscripciones[$i]['id'].'" gr="'.$arrInscripciones[$i]['id_grados'].'" tr="'.$arrInscripciones[$i]['id_turno'].'" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalFormListaInscritos" onclick="fnListaInscritos(this)">Ver</button>';    
                }
            }else{
                $idPlantel = intval($idPlantel);
                $arrInscripciones = $this->model->selectInscripcionesAdmisionByPlantel($idPlantel);
                for($i = 0; $i<count($arrInscripciones); $i++){
                    $arrInscripciones[$i]['numeracion'] = $i+1;
                    if($arrInscripciones[$i]['nombre_grupo'] == null){
                        $arrInscripciones[$i]['nombre_grupo'] = "Sin grupo";
                    }
                    $arrInscripciones[$i]['total'] = '<h5><span class="badge badge-secondary pr-2 pl-2">'.$arrInscripciones[$i]['total'].'</span></h5>';
                    $arrInscripciones[$i]['options'] = '<button type="button"  id="'.$arrInscripciones[$i]['id'].'" gr="'.$arrInscripciones[$i]['id_grados'].'" tr="'.$arrInscripciones[$i]['id_turno'].'" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalFormListaInscritos" onclick="fnListaInscritos(this)">Ver</button>';    
                }
            }
            echo json_encode($arrInscripciones,JSON_UNESCAPED_UNICODE);
            die();
        }
        //Obtener Lista de Inscripciones(ControlEscolar)
        public function getInscripcionesControlEscolar(){
            $idPlantel = $_GET['idplantel'];
            $arrData = $this->model->selectInscripcionesControlEscolar($idPlantel);
            for ($i=0; $i<count($arrData); $i++){
                $arrData[$i]['numeracion'] = $i+1;
                /* if($arrData[$i]['validacion'] == 1){
                    $arrData[$i]['validacion'] = '<span class="badge badge-success">Validado</span>';
                }else{
                    $arrData[$i]['validacion'] = '<span class="badge badge-warning">No Validado</span>';
                } */
                if($arrData[$i]['nombre_grupo'] == null){
                    $arrData[$i]['nombre_grupo'] = "Sin grupo";
                }else{
                    
                }
                if($arrData[$i]['total'] >= 4){
                    $arrData[$i]['total'] = '<h5><span class="badge badge-success pr-2 pl-2">'.$arrData[$i]['total'].' alumnos</span></h5>';
                }else{
                    $arrData[$i]['total'] = '<h5><span class="badge badge-warning pr-2 pl-2">'.$arrData[$i]['total'].' alumnos</span></h5>';
                }
                $arrData[$i]['options'] = '<button type="button"  id="'.$arrData[$i]['id'].'" gr="'.$arrData[$i]['grado'].'" tr="'.$arrData[$i]['id_turno'].'" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalFormListaInscritos" onclick="fnListaInscritos(this)">Ver</button>'; 
            }
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }
        //Buscar Persona del en el Modal Inscripcion
        public function buscarPersonaModal(){
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

        }
        //Guardar Inscripcion
        public function setInscripcion(){
            $data = $_POST;
            $intIdInscripcionNueva = 0;
            $intIdInscripcionEdit = 0;
            if(isset($_POST['idNuevo'])){
                $intIdInscripcionNueva = intval($_POST['idNuevo']);
            }
            if(isset($_POST['idEdit'])){
                $intIdInscripcionEdit = intval($_POST['idEdit']);
            }
            if(isset($_POST['chck_colegiatura'])){
                $checkColegiatura = 1;
                $selectcolegiatura = $_POST['select_chck_colegiaturas'];
                $arrColegitura = explode(',',$selectcolegiatura);
                $idPrecargaCol = $arrColegitura[0];
                $idServicioCol = $arrColegitura[1];
                $porcentajeCol = $arrColegitura[2];
                $precioCol = $arrColegitura[3];
            }else{
                $checkColegiatura = 0;
                $idPrecargaCol = null;
                $idServicioCol = null;
                $porcentajeCol = null;
                $precioCol = null;
            }
            if(isset($_POST['chck_inscripcion'])){
                $checkInscripcion = 1;
                $selectInscripcion = $_POST['select_chck_inscripcion'];
                $arrInscripcion = explode(',',$selectInscripcion);
                $idPrecargaIns = $arrInscripcion[0];
                $idServicioIns = $arrInscripcion[1];
                $porcentajeIns = $arrInscripcion[2];
                $precioIns = $arrInscripcion[3];
            }else{
                $checkInscripcion = 0;
                $idPrecargaIns = null;
                $idServicioIns = null;
                $porcentajeIns = null;
                $precioIns = null;
            }
            //Nueva
            if($intIdInscripcionNueva == 0){
                if($_POST['idSubcampaniaNuevo'] != ''){
                    $idPersona = $data['idPersonaSeleccionada'];
                    //$arrProspecto = $this->model->selectProspecto($idPersona); 
                    //$folioTransferencia = ($arrProspecto['folio_transferencia'] == '')?null:$arrProspecto['folio_transferencia'];
                    //$plantelOrigen = ($arrProspecto['id_plantel_prospectado'] == '')?null:$arrProspecto['id_plantel_prospectado']; 
                    $arrData = $this->model->insertInscripcion($data,$this->idUser, $this->idPlantel,$checkColegiatura,$checkInscripcion);
                    if($arrData){
                        $folioInscripcion = $arrData['folio'];
                        $idInscripcion = $arrData['inscripcion'];

                        $totalCol = $precioCol - ($precioCol*($porcentajeCol/100));
                        $totalIns = $precioIns - ($precioIns*($porcentajeIns/100));
                        if($checkColegiatura == 1 || $checkInscripcion == 1 ){
                            $arrTmpInscirpcion = $this->model->insertTempInscripcion($folioInscripcion,$precioIns,$porcentajeIns,$totalIns,$precioCol,$porcentajeCol,$totalCol,$idPersona,$idInscripcion,$idServicioCol,$idServicioIns);
                            if($arrTmpInscirpcion){
                                $arrResponse = array('estatus' => true,'data'=> $idInscripcion, 'msg' => 'Inscripcion realizado correctamente!');
                            }
                        }
                    }else{
                        $arrResponse = array('estatus' => false, 'msg' => 'No se pudo realizar la inscripcion');
                    } 
                }else{
                    $arrResponse = array('estatus' => false, 'msg' => 'No es posible guardar sin subcampaña');
                }
            }
            //Editar
            if($intIdInscripcionEdit !=0){
                $arrData = $this->model->updateInscripcion($intIdInscripcionEdit,$data, $this->nomConexion);
                if($arrData){
                    $arrResponse = array('estatus' => true, 'msg' => 'Datos Actualizados Correctamente');
                }else{
                    $arrResponse = array('estatus' => false, 'msg' => 'No es posible Actualizar los datos');
                }
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }

        //Obtener lista de niveles educativos
        public function getNivelesEducativos(){
            $nomConexion = $_GET['conexion'];
            $arrData = $this->model->selectNivelesEducativos($nomConexion);
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            die();
        }
        //Obtener Lista de Carreras
        public function getCarreras(){
            //&$nomConexion = $_GET['conexion'];
            $nivel = $_GET['nivel'];
            $idPlantel = $_GET['idplantel'];
            $arrData = $this->model->selectCarreras($nivel,$idPlantel);
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }
        //Obtener Datos de Persona
        public function getPersona(){
            $idPersona = $_GET['id'];
            $arrData = $this->model->selectPersona($idPersona);
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }

        //Obtener lista de Grados
        public function getGrados(){
            $nomConexion = $_GET['conexion'];
            $arrData = $this->model->selectGrados($nomConexion);
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }

        //Obtener lista de turnos
        public function getTurnos(){
            $nomConexion = $_GET['conexion'];
            $arrData = $this->model->selectturnos($nomConexion);
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }

        //Obtener la campania actual
        public function getCampaniaActual(){
            $nomConexion = $_GET['conexion'];
            $arrData = $this->model->selectSubcampanias($nomConexion);
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }

        //Obtener Lista de Documentos
        public function getDocumentos(){
            $id = $_GET['id_alumno'];
            $arrData = $this->model->selectDocumentacion($id, $this->nomConexion);
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }

        //Obtener Inscripcion por ID
        public function getInscripcion(int $idInscripcion){
            $arrData = $this->model->selectInscripcion($idInscripcion, $this->nomConexion);
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }

        //Obtener Lista de Inscritos en una Carrera
        public function getInscritos(){
            $idCarrera = $_GET['idCarrera'];
            $grado = $_GET['grado'];
            $turno = $_GET['turno'];
            $arrData = $this->model->selectInscritos($idCarrera,$grado, $turno);
            for ($i=0; $i<count($arrData); $i++){
                $arrData[$i]['numeracion'] = $i+1;
                $arrData[$i]['estatus'] = ($arrData[$i]['pospuesto'] == 1)?'<span class="badge badge-warning">Pospuesto</span>':'';
                $arrData[$i]['isdisabled'] = ($arrData[$i]['pospuesto'] == 1)?true:false;
            }
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }
        //Imprimir solicitud de inscripcion
        public function imprimir_solicitud_inscripcion($idInscripcion){
            $idInscripcion = $idInscripcion;
            $arrDataIns = $this->model->selectDatosImprimirSolInscricpion($idInscripcion);
            $idPlanEstudio = $arrDataIns['id_plan_estudio'];
            $arrDataDoc = $this->model->selectDocumentacionInscripcion($idPlanEstudio);
            $data['datos'] = $arrDataIns;
            $data['doc'] = $arrDataDoc;
            $this->views->getView($this,"viewpdf",$data); 
           
            
        }

        public function des_inscribir($params){
            $idInscripcion = explode(",",$params)[0];
            $idPersona = explode(",",$params)[1];
            $reqUpdateHistorial = $this->model->updateEstatusHistorial($idInscripcion,$this->idUser); //Actualizacion historial
            if($reqUpdateHistorial){
                $reqUpdateInscripcion = $this->model->updateEstatusInscripcion($idInscripcion,$this->idUser); //Actualizacion inscripcion
                if($reqUpdateInscripcion){
                    $reqUpAsignacionCategoria = $this->model->updateAsignacionCategoriaPersona($idPersona,$this->idUser);
                    if($reqUpAsignacionCategoria){
                        $arrResponse = array('estatus' => true, 'msg' => 'Inscripcion cancelada');
                    }else{
                        $arrResponse = array('estatus' => true, 'msg' => 'No es posible la cancelación');
                    }
                }
            }else{
                $arrResponse = array('estatus' => false, 'msg' => 'No es posible la cancelación');
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }


        public function des_inscribir_usuarios($arr){
            $arr = json_decode($arr);
            foreach ($arr as $key => $value) {
                if($value->estatus_check){
                    $idInscripcion = $value->id_inscripcion;
                    $idPersona = $value->id_persona;
                    $reqUpdateHistorial = $this->model->updateEstatusHistorial($idInscripcion,$this->idUser); //Actualizacion historial
                    if($reqUpdateHistorial){
                        $reqUpdateInscripcion = $this->model->updateEstatusInscripcion($idInscripcion,$this->idUser); //Actualizacion inscripcion
                        if($reqUpdateInscripcion){
                            $reqUpAsignacionCategoria = $this->model->updateAsignacionCategoriaPersona($idPersona,$this->idUser);
                            if($reqUpAsignacionCategoria){
                                $arrResponse = array('estatus' => true, 'msg' => 'Inscripciones canceladas');
                            }else{
                                $arrResponse = array('estatus' => true, 'msg' => 'No es posible la cancelación');
                            }
                        }
                    }else{
                        $arrResponse = array('estatus' => false, 'msg' => 'No es posible la cancelación');
                    } 
                }
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }
        public function posponer_usuarios($arr){
            $arr = json_decode($arr);
            $arrDatos = $arr->datos;
            $idSubcampania = $arr->idSubcampania;
            foreach ($arrDatos as $key => $value) {
                $request = $this->model->updatePosponerInscripcion($value->id_inscripcion,$this->idUser);
                if($request){
                    $reqUpPosponerInscripcion = $this->model->updateSubcampaniaInscripcion($value->id_inscripcion,$idSubcampania,$this->idUser);
                    if($reqUpPosponerInscripcion){
                        $arrResponse = array('estatus' => true, 'msg' => 'Inscripciones pospuestos');
                    }
                }else{
                    $arrResponse = array('estatus' => false, 'msg' => 'No es posible posponer');
                    break;
                }
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }
        
        public function getPromocionescolegiaturas($idPlanEstudio)
        {
            //$idInstitucion = $this->model->selectPlanEstudio($idCarrera);
            $arrData = $this->model->selectPromocionesColegiatura($idPlanEstudio);
            /* if($idInstitucion['id']){
            } */
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }
    }
?>