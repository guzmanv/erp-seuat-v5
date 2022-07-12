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

		//Consultar datos del Plantel para Los recibos
        public function selectDatosInstitucion(string $idHistorialCorte){
            /*$sql = "SELECT ing.id,inst.nombre_institucion,sist.nombre_sistema,inst.cve_centro_trabajo,plant.cod_postal,plant.colonia,plant.domicilio,
            plant.estado,plant.localidad,plant.municipio,sist.abreviacion_sistema,plant.folio_identificador,df.rfc FROM t_ingresos AS ing
            INNER JOIN t_personas AS per ON ing.id_persona_paga = per.id
            INNER JOIN t_inscripciones AS ins ON ins.id_personas = per.id
            INNER JOIN t_plan_estudios AS pe ON ins.id_plan_estudios = pe.id 
            INNER JOIN t_instituciones AS inst ON pe.id_instituciones = inst.id
            INNER JOIN t_planteles AS plant ON inst.id_planteles = plant.id
            INNER JOIN t_sistemas_educativos AS sist ON inst.id_sistemas_educativos = sist.id
            LEFT JOIN t_datos_fiscales AS df ON sist.id_datos_fiscales = df.id
            WHERE ing.id = $idHistorialCorte LIMIT 1";*/
            // $request = $this->select($idHistorialCorte);
            return $idHistorialCorte;
        }

	}
?>  