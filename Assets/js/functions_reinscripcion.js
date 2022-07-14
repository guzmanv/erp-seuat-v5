let btnReinscribir = document.querySelector("#btn_reinscribir");
let txtNombreAlumno = document.querySelector("#nombreAlumno");
let formReinscripcion = document.querySelector("#formReinscripcion");
let tableAlumnos = document.querySelector("#table_alumnos_inscritos");
btnReinscribir.disabled = true;
txtNombreAlumno.disabled = true;
let gradoInscritoActual = null;
let grupoInscritoActual = null;

let idSalonCompuesto = null;
let nombreGrupo = null;
let grado = null;
let idGrado = null;
let idTurno = null;
let idPlanEstudios = null;
let idPersona = null;
let idTutor = null;
let idDocumentos = null;
let idSubcapania = null;
let idHistorial = null;

let arrAlumnosSeleccioandos = [];


//TABS
var tabActual = 0;
mostrarTab(tabActual);

function mostrarTab(tabActual) {
    var tab = document.getElementsByClassName("tab");
    tab[tabActual].style.display = "block";
}
function fnNavTab(numTab){
    tabActual = numTab;
    var x = document.getElementsByClassName("tab");
    for( var i = 0; i<x.length;i++){
      x[i].style.display = "none";
    }
    x[numTab].style.display = "block";  
    fnMostrarDatatableReinscripciones();
    fnMostrarDatatableReinscripcionGrupal();

}

//Modal buscar Persona
function buscarPersona(){
    var textoBusqueda = $("input#busquedaPersona").val();
    var tablePersonas;
    tablePersonas = $('#tablePersonas').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            //url:"<?php echo media(); ?>/plugins/Spanish.json"
            "url": " "+base_url+"/Assets/plugins/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Reinscripcion/buscarPersonaModal?val="+textoBusqueda,
            "dataSrc":""
        },
        "columns":[
            {"data":"nombre_persona"},
            {"data":"apellidos"},
            {"data":"nombre_carrera"},
            {"data":"grado"},
            {"data":"nombre_grupo"},
            {"data":"options"}
        ],
        "responsive": true,
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "scrollY": '42vh',
        "scrollCollapse": true,
        "bDestroy": true,
        "order": [[ 0, "desc" ]],
        "iDisplayLength": 5
    });
    $('#tablePersonas').DataTable();
}
function seleccionarPersona(value){
    let nombre = value.getAttribute('rl');
    let id = value.id;
    let url = `${base_url}/Reinscripcion/getDatosAlumno/${id}`;
    document.getElementById('nombreAlumno').value = nombre;
    fetch(url)
    .then(res => res.json())
    .then((resultado) =>{
        if(resultado.numero_natural){
            gradoInscritoActual = resultado.numero_natural;
        }
        if(resultado.nombre_grupo){
            grupoInscritoActual = resultado.nombre_grupo;
        }
        idPlanEstudios = resultado.id_plan_estudios;
        idPersona = resultado.id;
        idTutor = resultado.id_tutores;
        idDocumentos = resultado.id_documentos;
        idSubcapania = resultado.id_subcampanias;
        idHistorial = resultado.id_historial;
        document.querySelector('#divDatosAlumno').style.display = "block";
        document.querySelector('#divDatosReinscripcion').style.display = "block";
        document.querySelector('#nombrePersona').textContent = `${resultado.nombre_persona} ${resultado.ap_paterno} ${resultado.ap_materno}`;
        document.querySelector('#nombrePlantel').textContent = `${resultado.nombre_plantel_fisico}`;
        document.querySelector('#nombreCarrera').textContent = `${resultado.nombre_carrera}`;
        document.querySelector('#nombreGeneracion').textContent = resultado.nombre_generacion;
        document.querySelector('#nombreCiclo').textContent = resultado.nombre_ciclo;
        document.querySelector('#nombrePeriodo').textContent = resultado.nombre_periodo;
        document.querySelector('#carreraGrupo').textContent = `${resultado.numero_natural} ${resultado.nombre_grupo}`;
        document.querySelector('#estatus').innerHTML = resultado.estatus;
        document.querySelector('#txtNombrePlantel').value = `${resultado.nombre_plantel_fisico}`;
        document.querySelector('#txtNombreCarrera').value = `${resultado.nombre_carrera}`;
        document.querySelector('#txtNombreGeneracion').value = resultado.nombre_generacion; 
    }).catch(err => {throw err});
    if(nombre != ""){
        document.querySelector('#alertBuscar').style.display = "none";
    }
    $('.close').click();
}

