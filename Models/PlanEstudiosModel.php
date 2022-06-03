<?php
    class PlanEstudiosModel extends Mysql{
        public function __construct(){
            parent::__construct();
        }

        public function selectPlanteles(){
            $sql = "SELECT *FROM t_planteles WHERE estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectInstituciones()
        {
            $sql = "SELECT inst.id,inst.nombre_institucion,plant.nombre_plantel_fisico FROM t_instituciones AS inst 
            INNER JOIN t_planteles AS plant ON inst.id_plantel = plant .id 
            WHERE inst.estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectNivelEducativo(){
            $sql = "SELECT *FROM t_nivel_educativos WHERE estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectCategorias(){
            $sql = "SELECT *FROM t_categoria_carreras WHERE estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectModalidades(){
            $sql = "SELECT *FROM t_modalidades WHERE estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectPlanes(){
            $sql = "SELECT *FROM t_organizacion_planes WHERE estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectPlanEstudios(){
            $sql = "SELECT plan.id,plan.nombre_carrera,plan.rvoe,plan.fecha_vigencia,plan.estatus,
            inst.nombre_institucion,cat.nombre_categoria_carrera,plant.nombre_plantel_fisico FROM t_plan_estudios AS plan
                        INNER JOIN t_instituciones AS inst ON plan.id_institucion = inst.id 
                        INNER JOIN t_planteles AS plant ON inst.id_plantel = plant.id 
                        INNER JOIN t_categoria_carreras AS cat ON plan.id_categoria_carrera = cat.id
                        WHERE plan.estatus != 0
                        ORDER BY id DESC";
            $request = $this->select_all($sql);
            return $request;
        }
        public function insertPlanEstudios($data,$arreglo){
            $idUser = $_SESSION['idUser'];
            $nombrePlanEstudios = $data['txtNombreNuevo'];
            $nombreCorto = $data['txtNombrecortoNuevo'];
            $perfilEgreso = $data['txtPerfilEgresoNuevo'];
            $duracionCarrera = $data['txtDuracionNuevo'];
            $materiasTotales = $data['txtMatTotalesNuevo'];
            $totalHoras = $data['txtTotalHrsNuevo'];
            $totalCreditos = $data['listTotalCreditosNuevo'];
            $claveProfesiones = $data['txtClaveProfNuevo'];
            $tipoREVOE = $data['listTipoRvoeNuevo'];
            $REVOE = $data['txtRvoeNuevo'];
            $vigenciaREVOE = $data['txtFechaVigenciaNuevo'];
            $turnoRVOE = $data['listTunoRvoeNuevo'];
            $calificacionMinima = $data['txtCalMinNuevo'];
            $fechaOtorgamiento = $data['txtFechaOtorgamientoNuevo'];
            $fechaActualizacion = ($data['txtFechaActualizacionNuevo'] == '')?null:$data['txtFechaActualizacionNuevo'];
            $perfilIngreso = $data['txtPerfilIngresoNuevo'];
            $campoLaboral = $data['txtCampoLaboralNuevo'];
            //$estatus = $data['listEstatusNuevo'];
            $idPlan = $data['listPlanNuevo'];
            $idInstitucion = $data['listNivelEdNuevo'];
            $idNiveleducativo = $data['listNivelEdNuevo'];
            $idCategoriaCarrera = $data['listCategoriaNuevo'];
            $idModalidad = $data['listModalidadNuevo'];
            switch ($tipoREVOE) {
                case 0:
                    $tipoREVOE = "Estatal";
                case 1:
                    $tipoREVOE = "Federal";
            }
            $aplicaCalsificacion = (count($arreglo)>0)?true:false;
            if($aplicaCalsificacion == true){
                $sqlPlanEstudio = "INSERT INTO t_plan_estudios(nombre_carrera,nombre_carrera_corto,perfil_egreso,duracion_carrera,materias_totales,total_horas,total_creditos,clave_profesiones,
                    tipo_rvoe,rvoe,turno,fecha_vigencia,calificacion_minima,fecha_otorgamiento,perfil_ingreso,campo_laboral,estatus,aplica_clasificacion,fecha_creacion,fecha_actualizacion,id_plan,
                    id_institucion,id_nivel_educativo,id_categoria_carrera,id_modalidad,id_usuario_creacion,id_usuario_actualizacion,fecha_actualizacion_rvoe) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),NOW(),?,?,?,?,?,?,?,?)";
                $requestPlanEstudio = $this->insert($sqlPlanEstudio,array($nombrePlanEstudios,$nombreCorto,$perfilEgreso,$duracionCarrera,$materiasTotales,$totalHoras,$totalCreditos,$claveProfesiones,
                        $tipoREVOE,$REVOE,$turnoRVOE,$vigenciaREVOE,$calificacionMinima,$fechaOtorgamiento,$perfilIngreso,$campoLaboral,1,1,$idPlan,$idInstitucion,$idNiveleducativo,
                    $idCategoriaCarrera,$idModalidad,$idUser,$idUser,$fechaActualizacion));
                foreach ($arreglo as $key => $value) {
                    $sqlClasificacion = "INSERT INTO t_plan_x_clasificacion(id_plan_estudios,id_clasificacion_materias,total_creditos,estatus) VALUES (?,?,?,?)";
                    $requestClasificacion = $this->insert($sqlClasificacion,array($requestPlanEstudio,$value->id_clasificacion,$value->creditos,$value->estatus));
                }
                return $requestClasificacion; 
            }else{
                $sqlPlanEstudio = "INSERT INTO t_plan_estudios(nombre_carrera,nombre_carrera_corto,perfil_egreso,duracion_carrera,materias_totales,total_horas,total_creditos,clave_profesiones,
                tipo_rvoe,rvoe,turno,fecha_vigencia,calificacion_minima,fecha_otorgamiento,perfil_ingreso,campo_laboral,estatus,aplica_clasificacion,fecha_creacion,fecha_actualizacion,id_plan,
                id_institucion,id_nivel_educativo,id_categoria_carrera,id_modalidad,id_usuario_creacion,id_usuario_actualizacion,fecha_actualizacion_rvoe) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),NOW(),?,?,?,?,?,?,?,?)";
                $requestPlanEstudio = $this->insert($sqlPlanEstudio,array($nombrePlanEstudios,$nombreCorto,$perfilEgreso,$duracionCarrera,$materiasTotales,$totalHoras,$totalCreditos,$claveProfesiones,
                        $tipoREVOE,$REVOE,$turnoRVOE,$vigenciaREVOE,$calificacionMinima,$fechaOtorgamiento,$perfilIngreso,$campoLaboral,1,0,$idPlan,$idInstitucion,$idNiveleducativo,
                    $idCategoriaCarrera,$idModalidad,$idUser,$idUser,$fechaActualizacion));
                return $requestPlanEstudio;
            }
        }

        public function updatePlanEstudios($idPlanEstudiosEdit, $data,$arreglo){
            $idUser = $_SESSION['idUser'];
            $nombrePlanEstudios = $data['txtNombreEdit'];
            $nombreCorto = $data['txtNombrecortoEdit'];
            $perfilEgreso = $data['txtPerfilEgresoEdit'];
            $duracionCarrera = $data['txtDuracionEdit'];
            $materiasTotales = $data['txtMatTotalesEdit'];
            $totalHoras = $data['txtTotalHrsEdit'];
            $totalCreditos = $data['listTotalCreditosEdit'];
            $claveProfesiones = $data['txtClaveProfEdit'];
            $tipoREVOE = $data['listTipoRvoeEdit'];
            $REVOE = $data['txtRvoeEdit'];
            $vigenciaREVOE = $data['txtFechaVigenciaEdit'];
            $calificacionMinima = $data['txtCalMinEdit'];
            $fechaOtorgamiento = $data['txtFechaOtorgamientoEdit'];
            $fechaEstimadaTermino = $data['txtFechaActualizacionEdit'];
            $turnoRVOE = $data['listTunoRvoeEdit'];
            $perfilIngreso = $data['txtPerfilIngresoEdit'];
            $campoLaboral = $data['txtCampoLaboralEdit'];
            $estatus = $data['listEstatusEdit'];
            $idPlan = $data['listPlanEdit'];
            $idInstitucion = $data['listInstitucionEdit'];
            $idNiveleducativo = $data['listNivelEdEdit'];
            $idCategoriaCarrera = $data['listCategoriaEdit'];
            $idModalidad = $data['listModalidadEdit'];

            $sql = "UPDATE t_plan_estudios SET nombre_carrera = ?,nombre_carrera_corto = ?,perfil_egreso = ?,duracion_carrera = ?,materias_totales = ?,
            total_horas = ?,total_creditos = ?,clave_profesiones = ?,tipo_rvoe = ?,rvoe = ?,fecha_vigencia = ?,calificacion_minima = ?,fecha_otorgamiento = ?,turno = ?,
            perfil_ingreso = ?,campo_laboral = ?,estatus = ?,fecha_actualizacion = NOW(),id_plan = ?,id_institucion = ?,id_nivel_educativo = ?,
            id_categoria_carrera = ?,id_modalidad = ?,id_usuario_creacion = ?,id_usuario_actualizacion = ?,fecha_actualizacion_rvoe = ? WHERE id = $idPlanEstudiosEdit";
            $request = $this->update($sql,array($nombrePlanEstudios,$nombreCorto,$perfilEgreso,$duracionCarrera,$materiasTotales,$totalHoras,$totalCreditos,
            $claveProfesiones,$tipoREVOE,$REVOE,$vigenciaREVOE,$calificacionMinima,$fechaOtorgamiento,$turnoRVOE,$perfilIngreso,$campoLaboral,$estatus,$idPlan,$idInstitucion,
            $idNiveleducativo,$idCategoriaCarrera,$idModalidad,$idUser,$idUser,$fechaEstimadaTermino));
/*             if($request){
                foreach ($arreglo as $key => $value) {
                    if($value->id != 0){
                        $arreglo = "es cero";
                        $sqlClasificacion = "UPDATE t_plan_x_clasificacion SET total_creditos = ?, estatus = ? WHERE id = $value->id";
                        $requestClasificacion = $this->update($sqlClasificacion,array($value->creditos,$value->estatus));
                        $estatusUp = true;
                    }else{
                        $sqlClasificacion = "INSERT INTO t_plan_x_clasificacion(id_plan_estudios,id_clasificacion_materias,total_creditos,estatus) VALUES (?,?,?,?)";
                        $requestClasificacion = $this->insert($sqlClasificacion,array($idPlanEstudiosEdit,$value->id_clasificacion,$value->creditos,$value->estatus));
                        $estatusUp = true;
                    }
                } 
            }else{
                $estatusUp = false;
            } */
            return $request;
        }

        public function selectPlanEstudio($idPlanestudio){
            $sql = "SELECT plan.id,plan.nombre_carrera,plan.nombre_carrera_corto,plan.rvoe,plan.fecha_vigencia,plan.estatus,plan.duracion_carrera,plan.
            materias_totales,plan.total_horas,
                        plan.calificacion_minima,plan.total_creditos,plan.clave_profesiones,plan.tipo_rvoe,plan.
                        fecha_otorgamiento,plan.perfil_ingreso,plan.perfil_egreso,plan.campo_laboral,
                        inst.nombre_institucion,niv.nombre_nivel_educativo,cat.nombre_categoria_carrera,moda.nombre_modalidad,
                        pl.nombre_plan,plan.fecha_actualizacion_rvoe,plan.turno,plant.nombre_plantel_fisico
                        FROM t_plan_estudios AS plan
                        INNER JOIN t_instituciones AS inst ON plan.id_institucion = inst.id
                        INNER JOIN t_planteles AS plant ON inst.id_plantel = plant.id 
                        INNER JOIN t_nivel_educativos AS niv ON plan.id_nivel_educativo = niv.id
                        INNER JOIN t_categoria_carreras AS cat ON plan.id_categoria_carrera = cat.id
                        INNER JOIN t_modalidades AS moda ON plan.id_modalidad = moda.id
                        INNER JOIN t_organizacion_planes AS pl ON plan.id_plan = pl.id
            WHERE plan.id = $idPlanestudio LIMIT 1";
            $request = $this->select($sql);
            return $request;
        }
        public function selectClasificacionPlanEstudio($idPlanEstudio){
            $sql = "SELECT x.id,x.estatus,x.id_clasificacion_materias,x.id_plan_estudios,c.nombre_clasificacion_materia,x.total_creditos FROM t_plan_x_clasificacion AS x 
            INNER JOIN t_clasificacion_materias AS c ON x.id_clasificacion_materias = c.id WHERE x.id_plan_estudios = $idPlanEstudio AND x.estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectPlanEstudioEdit($idPlanEstudio){
            $sql = "SELECT *FROM t_plan_estudios WHERE id = $idPlanEstudio";
            $request = $this->select($sql);
            return $request;
        }
        public function deletePlanEdtudio(int $idPlanEstudio){
			$sql = "SELECT * FROM t_plan_estudios WHERE id = $idPlanEstudio";
			$request = $this->select_all($sql);
			if($request){
				$sql = "UPDATE t_plan_estudios SET estatus = ? WHERE id = $idPlanEstudio";
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
			$sqlTablasRef = "SELECT TABLE_NAME AS tablas FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS WHERE REFERENCED_TABLE_NAME = 't_plan_estudios'";
			$requestTablasRef = $this->select_all($sqlTablasRef);
			return $requestTablasRef;
		}
		public function estatusRegistroTabla(string $nombreTabla,int $intIdPlanEstudio){
			$sqlEstatusRegistro = "SELECT * FROM t_plan_estudios
			RIGHT JOIN $nombreTabla ON $nombreTabla.id_plan_estudios = t_plan_estudios.id
			WHERE t_plan_estudios.id = $intIdPlanEstudio AND  $nombreTabla.estatus != 0";
			$requestEstatusRegistro = $this->select_all($sqlEstatusRegistro);
            return $requestEstatusRegistro;
		}
        public function selectColumn(string $nombreTabla){
            $sql = "SHOW COLUMNS FROM $nombreTabla LIKE 'estatus'";
            $request = $this->select($sql);
            return $request;
        }
        public function selectClasificaciones(){
            $sql = "SELECT *FROM t_clasificacion_materias";
            $request = $this->select_all($sql);
            return $request;
        }
    }
?>