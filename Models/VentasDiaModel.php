<?php
	class VentasDiaModel extends Mysql
	{
		public function __construct()
		{
			parent::__construct();
		}
		public function selectVentasDia($fecha,int $idUser){
			$sql = "SELECT i.id, i.folio,i.fecha_cobro,i.total,i.id_persona_paga  FROM t_ingresos AS i
            WHERE i.fecha_cobro != '' AND i.fecha_cobro LIKE '$fecha%' AND i.id_usuario_cobro  = $idUser ORDER BY i.fecha_cobro DESC";
			$request = $this->select_all($sql);
			return $request;
		}
        public function selectDatosAlumno(int $idAlumno){
            $sql = "SELECT p.id,p.nombre_persona,p.ap_paterno,p.ap_materno,pe.nombre_carrera,tg.numero_natural AS grado,
            inst.abreviacion_institucion,sis.abreviacion_sistema,pl.municipio FROM t_personas AS p
            INNER JOIN t_inscripciones AS i ON i.id_personas = p.id
            INNER JOIN t_plan_estudios AS pe ON i.id_plan_estudios = pe.id
            INNER JOIN t_instituciones AS inst ON pe.id_instituciones = inst.id
            INNER JOIN t_planteles AS pl ON inst.id_planteles = pl.id
            INNER JOIN t_grados AS tg ON i.id_grados = tg.id
            LEFT JOIN t_sistemas_educativos AS sis ON inst.id_sistemas_educativos = sis.id
            WHERE p.id = 30 AND i.tipo_ingreso = 'Inscripcion' LIMIT 1";
            $request = $this->select($sql);
            return $request;
        }
        public function selectObservacionIngreso(int $idIngreso){
            $sql = "SELECT observaciones FROM t_ingresos WHERE id= $idIngreso LIMIT 1";
            $request = $this->select($sql);
            return $request;
        }

        public function selectDetallesVenta(int $idIngreso){
            $sql = "SELECT id.id AS id_ingresos_detalles,s.nombre_servicio AS nombre_servicio,sp.nombre_servicio AS nombre_servicio_precarga,s.precio_unitario AS precio_unitario,
            sp.precio_unitario AS precio_unitario_precarga,id.promociones_aplicadas FROM t_ingresos_detalles AS id
            LEFT JOIN t_servicios AS s ON id.id_servicios = s.id
            LEFT JOIN t_precarga AS p ON id.id_precarga = p.id
            LEFT JOIN t_servicios AS sp ON p.id_servicios = sp.id
            WHERE id.id_ingresos = $idIngreso";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectAllVentasDia(int $idUsuario, $fecha){
            $sql = "SELECT i.id, i.folio,i.fecha_cobro,i.total,i.id_persona_paga FROM t_ingresos AS i
            WHERE i.fecha_cobro != '' AND i.fecha_cobro LIKE '$fecha%'  AND i.id_usuario_cobro  = $idUsuario ORDER BY i.fecha_cobro DESC";
			$request = $this->select_all($sql);
			return $request;
        }

        public function selectDatosUsuario(int $idUsuario){
            $sql = "SELECT p.nombre_persona,p.ap_paterno,p.ap_materno FROM t_usuarios AS u 
            INNER JOIN t_personas AS p ON u.id_personas = p.id
            WHERE u.id = $idUsuario";
            $request = $this->select($sql);
            return $request;
        }
	}
?>