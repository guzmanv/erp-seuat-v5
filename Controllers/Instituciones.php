<?php

	class Instituciones extends Controllers{
		private $idUser;
		private $rol;
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
			$this->rol = $_SESSION['claveRol'];
		}

		//Funcion para la Vista de PlantelesnomConexion
		public function instituciones()
		{
			$data['page_id'] = 4;
			$data['page_tag'] = "Instituciones";
			$data['page_title'] = "Instituciones";
			$data['page_name'] = "Instituciones";
			$data['page_content'] = "";
			$data['page_functions_js'] = "functions_instituciones.js";
            $data['planteles'] = $this->model->selectPlanteles();
            $data['sistemas_educativos'] = $this->model->selectSistemasEducativos();
			$this->views->getView($this,"instituciones",$data);
		}

		//Funcion para traer Lista de Planteles
		public function getInstituciones(){
			$arrData = $this->model->selectInstituciones();
			for ($i=0; $i < count($arrData); $i++) {
				$arrData[$i]['numeracion'] = $i+1;
				$arrData[$i]['nom_sistema'] = $this->model->selectSistemaEducativo($arrData[$i]['id_sistemas_educativos'])['nombre_sistema'];
				$arrData[$i]['nom_plantel'] = $this->model->selectPlantel($arrData[$i]['id_planteles'])['nombre_plantel_fisico'];
                $arrData[$i]['status'] = ($arrData[$i]['estatus'] == 1)?'<span class="badge badge-pill badge-success">Activo</span>':'<span class="badge badge-pill badge-warning">Inactivo</span>';
				$arrData[$i]['options'] = '<div class="text-center">
				<div class="btn-group">
					<button type="button" class="btn btn-outline-secondary btn-xs icono-color-principal dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-layer-group"></i> &nbsp; Acciones
					</button>
					<div class="dropdown-menu">
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnVerPlantel" onClick="fntVerInstitucion('.$arrData[$i]['id'].')" data-toggle="modal" data-target="#ModalVerPlantel" title="Ver"> &nbsp;&nbsp; <i class="fas fa-eye icono-azul"></i> &nbsp; Ver</button>
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnEditPlantel" onClick="fntEditInstitucion('.$arrData[$i]['id'].')" data-toggle="modal" data-target="#ModalFormEditPlantel" title="Editar"> &nbsp;&nbsp; <i class="fas fa-pencil-alt"></i> &nbsp; Editar</button>
						<div class="dropdown-divider"></div>
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnDelPlantel" onClick="fntDelInstitucion('.$arrData[$i]['id'].')" title="Eliminar"> &nbsp;&nbsp; <i class="far fa-trash-alt "></i> &nbsp; Eliminar</button>
						<!--<a class="dropdown-item" href="#">link</a>-->
					</div>
				</div>
				</div>';
			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}
		
		//Funcion para obtener Datos de un Plantel
		public function getInstitucion(int $idInstitucion){
			$arrData = $this->model->selectInstitucion($idInstitucion);
			/* $arrDataSistemaEducativo = $this->model->selectSistemaEducativo($arrData['id_sistema']);
			$arrData['nombre_sistema_educativo'] = $arrDataSistemaEducativo['nombre_sistema'];
			$arrData['abreviacion_sistema_educativo'] = $arrDataSistemaEducativo['abreviacion_sistema']; */
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}
		//Funcion para traer Lista de Municipios
		public function getMunicipios(){
			$idEstado = $_GET['idestado'];
			$arrData = $this->model->selectMunicipios($idEstado);
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}
		//Funcion para traer Lista de Localidades
		public function getLocalidades(){
			$idMunicipio = $_GET['idmunicipio'];
			$arrData = $this->model->selectLocalidades($idMunicipio);
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}
		//Funcion para Guardar un Nuevo Plantel
		public function setInstitucion(){
			$data = $_POST;
            $files = $_FILES;
			$idInstitucionEdit = 0;
			$idInstitucionNuevo = 0;
			if(isset($_POST['id_institucion_nuevo'])){
				$idInstitucionNuevo = intval($_POST['id_institucion_nuevo']);
			}
			if(isset($_POST['idInstitucionEdit'])){
				$idInstitucionEdit = intval($_POST['idInstitucionEdit']);
			}
			
			if($idInstitucionEdit != 0 ){
				$arrData = $this->model->updateInstitucion($idInstitucionEdit,$data,$files);
				if($arrData['estatus'] != TRUE){
					$arrResponse = array('estatus' => true, 'msg' => 'Datos actualizados correctamente.');
				}else{
					$arrResponse = array('estatus' => false, 'msg' => 'La Clave del centro de trabajo ya existe');
				}
			}
			if($idInstitucionNuevo == 1){
				$arrData = $this->model->insertInstitucion($data,$files);
			    if($arrData['estatus'] != TRUE){
			        if($arrData['imagen'] == false){
						$arrResponse = array('estatus' => false, 'msg' => 'No se pudo guardar la imagen.');
					}else{
						$arrResponse = array('estatus' => true, 'msg' => 'Datos guardados correctamente.');
					}
			    }else{
			    $arrResponse = array('estatus' => false, 'msg' => '¡Atención! La Clave del centro de trabajo ya existe'); 
                }
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}

		//Funcion para Elimniar un Plantel
		public function delInstitucion(){
			if($_POST){
					$intIdInstitucion = intval($_POST['idInstitucion']);
					$requestTablaRef = $this->model->getTablasRef();
					if(count($requestTablaRef)>0){
						$requestStatus = 0;
						foreach ($requestTablaRef as $key => $tabla) {
							$nombreTabla = $tabla['tablas'];
							$existColumn = $this->model->selectColumn($nombreTabla);
							if($existColumn){
								$requestEstatusRegistro = $this->model->estatusRegistroTabla($nombreTabla,$intIdInstitucion);
								if($requestEstatusRegistro){
									$requestStatus += count($requestEstatusRegistro);
								}else{
									$requestStatus += 0;
								}
							}
						}
						if($requestStatus == 0){
							$requestDelete = $this->model->deleteInstitucion($intIdInstitucion, $this->idUser);
							if($requestDelete == 'ok'){
								$arrResponse = array('estatus' => true, 'msg' => 'Se ha eliminado la institución.');
							}else if($requestDelete == 'exist'){
								$arrResponse = array('estatus' => false, 'msg' => 'No es posible eliminar la institución.');
							}else{
								$arrResponse = array('estatus' => false, 'msg' => 'Error al eliminar la institución.');
							}
						}else{
							$arrResponse = array('estatus' => false, 'msg' => 'No es posible eliminar porque hay plan de estudios activos relacionados a esta institución.');
						}
					}else{
						$requestDelete = $this->model->deleteInstitucion($intIdInstitucion,$this->idUser);
						if($requestDelete == 'ok'){
							$arrResponse = array('estatus' => true, 'msg' => 'Se ha eliminado la institución.');
						}else if($requestDelete == 'exist'){
							$arrResponse = array('estatus' => false, 'msg' => 'No es posible eliminar la institución.');
						}else{
							$arrResponse = array('estatus' => false, 'msg' => 'Error al eliminar la institución.');
						}
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getListEstados(){
			$arrResponse = $this->model->selectEstados();
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}

	}
?>