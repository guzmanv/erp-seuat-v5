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
            $data['page_functions_js'] = "functions_inscripcion.js";
            $this->views->getView($this,"inscripcion",$data);
            
        }

        public function getGruposCompuestos()
        {
            $arrData = $this->model->selectGruposCompuestos();
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }
    }
?>