document.querySelector('#ver_todas_notificaciones').textContent = "Ver todas las inscripciones";
document.querySelector('#ver_todas_notificaciones').href = `${base_url}/Ingresos/inscripciones`;
let arrNuevasInscripciones = [];
let time = 0;
fnMostrarInscripcionesDatatable(null);

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

function fnMostrarInscripcionesDatatable(datos){
        tableEstudiantes = $('#tableInscripcionesCaja').dataTable( {
            "aProcessing":true,
            "aServerSide":true,
            "language": {
                "url": " "+base_url+"/Assets/plugins/Spanish.json"
            },
            "ajax":{
                "url": " "+base_url+"/Ingresos/getEstudiantes",
                "dataSrc":""
            },
            "columns":[
                {"data":"numeracion"},
                {"data":"folio_inscripcion"},
                {"data":"nombre_persona"},
                {"data":"ap_paterno"},
                {"data":"ap_materno"},
                {"data":"is_edo_cta"},
                {"data":"aplica_desc_ins"},
                {"data":"aplica_desc_coleg"},
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
            "order": [[ 0, "asc" ]],
            "iDisplayLength": 25
        });
    $('#tableInscripcionesCaja').DataTable();
}

/*function fnAgregarServicios(value){
    let idPersona = value;
    let url = `${base_url}/Ingresos/getIngreso/${idIngreso}`;
    fetch(url).then((res) => res.json()).then(resultado =>{
        if(resultado.length > 0){
            let strObj = JSON.stringify(resultado);
            location.href = base_url + "/Ingresos/ingresos?type=obj&d="+convStrToBase64(strObj);
        }else{
            Swal.fire('Error!',"Hubo un error",'warning')
        }
    }).catch(err => {throw err});
}*/


function fnGenerarEstadoCuenta(idPer,id){
    let idPersona = idPer;
    let idTablaTemp = id;
    Swal.fire({
        title: 'Estado de cuenta',
        text: "Generar un estado de cuenta para el Alumno?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            let url = `${base_url}/Ingresos/generarEdoCuenta/${idPersona}`;
            Swal.fire({
                title:'Generando estado de cuenta',
                html: "<div class='overlay'><i class='fas fa-3x fa-sync-alt fa-spin'></i><div class='text-bold pt-2'>espere...</div></div>",
                icon:'question',
                showConfirmButton:false,
                didOpen: () =>{
                    fetch(url).then(res => res.json()).then((resultado) => {
                        if(resultado.estatus){
                            swal.fire("Estado de cuenta","Estado de cuenta generado correctamente!","success").then((result) =>{
                                location.href= `${base_url}/Ingresos`;
                            });
                            /* let urlDel = `${base_url}/Ingresos/delTblTempInscripcion/${idTablaTemp}`;
                            fetch(urlDel).then((res)=>res.json()).then(resultado =>{
                                console.log(resultado)
                            }).catch(err =>{throw err}); */
                        }else{
                            swal.fire("Estado de cuenta",resultado.msg,"warning");
                        }
                    }).catch(err => { throw err });
                }
            })
        }
    }) 
}

//Function para convertir un string  a  Formato Base64
function convStrToBase64(str){
    return window.btoa(unescape(encodeURIComponent( str ))); 
}