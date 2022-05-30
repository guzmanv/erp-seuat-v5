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
            echo 'hola';
        }
    }
?>