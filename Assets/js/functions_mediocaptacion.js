let tableMedioCaptacion;
const modalFormNvoMedio = document.querySelector('#modalFromNvoMedioCaptacion');

document.addEventListener('DOMContentLoaded', function(){

    tableMedioCaptacion = $('#tableMedioCaptacion').dataTable({
        "aProcessing":true,
        "aServerSide":true,
        "language":{
            "url": `${base_url}/Assets/plugins/Spanish.json`
        },
        "ajax":{
            "url": `${base_url}/MedioCaptacion/getMediosCaptacion`,
            "dataSrc":""
        },
        "columns":[
            {"data":"id"},
            {"data":"medio_captacion"},
            {"data":"estatus"},
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
        "iDisplayLength": 25,
        "order": [[0,"asc"]]
    })
})