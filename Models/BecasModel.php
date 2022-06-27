<?php

class BecasModel extends Mysql{

    public $idBeca;
    public $nombreBeca;
    public $porcDescuento;

    public function __construct(){
        parent::__construct();
    }

    public function selectBecas(){
        $sql = "SELECT * FROM t_becas";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectPeriodo(){
        $sql = "SELECT * FROM t_periodos";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectCarrera(){
        $sql = "SELECT * FROM t_plan_estudios";
        $request = $this->select_all($sql);
        return $request;
    }
}