document.querySelector('#ver_todas_notificaciones').textContent = "Ver todas las inscripciones";
document.querySelector('#ver_todas_notificaciones').href = `${base_url}/Ingresos/inscripciones`;
let formSaldarFaltantes = document.querySelector("#form-saldar-faltante");
let divLoading = document.querySelector("#divLoading");
let tableHistorialCorteCaja = "";
let arrNuevasInscripciones = [];
let time = 0;

document.addEventListener('DOMContentLoaded', function(){
        tableHistorialCorteCaja = $('#tableHistorialCorteCajas').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": " "+base_url+"/Assets/plugins/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/HistorialCorteCajas/getCortesCajas",
            "dataSrc":""
        },
        "columns":[
            {"data":"numeracion"},
            {"data":"folio"},
            {"data":"nombre_plantel_fisico"},
            {"data":"nombre"},
            {"data":"fechayhora_apertura_caja"},
            {"data":"fechayhora_cierre_caja"},
            {"data":"usuario_entrega"},
            {"data":"usuario_recibe"},
            {"data":"faltante"},
            {"data":"sobrante"},
            {"data":"options"}
        ],
        "responsive": true,
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "scrollCollapse": true,
        "bDestroy": true,
        "order": [[ 0, "asc" ]],
        "iDisplayLength": 10
    });
});
$('#tableHistorialCorteCajas').DataTable();

//Function para dar formato un numero a Moneda
function formatoMoneda(numero){
    let str = numero.toString().split(".");
    str[0] = str[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return "$"+str.join(".");
}

//Get notificaciones
setInterval(async function () {
    time += 1;
    let sizeNuevaInscripion = arrNuevasInscripciones.filter(i => Object.keys(i).every(i => i !== null)).length;
    let url = `${base_url}/Ingresos/getNuevasInscripciones`;
    fetch(url).then((res) => res.json()).then(resultado =>{
        resultado.forEach(element => {
            arrNuevasInscripciones[element.id_tmp] = {'folio':element.folio_inscripcion,'visto':false}
        });
        let nuevos = arrNuevasInscripciones.filter(i => Object.keys(i).every(i => i !== null)).length;
        document.querySelector('#numero_notificaciones').textContent = nuevos;
        document.querySelector('#titulo_notificaciones').textContent = nuevos+" Notificaciones";
        document.querySelector('#numero_nuevas_notificaciones').textContent = nuevos + " Inscripciones";
        if(sizeNuevaInscripion != nuevos && time > 2){
            fnMostrarInscripcionesDatatable(resultado);
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 7000,
                iconColor: 'white',
                background: '#ffc107',
                timerProgressBar: true,
                customClass: {
                    popup: 'colored-toast'
                },
                didOpen: (toast) => {
                  toast.addEventListener('mouseenter', Swal.stopTimer)
                  toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
              })    
              Toast.fire({
                icon: 'warning',
                title: "<h5 style='color:white'>Nueva Inscripcion</h5>",  
              })
        }
    }).catch(err =>{throw err});
    if(time >=50){
        time = 10;
    }
},500)

//REIMPRIMIR COMPROBANTE DE
function fnReimprimirComprobanteVenta(value,idHistorial){
    Swal.fire({
        title: 'Reimprimir?',
        text: "Desea reimprimir el comprobante del corte por id " +idHistorial+ "?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si reimprimir!',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Exito!',
                'Comprobante generado correctamente.',
                'success'
            )
            let url = `${base_url}/HistorialCorteCajas/reimprimir_comprobante_corte/${convStrToBase64(idHistorial)}`;
            window.open(url,'_blank');
        }
    })
}

function fnSaldarFaltantes(value)
{
    let idCorteCaja = value;
    let url = `${base_url}/HistorialCorteCajas/getDatosSaldarFaltante/${idCorteCaja}`;
    fetch(url).then((res) => res.json()).then(response =>{
        if(response){
            document.querySelector("#id-dinero-caja").value = response.id_dinero_caja;
            document.querySelector("#txt-nombre-caja").value = response.nombre;
            document.querySelector("#txt-recibido-por").value = response.nombre_persona_recibe;
            document.querySelector("#txt-entregado-por").value = response.nombre_persona_entrega;
            document.querySelector("#txt-cantidad-faltante").innerHTML = formatoMoneda(response.dinero_faltante);
        }
    }).catch(err =>{throw err});
}

formSaldarFaltantes.onsubmit = function(e){
    e.preventDefault();
    Swal.fire({
        title: 'Saldar faltante?',
        text: "Desea saldar el faltante de dinero del corte seleccionado?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, saldar!',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.isConfirmed) {
            divLoading.style.display = "flex";
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'/HistorialCorteCajas/setSaldarFaltante';
            var formData = new FormData(formSaldarFaltantes);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function() {
                if(request.readyState == 4 && request.status == 200) {
                    var objData = JSON.parse(request.responseText);
                    if(objData.estatus){
                        swal.fire("Exito!",objData.msg,"success").then((result) =>{
                            $('.close').click();
                        });
                        tableHistorialCorteCaja.api().ajax.reload();  
                    }else{
                        swal.fire("Estado de cuenta",resultado.msg,"warning");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }else{
            $('.close').click();
        }
    })
    
}
//Function para convertir un string  a  Formato Base64
function convStrToBase64(str){
    return window.btoa(unescape(encodeURIComponent( str ))); 
}