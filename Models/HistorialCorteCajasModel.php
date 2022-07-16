<?php
	class HistorialCorteCajasModel extends Mysql
	{
		public function __construct()
		{
			parent::__construct();
		}
		public function selectCortesCajas(){
			$sql = "SELECT cc.id,cc.folio,pla.nombre_plantel_fisico,c.nombre,cc.fechayhora_apertura_caja,cc.fechayhora_cierre_caja,CONCAT(pe.nombre_persona,' ',
            pe.ap_paterno,' ',pe.ap_materno) AS usuario_entrega, CONCAT(pr.nombre_persona,' ',pr.ap_paterno,' ',pr.ap_materno) AS usuario_recibe,dc.dinero_faltante,
            dc.dinero_sobrante FROM t_corte_caja AS cc
            INNER JOIN t_cajas AS c ON cc.id_cajas = c.id
            LEFT JOIN t_usuarios AS ur ON cc.id_usuario_recibe = ur.id
            LEFT JOIN t_usuarios AS ue ON cc.id_usuario_entrega = ue.id
            LEFT JOIN t_personas AS pr ON ur.id_personas = pr.id
            LEFT JOIN t_personas AS pe ON ue.id_personas = pe.id
            LEFT JOIN t_planteles AS pla ON c.id_planteles = pla.id
            LEFT JOIN t_dinero_caja AS dc ON dc.id_corte_caja = cc.id ORDER BY cc.fechayhora_cierre_caja DESC";
			$request = $this->select_all($sql);
			return $request;
		}

		//Consultar datos del Sistema para Los recibos
        public function selectDatosSistemas(int $idHistorialCorte){
            $sql = "SELECT tcc.id,tcc.folio,tp.nombre_plantel_fisico,tse.nombre_sistema,tc.nombre AS nombreCaja,
                    CONCAT(tcc.fechayhora_apertura_caja,' ',tcc.fechayhora_cierre_caja) AS fechaAperturaCierre
                    FROM t_corte_caja AS tcc
                    INNER JOIN t_cajas AS tc ON tcc.id_cajas = tc.id
                    INNER JOIN t_planteles AS tp ON tc.id_planteles = tp.id
                    INNER JOIN t_instituciones AS ti ON ti.id_planteles = ti.id
                    INNER JOIN t_sistemas_educativos AS tse ON ti.id_sistemas_educativos = tse.id
                    WHERE tcc.id = $idHistorialCorte LIMIT 1";
                    // WHERE tcc.id = $idHistorialCorte LIMIT 1
            $request = $this->select($sql);
            return $request;
        }

        //Consultar datos del corte
        public function selectDatosCorte(int $idHistorialCorte){
            $sql = "SELECT tcc.id,tcc.folio,CONCAT(tcc.fechayhora_apertura_caja,' ',tcc.fechayhora_cierre_caja) AS fechaAperturaCierre,
                    tc.nombre
                    FROM t_corte_caja AS tcc
                    INNER JOIN t_cajas AS tc ON tcc.id_cajas = tc.id
                    WHERE tcc.id = $idHistorialCorte LIMIT 1";
            $request = $this->select_all($sql);
            return $request;
        }

	}
?>  