function fnSelectSalonCompuesto(value)
{
    checkInputComplete();
    if(value != '')
    {
        idSalonCompuesto = (value.split(","))[0];
        grupo = (value.split(","))[1];
        grado = (value.split(","))[2];
        idTurno = (value.split(","))[3];
        idGrado = (value.split(","))[4];
        if(parseInt(grado) <= parseInt(gradoInscritoActual))
        {
            swal.fire("Atención","No se puede reinscribir a este grado","warning");
            idSalonCompuesto = null;
            grupo = null;
            grado = null;
            idTurno = null;
            idGrado = null;
            return false;
        }
        if(grupo != grupoInscritoActual)
        {
            swal.fire("Atención","No se puede reinscribir a un grupo diferente","warning");
            idSalonCompuesto = null;
            grupo = null;
            grado = null;
            idTurno = null;
            idGrado = null;
            return false;
        }
    }else{
        idSalonCompuesto = null;
        grupo = null;
        grado = null;
        idTurno = null;
        idGrado = null;
    }
}
function checkInputComplete()
{
    let salonCompuesto = document.querySelector("#select_salon_compuesto").value;
    if(salonCompuesto == ''){
        document.querySelector("#btn_reinscribir").disabled = true;
    }else{
        document.querySelector("#btn_reinscribir").disabled = false;
    }
}
function fnReinscribir(){
    let url = `${base_url}/Reinscripcion/setReinscripcionIndividual/${idTurno}/${idPlanEstudios}/${idPersona}/${idTutor}/${idDocumentos}/${idSubcapania}/${idSalonCompuesto}/${idHistorial}/${idGrado}`;
    fetch(url).then((res) => res.json()).then(response =>{
        if(response.estatus){
            formReinscripcion.reset();
            //$('#modal_form_nueva_inscripcion').modal("hide");
            swal.fire("Reinscripcion", response.msg, "success").then((result) =>{
                //$('.close').click();
                location.reload();
            });
            //tableInscripciones.api().ajax.reload(); 
        }else{
            swal.fire("Error", response.msg, "error");
        }
    }).catch(err =>{throw err});

}

if(tabActual == 0){
    fnMostrarDatatableReinscripciones();
}else if(tabActual == 2){
    fnMostrarDatatableReinscripcionGrupal();
}

function fnMostrarDatatableReinscripciones(){
    if(tabActual == 0){
        var tablePersonas;
        tablePersonas = $('#table_reinscripciones').dataTable( {
            "aProcessing":true,
            "aServerSide":true,
            "language": {
                //url:"<?php echo media(); ?>/plugins/Spanish.json"
                "url": " "+base_url+"/Assets/plugins/Spanish.json"
            },
            "ajax":{
                "url": " "+base_url+"/Reinscripcion/getReinscripciones",
                "dataSrc":""
            },
            "columns":[
                {"data":"numeracion"},
                {"data":"nombre_plantel_fisico"},
			    {"data":"nombre_institucion"},
			    {"data":"nombre_carrera"},
                {"data":"numero_natural"},
                {"data":"nombre_grupo"},
                {"data":"total_alumnos"},
			    {"data":"options"}
            ],
            "responsive": true,
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "scrollY": '42vh',
            "scrollCollapse": true,
            "bDestroy": true,
            "order": [[ 0, "desc" ]],
            "iDisplayLength": 5
        });
        $('#table_reinscripciones').DataTable();
    }
}

function fnMostrarDatatableReinscripcionGrupal()
{
    if(tabActual == 2){
        var tablePersonas;
        tablePersonas = $('#table_reinscripcion_grupal').dataTable( {
            "aProcessing":true,
            "aServerSide":true,
            "language": {
                //url:"<?php echo media(); ?>/plugins/Spanish.json"
                "url": " "+base_url+"/Assets/plugins/Spanish.json"
            },
            "ajax":{
                "url": " "+base_url+"/Reinscripcion/getInscripciones",
                "dataSrc":""
            },
            "columns":[
                {"data":"numeracion"},
                {"data":"nombre_plantel_fisico"},
			    {"data":"nombre_institucion"},
			    {"data":"nombre_carrera"},
                {"data":"numero_natural"},
                {"data":"nombre_grupo"},
                {"data":"total_alumnos"},
			    {"data":"options"}
            ],
            "responsive": true,
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "scrollY": '42vh',
            "scrollCollapse": true,
            "bDestroy": true,
            "order": [[ 0, "desc" ]],
            "iDisplayLength": 5
        });
        $('#table_reinscripcion_grupal').DataTable();
    }
}

