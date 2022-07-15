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
            "url": " "+base_url+"/Turnos/getTurnos",
            "dataSrc":""
        },
        "columns":[
			{"data": "numeracion"},
			{"data": "nombre_turno"},
			{"data": "abreviatura"},
			{"data": "hora_entrada"},
            {"data": "hora_salida"},
            {"data": "estatus"},
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

function fnRenovar(idPer){
    let idPersona = idPer;
    console.log('Mostar modal');
} 