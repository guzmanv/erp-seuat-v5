let tableAsignacionBeca;
let tableReinscritos;

function buscarAlumno(){
	var textoBusqueda = $("input#busquedaAlumno").val();
    tableReinscritos = $('#tableReinscritos').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": " "+base_url+"/Assets/plugins/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/RenovacionBecas/getReinscritos?val="+textoBusqueda,
            "dataSrc":""
        },
        "columns":[
            {"data":"nombre_completo"},
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
    $('#tableReinscritos').DataTable();
}