function fnVerEstudiantes(plantel,institucion,planestudios,grado,grupo)
{
    $('html,body').animate({scrollTop: $("#div_datos_reinscripcion").offset().top},'slow');
    let url = `${base_url}/Reinscripcion/getAlumnosInscritos/${plantel}/${institucion}/${planestudios}/${grado}/${grupo}`;
    fetch(url).then((res) => res.json()).then(response =>{
        if(response.length >0){
            let rows = "";
            response.forEach(element => {
                gradoInscritoActual = element.numero_natural;
                grupoInscritoActual = element.nombre_grupo;
                rows += '<tr><th><input type="checkbox" id="'+element.id_personas+'" t="'+element.id_tutores+'" d="'+element.id_documentos+'" s="'+element.id_subcampanias+'" h="'+element.id_historial+'" i="'+element.id+'" aria-label="Checkbox for following text input"></th><th scope="row">'+element.numeracion+'</th><td>'+element.nombre_persona+'</td><td>'+element.ap_paterno+' '+element.ap_materno+'</td><td>'+element.promedio+'</td><td>'+element.aprobado+'</td></tr>';
            });
            document.querySelector("#table_alumnos_inscritos").innerHTML = rows;
            fnSetGradoGrupoActual();
        }
    }).catch(err =>{throw err});
    arrAlumnosSeleccioandos = [];
    idPlanEstudios = planestudios;

}

function fnSetGradoGrupoActual()
{
    document.querySelector("#grado_actual").value = gradoInscritoActual;
    document.querySelector("#grupo_actual").value = grupoInscritoActual;
}

function fnCheckAll(value)
{
    let checks = tableAlumnos.getElementsByTagName("tr");
    if(value.checked){
        checks.forEach(element => {
            let col = element.getElementsByTagName("th");
            let check = col[0].getElementsByTagName('input')[0].checked = true;
        });
    }
    else{
        checks.forEach(element => {
            let col = element.getElementsByTagName("th");
            let check = col[0].getElementsByTagName('input')[0].checked = false;
        });
    }
}

function fnReinscibirGrupal()
{
    let arrChecks = tableAlumnos.getElementsByTagName("input");
    arrAlumnosSeleccioandos = [];
    arrChecks.forEach(element => {
        if(element.checked){
            id_tutor = element.getAttribute('t');
            id_documentos = element.getAttribute('d');
            id_subcampanias = element.getAttribute('s');
            id_historial = element.getAttribute('h');
            id_inscripcion = element.getAttribute('i');
            let objalumno = {'id_persona':element.id,'id_tutor':id_tutor,'id_documentos':id_documentos,'id_subcampania':id_subcampanias,'id_historial':id_historial,'id_inscripcion':id_inscripcion};
            arrAlumnosSeleccioandos.push(objalumno);
        }
    });
    if(arrAlumnosSeleccioandos.length > 0){
        if(idSalonCompuesto != null){
            let url = `${base_url}/Reinscripcion/setReinscripcionGrupal/${convStrToBase64(JSON.stringify(arrAlumnosSeleccioandos))}/${idTurno}/${idPlanEstudios}/${idSalonCompuesto}/${idGrado}`;
            fetch(url).then((res) => res.json()).then(response =>{
                if(response.estatus){
                    swal.fire("Reinscripcion", response.msg, "success").then((result) =>{
                        //$('.close').click();
                        location.reload();
                    });
                }else{
                    swal.fire("Error", response.msg, "error");
                }
            }).catch(err =>{throw err});
        }else{
            swal.fire("Atención", "Selecciona un salon salon compuesto", "warning");
        }
    }else{
        swal.fire("Atención", "Selecciona al menos un alumno", "warning");
    }
}

function convStrToBase64(str){
    return window.btoa(unescape(encodeURIComponent( str ))); 
}