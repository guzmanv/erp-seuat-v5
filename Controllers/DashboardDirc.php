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
				foreach ($arrPlanteles as $key => $plnt) {
					$instituciones = $this->model->selectTotalInstituciones($plnt['id']);
					$totalInstituciones += $instituciones['total'];
					$planEstudios = $this->model->selectTotalesPlanEstudios($plnt['id']);
					$totalPlanEstudios += $planEstudios['total'];
					$materias = $this->model->selectTotalesMaterias($plnt['id']);
					$totalMaterias += $materias['total'];
					$rvoes = $this->model->selectTotalesRVOES($plnt['id']);
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
				$totalMaterias = $this->model->selectTotalesMaterias($plantel);
				$totalRVOES = $this->model->selectTotalesRVOES($plantel);
				$arrData['instituciones'] = $totalInstituciones['total'];
                $arrData['plan_estudios'] = $totalPlanEstudios['total'];
                $arrData['materias'] = $totalMaterias['total'];
                $arrData['rvoes'] = $totalRVOES['total'];
                $arrData['tipo'] = "all";
               
			}else if($plantel != 'all' && $institucion != 'all'){
				$totalPlanEstudios = $this->model->selectPlanEstudiosbyInstitucion($plantel,$institucion);
				$totalMaterias = $this->model->selectMateriasbyInstitucion($plantel,$institucion);
				$totalRVOES = $this->model->selectRVOEproximoExpbyInstitucion($plantel,$institucion);
				$arrData['instituciones'] = 1;
                $arrData['plan_estudios'] = $totalPlanEstudios['total'];
                $arrData['materias'] = $totalMaterias['total'];
                $arrData['rvoes'] = count($totalRVOES);
                $arrData['tipo'] = "all";
			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
		}
		public function getListaRvoesExpirar($params){
			$arrParams = explode(',',$params);
			$idPlantel = $arrParams[0];
			$idInstitucion = $arrParams[1];
			if($idPlantel == 'all' && $idInstitucion == 'all'){
				$arrRes = [];
				$arrPlanteles = $this->model->selectPlanteles();
				foreach ($arrPlanteles as $keyCon => $plant) {
					$arrInstituciones = $this->model->selectInstitucionesByPlantel($plant['id']);
					foreach ($arrInstituciones as $keyP => $instit) {
						$arrData = $this->model->selectRvoesExpirar($plant['id'],$instit['id']);
						for($i = 0; $i<count($arrData); $i++){
							$arrData[$i]['id_plantel'] = $plant['id'];
							$arrData[$i]['nom_plantel'] = $plant['municipio'];
						}
						array_push($arrRes,$arrData);
					}
				}
				$newArray = array_merge([], ...$arrRes);
			}else if($idPlantel != 'all' && $idInstitucion == 'all'){
				$arrInstituciones = $this->model->selectInstitucionesByPlantel($idPlantel);
				$arrDataPlantel = $this->model->selectPlantel($idPlantel);
				$arrRes = [];
				foreach ($arrInstituciones as $keyP => $institucion) {
					$arrData = $this->model->selectRvoesExpirar($idPlantel,$institucion['id']);
					for($i = 0; $i<count($arrData); $i++){
						$arrData[$i]['id_plantel'] = $idPlantel;
						$arrData[$i]['nom_plantel'] = $arrDataPlantel['municipio'];
					}
					array_push($arrRes,$arrData);
				}
				$newArray = array_merge([], ...$arrRes);

			}else if($idPlantel != 'all' && $idInstitucion != 'all'){
				$newArray = $this->model->selectRvoesExpirar($idPlantel,$idInstitucion);
				$arrDataPlantel = $this->model->selectPlantel($idPlantel);
				for($i = 0; $i<count($newArray); $i++){
					$newArray[$i]['id_plantel'] = $idPlantel;
					$newArray[$i]['nom_plantel'] = $arrDataPlantel['municipio'];
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
				$arrPlanteles = $this->model->selectPlanteles();
				foreach ($arrPlanteles as $key => $plnte) {
					$arrInstituciones = $this->model->selectInstitucionesByPlantel($plnte['id']);
					foreach ($arrInstituciones as $keyp => $inst) {
						$arrPlanEstudios = $this->model->selectPlanEstudiosbyInstitucion($plnte['id'],$inst['id']);
						$arrMaterias = $this->model->selectMateriasbyInstitucion($plnte['id'],$inst['id']);
						$rvoes = $this->model->selectRVOEproximoExpbyInstitucion($plnte['id'],$inst['id']);
						$array[$plnte['id'].'/'.$inst['id']] = array('id_plantel' => $plnte['id'].'/'.$inst['id'],'abreviacion_institucion'=>$inst['abreviacion_institucion'],'municipio'=>$plnte['municipio'],'carreras'=>$arrPlanEstudios['total'],'materias'=>$arrMaterias['total'],'rvoes'=>count($rvoes));
					}
				}
			}else if($plantel != 'all' && $idInstitucion == 'all'){
				$array = [];
				$arrInstituciones = $this->model->selectInstitucionesByPlantel($plantel);
				$arrDataPlantel = $this->model->selectPlantel($plantel);
				foreach ($arrInstituciones as $key => $insti) {
					$arrPlanEstudios = $this->model->selectPlanEstudiosbyInstitucion($plantel,$insti['id']);
					$arrMaterias = $this->model->selectMateriasbyInstitucion($plantel,$insti['id']);
					$rvoes = $this->model->selectRVOEproximoExpbyInstitucion($plantel,$insti['id']);
					$array[$plantel.'/'.$insti['id']] = array('id_plantel' => $plantel.'/'.$insti['id'],'abreviacion_institucion'=>$insti['abreviacion_institucion'],'municipio'=>$arrDataPlantel['municipio'],'carreras'=>$arrPlanEstudios['total'],'materias'=>$arrMaterias['total'],'rvoes'=>count($rvoes));
				}
			}else if($plantel != 'all' && $idInstitucion != 'all'){
				$array = [];
				$arrPlantel = $this->model->selectPlantel($plantel);
				$arrInstitucion = $this->model->selectInstitucion($idInstitucion);
				$arrPlanEstudios = $this->model->selectPlanEstudiosbyInstitucion($plantel,$idInstitucion);
				$arrMaterias = $this->model->selectMateriasbyInstitucion($plantel,$idInstitucion);
				$rvoes = $this->model->selectRVOEproximoExpbyInstitucion($plantel,$idInstitucion);
				$array[$plantel.'/'.$idInstitucion] = array('id_plantel' => $plantel.'/'.$idInstitucion,'abreviacion_institucion'=>$arrInstitucion['abreviacion_institucion'],'municipio'=>$arrPlantel['municipio'],'carreras'=>$arrPlanEstudios['total'],'materias'=>$arrMaterias['total'],'rvoes'=>count($rvoes));

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