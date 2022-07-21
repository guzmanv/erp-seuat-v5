<?php
	class InscripcionModel extends Mysql
	{
		public function __construct()
		{
			parent::__construct();
		}
        public function selectInscripciones()
        {
            $sql = "SELECT tp.id AS id_plantel,tp.nombre_plantel_fisico,tin.id AS id_institucion,tin.nombre_institucion,
            tg.id AS id_grado,tg.numero_natural,tgr.id AS id_grupo,tgr.nombre_grupo,tpe.nombre_carrera, COUNT(*) AS total FROM t_inscripciones AS ti
            INNER JOIN t_plan_estudios AS tpe ON ti.id_plan_estudios = tpe.id
            INNER JOIN t_instituciones AS tin ON tpe.id_instituciones = tin.id
            INNER JOIN t_planteles AS tp ON tin.id_planteles = tp.id
            INNER JOIN t_salones_compuesto AS tsc ON ti.id_salones_compuesto = tsc.id
            INNER JOIN t_grados AS tg ON tsc.id_grados = tg.id
            INNER JOIN t_grupos AS tgr ON tsc.id_grupos = tgr.id
            WHERE ti.tipo_ingreso = 'Inscripcion' AND ti.estatus = 1
            GROUP BY tp.id,tin.id,tg.id,tgr.id,tpe.id HAVING COUNT(*)>=1";
            $request = $this->select_all($sql);
            return $request;
        }

		//Funcion para consultar lista de Categorias
		public function selectPlanteles(){
			$sql = "SELECT *FROM t_planteles WHERE estatus = 1";
			$request = $this->select_all($sql);
			return $request;
		}
        
        public function selectInstituciones(int $idPlantel)
        {
            $sql = "SELECT *FROM t_instituciones WHERE id_planteles = $idPlantel AND estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectNivelesEducativos()
        {
            $sql = "SELECT *FROM t_nivel_educativos WHERE estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectPreinscritos($idPlantel,$idInstitucion,$idNivelEducativo,$idPlanEstudios)
        {
            if($idPlantel == null && $idInstitucion == null && $idNivelEducativo == null && $idPlanEstudios == null){
                $sql = "SELECT tp.id AS id_plantel,tp.nombre_plantel_fisico,tin.id AS id_institucion,tin.nombre_institucion,tne.id AS 
                id_nivel_educativo,tper.nombre_persona,tper.ap_paterno ,tper.ap_materno,ti.id_personas FROM t_inscripciones AS ti
                INNER JOIN t_plan_estudios AS tpe ON ti.id_plan_estudios = tpe.id
                INNER JOIN t_nivel_educativos AS tne ON tpe.id_nivel_educativos = tne.id
                INNER JOIN t_instituciones AS tin ON tpe.id_instituciones = tin.id
                INNER JOIN t_planteles AS tp ON tin.id_planteles = tp.id
                INNER JOIN t_personas AS tper ON ti.id_personas = tper.id 
                WHERE ti.tipo_ingreso = 'Inscripcion' AND ti.estatus = 1 AND ti.id_salones_compuesto IS NULL";
            }else if($idPlantel != null && $idInstitucion == null && $idNivelEducativo == null && $idPlanEstudios == null){
                $sql = "SELECT tp.id AS id_plantel,tp.nombre_plantel_fisico,tin.id AS id_institucion,tin.nombre_institucion,tne.id AS 
                id_nivel_educativo,tper.nombre_persona,tper.ap_paterno ,tper.ap_materno,ti.id_personas FROM t_inscripciones AS ti
                INNER JOIN t_plan_estudios AS tpe ON ti.id_plan_estudios = tpe.id
                INNER JOIN t_nivel_educativos AS tne ON tpe.id_nivel_educativos = tne.id
                INNER JOIN t_instituciones AS tin ON tpe.id_instituciones = tin.id
                INNER JOIN t_planteles AS tp ON tin.id_planteles = tp.id
                INNER JOIN t_personas AS tper ON ti.id_personas = tper.id 
                WHERE ti.tipo_ingreso = 'Inscripcion' AND ti.estatus = 1 AND ti.id_salones_compuesto IS NULL AND tp.id = $idPlantel";
            }else if($idPlantel != null && $idInstitucion != null && $idNivelEducativo == null && $idPlanEstudios == null){
                $sql = "SELECT tp.id AS id_plantel,tp.nombre_plantel_fisico,tin.id AS id_institucion,tin.nombre_institucion,tne.id AS 
                id_nivel_educativo,tper.nombre_persona,tper.ap_paterno ,tper.ap_materno,ti.id_personas FROM t_inscripciones AS ti
                INNER JOIN t_plan_estudios AS tpe ON ti.id_plan_estudios = tpe.id
                INNER JOIN t_nivel_educativos AS tne ON tpe.id_nivel_educativos = tne.id
                INNER JOIN t_instituciones AS tin ON tpe.id_instituciones = tin.id
                INNER JOIN t_planteles AS tp ON tin.id_planteles = tp.id
                INNER JOIN t_personas AS tper ON ti.id_personas = tper.id 
                WHERE ti.tipo_ingreso = 'Inscripcion' AND ti.estatus = 1 AND ti.id_salones_compuesto IS NULL AND tp.id = $idPlantel AND tin.id = $idInstitucion";
            }else if($idPlantel != null && $idInstitucion != null && $idNivelEducativo != null && $idPlanEstudios == null){
                $sql = "SELECT tp.id AS id_plantel,tp.nombre_plantel_fisico,tin.id AS id_institucion,tin.nombre_institucion,tne.id AS 
                id_nivel_educativo,tper.nombre_persona,tper.ap_paterno ,tper.ap_materno,ti.id_personas FROM t_inscripciones AS ti
                INNER JOIN t_plan_estudios AS tpe ON ti.id_plan_estudios = tpe.id
                INNER JOIN t_nivel_educativos AS tne ON tpe.id_nivel_educativos = tne.id
                INNER JOIN t_instituciones AS tin ON tpe.id_instituciones = tin.id
                INNER JOIN t_planteles AS tp ON tin.id_planteles = tp.id
                INNER JOIN t_personas AS tper ON ti.id_personas = tper.id 
                WHERE ti.tipo_ingreso = 'Inscripcion' AND ti.estatus = 1 AND ti.id_salones_compuesto IS NULL AND tp.id = $idPlantel AND tin.id = $idInstitucion AND tne.id = $idNivelEducativo";
            }else if($idPlantel != null && $idInstitucion != null && $idNivelEducativo != null && $idPlanEstudios != null){
                $sql = "SELECT tp.id AS id_plantel,tp.nombre_plantel_fisico,tin.id AS id_institucion,tin.nombre_institucion,tne.id AS 
                id_nivel_educativo,tper.nombre_persona,tper.ap_paterno ,tper.ap_materno,ti.id_personas FROM t_inscripciones AS ti
                INNER JOIN t_plan_estudios AS tpe ON ti.id_plan_estudios = tpe.id
                INNER JOIN t_nivel_educativos AS tne ON tpe.id_nivel_educativos = tne.id
                INNER JOIN t_instituciones AS tin ON tpe.id_instituciones = tin.id
                INNER JOIN t_planteles AS tp ON tin.id_planteles = tp.id
                INNER JOIN t_personas AS tper ON ti.id_personas = tper.id 
                WHERE ti.tipo_ingreso = 'Inscripcion' AND ti.estatus = 1 AND ti.id_salones_compuesto IS NULL AND tp.id = $idPlantel AND tin.id = $idInstitucion AND tne.id = $idNivelEducativo AND tpe.id = $idPlanEstudios";
            }
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectSalonesCompuestos()
        {
            $sql = "SELECT tsc.id,tsc.nombre_salon_compuesto,tp.nombre_periodo,
            tg.nombre_grado,tgr.nombre_grupo,tt.nombre_turno,ts.nombre_salon FROM t_salones_compuesto AS tsc
            INNER JOIN t_periodos AS tp ON tsc.id_periodos = tp.id
            INNER JOIN t_grados AS tg ON tsc.id_grados = tg.id
            INNER JOIN t_grupos AS tgr ON tsc.id_grupos = tgr.id
            INNER JOIN t_turnos AS tt ON tsc.id_turnos = tt.id
            INNER JOIN t_salones AS ts ON tsc.id_salones = ts.id
            WHERE tsc.estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectSalonCompuesto(int $id)
        {
            $sql = "SELECT tsc.id AS id_salon_compuesto,tsc.id_salones,ts.cantidad_max_estudiantes  FROM t_salones_compuesto AS tsc
            INNER JOIN t_salones AS ts ON tsc.id_salones = ts.id 
            WHERE tsc.id = $id AND tsc.estatus = 1 LIMIT 1";
            $request = $this->select($sql);
            return $request;
        }

        public function insertInscripcion(int $idPersona,int $idSalonCompuesto,int $idUser)
        {
            $sql = "UPDATE t_inscripciones SET id_salones_compuesto = ?,fecha_actualizacion = NOW(),id_usuario_actualizacion = ? WHERE id_personas = $idPersona";
            $request = $this->update($sql,array($idSalonCompuesto,$idUser));
            return $request;
        }

        public function selectEstatusEdoCta(int $idPersona)
        {
            $sql = "SELECT *FROM t_estado_cuenta AS tec 
            WHERE tec.id_personas = $idPersona AND tec.pagado = 1";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectPlanEstudios(int $idPlantel,int $idInstitucion,int $idNivelEducativo)
        {
            $sql = "SELECT tpe.id,tpe.nombre_carrera FROM t_plan_estudios AS tpe 
            INNER JOIN t_instituciones AS ti ON tpe.id_instituciones = ti.id
            INNER JOIN t_planteles AS tp ON ti.id_planteles = tp.id
            INNER JOIN t_nivel_educativos AS tne ON tpe.id_nivel_educativos = tne.id
            WHERE tp.id = $idPlantel AND ti.id = $idInstitucion AND tne.id = $idNivelEducativo AND tpe.estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }
	}
?>