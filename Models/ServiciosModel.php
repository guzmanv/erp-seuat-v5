<?php
class ServiciosModel extends Mysql{
    public $intIdServicio;
    public $strCodigo_servicio;
    public $strNombre_servicio;
    public $intPrecio_unitario;
    public $intAplica_edo_cuenta;
    public $strAnio_fiscal;
    public $intEstatus;
    public $strFecha_creacion;
    public $strFecha_actualizacion;
    public $intId_usuario_creacion;
    public $intId_usuario_actualizacion;
    public $intIdInstitucion;
    public $intIdCategoria_servicio;
    public $intIdUnidades_medida;
 
	public function __construct(){
		parent::__construct();
	}
    public function selectServicios(){
        //Extraer todas los servicios
        // $sql = "SELECT ts.id AS IdServicios, ts.codigo_servicio AS CodigoServicio, ts.nombre_servicio AS NombreServicio, ts.precio_unitario AS PrecioUnitario, ts.aplica_edo_cuenta AS AplicaEdoCuenta, ts.estatus AS EstatusServicios, tp.abreviacion_plantel AS Plantel, tp.municipio AS Municipio FROM t_servicios ts INNER JOIN t_planteles tp ON ts.id_plantel = tp.id INNER JOIN t_categoria_servicios tcs ON ts.id_categoria_servicio = tcs.id  INNER JOIN t_unidades_medida tum ON ts.id_unidades_medida = tum.id WHERE ts.estatus !=0 ORDER BY ts.id DESC ";
        // $sql = "SELECT ts.id AS IdServicios, ts.codigo_servicio AS CodigoServicio, ts.nombre_servicio AS NombreServicio, 
        // ts.precio_unitario AS PrecioUnitario, ts.aplica_edo_cuenta AS AplicaEdoCuenta, 
        // ts.estatus AS EstatusServicios,tp.nombre_plantel_fisico, tp.municipio AS Municipio
        // FROM t_servicios ts 
        // INNER JOIN t_planteles AS tp ON ts.id_planteles = tp.id
        // INNER JOIN t_categoria_servicios tcs ON ts.id_categoria_servicios = tcs.id  
        // INNER JOIN t_unidades_medida tum ON ts.id_unidades_medida = tum.id
        // WHERE ts.estatus !=0 ORDER BY ts.id DESC";

        // $sql = "SELECT ts.id AS IdServicios, ts.codigo_servicio AS CodigoServicio, ts.nombre_servicio AS NombreServicio, 
        //                 ts.precio_unitario AS PrecioUnitario, ts.aplica_edo_cuenta AS AplicaEdoCuenta, ts.estatus AS EstatusServicios,
        //                 tp.nombre_plantel_fisico, tp.municipio AS Municipio
        //         FROM t_servicios AS ts 
        //         INNER JOIN t_instituciones AS ti ON ts.id_instituciones = ti.id
        //         INNER JOIN t_planteles AS tp ON ti.id_planteles = tp.id
        //         INNER JOIN t_categoria_servicios tcs ON ts.id_categoria_servicios = tcs.id  
        //         INNER JOIN t_unidades_medida tum ON ts.id_unidades_medida = tum.id
        //         WHERE ts.estatus !=0 ORDER BY ts.id DESC";
        $sql = "SELECT ts.id AS IdServicios, ts.codigo_servicio AS CodigoServicio, ts.nombre_servicio AS NombreServicio, 
                        ts.precio_unitario AS PrecioUnitario, ts.aplica_edo_cuenta AS AplicaEdoCuenta, ts.estatus AS EstatusServicios,
                        ti.nombre_institucion,tp.nombre_plantel_fisico,tp.municipio AS Municipio
                FROM t_servicios AS ts 
                INNER JOIN t_instituciones AS ti ON ts.id_instituciones = ti.id
                INNER JOIN t_planteles AS tp ON ti.id_planteles = tp.id
                INNER JOIN t_categoria_servicios tcs ON ts.id_categoria_servicios = tcs.id  
                INNER JOIN t_unidades_medida tum ON ts.id_unidades_medida = tum.id
                WHERE ts.estatus !=0 ORDER BY ts.id DESC";
        $request = $this->select_all($sql);
        return $request;
    }
        //EDITAR SERVICIOS
    public function selectServicio(int $id){
        // $sql = "SELECT s.codigo_servicio,s.nombre_servicio,s.precio_unitario,s.id_categoria_servicios,s.id_unidades_medida,s.anio_fiscal,s.aplica_edo_cuenta,
        //         s.id_planteles,s.estatus 
        //         FROM t_servicios AS s
        //         WHERE s.id = $id";
        $sql = "SELECT s.codigo_servicio,s.nombre_servicio,s.precio_unitario,s.id_categoria_servicios,s.id_unidades_medida,s.anio_fiscal,s.aplica_edo_cuenta,
                s.id_instituciones,s.estatus 
                FROM t_servicios AS s
                WHERE s.id = $id";
        $request = $this->select($sql);
        return $request;
    }
    public function selectUnidadMedida(){
        $sql = "SELECT * FROM t_unidades_medida WHERE estatus != 0 ORDER BY nombre_unidad_medida ASC ";
        $request = $this->select_all($sql);
        return $request;
    }
    
