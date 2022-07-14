<?php
	class ReinscripcionModel extends Mysql
	{
		public function __construct()
		{
			parent::__construct();
		}

        //Obtener datos persona
        public function selectPersonasModal($data){
            $sql = "SELECT per.id,per.nombre_persona,per.ap_paterno,per.ap_materno,
            ins.id AS id_inscripcion,pln.nombre_carrera,ins.id_grados,tgr.numero_natural AS grado,ins.id_salones_compuesto,gr.nombre_grupo FROM t_personas AS per
            LEFT JOIN t_inscripciones AS ins ON ins.id_personas = per.id
            LEFT JOIN t_historiales AS his ON ins.id_historial = his.id
            INNER JOIN t_plan_estudios AS pln ON ins.id_plan_estudios = pln.id
            INNER JOIN t_salones_compuesto AS sal ON ins.id_salones_compuesto = sal.id
            INNER JOIN t_grupos AS gr ON sal.id_grupos = gr.id
            INNER JOIN t_grados AS tgr ON ins.id_grados = tgr.id
            WHERE CONCAT(per.nombre_persona,' ',per.ap_paterno,' ',per.ap_materno) LIKE '%$data%' AND ins.tipo_ingreso = 'Inscripcion' AND ins.estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectDatosAlumno(int $idAlumno){
            $sql = "SELECT p.id,p.nombre_persona,p.ap_paterno,p.ap_materno,
            i.id AS id_inscripcion,i.id_plan_estudios,pe.nombre_carrera,pe.id_instituciones,ti.id_planteles,pln.nombre_plantel_fisico,i.id_grados,i.id_salones_compuesto,
            sc.id_salones,sc.id_periodos,per.nombre_periodo,per.id_ciclos,c.nombre_ciclo,c.id_generaciones,g.nombre_generacion,p.estatus,
            tg.numero_natural,tgr.nombre_grupo,i.id_turnos,i.id_tutores,i.id_documentos,i.id_subcampanias,i.id_historial FROM t_personas AS p
            INNER JOIN t_inscripciones AS i ON i.id_personas = p.id
            INNER JOIN t_plan_estudios AS pe ON i.id_plan_estudios = pe.id
            INNER JOIN t_instituciones AS ti ON pe.id_instituciones = ti.id
            INNER JOIN t_planteles AS pln ON ti.id_planteles = pln.id
            INNER JOIN t_salones_compuesto AS sc ON i.id_salones_compuesto = sc.id
            INNER JOIN t_periodos AS per ON sc.id_periodos = per.id
            INNER JOIN t_ciclos AS c ON per.id_ciclos = c.id
            INNER JOIN t_grados AS tg ON sc.id_grados = tg.id
            INNER JOIN t_grupos AS tgr ON sc.id_grupos = tgr.id
            INNER JOIN t_generaciones AS g ON c.id_generaciones = g.id
            WHERE p.id =$idAlumno";
            $request = $this->select($sql);
            return $request;
        }

        public function selectCiclos(){
            $sql = "SELECT *FROM t_ciclos WHERE estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectPeriodo(){
            $sql = "SELECT *FROM t_periodos WHERE estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectGrado(){
            $sql = "SELECT *FROM t_grados WHERE estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectGrupo(){
            $sql = "SELECT *FROM t_grupos WHERE estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectSalonesCompuestos()
        {
            $sql = "SELECT tsc.id,tsc.nombre_salon_compuesto,tp.nombre_periodo,
            tg.nombre_grado,tgr.nombre_grupo,tt.nombre_turno,ts.nombre_salon,tg.numero_natural,CONCAT(tsc.id,',',tgr.nombre_grupo,',',tg.numero_natural,',',tsc.id_turnos,',',tg.id) AS valuecomp FROM t_salones_compuesto AS tsc
            INNER JOIN t_periodos AS tp ON tsc.id_periodos = tp.id
            INNER JOIN t_grados AS tg ON tsc.id_grados = tg.id
            INNER JOIN t_grupos AS tgr ON tsc.id_grupos = tgr.id
            INNER JOIN t_turnos AS tt ON tsc.id_turnos = tt.id
            INNER JOIN t_salones AS ts ON tsc.id_salones = ts.id
            WHERE tsc.estatus = 1";
            $request = $this->select_all($sql);
            return $request;
        }
        
        public function insertReinscripcion(string $folio,int $idUser,int $idTurno, int $idPlanEstudio,int $idPersona,int $idTutor,int $idDocumentos,int $idSubcampania,int $idSalonCompuesto,int $idHistorial,int $idGrado)
        {
            $sql = "INSERT INTO t_inscripciones(folio_impreso,folio_sistema,tipo_ingreso,promedio,estatus,fecha_creacion,id_usuario_creacion,id_turnos,id_plan_estudios,id_personas,id_tutores,id_documentos,id_subcampanias,id_salones_compuesto,id_historial,id_grados) VALUES(?,?,?,?,?,NOW(),?,?,?,?,?,?,?,?,?,?)";
            $request = $this->update($sql,array($folio,$folio,"Reinscripcion",8,1,$idUser,$idTurno,$idPlanEstudio,$idPersona,$idTutor,$idDocumentos,$idSubcampania,$idSalonCompuesto,$idHistorial,$idGrado));
            return $request;
        }

        public function selectFolioPlantel(int $idPlantel)
        {
            $sql = "SELECT folio_identificador FROM t_planteles WHERE id= $idPlantel";
            $request = $this->select($sql);
            return $request;
        }
        public function selectCountInscripciones($sigla)
        {
            $sql_folio_sistema = "SELECT COUNT(*) AS total FROM t_inscripciones WHERE folio_sistema LIKE '%$sigla%'";
            $request_folio_sistema = $this->select($sql_folio_sistema);
            return $request_folio_sistema;
        }
        public function selectReinscripciones()
        {
            $sql = "SELECT tp.id AS id_plantel,tp.nombre_plantel_fisico,tin.id AS id_institucion,tin.nombre_institucion,
            tg.id AS id_grado,tg.numero_natural,tgr.id AS id_grupo,tgr.nombre_grupo,tpe.nombre_carrera, COUNT(*) AS total FROM t_inscripciones AS ti
            INNER JOIN t_plan_estudios AS tpe ON ti.id_plan_estudios = tpe.id
            INNER JOIN t_instituciones AS tin ON tpe.id_instituciones = tin.id
            INNER JOIN t_planteles AS tp ON tin.id_planteles = tp.id
            INNER JOIN t_salones_compuesto AS tsc ON ti.id_salones_compuesto = tsc.id
            INNER JOIN t_grados AS tg ON tsc.id_grados = tg.id
            INNER JOIN t_grupos AS tgr ON tsc.id_grupos = tgr.id
            WHERE ti.tipo_ingreso = 'Reinscripcion' AND ti.estatus = 1
            GROUP BY tp.id,tin.id,tg.id,tgr.id,tpe.id HAVING COUNT(*)>=1";
            $request = $this->select_all($sql);
            return $request;
        }
        public function selectInscripciones()
        {
            $sql = "SELECT tp.id AS id_plantel,tp.nombre_plantel_fisico,tin.id AS id_institucion,tin.nombre_institucion,
            tg.id AS id_grado,tg.numero_natural,tgr.id AS id_grupo,tgr.nombre_grupo,tpe.nombre_carrera,CONCAT(tp.id,',',tin.id,',',tpe.id,',',tg.id,',',tgr.id) AS values_select, COUNT(*) AS total FROM t_inscripciones AS ti
            INNER JOIN t_plan_estudios AS tpe ON ti.id_plan_estudios = tpe.id
            INNER JOIN t_instituciones AS tin ON tpe.id_instituciones = tin.id
            INNER JOIN t_planteles AS tp ON tin.id_planteles = tp.id
            INNER JOIN t_salones_compuesto AS tsc ON ti.id_salones_compuesto = tsc.id
            INNER JOIN t_grados AS tg ON tsc.id_grados = tg.id
            INNER JOIN t_grupos AS tgr ON tsc.id_grupos = tgr.id
            WHERE ti.tipo_ingreso = 'Inscripcion' AND ti.estatus = 1
            GROUP BY tp.id,tin.id,tg.id,tgr.id,tpe.id HAVING COUNT(*)>=1";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectAlumnosInscritos(int $idPlantel,int $idInstitucion,int $idPlanEstudio,int $idGrado,int $idGrupo)
        {
            $sql = "SELECT ti.id,ti.promedio,tg.numero_natural,tgr.nombre_grupo,ti.id_personas,ti.id_tutores,ti.id_documentos,ti.id_subcampanias,ti.id_historial,
            tper.nombre_persona,tper.ap_paterno,tper.ap_materno  FROM t_inscripciones AS ti
                        INNER JOIN t_plan_estudios AS tpe ON ti.id_plan_estudios = tpe.id
                        INNER JOIN t_instituciones AS tins ON tpe.id_instituciones = tins.id
                        INNER JOIN t_planteles AS tp ON tins.id_planteles = tp.id
                        INNER JOIN t_personas AS tper ON ti.id_personas = tper.id
                        INNER JOIN t_salones_compuesto AS tsc ON ti.id_salones_compuesto = tsc.id
                        INNER JOIN t_grados AS tg ON tsc.id_grados = tg.id
                        INNER JOIN t_grupos AS tgr ON tsc.id_grupos = tgr.id 
            WHERE ti.tipo_ingreso = 'Inscripcion' AND ti.estatus = 1 AND tp.id = $idPlantel AND tins.id = $idInstitucion AND tpe.id = $idPlanEstudio AND tg.id = $idGrado AND tgr.id = $idGrupo";
            $request = $this->select_all($sql);
            return $request;
        }

        public function updateInscripcionEstatus(int $idInscripcion,$idUser)
        {
            $sql = "UPDATE t_inscripciones SET estatus = ?,fecha_actualizacion = NOW(),id_usuario_actualizacion = ? WHERE id = $idInscripcion";
            $request = $this->update($sql,array(2,$idUser));
            return $request;
        }

        public function selectListaAlumnosInscritos(int $idPlanEstudio,int $idGrado,int $idGrupo)
        {
            $sql = "SELECT ti.id,tper.nombre_persona,tper.ap_paterno,tper.ap_materno FROM t_inscripciones AS ti 
            INNER JOIN t_personas AS tper ON ti.id_personas = tper.id
            INNER JOIN t_salones_compuesto AS tsc ON ti.id_salones_compuesto = tsc.id
            WHERE  ti.estatus = 1 AND ti.id_plan_estudios = $idPlanEstudio AND tsc.id_grados = $idGrado AND tsc.id_grupos = $idGrupo";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectDatosImprimirSolInscricpion(int $idInscripcion){
            $idInscripcion = $idInscripcion;
            $sql = "SELECT ins.folio_impreso,plnes.nombre_carrera,plnes.id AS id_plan_estudio,orgpl.nombre_plan,
            plnes.duracion_carrera,peralum.nombre_persona,peralum.ap_paterno,peralum.ap_materno,peralum.direccion,
            peralum.colonia,peralum.tel_celular AS tel_celular_alumno,peralum.tel_fijo AS tel_fijo_alumno,peralum.email AS email_alumno,
            loc.nombre AS localidad,mun.nombre AS municipio,est.nombre AS estado,tut.nombre_tutor,
            tut.appat_tutor,tut.apmat_tutor,tut.tel_celular AS tel_celular_tutor,tut.tel_fijo AS tel_fijo_tutor,
            tut.email AS email_tutor,sis.nombre_sistema,inst.nombre_institucion,inst.categoria,
            inst.cve_centro_trabajo,CONCAT(plntel.domicilio,',',plntel.localidad,',',plntel.municipio,',',plntel.estado) AS ubicacion,
            ins.id_grados,grad.nombre_grado,tur.hora_entrada,tur.hora_salida,peralum.nombre_empresa
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
            INNER JOIN t_turnos AS tur ON ins.id_turnos = tur.id
            WHERE ins.id = $idInscripcion LIMIT 1";
            $request = $this->select($sql);
            return $request;
        }
	}
?>