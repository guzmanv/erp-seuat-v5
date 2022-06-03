<?php
	class DashboardDirc extends Controllers{
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
		public function DashboardDirc(){
			$data['page_id'] = 2;
			$data['page_tag'] = "Dashboard DIRC";
			$data['page_title'] = "Página Dashboard";
			$data['page_name'] = "Página Dashboard";
			$data['page_functions_js'] = "functions_dashboard_dirc.js";
			$data['planteles'] = $this->model->selectPlanteles();
			$this->views->getView($this,"dashboarddirc",$data);
		}
		public function getTotalesCard($params){
			$arrParams = explode(',',$params);
			$plantel = $arrParams[0];
			$institucion = $arrParams[1];
 			if($plantel == 'all' && $institucion == 'all'){
				$totalInstituciones = 0;
				$totalPlanEstudios = 0;
				$totalMaterias = 0;
				$totalRVOES = 0;
                $arrPlanteles = $this->model->selectPlanteles();
				foreach ($arrPlanteles as $key => $plantel) {
					$instituciones = $this->model->selectTotalInstituciones($plantel['id']);
					$totalInstituciones += $instituciones['total'];
					$planEstudios = $this->model->selectTotalesPlanEstudios($plantel['id']);
					$totalPlanEstudios += $planEstudios['total'];
					$materias = $this->model->selectTotalesMaterias($plantel['id']);
					$totalMaterias += $materias['total'];
					$rvoes = $this->model->selectTotalesRVOES($plantel['id']);
					$totalRVOES += $rvoes['total'];
				}
				$arrData['instituciones'] = $totalInstituciones;
                $arrData['plan_estudios'] = $totalPlanEstudios;
                $arrData['materias'] = $totalMaterias;
                $arrData['rvoes'] = $totalRVOES;
                $arrData['tipo'] = "all";
			}else if($plantel != 'all' && $institucion =='all'){
				$totalInstituciones = $this->model->selectTotalInstituciones($plantel);
				$totalPlanEstudios = $this->model->selectTotalesPlanEstudios($plantel);
				/*$totalMaterias = $this->model->selectTotalesMaterias($nomConexion);
				$totalRVOES = $this->model->selectTotalesRVOES($nomConexion);
				$arrData['planteles'] = $totalPlanteles['total'];
                $arrData['plan_estudios'] = $totalPlanEstudios['total'];
                $arrData['materias'] = $totalMaterias['total'];
                $arrData['rvoes'] = $totalRVOES['total'];
                $arrData['tipo'] = "all";  */
               
			}else if($plantel != 'all' && $institucion != 'all'){
				/* $totalPlanEstudios = $this->model->selectPlanEstudiosbyPlantel($nomConexion,$idPlatel);
				$totalMaterias = $this->model->selectMateriasbyPlantel($nomConexion,$idPlatel);
				$totalRVOES = $this->model->selectRVOEproximoExpbyPlantel($nomConexion,$idPlatel);
				$arrData['planteles'] = 1;
                $arrData['plan_estudios'] = $totalPlanEstudios['total'];
                $arrData['materias'] = $totalMaterias['total'];
                $arrData['rvoes'] = count($totalRVOES);
                $arrData['tipo'] = "all"; */
			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
		}
		public function getListaRvoesExpirar($params){
			$arrParams = explode(',',$params);
			$nomConexion = $arrParams[0];
			$idPlantel = $arrParams[1];
			if($nomConexion == 'all' && $idPlantel == 'all'){
				$arrRes = [];
				foreach (conexiones as $keyCon => $conexion) {
					$arrPlantel = $this->model->selectDatosPlantel($keyCon);
					foreach ($arrPlantel as $keyP => $plantel) {
						$arrData = $this->model->selectRvoesExpirar($keyCon,$plantel['id']);
						for($i = 0; $i<count($arrData); $i++){
							$arrData[$i]['nom_conexion'] = $keyCon;
							$arrData[$i]['plantel_bd'] = $conexion['NAME'];
						}
						array_push($arrRes,$arrData);
					}
				}
				$newArray = array_merge([], ...$arrRes);
			}else if($nomConexion != 'all' && $idPlantel == 'all'){
				$arrPlantel = $this->model->selectDatosPlantel($nomConexion);
				$arrRes = [];
				foreach ($arrPlantel as $keyP => $plantel) {
					$arrData = $this->model->selectRvoesExpirar($nomConexion,$plantel['id']);
					for($i = 0; $i<count($arrData); $i++){
						$arrData[$i]['nom_conexion'] = $nomConexion;
						$arrData[$i]['plantel_bd'] = conexiones[$nomConexion]['NAME'];
					}
					array_push($arrRes,$arrData);
				}
				$newArray = array_merge([], ...$arrRes);

			}else if($nomConexion != 'all' && $idPlantel != 'all'){
				$newArray = $this->model->selectRvoesExpirar($nomConexion,$idPlantel);
				for($i = 0; $i<count($newArray); $i++){
					$newArray[$i]['nom_conexion'] = $nomConexion;
					$newArray[$i]['plantel_bd'] = conexiones[$nomConexion]['NAME'];
				}
			}
			echo json_encode($newArray ,JSON_UNESCAPED_UNICODE);
            die();
		}
		public function getPlanEstudiosMateriabyInstitucion($params){
			$arrParams = explode(',',$params);
			$plantel = $arrParams[0];
			$idInstitucion = $arrParams[1];
			if($plantel == 'all' && $idInstitucion == 'all'){
				$array = [];
				foreach (conexiones as $key => $conexion) {
					$arrPlantel = $this->model->selectDatosPlantel($key);
					foreach ($arrPlantel as $keyp => $plantel) {
						$arrPlanEstudios = $this->model->selectPlanEstudiosbyPlantel($key,$plantel['id']);
						$arrMaterias = $this->model->selectMateriasbyPlantel($key,$plantel['id']);
						$rvoes = $this->model->selectRVOEproximoExpbyPlantel($key,$plantel['id']);
						$array[$key.'/'.$plantel['id']] = array('id_plantel' => $key.'/'.$plantel['id'],'abreviacion_plantel'=>$plantel['abreviacion_plantel'],'municipio'=>$plantel['municipio'],'carreras'=>$arrPlanEstudios['total'],'materias'=>$arrMaterias['total'],'rvoes'=>count($rvoes));
					}
				}
			}else if($nomConexion != 'all' && $idPlantel == 'all'){
				$array = [];
				$arrPlantel = $this->model->selectDatosPlantel($nomConexion);
				foreach ($arrPlantel as $key => $plantel) {
					$arrPlanEstudios = $this->model->selectPlanEstudiosbyPlantel($nomConexion,$plantel['id']);
					$arrMaterias = $this->model->selectMateriasbyPlantel($nomConexion,$plantel['id']);
					$rvoes = $this->model->selectRVOEproximoExpbyPlantel($nomConexion,$plantel['id']);
					$array[$nomConexion.'/'.$plantel['id']] = array('id_plantel' => $nomConexion.'/'.$plantel['id'],'abreviacion_plantel'=>$plantel['abreviacion_plantel'],'municipio'=>$plantel['municipio'],'carreras'=>$arrPlanEstudios['total'],'materias'=>$arrMaterias['total'],'rvoes'=>count($rvoes));
				}
			}else if($nomConexion != 'all' && $idPlantel != 'all'){
				$array = [];
				$arrPlantel = $this->model->selectPlantel($nomConexion, $idPlantel);
				$arrPlanEstudios = $this->model->selectPlanEstudiosbyPlantel($nomConexion,$arrPlantel['id']);
				$arrMaterias = $this->model->selectMateriasbyPlantel($nomConexion,$arrPlantel['id']);
				$rvoes = $this->model->selectRVOEproximoExpbyPlantel($nomConexion,$arrPlantel['id']);
				$array[$nomConexion.'/'.$arrPlantel['id']] = array('id_plantel' => $nomConexion.'/'.$arrPlantel['id'],'abreviacion_plantel'=>$arrPlantel['abreviacion_plantel'],'municipio'=>$arrPlantel['municipio'],'carreras'=>$arrPlanEstudios['total'],'materias'=>$arrMaterias['total'],'rvoes'=>count($rvoes));

			}
			echo json_encode($array,JSON_UNESCAPED_UNICODE);
            die();
		}

		public function getInstituciones($idPlantel){
			$arrData = $this->model->selectDatosInstitucion($idPlantel);
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
		}
	}
?>