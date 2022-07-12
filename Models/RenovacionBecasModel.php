<?php

class RenovacionBecasModel extends Mysql{

    public function __construct(){
        parent::__construct();
    }

    public function selectAlumno($data)
    {
        $sql = "SELECT per.id, CONCAT(per.nombre_persona,' ', per.ap_paterno,' ', per.ap_materno) as nombre_completo
        FROM t_personas as per
        INNER JOIN t_asignacion_categoria_persona as asig_ct ON asig_ct.id_personas = per.id
        INNER JOIN t_categoria_personas as ct_per ON ct_per.id = asig_ct.id_categoria_persona 
        INNER JOIN t_inscripciones as insc ON insc.id_personas = per.id
        WHERE ct_per.id = 2 AND insc.tipo_ingreso = 'Reinscripcion' AND per.nombre_persona LIKE '$data%'";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectBecados()
    {
        $sql = "SELECT asig.id, CONCAT(per.nombre_persona,' ',per.ap_paterno,' ',per.ap_materno) as nombre_completo,
        pln_est.nombre_carrera, pe.nombre_periodo, grd.nombre_grado, asig.porcentaje_beca, asig.fecha_asignada_beca, asig.estatus
        FROM t_asignacion_becas as asig
        INNER JOIN t_inscripciones as ins ON asig.id_inscripciones = ins.id  
        INNER JOIN t_personas as per ON per.id = ins.id_personas 
        INNER JOIN t_plan_estudios as pln_est ON pln_est.id = ins.id_plan_estudios
        INNER JOIN t_salones_compuesto as sal ON sal.id = ins.id_salones_compuesto 
        INNER JOIN t_periodos as pe ON pe.id = sal.id_periodos 
        INNER JOIN t_grados as grd ON grd.id = sal.id_grados";
        $request = $this->select_all($sql);
        return $request;
    }
}