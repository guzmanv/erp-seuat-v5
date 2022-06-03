var $salesChart = $('#sales-chart');
var $salesChartPlantel= $('#sales-chart-plantel');
var arrPlanteles = [];
var carreras = [];
var materias = [];
var rvoes = [];
let idPlantelSeleccionado = null;
let idInstitucionSeleccionado = null;

document.addEventListener('DOMContentLoaded', function(){
    idPlantelSeleccionado = 'all';
    idInstitucionSeleccionado = 'all';
    let plantel = "all";
    fnTotalesCard(plantel,'all');
    plEstudioMateriabyInstitucion(plantel,'all');
    document.querySelector('#sales-chart-plantel').style.display = "none";
    document.querySelector('#sales-chart').style.display = "none";
    document.querySelector('.divnomplant').style.display = "none";
    document.querySelector('#listInstituciones').innerHTML = '<option value="all">Todos</option>';
});
//var $salesChartPlantel = $('#sales-chart-plantel');
function plantelSeleccionado(plantel){
    idPlantelSeleccionado = plantel;
    if(plantel == 'all'){
        document.querySelector('#listInstituciones').innerHTML = '<option value="all" selected>Todos</option>';
        idInstitucionSeleccionado = 'all';
        fnTotalesCard(plantel,idInstitucionSeleccionado);
        plEstudioMateriabyInstitucion(plantel,institucionSeleccionado);
    }else{
        document.querySelector('#listInstituciones').innerHTML = '<option value="all" selected>Todos</option>';
        let url = `${base_url}/DashboardDirc/getInstituciones/${plantel}`;
        fetch(url).then((res) => res.json()).then(resultado =>{
            resultado.forEach(institucion => {
                document.querySelector('#listInstituciones').innerHTML += '<option value="'+institucion.id+'">'+institucion.nombre_institucion+'</option>';
            });
        }).catch(err => {throw err});
        fnTotalesCard(plantel,idInstitucionSeleccionado);
        /*plEstudioMateriabyPlantel(plantel,'all'); */
    } 

}
function fnTotalesCard(plantel,institucion){
    let url = base_url+"/DashboardDirc/getTotalesCard/"+plantel+"/"+institucion;
    fetch(url).then(res => res.json()).then((resultado) => {
        console.log(resultado)
        if(resultado.tipo == "all"){
            document.querySelector('.divnomplant').style.display = "none";
            document.querySelector('.divplant').style.display = "block";
            document.querySelector('#sales-chart').style.display = "flex";
            document.querySelector('#sales-chart-plantel').style.display = "none";
            document.querySelector('.plnt').innerHTML=resultado.instituciones;
            document.querySelector('.ple').innerHTML=resultado.plan_estudios;
            document.querySelector('.mat').innerHTML=resultado.materias;
            document.querySelector('.rvoeexp').innerHTML=resultado.rvoes;
            document.getElementById('btnRvoesExp').setAttribute('onClick', 'fnRvoeExp();' );
        }else{
            document.querySelector('.divnomplant').style.display = "block";
            document.querySelector('#sales-chart').style.display = "none";
            document.querySelector('#sales-chart-plantel').style.display = "flex";
            document.querySelector('.divplant').style.display = "none";
            document.querySelector('.ple').innerHTML=resultado.plan_estudios;
            document.querySelector('.mat').innerHTML=resultado.materias;
            document.querySelector('.rvoeexp').innerHTML=resultado.rvoes;
            document.getElementById('btnRvoesExp').setAttribute('onClick', 'fnRvoeExp('+plantel+');' );
        }
        }).catch(err => { throw err });
}

function institucionSeleccionado(value){
/*     idPlantelSeleccionado = value;
    let nomConexion = document.getElementById('listSuperplanteles').value;
    if(value == 'all'){
        fnTotalesCard(nomConexion,'all');
        plEstudioMateriabyPlantel(nomConexion,'all')
    }else{
        fnTotalesCard(nomConexion,value);
        plEstudioMateriabyPlantel(nomConexion,value)
    } */
}


