<?php
	class ReinscripcionModel extends Mysql
	{
		public function __construct()
		{
			parent::__construct();
		}

        //Obtener datos persona
        public function selectPersonasModal($data){
            $sql = "SELECT per.id,per.nombre_persona,per.ap_paterno,per.ap_materno,
            ins.id AS id_inscripcion,pln.nombre_carrera,ins.id_grados,tgr.numero_natural AS grado,ins.id_salones_compuesto,gr.nombre_grupo FROM t_personas AS per
            LEFT JOIN t_inscripciones AS ins ON ins.id_personas = per.id
            LEFT JOIN t_historiales AS his ON ins.id_historial = his.id
            INNER JOIN t_plan_estudios AS pln ON ins.id_plan_estudios = pln.id
            INNER JOIN t_salones_compuesto AS sal ON ins.id_salones_compuesto = sal.id
            INNER JOIN t_grupos AS gr ON sal.id_grupos = gr.id
            INNER JOIN t_grados AS tgr ON ins.id_grados = tgr.id
            WHERE CONCAT(per.nombre_persona,' ',per.ap_paterno,' ',per.ap_materno) LIKE '%$data%'";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectDatosAlumno(int $idAlumno){
            $sql = "SELECT p.id,p.nombre_persona,p.ap_paterno,p.ap_materno,
            i.id AS id_inscripcion,i.id_plan_estudios,pe.nombre_carrera,pe.id_instituciones,ti.id_planteles,pln.nombre_plantel_fisico,i.id_grados,i.id_salones_compuesto,
            sc.id_salones,sc.id_periodos,per.nombre_periodo,per.id_ciclos,c.nombre_ciclo,c.id_generaciones,g.nombre_generacion,p.estatus,
            tg.numero_natural,tgr.nombre_grupo FROM t_personas AS p
            INNER JOIN t_inscripciones AS i ON i.id_personas = p.id
            INNER JOIN t_plan_estudios AS pe ON i.id_plan_estudios = pe.id
            INNER JOIN t_instituciones AS ti ON pe.id_instituciones = ti.id
            INNER JOIN t_planteles AS pln ON ti.id_planteles = pln.id
            INNER JOIN t_salones_compuesto AS sc ON i.id_salones_compuesto = sc.id
            INNER JOIN t_periodos AS per ON sc.id_periodos = per.id
            INNER JOIN t_ciclos AS c ON per.id_ciclos = c.id
            INNER JOIN t_grados AS tg ON sc.id_grados = tg.id
            INNER JOIN t_grupos AS tgr ON sc.id_grupos = tgr.id
            INNER JOIN t_generaciones AS g ON c.id_generaciones = g.id
            WHERE p.id =$idAlumno";
            $request = $this->select($sql);
            return $request;
        }

        public function selectCiclos(){
            $sql = "SELECT *FROM t_ciclos WHERE estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectPeriodo(){
            $sql = "SELECT *FROM t_periodos WHERE estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectGrado(){
            $sql = "SELECT *FROM t_grados WHERE estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectGrupo(){
            $sql = "SELECT *FROM t_grupos WHERE estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }
        
        public function insertReinscripcion()
        {
            $sql = "INSERT INTO t_inscripciones(folio_impreso,folio_sistema,tipo_ingreso,promedio,estatus,fecha_creacion,id_usuario_creacion,id_turnos,id_plan_estudios,id_personas,id_tutores,id_documentos,id_subcampanias,id_salones_compuesto,id_historial,id_grados) VALUES(?,?,?,?,?,NOW(),?,?,?,?,?,?,?,?,?,?)";
            $request = $this->update($sql,array("TGZ202200003","TGZ202200003","Reinscripcion",1,1,2,1,1,30,75,4,1,3,45,1));
            return $request;
        }
	}
?>