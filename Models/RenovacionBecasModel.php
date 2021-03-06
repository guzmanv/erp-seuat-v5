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

    public function selectAlumnoAsignacion($idIns)
    {
        $sql = "SELECT ins.id, slnco.id_periodos, pln.id as id_plan_estudios, pln.nombre_carrera, grd.nombre_grado, CONCAT(per.nombre_persona,' ',per.ap_paterno,' ', per.ap_materno) AS nombre_estudiante, 
        per.direccion as direccion_estudiante, per.tel_fijo, per.tel_celular, CONCAT(tut.nombre_tutor,' ', tut.appat_tutor,' ', tut.apmat_tutor) as nombre_tutor, tut.direccion as direccion_tutor, ins.id_tutores, ins.promedio
        FROM t_inscripciones ins
        INNER JOIN t_personas per ON per.id = ins.id_personas
        INNER JOIN t_plan_estudios pln ON pln.id = ins.id_plan_estudios
        INNER JOIN t_salones_compuesto slnco ON slnco.id = ins.id_salones_compuesto 
        INNER JOIN t_grados grd ON grd.id = ins.id_grados
        INNER JOIN t_tutores tut ON tut.id = ins.id_tutores 
        WHERE ins.id = $idIns";
        $request = $this->select($sql);
        return $request;
    }

    public function selectAsignacion()
    {
        $sql = "SELECT asg.id, CONCAT(per.nombre_persona,' ',per.ap_paterno,' ',per.ap_materno) as nombre_estudiante, pln.nombre_carrera, asg.porcentaje_beca, asg.fecha_asignada_beca 
        FROM t_asignacion_becas asg
        INNER JOIN t_inscripciones ins ON asg.id_inscripciones = ins.id
        INNER JOIN t_personas per ON ins.id_personas = per.id
        INNER JOIN t_plan_estudios pln ON pln.id = ins.id_plan_estudios";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectBecaAsignar()
    {
        $sql = "SELECT id, nombre_beca, promedio, porcentaje_descuento, id_periodos, id_plan_estudios, id_grados from t_becas";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectMontos(int $idPlan, int $idPeriodo){
        $sql = "SELECT pr.id as id_precarga, pr.id_servicios, pr.cobro_total, sr.nombre_servicio, pr.id_periodos, id_plan_estudios
        FROM t_precarga as pr 
        INNER JOIN t_servicios as sr on pr.id_servicios = sr.id
        INNER JOIN t_categoria_servicios as ct_sr on sr.id_categoria_servicios = ct_sr.id 
        WHERE ct_sr.clave_categoria = 'COL' AND id_plan_estudios = $idPlan AND id_periodos = $idPeriodo";
        $request = $this->select_all($sql);
        return $request;
    }
}