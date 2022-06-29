<?php

class BecasModel extends Mysql{

    public $intidBeca;
    public $strnombreBeca;
    public $intporcDescuento;
    public $intidPeriodo;
    public $intidPlanEstudios;
    public $intidUsuarioCreacion;

    public function __construct(){
        parent::__construct();
    }

    public function selectBecas(){
        $sql = "SELECT bc.nombre_beca, bc.porcentaje_descuento, bc.estatus, pr.nombre_periodo, pln.nombre_carrera 
        FROM t_becas as bc
        INNER JOIN t_periodos as pr ON bc.id_periodos = pr.id 
        INNER JOIN t_plan_estudios as pln ON bc.id_plan_estudios = pln.id";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectPeriodo(){
        $sql = "SELECT * FROM t_periodos";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectInstituciones(){
        $sql = "SELECT * FROM t_instituciones";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectNivel(){
        $sql = "SELECT * FROM t_nivel_educativos";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectCarreras(){
        $sql = "SELECT * FROM t_plan_estudios";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectPlanteles(){
        $sql = "SELECT * FROM t_planteles";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectInstitucion(int $idPlantel)
    {
        $idPlt = $idPlantel;
        $sql = "SELECT * FROM t_instituciones WHERE id_planteles = $idPlt";
        $request = $this->select($sql);
        return $request;
    }

    public function selectCarrera(int $idNivel){
        $idNvl = $idNivel;
        $sql = "SELECT * FROM t_plan_estudios WHERE id_nivel_educativos = $idNvl";
        $request = $this->select($sql);
        return $request;
    }

    public function insertBeca(string $nomBeca, int $desc, int $periodo, int $planEstudios)
    {
        $request = "";
        $this->strnombreBeca = $nomBeca;
        $this->intporcDescuento = $desc;
        $this->intidPeriodo = $periodo;
        $this->intidUsuarioCreacion = $_SESSION['idUser'];
        $this->intidPeriodo = $periodo;
        $this->intidPlanEstudios = $planEstudios;
        $sql = "INSERT INTO t_becas(nombre_beca, porcentaje_descuento, estatus, fecha_creacion, id_usuario_creacion, id_periodos, id_plan_estudios) VALUES(?,?,1,NOW(),?,?,?)";
        $arrData = array($this->strnombreBeca, $this->intporcDescuento, $this->intidUsuarioCreacion, $this->intidPeriodo, $this->intidPlanEstudios);
        $request = $this->insert($sql,$arrData);
        $request['estatus'] = FALSE;
        return $request;
    }
}