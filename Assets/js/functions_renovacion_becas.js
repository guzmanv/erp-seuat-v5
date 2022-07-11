let tableAsignacionBeca;

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