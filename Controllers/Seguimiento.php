<?php
class Seguimiento extends Controllers{
	public function __construct()
	{
		parent::__construct();
        session_start();
        if(empty($_SESSION['login'])){
            header('Location: '.base_url().'/login');
            die();
        }
	}

    public function seguimiento_prospectos()
    {
        $data['page_tag'] = "Seguimiento de prospección";
        $data['page_title'] = "Seguimiento de prospección";
        $data['page_functions_js'] = "functions_SegProspectos.js";
        $data['planteles'] = $this->model->selectPlanteles();
        $data['escolaridad'] = $this->model->selectEscolaridad();
        $data['nivel_estudios_interes'] = $this->model->selectNivelInteres();
        $data['carrera_interes'] = $this->model->selectCarreraInteres();
        $data['estados'] = $this->model->selectEstados();
        $this->views->getView($this,"seguimiento_prospectos",$data);
    }

    public function getProspectos()
    {
        $arrData = $this->model->selectProspectos();
        for ($i=0; $i <count($arrData) ; $i++) { 
            $arrData[$i]['numeracion'] = $i + 1;
            if($arrData[$i]['nombre_categoria'] == 'Prospecto')
            {
                $arrData[$i]['nombre_completo'] = $arrData[$i]['nombre_completo'].' <span class="badge badge-success">'. $arrData[$i]['nombre_categoria'] .'</span>';
                $arrData[$i]['options'] = '<div class="text-center">
                <div class="btn-group">
                    <button type="" class="btn btn-outline-secondary btn-xs icono-color-principal dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-layer-group"></i> &nbsp; Acciones
                    </button>
                    <div class="dropdown-menu">
                        <button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnEditSalon" data-toggle="modal" data-target="#ModalAgendarProspectoSeguimiento" onClick="ftnAgendar('. $arrData[$i]['id'] .')" title="Agendar"> &nbsp;&nbsp; <i class="fas fa-calendar-alt"></i> &nbsp; Agendar</button>
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnDelSalon" data-toggle="modal" data-target="#ModalEditDatosProspectoSeguimiento" onClick="fnEditarDatosProspecto('. $arrData[$i]['id'] .')"title="Editar"> &nbsp;&nbsp; <i class="fas fa-pencil-alt"></i> &nbsp; Editar</button>
                        <button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnDelSalon" onClick="fnDarSeguimiento('. $arrData[$i]['id'] .')" data-toggle="modal" data-target="#ModalSeguimiento" title="Seguimiento"> &nbsp;&nbsp; <i class="far fa-arrow-alt-circle-right"></i> &nbsp; Seguimiento</button>
                    </div>
                </div>
            </div>';
            }
        }
        /* 
            else if($arrData[$i]['nombre_categoria'] == 'Egresado'){
                $arrData[$i]['nombre_completo'] = $arrData[$i]['nombre_completo'].' <span class="badge badge-primary">'. $arrData[$i]['nombre_categoria'] .'</span>';
                $arrData[$i]['options'] =
                '<div class="text-center">
                <div class="btn-group">
                    <button type="" class="btn btn-outline-secondary btn-xs icono-color-principal dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-layer-group"></i> &nbsp; Acciones
                    </button>
                    <div class="dropdown-menu">
                        <button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnEditSalon" data-toggle="modal" data-target="#ModalAgendarProspectoSeguimiento" onClick="ftnAgendar('. $arrData[$i]['id'] .')" title="Editar"> &nbsp;&nbsp; <i class="fas fa-calendar-alt"></i> &nbsp; Agendar</button>
						<button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnDelSalon" data-toggle="modal" data-target="#ModalEditDatosProspectoSeguimiento" onClick="fnEditarDatosProspecto('.$arrData[$i]['id'].')" title="Editar"> &nbsp;&nbsp; <i class="fas fa-pencil-alt"></i> &nbsp; Editar</button>
                        <button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnDelSalon" data-toggle="modal" data-target="#ModalEgresadoSeguimiento" title="Egresado"> &nbsp;&nbsp; <i class="fas fa-user-graduate"></i> &nbsp; Egresado</button>
                        <button class="dropdown-item btn btn-outline-secondary btn-sm btn-flat icono-color-principal btnDelSalon" onClick="fnDarSeguimiento('. $arrData[$i]['id'].
                ')" data-toggle="modal" data-target="#ModalSeguimiento" title="Seguimiento" disabled> &nbsp;&nbsp; <i class="far fa-arrow-alt-circle-right"></i> &nbsp; Seguimiento</button>
                    </div>
                </div>
            </div>';
            }
        } */
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function agenda(){
        $data['page_tag'] = "Agenda de llamadas";
        $data['page_name'] = "Agenda de llamadas";
        $this->views->getView($this,"AgendaProspecto",$data);
    }

    public function editDatos(){
        if(isset($_POST['idProspectoEdit'])){
            $idProspecto = $_POST['idProspectoEdit'];
        }
        if(isset($_POST['idPersonaEdit'])){
            $idPersona = $_POST['idPersonaEdit'];
        }
        $nombre = strClean($_POST['txtNombreEdit']);
        $apepat = strClean($_POST['txtApellidoPatEdit']);
        $apemat = strClean($_POST['txtApellidoMatEdit']);
        $telefono = $_POST['txtTelefonoCelEdit'];
        $email = $_POST['txtEmail'];
        $plantel = strClean($_POST['slctPlantelEdit']);
        $nivel = intval($_POST['slctNivelEstudiosEdit']);
        $carrera = intval($_POST['slctCarreraEdit']);

        $arrData = $this->model->updatePersona($nombre, $apepat, $apemat, $telefono, $email, $plantel, $nivel, $carrera,$idProspecto, $idPersona);

        if($arrData['estatus'] == TRUE){
            $arrResponse = array('estatus' => TRUE, 'msg' => 'Datos actualizados correctamente');
        }
        else{
            $arrResponse = array('estatus' => TRUE, 'msg' => 'No se puede actualizar');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function setProgramarAgenda(){
        if($_POST){
            if(empty($_POST['txtFechaProg']) || empty($_POST['txtHoraProg']) || empty($_POST['idUsuarioAtendidoAgenda']) || empty($_POST['txtFechaRegistro'])){
                $arrResponse = array("estatus" => false, "msg" => 'Datos incorrectos.');
            }
            else
            {
                $intIdPersona = intval($_POST['idPersona']);
                $intIdUsuarioAtendio = intval($_SESSION['idUser']);
                $strFechaProgramada = strClean($_POST['txtFechaProg']);
                $strFechaRegistro = strClean($_POST['txtFechaRegistro']);
                $strHoraProgramada = strClean($_POST['txtHoraProg']);
                $strAsuntoLlamada = strClean($_POST['txtAsunto']);
                $strDetalleLlamada = strClean($_POST['txtComentario']);
                if($intIdPersona <> 0){
                    $requestAgendarProspecto = $this->model->insertAgendaProspecto($intIdPersona, $intIdUsuarioAtendio, $strFechaProgramada, $strFechaRegistro, $strHoraProgramada, $strAsuntoLlamada, $strDetalleLlamada);
                    $option = 1;
                }
                if($requestAgendarProspecto > 0){
                    if($option == 1)
                    {
                        $arrResponse = array('estatus' => true, 'msg' => 'Llamada agendada');
                    }
                }
                else{
                    $arrResponse = array('estatus' => false, "msg" => 'No es posible agendar, probablemente existe un registro');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }

    public function getPersonaSeguimiento(int $idPersona)
    {
        $intIdPersona = intval($idPersona);
        if($intIdPersona > 0)
        {
            $data['datos'] = $this->model->selectPersonaSeguimiento($intIdPersona);
            $data['seguimiento'] = $this->model->selectSeguimientoProspecto($intIdPersona);
            if(empty($data['datos']))
            {
                $data['response'] = array('estatus'=>false, 'msg' => 'Datos no encontrados');
            }
            else{
                $data['response'] = array('estatus'=>true, 'msg' => $data['datos']);
            }
            for ($i=0; $i < count($data['seguimiento']); $i++) { 
                $data['seguimiento'][$i]['respuesta_rapida'] = '<span class="badge badge-warning">'.$data['seguimiento'][$i]['respuesta_rapida'].'</span>';
            }
        }
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    public function getRespuestasRapidas()
    {
        $arrData = $this->model->selectRespuestasRapidas();
        for ($i=0; $i < count($arrData); $i++) { 
            $arrData[$i]['respuesta_rapida'] = '<input type="radio" class="form-check-input" id="rad'.$arrData[$i]['identificador'].'" name="rad" value="'.$arrData[$i]['id'].'">'.$arrData[$i]['respuesta_rapida'].'<br>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    }

    public function setSeguimientoProspectoIndividual(){
        if(isset($_POST['idProsInd']))
        {
            $intIdPro = intval($_POST['idProsInd']);
        }
        $intResp = intval($_POST['rad']);
        $strComent = strClean($_POST['txtComentarioSegInd']);
        $arrData = $this->model->insertSeguimientoProspectoInd($intResp, $strComent, $intIdPro);
        if($arrData == TRUE)
        {
            $arrResponse = array('estatus' => true, 'msg' => 'Se ha añadido el seguimiento');
        }
        else
        {
            $arrResponse = array('estatus' => false, 'msg' => 'Error, no puede agregarse el seguimiento');
        }
        echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getProspecto(int $idPers)
    {
        $id = $idPers;
        $arrData = $this->model->selectProspecto($id);
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getMunicipios(){
        $idEstado = $_GET['idestado'];
        $arrData = $this->model->selectMunicipios($idEstado);
        echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getLocalidades(){
        $idMunicipio = $_GET['idmunicipio'];
        $arrData = $this->model->selectLocalidades($idMunicipio);
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getMedioCaptacion()
    {
        $arrData = $this->model->selectMedioCaptacion();
        for ($i=0; $i < count($arrData); $i++) { 
            $arrData[$i]['med_capInput'] = '<input type="radio" class="form-check-input" id="rad'.$arrData[$i]['id'].'" name="rad" value="'.$arrData[$i]['id'].'">'.$arrData[$i]['medio_captacion'].'<br>';
        }
        echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getCarrera()
    {
        $idNivel = $_GET['idNivel'];
        $arrData = $this->model->selectCarrera($idNivel);
        echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
        die();
    }

    public function setProspecto()
    {    
        $strNombreNvo = strClean($_POST['txtNombreNuevo']);
        $strApePatNvo = strClean($_POST['txtApellidoPaNuevo']);
        $strApeMatNvo = strClean($_POST['txtApellidoMaNuevo']);
        $strSexoNvo = $_POST['listSexoNuevo'];
        $strAliasNvo = $_POST['txtAlias'];
        $intEdadNvo = $_POST['txtEdadNuevo'];
        $strEdoCivilNvo = $_POST['listEstadoCivilNuevo'];
        $strOcupacionNvo = $_POST['txtOcupacion'];
        $intEscolaridadNvo = $_POST['slctEscolaridad'];
        $strFechaNacNvo = $_POST['txtFechaNacimientoNuevo'];
        $intLocalidadNvo = $_POST['listLocalidadNuevo'];
        $intTelNvo = $_POST['txtTelCelNuevo'];
        $intTelFijoNvo = $_POST['txtTelFiNuevo'];
        $strEmailNvo = $_POST['txtEmailNuevo'];
        $strPlantelProcNvo = $_POST['txtPlantelProcedencia'];
        $strPlantelIntNvo = $_POST['slctPlantelNvo'];
        $strPlantelProspectadoNvo = $_POST['slctPlantelPros'];
        $strNivelNvo = $_POST['slctNivelEstudios'];
        $intCarreraNvo = $_POST['slctCarreraNuevoPro'];
        $intMedioNvo = $_POST['rad'];
        $strComentarioNvo = $_POST['txtObservacionPros'];
        
        $intIdPersonaNueva = 0;
        $intIdPersonaEdit = 0;
        if(isset($_POST['idNuevo'])){
            $intIdPersonaNueva = intval($_POST['idNuevo']);
        }
        if(isset($_POST['idPersonaEdit'])){
            $intIdPersonaEdit = intval($_POST['idPersonaEdit']);
        }

        if($intIdPersonaNueva == 0)
        {
            $idSubcampana = $this->model->selectSubcampania(); 
            if($idSubcampana)
            {
                $arrProspecto = $this->model->insertProspecto($strNombreNvo, $strApePatNvo, $strApeMatNvo, $strAliasNvo, $strEdoCivilNvo, $strOcupacionNvo, $strFechaNacNvo, $intEscolaridadNvo, $intEdadNvo, $strSexoNvo, $intLocalidadNvo, $intTelNvo, $intTelFijoNvo, $strEmailNvo, $strPlantelProcNvo, $strPlantelIntNvo, $strPlantelProspectadoNvo, $strNivelNvo, $intCarreraNvo, $intMedioNvo, $strComentarioNvo, $idSubcampana['id']);
                if($arrProspecto)
                {
                    $arrResponse = array('estatus' => true, 'msg' => 'Se ha dado de alta un nuevo prospecto');
                }
                else
                {
                    $arrResponse = array('estatus' => false, 'msg' => 'No se pudieron guardar los datos');
                }
            }
            else
            {
                $arrResponse = array('estatus' => false, 'msg' => 'No existe una subcampaña activa');
            }
        }
        if($intIdPersonaEdit != 0)
        {
            $arrData = $this->model->updateProspecto();
            if($arrData)
            {
                $arrResponse = array('estatus' => true, 'msg' => 'Datos actualizados correctamente');
            }
            else
            {
                $arrResponse = array('estatus' => true, 'msg' => 'No es posible actualizar los datos');
            }
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }


}
?>