<?php

class SeguimientoModel extends Mysql{

    public $intIdPers;
    public $intIdPros;
    public $strNombrePers; //$strNombreP
    public $strApePat; //$strApellidoPaP
    public $strApeMat; //$strApellidoMaP
    public $strTelCel; //$strTelcelP
    public $strEmail; //$strEmailP
    public $intIdNvlCarrInte; //$intNivelEstudiosInteresP
    public $intIdCarrInte; //$intCarreaInteresP
    public $strPltInteres; //$intPlantelInteresP
    public $strPltProspectado;
    public $intCatPer; //$intIdCategoriaPersona
    public $intNotificacion;
    public $intEstatus;
    public $intRespRap;
    public $strComentario;
    public $intIdUsuario; //$intIdUsuarioCreacion - //$intIdUsuarioActualizacion
    public $strOcupacion; //$strOcupacionP
    public $strEstadoCivil; //$strEstadoCivilP
    public $strSexo; //$strSexoP
    public $intEdad; //$intEdad
    public $intEstado; //$intEstadoP
    public $intMunicipio; //$intMunicipioP
    public $intLocalidad; //$intLocalidadP
    public $strDireccion;//$strDireccionP
    public $strColonia; //$strColoniaP
    public $intCodigoPostal; //$intCpP
    public $strTelfijo; //$strTelFiP
    public $strPlantelProcedencia; //$strPlantelProcedenciaP
    public $intMedioCaptacion;
    public $strAlias;
    public $strFechaNacimiento;
    public $intEscolaridad;
    public $intIdSubcampania;


    public function __construct(){
        parent::__construct();
    }