function plEstudioMateriabyInstitucion(plantel,institucion){
/*     let url = base_url+"/DashboardDirc/getPlanEstudiosMateriabyInstitucion/"+plantel+"/"+plantel;
    fetch(url).then(res => res.json()).then((resultado) => {
        arrPlanteles = [];
        carreras = [];
        materias = [];
        rvoes = [];
        for ( const [key,value] of Object.entries( resultado ) ) {
            arrPlanteles.push(value.abreviacion_plantel+'('+value.municipio+')');
            carreras.push(value.carreras);
            materias.push(value.materias);
            rvoes.push(value.rvoes);
        }
        if(arrPlanteles[0]!= null){
            fnMostrarGrafica(arrPlanteles,carreras,materias);
            document.querySelector('#sales-chart').style.display = 'block';
            document.querySelector('#sales-chart-plantel').style.display = "none";
        }else{
            
        }
        }).catch(err => { throw err });  */
}
function fnMostrarGrafica(arrPlanteles,carreras,materias){
    var ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
      }
    var mode = 'index'
    var intersect = true
    // eslint-disable-next-line no-unused-vars
    var salesChart = new Chart($salesChart, {
      type: 'bar',
      data: {
        labels: arrPlanteles,
        datasets: [
          {
            backgroundColor: '#007bff',
            borderColor: '#007bff',
            data: carreras
          },
          {
            backgroundColor: '#ced4da',
            borderColor: '#ced4da',
            data: materias
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          mode: mode,
          intersect: intersect
        },
        hover: {
          mode: mode,
          intersect: intersect
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            // display: false,
            gridLines: {
              display: true,
              lineWidth: '4px',
              color: 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
          }],
          xAxes: [{
            display: true,
            gridLines: {
              display: false
            },
            ticks: ticksStyle
          }]
        }
      }
    })
}
function fnMostrarGraficaPlantel(carreras,materias){
    var ticksStyle = {
        fontColor: '#495057',
        fontStyle: 'bold'
      }
    var mode = 'index'
    var intersect = true
    // eslint-disable-next-line no-unused-vars
    var salesChart = new Chart($salesChartPlantel, {
      type: 'bar',
      data: {
        datasets: [
          {
            backgroundColor: '#007bff',
            borderColor: '#007bff',
            data: carreras
          },
          {
            backgroundColor: '#ced4da',
            borderColor: '#ced4da',
            data: materias
          }
        ]
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          mode: mode,
          intersect: intersect
        },
        hover: {
          mode: mode,
          intersect: intersect
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            // display: false,
            gridLines: {
              display: true,
              lineWidth: '4px',
              color: 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
          }],
          xAxes: [{
            display: true,
            gridLines: {
              display: false
            },
            ticks: ticksStyle
          }]
        }
      }
    })
}
function fnRvoeExp(){
    document.querySelector('#tableRvoesExp').innerHTML = "";
    document.querySelector('#alertSinRvoeExp').innerHTML = "";
    let url = base_url+"/DashboardDirc/getListaRvoesExpirar/"+conexionSeleccionado+"/"+idPlantelSeleccionado;
    fetch(url).then(res => res.json()).then((resultado) => {
        if(resultado.length != 0){
            let contador = 0;
            resultado.forEach(element => {
                contador += 1;
                document.querySelector('#tableRvoesExp').innerHTML += "<tr><td>"+contador+"</td><td>"+element.nombre_carrera+"</td><td>"+element.abreviacion_sistema+"</td><td>"+element.abreviacion_plantel+"("+element.municipio+")"+"</td><td>"+element.rvoe+"</td><td><span class='badge badge-danger'>"+element.fecha_actualizacion_rvoe+"</span></td></tr>";                
            });
        }else{
            document.querySelector('#alertSinRvoeExp').innerHTML += '<div class="alert alert-warning" role="alert">No hay datos que mostrar</div>';                
        } 
    }).catch(err => { throw err });
    /* if(value != undefined){
    }else{
        let url = base_url+"/DashboardDirc/getListaRvoesExpirar/all";
        fetch(url).then(res => res.json()).then((resultado) => {
            let contador = 0;
            resultado.forEach(element => {
                contador += 1;
                document.querySelector('#tableRvoesExp').innerHTML += "<tr><td>"+contador+"</td><td>"+element.nombre_carrera+"</td><td>"+element.abreviacion_sistema+"</td><td>"+element.abreviacion_plantel+"("+element.municipio+")"+"</td><td>"+element.rvoe+"</td><td><span class='badge badge-danger'>"+element.fecha_actualizacion_rvoe+"</span></td></tr>";                
            });
        }).catch(err => { throw err });
    } */
}