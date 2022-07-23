<?php
	class HistorialCorteCajasModel extends Mysql
	{
		public function __construct()
		{
			parent::__construct();
		}
		public function selectCortesCajas(){
			$sql = "SELECT cc.id,cc.folio,pla.nombre_plantel_fisico,c.nombre,cc.fechayhora_apertura_caja,cc.fechayhora_cierre_caja,CONCAT(pe.nombre_persona,' ',
            pe.ap_paterno,' ',pe.ap_materno) AS usuario_entrega, CONCAT(pr.nombre_persona,' ',pr.ap_paterno,' ',pr.ap_materno) AS
            usuario_recibe,dc.dinero_faltante,
            dc.dinero_sobrante FROM t_corte_caja AS cc
            INNER JOIN t_cajas AS c ON cc.id_cajas = c.id
            INNER JOIN t_usuarios AS ur ON cc.id_usuario_recibe = ur.id
            INNER JOIN t_usuarios AS ue ON cc.id_usuario_entrega = ue.id
            INNER JOIN t_personas AS pr ON ur.id_personas = pr.id
            INNER JOIN t_personas AS pe ON ue.id_personas = pe.id
            INNER JOIN t_planteles AS pla ON c.id_planteles = pla.id
            LEFT JOIN t_dinero_caja AS dc ON dc.id_corte_caja = cc.id
            WHERE cc.folio IS NOT NULL AND dc.estatus = 1 ORDER BY cc.fechayhora_cierre_caja DESC";
			$request = $this->select_all($sql);
			return $request;
		}

		//Consultar datos del Sistema para Los recibos
        public function selectDatosSistemas(int $idHistorialCorte){
            $sql = "SELECT tcc.id,tcc.folio,tcc.cantidad_entregada,tcc.cantidad_recibida,tp.nombre_plantel_fisico,CONCAT(tp.domicilio,
            ', ',tp.localidad) AS domiciLocaliPlantel,tp.cod_postal,tse.nombre_sistema,tc.nombre AS nombreCaja,tcc.fechayhora_apertura_caja,tcc.fechayhora_cierre_caja,
            tdc.dinero_sobrante,tdc.dinero_faltante,CONCAT(per.nombre_persona,' ',per.ap_paterno,' ',per.ap_materno) AS nomCajero
            FROM t_corte_caja AS tcc
            INNER JOIN t_cajas AS tc ON tcc.id_cajas = tc.id
            INNER JOIN t_planteles AS tp ON tc.id_planteles = tp.id
            INNER JOIN t_sistemas_educativos AS tse ON tc.id_sistemas_educativos = tse.id
            INNER JOIN t_dinero_caja AS tdc ON tdc.id_corte_caja = tcc.id
            INNER JOIN t_usuarios AS tu ON tcc.id_usuario_entrega = tu.id
            INNER JOIN t_personas AS per ON tu.id_personas = per.id
                    WHERE tcc.id = $idHistorialCorte AND tdc.estatus = 1 LIMIT 1";
                    // WHERE tcc.id = $idHistorialCorte LIMIT 1
            $request = $this->select($sql);
            return $request;
        }

        public function selectSaldarFaltante(int $idCorte)
        {
            $sql = "SELECT tdc.id AS id_dinero_caja,tdc.id_corte_caja,tcc.id_cajas,tc.nombre,tdc.dinero_faltante,
            CONCAT(tpe.nombre_persona,' ',tpe.ap_paterno,' ',tpe.ap_materno) AS nombre_persona_entrega,
            CONCAT(tpr.nombre_persona ,' ',tpr.ap_paterno,' ',tpr.ap_materno) AS nombre_persona_recibe FROM t_dinero_caja AS tdc 
            INNER JOIN t_corte_caja AS tcc ON tdc.id_corte_caja = tcc.id
            INNER JOIN t_cajas AS tc ON tcc.id_cajas = tc.id
            INNER JOIN t_usuarios AS tue ON tcc.id_usuario_entrega = tue.id
            INNER JOIN t_personas AS tpe ON tue.id_personas = tpe.id
            INNER JOIN t_usuarios AS tur ON tcc.id_usuario_recibe = tur.id
            INNER JOIN t_personas AS tpr ON tur.id_personas = tpr.id
            WHERE tdc.id_corte_caja = $idCorte LIMIT 1";
            $request = $this->select($sql);
            return $request;
        }

        public function updateSaldarFaltante(int $idCorte, int $idUser)
        {
            $sql = "UPDATE t_dinero_caja SET dinero_faltante = ? ,fecha_reembolso_faltante = NOW(),fecha_actualizacion = NOW(),id_usuario_actualizacion = ? WHERE id = $idCorte";
            $request = $this->update($sql,array(0,$idUser));
            return $request;
        }

	}
?>  