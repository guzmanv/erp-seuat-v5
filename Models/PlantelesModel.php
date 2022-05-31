<?php
    class PlantelesModel extends Mysql{

        public function __construct(){
            parent::__construct();
        }
        public function selectPlanteles(){
            $sql = "SELECT *FROM t_planteles WHERE estatus  != 0";
            $request = $this->select_all($sql);
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

        public function insertPlantel($data, int $idUser)
        {
            $nombrePlantel = $data['txt_nombre_nuevo'];
            $idEstado = $data['select_estado_nuevo'];
            $idMunicipio = $data['select_municipio_nuevo'];
            $idLocalidad = $data['select_localidad_nuevo'];
            $domicilio = $data['txt_domicilio_nuevo'];
			$latitud = $data['txt_latitud_nuevo'];
			$longitud = $data['txt_longitud_nuevo'];
            $colonia = $data['txt_colonia_nuevo'];
            $codigoPostal = $data['txt_codigo_postal_nuevo'];
            $estatus = $data['estatus_nuevo'];

			$sqlNomEstado = "SELECT nombre FROM t_estados WHERE id = $idEstado LIMIT 1";
			$requestNomEstado = $this->select($sqlNomEstado);
			$sqlNomMunicipio = "SELECT nombre FROM t_municipios WHERE id = $idMunicipio LIMIT 1";
			$requestNomMunicipio = $this->select($sqlNomMunicipio);
			$sqlNomLocalidad = "SELECT nombre FROM t_localidades WHERE id = $idLocalidad LIMIT 1";
			$requestNomLocalidad = $this->select($sqlNomLocalidad);

            $sqlNew = "INSERT INTO t_planteles(nombre_plantel_fisico,estado,municipio,localidad,domicilio,colonia,cod_postal,latitud,longitud,estatus,fecha_creacion,id_usuario_creacion) VALUES(?,?,?,?,?,?,?,?,?,?,NOW(),?)";
            $requestNew = $this->insert($sqlNew,array($nombrePlantel,$requestNomEstado['nombre'],$requestNomMunicipio['nombre'],$requestNomLocalidad['nombre'],$domicilio,$colonia,$codigoPostal,$latitud,$longitud,$estatus,$idUser));
			return $requestNew;
        }

        		//Funcion para Actualizar un Plantel
		public function updatePlantel(int $idPlantelEdit,$data,int $idUser){
            $nombrePlantel = $data['txt_nombre_edit'];
            $idEstado = $data['select_estado_edit'];
            $idMunicipio = $data['select_municipio_edit'];
            $idLocalidad = $data['select_localidad_edit'];
            $domicilio = $data['txt_domicilio_edit'];
			$latitud = $data['txt_latitud_edit'];
			$longitud = $data['txt_longitud_edit'];
            $colonia = $data['txt_colonia_edit'];
            $codigoPostal = $data['txt_codigo_postal_edit'];
            $estatus = $data['select_estatus_edit'];

			$sqlNomEstado = "SELECT nombre FROM t_estados WHERE id = $idEstado LIMIT 1";
			$requestNomEstado = $this->select($sqlNomEstado);
			$sqlNomMunicipio = "SELECT nombre FROM t_municipios WHERE id = $idMunicipio LIMIT 1";
			$requestNomMunicipio = $this->select($sqlNomMunicipio);
			$sqlNomLocalidad = "SELECT nombre FROM t_localidades WHERE id = $idLocalidad LIMIT 1";
			$requestNomLocalidad = $this->select($sqlNomLocalidad);

            $sqlUpdate = "UPDATE t_planteles SET nombre_plantel_fisico = ?,estado = ?,municipio = ?,localidad = ?,domicilio = ?,
					colonia = ?,cod_postal = ?,latitud = ?,longitud = ?,estatus = ?,fecha_actualizacion = NOW(),id_usuario_actualizacion = ? WHERE id = $idPlantelEdit";
			$requestUpdate = $this->update($sqlUpdate,array($nombrePlantel,$requestNomEstado['nombre'],$requestNomMunicipio['nombre'],$requestNomLocalidad['nombre'],$domicilio,$colonia,$codigoPostal,$latitud,$longitud,$estatus,$idUser));
			return $requestUpdate;  	
		}

		//Funcion para consultar Datos de un Plantel por ID
		public function selectPlantel(int $idPlantel){
			$sql = "SELECT *FROM t_planteles WHERE id = $idPlantel LIMIT 1";
			$request = $this->select($sql);
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
			}else{
                $request = 'exist';
            }
		    return $request;	
		}

    }
?>