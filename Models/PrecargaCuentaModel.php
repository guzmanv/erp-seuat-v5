<?php

class PrecargaCuentaModel extends Mysql
{
   
    public $intIdPers;
    public function __construct()
    {
        parent::__construct();
    }
    public function selectPlanteles(){
        $sql = "SELECT *FROM t_instituciones WHERE estatus = 1";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectPlanEstudios(){
        $sql = "SELECT pe.id,ti.nombre_institucion,pe.nombre_carrera,ti.id AS id_plantel,ne.nombre_nivel_educativo 
                FROM t_plan_estudios AS pe
                INNER JOIN t_instituciones AS ti ON pe.id_institucion = ti.id
                INNER JOIN t_nivel_educativos AS ne ON pe.id_nivel_educativo = ne.id
                WHERE  pe.estatus = 1";
        $request = $this->select_all($sql);
        return $request;
    }
    public function selectPlanEstudiosByNivel(int $idNivel){
        $sql = "SELECT pe.id,ti.nombre_institucion,pe.nombre_carrera,ti.id AS id_plantel,pe.id_nivel_educativo,ne.nombre_nivel_educativo
                FROM t_plan_estudios AS pe
                INNER JOIN t_instituciones AS ti ON pe.id_institucion = ti.id
                INNER JOIN t_nivel_educativos AS ne ON pe.id_nivel_educativo = ne.id
                WHERE  pe.estatus = 1 AND pe.id_nivel_educativo = $idNivel";
        $request = $this->select_all($sql);
        return $request;
    }
    public function selectPlanEstudiosByPlantel(int $idPlantel){
        $sql = "SELECT pe.id,ti.nombre_institucion,pe.nombre_carrera,ti.id AS id_plantel,ne.nombre_nivel_educativo
                FROM t_plan_estudios AS pe
                INNER JOIN t_instituciones AS ti ON pe.id_institucion = ti.id
                INNER JOIN t_nivel_educativos AS ne ON pe.id_nivel_educativo = ne.id
                WHERE  pe.estatus = 1 AND pe.id_institucion = $idPlantel";
        $request = $this->select_all($sql);
        return $request;
    }
    public function selectPlanEstudiosByPlantelNivel(int $idPlantel, int $idNivel){
        $sql = "SELECT pe.id,ti.nombre_institucion,pe.nombre_carrera,ti.id AS id_plantel,ne.nombre_nivel_educativo
                FROM t_plan_estudios AS pe
                INNER JOIN t_instituciones AS ti ON pe.id_institucion = ti.id
                INNER JOIN t_nivel_educativos AS ne ON pe.id_nivel_educativo = ne.id
                WHERE  pe.estatus = 1 AND pe.id_institucion = $idPlantel AND pe.id_nivel_educativo = $idNivel";
        $request = $this->select_all($sql);
        return $request;
    }
    public function selectServicios(int $idPlantel){
        $sql = "SELECT s.id,s.nombre_servicio,s.codigo_servicio,s.precio_unitario,cs.nombre_categoria FROM t_servicios AS s
        INNER JOIN t_categoria_servicios AS cs ON s.id_categoria_servicio = cs.id WHERE s.aplica_edo_cuenta = 1 AND s.id_plantel = $idPlantel";
        $request = $this->select_all($sql);
        return $request;
    }
    public function seletNiveles(){
        $sql = "SELECT *FROM t_nivel_educativos";
        $request = $this->select_all($sql);
        return $request;
    }
    public function selectNivelesByPlantel(int $idPlantel){
        $sql = "SELECT ne.id,ne.nombre_nivel_educativo FROM t_plan_estudios AS pe 
        INNER JOIN t_planteles AS p ON pe.id_plantel = p.id
        INNER JOIN t_nivel_educativos AS ne ON pe.id_nivel_educativo = ne.id
        WHERE pe.id_plantel = $idPlantel AND pe.estatus = 1
        GROUP BY pe.id_nivel_educativo";
        $request = $this->select_all($sql);
        return $request;
    }
    public function selectPeriodos(){
        $sql = "SELECT *FROM t_periodos";
        $request = $this->select_all($sql);
        return $request;
    }
    public function selectGrados(){
        $sql = "SELECT *FROM t_grados";
        $request = $this->select_all($sql);
        return $request;
    }
    //original
    // public function insertPrecargaCuenta(int $idPlantel,int $idPlanEstudios,int $idNivel,int $idPeriodo,int $idGrado,int $idServicio,$precioNuevo,$fechaLimitePago,$idUser, string $nomConexion){
    //     $this->strNomConexion = $nomConexion;
    //     $this->intCobroTotsal = $precioNuevo;
    //     // $sql = "INSERT INTO t_precarga(cobro_total,fecha_limite_cobro,estatus,id_usuario_creacion,fecha_creacion,id_servicio,id_plan_estudios,id_periodo,id_grado) VALUES(?,?,?,?,NOW(),?,?,?,?)";
    //     // $request = $this->insert($sql,$this->strNomConexion,array($precioNuevo,$fechaLimitePago,1,$idUser,$idServicio,$idPlanEstudios,$idPeriodo,$idGrado));
    //     $sql = "SELECT * FROM t_precarga WHERE cobro_total = '$this->intCobroTotsal' AND fecha_limite_cobro = '$fechaLimitePago' AND id_plan_estudios = '$idPlanEstudios' AND id_periodo = '$idPeriodo' AND id_grado = '$idGrado'";
    //         $request = $this->select_all($sql,$this->strNomConexion);
    //     if(empty($request)){
    //         $sql = "INSERT INTO t_precarga(cobro_total,fecha_limite_cobro,estatus,id_usuario_creacion,fecha_creacion,id_servicio,id_plan_estudios,id_periodo,id_grado) VALUES(?,?,?,?,NOW(),?,?,?,?)";
    //         $request = $this->insert($sql,$this->strNomConexion,array($this->intCobroTotsal,$fechaLimitePago,1,$idUser,$idServicio,$idPlanEstudios,$idPeriodo,$idGrado));
    
    //         $return = $request;
    //     }else{
    //         $return = "exist";
    //     }
    //     return $return;
    // }

    public function insertPrecargaCuenta(int $idPlantel,int $idPlanEstudios,int $idNivel,int $idPeriodo,int $idGrado,int $idServicio,$precioNuevo,$fechaLimitePago,$idUser){
        $this->intCobroTotsal = $precioNuevo;
        // $sql = "INSERT INTO t_precarga(cobro_total,fecha_limite_cobro,estatus,id_usuario_creacion,fecha_creacion,id_servicio,id_plan_estudios,id_periodo,id_grado) VALUES(?,?,?,?,NOW(),?,?,?,?)";
        // $request = $this->insert($sql,$this->strNomConexion,array($precioNuevo,$fechaLimitePago,1,$idUser,$idServicio,$idPlanEstudios,$idPeriodo,$idGrado));
        $sql = "SELECT tPre.id, tPre.cobro_total, tPre.fecha_limite_cobro, tPlant.nombre_plantel, tNi.nombre_nivel_educativo, 
                        tPla.nombre_carrera, tpe.nombre_periodo, tGra.nombre_grado, tSe.nombre_servicio
                FROM t_precarga AS tPre
                INNER JOIN t_servicios AS tSe ON tPre.id_servicio = tSe.id
                INNER  JOIN t_plan_estudios AS tPla ON tPre.id_plan_estudios = tPla.id 
                INNER JOIN t_periodos AS tpe ON tPre.id_periodo = tpe.id
                INNER JOIN t_grados AS tGra ON tPre.id_grado = tGra.id 
                INNER JOIN t_planteles AS tPlant ON tPla.id_plantel = tPlant.id
                INNER JOIN t_nivel_educativos AS tNi ON tPla.id_nivel_educativo = tNi.id
                WHERE tPre.cobro_total = '$this->intCobroTotsal' AND tPre.fecha_limite_cobro = '$fechaLimitePago' AND tPla.id_plantel = '$idPlantel' AND tPla.id_nivel_educativo = '$idNivel'
                AND tPre.id_plan_estudios = '$idPlanEstudios' AND tPre.id_periodo = '$idPeriodo' 
                AND tPre.id_grado = '$idGrado'";
            $request = $this->select_all($sql);
        if(empty($request)){
            $sql = "INSERT INTO t_precarga(cobro_total,fecha_limite_cobro,estatus,id_usuario_creacion,fecha_creacion,id_servicio,id_plan_estudios,id_periodo,id_grado) VALUES(?,?,?,?,NOW(),?,?,?,?)";
            $request = $this->insert($sql,array($this->intCobroTotsal,$fechaLimitePago,1,$idUser,$idServicio,$idPlanEstudios,$idPeriodo,$idGrado));
    
            $return = $request;
        }else{
            $return = "exist";
        }
        return $return;
    }

    // public function insertPrecargaCuenta(int $idPlantel,int $idPlanEstudios,int $idNivel,int $idPeriodo,int $idGrado,int $idServicio,$precioNuevo,$fechaLimitePago,$idUser, string $nomConexion){
    //     $this->strNomConexion = $nomConexion;
    //     $sql = "INSERT INTO t_precarga(cobro_total,fecha_limite_cobro,estatus,id_usuario_creacion,fecha_creacion,id_servicio,id_plan_estudios,id_periodo,id_grado) VALUES(?,?,?,?,NOW(),?,?,?,?)";
    //     $request = $this->insert($sql,$this->strNomConexion,array($precioNuevo,$fechaLimitePago,1,$idUser,$idServicio,$idPlanEstudios,$idPeriodo,$idGrado));
    //     return $request;
    // }

    public function selectServiciosByInput($value){
        $sql = "SELECT *FROM t_servicios WHERE nombre_servicio LIKE '%$value%'";
        $request = $this->select_all($sql);
        return $request;
    }

    //EXTRAER PRECARGAS
    public function selectPrecargas()
    {
        $sql = "SELECT tPre.id AS idPre, tPre.cobro_total AS cTotal, tPre.fecha_limite_cobro AS limCobro, tSe.nombre_servicio AS nomSer, 
                tPla.nombre_carrera AS nomCarre, tPe.nombre_periodo AS nomPer, tGra.nombre_grado AS nomGra, tPre.estatus AS est
                FROM t_precarga AS tPre
                INNER JOIN t_servicios AS tSe ON tPre.id_servicio = tSe.id
                INNER JOIN t_plan_estudios AS tPla ON tPre.id_plan_estudios = tPla.id
                INNER JOIN t_periodos AS tPe ON tPre.id_periodo = tPe.id
                INNER JOIN t_grados AS tGra ON tPre.id_grado = tGra.id
                WHERE tPre.estatus !=0
                ";
        $request = $this->select_all($sql);
        return $request;
    }

    //PARA EDITAR
    public function selectPrecargaCuenta (int $intIdPrecarga)
    {
        //BUSCAR SALONES COMPUESTOS
        $this->intIdPrecarga = $intIdPrecarga;
        $sql = "SELECT * FROM t_precarga WHERE id = $this->intIdPrecarga";
        $request = $this->select($sql);
        return $request;
    }

    //PARA ACTUALIZAR PRECARGA
    public function updatePrecargaCuentas(int $id, string $cobro_total, string $fecha_limite_cobro, int $estatus, string $fecha_modificacion, 
                                            int $id_usuario_modificacion)
    {
        $this->intIdPrecargaCuenta = $id;
        $this->intNuevoPrecio = $cobro_total;
        $this->strFechaLimCobro = $fecha_limite_cobro;
        $this->intEstatus = $estatus;
        /* $this->strFecha_Actualizacion = $fecha_modificacion; */
        $this->intId_Usuario_Actualizacion = $id_usuario_modificacion;

        $sql = "SELECT * FROM t_precarga WHERE cobro_total = '$this->intNuevoPrecio' AND id != $this->intIdPrecargaCuenta";
        $request = $this->select_all($sql);

        if(empty($request))
        {
            $sql = "UPDATE t_precarga SET cobro_total = ?, fecha_limite_cobro = ?, estatus = ?, fecha_modificacion = NOW(), id_usuario_modificacion = ? WHERE id = $this->intIdPrecargaCuenta ";
            $arrData = array($this->intNuevoPrecio, $this->strFechaLimCobro, $this->intEstatus, $this->intId_Usuario_Actualizacion);
            $request = $this->update($sql,$arrData);
        }else{
            $request = "exist";
        }
        return $request;
    }

    //MODELO PARA ELIMINAR PRECARGA CUENTA
    public function deletePrecargaCuenta(int $idPre){
        $this->intIdPrecargaCuenta = $idPre;
        $sql = "SELECT * FROM t_estado_cuenta WHERE id_precarga = $this->intIdPrecargaCuenta";
        $request = $this->select_all($sql);
        if(empty($request))
        {
            $sql = "UPDATE t_precarga SET estatus = ? WHERE id = $this->intIdPrecargaCuenta";
            $arrData =array(0);
            $request = $this->update($sql,$arrData);
            if($request)
            {
                $request = 'ok';
            }else{
                $request  = 'error';
            }
        }else{
            $request = 'exist';
        }
        return $request;
    }

}
