<?php

class RenovacionBecasModel extends Mysql{

    public function __construct(){
        parent::__construct();
    }

    public function selectAlumno($data)
    {
        $sql = "SELECT per.id,CONCAT(COALESCE(per.nombre_persona,''),' ',COALESCE(per.ap_paterno,''),' ',COALESCE(per.ap_materno,'')) AS nombre,
        ins.id AS id_inscripcion
        FROM t_personas AS per
        LEFT JOIN t_inscripciones AS ins ON ins.id_personas = per.id
        WHERE CONCAT(COALESCE(per.nombre_persona,''),' ',COALESCE(per.ap_paterno,''),' ',COALESCE(per.ap_materno,'')) 
        LIKE '%$data%'";
        $request = $this->select($sql);
        return $request;
    }

    public function selectAsignacion()
    {
        $sql = "SELECT insc.id, pln.nombre_carrera_corto as carrera, insc.id_grados, per.nombre_periodo, mdl.nombre_plan, insc.promedio, insc.id_personas 
        FROM t_inscripciones as insc
        INNER JOIN t_plan_estudios as pln ON insc.id_plan_estudios = pln.id
        INNER JOIN t_organizacion_planes as mdl ON mdl.id = pln.id_organizacion_planes
        INNER JOIN t_salones_compuesto as sln ON sln.id = insc.id_salones_compuesto
        INNER JOIN t_periodos as per ON per.id = sln.id_periodos 
        WHERE tipo_ingreso = 'Reinscripcion'";
        $request = $this->select_all($sql);
        return $request;
    }
}