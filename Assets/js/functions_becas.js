let tableBecas = document.querySelector('#tableBecas');
const frmNuevaBeca = document.querySelector('#formNuevaBeca');
let slctInst = document.querySelector('#slctInstitucion');
let slctCrr = document.querySelector('#slctCarrera')

document.addEventListener('DOMContentLoaded', function(){
    tableBecas = $('#tableBecas').dataTable({
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
			{"data": "nombre_periodo"},
            {"data": "nombre_carrera"},
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

$('#tableBecas').dataTable();

function fnNuevaBeca(){
	document.querySelector('#idBecaNueva').value = 1;
}

//Nueva Beca
frmNuevaBeca.addEventListener('submit', (e) =>{
	e.preventDefault();
	let idNuevaBeca = document.querySelector('idBecaNueva');
	let nombreBeca = document.querySelector('txtNuevaBeca');
	let descBeca = document.querySelector('txtPorcentaje');
	let periodo = document.querySelector('slctPeriodo');
	let carrera = document.querySelector('slctInstitucion');
	if(nombreBeca == "" || descBeca == "" | periodo == "" | carrera == "")
	{
		swal.fire("Atención","Atención, todos los campos son obligatorios","warning");
		return false;
	}
	idNuevaBeca = 1;
	const datosNuevo = new FormData(document.getElementById('formNuevaBeca'));
	let url = `${base_url}/Becas/setBecas`;
	fetch(url,{
		method: 'POST',
		body: datosNuevo
	})
		.then(response => response.json())
		.then(data => {
			if(data.estatus)
			{
				$('#cancelarModalNTurno').click();
				frmNuevaBeca.reset();
				swal.fire('Beca',data.msg,'success');
				tableBecas.api().ajax.reload();
			}
			else
			{
				swal.fire('Error',data.msg,'error');
			}
		})
})

function fnElegirInstitucion(idPlt){
	let url = `${base_url}/Becas/getInstitucion?idIns=${idPlt}`;
	//console.log(url);
	fetch(url)
	.then(response => response.json())
	.then(data => {
		slctInst.innerHTML="";
		for(let i = 0; i < data.length; i++){
			if(data[i]['id'] == "" && data[i]['nombre_institucion'] == "")
			{
				slctInst.text = "Seleccione...";
				slctInst.value = "";
			}
			else
			{
				let opc = document.createElement('option');
				opc.text = data[i]['nombre_institucion'];
				opc.value = data[i]['id'];
				slctInst.appendChild(opc);
			}
		}
	})
	.catch(err => {throw err})
}

function fnElegirCarrera(idNvl)
{
	let url = `${base_url}/Becas/getCarrera?idNivel=${idNvl}`;
	fetch(url)
		.then(response => response.json())
		.then(data => {
			console.log(data)
			slctCrr.innerHTML = "";
			for (let i = 0; i < data.length; i++) {
				console.log(data)
				if (data[i]['id'] == "" && data[i]['nombre_carrera'] == "") {
					slctCrr.text = "Seleccione..."
					slctCrr.value= ""
				} else {
					let opc = document.querySelector('option');
					opc.text = data[i]['nombre_carrera'];
					opc.text = data[i]['id'];
					slctCrr.appendChild(opc)
				}
			}
		})
}