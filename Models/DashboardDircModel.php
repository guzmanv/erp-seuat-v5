<?php
    class DashboardDircModel extends Mysql{
        public function __construct(){
            parent::__construct();
        }

        public function selectPlanteles()
        {
            $sql = "SELECT *FROM t_planteles WHERE estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectTotalInstituciones(int $idPlantel){
            $sqlInstituciones = "SELECT COUNT(*) AS total FROM t_instituciones WHERE id_plantel = $idPlantel AND estatus = 1";
            $requestInstituciones = $this->select($sqlInstituciones);
            return $requestInstituciones;
        }


        public function selectTotalesPlanEstudios(int $idPlantel){
            $sqlPlanEstudios = "SELECT COUNT(*) AS total FROM t_plan_estudios AS pe
            INNER JOIN t_instituciones  AS i ON pe.id_institucion =i.id
            INNER JOIN t_planteles AS p ON i.id_plantel = p.id
            WHERE pe.estatus = 1 AND p.id = $idPlantel";
            $requestPlanEstudios = $this->select($sqlPlanEstudios);
            return $requestPlanEstudios;
        }
        public function selectTotalesMaterias(int $idPlantel){
            $sqlMaterias = "SELECT COUNT(*) AS total FROM t_materias AS m 
            INNER JOIN t_plan_estudios AS pe ON m.id_plan_estudios = pe.id 
            INNER JOIN t_instituciones AS i ON pe.id_institucion = i.id 
            INNER JOIN t_planteles AS p ON i.id_plantel = p.id 
            WHERE m.estatus = 1 AND p.id = $idPlantel";
            $requestMaterias = $this->select($sqlMaterias);
            return $requestMaterias;
        }
        public function selectTotalesRVOES(int $idPlantel){
            $sqlRVOES = "SELECT COUNT(*) AS total FROM t_plan_estudios AS pe
            INNER JOIN t_instituciones AS i ON pe.id_institucion = i.id
            INNER JOIN t_planteles AS p ON i.id_plantel = p.id 
            WHERE DATEDIFF(pe.fecha_actualizacion_rvoe,CURRENT_DATE) <= 365 AND pe.estatus = 1 AND p.id = $idPlantel";
            $requestRVOES = $this->select($sqlRVOES);
            return $requestRVOES;
        }
/*         public function selectTotalesCard($nomConexion){
            if($nomConexion == "all"){
               $sqlPlanteles = "SELECT COUNT(*) AS total FROM t_db";
                $requestPlanteles = $this->select($sqlPlanteles,'bd_usr');
                $sqlPlanEstudios = "SELECT COUNT(*) AS total FROM t_plan_estudios WHERE estatus = 1";
                $requestPlanEstudios = $this->select($sqlPlanEstudios,$nom);
                $sqlMaterias = "SELECT COUNT(*) AS total FROM t_materias WHERE estatus = 1";
                $requestMaterias = $this->select($sqlMaterias);
                $sqlRVOES = "SELECT COUNT(*) AS total FROM t_plan_estudios WHERE DATEDIFF(fecha_actualizacion_rvoe,CURRENT_DATE) <= 365 AND estatus = 1";
                $requestRVOES = $this->select($sqlRVOES);
                $request['planteles'] = $requestPlanteles['total'];
                $request['plan_estudios'] = $requestPlanEstudios['total'];
                $request['materias'] = $requestMaterias['total'];
                $request['rvoes'] = $requestRVOES['total'];
                $request['tipo'] = "all";
            }else{
                $sqlPlanEstudios = "SELECT COUNT(*) AS total FROM t_plan_estudios WHERE estatus = 1 AND id_plantel = $plantel";
                $requestPlanEstudios = $this->select($sqlPlanEstudios);
                $sqlMaterias = "SELECT COUNT(*) AS total FROM t_materias AS mat 
                INNER JOIN t_plan_estudios AS pln ON mat.id_plan_estudios = pln.id WHERE mat.estatus = 1 AND pln.id_plantel = $plantel";
                $requestMaterias = $this->select($sqlMaterias);
                $sqlRVOES = "SELECT COUNT(*) AS total FROM t_plan_estudios WHERE DATEDIFF(fecha_actualizacion_rvoe,CURRENT_DATE) <= 365 AND id_plantel = $plantel AND estatus = 1";
                $requestRVOES = $this->select($sqlRVOES);
                $request['plan_estudios'] = $requestPlanEstudios['total'];
                $request['materias'] = $requestMaterias['total'];
                $request['rvoes'] = $requestRVOES['total'];
                $request['tipo'] = "";
            }
            return $requestPlanteles;
        }
 */


        public function selectRvoesExpirar($idPlantel,$idInstitucion){
            if($idInstitucion == "all"){
                $sqlRVOES = "SELECT pl.id,pl.nombre_carrera,pl.nombre_carrera_corto,inst.abreviacion_institucion,plant.municipio,pl.rvoe,pl.fecha_actualizacion_rvoe FROM t_plan_estudios AS pl 
                INNER JOIN t_instituciones AS inst ON pl.id_institucion = inst.id 
                INNER JOIN t_planteles AS plant ON inst.id_plantel = plant.id
                WHERE DATEDIFF(pl.fecha_actualizacion_rvoe,CURRENT_DATE) <= 365 AND pl.estatus = 1 AND plant.id = $idPlantel";
                $requestRVOES = $this->select_all($sqlRVOES);
            }else{
                $sqlRVOES = "SELECT pl.id,pl.nombre_carrera,pl.nombre_carrera_corto,inst.abreviacion_institucion,plant.municipio,pl.rvoe,pl.fecha_actualizacion_rvoe FROM t_plan_estudios AS pl 
                INNER JOIN t_instituciones AS inst ON pl.id_institucion = inst.id
                INNER JOIN t_planteles AS plant ON inst.id_plantel = plant.id
                WHERE DATEDIFF(fecha_actualizacion_rvoe,CURRENT_DATE) <= 365 AND pl.id_institucion = $idInstitucion  AND plant.id = $idPlantel AND pl.estatus = 1";
                $requestRVOES = $this->select_all($sqlRVOES);
            }
            return $requestRVOES;
        }

        //  Lista de Superplanteles
        public function selectSuperplanteles(string $nomConexion){
            $sql = "SELECT id,nombre_conexion,nombre_plantel FROM t_db";
            $request = $this->select_all($sql, $nomConexion);
            return $request;
        }


        public function selectPlanEstudiosbyInstitucion($idPlantel,$idInstitucion){
            $sql = "SELECT COUNT(*) AS total FROM t_plan_estudios AS pe
            INNER JOIN t_instituciones  AS i ON pe.id_institucion =i.id
            INNER JOIN t_planteles AS p ON i.id_plantel = p.id
            WHERE pe.estatus = 1 AND p.id = $idPlantel AND i.id = $idInstitucion";
            $request = $this->select($sql);
            return $request;
        }
        public function selectMateriasbyInstitucion($idPlantel, $idInstitucion){
            $sql = "SELECT COUNT(*) AS total FROM t_materias AS mat
            INNER JOIN t_plan_estudios AS ples ON mat.id_plan_estudios = ples.id
            INNER JOIN t_instituciones AS ins ON ples.id_institucion = ins.id 
            INNER JOIN t_planteles AS pl ON ins.id_plantel = pl.id 
            WHERE pl.id = $idPlantel AND ins.id = $idInstitucion AND mat.estatus = 1";
            $request = $this->select($sql);
            return $request;
        }
        public function selectRVOEproximoExpbyInstitucion($idPlantel, $idInstitucion){
            $sql = "SELECT pl.id,pl.nombre_carrera,pl.nombre_carrera_corto,se.abreviacion_sistema,
            ins.abreviacion_institucion,p.municipio,pl.rvoe,pl.fecha_actualizacion_rvoe 
            FROM t_plan_estudios AS pl 
            INNER JOIN t_instituciones AS ins ON pl.id_institucion  = ins .id 
            INNER JOIN t_planteles AS p ON ins.id_plantel = p.id 
            INNER JOIN t_sistemas_educativos AS se ON ins.id_sistema = se.id
            WHERE DATEDIFF(pl.fecha_actualizacion_rvoe,CURRENT_DATE) <= 365 
            AND ins.id_plantel = $idPlantel AND ins.id = $idInstitucion AND pl.estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectDatosInstitucion($idPlantel){
            $sql = "SELECT *FROM t_instituciones WHERE id_plantel = $idPlantel";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectPlantel(int $idPlantel){
            $sql = "SELECT *FROM t_planteles WHERE id = $idPlantel";
            $request = $this->select($sql);
            return $request;
        }
        public function selectInstitucion(int $idInstitucion){
            $sql = "SELECT *FROM t_instituciones WHERE id = $idInstitucion";
            $request = $this->select($sql);
            return $request;
        }
        public function selectInstitucionesByPlantel($idPlantel)
        {
            $sql = "SELECT *FROM t_instituciones WHERE estatus = 1 AND id_plantel = $idPlantel";
            $request = $this->select_all($sql);
            return $request;
        }
    }
?>    