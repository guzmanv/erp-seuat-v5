<?php
	class InstitucionesModel extends Mysql
	{
		public function __construct()
		{
			parent::__construct();
		}

		//Funcion para consultar lista de Categorias
		public function selectCategorias(){
			$sql = "SELECT *FROM t_categoria_carreras";
			$request = $this->select_all($sql);
			return $request;
		}
		//Funcion para consultar lista de Planteles
        public function selectInstituciones(){
            $sql = "SELECT *FROM t_instituciones WHERE estatus != 0 ORDER BY id DESC";
            $request = $this->select_all($sql);
            return $request;
        }

        //Funcion para seleccionar planteles
        public function selectPlanteles()
        {
            $sql = "SELECT *FROM t_planteles WHERE estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectPlantel(int $idPlantel)
        {
            $sql = "SELECT *FROM t_planteles WHERE id = $idPlantel";
            $request = $this->select($sql);
            return $request;
        }
		//Funcion para consultar Datos de un Plantel por ID
		public function selectInstitucion(int $idInstitucion){
			$sql = "SELECT *FROM t_instituciones WHERE id = $idInstitucion";
			$request = $this->select($sql);
			return $request;
		}

		//Funcion para consultar Lista de Estados de Mexico
		public function selectEstados(){
			$sql = "SELECT id,nombre FROM t_estados";
			$request = $this->select_all($sql);
			return $request;
		}
		//Funcion para consultar Lista de Municipios por ID de Estado
		public function selectMunicipios($data){
			$sql = "SELECT id,nombre FROM t_municipios WHERE id_estados = $data";
			$request = $this->select_all($sql);
			return $request;
		}
		//Funcion para consultar Lista de Localidades por ID de Municipio
		public function selectLocalidades($data){
			$sql = "SELECT *FROM t_localidades WHERE id_municipio = $data";
			$request = $this->select_all($sql);
			return $request;
		}
		//Funcion para Insertar Nuevo Plantel
		public function insertInstitucion($data,$files){
			$idUser = $_SESSION['idUser'];
            $idPlantel = $data['select_plantel_nuevo'];
			$idSistemaEducativo = $data['select_sistema_educativo_nuevo'];
            $nombreInstitucion = $data['txt_nombre_nuevo'];
            $abreviacionInstitucion = $data['txt_abreviacion_nuevo'];
            $regimen = $data['txt_regimen_nuevo'];
            $claveCentroTrabajo = $data['txt_clave_centro_trabajo_nuevo'];
            $servicio = $data['txt_servicio_nuevo'];
            $categoria = $data['txt_categoria_nuevo'];
            $zonaEscolar = $data['txt_zona_escolar_nuevo'];
			$cedulaFuncionamiento = $data['txt_cedula_funcionamiento_nuevo'];
			$cveInstitucionDGP = $data['txt_clave_dgp_nuevo'];
			$estatus = $data['estatus_nuevo'];

            $nombreImagenInstitucion = time().'-'.$nombreInstitucion . '-' . $abreviacionInstitucion . '-' . $idPlantel. '.' .pathinfo($files["profileImageInstitucion"]["name"], PATHINFO_EXTENSION);
            $direccionLogos = 'Assets/images/logos/';
			$nombreImagenInstitucionFile = $direccionLogos . basename($nombreImagenInstitucion);
			$request = [];
			$sqlExist = "SELECT *FROM t_instituciones WHERE cve_centro_trabajo = '$claveCentroTrabajo'";
			$requestExist = $this->select($sqlExist);
			if($requestExist){
				$request['estatus'] = TRUE;
				$request['imagen'] = null;
			}else{
				if(move_uploaded_file($files["profileImageInstitucion"]["tmp_name"],$nombreImagenInstitucionFile)){
                	$sqlNew = "INSERT INTO t_instituciones(nombre_institucion,abreviacion_institucion,regimen,servicio,categoria,zona_escolar, 
					logo_institucion,cve_centro_trabajo,cedula_funcionamiento,cve_institucion_dgp,estatus,fecha_creacion,id_usuario_creacion, 
					id_sistemas_educativos,id_planteles) VALUES(?,?,?,?,?,?,?,?,?,?,?,NOW(),?,?,?)";
			    	$requestNew = $this->insert($sqlNew,array($nombreInstitucion,$abreviacionInstitucion,$regimen,$servicio,$categoria,$zonaEscolar,$nombreImagenInstitucion,$claveCentroTrabajo,$cedulaFuncionamiento,$cveInstitucionDGP,$estatus,$idUser,$idSistemaEducativo,$idPlantel));
					$request['estatus'] = FALSE;
					$request['imagen'] = true;
            	}else{
					$request['estatus'] = FALSE;
					$request['imagen'] = false;
				}
			}
			return $request;
		}
		//Funcion para Actualizar un Plantel
		public function updateInstitucion($idInstitucionEdit,$data,$files){
 			$idUser = $_SESSION['idUser'];
            $nombreInstitucion = $data['txt_nombre_edit'];
			$idSistemaEducativo = $data['select_sistema_educativo_edit'];
            $abreviacionInstitucion = $data['txt_abreviacion_edit'];
            $idPlantel = $data['select_plantel_edit'];
            $regimen = $data['txtRegimenEdit'];
            $claveCentroTrabajo = $data['txtClaveCentroTrabajoEdit'];
            $servicio = $data['txtServicioEdit'];
            $idCategoria = $data['txtCategoriaEdit'];
            $zonaEscolar = $data['txtZonaEscolarEdit'];
			$cedulaFuncionamiento = $data['txtCedulaFuncionamientoEdit'];
			$cveInstitucionDGP = $data['txtClaveInstitucionDGPEdit'];
            $intEstatus = $data['select_estatus_edit'];

            $nombreImagenInstitucion = time() .'-'.$nombreInstitucion . '-' . $abreviacionInstitucion . '-' . $idPlantel. '.' .pathinfo($files["profileImageInstitucion"]["name"], PATHINFO_EXTENSION);

            $direccionLogos = 'Assets/images/logos/';
			$nombreImagenInstitucionFile = $direccionLogos . basename($nombreImagenInstitucion);

			$request = [];
			$sqlExist = "SELECT *FROM t_instituciones WHERE cve_centro_trabajo = '$claveCentroTrabajo' AND id != $idInstitucionEdit";
			$requestExist = $this->select($sqlExist);
			if($requestExist){
				$request['estatus'] = TRUE;
				
			}else{
				if($files["profileImageInstitucion"]["name"] == ""){
 					$sqlUpdate = "UPDATE t_instituciones SET nombre_institucion = ?,abreviacion_institucion = ?,regimen = ?,servicio = ?,categoria = ?,
					cve_centro_trabajo = ?,zona_escolar = ?,cedula_funcionamiento = ?,cve_institucion_dgp = ?,estatus = ?,fecha_actualizacion = NOW(),id_usuario_actualizacion = ? ,id_sistemas_educativos = ?,id_planteles = ? WHERE id = $idInstitucionEdit";
					$requestUpdate = $this->update($sqlUpdate,array($nombreInstitucion,$abreviacionInstitucion,$regimen,$servicio,$idCategoria,
						$claveCentroTrabajo,$zonaEscolar,$cedulaFuncionamiento,$cveInstitucionDGP,$intEstatus,$idUser,$idSistemaEducativo,$idPlantel));
					$request['estatus'] = FALSE;
				}else{
					if(move_uploaded_file($files["profileImageInstitucion"]["tmp_name"],$nombreImagenInstitucionFile)){
                        $sqlUpdate = "UPDATE t_instituciones SET nombre_institucion = ?,abreviacion_institucion = ?,regimen = ?,servicio = ?,categoria = ?,
                        cve_centro_trabajo = ?,zona_escolar = ?,logo_institucion = ?,cedula_funcionamiento = ?,cve_institucion_dgp = ?,estatus = ?,fecha_actualizacion = NOW(),id_usuario_actualizacion = ? ,id_sistemas_educativos = ?,id_planteles = ? WHERE id = $idInstitucionEdit";
                        $requestUpdate = $this->update($sqlUpdate,array($nombreInstitucion,$abreviacionInstitucion,$regimen,$servicio,$idCategoria,
                            $claveCentroTrabajo,$zonaEscolar,$nombreImagenInstitucion,$cedulaFuncionamiento,$cveInstitucionDGP,$intEstatus,$idUser,$idSistemaEducativo,$idPlantel));
                        $request['estatus'] = FALSE;
					} 
				}
			}
			return $request;  	
		}


		public function deleteInstitucion(int $idInstitucion, int $idUser){
			$sql = "SELECT * FROM t_instituciones WHERE id = $idInstitucion";
			$request = $this->select_all($sql);
			if($request){
				$sql = "UPDATE t_instituciones SET estatus = ?,fecha_actualizacion = NOW(), id_usuario_actualizacion = ? WHERE id = $idInstitucion";
				$arrData = array(0,$idUser);
				$request = $this->update($sql,$arrData);
				if($request){
					$request = 'ok';	
				}else{
					$request = 'error';
				}
			}
		return $request;	
		}
		public function getTablasRef(){
			$sqlTablasRef = "SELECT TABLE_NAME AS tablas FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = '".DB_NAME."' AND REFERENCED_TABLE_NAME = 't_instituciones'";
			$requestTablasRef = $this->select_all($sqlTablasRef);
			return $requestTablasRef;
		}
		public function estatusRegistroTabla(string $nombreTabla,int $idInstitucion){
			$sqlEstatusRegistro = "SELECT * FROM t_instituciones
			RIGHT JOIN $nombreTabla ON $nombreTabla.id_instituciones = t_instituciones.id
			WHERE t_instituciones.id = $idInstitucion AND  $nombreTabla.estatus != 0";
			$requestEstatusRegistro = $this->select_all($sqlEstatusRegistro);
			return $requestEstatusRegistro;
		}
		public function selectColumn(string $nombreTabla){
            $sql = "SHOW COLUMNS FROM $nombreTabla LIKE 'estatus'";
            $request = $this->select($sql);
            return $request;
        }

		public function selectSistemasEducativos()
		{
			$sql = "SELECT *FROM t_sistemas_educativos WHERE estatus = 1";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectSistemaEducativo(int $idSistema)
		{
			$sql = "SELECT *FROM t_sistemas_educativos WHERE id = $idSistema LIMIT 1";
			$request = $this->select($sql);
			return $request;
		}
	}
?>