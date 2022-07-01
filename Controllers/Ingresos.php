<?php
    class Ingresos extends Controllers{
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
        public function ingresos(){
            $data['page_id'] = 10;
            $data['page_tag'] = "Ingresos";
            $data['page_title'] = "Caja (ingresos)";
            $data['page_content'] = "";
            $data['metodos_pago'] = $this->model->selectMetodosPago();
            $data['estatus_caja'] = $this->model->selectEstatusCaja($this->idUser);
            $data['grados'] = $this->model->selectGrados();
            $data['page_functions_js'] = "functions_ingresos.js";
            $this->views->getView($this,"ingresos",$data);
            
        }
        //Funcion obtener lista ingresos
        public function getIngresos(){
            $arrData = $this->model->selectIngresos();
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }
        //Funcion para buscar persona en el Modal
        public function buscarPersonaModal(){
            $data = $_GET['val'];
            $arrData = $this->model->selectPersonasModal($data);
            for($i = 0; $i <count($arrData); $i++){
                $arrData[$i]['numeracion'] = $i+1;
                $arrData[$i]['options'] = '<button type="button"  id="'.$arrData[$i]['id'].'" class="btn btn-primary btn-sm" rl="'.$arrData[$i]['nombre'].'" onclick="seleccionarPersona(this)">Seleccionar</button>';
            }
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();

        }       
        // Funcion para obtener Servicios por Tipo de pago
        public function getServicios($valor){
            $valor = explode(',',$valor);
            $pago = $valor[1];
            $grado = $valor[0];
            $idPersona = $valor[2];
            if($pago == 1){ //Colegiaturas
                $arrData['tipo'] = "COL";
                if($grado == 1){
                    $arrDataCol = $this->model->selectColegiaturas($idPersona,$grado);
                    for ($i = 0; $i<count($arrDataCol); $i++) {
                        $idServicio = $arrDataCol[$i]['id_servicio'];
                        $arrDataTemp = $this->model->selectColegTemp($idPersona,$idServicio);
                        $idServicioColegiatura = $arrDataTemp['id_servicio_colegiatura'];
                        $idServicioInscripcion = $arrDataTemp['id_servicio_inscripcion'];
                        if($idServicio == $idServicioColegiatura){
                            $arrDataCol[$i] = $arrDataTemp;
                        }
                    }
                    /* if(count($arrDataCol) == 1){ //Si arrColegiaturas es solo uno
                        $arrDataTemp = $this->model->selectColegTemp($idPersona);
                        $arrNew = array_merge($arrDataCol[0],$arrDataTemp);
                        $arrData['data'] = $arrNew;
                    } */

                }else{
                    /* $arrDataCol = $this->model->selectColegiaturas($idPersona,$grado);
                    $arrData['data'] = $arrDataCol; */
                }
            }else{ //Servicios
                $arrData['tipo'] = "SERV";
                //$arrData['data'] = $this->model->selectServicios($idPersona,$grado);
                if($grado == 1){
                    $datos = $this->model->selectServicios($idPersona,$grado);
                    if(count($datos) == 1){
                        $arrDataTemp = $this->model->selectColegTemp($idPersona);
                        $arrNew = array_merge($datos[0],$arrDataTemp);
                        $arrData['data'] = $arrNew;
                    }
                    
                }else{
                    $datos = $this->model->selectServicios($idPersona,$grado);
                    $arrData['data'] = $datos;
                }
            }
            echo json_encode($arrDataCol,JSON_UNESCAPED_UNICODE);
            die();
        }
        //Funcion para obtener promociones por Id del Servicio
        public function getPromociones($idServicio){
            $arrData = $this->model->selecPromociones($idServicio);
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }
        //Funcion para generar un estado de cuenta
        public function generarEdoCuenta($idPersonaSeleccionada){
            $arrPlantel = $this->model->selectPlantelAlumno($idPersonaSeleccionada);
            $arrCarrera = $this->model->selectCarreraAlumno($idPersonaSeleccionada);
            $arrGrado = $this->model->selectGradoAlumno($idPersonaSeleccionada);
            $arrPeriodo = $this->model->selectPeriodoAlumno($idPersonaSeleccionada);
            $idInstitucion = $arrCarrera['id_instituciones'];
            $idCarrera = $arrCarrera['id_plan_estudios'];
            $idGrado = $arrGrado['id'];
            $idPeriodo = $arrPeriodo['id_periodo'];
            $arrData = $this->model->generarEdoCuentaAlumno($idPersonaSeleccionada,$idInstitucion,$idCarrera,$idGrado,$idPeriodo,$this->idUser);
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }
        //Funcion para enviar ingresos
        public function setIngresos(){
            $idAlumno = $_GET['idP'];
            $tipoPago = $_GET['tipoP'];
            $tipoComprobante = $_GET['tipoCom'];
            $observaciones = $_GET['observacion'];
            $arrayDate = json_decode($_GET['date']);
            $isEdoCta = false;
            $total = 0;
            $estados = "";
            foreach ($arrayDate as $key => $value) {
                $total += $value->subtotal;
            }
            foreach ($arrayDate as $key => $value) {
                if($value->edo_cta == '1'){
                    $isEdoCta = true;
                    break;
                }
            }
            $folio = $this->model->selectFolioSig($idAlumno);
            $reqIngreso = $this->model->insertIngresos($folio,$tipoPago,$tipoComprobante,$total,$observaciones,$idAlumno,$this->idPlantel,$this->idUser);
            if($reqIngreso){
                foreach ($arrayDate as $key => $value) {
                    $idServicio = null;
                    $idPrecarga = null;
                    if($value->edo_cta == 1){ //Estado de Cuenta
                        $idPrecarga = $value->precarga;
                        $idServicio = $value->id_servicio;
                        $reqIngDetalles = $this->model->insertIngresosDetalle($value->cantidad,$value->precio_unitario,$value->precio_unitario,$total,$value->subtotal,0,0,json_encode($value->promociones),$idServicio,$idPrecarga,$reqIngreso);
                        $idEstadoCta = $value->id_edo_cta;  //ID  edo cta a actualizar como pagado
                        if($reqIngDetalles){
                            $reqEdoCtaUpdate = $this->model->updateEdoCta($idEstadoCta,$this->idUser);
                            //$arrResponse = $reqEdoCtaUpdate; Se se guardo correcxtamnete a Pagado
                        }
                    }else{ //Otros Servicios
                        $idServicio = $value->id_servicio;
                        $reqIngDetalles = $this->model->insertIngresosDetalle($value->cantidad,$value->precio_unitario,$value->precio_unitario,$total,$value->subtotal,0,0,json_encode($value->promociones),$idServicio,$idPrecarga,$reqIngreso);
                    }
                    if($reqIngDetalles){
                        if($value->temp){
                            $this->model->deletTempTable($idAlumno);
                        }
                        $arrResponse = array('estatus' => true, 'id'=>$reqIngreso,'msg' => 'Datos guardados correctamente!');                       
                    }else{
                        $arrResponse = array('estatus' => false, 'msg' => 'No es posible Guardar los Datos');
                    }
                }
            }else{
                $arrResponse = array('estatus' => false, 'msg' => 'No es posible Guardar los Datos');
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }
        //Funcion para imprimir comprante de una Venta
        public function imprimir_comprobante_venta(string $idVenta){
            $idIngreso = $this->reverse64($idVenta);
            $data['datosInstitucion'] = $this->model->selectDatosInstitucion($idIngreso); //Datos del plantel
            $data['datos_venta'] = $this->model->selectDatosVenta($idIngreso);//Datos del ingreso/venta
            $data['datos_alumno'] = $this->model->selectDatosAlumno($idIngreso);//Datos del Alumno
            $data['datos_usuario'] = $this->model->selectDatosUsuario($this->idUser);//Datos del Usuario Admin
            $arrDatosVenta = [];
            $total = 0;
            $inscripcion = 0;
            $colegiatura = 0;
            $otros = 0;
            foreach ($data['datos_venta'] as $key => $venta) {
                if($venta['codigo_servicio_precarga'] != 'CM'){
                    $colegiatura += $venta['precio_unitario_precarga'];
                }else if($venta['codigo_servicio_precarga'] == 'IN'){
                    $inscripcion += $venta['precio_unitario_precarga'];
                }else if($venta['codigo_servicio']!= null){
                    $otros += $venta['precio_unitario'];
                }
                $total = $venta['total'];
            }
            $arrDatosVenta['total'] = $total;
            $arrDatosVenta['inscripcion'] = $inscripcion;
            $arrDatosVenta['colegiatura'] = $colegiatura;
            $arrDatosVenta['otros'] = $otros;            
            $data['datos_venta'] = $arrDatosVenta; 
            $this->views->getView($this,"viewpdf_compromante_venta_media_carta",$data);
        }


        public function aperturarCaja($args){
            $arg = explode(',',$args);
            $idCaja = $arg[0];
            $estatus = 1;
            $monto = $arg[1];
            $apertura = $this->model->updateEstatusCaja($idCaja,$estatus,$monto);
            if($apertura){
               $caja = $this->model->insertCorteCaja($monto,$idCaja);
                if($caja){
                    $arrResponse = array('estatus' => true, 'msg' => 'Caja aperturado correctamente!');
                }
            }else{
                $arrResponse = array('estatus' => false, 'msg' => 'No es posible aperturar la caja!');                       
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }

        //Funcion para convertir base64 a Array
        private function reverse64($arr){
            return base64_decode($arr);
        }

        public function getNuevasInscripciones()
        {
            $arrInscripciones = $this->model->selectNuevasInscripciones();
            echo json_encode($arrInscripciones,JSON_UNESCAPED_UNICODE);
            die();
        }


        public function inscripciones()
        {
            $data['page_id'] = 10;
            $data['page_tag'] = "Inscripciones";
            $data['page_title'] = "Inscripciones";
            $data['page_content'] = "";
            $data['page_functions_js'] = "functions_inscripciones_caja.js";
            $this->views->getView($this,"listainscripciones",$data);
        }
        
        public function getEstudiantes(){
            $arrData = $this->model->selectNuevasInscripciones();
            for ($i=0; $i<count($arrData); $i++){
                $arrData[$i]['numeracion'] = $i+1;
                $edo_cta = $this->getEstatusEstadoCuentaInscripciones($arrData[$i]['id_persona']);
                $arrData[$i]['is_edo_cta'] = $edo_cta;
                $disabledButton = ($edo_cta)?'disabled':'';
                $arrData[$i]['is_edo_cta'] = ($edo_cta)?'<span class="badge badge-success">&nbsp&nbspSi&nbsp&nbsp</span>':'<span class="badge badge-danger">&nbsp&nbspNo&nbsp&nbsp</span>';
                $arrData[$i]['aplica_desc_coleg'] = ($arrData[$i]['porcentaje_descuento_coleg'])?'<span class="badge badge-success">&nbsp&nbspSi&nbsp&nbsp</span>':'<span class="badge badge-danger"> No r</span>'; 
                $arrData[$i]['aplica_desc_ins'] = ($arrData[$i]['porcentaje_descuento_insc'])?'<span class="badge badge-success">&nbsp&nbspSi&nbsp&nbsp</span>':'<span class="badge badge-danger"> No </span>';
                $arrData[$i]['options'] = '<button type="button" class="btn btn-primary btn-sm" onclick="fnGenerarEstadoCuenta('.$arrData[$i]['id_persona'].','.$arrData[$i]['id_tmp'].')" '.$disabledButton.'>Generar estado de cuenta</button>';
            }
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function getIngreso(int $idIngreso){
            $arrData = $this->model->selectIngreso($idIngreso);
            for($i = 0; $i<count($arrData); $i++){
                $arrData[$i]['id'] = null;
                if($arrData[$i]['colegiatura'] == 1){
                    $arrData[$i]['tipo'] = "col";
                }else{
                    $arrData[$i]['tipo'] = "serv";
                }
            }
            echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
            die();
        }

        public function delTblTempInscripcion(int $id)
        {
            $response = $this->model->deletTempInscripcion($id);
            if($response){
                $arrResponse = array('estatus' => true, 'msg' => 'Se ha borrado correctamente');                       
            }else{
                $arrResponse = array('estatus' => false, 'msg' => 'No se pudo realizar el procedimiento');                       
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }
        

        //Funcion para obtener si una persona tiene estado de cuenta
        public function getEstatusEstadoCuenta($idPersonaSeleccionada){
            $arrData = $this->model->selectStatusEstadoCuenta($idPersonaSeleccionada);
            if(count($arrData) == 0){
                $arrRequest = false;
            }else{
                $arrRequest = true;
            }
            echo json_encode($arrRequest,JSON_UNESCAPED_UNICODE);
            die();
        } 

         //Funcion para obtener si una persona tiene estado de cuenta
         public function getEstatusEstadoCuentaInscripciones($idPersonaSeleccionada){
            $arrData = $this->model->selectStatusEstadoCuenta($idPersonaSeleccionada);
            if(count($arrData) == 0){
                $arrRequest = false;
            }else{
                $arrRequest = true;
            }
            return $arrRequest;
        }
    }
?>