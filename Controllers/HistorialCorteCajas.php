<?php
	class HistorialCorteCajas extends Controllers{
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
		public function historialcortecajas(){
			$data['page_tag'] = "Historial de corte de cajas";
			$data['page_title'] = "Historial de corte de cajas";
			$data['page_name'] = "Historial de corte de cajas";
			$data['page_content'] = "";
			$data['page_functions_js'] = "functions_historial_cortes_caja.js";
			$this->views->getView($this,"historialcortecajas",$data);
		}
		public function getCortesCajas(){
			$arrData = $this->model->selectCortesCajas();
			for($i = 0; $i<count($arrData); $i++){
				$arrData[$i]['numeracion'] = $i+1;
				//$arrData[$i]['plantel'] = $arrData[$i]['nombre_plantel'].'/'.$arrData[$i]['municipio'];
				//$arrData[$i]['nom_plantel'] = conexiones[$arrData[$i]['plantel']]['NAME'];
				$arrData[$i]['faltante'] = ($arrData[$i]['dinero_faltante'] > 0)?'<span class="badge badge-danger">'.'$'.formatoMoneda($arrData[$i]['dinero_faltante']).'</span>':'$ '.formatoMoneda($arrData[$i]['dinero_faltante']);
				$arrData[$i]['sobrante'] = ($arrData[$i]['dinero_sobrante'] > 0)?'<span class="badge badge-warning">'.'$'.formatoMoneda($arrData[$i]['dinero_sobrante']).'</span>':'$ '.formatoMoneda($arrData[$i]['dinero_sobrante']);
				
				$arrData[$i]['options'] = '<div class="text-center">
				<div class="btn-group">
					<button type="button" class="btn btn-outline-secondary btn-xs icono-color-principal dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-layer-group"></i> &nbsp; Acciones
					</button>
					<div class="dropdown-menu">
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal datosPersonalesVerficar" onClick="fnDatosPersonalesVerificacion(this,'.$arrData[$i]['id'].')" data-toggle="modal" data-target="#ModalFormEditPersona" title="Datos Personales"> &nbsp;&nbsp; <i class="far fa-address-book"></i> &nbsp Reimprimir</button>
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal editTutor" onclick="fnEditTutor(this)" data-toggle="modal" data-target="#ModalFormEditTutor" title="Tutor"> &nbsp;&nbsp; <i class="fas fa-user-friends"></i> &nbsp;Saldar faltantes</button>
						<div class="dropdown-divider"></div>
					</div>
				</div>
				</div>';
			} 
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}

		public function imprimir_comprobante_corte(string $idCorte){
			$idHistorialCorte = $this->reverse64($idCorte);
			$data['datosInstitucion'] = $this->model->selectDatosInstitucion($idHistorialCorte); //Datos del plantel

			$arrDatosVenta = [];
            // $total = 0;
            // $inscripcion = 0;
            // $colegiatura = 0;
            // $otros = 0;
            // foreach ($data['datos_venta'] as $key => $venta) {
            //     if($venta['codigo_servicio_precarga'] != 'CM'){
            //         $colegiatura += $venta['precio_unitario_precarga'];
            //     }else if($venta['codigo_servicio_precarga'] == 'IN'){
            //         $inscripcion += $venta['precio_unitario_precarga'];
            //     }else if($venta['codigo_servicio']!= null){
            //         $otros += $venta['precio_unitario'];
            //     }
            //     $total = $venta['total'];
            // }
            // $arrDatosVenta['total'] = $total;
            // $arrDatosVenta['inscripcion'] = $inscripcion;
            // $arrDatosVenta['colegiatura'] = $colegiatura;
            // $arrDatosVenta['otros'] = $otros;            
            // $data['datos_venta'] = $arrDatosVenta; 
			$this->views->getView($this,"viewpdf_compromante_corte_caja",$data);
		}

		//Funcion para convertir base64 a Array
        private function reverse64($arr){
            return base64_decode($arr);
        }

    }
?>