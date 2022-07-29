<?php
setlocale(LC_ALL,"es_ES.UTF-8");
setlocale(LC_TIME, 'spanish');
date_default_timezone_set('America/Mexico_City');

date_default_timezone_set('America/Mexico_City');
$formatFechaActual = iconv('ISO-8859-2', 'UTF-8', strftime("%d/%m/%Y", strtotime(date('Y-m-d'))));
$datosPlantel = $data['plantel'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Your receipt</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
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

    <div class="cabecera">
        <div>
            <div class="row">
                <div class="col-2">
                    <img src="<?php echo(media().'/images/Logo_seuat_color.jpeg') ?>" height="80" width="80">
                </div>
                <div class="col-8" style="text-align:center">
                    <p><b><?php echo(strtoupper($datosPlantel['nombre_sistema']))?></b><br><br>
                    <b><?php echo(strtoupper($datosPlantel['nombre_plantel_fisico'])) ?></b><br>
                        <!-- <small><?php echo $datosPlantel['domicilio'].', '.$datosPlantel['colonia'].', '.$datosPlantel['municipio'].', '.$datosPlantel['estado'].', Mexico, CP: '.$datosPlantel['cod_postal'] ?></small><br> -->
                        <small><?php echo $datosPlantel['domicilio'].', '.$datosPlantel['colonia'].', '.$datosPlantel['municipio'].', '.$datosPlantel['estado'].', Mexico.' ?></small><br>
                        <small>Código postal: <?php echo $datosPlantel['cod_postal']?></small><br>
                    </p>
                </div>
                <div class="col-2" style="text-align:right">
                    <img src="<?php echo(media().'/images/logo_iessic.jpg') ?>" height="80" width="80">
                </div>
            </div>
        </div>
        <div></div>   
    </div>
    <div class="col-12" style="text-align:center"><br>
    <div style="width:759px; font-size:16px; font-weight: bold; letter-spacing: 0.2em; text-align: center; "> COMPROBANTE DE CORTE CAJA</div>
        <!-- <h4>COMPROBANTE DE CORTE CAJA</h4> -->
    </div>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="information">
                <td colspan="12">
                    <table>
                        <tr>
                            <td class="nomCaja">
                                <b>CORTE DE: <?php echo(strtoupper($data['nombreCaja'])); ?> </b>
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
            <p>FOLIO: <?php echo "TGZ01010";?></p>
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
                <p><?php echo(strtoupper($data['plantel']['nomPer']))?></p>
                <p><?php echo '$ '.formatoMoneda($data['fondoRecibido']);?></p>
                <p><?php echo '$ '.formatoMoneda($data['sobrante']);?></p>
                <p><?php echo '$ '.formatoMoneda($data['faltante']);?></p>
                <p><?php echo $data['fechaCorteDesde'];?></p>
                <p><?php echo $data['fechaCorteHasta'];?></p>
            </div>
        </div>
    </section><br>
    
    <div class="totalEfectvoEntrega">
        <div class="totalEfectvo">
            <div class="col-6">
                <h4>Total Efectivo a entregar:</h4>
            </div>
            <div class="col-6" style="text-align:right">
                <h4><?php echo '$ '.formatoMoneda($data['total_sistema']) ?></h4>
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
            <p><?php echo $data['plantel']['nomPer']?></p>
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
            <small><br><i> Documento Impreso a <?php echo DATE('d-m-Y H:i:s') ?> por <?php echo $data['plantel']['nomPer']; ?></i></small>
        </p>
    </div>
</html>