let tableBecas = document.querySelector('#tableBecas');


document.addEventListener('DOMContentLoaded', function(){
    tableBecas = $('#tableBecas').dataTable( {
		"aProcessing":true,
		"aServerSide":true,
        "language": {
        	"url": " "+base_url+"/Assets/plugins/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Becas/getBecas",
            "dataSrc":""
        },
        "columns":[
			{"data": "numeracion"},
			{"data": "nombre_beca"},
            {"data": "porcentaje_descuento"},
			{"data": "estatus"},
			{"data": "id_periodos"},
            {"data": "id_plan_estudios"}
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
})

$('tableBecas').dataTable();