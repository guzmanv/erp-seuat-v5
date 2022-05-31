let divLoading = document.querySelector("#divLoading");
let formPlantelNuevo = document.querySelector("#form_plantel_nuevo");
let formPlantelEdit = document.querySelector("#form_plantel_edit");
const selMunicipio = document.querySelector('#select_municipio_nuevo');
const selMunicipioEdit = document.querySelector('#select_municipio_edit');
const selLocalidades = document.querySelector('#select_localidad_nuevo');
const selLocalidadesEdit = document.querySelector('#select_localidad_edit');

document.addEventListener('DOMContentLoaded', function () {
    tablePlanteles = $('#table_planteles').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": " " + base_url + "/Assets/plugins/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/Planteles/getPlanteles",
            "dataSrc": ""
        },
        "columns": [
            { "data": "numeracion" },
            { "data": "nombre_plantel_fisico" },
            { "data": "estado" },
            { "data": "municipio" },
            { "data": "localidad" },
            { "data": "latitud" },
            { "data": "longitud" },
            { "data": "estatus" },
            { "data": "options" }

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
        "order": [[0, "asc"]],
        "iDisplayLength": 25
    });
});
$('#table_planteles').DataTable();


formPlantelNuevo.onsubmit = function (e) {
    e.preventDefault();
    document.querySelector("#id_nuevo").value = 0;
    let strNombre = document.querySelector('#txt_nombre_nuevo').value;
    let intEstado = document.querySelector('#select_estado_nuevo').value;
    let intMunicipio = document.querySelector('#select_municipio_nuevo').value;
    let intLocalidad = document.querySelector('#select_localidad_nuevo').value;
    let strDomicilio = document.querySelector('#txt_domicilio_nuevo').value;
    let strColonia = document.querySelector('#txt_colonia_nuevo').value;
    let intCodigoPostal = document.querySelector('#txt_codigo_postal_nuevo').value;

    if (strNombre == '' || intEstado == '' || intMunicipio == '' || intLocalidad == '' || strDomicilio == '' || strColonia == '' || intCodigoPostal == '' ) {
        swal.fire("Atención", "Atención todos los campos son obligatorios", "warning");
        return false;
    }
    divLoading.style.display = "flex";
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url + '/Planteles/setPlantel';
    var formData = new FormData(formPlantelNuevo);
    request.open("POST", ajaxUrl, true);
    request.send(formData);
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var objData = JSON.parse(request.responseText);
            if(objData.estatus){
                $('#modal_form_nuevo_plantel').modal("hide");
                formPlantelNuevo.reset();
                swal.fire("Planteles", objData.msg, "success").then((result) =>{
                    $('.close').click();
                });
                tablePlanteles.api().ajax.reload();  
            }else{
                swal.fire("Error", objData.msg, "error");
            }
             
        }
        divLoading.style.display = "none";
        return false;
    }
}

//Funcion para obtener el ID del Estado en el Select y obtener lista de Municipios
function estadoSeleccionado(value){
    if(value == ''){
        selMunicipio.innerHTML = "<option value=''>Seleccionar ...</option>";
        selLocalidades.innerHTML = "<option value=''>Seleccionar ...</option>";
        return false;
    }
    divLoading.style.display = "flex";
    let url = base_url+"/Planteles/getMunicipios?idestado="+value;
    fetch(url)
    .then(res => res.json())
    .then((resultado) => {
		selMunicipio.innerHTML = "<option value=''>Seleccionar ...</option>";
        for (let i = 0; i < resultado.length; i++) {
            opcion = document.createElement('option');
            opcion.text = resultado[i]['nombre'];
            opcion.value = resultado[i]['id'];
            selMunicipio.appendChild(opcion);
        }
        divLoading.style.display = "none";
    })
    .catch(err => { throw err });
}

//Funcion para obtener el ID del Estado en el Select y obtener lista de Municipios
function estadoSeleccionadoEdit(value){
    if(value == ''){
        selMunicipioEdit.innerHTML = "<option value=''>Seleccionar ...</option>";
        selLocalidadesEdit.innerHTML = "<option value=''>Seleccionar ...</option>";
        return false;
    }
    divLoading.style.display = "flex";
    let url = base_url+"/Planteles/getMunicipios?idestado="+value;
    fetch(url)
    .then(res => res.json())
    .then((resultado) => {
		selMunicipioEdit.innerHTML = "<option value=''>Seleccionar ...</option>";
		selLocalidadesEdit.innerHTML = "<option value=''>Seleccionar ...</option>";
        for (let i = 0; i < resultado.length; i++) {
            opcion = document.createElement('option');
            opcion.text = resultado[i]['nombre'];
            opcion.value = resultado[i]['id'];
            selMunicipioEdit.appendChild(opcion);
        }
        divLoading.style.display = "none";
    })
    .catch(err => { throw err });
}