    public function selectCategoriaServicios(){
        $sql = "SELECT * FROM t_categoria_servicios WHERE estatus != 0 ORDER BY nombre_categoria ASC ";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectInstituciones(){
        $sql = "SELECT * FROM t_instituciones WHERE estatus != 0 ORDER BY nombre_institucion ASC ";
        $request = $this->select_all($sql);
        return $request;
    }

    public function insertServicio(string $codigo_servicio, string $nombre_servicio, int $precio_unitario, int $aplica_edo_cuenta, string $anio_fiscal, int $estatus, string $fecha_creacion, string $fecha_actualizacion, int $id_usuario_creacion, int $id_usuario_actualizacion, int $id_institucion, int $id_categoria_servicio, int $id_unidades_medida){
        $return = 0;
        $this->strCodigo_servicio = $codigo_servicio;
        $this->strNombre_servicio = $nombre_servicio;
        $this->intPrecio_unitario = $precio_unitario;
        $this->intAplica_edo_cuenta = $aplica_edo_cuenta;
        $this->strAnio_fiscal = $anio_fiscal;
        $this->intEstatus = 1;
        $this->strFecha_creacion = $fecha_creacion;
        $this->strFecha_actualizacion = $fecha_actualizacion;
        $this->intId_usuario_creacion = $id_usuario_creacion;
        $this->intId_usuario_actualizacion = $id_usuario_actualizacion;
        $this->intIdInstitucion = $id_institucion;
        $this->intIdCategoria_servicio = $id_categoria_servicio;
        $this->intIdUnidades_medida = $id_unidades_medida;

        $sql = "SELECT * FROM t_servicios WHERE codigo_servicio = '{$this->strCodigo_servicio}' ";
        $request = $this->select_all($sql);
        if(empty($request)){
            $query_insert = "INSERT INTO t_servicios(codigo_servicio,nombre_servicio,precio_unitario,aplica_edo_cuenta,anio_fiscal,estatus,fecha_creacion,fecha_actualizacion,id_usuario_creacion,id_usuario_actualizacion,id_instituciones,id_categoria_servicioS,id_unidades_medida) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $arrData = array($this->strCodigo_servicio, $this->strNombre_servicio, $this->intPrecio_unitario, $this->intAplica_edo_cuenta, $this->strAnio_fiscal, $this->intEstatus, $this->strFecha_creacion, $this->strFecha_actualizacion, $this->intId_usuario_creacion, $this->intId_usuario_actualizacion, $this->intIdInstitucion, $this->intIdCategoria_servicio, $this->intIdUnidades_medida );
            $request_insert = $this->insert($query_insert,$arrData);
            $return = $request_insert;
        }else{
            $return = "exist";
        }
        return $return;
    }
    public function updateServicio(int $intIdServicio,string $strCodigo_servicio,string $strNombre_servicio,string $intPrecio_unitario,int $intIdCategoria_servicio,int $intIdUnidades_medida,int $strAnio_fiscal,int $intAplica_edo_cuenta,int $intIdInstitucion,int $intEstatus,int $id_user){
        $sql = "UPDATE t_servicios SET codigo_servicio = ?,nombre_servicio = ?,precio_unitario = ?,id_categoria_servicioS = ?,id_unidades_medida = ?,anio_fiscal = ?,aplica_edo_cuenta = ?,id_instituciones = ?,estatus = ?,fecha_actualizacion = NOW(),id_usuario_actualizacion = ? WHERE id = $intIdServicio";
        $arrRequest = $this->update($sql,array($strCodigo_servicio,$strNombre_servicio,$intPrecio_unitario,$intIdCategoria_servicio,$intIdUnidades_medida,$strAnio_fiscal,$intAplica_edo_cuenta,$intIdInstitucion,$intEstatus,$id_user));
        return $arrRequest;
    }

    public function deleteServicio(int $idservicio){
		$this->intIdServicio = $idservicio;
		$sql = "SELECT * FROM t_ingresos_detalles WHERE id_servicios = $this->intIdServicio";
		$request = $this->select_all($sql);
		if(empty($request)){
			$sql = "UPDATE t_servicios SET estatus = ? WHERE id = $this->intIdServicio";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);
			if($request){
				$request = 'ok';	
			}else{
				$request = 'error';
			}
		}else{
			$request = 'exist';
		}
		return $request;
	}

    // public function selectPlanteles(){
    //     $sql = "SELECT *FROM t_planteles WHERE estatus = 1";
    //     $request = $this->select_all($sql);
    //     return $request;
    // }
}
?>