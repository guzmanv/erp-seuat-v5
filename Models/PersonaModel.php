<?php
    class PersonaModel extends Mysql{
        public function __construct(){
            parent::__construct();
        }
        public function selectPersonas(int $idPlantel){
            $sql = "SELECT p.id,p.alias,p.nombre_persona,p.ap_paterno,p.ap_materno,p.email,p.tel_celular,
            p.direccion,p.estatus,c.nombre_categoria,pros.id_plantel_prospectado  FROM t_personas AS p
            LEFT JOIN t_asignacion_categoria_persona AS ac ON ac.id_personas = p.id
            INNER JOIN t_categoria_personas AS c ON ac.id_categoria_persona = c.id
            INNER JOIN t_prospectos AS pros ON pros.id_personas = p.id
            WHERE p.estatus = 1  AND ac.id_categoria_persona = 1 AND ac.estatus = 1 AND pros.id_plantel_prospectado = $idPlantel ORDER BY p.id DESC";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectPersona($idPersona){
            $sql = "SELECT *FROM t_personas WHERE id = $idPersona";
            $request = $this->select($sql);
            return $request;
        }
        public function selectPersonaEdit(int $idPersona){
            $sql = "SELECT per.id,per.alias,per.ap_paterno,per.ap_materno,per.colonia,per.cp,per.direccion,per.edad,per.edo_civil,per.email,
            per.estatus,acp.id_categoria_persona,per.id_escolaridad,esc.nombre_escolaridad,per.id_localidad,loc.nombre AS nomlocalidad,
            per.nombre_persona,per.ocupacion,per.sexo,per.tel_celular,per.tel_fijo,mun.id AS idmun,mun.nombre AS nommunicipio,est.id AS idest,
            est.nombre AS nomestado, per.fecha_nacimiento,per.curp,ne.nombre_nivel_educativo AS nivel_carrera_interes, ne.id AS id_nivel_carrera_interes,
            ci.nombre_carrera AS carrera_interes,ci.id AS id_carrera_interes,pros.id_plantel_interes,pin.nombre_plantel_fisico,pin.municipio AS munplantel,pros.id_carrera_interes,mc.medio_captacion,pros.escuela_procedencia,
            pros.observaciones AS observacion 
            FROM t_prospectos AS pros
            INNER JOIN t_personas AS per ON pros.id_personas = per.id
            RIGHT JOIN t_asignacion_categoria_persona AS acp ON acp.id_personas = per.id
            LEFT JOIN t_escolaridad AS esc ON per.id_escolaridad = esc.id
            INNER JOIN t_localidades AS loc ON per.id_localidad = loc.id
            INNER JOIN t_municipios AS mun ON loc.id_municipio = mun.id
            INNER JOIN t_estados AS est ON mun.id_estados = est.id
            LEFT JOIN t_nivel_educativos AS ne ON pros.id_nivel_carrera_interes = ne.id
            LEFT JOIN t_carrera_interes AS ci ON pros.id_carrera_interes = ci.id
            INNER JOIN t_medios_captacion AS mc ON pros.id_medios_captacion = mc.id
            LEFT JOIN t_planteles AS pin ON pros.id_plantel_interes  = pin.id
            WHERE per.id =  $idPersona AND acp.id_categoria_persona = 1"; //1 = Prospecto
            $request = $this->select($sql);
            return $request;
        }
        public function selectCategoriasPersona(){
            $sql = "SELECT *FROM t_categoria_personas";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectGradosEstudios(){
            $sql = "SELECT *FROM t_escolaridad";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectNivelesEducativos(){
            $sql = "SELECT *FROM t_nivel_educativos WHERE estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }
        public function insertPersona($data, int $idUSer,int $id_subcampania, int $idPlantelProspectado){
            $alias = $data['txtAliasNuevo'];
            $nombre = $data['txtNombreNuevo'];
            $apellidoP = ($data['txtApellidoPaNuevo'] == '')?null:$data['txtApellidoPaNuevo'];
            $apellidoM = ($data['txtApellidoMaNuevo'] == '')?null:$data['txtApellidoMaNuevo'];
            $direccion = ($data['txtDireccionNuevo'] == '')?null:$data['txtDireccionNuevo'];
            $edad = ($data['txtEdadNuevo'] == '')?null:$data['txtEdadNuevo'];
            $sexo = $data['listSexoNuevo'];
            $cp = ($data['txtCPNuevo'] == '')?null:$data['txtCPNuevo'];
            $colonia = ($data['txtColoniaNuevo'] == '')?null:$data['txtColoniaNuevo'];
            $telefonoCelular = ($data['txtTelCelNuevo'] == '')?null:$data['txtTelCelNuevo'];
            $telefonoFijo = ($data['txtTelFiNuevo'] == '')?null:$data['txtTelFiNuevo'];
            $email = ($data['txtEmailNuevo'] == '')?null:$data['txtEmailNuevo'];
            $estadoCivil = ($data['listEstadoCivilNuevo'] == '')?null:$data['listEstadoCivilNuevo'];
            $ocupacion = ($data['txtOcupacionNuevo'] == '')?null:$data['txtOcupacionNuevo'];
            $grado = ($data['listEscolaridadNuevo'] == '')?null:$data['listEscolaridadNuevo'];
            $localidad = $data['listLocalidadNuevo'];
            $categoriaPersona = 1; //1 = Prospecto
            $fechaNacimiento = ($data['txtFechaNacimientONuevo'] == '')?null:$data['txtFechaNacimientONuevo'];
            $CURP = ($data['txtCURPNuevo'] == '')?null:$data['txtCURPNuevo'];
            $plantelInteres = ($data['listPlantelInteres'] == '')?null:$data['listPlantelInteres'];
            $nivelCarreraInteres = ($data['listNivelCarreraInteres'] == '')?null:$data['listNivelCarreraInteres'];
            $carreraInteres = ($data['listCarreraInteres'] == '')?null:$data['listCarreraInteres'];
            $medioCaptacion = $data['listMediosCaptacion'];
            $escuelaProcedencia = ($data['txtNombreEscuelaProc'] == '')?null:$data['txtNombreEscuelaProc'];
            $observacion = $data['txtObservacion'];
            $sqlPersona = "INSERT INTO t_personas(nombre_persona,ap_paterno,ap_materno,alias,direccion,edad,sexo,cp,colonia,tel_celular,tel_fijo,email,edo_civil,ocupacion,curp,fecha_nacimiento,estatus,fecha_creacion,id_localidad,id_escolaridad,id_usuario_creacion) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),?,?,?)";
            $requestPersona = $this->insert($sqlPersona,array($nombre,$apellidoP,$apellidoM,$alias,$direccion,$edad,$sexo,$cp,$colonia,$telefonoCelular,$telefonoFijo,$email,$estadoCivil,$ocupacion,$CURP,$fechaNacimiento,1,$localidad,$grado,$idUSer));
            if($requestPersona){
                $idPersona = $requestPersona;
                $sqlAsignCategoria = "INSERT INTO t_asignacion_categoria_persona(fecha_alta,validacion_datos_personales,validacion_doctos,estatus,fecha_creacion,id_usuario_creacion,id_personas,id_categoria_persona) VALUES(NOW(),?,?,?,NOW(),?,?,?)";
                $requestAsignCategoria = $this->insert($sqlAsignCategoria,array(0,0,1,$idUSer,$idPersona,$categoriaPersona));
                 if($requestAsignCategoria){
                    $sqlProspecto = "INSERT INTO t_prospectos(escuela_procedencia,observaciones,id_plantel_interes,id_plantel_prospectado,id_nivel_carrera_interes,id_carrera_interes,id_medios_captacion,id_subcampanias,id_personas) VALUES(?,?,?,?,?,?,?,?,?)";
                    $requestProspecto = $this->insert($sqlProspecto,array($escuelaProcedencia,$observacion,$plantelInteres,$idPlantelProspectado,$nivelCarreraInteres,$carreraInteres,$medioCaptacion,$id_subcampania,$idPersona));
                }
            }
            return $requestProspecto;
        }

        public function updatePersona($idPersona,$data,int $idUSer){
            $nombre = $data['txtNombreEdit'];
            $alias = $data['txtAliasEdit'];
            $apellidoP = ($data['txtApellidoPaEdit'] == '')?null:$data['txtApellidoPaEdit'];
            $apellidoM = ($data['txtApellidoMaEdit'] == '')?null:$data['txtApellidoMaEdit'];
            $edad = ($data['txtEdadEdit'] == '')?null:$data['txtEdadEdit'];
            $estadoCivil = ($data['listEstadoCivilEdit'] == '')?null:$data['listEstadoCivilEdit'];
            $fechaNacimiento = ($data['txtFechaNacimientoEdit'] == '')?null:$data['txtFechaNacimientoEdit'];
            $CURP = ($data['txtCURPEdit'] == '')?null:$data['txtCURPEdit'];
            $ocupacion = ($data['txtOcupacionEdit'] == '')?null:$data['txtOcupacionEdit'];
            $telefonoCelular = ($data['txtTelCelEdit'] == '')?null:$data['txtTelCelEdit'];
            $telefonoFijo = ($data['txtTelFiEdit'] == '')?null:$data['txtTelFiEdit'];
            $escolaridad = ($data['listEscolaridadEdit'] == '')?null:$data['listEscolaridadEdit'];
            $plantelInteres = ($data['listPlantelInteresEdit'] == '')?null:$data['listPlantelInteresEdit'];
            $nivelCarreraInteres = ($data['listNivelCarreraInteresEdit'] == '')?null:$data['listNivelCarreraInteresEdit'];
            $carreraInteres = ($data['listCarreraInteresEdit'] == '')?null:$data['listCarreraInteresEdit'];
            $escuelaProcedencia = ($data['txtNombreEscuelaProcEdit'] == '')?null:$data['txtNombreEscuelaProcEdit'];
            $email = ($data['txtEmailEdit'] == '')?null:$data['txtEmailEdit'];
            $colonia = ($data['txtColoniaEdit'] == '')?null:$data['txtColoniaEdit'];
            $CP = ($data['txtCPEdit'] == '')?null:$data['txtCPEdit'];
            $direccion = ($data['txtDireccionEdit'] == '')?null:$data['txtDireccionEdit'];
            $observacion = ($data['txtObservacionEdit'] == '')?null:$data['txtObservacionEdit'];
            $sql = "UPDATE t_personas SET nombre_persona = ?,ap_paterno = ?,ap_materno = ?,alias = ?,direccion = ?,edad = ?,cp = ?,colonia = ?,tel_celular = ?,tel_fijo = ?,email = ?,edo_civil = ?,ocupacion = ?,curp = ?,fecha_nacimiento = ?,fecha_actualizacion = NOW(),id_escolaridad = ?,id_usuario_actualizacion = ? WHERE id = $idPersona";
            $request = $this->update($sql,array($nombre,$apellidoP,$apellidoM,$alias,$direccion,$edad,$CP,$colonia,$telefonoCelular,$telefonoFijo,$email,$estadoCivil,$ocupacion,$CURP,$fechaNacimiento,$escolaridad,$idUSer)); 
            if($request){
                $sqlProspecto = "UPDATE t_prospectos SET escuela_procedencia = ?,observaciones = ?, id_plantel_interes = ?,id_nivel_carrera_interes = ?,id_carrera_interes = ? WHERE id_personas = $idPersona";
                $requestProspecto = $this->update($sqlProspecto, array($escuelaProcedencia, $observacion, $plantelInteres, $nivelCarreraInteres, $carreraInteres));
            }
            return $requestProspecto;
        }
        public function selectEstados(){
            $sql = "SELECT *FROM t_estados";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectMunicipios($idEstado){
            $idEstado = $idEstado;
            $sql = "SELECT *FROM t_municipios WHERE id_estados = $idEstado";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectLocalidades($idMunicipio){
            $idMunicipio = $idMunicipio;
            $sql = "SELECT *FROM t_localidades WHERE id_municipio = $idMunicipio";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectCarrerasInteres($idNivel){
            $idNivel = $idNivel;
            $sql = "SELECT *FROM t_carrera_interes WHERE id_nivel_educativo = $idNivel";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectPlanteles(){
            $sql = "SELECT *FROM t_planteles WHERE estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectMediosCaptacion(){
            $sql = "SELECT *FROM t_medios_captacion";
            $request = $this->select_all($sql);
            return $request;
        }
        public function deletePersona($idPersona){
            $sql = "SELECT * FROM t_personas WHERE id = $idPersona";
			$request = $this->select_all($sql);
			if($request){
				$sql = "UPDATE t_personas SET estatus = ? WHERE id = $idPersona";
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
        public function selectSubcampania(){
            $sql = "SELECT *FROM t_subcampania WHERE estatus = 1 ORDER BY fecha_fin DESC LIMIT 1";
            $request = $this->select($sql);
            return $request;
        }
        
        public function insertPersonaCSV(int $id, string $nombrePersona, $apPaterno, $apMaterno, string $alias, $direccion, $edad, string $sexo, $cp, $colonia, $telCelular, $telFijo, $email, $edoCivil, $ocupacion, int $idLocalidad, $curp, $fechaNacimiento, int $estatus, int $idRol, $idEscolaridad, $escuelaProcedencia, $plantelInteres, $nivelCarreraInteres, $carreraInteres, $medioCaptacion, $idsubcampania, string $plantelOrigen, string $folioTransferencia, int $idUser, int $idPlantel){
            $sqlPersona = "INSERT INTO t_personas(nombre_persona,ap_paterno,ap_materno,alias,direccion,edad,sexo,cp,colonia,tel_celular,tel_fijo,email,edo_civil,ocupacion,id_localidad,curp,fecha_nacimiento,estatus,fecha_creacion,id_usuario_creacion,id_rol,id_escolaridad) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),?,?,?)";
            $requestPersona = $this->insert($sqlPersona,array($nombrePersona,$apPaterno,$apMaterno,$alias,$direccion,$edad,$sexo,$cp,$colonia,$telCelular,$telFijo,$email,$edoCivil,$ocupacion,$idLocalidad,$curp,$fechaNacimiento,$estatus,$idUser,$idRol,$idEscolaridad));
            $categoriaPersona = 1; //1 = Prospecto
            if($requestPersona){
                $idPersona = $requestPersona;
                $sqlAsignCategoria = "INSERT INTO t_asignacion_categoria_persona(fecha_alta,validacion_datos_personales,validacion_doctos,estatus,fecha_creacion,id_usuario_creacion,id_personas,id_categoria_persona) VALUES(NOW(),?,?,?,NOW(),?,?,?)";
                $requestAsignCategoria = $this->insert($sqlAsignCategoria,array(0,0,1,$idUser,$idPersona,$categoriaPersona));
                if($requestAsignCategoria){
                    $sqlProspecto = "INSERT INTO t_prospectos(escuela_procedencia,observaciones,id_plantel_interes,id_plantel_prospectado,id_nivel_carrera_interes,id_carrera_interes,id_medios_captacion,id_subcampania,id_personas) VALUES(?,?,?,?,?,?,?,?,?)";
                    $requestProspecto = $this->insert($sqlProspecto,array($escuelaProcedencia,null,$plantelInteres,$idPlantel,$nivelCarreraInteres,$carreraInteres,$medioCaptacion,$idsubcampania,$idPersona));
                }
            }
            return $requestProspecto;
        }

        public function selectCanceladoInscripcion($idPersona)
        {
           $sqlCancelado = "SELECT *FROM t_historiales AS th 
           LEFT JOIN t_inscripciones AS ti ON ti.id_historial = th.id
           WHERE ti.id_personas = $idPersona AND th.cancelado = 1";
           $requestCancelado = $this->select($sqlCancelado);
           return $requestCancelado;
        }
    }
?>