//Funcion para obtener el ID del Municipio en el Select y obtener lista de Localidades
function municipioSeleccionado(value){
    if(value == ''){
        selLocalidades.innerHTML = "<option value=''>Seleccionar ...</option>";
        return false;
    }
    divLoading.style.display = "flex";
    let url = base_url+"/Planteles/getLocalidades?idmunicipio="+value;
    fetch(url)
    .then(res => res.json())
    .then((resultado) => {
		selLocalidades.innerHTML = "<option value=''>Seleccionar ...</option>";
        for (let i = 0; i < resultado.length; i++) {
            opcion = document.createElement('option');
            opcion.text = resultado[i]['nombre'];
            opcion.value = resultado[i]['id'];
            selLocalidades.appendChild(opcion);
        }
        divLoading.style.display = "none";
    })
    .catch(err => { throw err });        
}

//Funcion para obtener el ID del Municipio en el Select y obtener lista de Localidades
function municipioSeleccionadoEdit(value){
    if(value == ''){
        selLocalidadesEdit.innerHTML = '<option value="">Seleccionar ...</option>';
        return false;
    }
    divLoading.style.display = "flex";
    let url = base_url+"/Planteles/getLocalidades?idmunicipio="+value;
    fetch(url)
    .then(res => res.json())
    .then((resultado) => {
		selLocalidadesEdit.innerHTML = "";
        for (let i = 0; i < resultado.length; i++) {
            opcion = document.createElement('option');
            opcion.text = resultado[i]['nombre'];
            opcion.value = resultado[i]['id'];
            selLocalidadesEdit.appendChild(opcion);
        }
        divLoading.style.display = "none";
    })
    .catch(err => { throw err });        
}

//Funcion para Editar Plantel
function fntEditPlantel(idPlantel){
    let idplantel = idPlantel;
    divLoading.style.display = "flex";
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl  = base_url+'/Planteles/getPlantel/'+idplantel;
    request.open("GET",ajaxUrl ,true);
	request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData){   
                document.querySelector("#id_edit").value = objData.id
                document.querySelector('#txt_nombre_edit').value = objData.nombre_plantel_fisico;
                let idEstadoPlantel = "";
                let idMunicipioPlantel = "";
                let idLocalidadPlantel = "";
                document.querySelector('#select_municipio_edit').innerHTML = "";
                document.querySelector('#select_localidad_edit').innerHTML = "";
                let url = base_url+"/Planteles/getListEstados";
                fetch(url)
                .then(res => res.json())
                .then((resultado) => {
                    for (let i = 0; i < resultado.length; i++) {
                        document.querySelector('#select_estado_edit').innerHTML += "<option value='"+resultado[i]['id']+"'>"+resultado[i]['nombre']+"</option>";
                        if(resultado[i]['nombre'] == objData.estado){
                            idEstadoPlantel = resultado[i]['id'];
                            select = document.querySelector('#select_estado_edit');
                            var opt = document.createElement('option');
                            opt.value = resultado[i]['id'];
                            opt.innerHTML = resultado[i]['nombre'];
                            opt.setAttribute("selected","");
                            select.appendChild(opt);
                            let urlMunicipios = base_url+"/Planteles/getMunicipios?idestado="+idEstadoPlantel;
                            fetch(urlMunicipios)
                            .then(res => res.json())
                            .then((resultadoMunicipio) =>{
                                resultadoMunicipio.forEach(element => {
                                    document.querySelector('#select_municipio_edit').innerHTML += "<option value='"+element['id']+"'>"+element['nombre']+"</option>"
                                    if(element['nombre'] == objData.municipio){
                                        idMunicipioPlantel = element['id'];
                                        selectMunicipio = document.querySelector('#select_municipio_edit');
                                        var optMunicipio = document.createElement('option');
                                        optMunicipio.value = element['id'];
                                        optMunicipio.innerHTML = element['nombre'];
                                        optMunicipio.setAttribute("selected","");
                                        selectMunicipio.appendChild(optMunicipio);
                                        let urlLocalidades = base_url+"/Planteles/getLocalidades?idmunicipio="+idMunicipioPlantel;
                                        fetch(urlLocalidades)
                                        .then(res => res.json())
                                        .then((resultadoLocalidad) =>{
                                            resultadoLocalidad.forEach(element => {
                                                document.querySelector('#select_localidad_edit').innerHTML += "<option value='"+element['id']+"'>"+element['nombre']+"</option>"
                                                if(element['nombre'] == objData.localidad){
                                                    idLocalidadPlantel = element['id'];
                                                    selectLocalidades = document.querySelector('#select_localidad_edit');
                                                    var optLocalidad = document.createElement('option');
                                                    optLocalidad.value = element['id'];
                                                    optLocalidad.innerHTML = element['nombre'];
                                                    optLocalidad.setAttribute("selected","");
                                                    selectLocalidades.appendChild(optLocalidad);
                                                }
                                            });
                                        })
                                        .catch(err => {throw err});
                                        }

                                    });
                                })
                                .catch(err => {throw err});
                        }
                    }
                })
                .catch(err => { throw err });
                document.querySelector('#txt_domicilio_edit').value = objData.domicilio;
                document.querySelector('#txt_colonia_edit').value = objData.colonia;
                document.querySelector('#txt_codigo_postal_edit').value = objData.cod_postal;
                document.querySelector('#txt_latitud_edit').value = objData.latitud;
                document.querySelector('#txt_longitud_edit').value = objData.longitud;
                document.querySelector('#select_estatus_edit').querySelector('option[value="'+objData.estatus+'"]').selected = true;
            }else{
                swal.fire("Error", objData.msg , "error");
            }
            
        }
        divLoading.style.display = "none";
        return false;
    }
    
}

