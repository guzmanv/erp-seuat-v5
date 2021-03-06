<?php
    class PreinscripcionModel extends Mysql{
        public function __construct(){
            parent::__construct();
        }
        public function selectInscripcionesAdmision(){
            $sql = "SELECT plant.id AS id_plantel,plant.nombre_plantel_fisico,plan.id,plan.nombre_carrera,niv.nombre_nivel_educativo,
            ins.id_grados,grup.nombre_grupo,orgp.nombre_plan,tur.id AS id_turno,tur.nombre_turno,plant.municipio,tgi.numero_natural,COUNT(*) AS total 
            FROM t_inscripciones AS ins
            			INNER JOIN t_grados AS tgi ON ins.id_grados = tgi.id
                        INNER JOIN t_personas AS per ON ins.id_personas = per.id
                        INNER JOIN t_plan_estudios AS plan ON ins.id_plan_estudios = plan.id
                        INNER JOIN t_nivel_educativos AS niv ON plan.id_nivel_educativos = niv.id
                        INNER JOIN t_organizacion_planes AS orgp ON plan.id_organizacion_planes = orgp.id
                        LEFT JOIN t_salones_compuesto AS sal ON ins.id_salones_compuesto = sal.id
                        LEFT JOIN t_grados AS gra ON sal.id_grados = gra.id
                        LEFT JOIN t_grupos AS grup ON sal.id_grupos = grup.id
                        INNER JOIN t_instituciones AS inst ON plan.id_instituciones = inst.id
                        INNER JOIN t_planteles AS plant ON inst.id_planteles = plant.id
                        INNER JOIN 	t_sistemas_educativos AS se ON inst.id_sistemas_educativos = se.id 
                        INNER JOIN t_turnos AS tur ON ins.id_turnos = tur.id
                        INNER JOIN t_historiales AS his ON ins.id_historial = his.id
                        WHERE his.inscrito = 1 AND ins.tipo_ingreso = 'Inscripcion' AND ins.estatus = 1
                        GROUP BY plan.nombre_carrera,ins.id_grados,tur.nombre_turno HAVING COUNT(*)>=1";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectInscripcionesAdmisionByPlantel(int $idPlantel)
        {
            $sql = "SELECT plant.id AS id_plantel,plant.nombre_plantel_fisico,plan.id,plan.nombre_carrera,niv.nombre_nivel_educativo,
            ins.id_grados,grup.nombre_grupo,orgp.nombre_plan,tur.id AS id_turno,tur.nombre_turno,plant.municipio,tgi.numero_natural,COUNT(*) AS total 
            FROM t_inscripciones AS ins
            			INNER JOIN t_grados AS tgi ON ins.id_grados = tgi.id
                        INNER JOIN t_personas AS per ON ins.id_personas = per.id
                        INNER JOIN t_plan_estudios AS plan ON ins.id_plan_estudios = plan.id
                        INNER JOIN t_nivel_educativos AS niv ON plan.id_nivel_educativos = niv.id
                        INNER JOIN t_organizacion_planes AS orgp ON plan.id_organizacion_planes = orgp.id
                        LEFT JOIN t_salones_compuesto AS sal ON ins.id_salones_compuesto = sal.id
                        LEFT JOIN t_grados AS gra ON sal.id_grados = gra.id
                        LEFT JOIN t_grupos AS grup ON sal.id_grupos = grup.id
                        INNER JOIN t_instituciones AS inst ON plan.id_instituciones = inst.id
                        INNER JOIN t_planteles AS plant ON inst.id_planteles = plant.id
                        INNER JOIN 	t_sistemas_educativos AS se ON inst.id_sistemas_educativos = se.id 
                        INNER JOIN t_turnos AS tur ON ins.id_turnos = tur.id
                        INNER JOIN t_historiales AS his ON ins.id_historial = his.id
                        WHERE his.inscrito = 1 AND ins.tipo_ingreso = 'Inscripcion' AND plant.id = $idPlantel AND ins.estatus = 1
                        GROUP BY plan.nombre_carrera,ins.id_grados,tur.nombre_turno HAVING COUNT(*)>=1";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectInscripcionesControlEscolar($idplantel){
            $idPlantel = $idplantel;
            if($idPlantel == "Todos"){
                $sql = "SELECT plant.id AS id_plantel,plant.nombre_plantel_fisico,plan.id,plan.nombre_carrera,niv.nombre_nivel_educativo,
                tg.numero_natural AS grado,grup.nombre_grupo,orgp.nombre_plan,tur.id AS id_turno,tur.nombre_turno,plant.municipio,COUNT(*) AS total FROM t_inscripciones AS ins
                            INNER JOIN t_personas AS per ON ins.id_personas = per.id
                            INNER JOIN t_plan_estudios AS plan ON ins.id_plan_estudios = plan.id
                            INNER JOIN t_nivel_educativos AS niv ON plan.id_nivel_educativos = niv.id
                            INNER JOIN t_organizacion_planes AS orgp ON plan.id_organizacion_planes = orgp.id
                            INNER JOIN t_grados AS tg ON ins.id_grados = tg.id
                            LEFT JOIN t_salones_compuesto AS sal ON ins.id_salones_compuesto = sal.id
                            LEFT JOIN t_grados AS gra ON sal.id_grados = gra.id
                            LEFT JOIN t_grupos AS grup ON sal.id_grupos = grup.id
                            INNER JOIN t_instituciones AS inst ON plan.id_instituciones = inst.id
                            INNER JOIN t_planteles AS plant ON inst.id_planteles = plant.id
                            INNER JOIN 	t_sistemas_educativos AS se ON inst.id_sistemas_educativos = se.id 
                            INNER JOIN t_turnos AS tur ON ins.id_turnos = tur.id
                            INNER JOIN t_historiales AS his ON ins.id_historial = his.id
                            WHERE his.inscrito = 1 AND ins.estatus = 1 AND ins.tipo_ingreso ='Inscripcion'
                            GROUP BY plan.nombre_carrera,tg.numero_natural,tur.nombre_turno HAVING COUNT(*)>=1";
                $request = $this->select_all($sql);
            }else{
                $sql = "SELECT plant.id AS id_plantel,plant.nombre_plantel_fisico,plan.id,plan.nombre_carrera,niv.nombre_nivel_educativo,
                tg.numero_natural AS grado,grup.nombre_grupo,orgp.nombre_plan,tur.id AS id_turno,tur.nombre_turno,plant.municipio,COUNT(*) AS total FROM t_inscripciones AS ins
                            INNER JOIN t_personas AS per ON ins.id_personas = per.id
                            INNER JOIN t_plan_estudios AS plan ON ins.id_plan_estudios = plan.id
                            INNER JOIN t_nivel_educativos AS niv ON plan.id_nivel_educativos = niv.id
                            INNER JOIN t_organizacion_planes AS orgp ON plan.id_organizacion_planes = orgp.id
                            INNER JOIN t_grados AS tg ON ins.id_grados = tg.id
                            LEFT JOIN t_salones_compuesto AS sal ON ins.id_salones_compuesto = sal.id
                            LEFT JOIN t_grados AS gra ON sal.id_grados = gra.id
                            LEFT JOIN t_grupos AS grup ON sal.id_grupos = grup.id
                            INNER JOIN t_instituciones AS inst ON plan.id_instituciones = inst.id
                            INNER JOIN t_planteles AS plant ON inst.id_planteles = plant.id
                            INNER JOIN 	t_sistemas_educativos AS se ON inst.id_sistemas_educativos = se.id 
                            INNER JOIN t_turnos AS tur ON ins.id_turnos = tur.id
                            INNER JOIN t_historiales AS his ON ins.id_historial = his.id
                            WHERE his.inscrito = 1 AND plant.id = $idPlantel AND ins.estatus = 1 AND ins.tipo_ingreso = 'Inscripcion'
                            GROUP BY plan.nombre_carrera,tg.numero_natural,tur.nombre_turno HAVING COUNT(*)>=1";
                $request = $this->select_all($sql);
            }
            return $request;
        }
        public function selectPersona($id){
            $sql = "SELECT *FROM t_personas WHERE id = $id";
            $request = $this->select($sql);
            return $request;
        }
        public function selectPersonasModal($data,int $idPlantel){
            $sql = "SELECT per.id,CONCAT(COALESCE(per.nombre_persona,''),' ',COALESCE(per.ap_paterno,''),' ',COALESCE(per.ap_materno,'')) AS nombre,
            ins.id AS id_inscripcion,pr.id AS id_prospecto,pr.id_plantel_prospectado FROM t_personas AS per
            LEFT JOIN t_inscripciones AS ins ON ins.id_personas = per.id
            LEFT JOIN t_historiales AS his ON ins.id_historial = his.id
            LEFT JOIN t_prospectos AS pr ON pr.id_personas  = per.id
            WHERE CONCAT(COALESCE(per.nombre_persona,''),' ',COALESCE(per.ap_paterno,''),' ',COALESCE(per.ap_materno,'')) LIKE '%$data%' AND pr.id  != '' AND pr.id_plantel_prospectado = $idPlantel AND ins.id IS NULL";
            $request = $this->select_all($sql);
            return $request;
        }

        public function insertInscripcion($data,int $idUser, int $idPlantel, int $checkColegiatura, int $checkInscripcion){
            $idPersona = $data['idPersonaSeleccionada'];
            //$idPlantel = $data['listPlantelNuevo'];
            $idCarrera = $data['listCarreraNuevo'];
            $grado = $data['listGradoNuevo'];
            $turno = $data['listTurnoNuevo'];
            $empresa = $data['txtNombreEmpresa'];
            $nombreTutor = $data['txtNombreTutorAgregar'];
            $appPatTutor = $data['txtAppPaternoTutorAgregar'];
            $appMatTutor = $data['txtAppMaternoTutorAgregar'];
            $telCelularTutor = $data['txtTelCelularTutorAgregar'];
            $telFijoTutor = $data['txtTelFijoTutorAgregar'];
            $emailTutor = $data['txtEmailTutorAgregar'];

            $anioActual = date('Y');
            $siglaSistema = $this->selectFolioPlantel($idPlantel)['folio_identificador'];
            $tipoIngreso = "Inscripcion";
            if($grado != 1){
                $idSalon = null;
            }else{
                $idSalon = null;
            }
            $direccionTutor = $data['txtDireccionNuevo'];
            $idSubcampania = $data['idSubcampaniaNuevo'];
            $sql = "INSERT INTO t_tutores(nombre_tutor,appat_tutor,apmat_tutor,direccion,tel_celular,tel_fijo,email,estatus,id_usuario_creacion,fecha_creacion) VALUES(?,?,?,?,?,?,?,?,?,NOW())";
            $request = $this->insert($sql,array($nombreTutor,$appPatTutor,$appMatTutor,$direccionTutor,$telCelularTutor,$telFijoTutor,$emailTutor,1,$idUser));
            if($request){
                $idTutor = $request;
                $sql_documentos = "SELECT doc.id FROM t_plan_estudios AS plan
                INNER JOIN t_nivel_educativos AS niv ON plan.id_nivel_educativos = niv.id 
                INNER JOIN t_documentos AS doc ON doc.id_nivel_educativo = niv.id WHERE plan.id = $idCarrera LIMIT 1";
                $request_documentos = $this->select($sql_documentos);
                if($request_documentos){
                    $idDocumentos = $request_documentos['id'];
                    $sql_folio_sistema = "SELECT COUNT(*) AS total FROM t_inscripciones WHERE folio_sistema LIKE '%$siglaSistema%'";
                    $request_folio_sistema = $this->select($sql_folio_sistema);
                    $request_folio_sistema_format = str_pad($request_folio_sistema['total']+1 ,5,"0",STR_PAD_LEFT);
                    $folioSistema = $siglaSistema.$anioActual.($request_folio_sistema_format);

                    $sql_historial = "INSERT INTO t_historiales(aperturado,inscrito,egreso,pasante,titulado,baja,matricula_interna,matricula_externa,fecha_inscrito,fecha_egreso,fecha_pasante,fecha_titulado,fecha_baja) VALUES(?,?,?,?,?,?,?,?,NOW(),?,?,?,?)";
                    $request_historial = $this->insert($sql_historial,array(0,1,0,0,0,0,null,null,null,null,null,null));
                    if($request_historial){
                        $sql_inscripcion = "INSERT INTO t_inscripciones(folio_impreso,folio_sistema,tipo_ingreso,id_grados,promedio,estatus,aplica_descuento_inscripcion,aplica_descuento_colegiatura,id_turnos,id_plan_estudios,id_personas,id_tutores,id_documentos,id_subcampanias,id_salones_compuesto,id_historial,id_usuario_creacion,fecha_creacion) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())";
                        $request_inscripcion = $this->insert($sql_inscripcion,array($folioSistema,$folioSistema,$tipoIngreso,$grado,null,1,$checkInscripcion,$checkColegiatura, $turno,$idCarrera,$idPersona,$idTutor,$idDocumentos,$idSubcampania,$idSalon,$request_historial,$idUser));
                        if($request_inscripcion){
                            $sqlEmpresa = "UPDATE t_personas SET nombre_empresa = ?,fecha_actualizacion = NOW(),id_usuario_actualizacion = ? WHERE id = $idPersona";
                            $requestEmpresa = $this->update($sqlEmpresa,array($empresa,$idUser));
                            /* $sqlUpdateProspecto = "UPDATE t_prospectos SET id_plantel_inscrito = ? WHERE id_persona = $idPersona";
                            $reqUpdateProspecto = $this->update($sqlUpdateProspecto,array($idPlantel)); */
                            $sqlUpdateAsigCatPersona = "UPDATE t_asignacion_categoria_persona SET fecha_baja = NOW(), estatus = ?,fecha_actualizacion = NOW(),id_usuario_actualizacion = ? WHERE id_personas = $idPersona AND id_categoria_persona = 1";
                            $reqUpdateAsigCatPersona = $this->update($sqlUpdateAsigCatPersona,array(2,$idUser));
                            $sqlInsertCatPersona = "INSERT INTO t_asignacion_categoria_persona(fecha_alta,validacion_datos_personales,validacion_doctos,estatus,fecha_creacion,id_usuario_creacion,id_personas,id_categoria_persona) VALUES(NOW(),?,?,?,NOW(),?,?,?)";
                            $reqInsertCatPersona = $this->insert($sqlInsertCatPersona,array(0,0,1,$idUser,$idPersona,2));
                        }
                    }

                }
            }
            $response['inscripcion'] = $request_inscripcion;
            $response['folio'] = $folioSistema;
            return $response;
        }
        public function selectPlanteles(){
            $sql = "SELECT *FROM t_planteles WHERE estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectNivelesEducativos(){
            $sql = "SELECT *FROM t_nivel_educativos WHERE estatus != 0";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectCarreras(int $nivel, int $idPlantel){
            $sql = "SELECT tp.id AS id_plantel, inst.id AS id_sistema,tpe.id AS id_plan_estudio, 
            tpe.nombre_carrera FROM t_plan_estudios AS tpe 
            INNER JOIN t_instituciones AS inst ON tpe.id_instituciones = inst.id
            INNER JOIN t_planteles AS tp ON inst.id_planteles = tp.id
            INNER JOIN t_sistemas_educativos AS tse ON inst.id_sistemas_educativos = tse.id
            WHERE tpe.id_nivel_educativos = $nivel AND inst.id_planteles = $idPlantel AND tpe.estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectGrados(){
            $sql = "SELECT *FROM t_grados";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectSubcampanias(){
            $sql = "SELECT c.id AS id_campania,c.nombre_campania,c.fecha_fin AS fecha_fin_campania,s.id AS id_subcampania,s.nombre_sub_campania,s.fecha_fin AS fecha_fin_subcampania FROM t_campanias AS c
            RIGHT JOIN t_subcampania AS s ON s.id_campanias = c.id
            WHERE c.fecha_fin >= NOW() AND c.estatus = 1 AND s.estatus = 1
            ORDER BY c.fecha_fin DESC";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectPlanes(){
            $sql = "SELECT *FROM t_organizacion_planes";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectturnos(){
            $sql = "SELECT *FROM t_turnos WHERE id_categoria_persona = 2";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectDocumentacion($idAlumno){
            $idAlumno = $idAlumno;
            $sql = "SELECT insc.id_personas,insc.id_documentos,det.tipo_documento FROM t_inscripciones AS insc
            INNER JOIN t_documentos AS doc ON insc.id_documentos = doc.id
            INNER JOIN t_detalle_documentos AS det ON det.id_documentos = doc.id
            WHERE insc.id = $idAlumno";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectInscripcion(int $idInscripcion){
            $sql = "SELECT per.nombre_persona,per.ap_paterno,per.ap_materno,plnt.id AS id_plantel,ins.id_plan_estudios,plan.nombre_carrera FROM t_inscripciones AS ins
            INNER JOIN t_personas AS per ON ins.id_personas = per.id
            INNER JOIN t_plan_estudios AS plan ON ins.id_plan_estudios = plan.id
            INNER JOIN t_planteles AS plnt ON plan.id_plantel = plnt.id
            WHERE ins.id = $idInscripcion";
            $request = $this->select_all($sql);
            return $request;
        }

        //Lista de Inscritos en una Carrera
        public function selectInscritos(int $idCarrera, int $grado, int $turno){
            $sql = "SELECT ins.id AS id_inscripcion,per.id AS id_persona,per.nombre_persona,CONCAT(per.ap_paterno,' ',per.ap_materno) AS apellidos,h.pospuesto FROM t_inscripciones AS ins
            INNER JOIN t_personas AS per ON ins.id_personas = per.id
            INNER JOIN t_historiales AS h ON ins.id_historial = h.id
            WHERE ins.id_plan_estudios = $idCarrera AND ins.id_grados = $grado AND ins.id_turnos = $turno AND h.inscrito = 1 AND ins.estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }

        //Obtener datos para la impresion de solicitud de inscripcion
        public function selectDatosImprimirSolInscricpion(int $idInscripcion){
            $idInscripcion = $idInscripcion;
            $sql = "SELECT ins.folio_impreso,plnes.nombre_carrera,plnes.id AS id_plan_estudio,orgpl.nombre_plan,
            plnes.duracion_carrera,peralum.nombre_persona,peralum.ap_paterno,peralum.ap_materno,peralum.direccion,
            peralum.colonia,peralum.tel_celular AS tel_celular_alumno,peralum.tel_fijo AS tel_fijo_alumno,peralum.email AS email_alumno,
            loc.nombre AS localidad,mun.nombre AS municipio,est.nombre AS estado,tut.nombre_tutor,
            tut.appat_tutor,tut.apmat_tutor,tut.tel_celular AS tel_celular_tutor,tut.tel_fijo AS tel_fijo_tutor,
            tut.email AS email_tutor,sis.nombre_sistema,inst.nombre_institucion,inst.categoria,
            inst.cve_centro_trabajo,CONCAT(plntel.domicilio,',',plntel.localidad,',',plntel.municipio,',',plntel.estado) AS ubicacion,
            ins.id_grados,grad.nombre_grado,tur.hora_entrada,tur.hora_salida,peralum.nombre_empresa,grad.numero_natural,te.nombre_escolaridad
            FROM t_inscripciones AS ins 
            INNER JOIN t_plan_estudios AS plnes ON ins.id_plan_estudios = plnes.id
            iNNER JOIN t_instituciones AS inst ON plnes.id_instituciones = inst.id
            INNER JOIN t_planteles AS plntel ON inst.id_planteles = plntel.id
            INNER JOIN t_sistemas_educativos AS sis ON inst.id_sistemas_educativos = sis.id
            INNER JOIN t_organizacion_planes AS orgpl ON plnes.id_organizacion_planes = orgpl.id
            INNER JOIN t_personas AS peralum ON ins.id_personas = peralum.id
            INNER JOIN t_tutores AS tut ON ins.id_tutores = tut.id
            INNER JOIN t_localidades AS loc ON peralum.id_localidad = loc.id
            INNER JOIN t_municipios AS mun ON loc.id_municipio = mun.id
            INNER JOIN t_estados AS est ON mun.id_estados = est.id
            LEFT JOIN t_grados AS grad ON ins.id_grados = grad.id
            LEFT JOIN t_escolaridad AS te ON peralum.id_escolaridad = te.id
            INNER JOIN t_turnos AS tur ON ins.id_turnos = tur.id
            WHERE ins.id = $idInscripcion LIMIT 1";
            $request = $this->select($sql);
            return $request;
        }
        //Obtener lista de documentacion por el Plan de Estudios
        public function selectDocumentacionInscripcion(int $idPlanEstudios){
            $idPlanEstudios = $idPlanEstudios;
            $sql = "SELECT dest.tipo_documento FROM t_plan_estudios AS plnest 
            INNER JOIN t_nivel_educativos AS nivel ON plnest.id_nivel_educativos = nivel.id 
            INNER JOIN t_documentos AS doc ON doc.id_nivel_educativo = nivel.id
            INNER JOIN t_detalle_documentos AS dest ON dest.id_documentos = doc.id
            WHERE plnest.id = $idPlanEstudios";
            $request = $this->select_all($sql);
            return $request;
        }
        public function updateEstatusHistorial(int $idInscripcion,int $idUser){
            $sqlHistorial = "SELECT id_historial FROM t_inscripciones AS i
            INNER JOIN t_historiales AS h ON i.id_historial = h.id
            WHERE i.id = $idInscripcion AND i.estatus = 1 LIMIT 1";
            $requestHistorial = $this->select($sqlHistorial);
            if($requestHistorial){
                $idHistorial = $requestHistorial['id_historial'];
                $sql = "UPDATE t_historiales SET inscrito = ?,cancelado = ?,fecha_cancelado = NOW(),id_usuario_actualizacion = ?,fecha_actualizacion = NOW() WHERE id= $idHistorial";
                $request = $this->update($sql,array(0,1,$idUser));
            }
            return $request;
        }
        public function updatePosponerInscripcion(int $idInscripcion,int $idUser){
            $sqlHistorial = "SELECT id_historial FROM t_inscripciones AS i
            INNER JOIN t_historiales AS h ON i.id_historial = h.id
            WHERE i.id = $idInscripcion LIMIT 1";
            $requestHistorial = $this->select($sqlHistorial);
            if($requestHistorial){
                $idHistorial = $requestHistorial['id_historial'];
                $sql = "UPDATE t_historiales SET inscrito = ?,pospuesto = ?,fecha_pospuesto = NOW(),id_usuario_actualizacion = ?,fecha_actualizacion = NOW() WHERE id= $idHistorial";
                $request = $this->update($sql,array(0,1,$idUser));
            }
            return $request;
        }
        public function updateSubcampaniaInscripcion($idInscripcion,$idSubcampania,$idUser)
        {
            $sqlUpInscripcion = "UPDATE t_inscripciones SET id_subcampanias = ?,fecha_actualizacion = NOW(),id_usuario_actualizacion = ? WHERE id = $idInscripcion";
            $requestUpInscripcion = $this->update($sqlUpInscripcion,array($idSubcampania,$idUser));
            return $requestUpInscripcion;
        }

        public function selectProspecto(int $idPersona){
            $sql = "SELECT *FROM t_prospectos WHERE id_personas = $idPersona LIMIT 1";
            $request = $this->select($sql );
            return $request;
        }
        public function selectSistemasEducativos()
        {
            $sql = "SELECT *FROM t_sistemas_educativos WHERE estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectFolioPlantel($idPlantel){
            $sql = "SELECT folio_identificador FROM t_planteles WHERE id= $idPlantel";
            $request = $this->select($sql);
            return $request;
        }
        public function selectPromocionesColegiatura(int $idPlanEstudio)
        {
            $sql = "SELECT tp.id,ts.nombre_servicio,tcs.nombre_categoria,ts.codigo_servicio,tcs.clave_categoria,tpr.nombre_promocion,
            tpr.porcentaje_descuento,ts.id AS id_servicio,tp.cobro_total,tins.abreviacion_institucion,plant.nombre_plantel_fisico FROM t_precarga AS tp 
            INNER JOIN t_servicios AS ts ON tp.id_servicios = ts.id
            INNER JOIN t_promociones AS tpr ON tpr.id_servicios = ts.id 
            INNER JOIN t_categoria_servicios AS tcs ON ts.id_categoria_servicios = tcs.id
            INNER JOIN t_instituciones  AS tins ON ts.id_instituciones = tins.id
            INNER JOIN t_planteles AS plant ON tins.id_planteles = plant.id
            WHERE ts.codigo_servicio LIKE '%COL%' AND tp.id_plan_estudios = $idPlanEstudio";

            /* $sql = "SELECT tp.id,tp.nombre_promocion,tp.porcentaje_descuento,ts.precio_unitario FROM t_promociones AS tp
            INNER JOIN t_servicios AS ts ON tp.id_servicios = ts.id 
            WHERE ts.codigo_servicio LIKE '%COL%'"; */
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectPlanEstudio(int $idPlanEstudio)
        {
            $sql = "SELECT *FROM t_plan_estudios as tpe WHERE tpe.id = $idPlanEstudio LIMIT 1";
            $request = $this->select($sql);
            return $request; 
        }


        public function selectPromocionesInscripcion()
        {
            $sql = "SELECT ts.id ,ts.nombre_servicio,tcs.nombre_categoria,ts.codigo_servicio ,tcs.clave_categoria,
            tp.nombre_promocion,tp.porcentaje_descuento,tins.abreviacion_institucion,plant.nombre_plantel_fisico,
            ts.precio_unitario FROM t_promociones AS tp 
            INNER JOIN t_servicios AS ts ON tp.id_servicios = ts.id
            INNER JOIN t_categoria_servicios AS tcs ON ts.id_categoria_servicios = tcs.id
            INNER JOIN t_instituciones  AS tins ON ts.id_instituciones = tins.id
            INNER JOIN t_planteles AS plant ON tins.id_planteles = plant.id
            WHERE ts.codigo_servicio LIKE '%INS'";
            $request = $this->select_all($sql);
            return $request;
        }

        public function insertIngresos($estatus,$total,$idUser,$idPlantel)
        {
           $sql = "INSERT INTO t_ingresos
            (estatus, total, fecha_creacion, id_usuario_creacion, id_planteles)
            VALUES(?, ?, NOW(), ?, ?)";
            $request = $this->insert($sql,array($estatus,$total,$idUser,$idPlantel));
            return $request;
        }
        public function insertIngresoDetalle($descuentoDinero,$descuentoPorcentaje,$idIngreso,$idPrecargaCol,$idServicioCol,$idPrecargaIns,$idServicioIns)
        {
            $sqlColegiatura = "INSERT INTO t_ingresos_detalles
            (cantidad, cargo, precio_subtotal, descuento_dinero, descuento_porcentaje, id_servicios, id_ingresos, id_precarga)
            VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
            $requestColegiatura = $this->insert($sqlColegiatura,array(1,200,200,$descuentoDinero,$descuentoPorcentaje,$idServicioCol,$idIngreso,$idPrecargaCol));

            $sqlInscripcion = "INSERT INTO t_ingresos_detalles
            (cantidad, cargo, precio_subtotal, descuento_dinero, descuento_porcentaje, id_servicios, id_ingresos, id_precarga)
            VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
            $requestInscirpcion = $this->insert($sqlInscripcion,array(1,200,200,$descuentoDinero,$descuentoPorcentaje,$idServicioIns,$idIngreso,$idPrecargaIns));
            
            return $requestInscirpcion;
        }

        public function insertTempInscripcion($folioInscripcion,$precioIns,$porcentajeIns,$totalIns,$precioCol,$porcentajeCol,$totalCol,int $idPersona,int $idInscripcion,
        $idServCol,$idServIns)
        {
            $sql = "INSERT INTO t_tmpInscripciones(folio_inscripcion, precio_inscripcion, porcentaje_descuento_insc, total_descuento_insc, precio_colegiatura, porcentaje_descuento_coleg, total_descuento_coleg, id_persona, id_inscripcion, id_servicio_inscripcion,id_servicio_colegiatura) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)";
            $request = $this->insert($sql,array($folioInscripcion, $precioIns, $porcentajeIns, $totalIns, $precioCol, $porcentajeCol, $totalCol, $idPersona, $idInscripcion,$idServIns,$idServCol));
            return $request;
        }

        public function updateEstatusInscripcion(int $idInscripcion, int $idUser)
        {
            $sqlUpdateInscripcion = "UPDATE t_inscripciones SET estatus = ?,fecha_actualizacion = NOW(), id_usuario_actualizacion = ? WHERE id = ?";
            $requestUpdateInscripcion = $this->update($sqlUpdateInscripcion,array(2,$idUser,$idInscripcion));
            return $requestUpdateInscripcion;
        }
        public function updateAsignacionCategoriaPersona(int $idPersona,int $idUser)
        {
            $sqlUpCatEstudiante = "UPDATE t_asignacion_categoria_persona  SET estatus = ?,fecha_actualizacion = NOW(),id_usuario_actualizacion = ? WHERE
            id_personas = ? AND id_categoria_persona = 2";
            $requestCatEstudiante = $this->update($sqlUpCatEstudiante,array(2,$idUser,$idPersona));
            $sqlUpCatProspecto = "UPDATE t_asignacion_categoria_persona SET estatus = ?,fecha_actualizacion = NOW(),id_usuario_actualizacion = ? WHERE
            id_personas = ? AND id_categoria_persona = 1";
            $requestCatProspecto = $this->update($sqlUpCatProspecto,array(1,$idUser,$idPersona));
            return $requestCatProspecto;
        }



    }
?>