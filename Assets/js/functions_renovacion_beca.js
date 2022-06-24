function buscarAlumno(){
    let url = base_url+"/RenovacionBeca/buscarAlumnoModal?val="+textoBusqueda;
    fetch(url)
    .then((res) => res.json())
    .then(resultado =>{
        console.log(resultado)
    }).catch(err => {throw err});

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
            "url": " "+base_url+"/Inscripcion/buscarPersonaModal?val="+textoBusqueda,
            "dataSrc":""
        },
        "columns":[
            {"data":"nombre"},
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