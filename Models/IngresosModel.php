<?php
	class IngresosModel extends Mysql
	{
		public function __construct()
		{
			parent::__construct();
		}
        //Lista de ingresos
        public function selectIngresos(){
            $sql = "SELECT *FROM t_ingresos";
            $request = $this->select_all($sql);
            return $request;
        }
        //Obtener datos persona
        public function selectPersonasModal($data){
            $sql = "SELECT per.id,CONCAT(per.nombre_persona,' ',per.ap_paterno,' ',per.ap_materno) AS nombre,
            ins.id AS id_inscripcion,pln.nombre_carrera,ins.id_grados,gr.numero_natural, ins.id_salones_compuesto,grup.nombre_grupo FROM t_personas AS per
            LEFT JOIN t_inscripciones AS ins ON ins.id_personas = per.id
            LEFT JOIN t_historiales AS his ON ins.id_historial = his.id
            INNER JOIN t_plan_estudios AS pln ON ins.id_plan_estudios = pln.id
            LEFT JOIN t_salones_compuesto AS sal ON ins.id_salones_compuesto = sal.id
            LEFT JOIN t_grados AS gr ON ins.id_grados = gr.id
            LEFT JOIN t_grupos AS grup ON sal.id_grupos = grup.id
            WHERE CONCAT(per.nombre_persona,' ',per.ap_paterno,' ',per.ap_materno) LIKE '%$data%'";
            $request = $this->select_all($sql);
            return $request;
        }
        //Obtener estatus del estado de cuenta
        public function selectStatusEstadoCuenta(int $idPersonaSeleccionada){
            $sql = "SELECT *FROM t_estado_cuenta WHERE id_personas = $idPersonaSeleccionada";
            $request = $this->select_all($sql);
            return $request;
        }
        //Obtener lista de Servicios
        public function selectServicios(int $idPersona, int $idGrado){
            $sqlSerEdoCta = "SELECT ec.id AS id_edo_cta,p.id AS id_precarga,s.nombre_servicio,s.precio_unitario,cs.colegiatura FROM t_estado_cuenta AS ec
            INNER JOIN t_precarga AS p ON ec.id_precarga = p.id
            INNER JOIN t_servicios AS s ON p.id_servicios = s.id
            INNER JOIN t_categoria_servicios AS cs ON s.id_categoria_servicios = cs.id
            WHERE ec.id_personas = $idPersona AND p.id_grados = $idGrado";
            $requestServEdoCta = $this->select_all($sqlSerEdoCta);
            $arrayServ = [];
            foreach ($requestServEdoCta as $key => $value) {
                if($value['colegiatura'] != 1){
                    array_push($arrayServ,$value);
                }
            }
            //$sql = "SELECT *FROM t_servicios WHERE codigo_servicio NOT LIKE '%COL%'";
            $sqlOtrosServ = "SELECT *FROM t_servicios AS s WHERE s.aplica_edo_cuenta != 1";
            $requestOtrosServ = $this->select_all($sqlOtrosServ);
            foreach ($requestOtrosServ as $key => $value) {
                array_push($arrayServ,$value);
            }
            return $arrayServ;
        }
        //Obtener lista de Colegiaturas
        public function selectColegiaturas(int $idPersona, int $idGrado){
            $sql = "SELECT ec.id AS id_edo_cta,p.id AS id_precarga,s.nombre_servicio,s.precio_unitario,ec.pagado FROM t_estado_cuenta AS ec
            INNER JOIN t_precarga AS p ON ec.id_precarga = p.id
            INNER JOIN t_servicios AS s ON p.id_servicios = s.id
            INNER JOIN t_categoria_servicios AS cs ON s.id_categoria_servicios = cs.id
            WHERE ec.id_personas = $idPersona AND p.id_grados = $idGrado AND cs.colegiatura = 1";
            $request = $this->select_all($sql);
            return $request;
        }
        //Lista de Promociones por Servicio
        public function selecPromociones(int $idServicio){
            $sql = "SELECT *FROM t_servicios AS ser INNER JOIN t_promociones AS prom ON prom.id_servicios = ser.id WHERE ser.id = $idServicio";
            $request = $this->select_all($sql);
            return $request;
        }
        //Obtener carrera del Alumno
        public function selectCarreraAlumno(int $idPersonaSeleccionada){
            $sql = "SELECT ti.id_plan_estudios,tpe.id_instituciones FROM t_inscripciones AS ti 
            INNER JOIN t_plan_estudios AS tpe ON ti.id_plan_estudios = tpe.id
            WHERE ti.id_personas = $idPersonaSeleccionada LIMIT 1";
            $request = $this->select($sql);
            return $request;    
        }
        //Obtener grado del Alumno
        public function selectGradoAlumno(int $idPersonaSeleccionada){
            $sql = "SELECT gr.id,gr.numero_natural  FROM t_inscripciones AS ins
            INNER JOIN t_grados AS gr ON ins.id_grados = gr.id
            WHERE ins.id_personas = $idPersonaSeleccionada LIMIT 1";
            $request = $this->select($sql);
            return $request; 
        }
        //Obtener periodo del Alumno
        public function selectPeriodoAlumno(int $idPersonaSeleccionada){
            $sql = "SELECT ins.id_salones_compuesto,per.id AS id_periodo FROM t_inscripciones AS ins 
            INNER JOIN t_subcampania AS sub ON ins.id_subcampanias = sub.id
            INNER JOIN t_campanias AS cam ON sub.id_campanias = cam.id
            INNER JOIN t_periodos AS per ON cam.id_periodos = per.id
            WHERE ins.id_personas = $idPersonaSeleccionada LIMIT 1";
            //$sql = "SELECT *FROM t_periodos AS p WHERE estatus = 1 LIMIT 1";
            $request = $this->select($sql);
            return $request; 
        }
        //Obtener datos para generar un estado de cuenta
        public function generarEdoCuentaAlumno(int $idPersonaSeleccionada,int $idInstituciones, int $idCarrera, int $idGrado, int $idPeriodo, int $idUser){
            $sqlServicios = "SELECT p.id AS id_precarga FROM t_precarga AS p
            INNER JOIN t_servicios AS s ON p.id_servicios = s.id
            WHERE s.aplica_edo_cuenta = 1 AND s.id_instituciones = $idInstituciones AND s.estatus = 1 AND p.id_plan_estudios = $idCarrera AND p.id_periodos = $idPeriodo AND p.id_grados = $idGrado";
            $requestServicios = $this->select_all($sqlServicios);
            if($requestServicios){
                foreach ($requestServicios as $key => $servicio) {
                    $idPrecarga = $servicio['id_precarga'];
                    $sqlEdoCta = "INSERT INTO t_estado_cuenta(pagado,estatus,id_usuario_creacion,fecha_creacion,id_precarga,id_personas) VALUES(?,?,?,NOW(),?,?)";
                    $requestEdoCta = $this->insert($sqlEdoCta,array(0,1,$idUser,$idPrecarga,$idPersonaSeleccionada));
                    if($requestEdoCta){
                        $request['estatus'] = true;
                        $request['msg'] = null;
                    }
                }
            }else{
                $request['estatus'] = false;
                $request['msg'] = "No hay datos cargados para la carrera, grado o periodo del Alumno";
            }
            return $request;
        }
        //Actualizar ingresos
       /*  public function updateIngresos($idIngreso,$tipoPago,$tipoComprobante,$observaciones,$folioNuevo,$total){
            $sql = "UPDATE t_ingresos SET fecha = NOW(),folio = ?,forma_pago = ?,tipo_comprobante = ?,total = ?,observaciones = ?,
            recibo_inscripcion = ? WHERE id= $idIngreso";
            $request = $this->update($sql,array($folioNuevo,$tipoPago,$tipoComprobante,$total,$observaciones,1));
            return $idIngreso;
        } */
        //Actualizar ingresos detalles
        public function updateIngresosDetalles($idIngreso,$cantidad,$precioUnitario,$subtotal,$arrPromociones){
            $sql = "UPDATE t_ingresos_detalles SET cantidad = ? ,cargo = ?,abono = ?,saldo = ?,precio_subtotal = ?,promociones_aplicadas = ? WHERE id_ingresos = $idIngreso";
            $request = $this->update($sql,array($cantidad,$precioUnitario,$precioUnitario,$precioUnitario,$subtotal,$arrPromociones));
            return $idIngreso;
        }
        //Obtener el siguiente Folio
        public function selectFolioSig(int $idAlumno){
            $sqlPlantel = "SELECT pl.id AS id_plantel,inst.abreviacion_institucion,sis.abreviacion_sistema,pl.folio_identificador FROM t_personas AS p
            INNER JOIN t_inscripciones AS i ON i.id_personas = p.id
            INNER JOIN t_plan_estudios AS ple ON i.id_plan_estudios = ple.id
            INNER JOIN t_instituciones AS inst ON ple.id_instituciones = inst.id
            INNER JOIN t_planteles AS pl ON inst.id_planteles = pl.id
            LEFT JOIN t_sistemas_educativos AS sis ON inst.id_sistemas_educativos = sis.id
            WHERE p.id = $idAlumno LIMIT 1";
            $requestPlantel = $this->select($sqlPlantel);
            $codigoPlantel = $requestPlantel['folio_identificador'];

            $sqlFolioCosecutivo = "SELECT COUNT(folio) AS num_folios FROM  t_ingresos WHERE folio LIKE '%$codigoPlantel%'";
            $requestFolioConsecutivo = $this->select($sqlFolioCosecutivo);
            $cantidadFolios = $requestFolioConsecutivo['num_folios'];
            $nuevoFolio = $cantidadFolios+1;
            $nuevoFolioConsecutivo = $codigoPlantel.'IN'.date("mY").substr(str_repeat(0,4).$nuevoFolio,-4);

            return $nuevoFolioConsecutivo;
        }
        //Obtener el Id del ingreso de un id Servicio e id Alumno
       /*  public function checkIdIngreso(int $idServicio,int $idAlumno){    
            $sql = "SELECT i.id FROM t_ingresos AS i
            RIGHT JOIN t_ingresos_detalles AS id ON id.id_ingresos = i.id
            WHERE id.id_servicio = $idServicio AND i.id_persona = $idAlumno";
            $request = $this->select($sql);
            return $request;
        } */
        
        //Insertar un nuevo Ingreso
        public function insertIngresos(string $folio,int $formaPago, string $tipoComprobante,int $total,string $observaciones,int $idAlumno, int $idPlantel, int $idUSer){
            $sqlIngresos = "INSERT INTO t_ingresos(fecha,folio,estatus,id_metodos_pago,tipo_comprobante,referencia,total,observaciones,recibo_inscripcion,id_planteles,id_persona_paga,id_usuario_cobro) VALUES(NOW(),?,?,?,?,?,?,?,?,?,?,?)";
            $requestIngresos = $this->insert($sqlIngresos,array($folio,1,$formaPago,$tipoComprobante,$folio,$total,$observaciones,1,$idPlantel,$idAlumno,$idUSer));
            return $requestIngresos;
        }
        //Insertar un nuevo ingreso detalle
        public function insertIngresosDetalle(int $cantidad,int $cargo,int $abono,int $saldo,int $precioSubtotal,int $descuentoDinero,int $descuentoPorcentaje,string $promocionesAplicadas,$idServicio,$idPrecarga,int $idIngreso){
            if($idServicio != null && $idPrecarga != null){ //Edo Cta
                $sqlIngDetalle = "INSERT INTO t_ingresos_detalles(cantidad,cargo,abono,saldo,precio_subtotal,descuento_dinero,descuento_porcentaje,promociones_aplicadas,id_servicios,id_ingresos,id_precarga) VALUES(?,?,?,?,?,?,?,?,?,?,?)";
                $requestIngDetalle = $this->insert($sqlIngDetalle,array($cantidad,$cargo,$abono,$saldo,$precioSubtotal,$descuentoDinero,$descuentoPorcentaje,$promocionesAplicadas,$idServicio,$idIngreso,$idPrecarga));
            }else if($idServicio !=null && $idPrecarga == null){
                $sqlIngDetalle = "INSERT INTO t_ingresos_detalles(cantidad,cargo,abono,saldo,precio_subtotal,descuento_dinero,descuento_porcentaje,promociones_aplicadas,id_servicios,id_ingresos,id_precarga) VALUES(?,?,?,?,?,?,?,?,?,?,?)";
                $requestIngDetalle = $this->insert($sqlIngDetalle,array($cantidad,$cargo,$abono,$saldo,$precioSubtotal,$descuentoDinero,$descuentoPorcentaje,$promocionesAplicadas,$idServicio,$idIngreso,NULL));
            }
            return $requestIngDetalle;
        }
        //Consultar datos del Plantel para Los recibos
        public function selectDatosInstitucion(int $idIngreso){
            $sql = "SELECT ing.id,inst.nombre_institucion,sist.nombre_sistema,inst.cve_centro_trabajo,plant.cod_postal,plant.colonia,plant.domicilio,
            plant.estado,plant.localidad,plant.municipio,sist.abreviacion_sistema,plant.folio_identificador,df.rfc FROM t_ingresos AS ing
            INNER JOIN t_personas AS per ON ing.id_persona_paga = per.id
            INNER JOIN t_inscripciones AS ins ON ins.id_personas = per.id
            INNER JOIN t_plan_estudios AS pe ON ins.id_plan_estudios = pe.id 
            INNER JOIN t_instituciones AS inst ON pe.id_instituciones = inst.id
            INNER JOIN t_planteles AS plant ON inst.id_planteles = plant.id
            INNER JOIN t_sistemas_educativos AS sist ON inst.id_sistemas_educativos = sist.id
            LEFT JOIN t_datos_fiscales AS df ON sist.id_datos_fiscales = df.id
            WHERE ing.id = $idIngreso LIMIT 1";
            $request = $this->select($sql);
            return $request;
        }
        //Consultar datos de la Venta/Ingreso
        public function selectDatosVenta(int $idIngreso){
            $sql = "SELECT i.id AS id_ingreso,i.folio,i.fecha AS fecha_ingreso,id.cantidad,id.id AS id_ingreso_detalle,i.total,s.nombre_servicio,s.precio_unitario,s.codigo_servicio,
            id.id_precarga,sp.nombre_servicio AS nombre_servicio_precarga,sp.precio_unitario AS precio_unitario_precarga,sp.codigo_servicio AS codigo_servicio_precarga FROM t_ingresos AS i       
            RIGHT JOIN t_ingresos_detalles AS id ON id.id_ingresos = i.id
            LEFT JOIN t_servicios AS s ON id.id_servicios = s.id
            LEFT JOIN t_precarga AS p ON id.id_precarga = p.id
            LEFT JOIN t_servicios AS sp ON p.id_servicios = sp.id
            WHERE i.id = $idIngreso";
            $request = $this->select_all($sql);
            return $request;
        }
        //Consultar datos del Alumno vinculado a la Venta
        public function selectDatosAlumno(int $idIngreso){
            $sql = "SELECT p.id,p.nombre_persona,p.ap_paterno,p.ap_materno,pe.nombre_carrera,h.matricula_interna,
            per.fecha_inicio_periodo,per.fecha_fin_periodo,pe.nombre_carrera FROM t_ingresos AS i
            INNER JOIN t_personas AS p ON i.id_persona_paga = p.id
            INNER JOIN t_inscripciones AS ins ON i.id_persona_paga = ins.id_personas
            INNER JOIN t_plan_estudios AS pe ON ins.id_plan_estudios = pe.id
            INNER JOIN t_historiales AS h ON ins.id_historial = h.id
            LEFT JOIN t_salones_compuesto AS sc ON ins.id_salones_compuesto = sc.id
            LEFT JOIN t_periodos AS per ON sc.id_periodos = per.id
            WHERE i.id = $idIngreso LIMIT 1";
            $request = $this->select($sql);
            return $request;
        }
        public function selectDatosUsuario(int $idUsuario){
            $sql = "SELECT p.nombre_persona, p.ap_paterno, p.ap_materno, l.nombre AS localidad, m.nombre AS municipio, e.nombre AS estado FROM t_usuarios AS u 
            INNER JOIN t_personas AS p ON u.id_personas = p.id 
            INNER JOIN t_localidades AS l ON p.id_localidad = l.id
            INNER JOIN t_municipios AS m ON l.id_municipio = m.id
            INNER JOIN t_estados AS e ON m.id_estados = e.id
            LIMIT 1";
            $request = $this->select($sql);
            return $request;
        }
        public function updateEdoCta(int $id,int $idUser){
            $sql = "UPDATE t_estado_cuenta SET pagado = ? ,id_usuario_actualizacion = ?,fecha_actualizacion = NOW() WHERE id = $id";
            $request = $this->update($sql,array(1,$idUser));
            return $request;
        }

        public function selectMetodosPago(){
            $sql = "SELECT *FROM t_metodos_pago WHERE estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectEstatusCaja(int $idUser){
            $sql = "SELECT c.id AS id_caja,c.id_usuario_atiende,ec.estatus_caja,c.nombre FROM t_cajas AS c
            INNER JOIN t_estatus_caja AS ec ON ec.id_caja = c.id
            WHERE c.id_usuario_atiende = $idUser";
            $request = $this->select($sql);
            return $request;
        }
        public function updateEstatusCaja(int $idCaja, int $estatus,int $monto){
            $sql = "UPDATE t_estatus_caja SET estatus_caja = ?,monto_caja = ? WHERE id_caja = $idCaja";
            $request = $this->update($sql,array($estatus,$monto));
            return $request;
        }
        public function insertCorteCaja(int $monto, int $idCaja){
            $sql = "INSERT INTO t_corte_caja(fechayhora_apertura_caja,cantidad_recibida,id_cajas) VALUES(NOW(),?,?)";
            $request = $this->insert($sql,array($monto,$idCaja));
            return $request;
        }

        //Obtener plantel del Alumno
        public function selectPlantelAlumno(int $idPersonaSeleccionada){
            $sql = "SELECT plte.id FROM t_inscripciones AS ins
            INNER JOIN t_plan_estudios AS plnest ON ins.id_plan_estudios = plnest.id
            INNER JOIN t_instituciones AS inst ON plnest.id_instituciones = inst.id
            INNER JOIN t_planteles AS plte ON inst.id_planteles = plte.id WHERE ins.id_personas = $idPersonaSeleccionada LIMIT 1";
            $request = $this->select($sql);
            return $request;
        }

        public function selectPlantelUSer(int $idUser){
/*             $sql = "SELECT p.id FROM t_administrativo AS ad 
            INNER JOIN t_planteles AS p ON ad.id_plantel = p.id WHERE ad.id_usuario = $idUser LIMIT 1"; */
            $sql = "SELECT nom_plantel FROM t_administrativo WHERE id_usuario = $idUser LIMIT 1";
            $request = $this->select($sql);
            return $request;
        }
        public function selectGrados()
        {
            $sql = "SELECT *FROM t_grados WHERE estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectNuevasInscripciones()
        {
            //$sql = "SELECT *FROM t_ingresos WHERE folio IS NULL";
            $sql = "SELECT tt.id AS id_tmp,tt.folio_inscripcion,tt.id_persona,tt.id_inscripcion,tt.porcentaje_descuento_coleg,
            tt.porcentaje_descuento_insc,tt.precio_colegiatura,tt.precio_inscripcion,tt.total_descuento_coleg,
            tt.total_descuento_insc,tp.id AS id_persona,tp.nombre_persona,tp.ap_paterno,tp.ap_materno FROM t_tmpInscripciones AS tt 
            INNER JOIN t_personas AS tp ON tt.id_persona = tp.id";
            $request = $this->select_all($sql);
            return $request;
        }


        //Funcion para consultar lista de Estudiantes
		public function selectEstudiantes(){
			/* $sql = "SELECT ins.id,per.id AS id_personas, per.nombre_persona,CONCAT(per.ap_paterno,' ',per.ap_materno)AS apellidos,
            plante.nombre_plantel_fisico,plante.municipio,planest.nombre_carrera,ins.grado,sa.nombre_salon,acp.validacion_doctos,
            acp.validacion_datos_personales,acp.id_usuario_verificacion_doctos,acp.id_usuario_verificacion_datos_personales 
            FROM t_inscripciones AS ins 
            LEFT JOIN t_historiales AS his ON ins.id_historial = his.id
            INNER JOIN t_personas AS per ON ins.id_personas = per.id
            INNER JOIN t_plan_estudios AS planest ON ins.id_plan_estudios = planest.id
            INNER JOIN t_instituciones AS inst ON planest.id_instituciones = inst.id
            INNER JOIN t_planteles AS plante ON inst.id_planteles = plante.id
            LEFT JOIN t_salones_compuesto AS sal ON ins.id_salones_compuesto = sal.id
            LEFT JOIN t_salones AS sa ON sal.id_salones = sa.id 
            RIGHT JOIN t_asignacion_categoria_persona AS acp ON acp.id_personas = per.id 
            WHERE his.inscrito = 1 AND acp.estatus = 1 AND acp.id_categoria_persona = 2"; */
            $sql = "SELECT ti.id AS id_ingreso,ts.id AS id_servicio,tid.id_precarga,ti.id_persona_paga,
            tp.nombre_persona,tp.ap_paterno,tp.ap_materno FROM t_ingresos_detalles AS tid
            INNER JOIN t_ingresos AS ti ON tid.id_ingresos = ti.id 
            INNER JOIN t_servicios AS ts ON tid.id_servicios = ts.id
            INNER JOIN t_categoria_servicios AS tcs ON ts.id_categoria_servicios = tcs.id 
            INNER JOIN t_personas AS tp ON ti.id_persona_paga = tp.id
            WHERE (tcs.colegiatura = 1 OR tcs.clave_categoria LIKE '%INS%') AND ti.folio IS NULL
            GROUP BY ti.id HAVING COUNT(*)>=1";
			$request = $this->select_all($sql);
			return $request;
		}

        public function selectIngreso(int $idIngreso)
        {
            $sql = "SELECT ts.id AS id_servicio,tcs.colegiatura,ti.id_persona_paga,tp.nombre_persona,
            tp.ap_paterno,tp.ap_materno,ts.nombre_servicio,ts.precio_unitario,
            tid.id_precarga,ts.aplica_edo_cuenta FROM t_ingresos_detalles AS tid
            INNER JOIN t_ingresos AS ti ON tid.id_ingresos = ti.id
            INNER JOIN t_servicios AS ts ON tid.id_servicios = ts.id
            INNER JOIN t_categoria_servicios AS tcs ON ts.id_categoria_servicios = tcs.id
            INNER JOIN t_personas AS tp ON ti.id_persona_paga = tp.id
            WHERE ti.id = $idIngreso";
            $request = $this->select_all($sql);
            return $request;
        }

        public function deletTempInscripcion(int $id)
        {
            $sql = "DELETE FROM t_tmpinscripciones WHERE id = $id";
            $request = $this->delete($sql);
            return $request;
        }
	}
?>  