    public function selectMedioCaptacion()
    {
        $sql = "SELECT * FROM t_medios_captacion";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectPlanteles(){
        $sql = "SELECT id, nombre_plantel_fisico FROM t_planteles";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectNivelInteres(){
        $sql = "SELECT id, nombre_nivel_educativo FROM t_nivel_educativos";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectCarreraInteres()
    {
        $sql = "SELECT id, nombre_carrera FROM t_carrera_interes";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectCarrera(int $idNivel){
        $idNvl = $idNivel;
        $sql = "SELECT id, nombre_carrera FROM t_carrera_interes WHERE id_nivel_educativo = $idNvl";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectProspectos(){
        $sql = "SELECT pe.id, CONCAT(pe.nombre_persona, ' ', pe.ap_paterno, ' ', pe.ap_materno) as nombre_completo, 
        cat.nombre_categoria, pe.alias, pe.tel_celular, plt.nombre_plantel_fisico, crr.nombre_carrera, med.medio_captacion
        FROM t_personas as pe
        INNER JOIN t_asignacion_categoria_persona as asig ON pe.id = asig.id_personas
        INNER JOIN t_categoria_personas as cat ON asig.id_categoria_persona = cat.id
        INNER JOIN t_prospectos as pro ON pe.id = pro.id_personas 
        INNER JOIN t_planteles as plt ON pro.id_plantel_interes = plt.id 
        INNER JOIN t_carrera_interes as crr ON pro.id_carrera_interes = crr.id 
        INNER JOIN t_medios_captacion as med ON pro.id_medios_captacion = med.id
        WHERE pe.estatus != 0 AND asig.id_categoria_persona = 1 OR asig.id_categoria_persona = 5
        ORDER BY pe.id DESC";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectPlantelInteres(int $id)
    {
        $this->intIdPltInte = $id;
        $sql = "SELECT id, nombre_carrera FROM t_carrera_interes WHERE id_nivel_carrera = $this->intIdPltInte";
        $request = $this->select($sql);
        return $request;
    }

    public function selectProspecto(int $id){
        $this->intIdPers = $id;
        $sql = "SELECT per.id as per_id, per.nombre_persona, per.ap_paterno, per.ap_materno,
        per.tel_celular,
        per.email,
        pro.id_plantel_interes,
        pro.id_nivel_carrera_interes,
        pro.id_carrera_interes,
        pro.id as pro_id
        FROM t_personas as per
        INNER JOIN t_prospectos AS pro ON pro.id_personas = per.id
        WHERE per.id = $this->intIdPers";
        $request = $this->select($sql);
        return $request;
    }

    public function updatePersona(string $nombre, string $apPat, string $apMat, string $tel_celular, string $email, int $pltInteres, int $nvlInteres, int $carrInteres, int $idPro, int $idPer)
    {
        $this->strNombrePers = $nombre;
        $this->strApePat = $apPat;
        $this->strApeMat = $apMat;
        $this->strTelCel = $tel_celular;
        $this->strEmail = $email;
        $this->intIdPltInte = $pltInteres;
        $this->intIdNvlCarrInte = $nvlInteres;
        $this->intIdCarrInte = $carrInteres;
        $this->intIdUsuario = $_SESSION['idUser'];
        $this->intIdPers = $idPer;
        $this->intIdPros = $idPro;
        $request;
        $sql = "UPDATE t_personas SET nombre_persona = ?, ap_paterno = ?, ap_materno = ?, tel_celular = ?, email = ?, fecha_actualizacion = NOW(), id_usuario_actualizacion = ? WHERE id=$this->intIdPers";
        $sql2 = "UPDATE t_prospectos SET id_nivel_carrera_interes = ?, id_plantel_interes = ?, id_carrera_interes = ? WHERE id=$this->intIdPros";
        $arrData = array($this->strNombrePers, $this->strApePat, $this->strApeMat, $this->strTelCel, $this->strEmail, $this->intIdUsuario);
        $arrData2 = array($this->intIdNvlCarrInte, $this->intIdPltInte, $this->intIdCarrInte);
        $rquestUpdate = $this->update($sql,$arrData);
        $requestUpdate2 = $this->update($sql2, $arrData2);
        $request['estatus'] = TRUE;
        return $request;
    }

    public function insertAgendaProspecto(int $idPersona, int $idUsuarioAtendidoAgenda, string $fechaPrograma, string $fechaRegistro, string $horaActualizacion, string $AsuntoLlamada, string $detalleLlamada){
        $request = "";
        $this->intIdPers = $idPersona;
        $this->intIdUsuarioAtendio = $idUsuarioAtendidoAgenda;
        $this->strFechaProgramada = $fechaPrograma;
        $this->strFechaRegistro = $fechaRegistro;
        $this->strHoraProgramada = $horaActualizacion;
        $this->strAsunto = $AsuntoLlamada;
        $this->intNotificacion = 0;
        $this->intEstatus = 1;
        $this->strDetalle = $detalleLlamada;
        $sql = "INSERT INTO t_agenda(fecha_registro, fecha_programada, hora_programada, asunto, detalle, notificacion, estatus, id_usuario_atendio, id_personas) VALUES(?,?,?,?,?,?,?,?,?)";
        $arrData = array($this->strFechaRegistro, $this->strFechaProgramada, $this->strHoraProgramada, $this->strAsunto, $this->strDetalle,$this->intNotificacion, $this->intEstatus, $this->intIdUsuarioAtendio, $this->intIdPers);
        $request = $this->insert($sql, $arrData);
        return $request;
    }

    public function selectEgresado(int $idCatPer, int $idPers)
    {
        $this->intIdCatPer = $idCatPer;
        $this->intIdPers = $idPers;
        $sql = "SELECT per.id, per.nombre_persona, per.ap_paterno, per.ap_materno, crr.nombre_carrera, per.nombre_empresa,
        avg(ins.promedio), plan.nombre_carrera
        FROM t_personas as per
        INNER JOIN t_carrera_interes as crr
        ON per.id_carrera_interes = crr.id
        INNER JOIN t_inscripciones as ins
        ON per.id = ins.id_personas
        INNER JOIN t_plan_estudios as plan
        ON ins.id_plan_estudios = plan.id
        WHERE id_categoria_persona = $this->intIdCarPer
        AND ins.id_personas = $this->intIdPers
        AND ins.tipo_ingreso = 'Reinscripcion'";
        $request = $this->select($sql);
        return $request;
    }

    public function selectPersonaSeguimiento(int $idPer)
    {
        $this->intIdPers = $idPer;
        $sql = "SELECT pe.id, CONCAT(pe.nombre_persona, ' ',pe.ap_paterno, ' ', pe.ap_materno) AS nombre_persona, pe.tel_celular,
        pe.email, mun.nombre AS municipio, est.nombre AS estado, CONCAT(pe2.nombre_persona, ' ', pe2.ap_paterno, ' ', pe2.ap_materno) as nombre_comisionista, pe2.tel_celular as tel_comisionista, pe.fecha_creacion, med.medio_captacion, nvl.nombre_nivel_educativo, crr.nombre_carrera, pros.id as id_pro
        FROM t_personas AS pe
        INNER JOIN t_localidades AS loc ON pe.id_localidad = loc.id
        INNER JOIN t_municipios AS mun ON loc.id_municipio = mun.id
        INNER JOIN t_estados AS est ON mun.id_estados = est.id
        INNER JOIN t_prospectos AS pros ON pros.id_personas = pe.id
        INNER JOIN t_personas AS pe2 ON pe.id_usuario_creacion = pe2.id
        INNER JOIN t_medios_captacion AS med ON pros.id_medios_captacion = med.id
        INNER JOIN t_nivel_educativos AS nvl ON pros.id_nivel_carrera_interes = nvl.id
        LEFT JOIN t_carrera_interes AS crr ON pros.id_carrera_interes = crr.id
        WHERE pe.id = $this->intIdPers";
        $request = $this->select($sql);
        return $request;
    }

    public function insertSeguimientoProspectoInd(int $respuesta_rap, string $comentario, int $idPros)
    {
        $this->intRespRap = $respuesta_rap;
        $this->strComentario = $comentario;
        $this->intIdPros = $idPros;
        $this->intIdUsuario = $_SESSION['idUser'];
        $sql = "INSERT INTO t_seguimiento_prospecto(fecha_de_seguimiento,comentario,id_usuario_atendio,id_respuesta_rapida,id_prospectos) VALUES (NOW(), ?, ?, ? ,?)";
        $arrData = array($this->strComentario, $this->intIdUsuario, $this->intRespRap, $this->intIdPros);
        $request = $this->insert($sql,$arrData);
        return $request;
    }


    public function selectSeguimientoProspecto(int $idPer){
        $this->intIdPers = $idPer;
        $sql = "SELECT DATE_FORMAT(sp.fecha_de_seguimiento,'%d-%m-%Y') AS fecha_de_seguimiento, sp.comentario, CONCAT(per2.nombre_persona, ' ', per2.ap_paterno,' ', per2.ap_materno) as nombre_asesor, resp.respuesta_rapida
        FROM t_seguimiento_prospecto AS sp
        LEFT JOIN t_prospectos AS p ON sp.id_prospectos = p.id
        INNER JOIN t_personas AS per ON p.id_personas = per.id
        INNER JOIN t_respuesta_rapida as resp ON sp.id_respuesta_rapida = resp.id
        INNER JOIN t_personas as per2 ON sp.id_usuario_atendio = per2.id
        WHERE per.id = $this->intIdPers
        ORDER BY fecha_de_seguimiento DESC;";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectRespuestasRapidas(){
        $sql = "SELECT * FROM t_respuesta_rapida";
        $request = $this->select_all($sql);
        return $request;
    }

    public function insertProspecto(string $nom, string $apeP, string $apeM, string $ali, string $edo_civil, string $ocup, string $fecha_nac, int $escol, int $ed, string $sex, int $loc, string $telc, string $telf, string $correo, string $plantProc, string $plantInt, string $plntPros, int $nivelInt, int $carrInt, int $med, string $coment, int $idSub)
    {
        $this->strNombrePers = $nom;
        $this->strApePat = $apeP;
        $this->strApeMat = $apeM;
        $this->strAlias = $ali;
        $this->strEstadoCivil = $edo_civil;
        $this->strOcupacion = $ocup;
        $this->strFechaNacimiento = $fecha_nac;
        $this->intEscolaridad = $escol;
        $this->intEdad = $ed;
        $this->strSexo = $sex;
        $this->intLocalidad = $loc;
        $this->strTelCel = $telc;
        $this->strTelfijo = $telf;
        $this->strEmail = $correo;
        $this->strPltInteres = $plantInt;
        $this->strPltProspectado = $plntPros;
        $this->strPlantelProcedencia = $plantProc;
        $this->intIdNvlCarrInte = $nivelInt;
        $this->intIdCarrInte = $carrInt;
        $this->intMedioCaptacion = $med;
        $this->strComentario = $coment;
        $this->intIdUsuario = $_SESSION['idUser'];
        $this->intIdSubcampania = $idSub;

        $sqlPersona = "INSERT INTO t_personas(nombre_persona, ap_paterno, ap_materno, sexo, alias, edad, edo_civil, ocupacion, id_escolaridad,fecha_nacimiento, estatus, id_localidad, tel_celular, tel_fijo, email, fecha_creacion, id_usuario_creacion) 
        VALUES(?,?,?,?,?,?,?,?,?,?,1,?,?,?,?,NOW(),?)";
        $arrPersona = array($this->strNombrePers,$this->strApePat,$this->strApeMat,$this->strSexo,$this->strAlias, $this->intEdad,$this->strEstadoCivil, $this->strOcupacion, $this->intEscolaridad,$this->strFechaNacimiento,$this->intLocalidad,$this->strTelCel,$this->strTelfijo, $this->strEmail,$this->intIdUsuario);
        $requestPersona = $this->insert($sqlPersona,$arrPersona);
        if($requestPersona)
        {
            $idPersona = $requestPersona;
            $sqlAsignacion = "INSERT INTO t_asignacion_categoria_persona(fecha_alta,validacion_datos_personales,validacion_doctos,estatus,fecha_creacion,id_usuario_creacion,id_persona,id_categoria_persona) values(NOW(),0,0,1,NOW(),?,?,1)";
            $arrDataAsig = array($this->intIdUsuario, $idPersona);
            $requestAsig = $this->insert($sqlAsignacion,$arrDataAsig);
            if($requestAsig)
            {
                $sqlProspecto = "INSERT INTO t_prospectos(escuela_procedencia,observaciones, id_plantel_interes,id_nivel_carrera_interes,id_carrera_interes,id_medios_captacion,id_persona) VALUES(?,?,?,?,?,?,?)";
                $arrDataProspecto = array($this->strPlantelProcedencia, $this->strComentario, $this->strPltInteres, $this->intIdNvlCarrInte, $this->intIdCarrInte, $this->intMedioCaptacion, $idPersona);
                $requestProspecto = $this->insert($sqlProspecto,$arrDataProspecto);
            }
        }
        return $requestProspecto;
    }

    

    public function selectEstados(){

        $sql = "SELECT * FROM t_estados";
        $request = $this->select_all($sql);
        return $request;

    }

    public function selectMunicipios(int $idEstado){

        $idEstado = $idEstado;
        $sql = "SELECT *FROM t_municipios WHERE id_estados = $idEstado";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectLocalidades($idMunicipio){

        $idMunicipio = $idMunicipio;
        $sql = "SELECT *FROM t_localidades WHERE id_municipio = $idMunicipio";
        $request = $this->select_all($sql);
        return $request;

    }

    public function selectEscolaridad(){
        $sql = "SELECT id, nombre_escolaridad FROM t_escolaridad";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectCampania(){

        $sql = "SELECT id, nombre_campania FROM t_campanias WHERE id = (SELECT MAX(id) from t_campanias)";
        $request = $this->select_all($sql);
        return $request;

    }

    public function selectSubcampania(){
        $sql = "SELECT * FROM t_subcampania WHERE estatus = 1 ORDER BY fecha_fin DESC LIMIT 1";
        $request = $this->select($sql);
        return $request;
    }

}
