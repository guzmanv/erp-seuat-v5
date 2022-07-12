let tableAsignacionBeca;
let tableAlumnosBecados;

document.addEventListener('DOMContentLoaded', function(){
	tableAlumnosBecados = $('#tableBecados').dataTable({
		"aProcessing":true,
		"aServerSide":true,
        "language": {
        	"url": " "+base_url+"/Assets/plugins/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/RenovacionBecas/getBecados",
            "dataSrc":""
        },
        "columns":[
			{"data": "numeracion"},
			{"data": "nombre_completo"},
			{"data": "nombre_carrera"},
			{"data": "nombre_periodo"},
            {"data": "nombre_grado"},
            {"data": "porcentaje_beca"},
			{"data": "fecha_asignada_beca"},
			{"data": "estatus"},
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
	})
})
$('#tableBecados').DataTable();

tableAsignacionBeca = $('#tabla-asig-becas').dataTable( {
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
			{"data": "carrera"},
			{"data": "id_grados"},
			{"data": "nombre_periodo"},
            {"data": "nombre_plan"},
            {"data": "promedio"}
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
$('#tabla-asig-becas').DataTable(); 

function buscarAlumno(){
	var textoBusqueda = $("input#busquedaAlumno").val();
    var tablePersonas;
    tablePersonas = $('#tablePersonas').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            //url:"<?php echo media(); ?>/plugins/Spanish.json"
            "url": " "+base_url+"/Assets/plugins/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/RenovacionBecas/selectAlumno?val="+textoBusqueda,
            "dataSrc":""
        },
        "columns":[
            {"data":"nombre_persona"},
            {"data":"estatus"},
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