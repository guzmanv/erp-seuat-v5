let selectPlanteles = document.querySelector("#list_plantel");
let selectInstituciones = document.querySelector("#list_institucion");
let selectNievelesEducativos = document.querySelector("#list_nivel_educativo");
let idPlantelSeleccionado = null;
let idInstitucionSeleccionado = null;
let idNivelSeleccionado = null;
function fnSelectPlantel(id)
{
    if(id != ''){
        idPlantelSeleccionado = id;
        let url = `${base_url}/Inscripcion/getInstituciones/${id}`;
        fetch(url).then((res) => res.json()).then(response =>{
            if(response.length > 1){
                selectInstituciones.innerHTML = "<option value=''>Seleccionar...</option>";
                let options = "";
                response.forEach(institucion => {
                    options += "<option value='"+institucion.id+"'>"+institucion.nombre_institucion+"</option>";
                });
                selectInstituciones.innerHTML += options;
            }else{
                selectInstituciones.innerHTML = "<option value=''>Seleccionar...</option>";
            }
        }).catch(err =>{throw err});
        fnPreenscritos(idPlantelSeleccionado);
    }else{
        idPlantelSeleccionado = null;
        selectInstituciones.innerHTML = "<option value=''>Seleccionar...</option>";
        selectNievelesEducativos.innerHTML = "<option value=''>Seleccionar...</option>";
    }
}
/* function fnSelectInstitucion(id)
{
    if(id != ''){
        let url = `${base_url}/Inscripcion/getNivelEducativo`;
    }
} */
function fnPreenscritos(plantel)
{
    let url = `${base_url}/Inscripcion/getPreenscritos/${plantel}`; 
    fetch(url).then((res)=> res.json()).then(response =>{
        let rows = "";
        if(response.length > 0){
            rows += "<tr><td></td><td></td><td></td><td></td><td></td></tr>";
        }
        document.querySelector("#table_preeinscripcion").innerHTML = rows;
    }).catch(err =>{throw err});
}