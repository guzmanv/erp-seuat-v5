let selectPlanteles = document.querySelector("#list_plantel");
let selectInstituciones = document.querySelector("#list_institucion");
let selectNievelesEducativos = document.querySelector("#list_nivel_educativo");
let tableReinscripcion = document.querySelector("#table_preeinscripcion");
let formNuevaInscripcion = document.querySelector("#form_nueva_inscripcion");
let idPlantelSeleccionado = null;
let idInstitucionSeleccionado = null;
let idNivelSeleccionado = null;

document.addEventListener('DOMContentLoaded', function(){
	tableInscripciones = $('#table_inscripciones').dataTable( {
		"aProcessing":true,
		"aServerSide":true,
        "language": {
        	"url": " "+base_url+"/Assets/plugins/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Inscripcion/getInscripciones",
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
	    "lengthChange": true,
	    "searching": true,
	    "ordering": true,
	    "info": true,
	    "autoWidth": false,
	    "scrollY": '42vh',
	    "scrollCollapse": true,
	    "bDestroy": true,
	    "order": [[ 0, "asc" ]],
	    "iDisplayLength": 25
    });
});
$('#table_inscripciones').DataTable();



function fnSelectPlantel(id)
{
    if(id != ''){
        idPlantelSeleccionado = id;
        let url = `${base_url}/Inscripcion/getInstituciones/${id}`;
        fetch(url).then((res) => res.json()).then(response =>{
            if(response.length > 1){
                selectInstituciones.innerHTML = "<option value=''>Seleccionar...</option>";
                let options = "";
                response.forEach(institucion => {
                    options += "<option value='"+institucion.id+"'>"+institucion.nombre_institucion+"</option>";
                });
                selectInstituciones.innerHTML += options;
            }else{
                selectInstituciones.innerHTML = "<option value=''>Seleccionar...</option>";
            }
        }).catch(err =>{throw err});
        fnPreenscritos(idPlantelSeleccionado,idInstitucionSeleccionado,idNivelSeleccionado);
    }else{
        idPlantelSeleccionado = null;
        selectInstituciones.innerHTML = "<option value=''>Seleccionar...</option>";
        tableReinscripcion.innerHTML = "";
    }
}
function fnSelectInstitucion(id)
{
    if(id != ''){
        idInstitucionSeleccionado = id;
        fnPreenscritos(idPlantelSeleccionado,idInstitucionSeleccionado,idNivelSeleccionado);
    }else{
        idInstitucionSeleccionado = null;
    }
}
function fnSelectNivelEducativo(id)
{
    if(id != ''){
        idNivelSeleccionado = id;
        fnPreenscritos(idPlantelSeleccionado,idInstitucionSeleccionado,idNivelSeleccionado);
    }else{
        idNivelSeleccionado = null;
    }
}
function fnPreenscritos(plantel,institucion,nivel_educativo)
{
    let url = `${base_url}/Inscripcion/getPreinscritos/${plantel}/${institucion}/${nivel_educativo}`; 
    fetch(url).then((res)=> res.json()).then(response =>{
        let rows = "";
        if(response.length > 0){
            let numeracion = 0;
            response.forEach(element => {
                let isDisabledCheck = (element.estatus)?'':'disabled';
                numeracion += 1;
                let options = "";
                rows += "<tr><td class='text-center'><input type='checkbox' id='"+element.id_personas+"' "+isDisabledCheck+"></td><td>"+numeracion+"</td><td>"+element.nombre_plantel_fisico+"</td><td>"+element.nombre_persona+"</td><td>"+element.ap_paterno+"</td><td>"+element.observacion+"</td></tr>";
            });
            tableReinscripcion.innerHTML = rows;
        }else{
            tableReinscripcion.innerHTML = "";
        }
    }).catch(err =>{throw err});
}

function fnFiltrarAlumno(value)
{
    let rows = $('#table_preeinscripcion tr');
    var val = $.trim(value).replace(/ +/g, ' ').toLowerCase();
    
    rows.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
}
function fnCheckAll(value)
{
    let checks = tableReinscripcion.getElementsByTagName("tr");
    if(value.checked){
        checks.forEach(element => {
            let col = element.getElementsByTagName("td");
            let check = col[0].getElementsByTagName('input')[0].checked = true;
        });
    }
    else{
        checks.forEach(element => {
            let col = element.getElementsByTagName("td");
            let check = col[0].getElementsByTagName('input')[0].checked = false;
        });
    }
}
formNuevaInscripcion.onsubmit = function(e){
    e.preventDefault();
    let idSalonCompuesto = document.querySelector("#select_salon_compuesto").value;
    let arrChecks = () =>{
        let checks = tableReinscripcion.getElementsByTagName('input');
        let arrValues = [];
        checks.forEach(element => {
            if(element.checked){
                arrValues.push(element.id);
            }
        });
        return arrValues;
    }
    if(arrChecks().length <= 0){
        swal.fire("Atención","Atención selecciona al menos un alumno","warning");
        return false;
    }
    if(idSalonCompuesto == ''){
        swal.fire("Atención","Atención selecciona un salon compuesto","warning");
        return false;
    }

    let url = `${base_url}/Inscripcion/setInscripcion/${idSalonCompuesto}/${convStrToBase64(JSON.stringify(arrChecks()))}`;
    fetch(url).then((res) => res.json()).then(response =>{
        if(response.estatus){
            formNuevaInscripcion.reset();
            $('#modal_form_nueva_inscripcion').modal("hide");
            swal.fire("Inscripcion", response.msg, "success").then((result) =>{
                $('.close').click();
            });
            tableInscripciones.api().ajax.reload();  
        }else{
            swal.fire("Error", response.msg, "error");
        }
    }).catch(err =>{throw err});

}

function fnVerListaInscritos()
{

}
function btnNuevaInscripcion()
{
    fnPreenscritos(null,null,null);
    formNuevaInscripcion.reset();
}
function convStrToBase64(str){
    return window.btoa(unescape(encodeURIComponent( str ))); 
}