<?php
setlocale(LC_ALL,"es_ES.UTF-8");
setlocale(LC_TIME, 'spanish');
date_default_timezone_set('America/Mexico_City');
// $userAtencion = $data['data'][0]['nombre_usuario'];
// $userAlumno = $data['data'][0]['nombre_alumno'];
// $fechaEntrega = $data['data'][0]['fecha_estimada_devolucion'];
// $formatFechaEntrega = iconv('ISO-8859-2', 'UTF-8', strftime("%A, %d de %B de %Y", strtotime($fechaEntrega)));
// $formatFechaEntrega = iconv('', 'UTF-8', strftime("%A, %d de %B de %Y", strtotime($fechaEntrega)));
// $formatFechaActual = iconv('ISO-8859-2', 'UTF-8', strftime("%A, %d de %B de %Y", strtotime(date('Y-m-d'))));
// $formatFechaActual = iconv('', 'UTF-8', strftime("%A, %d de %B de %Y", strtotime(date('Y-m-d'))));
// $nombreCarrera = $data['data'][0]['nombre_carrera'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hitorial documentacion</title>
    <style type="text/css">
        body {
            background-size:100%;
            background-repeat: no-repeat;
            font-family: "Source Sans Pro",-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
        }
        .col-8 {
            float: left;
            width: 66.67%;
            padding: 0px;
        }
        .col-6 {
            float: left;
            width: 50%;
            padding: 0px;
        }
        .col-3 {
            float: left;
            width: 25%;
            padding: 0px;
        }
        .col-2 {
            float: left;
            width: 16.667%;
            padding: 0px;
        }
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
        h3{
            color:white;
            margin: 0px;
        }
        .invoice-box {
        max-width: 800px;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
        }

    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }

    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    .invoice-box table tr.information table td {
        padding-bottom: 10px;
        font-size: 12px;
    }
    .invoice-box table tr.information table td {
        width: 100%;
        display: block;
        text-align: center;
    }
    .footer {
        position: fixed;
        left: 0;
        bottom: 0;
        color: black;
        font-size: 10px;
        width: 100%;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        text-align: center;
    }




    .nomCaja{
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }

    .totalEfectvo h4{
        background-color: #b7bdc9;
    }
    section .datosCorte{
        padding-bottom: 300px;
    }
    .totalEfectvoEntrega{
        padding-top: 25%;
        padding-bottom: 10%;
    }

    </style>
</head>
<body>

    <div class="cabecera">
        <div>
            <div class="row">
                <div class="col-2">
                    <img src="<?php echo(media().'/images/Logo_seuat_color.jpeg') ?>" height="80" width="80">
                </div>
                <div class="col-8" style="text-align:center">
                    <!-- <p><b>SISTEMA EDUCATIVO UNIVERSITARIO AZTECA</b><br> -->
                    <p><b><?php echo(strtoupper($data['datosSistema']['nombre_sistema']))?></b><br><br>
                        <!-- <small style="font-size: 13px"><b>INSTITUTO DE ESTUDIOS SUPERIORES "SOR JUANA INES DE LA CRUZ"</b></small><br> -->
                        <!-- <small>Incorporado a la Secretaría de Educación Pública</small><br> -->
                        <small><?php echo $data['datosSistema']['domiciLocaliPlantel']?> Chiapas</small><br>
                        <small>Código postal: <?php echo $data['datosSistema']['cod_postal']?></small><br>
                    </p>
                </div>
                <div class="col-2" style="text-align:right">
                    <img src="<?php echo(media().'/images/logo_iessic.jpg') ?>" height="80" width="80">
                </div>
            </div>
        </div>
        <div></div>   
    </div>
    <div class="col-12" style="text-align:center">
        <h4>COMPROBANTE DE CORTE</h4>
    </div>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="information">
                <td colspan="12">
                    <table>
                        <tr>
                            <td class="nomCaja">
                                <b>CORTE DE: <?php echo(strtoupper($data['datosSistema']['nombreCaja']))?> </b>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr> 
        </table>
    </div>

    <div>
        <div class="col-6">
            <p>DETALLE CORTE</p>
        </div>
        <div class="col-6" style="text-align:right">
            <p>FOLIO: <?php echo(strtoupper($data['datosSistema']['folio']))?></p>
        </div><br><br>
        <div>
            <hr>
        </div>
    </div>

    <section>
        <div class="datosCorte">
            <div class="col-6">
                <p>Hecho por:</p>
                <p>Fondo recibido:</p>
                <p>Sobrante:</p>
                <p>Faltante:</p>
                <!-- <p>Efectivo Inicial:</p> -->
                <p>Fecha de apertura:</p>
                <p>Fecha de Cierre:</p>
            </div>
            <div class="col-6" style="text-align:right">
                <p><?php echo(strtoupper($data['datosSistema']['nomCajero']))?></p>
                <p><?php echo(strtoupper($data['datosSistema']['cantidad_recibida']))?></p>
                <p><?php echo(strtoupper($data['datosSistema']['dinero_sobrante']))?></p>
                <p><?php echo(strtoupper($data['datosSistema']['dinero_faltante']))?></p>
                <p><?php echo(strtoupper($data['datosSistema']['fechayhora_apertura_caja']))?></p>
                <p><?php echo(strtoupper($data['datosSistema']['fechayhora_cierre_caja']))?></p>
            </div>
        </div>
    </section><br>
    
    <div class="totalEfectvoEntrega">
        <div class="totalEfectvo">
            <div class="col-6">
                <h4>Total Efectivo a entregar:</h4>
            </div>
            <div class="col-6" style="text-align:right">
                <h4>$<?php echo $data['datosSistema']['cantidad_entregada']?></h4>
            </div>
        </div>
    </div>

    <br><br>
    <div style='text-align:center'>
        <h4>FIRMAS</h4>   
    </div>
    <div>
        <div class="col-6" style="text-align:center">
            <h4>Cajero(a)</h4><br>
            <hr style="width:50%">
            <!-- <p><?php echo $userAlumno ?></p> -->
            <p><?php echo $data['datosSistema']['nomCajero']?></p>
        </div>
        <div class="col-6" style="text-align:center">
            <h4>Autorizado por:</h4><br>
            <hr style="width:50%">
            <!-- <p><?php echo $userAtencion ?></p> -->
            <p>Francisco-Go</p>
        </div>
    </div>
    
    
    <div class="footer">
        <p>
            <small><br><i> Documento Impreso a <?php echo DATE('d-m-Y H:i:s') ?> por Jose Santiz Ruiz</i></small>
        </p>
    </div>
</html>