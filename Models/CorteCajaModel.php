<?php
	class CorteCajaModel extends Mysql
	{
		public function __construct()
		{
			parent::__construct();
		}
        public function selectCorteActual(){
            $sql = "SELECT *FROM t_corte_caja
            WHERE fechayhora_cierre_caja != ''";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectCajeros(){
            $sql = "SELECT c.id AS id_caja,p.id AS id_persona,p.nombre_persona,p.ap_paterno,p.ap_materno FROM t_cajas AS c
            INNER JOIN t_usuarios AS u ON c.id_usuario_atiende = u.id
            INNER JOIN t_personas AS p ON u.id_personas = p.id
            INNER JOIN t_estatus_caja AS ec ON ec.id_caja = c.id
            WHERE ec.estatus_caja = 1";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectCaja(int $idCaja){
            $sql = "SELECT c.id,c.nombre,ec.estatus_caja,cc.id AS id_corte_caja,cc.fechayhora_apertura_caja,cc.fechayhora_cierre_caja,c.id_planteles FROM t_cajas AS c 
            INNER JOIN t_estatus_caja AS ec ON ec.id_caja = c.id
            RIGHT JOIN t_corte_caja AS cc ON cc.id_cajas = c.id
            WHERE c.id = $idCaja ORDER BY cc.fechayhora_apertura_caja DESC";
            $request = $this->select($sql);
            return $request;
        }

        public function estatusCaja(int $idCaja){
            return $idCaja;
        }

        public function selectTotalesMetodosPago(int $id_usuario,$fecha_apertura){
            $sql = "SELECT i.id AS id_ingreso,i.id_usuario_cobro,i.id_metodos_pago,i.total,mp.descripcion,
            i.fecha_cobro,i.folio,CONCAT(p.nombre_persona,' ',p.ap_paterno,' ',p.ap_materno)AS nombre_persona FROM t_ingresos AS i
            INNER JOIN t_metodos_pago AS mp ON i.id_metodos_pago = mp.id
            INNER JOIN t_personas AS p ON i.id_persona_paga = p.id
            WHERE i.id_usuario_cobro  = $id_usuario AND i.fecha_cobro >= '$fecha_apertura'";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectDetalleIngreso(int $idIngreso){
            $sql = "SELECT s.codigo_servicio AS codigo_servicio,sp.codigo_servicio AS codigo_servicio_precarga,s.nombre_servicio,sp.nombre_servicio AS nombre_servicio_precarga,
            idet.abono,i.folio,i.fecha_cobro,CONCAT(per.nombre_persona,' ',per.ap_paterno,' ',per.ap_materno) AS nombre_usuario  FROM t_ingresos_detalles AS idet 
            LEFT JOIN t_servicios AS s ON idet.id_servicios = s.id
            LEFT JOIN t_precarga AS p ON idet.id_precarga = p.id
            LEFT JOIN t_servicios AS sp ON p.id_servicios = sp.id
            LEFT JOIN t_ingresos AS i ON idet.id_ingresos = i.id
            INNER JOIN t_usuarios AS u ON i.id_usuario_cobro = u.id
            INNER JOIN t_personas AS per ON u.id_personas = per.id
            WHERE idet.id_ingresos = $idIngreso";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectMetodoPago(int $metodo){
            $sql = "SELECT descripcion FROM t_metodos_pago WHERE id = $metodo";
            $request = $this->select($sql);
            return $request;
        }


        public function updateCorteCaja(string $folio, int $id_corte_caja, $total_entregada,int $id_user_entrega,int $id_usuario_recibe,string $comentario){
            $sql = "UPDATE t_corte_caja SET folio = ?,fechayhora_cierre_caja = NOW(),cantidad_entregada = ?,id_usuario_entrega = ?,id_usuario_recibe = ?,comentario = ? 
            WHERE id = $id_corte_caja";
            $request = $this->update($sql,array($folio,$total_entregada,$id_user_entrega,$id_usuario_recibe,$comentario));
            return $request;
        }



        public function updateStatusCaja(int $id_caja,$monto){
            $sql = "UPDATE t_estatus_caja SET estatus_caja = ?,monto_caja = ? WHERE id_caja = $id_caja";
            $request = $this->update($sql,array(0,$monto));
            return $request;
        }
        public function selectIdUsuario(int $id_caja){
            $sql = "SELECT id_usuario_atiende FROM t_cajas WHERE id = $id_caja";
            $request = $this->select($sql);
            return $request;
        }
        public function insertDetalleCorteCaja($cantidad_entregada,$cantidad_real_recibida,int $estatus,int $id_usuario_creacion,int $id_metodo_pago,int $id_corte_caja){
            $sql = "INSERT INTO t_detalle_corte_caja(cantidad_entregada,cantidad_real_recibida,estatus,id_usuario_creacion,id_usuario_modificacion,fecha_creacion,fecha_actualizacion,id_metodos_pago,id_corte_caja) VALUES(?,?,?,?,?,NOW(),NOW(),?,?)";
            $request = $this->insert($sql,array($cantidad_entregada,$cantidad_real_recibida,$estatus,$id_usuario_creacion,$id_usuario_creacion,$id_metodo_pago,$id_corte_caja));
            return $request;
        }

        public function sigFoliocorte(string $codigo_plantel){
            $sql = "SELECT COUNT(folio) AS num_folios FROM  t_corte_caja WHERE folio LIKE '%$codigo_plantel%'";
            $request = $this->select($sql);
            return $request;
        }

        public function selectPlantel(int $id)
        {
            $sql = "SELECT *FROM t_planteles WHERE estatus = 1  AND id = $id LIMIT 1";
            $request = $this->select($sql);
            return $request;
        }

        public function selectPlantelCajero(int $idUsuario){
            $sql = "SELECT tcc.id,tu.id,tu.nickname,tp.nombre_persona,tpla.nombre_plantel_fisico,tpla.folio_identificador
                    FROM t_corte_caja AS tcc
                    INNER JOIN t_cajas AS tc ON tcc.id_cajas = tc.id
                    INNER JOIN t_usuarios AS tu ON tc.id_usuario_atiende = tu.id
                    INNER JOIN t_personas AS tp ON tu.id_personas = tp.id
                    INNER JOIN t_planteles AS tpla ON tc.id_planteles = tpla.id
                    WHERE tu.id = $idUsuario LIMIT 1";
            $request = $this->select($sql);
            return $request;
        }

        public function insertDineroCaja($id_corte_caja,$faltante,$sobrante,$id_user,$comentario){
            $sql = "INSERT INTO t_dinero_caja(dinero_sobrante,dinero_faltante,fecha_sobrante_faltante,fecha_reembolso_faltante,estatus,fecha_creacion,id_usuario_creacion,id_corte_caja,observacion) VALUES(?,?,NOW(),NOW(),?,NOW(),?,?,?)";
            $request = $this->insert($sql,array($sobrante,$faltante,1,$id_user,$id_corte_caja,$comentario));
            return $request;
        }
        // public function selectPlantelUsuaurio(int $idUser){
        //     $sql = "SELECT *FROM t_administrativo AS a
        //     INNER JOIN t_planteles AS p ON a.id_plantel = p.id
        //     WHERE a.id_usuario = $idUser";
        //     $request = $this->select($sql);
        //     return $request;
        // }

        public function selectPlantelUsuaurio(int $idUser){
            $sql = "SELECT tcc.id,tu.id,tu.nickname,tp.nombre_persona,tse.nombre_sistema,tpla.nombre_plantel_fisico,tpla.folio_identificador,tpla.domicilio,
                            tpla.colonia,tpla.municipio,tpla.estado,tpla.cod_postal
                    FROM t_corte_caja AS tcc
                    INNER JOIN t_cajas AS tc ON tcc.id_cajas = tc.id
                    INNER JOIN t_usuarios AS tu ON tc.id_usuario_atiende = tu.id
                    INNER JOIN t_personas AS tp ON tu.id_personas = tp.id
                    INNER JOIN t_sistemas_educativos AS tse ON tc.id_sistemas_educativos = tse.id
                    INNER JOIN t_planteles AS tpla ON tc.id_planteles = tpla.id
                    WHERE tu.id  = $idUser";
            $request = $this->select($sql);
            return $request;
        }

        public function selectDatosCaja(int $idCaja){
            $sql = "SELECT tcc.id,tc.id,tcc.folio,tcc.cantidad_entregada,tcc.cantidad_recibida,tp.nombre_plantel_fisico,CONCAT(tp.domicilio,
                    ', ',tp.localidad) AS domiciLocaliPlantel,tp.cod_postal,tse.nombre_sistema,tc.nombre AS nombreCaja,tcc.fechayhora_apertura_caja,tcc.fechayhora_cierre_caja,
                    tdc.dinero_sobrante,tdc.dinero_faltante,CONCAT(per.nombre_persona,' ',per.ap_paterno,' ',per.ap_materno) AS nomCajero
                    FROM t_corte_caja AS tcc
                    INNER JOIN t_cajas AS tc ON tcc.id_cajas = tc.id
                    INNER JOIN t_planteles AS tp ON tc.id_planteles = tp.id
                    INNER JOIN t_sistemas_educativos AS tse ON tc.id_sistemas_educativos = tse.id
                    INNER JOIN t_dinero_caja AS tdc ON tdc.id_corte_caja = tcc.id
                    INNER JOIN t_usuarios AS tu ON tcc.id_usuario_entrega = tu.id
                    INNER JOIN t_personas AS per ON tu.id_personas = per.id
                    WHERE tc.id = $idCaja LIMIT 1";
            $request = $this->select($sql);
            return $request;
        }

	}
?>  