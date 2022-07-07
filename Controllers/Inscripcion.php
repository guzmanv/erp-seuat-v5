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
            $data['page_functions_js'] = "functions_inscripcion.js";
            $this->views->getView($this,"inscripcion",$data);
            
        }

        public function getPreenscritos(int $idPlantel)
        {
            $arrData = $this->model->selectPreenscritos();
            for($i = 0; $i<count($arrData); $i++){
                $arrData[$i]['numeracion'] = $i+1;
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
    }
?>