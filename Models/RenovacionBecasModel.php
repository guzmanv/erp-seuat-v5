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
}