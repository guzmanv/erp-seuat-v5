var formInstitucionNuevo = document.querySelector("#form_nueva_institucion");
document.getElementById("btnAnterior").style.display = "none";
document.getElementById("btnAnteriorEdit").style.display = "none";
document.getElementById("btnSiguiente").style.display = "none";
document.getElementById("btnSiguienteEdit").style.display = "none";
document.getElementById("btnActionFormNuevo").style.display = "none";
document.getElementById("btnActionFormEdit").style.display = "none";
let divLoading = document.querySelector("#divLoading");

var tabActual = 0;
var tabActualEdit = 0;
mostrarTab(tabActual);
mostrarTabEdit(tabActualEdit);
var tablePlanEstudios;


//Mostrar Lista de Planteles de Datatable
document.addEventListener('DOMContentLoaded', function(){
	tableInstituciones = $('#tableInstituciones').dataTable( {
		"aProcessing":true,
		"aServerSide":true,
        "language": {
        	"url": " "+base_url+"/Assets/plugins/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Instituciones/getInstituciones",
            "dataSrc":""
        },
        "columns":[
            {"data":"numeracion"},
            {"data":"nombre_institucion"},
			{"data":"abreviacion_institucion"},
            {"data":"nom_sistema"},
            {"data":"nom_plantel"},
            {"data":"regimen"},
            {"data":"servicio"},
            {"data":"status"},
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

    //Funcion para Guardar Nuevo Plantel
    formInstitucionNuevo.onsubmit = function(e){
        e.preventDefault();
        document.querySelector("#id_institucion_nuevo").value = 1;
        let idPlantel = document.querySelector('#select_plantel_nuevo').value;
        let intIdSistemaEduvativo = document.querySelector('#select_sistema_educativo_nuevo').value;
        var strNombreInstitucion = document.querySelector('#txt_nombre_nuevo').value;
        var strAbreviacionInstitucion = document.querySelector('#txt_abreviacion_nuevo').value;
        var strRegimen = document.querySelector('#txt_regimen_nuevo').value;
        var intClaveCentroTrabajo = document.querySelector('#txt_clave_centro_trabajo_nuevo').value;
        var strServicio = document.querySelector('#txt_servicio_nuevo').value;
        var strCategoria = document.querySelector('#txt_categoria_nuevo').value;

        if (idPlantel == '' || intIdSistemaEduvativo == '' || strNombreInstitucion == '' || strAbreviacionInstitucion == '' || strRegimen == '' || 
            strServicio == '' || strCategoria == ''  || intClaveCentroTrabajo == ''){
                swal.fire("Atención", "Atención todos los campos son obligatorios", "warning");
                return false;
        }
        divLoading.style.display = "flex";
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'/Instituciones/setInstitucion';
        var formData = new FormData(formInstitucionNuevo);
        request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function() {
                if(request.readyState == 4 && request.status == 200) {
                    var objData = JSON.parse(request.responseText);
                    if(objData.estatus){
                        formInstitucionNuevo.reset();
                        $('#modal_form_nueva_institucion').modal("hide");
                        swal.fire("Instituciones", objData.msg, "success").then((result) =>{
                            $('.close').click();
                        });
                        tableInstituciones.api().ajax.reload();  
                    }else{
                        swal.fire("Error", objData.msg, "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
    }
});
$('#tableInstituciones').DataTable();



function fnNavTab(numTab){
    tabActual = numTab;
    var x = document.getElementsByClassName("tab");
    for( var i = 0; i<x.length;i++){
      x[i].style.display = "none";
    }
    x[numTab].style.display = "block";
    if (numTab == 0) {
        document.getElementById("btnSiguiente").style.display = "inline";
        document.getElementById("btnAnterior").style.display = "none";
      } else {
        document.getElementById("btnAnterior").style.display = "inline";
      }
      if (numTab == (x.length - 1)) {
        document.getElementById("btnSiguiente").style.display = "none";
        document.getElementById("btnActionFormNuevo").style.display = "inline";
      } else {
        document.getElementById("btnSiguiente").style.display = "inline";
        document.getElementById("btnActionFormNuevo").style.display = "none";
      }
    estadoIndicadores(numTab);
  
  }
  function fnNavTabEdit(numTab){
    tabActualEdit = numTab;
    var x = document.getElementsByClassName("tabEdit");
    for( var i = 0; i<x.length;i++){
      x[i].style.display = "none";
    }
    x[numTab].style.display = "block";
    if (numTab == 0) {
        document.getElementById("btnSiguienteEdit").style.display = "inline";
        document.getElementById("btnAnteriorEdit").style.display = "none";
      } else {
        document.getElementById("btnAnteriorEdit").style.display = "inline";
      }
      if (numTab == (x.length - 1)) {
        document.getElementById("btnSiguienteEdit").style.display = "none";
        document.getElementById("btnActionFormEdit").style.display = "inline";
      } else {
        document.getElementById("btnSiguienteEdit").style.display = "inline";
        document.getElementById("btnActionFormEdit").style.display = "none";
      }
    estadoIndicadoresEdit(numTab);
  }
  function mostrarTab(tabActual) {
    var tab = document.getElementsByClassName("tab");
    tab[tabActual].style.display = "block";
    if (tabActual == 0) {
      document.getElementById("btnSiguiente").style.display = "inline";
      document.getElementById("btnAnterior").style.display = "none";
    } else {
      document.getElementById("btnAnterior").style.display = "inline";
    }
    if (tabActual == (tab.length - 1)) {
      document.getElementById("btnSiguiente").style.display = "none";
      document.getElementById("btnActionFormNuevo").style.display = "inline";
    } else {
      document.getElementById("btnSiguiente").style.display = "inline";
      document.getElementById("btnActionFormNuevo").style.display = "none";
    }
    estadoIndicadores(tabActual)
  }
  function mostrarTabEdit(tabActualEdit) {
    var tab = document.getElementsByClassName("tabEdit");
    tab[tabActualEdit].style.display = "block";
    if (tabActualEdit == 0) {
      document.getElementById("btnSiguienteEdit").style.display = "inline";
      document.getElementById("btnAnteriorEdit").style.display = "none";
    } else {
      document.getElementById("btnAnteriorEdit").style.display = "inline";
    }
    if (tabActualEdit == (tab.length - 1)) {
      document.getElementById("btnSiguienteEdit").style.display = "none";
      document.getElementById("btnActionFormEdit").style.display = "inline";
    } else {
      document.getElementById("btnSiguienteEdit").style.display = "inline";
      document.getElementById("btnActionFormEdit").style.display = "none";
    }
    estadoIndicadoresEdit(tabActualEdit)
  }
  function pasarTab(n) {
    var x = document.getElementsByClassName("tab");
    //n = 1 : siguiente; n = -1 : anterior
    x[tabActual].style.display = "none";
    tabActual = tabActual + n;
    //console.log(tabActual);
    if (tabActual >= x.length) {
      //var jos = document.getElementById("formPlanEstudiosNueva").submit();
      //console.log(jos);
    }
    mostrarTab(tabActual);
    

  }
  function pasarTabEdit(n) {
    var x = document.getElementsByClassName("tabEdit");
    //n = 1 : siguiente; n = -1 : anterior
    x[tabActualEdit].style.display = "none";
    tabActualEdit = tabActualEdit + n;
   // console.log(tabActualEdit);

    if (tabActualEdit >= x.length) {
      //var jos = document.getElementById("formPlanEstudiosNueva").submit();
      //console.log(jos);
    }
    mostrarTabEdit(tabActualEdit);
    
  }
  function estadoIndicadores(tabActual) {
    var posStep, step = document.getElementsByClassName("step");
    var posTab, tab = document.getElementsByClassName("tab-nav");
    for (posStep = 0; posStep < step.length; posStep++) {
      step[posStep].className = step[posStep].className.replace(" active", "");
  
    }
    step[tabActual].className += " active";
    for (posTab = 0; posTab < tab.length; posTab++) {
      tab[posTab].className = tab[posTab].className.replace(" active", "");
    }
    tab[tabActual].className += " active";
  }
  function estadoIndicadoresEdit(tabActualEdit) {
    var posStep, step = document.getElementsByClassName("stepEdit");
    var posTab, tab = document.getElementsByClassName("tab-navEdit");
    for (posStep = 0; posStep < step.length; posStep++) {
      step[posStep].className = step[posStep].className.replace(" active", "");
  
    }
    step[tabActualEdit].className += " active";
    for (posTab = 0; posTab < tab.length; posTab++) {
      tab[posTab].className = tab[posTab].className.replace(" active", "");
    }
    tab[tabActualEdit].className += " active";
  }


//Funcion para obtener el ID del Estado en el Select y obtener lista de Municipios
function estadoSeleccionado(value){
    divLoading.getElementsByClassName.display = "flex";
    const $selMunicipio = document.querySelector('#listMunicipioNuevo');
    let url = base_url+"/Instituciones/getMunicipios?idestado="+value;
        fetch(url)
            .then(res => res.json())
            .then((resultado) => {
				$selMunicipio.innerHTML = "";
                for (let i = 0; i < resultado.length; i++) {
                    opcion = document.createElement('option');
                    opcion.text = resultado[i]['nombre'];
                    opcion.value = resultado[i]['id'];
                    $selMunicipio.appendChild(opcion);
                }
                divLoading.style.display = "none";
            })
            .catch(err => { throw err });
}
//Funcion para obtener el ID del Estado en el Select y obtener lista de Municipios
function estadoSeleccionadoEdit(value){
    const $selMunicipio = document.querySelector('#listMunicipioEdit');
    divLoading.getElementsByClassName.display = "flex";
    let url = base_url+"/Instituciones/getMunicipios?idestado="+value;
        fetch(url)
            .then(res => res.json())
            .then((resultado) => {
				$selMunicipio.innerHTML = "";
                for (let i = 0; i < resultado.length; i++) {
                    opcion = document.createElement('option');
                    opcion.text = resultado[i]['nombre'];
                    opcion.value = resultado[i]['id'];
                    $selMunicipio.appendChild(opcion);
                }
                divLoading.style.display = "none";
            })
            .catch(err => { throw err });
}
//Funcion para obtener el ID del Municipio en el Select y obtener lista de Localidades
function municipioSeleccionado(value){
    const $selLocalidades = document.querySelector('#listLocalidadNuevo');
    divLoading.getElementsByClassName.display = "flex";
    let url = base_url+"/Instituciones/getLocalidades?idmunicipio="+value;
        fetch(url)
            .then(res => res.json())
            .then((resultado) => {
				$selLocalidades.innerHTML = "";
                for (let i = 0; i < resultado.length; i++) {
                    opcion = document.createElement('option');
                    opcion.text = resultado[i]['nombre'];
                    opcion.value = resultado[i]['id'];
                    $selLocalidades.appendChild(opcion);
                }
                divLoading.style.display = "none";
            })
            .catch(err => { throw err });
            
}
//Funcion para obtener el ID del Municipio en el Select y obtener lista de Localidades
function municipioSeleccionadoEdit(value){
    const $selLocalidades = document.querySelector('#listLocalidadEdit');
    divLoading.getElementsByClassName.display = "flex";
    let url = base_url+"/Instituciones/getLocalidades?idmunicipio="+value;
        fetch(url)
            .then(res => res.json())
            .then((resultado) => {
				$selLocalidades.innerHTML = "";
                for (let i = 0; i < resultado.length; i++) {
                    opcion = document.createElement('option');
                    opcion.text = resultado[i]['nombre'];
                    opcion.value = resultado[i]['id'];
                    $selLocalidades.appendChild(opcion);
                }
                divLoading.style.display = "none";
            })
            .catch(err => { throw err });
            
}

//Funcion para el boton de Buscar Imagen del Plantel
function buscarImagenInstitucion(e){
    document.querySelector('#profileImageInstitucion').click();
}
//Funcion para el boton de Buscar Imagen del Plantel Edit
function buscarImagenInstitucionEdit(e){
    document.querySelector('#profileImageInstitucionEdit').click();
}
//Funcion para mostrar Imagen buscado del Plantel
function displayImageInstitucion(e) {
    if (e.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e){
            document.querySelector('#profileDisplayInstitucion').setAttribute('src', e.target.result);
            document.getElementById('btnBuscarImagenInstitucion').textContent = "Cambiar";
            document.querySelector('#btnBuscarImagenInstitucion').classList.replace("btn-primary", "btn-warning");
        }
        reader.readAsDataURL(e.files[0]);
    }
}
//Funcion para mostrar Imagen buscado del Plantel Edit
function displayImageInstitucionEdit(e) {
    if (e.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e){
            document.querySelector('#profileDisplayInstitucionEdit').setAttribute('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
    }
}
//Funcion para el boton de Buscar Imagen del Sistema
function buscarImagenInstitucion(f){
    document.querySelector('#profileImageInstitucion').click();
}
//Funcion para el boton de Buscar Imagen del Sistema Edit
function buscarImagenInstitucionEdit(f){
    document.querySelector('#profileImageInstitucionEdit').click();
}
//Funcion para mostrar Imagen buscado del Sistema
function displayImageInstitucion(f) {
    if (f.files[0]) {
        var reader = new FileReader();
        reader.onload = function(f){
            document.querySelector('#profileDisplayInstitucion').setAttribute('src', f.target.result);
            document.getElementById('btnBuscarImagenInstitucion').textContent = "Cambiar";
            document.querySelector('#btnBuscarImagenInstitucion').classList.replace("btn-primary", "btn-warning");
        }
        reader.readAsDataURL(f.files[0]);
    }
}
//Funcion para mostrar Imagen buscado del Sistema Edit
function displayImageInstitucionEdit(f) {
    if (f.files[0]) {
        var reader = new FileReader();
        reader.onload = function(f){
            document.querySelector('#profileDisplayInstitucionEdit').setAttribute('src', f.target.result);
        }
        reader.readAsDataURL(f.files[0]);
    }
}

//Funcion para Editar Plantel
function fntEditInstitucion(idInstitucion){
    var idInstitucion = idInstitucion;
    $('#step1-tabEdit').click();
    tabActualEdit = 0;
    divLoading.style.display = "flex";
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl  = base_url+'/Instituciones/getInstitucion/'+idInstitucion;
    request.open("GET",ajaxUrl ,true);
	request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var objData = JSON.parse(request.responseText);
            if(objData)
            {   
                document.querySelector("#idInstitucionEdit").value = objData.id
                document.querySelector('#txt_nombre_edit').value = objData.nombre_institucion;
                document.querySelector('#select_plantel_edit').querySelector('option[value="' +objData.id_planteles+ '"]').selected = true;
                document.querySelector('#select_sistema_educativo_edit').querySelector('option[value="' +objData.id_sistemas_educativos+ '"]').selected = true;
                document.querySelector('#select_estatus_edit').querySelector('option[value="' +objData.estatus+ '"]').selected = true;
                document.querySelector('#txt_abreviacion_edit').value = objData.abreviacion_institucion;
                document.querySelector('#txtRegimenEdit').value = objData.regimen;
                document.querySelector('#txtServicioEdit').value = objData.servicio;
                document.querySelector('#txtCategoriaEdit').value = objData.categoria;
                document.querySelector('#txtClaveCentroTrabajoEdit').value = objData.cve_centro_trabajo;
                document.querySelector('#txtCedulaFuncionamientoEdit').value = objData.cedula_funcionamiento;
                document.querySelector('#txtClaveInstitucionDGPEdit').value = objData.cve_institucion_dgp;
                document.querySelector('#txtZonaEscolarEdit').value = objData.zona_escolar;
                document.querySelector("#profileDisplayInstitucionEdit").src = base_url+"/Assets/images/logos/"+objData.logo_institucion;
            }else{
                swal.fire("Error", objData.msg , "error");
            }
        }
        divLoading.style.display = "none";
        return false;
    }
    
}

//Funcion para Eliminar Plantel
function fntDelInstitucion(id) {
    swal.fire({
        icon: "question",
        title: "Eliminar institución",
        text: "¿Realmente quiere eliminar la institución?",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33', 
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!"
    }). then((result) => {
        if (result.isConfirmed) 
        {
            divLoading.getElementsByClassName.display = "flex";
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url+'/Instituciones/delInstitucion'; 
            var strData = "idInstitucion="+id;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    var objData = JSON.parse(request.responseText);
                    if(objData.estatus)
                    {
                        swal.fire("Eliminar!", objData.msg , "success");
                        tableInstituciones.api().ajax.reload();

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

//Funcion para Ver Plantel
//Funcion para Editar Plantel
function fntVerInstitucion(idInstitucion){
    var idInstitucion = idInstitucion;
    divLoading.style.display = "flex";
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl  = base_url+'/Instituciones/getInstitucion/'+idInstitucion;
    request.open("GET",ajaxUrl ,true);
	request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            var objData = JSON.parse(request.responseText);
            if(objData)
            {   
                document.querySelector('#titModal').innerHTML = objData.nombre_institucion;
                document.querySelector('#txtNombreInstitucionVer').value = objData.nombre_institucion;
                document.querySelector('#txtAbreviacionInstitucionVer').value = objData.abreviacion_institucion;
                document.querySelector('#txtRegimenVer').value = objData.regimen;
                document.querySelector('#txtClaveCentroTrabajoVer').value = objData.cve_centro_trabajo;
                document.querySelector('#txtServicioVer').value = objData.servicio;
                document.querySelector('#txtCategoriaVer').value = objData.categoria;
                document.querySelector('#txtZonaEscolarVer').value = objData.zona_escolar;
                document.querySelector('#txtCedulaFuncionamientoVer').value = objData.cedula_funcionamiento;
                document.querySelector('#txtClaveInstitucionDGPVer').value = objData.cve_institucion_dgp;
                document.querySelector("#profileInstitucionVer").src = base_url+"/Assets/images/logos/"+objData.logo_institucion;
                document.querySelector('#select_plantel_ver').querySelector('option[value="'+objData.id_planteles+'"]').selected = true;
                document.querySelector('#select_sistema_educativo_ver').querySelector('option[value="'+objData.id_sistemas_educativos+'"]').selected = true;
            }else{
                swal.fire("Error", objData.msg , "error");
            }    
        }
        divLoading.style.display = "none";
        return false;
    }
}
//Funcion para guardar datos del Plantel Editado
var formEditInstitucion = document.querySelector("#formEditInstitucion");
formEditInstitucion.onsubmit = function(e){
        e.preventDefault();
        var strNombreInstitucion = document.querySelector('#txt_nombre_edit').value;
        let intIdPlantel = document.querySelector('#select_plantel_edit').value;
        let intIdSistemaEducativo = document.querySelector('#select_sistema_educativo_edit').value;
        var strAbreviacionInstitucion = document.querySelector('#txt_abreviacion_edit').value;
        var strRegimen = document.querySelector('#txtRegimenEdit').value;
        var strServicio = document.querySelector('#txtServicioEdit').value;
        var strCategoria = document.querySelector('#txtCategoriaEdit').value;
        var intClaveCentroTrabajo = document.querySelector('#txtClaveCentroTrabajoEdit').value;
        
        if (strNombreInstitucion == '' || intIdPlantel == '' || intIdSistemaEducativo == ''  || strAbreviacionInstitucion == '' || strRegimen == '' || strServicio == '' || strCategoria == '' || intClaveCentroTrabajo == ''){
            swal.fire("Atención", "Atención todos los campos son obligatorios", "warning");
            return false;
        }
        divLoading.style.display = "flex";
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url+'/Instituciones/setInstitucion';
        var formData = new FormData(formEditInstitucion);
        request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function() {
                if(request.readyState == 4 && request.status == 200) {
                    var objData = JSON.parse(request.responseText);
                    if(objData.estatus){
                        $('#ModalFormEditPlantel').modal("hide");
                        formEditInstitucion.reset();
                        swal.fire("Institucion", objData.msg, "success").then((result) =>{
                            $('.close').click();
                        });
                        tableInstituciones.api().ajax.reload();  
                    }else{
                        swal.fire("Error",objData.msg, "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
    }

//Funcion para Aceptar solo Numeros en un Input
function validarNumeroInput(event){
    if(event.charCode >= 48 && event.charCode <= 57){
        return true;
    }
    return false;
}
function btnNuevaInstitucion(){
    $('#step1-tab').click();
    tabActual = 0;
    document.querySelector("#profileDisplayInstitucion").src = base_url+"/Assets/images/img/logo-empty.png";
    document.getElementById('btnBuscarImagenInstitucion').textContent = "Agregar";
    document.querySelector('#btnBuscarImagenInstitucion').classList.replace("btn-warning", "btn-primary");

}