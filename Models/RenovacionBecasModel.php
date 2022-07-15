<?php

class RenovacionBecasModel extends Mysql{

    public function __construct(){
        parent::__construct();
    }

    public function selectReinscritos(){
        $sql = "SELECT ins.id, ins.id_personas, CONCAT(per.nombre_persona, ' ', per.ap_paterno, ' ', per.ap_materno) as nombre_estudiante, pln.nombre_carrera, org.nombre_plan, grd.nombre_grado, ins.promedio 
        FROM t_inscripciones ins 
        INNER JOIN t_personas per On per.id = ins.id_personas
        INNER JOIN t_plan_estudios pln ON pln.id = ins.id_plan_estudios 
        INNER JOIN t_organizacion_planes org ON org.id = pln.id_organizacion_planes 
        INNER JOIN t_grados grd ON grd.id = ins.id_grados
        WHERE ins.tipo_ingreso = 'Reinscripcion'";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectRenovacionInd($idPer)
    {
        $sql="SELECT id_plan_estudios, promedio, id_personas, id_grados FROM t_inscripciones
        WHERE id_personas = $idPer
        ORDER BY id_grados DESC LIMIT 1";
        $request = $this->select($sql);
        return $request;
    }
}