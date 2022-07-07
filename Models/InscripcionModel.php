<?php
	class InscripcionModel extends Mysql
	{
		public function __construct()
		{
			parent::__construct();
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

        public function selectPreenscritos()
        {
            $sql = "SELECT tp.id AS id_plantel,tp.nombre_plantel_fisico,tin.id AS id_institucion,tin.nombre_institucion,tne.id AS 
            id_nivel_educativo,tper.nombre_persona,tper.ap_paterno ,tper.ap_materno FROM t_inscripciones AS ti
            INNER JOIN t_plan_estudios AS tpe ON ti.id_plan_estudios = tpe.id
            INNER JOIN t_nivel_educativos AS tne ON tpe.id_nivel_educativos = tne.id
            INNER JOIN t_instituciones AS tin ON tpe.id_instituciones = tin.id
            INNER JOIN t_planteles AS tp ON tin.id_planteles = tp.id
            INNER JOIN t_personas AS tper ON ti.id_personas = tper.id 
            WHERE ti.tipo_ingreso = 'Inscripcion' AND ti.estatus = 1 AND ti.id_salones_compuesto IS NULL";
            $request = $this->select_all($sql);
            return $request;
        }
	}
?>