<?php
    class MateriasModel extends Mysql{
        public function __construct(){
            parent::__construct();
        }
        public function selectMaterias(){
            $sql = "SELECT mat.id,mat.nombre_materia,pe.nombre_carrera,mat.id_grados,mat.tipo,
            mat.estatus,gr.numero_romano,mat.id_clasificacion_materias,clma.nombre_clasificacion_materia FROM t_materias AS mat
            INNER JOIN t_plan_estudios AS pe ON mat.id_plan_estudios = pe.id
            INNER JOIN t_grados AS gr ON mat.id_grados = gr.id
            INNER JOIN t_clasificacion_materias AS clma ON mat.id_clasificacion_materias = clma.id
            WHERE mat.estatus !=0 ORDER BY mat.id DESC";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectGrados(){
            $sql = "SELECT *FROM t_grados";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectPlanEstudios(){
            $sql = "SELECT *FROM t_plan_estudios WHERE estatus = 1 ORDER BY nombre_carrera ASC";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectPlanEstudiosByInstitucion(int $idInstitucion){
            $sql = "SELECT *FROM t_plan_estudios WHERE id_instituciones = $idInstitucion AND estatus = 1 ORDER BY nombre_carrera ASC";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectPlanEstudiosNuevo($id){
            $sql = "SELECT *FROM t_plan_estudios WHERE id_instituciones = $id AND estatus = 1 ORDER BY nombre_carrera ASC";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectPlanteles(){
            $sql = "SELECT *FROM t_planteles WHERE estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectInstituciones()
        {
            $sql ="SELECT inst.id,inst.nombre_institucion,plant.nombre_plantel_fisico FROM t_instituciones AS inst
            INNER JOIN t_planteles AS plant ON inst.id_planteles = plant.id
            WHERE inst.estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectClasificacion(){
            $sql = "SELECT *FROM t_clasificacion_materias";
            $request = $this->select_all($sql);
            return $request;
        }
        public function insertMateria($data){
            $idUser = $_SESSION['idUser'];
            $nombreMateria = $data['txtNombreNuevo'];
            $clave = $data['txtClaveNuevo'];
            $horasTeoria = $data['txtHorasTeoriaNuevo'];
            $horasPracticas = $data['txtHorasPracticaNuevo'];
            $creditos = $data['txtCreditosNuevo'];
            $tipo = $data['listTipoNuevo'];
            $grado = $data['listGradoNuevo'];
            $planEstudio = $data['listPlanEstudioNuevo'];
            $clasificacion = $data['listClasificacionNuevo'];
            //$estatus = $data['listEstatusNuevo'];
            $request = [];
            if ($tipo == '1') {
                $tipo = "Basica";
            }else{    
                $tipo = "Ordinaria";
            }
            $request = [];
            $sqlExist = "SELECT *FROM t_materias WHERE nombre_materia = '$nombreMateria' OR clave = '$clave'";
            $requestExist = $this->select($sqlExist);
            if($requestExist){
                $request['estatus'] = TRUE;
            }else{
                $sqlNew = "INSERT INTO t_materias(clave,nombre_materia,hrs_teoria,hrs_practicas,creditos,tipo,id_grados,id_plan_estudios,
                    id_clasificacion_materias,estatus,fecha_creacion,fecha_actualizacion,id_usuario_creacion,id_usuario_actualizacion) 
                    VALUES (?,?,?,?,?,?,?,?,?,?,NOW(),NOW(),?,?)";
                $requestNew = $this->insert($sqlNew,array($clave,$nombreMateria,$horasTeoria,$horasPracticas,$creditos,$tipo,$grado,$planEstudio,
                        $clasificacion,1,$idUser,$idUser));
                $request['estatus'] = FALSE;
            }
            return $request;
        }

        public function selectMateria(int $idMateria){
            $sql = "SELECT mat.id,mat.clave,mat.nombre_materia,mat.hrs_teoria,mat.hrs_practicas,mat.creditos,mat.tipo,pe.id AS id_plan,pe.nombre_carrera,
            mat.id_grados,mat.tipo,
                        mat.id_clasificacion_materias,mat.estatus,gr.id AS id_grado,gr.nombre_grado,gr.numero_romano,inst.id AS idplantel,inst.nombre_institucion,plant.nombre_plantel_fisico,inst.id AS idInstitucion FROM t_materias AS mat
                        INNER JOIN t_plan_estudios AS pe ON mat.id_plan_estudios = pe.id
                        INNER JOIN t_instituciones AS inst ON pe.id_instituciones = inst.id
                        INNER JOIN t_planteles AS plant ON inst.id_planteles = plant.id
                        INNER JOIN t_grados AS gr ON mat.id_grados = gr.id WHERE mat.id = $idMateria";
            $request = $this->select($sql);
            return $request;
        }

        public function updateMateria(int $intIdMateriaEdit,$data){
            $idUser = $_SESSION['idUser'];
            $idMateria = $intIdMateriaEdit;
            $nombreMateria = $data['txtNombreEdit'];
            $clave = $data['txtClaveEdit'];
            $horasTeoria = $data['txtHorasTeoriaEdit'];
            $horasPracticas = $data['txtHorasPracticaEdit'];
            $creditos = $data['txtCreditosEdit'];
            $tipo = $data['listTipoEdit'];
            $grado = $data['listGradoEdit'];
            $planEstudio = $data['listPlanEstudioEdit'];
            $clasificacion = $data['listClasificacionEdit'];
            $estatus = $data['listEstatusEdit'];
            if ($tipo == '1') {
                $tipo = "Basica";
            }else{    
                $tipo = "Ordinaria";
            }
            $sql = "UPDATE t_materias SET clave = ? ,nombre_materia = ? ,hrs_teoria = ?,hrs_practicas = ?,creditos = ?,tipo = ?,id_grados = ?,
            id_plan_estudios = ? ,id_clasificacion_materias = ? ,estatus = ?,
            fecha_actualizacion = NOW() ,id_usuario_creacion = ? ,id_usuario_actualizacion = ? WHERE id = $intIdMateriaEdit"; 
            $request = $this->update($sql,array($clave,$nombreMateria,$horasTeoria,$horasPracticas,$creditos,$tipo,$grado,$planEstudio,
                        $clasificacion,$estatus,$idUser,$idUser));
            return $request;
        }

        public function deleteMateria(int $intIdMateria){
            $sql = "SELECT * FROM t_materias WHERE id = $intIdMateria";
			$request = $this->select_all($sql);
			if($request){
				$sql = "UPDATE t_materias SET estatus = ? WHERE id = $intIdMateria";
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
        public function selectPlanEstudio(int $plnEstudio){
            $sql = "SELECT *FROM t_plan_estudios WHERE id = $plnEstudio";
            $request = $this->select($sql);
            return $request;
        }
        /////////////////
        public function selectClasificacionPlanEstudio(int $idPlanEstudio){
            $sql = "SELECT x.id,x.estatus,x.id_clasificacion_materias,x.id_plan_estudios,c.nombre_clasificacion_materia,x.total_creditos FROM t_plan_x_clasificacion AS x 
            INNER JOIN t_clasificacion_materias AS c ON x.id_clasificacion_materias = c.id WHERE x.id_plan_estudios = $idPlanEstudio AND x.estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectCreditoClasificacionPlanEstudio(int $idPlanEstudio,int $idClasificacion){
            $sql = "SELECT *FROM t_materias AS m
            WHERE m.id_plan_estudios = $idPlanEstudio AND m.id_clasificacion_materias = $idClasificacion";
            $request = $this->select_all($sql);
            return $request;
        }
    }
?>    