let tableAsignacionBeca;
let tablaBecados;

document.addEventListener('DOMContentLoaded', function(){
    tablaBecados = $('#tableBecados').dataTable( {
		"aProcessing":true,
		"aServerSide":true,
        "language": {
        	"url": " "+base_url+"/Assets/plugins/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/RenovacionBecas/getAsignaciones",
            "dataSrc":""
        },
        "columns":[
            {"data": "numeracion"},
			{"data": "nombre_estudiante"},
			{"data": "nombre_carrera"},
			{"data": "porcentaje_beca"},
			{"data": "fecha_asignada_beca"},
			{"data": "options"}
        ],
        "responsive": true,
	    "paging": true,
	    "lengthChange": true,
	    "searching": true,
	    "ordering": false,
	    "info": true,
	    "autoWidth": false,
	    "scrollY": '42vh',
	    "scrollCollapse": true,
	    "bDestroy": true,
	    "order": [[ 0, "asc" ]],
	    "iDisplayLength": 10
    });
});
$('#tableBecados').DataTable();

tableAsignacionBeca = $('#tabla-asig-becas').dataTable( {
    "aProcessing":true,
    "aServerSide":true,
    "language": {
        "url": " "+base_url+"/Assets/plugins/Spanish.json"
    },
    "ajax":{
        "url": " "+base_url+"/RenovacionBecas/getReinscritos",
        "dataSrc":""
    },
    "columns":[
        {"data": "numeracion"},
	    {"data": "nombre_estudiante"},
	    {"data": "nombre_carrera"},
    	{"data": "nombre_grado"},
    	{"data": "nombre_plan"},
        {"data": "promedio"},
        {"data": "options"}
    ],
    "responsive": true,
    "paging": true,
    "lengthChange": true,
    "searching": true,
    "ordering": false,
    "info": true,
    "autoWidth": false,
    //"scrollY": '42vh',
    "scrollCollapse": true,
    "bDestroy": true,
    "order": [[ 0, "asc" ]],
    "iDisplayLength": 10
});

$('#tabla-asig-becas').dataTable();

function fnRatificar(idIns)
{
    let idInscripcion = idIns;
    let url = `${base_url}/RenovacionBecas/getEstudianteAsig/${idInscripcion}`;
    let carrera = document.querySelector('#lblCarreraAsig');
    let grado = document.querySelector('#lblGradoAsig');
    let direccionEst = document.querySelector('#direccion_estudianteAsig');
    let nombreTutor = document.querySelector('#nombre_tutorAsig');
    //let direccionTutor = document.querySelector('#direccionAsig');
    let telefonoFijo = document.querySelector('#telefonoFijoAsig');
    let telefonoCel = document.querySelector('#telefonoCelAsig');
    let promedioAsig = document.querySelector('#promedioAsig');
    fetch(url)
        .then(response => response.json())
        .then(data => {
            console.log(data);  
            carrera.textContent = data.datosEstudiante.nombre_carrera;
            grado.textContent = data.datosEstudiante.nombre_grado;
            direccionEst.textContent = data.datosEstudiante.direccion_estudiante;
            nombreTutor.textContent = data.datosEstudiante.nombre_tutor;
            telefonoFijo.textContent = data.datosEstudiante.tel_fijo;
            telefonoCel.textContent = data.datosEstudiante.tel_celular;
            promedioAsig.textContent = data.datosEstudiante.promedio;
        })

}