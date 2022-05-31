<?php
	class Planteles extends Controllers{
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
		public function planteles()
		{
			$data['page_id'] = 4;
			$data['page_tag'] = "Planteles";
			$data['page_title'] = "Planteles";
			$data['page_name'] = "plantel";
			$data['page_content'] = "";
			$data['lista_estados'] = $this->model->selectEstados(); //Traer lista de Estado
			$data['page_functions_js'] = "functions_planteles.js";
			$this->views->getView($this,"plantel",$data);
        }

		public function getPlanteles()
		{
			$arrPlanteles = $this->model->selectPlanteles();
			for($i = 0; $i<count($arrPlanteles); $i++){
				$arrPlanteles[$i]['numeracion'] = $i+1;
				$arrPlanteles[$i]['estatus'] = ($arrPlanteles[$i]['estatus'] == 1)?'<span class="badge badge-pill badge-success">Activo</span>
				':'<span class="badge badge-pill badge-warning">Inactivo</span>';
				$arrPlanteles[$i]['options'] = '<div class="text-center">
				<div class="btn-group">
					<button type="button" class="btn btn-outline-secondary btn-xs icono-color-principal dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-layer-group"></i> &nbsp; Acciones
					</button>
					<div class="dropdown-menu">
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnVerPlantel" onClick="fntVerPlantel('.$arrPlanteles[$i]['id'].')" data-toggle="modal" data-target="#modal_form_ver_plantel" title="Ver"> &nbsp;&nbsp; <i class="fas fa-eye icono-azul"></i> &nbsp; Ver</button>
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnEditPlantel" onClick="fntEditPlantel('.$arrPlanteles[$i]['id'].')" data-toggle="modal" data-target="#modal_form_edit_plantel" title="Editar"> &nbsp;&nbsp; <i class="fas fa-pencil-alt"></i> &nbsp; Editar</button>
						<div class="dropdown-divider"></div>
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnDelPlantel" onClick="fntDelPlantel('.$arrPlanteles[$i]['id'].')" title="Eliminar"> &nbsp;&nbsp; <i class="far fa-trash-alt "></i> &nbsp; Eliminar</button>
						<!--<a class="dropdown-item" href="#">link</a>-->
					</div>
				</div>
				</div>';
			}
			echo json_encode($arrPlanteles, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function setPlantel()
		{
			$data = $_POST;
			$idPlantelEdit = 0;
			$idPlantelNuevo = 0;
			if(isset($_POST['id_nuevo'])){
				$idPlantelNuevo = intval($_POST['id_nuevo']);
			}
			if(isset($_POST['id_edit'])){
				$idPlantelEdit = intval($_POST['id_edit']);
			}			
			if($idPlantelEdit != 0 ){
				$arrData = $this->model->updatePlantel($idPlantelEdit,$data,$this->idUser);
				if($arrData){
					$arrResponse = array('estatus' => true, 'msg' => 'Datos actualizados correctamente.');
				}else{
					$arrResponse = array('estatus' => false, 'msg' => 'La Clave del centro de trabajo ya existe');
				}
			}else{
				$arrData = $this->model->insertPlantel($data,$this->idUser);
				if($arrData){
					$arrResponse = array('estatus' => true, 'msg' => 'Datos guardados correctamente.');
				}else{
					$arrResponse = array('estatus' => false, 'msg' => '¡Atención! No es posible guardar el plantel'); 
				}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
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

		//Funcion para obtener Datos de un Plantel
		public function getPlantel(int $idPlantel){
			$arrPlantel = $this->model->selectPlantel($idPlantel);
			if($arrPlantel){
				echo json_encode($arrPlantel,JSON_UNESCAPED_UNICODE);
				die();
			}
		}

		public function getListEstados(){
			$arrResponse = $this->model->selectEstados();
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}

		//Funcion para Elimniar un Plantel
		public function delPlantel(){
			if($_POST){
				$intIdPlantel = intval($_POST['idPlantel']);
				$requestDelete = $this->model->deletePlantel($intIdPlantel);
				if($requestDelete == 'ok'){
					$arrResponse = array('estatus' => true, 'msg' => 'Se ha eliminado el Plantel.');
				}else if($requestDelete == 'exist'){
					$arrResponse = array('estatus' => false, 'msg' => 'No es posible eliminar el plantel.');
				}else{
					$arrResponse = array('estatus' => false, 'msg' => 'Error al eliminar el plantel.');
				} 
			}
			echo json_encode($arrResponse , JSON_UNESCAPED_UNICODE);
			die();
		}
    }
?>