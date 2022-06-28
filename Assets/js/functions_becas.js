let tableBecas = document.querySelector('#tableBecas');
const frmNuevaBeca = document.querySelector('#formNuevaBeca');
let slctInst = document.querySelector('#slctInstitucion');


document.addEventListener('DOMContentLoaded', function(){
    tableBecas = $('#tableBecas').dataTable( {
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
			{"data": "id_periodos"},
            {"data": "id_plan_estudios"},
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
	let idNuevaBeca = document.querySelector('');
	let nombreBeca = document.querySelector('');
	let descBeca = document.querySelector('');
	let periodo = document.querySelector('');
	let carrera = document.querySelector('');
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

		.catch(function(err){
			console.log('Error', err);
		})
})

function fnEditarBeca(idBeca)
{
	let idBecaEdit = idBeca;
	let url = `${base_url}/Becas/getBeca/${idBecaEdit}`;
	let txtNomBecaEdit = document.querySelector();
	let txtPctBecaEdit = document.querySelector();
	let slctPeriodoEdit = document.querySelector();
	let slctCarreraEdit = document.querySelector();
}


function fnElegirPlantel()



function fnElegirInstitucion(idPlantel){
	let url = `${base_url}/Becas/getInstiticion/${idPlantel}`;
	fetch(url)
		.then(response => response.json())
		.then(data =>{
			for (let i = 0; i < data.length; i++) {
				if(data[i]['id'] == "" & data[i]['nombre_institucion'] == "")
				{
					slctInst.text="Seleccione...";
					slctInst.value="";
				}
				else
				{
					opc = document.createElement('option');
					opc.text = data[i]['nombre_institucion'];
					opc.value = data[i]['id'];
					slctInst.appendChild(opc);
				}
			}
		})
	.catch(err => {throw err})
}