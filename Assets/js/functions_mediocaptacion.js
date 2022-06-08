let tableMedioCaptacion;
const modalFormNvoMedio = document.querySelector('#modalFromNvoMedioCaptacion');

document.addEventListener('DOMContentLoaded', function(){

    tableMedioCaptacion = $('#tableMediosCap').dataTable({
        "aProcessing":true,
        "aServerSide":true,
        "language":{
            "url": " "+base_url+"/Assets/plugins/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/MedioCaptacion/getMediosCaptacion",
            "dataSrc":""
        },
        "columns":[
            {"data":"numeracion"},
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

$('#tableMediosCap').DataTable();

function fnEditarMedCap(idMed)
{
    let idMedioCaptacion = idMed;
    let url = `${base_url}/MedioCaptacion/getMedioCaptacion/${idMedioCaptacion}`;
    let idMedio = document.querySelector('#idMedCapEdit');
    let estatus = document.querySelector('#listEstatusMed')

    fetch(url)
        .then(response => response.json())
        .then(data => {
            console.log(data);

        })

        //.catch(err => console.log(err))
}