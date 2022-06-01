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
					id_sistema,id_plantel) VALUES(?,?,?,?,?,?,?,?,?,?,?,NOW(),?,?,?)";
			    	$requestNew = $this->insert($sqlNew,array($nombreInstitucion,$abreviacionInstitucion,$regimen,$servicio,$categoria,$zonaEscolar,$nombreImagenInstitucionFile,$claveCentroTrabajo,$cedulaFuncionamiento,$cveInstitucionDGP,$estatus,$idUser,$idSistemaEducativo,$idPlantel));
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
		public function updatePlantel($idPlantelEdit,$data,$files){
			$idUser = $_SESSION['idUser'];
			$idSistemaEducativo = $data['select_sistema_educativo_edit'];
			$nombrePlantel = $data['txtNombrePlantelEdit'];
            $abreviacionPlantel = $data['txtAbreviacionPlantelEdit'];
            //$nombreSistema = $data['txtNombreSistemaEdit'];
            //$abreviacionSistema = $data['txtAbreviacionSistemaEdit'];
            $regimen = $data['txtRegimenEdit'];
            $servicio = $data['txtServicioEdit'];
            $idCategoria = $data['txtCategoriaEdit'];
            //$acuerdoIncorporacion = $data['txtAcuerdoIncorporacionEdit'];
            $claveCentroTrabajo = $data['txtClaveCentroTrabajoEdit'];
            $idEstado = $data['listEstadoEdit'];
            $idMunicipio = $data['listMunicipioEdit'];
            $idLocalidad = $data['listLocalidadEdit'];
            $domicilio = $data['txtDomicilioEdit'];
            $colonia = $data['txtColoniaEdit'];
            $zonaEscolar = $data['txtZonaEscolarEdit'];
            $codigoPostal = $data['txtCodigoPostalEdit'];
			$latitud = $data['txtLatitudEdit'];
			$longitud = $data['txtLongitudEdit'];
			$cedulaFuncionamiento = $data['txtCedulaFuncionamientoEdit'];
			//$cveDGP = $data['txtClaveDGPEdit'];
			$cveInstitucionDGP = $data['txtClaveInstitucionDGPEdit'];

        
			$sqlNomEstado = "SELECT nombre FROM t_estados WHERE id = $idEstado LIMIT 1";
			$requestNomEstado = $this->select($sqlNomEstado);
			$sqlNomMunicipio = "SELECT nombre FROM t_municipios WHERE id = $idMunicipio LIMIT 1";
			$requestNomMunicipio = $this->select($sqlNomMunicipio);
			$sqlNomLocalidad = "SELECT nombre FROM t_localidades WHERE id = $idLocalidad LIMIT 1";
			$requestNomLocalidad = $this->select($sqlNomLocalidad);

            $nombreImagenPlantel = time() .'-'.$abreviacionPlantel . '-' . $requestNomEstado['nombre'] . '-' . $requestNomMunicipio['nombre']. '.' .pathinfo($files["profileImagePlantel"]["name"], PATHINFO_EXTENSION);
			/* $nombreImagenSistema = time() .'-'.$abreviacionSistema . '-' . $requestNomEstado['nombre'] . '-' . $requestNomMunicipio['nombre']. '.' .pathinfo($files["profileImageSistema"]["name"], PATHINFO_EXTENSION); */
            $direccionLogos = 'Assets/images/logos/';
			$nombreImagenPlantelFile = $direccionLogos . basename($nombreImagenPlantel);
			/* $nombreImagenSistemaFile = $direccionLogos . basename($nombreImagenSistema); */

			$request = [];
			$sqlExist = "SELECT *FROM t_planteles WHERE cve_centro_trabajo = '$claveCentroTrabajo' AND id != $idPlantelEdit";
			$requestExist = $this->select($sqlExist);
			if($requestExist){
				$request['estatus'] = TRUE;
				
			}else{
				if($files["profileImagePlantel"]["name"] == ""){
					$sqlUpdate = "UPDATE t_planteles SET nombre_plantel = ?,abreviacion_plantel = ?,regimen = ?,servicio = ?,categoria = ?,
					cve_centro_trabajo = ?,estado = ?,municipio = ?,localidad = ?,domicilio = ?,colonia = ?,zona_escolar = ?,cod_postal = ?,latitud = ?,longitud = ?,
					logo_plantel = ?,cedula_funcionamiento = ?,cve_institucion_dgp = ?,estatus = ?,fecha_actualizacion = NOW(),id_usuario_actualizacion = ? ,id_sistema = ? WHERE id = $idPlantelEdit";
					$requestUpdate = $this->update($sqlUpdate,array($nombrePlantel,$abreviacionPlantel,$regimen,$servicio,$idCategoria,
						$claveCentroTrabajo,$requestNomEstado['nombre'],$requestNomMunicipio['nombre'],$requestNomLocalidad['nombre'],$domicilio,$colonia,$zonaEscolar,$codigoPostal,$latitud,$longitud,
						$nombreImagenPlantel,$cedulaFuncionamiento,$cveInstitucionDGP,1,$idUser,$idSistemaEducativo));
					$request['estatus'] = FALSE;
				}else{
					if(move_uploaded_file($files["profileImagePlantel"]["tmp_name"],$nombreImagenPlantelFile)){
						$sqlUpdate = "UPDATE t_planteles SET nombre_plantel = ?,abreviacion_plantel = ?, regimen = ?,servicio = ?,categoria = ?,
						cve_centro_trabajo = ?,estado = ?,municipio = ?,localidad = ?,domicilio = ?,colonia = ?,zona_escolar = ?,cod_postal = ?,latitud = ?,longitud = ?,
						logo_plantel = ?,cedula_funcionamiento = ?,cve_institucion_dgp = ?,estatus = ?,fecha_actualizacion = NOW(),id_usuario_actualizacion = ?, id_sistema = ? WHERE id = $idPlantelEdit";
						$requestUpdate = $this->update($sqlUpdate,array($nombrePlantel,$abreviacionPlantel,$regimen,$servicio,$idCategoria,
								$claveCentroTrabajo,$requestNomEstado['nombre'],$requestNomMunicipio['nombre'],$requestNomLocalidad['nombre'],$domicilio,$colonia,$zonaEscolar,$codigoPostal,$latitud,$longitud,
								$nombreImagenPlantel,$cedulaFuncionamiento,$cveInstitucionDGP,1,$idUser,$idSistemaEducativo));
						$request['estatus'] = FALSE;
					}
				}
/* 
				if($files["profileImagePlantel"]["name"] == "" || $files["profileImageSistema"]["name"] == ""){
					if($files["profileImagePlantel"]["name"] != ""){
						if(move_uploaded_file($files["profileImagePlantel"]["tmp_name"],$nombreImagenPlantelFile)){
							$sqlUpdate = "UPDATE t_planteles SET nombre_plantel = ?,abreviacion_plantel = ?,nombre_sistema = ?,abreviacion_sistema = ?,regimen = ?,servicio = ?,categoria = ?,
						cve_centro_trabajo = ?,estado = ?,municipio = ?,localidad = ?,domicilio = ?,colonia = ?,zona_escolar = ?,cod_postal = ?,latitud = ?,longitud = ?,
						logo_plantel = ?,cedula_funcionamiento = ?,cve_institucion_dgp = ?,estatus = ?,fecha_actualizacion = NOW(),id_usuario_creacion = ?,id_usuario_actualizacion = ? WHERE id = $idPlantelEdit";
						$requestUpdate = $this->update($sqlUpdate,$nomConexion,array($nombrePlantel,$abreviacionPlantel,$nombreSistema,$abreviacionSistema,$regimen,$servicio,$idCategoria,
								$claveCentroTrabajo,$requestNomEstado['nombre'],$requestNomMunicipio['nombre'],$requestNomLocalidad['nombre'],$domicilio,$colonia,$zonaEscolar,$codigoPostal,$latitud,$longitud,
								$nombreImagenPlantel,$cedulaFuncionamiento,$cveInstitucionDGP,1,$idUser,$idUser));
						}
					}else if($files["profileImageSistema"]["name"] != ""){
						if(move_uploaded_file($files["profileImageSistema"]["tmp_name"],$nombreImagenSistemaFile)){
							$sqlUpdate = "UPDATE t_planteles SET nombre_plantel = ?,abreviacion_plantel = ?,nombre_sistema = ?,abreviacion_sistema = ?,regimen = ?,servicio = ?,categoria = ?,
						cve_centro_trabajo = ?,estado = ?,municipio = ?,localidad = ?,domicilio = ?,colonia = ?,zona_escolar = ?,cod_postal = ?,latitud = ?,longitud = ?,
						logo_sistema = ?,cedula_funcionamiento = ?,cve_institucion_dgp = ?,estatus = ?,fecha_actualizacion = NOW(),id_usuario_creacion = ?,id_usuario_actualizacion = ? WHERE id = $idPlantelEdit";
						$requestUpdate = $this->update($sqlUpdate,$nomConexion,array($nombrePlantel,$abreviacionPlantel,$nombreSistema,$abreviacionSistema,$regimen,$servicio,$idCategoria,
								$claveCentroTrabajo,$requestNomEstado['nombre'],$requestNomMunicipio['nombre'],$requestNomLocalidad['nombre'],$domicilio,$colonia,$zonaEscolar,$codigoPostal,$latitud,$longitud,
								$nombreImagenSistema,$cedulaFuncionamiento,$cveInstitucionDGP,1,$idUser,$idUser));
						}
					}else{
						$sqlUpdate = "UPDATE t_planteles SET nombre_plantel = ?,abreviacion_plantel = ?,nombre_sistema = ?,abreviacion_sistema = ?,regimen = ?,servicio = ?,categoria = ?,
					cve_centro_trabajo = ?,estado = ?,municipio = ?,localidad = ?,domicilio = ?,colonia = ?,zona_escolar = ?,cod_postal = ?,latitud = ?, longitud = ?,cedula_funcionamiento = ?,cve_institucion_dgp = ?,
					estatus = ?,fecha_actualizacion = NOW(),id_usuario_creacion = ?,id_usuario_actualizacion = ? WHERE id = $idPlantelEdit";
					$requestUpdate = $this->update($sqlUpdate,$nomConexion,array($nombrePlantel,$abreviacionPlantel,$nombreSistema,$abreviacionSistema,$regimen,$servicio,$idCategoria,
							$claveCentroTrabajo,$requestNomEstado['nombre'],$requestNomMunicipio['nombre'],$requestNomLocalidad['nombre'],$domicilio,$colonia,$zonaEscolar,$codigoPostal,$latitud,$longitud,$cedulaFuncionamiento,$cveInstitucionDGP,
							1,$idUser,$idUser));
					}
				}else{
					if(move_uploaded_file($files["profileImagePlantel"]["tmp_name"],$nombreImagenPlantelFile) || 
					move_uploaded_file($files["profileImageSistema"]["tmp_name"],$nombreImagenSistemaFile)){
						$sqlUpdate = "UPDATE t_planteles SET nombre_plantel = ?,abreviacion_plantel = ?,nombre_sistema = ?,abreviacion_sistema = ?,regimen = ?,servicio = ?,categoria = ?,
						cve_centro_trabajo = ?,estado = ?,municipio = ?,localidad = ?,domicilio = ?,colonia = ?,zona_escolar = ?,cod_postal = ?,latitud = ?, longitud = ?,logo_plantel = ?,
						logo_sistema=?,cedula_funcionamiento = ?,cve_institucion_dgp = ?,estatus = ?,fecha_actualizacion = NOW(),id_usuario_creacion = ?,id_usuario_actualizacion = ? WHERE id = $idPlantelEdit";
						$requestUpdate = $this->update($sqlUpdate,$nomConexion,array($nombrePlantel,$abreviacionPlantel,$nombreSistema,$abreviacionSistema,$regimen,$servicio,$idCategoria,
								$claveCentroTrabajo,$requestNomEstado['nombre'],$requestNomMunicipio['nombre'],$requestNomLocalidad['nombre'],$domicilio,$colonia,$zonaEscolar,$codigoPostal,$latitud,$longitud,
								$nombreImagenPlantel,$nombreImagenSistema,$cedulaFuncionamiento,$cveInstitucionDGP,1,$idUser,$idUser));
					}
				}
				$request['estatus'] = FALSE; */
			}
			return $request;  	
		}
		public function deletePlantel(int $idPlantel){
			$sql = "SELECT * FROM t_planteles WHERE id = $idPlantel";
			$request = $this->select_all($sql);
			if($request){
				$sql = "UPDATE t_planteles SET estatus = ? WHERE id = $idPlantel";
				$arrData = array(0);
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
			$sqlTablasRef = "SELECT TABLE_NAME AS tablas FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = '".DB_NAME."' AND REFERENCED_TABLE_NAME = 't_planteles'";
			$requestTablasRef = $this->select_all($sqlTablasRef);
			return $requestTablasRef;
		}
		public function estatusRegistroTabla(string $nombreTabla,int $idPlantel){
			$sqlEstatusRegistro = "SELECT * FROM t_planteles
			RIGHT JOIN $nombreTabla ON $nombreTabla.id_plantel = t_planteles.id
			WHERE t_planteles.id = $idPlantel AND  $nombreTabla.estatus != 0";
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