formPlantelEdit.onsubmit = function(e){
    e.preventDefault();
    let strNombre = document.querySelector('#txt_nombre_edit').value;
    let intEstado = document.querySelector('#select_estado_edit').value;
    let intMunicipio = document.querySelector('#select_municipio_edit').value;
    let intLocalidad = document.querySelector('#select_localidad_edit').value;
    let strDomicilio = document.querySelector('#txt_domicilio_edit').value;
    let strColonia = document.querySelector('#txt_colonia_edit').value;
    let intCodigoPostal = document.querySelector('#txt_codigo_postal_edit').value;

    if (strNombre == '' || intEstado == '' || intMunicipio == '' || intLocalidad == '' || strDomicilio == '' || strColonia == '' || intCodigoPostal == '' ) {
        swal.fire("Atención", "Atención todos los campos son obligatorios", "warning");
        return false;
    }
    divLoading.style.display = "flex";
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url+'/Planteles/setPlantel';
    var formData = new FormData(formPlantelEdit);
    request.open("POST",ajaxUrl,true);
    request.send(formData);
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            var objData = JSON.parse(request.responseText);
            if(objData.estatus){
                $('#modal_form_edit_plantel').modal("hide");
                formPlantelEdit.reset();
                swal.fire("Planteles", objData.msg, "success").then((result) =>{
                    $('.close').click();
                });
                tablePlanteles.api().ajax.reload();  
            }else{
                swal.fire("Error",objData.msg, "error");
            }
        }
        divLoading.style.display = "none";
        return false;
    }
}

function fntVerPlantel(idPlantel){
    divLoading.style.display = "flex";
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl  = base_url+'/Planteles/getPlantel/'+idPlantel;
    request.open("GET",ajaxUrl ,true);
	request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var objData = JSON.parse(request.responseText);
            if(objData){   
                document.querySelector('#txt_nombre_ver').value = objData.nombre_plantel_fisico;
                document.querySelector('#select_estado_ver').value = objData.estado;
                document.querySelector('#select_municipio_ver').value = objData.municipio;
                document.querySelector('#select_localidad_ver').value = objData.localidad;
                document.querySelector('#txt_colonia_ver').value = objData.colonia;
                document.querySelector('#txt_domicilio_ver').value = objData.domicilio;
                document.querySelector('#txt_codigo_postal_ver').value = objData.cod_postal;
                document.querySelector('#txt_latitud_ver').value = objData.latitud;
                document.querySelector('#txt_longitud_ver').value = objData.longitud;
                let estatus = (objData.estatus == 1)?'Activo':'Inactivo';
                document.querySelector('#select_estatus_ver').value = estatus;
            }else{
                swal.fire("Error", objData.msg , "error");
            } 
        }
        divLoading.style.display = "none";
        return false;
    }
}

//Funcion para Eliminar Plantel
function fntDelPlantel(id) {
    swal.fire({
        icon: "question",
        title: "Eliminar plantel",
        text: "¿Realmente quiere eliminar el plantel?",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33', 
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!"
    }). then((result) => {
        if (result.isConfirmed){
            divLoading.style.display = "flex";
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'/Planteles/delPlantel'; 
            var strData = "idPlantel="+id;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    var objData = JSON.parse(request.responseText);
                    if(objData.estatus){
                        swal.fire("Eliminar!", objData.msg , "success");
                        tablePlanteles.api().ajax.reload();

                    } else {
                        swal.fire("Atención!", objData.msg , "error");
                    } 
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    });
}

//Funcion para Aceptar solo Numeros en un Input
function validarNumeroInput(event){
    if(event.charCode >= 48 && event.charCode <= 57){
        return true;
    }
    return false;
}