<?php
/**
 * Description of Generador correos
 *
 * Esta clase contiene todas las funciones usadas para enviar los correos de confirmación
 * de ingreso de prestamo interbibliotecario.
 *
 * @author damanzano
 * @since 27/01/11
 */
include_once ('../model/Usuario.php');
include_once ('../model/SolicitudPrestamo.php');

class GeneradorCorreos{
  public static function confirmacionSolicitud($solicitud, $usuario, $idCasoMantis){
    $para = $solicitud->getCorreo();
    $asunto = utf8_decode('Notificación de solicitud de préstamo interbibliotecario');
	
    $mensaje = '
    <html>
      <head>
        <title>Notificaci&oacute;n de solicitud de pr&eacute;stamo interbibliotecario</title>
		<style>
		  body {
		  font-family:Arial, Helvetica, sans-serif;
		  font-size:15px }
		</style>
      </head>
      <body>
        <b>Cordial saludo '.$usuario->getNombre().',</b>
        <br />
        <br />
        <br />
		<p>
		  Le informamos que su solicitud de pr&eacute;stamo interbibliotecario ha sido registrada en nuestro sistema con el n&uacute;mero de solicitud '.$idCasoMantis.'.
		</p>
		Los datos que se recibieron en la solicitud son los siguientes:';
        
    foreach ($solicitud->getLibros() as $key => $value) {
          $mensaje.='<table border="1" cellpadding="4" cellspacing="0">
          <tr>
            <th align="right" colspan="2" align="center">Libro '.($key+1).'</th>			
          </tr>
          <tr>
            <th align="right">T&iacute;tulo</th>
			<td>'.utf8_decode($value['titulo']).'</td>
          </tr>
          <tr>
            <th align="right">Edici&oacute;n</th>
			<td>'.utf8_decode($value['edicion']).'</td>
          </tr>
		  <tr>
            <th align="right">Autor</th>
			<td>'.utf8_decode($value['autor']).'</td>
          </tr>
		  <tr>
            <th align="right">Signatura</th>
			<td>'.utf8_decode($value['signatura']).'</td>
          </tr>
		  <tr>
            <th align="right">Instituci&oacute;n</th>
			<td>'.utf8_decode($value['institucion']).'</td>
          </tr>		  
          </table>';
		  
    }	  
		  
		  $mensaje .= '       
		<br/>
		Puede consultar la informaci&oacute;n y el estado de su solicitud en el Sistema de Gesti&oacute;n de Solicitudes: <a href="https://'.$_SERVER['SERVER_NAME'].'/solicitud_servicios/view.php?id='.$idCasoMantis.'">https://'.$_SERVER['SERVER_NAME'].'/solicitud_servicios/view.php?id='.$idCasoMantis.'</a>
		<br />
		<br />
		<br />
		<br />
		<b>
		  Biblioteca Universidad Icesi
		  <br/>
		  Direcci&oacute;n de Servicios y Recursos de Informaci&oacute;n
		  <br/>
		  Universidad Icesi
		</b>
      </body>
    </html>
    ';
    
    //Se agrega como encabezado el Content-type para que se env�e el correo como HTML
    $encabezados  = 'MIME-Version: 1.0' . "\r\n";
    $encabezados .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    
    //Se agrega el encabezado From para que aparezca un nombre 
    $encabezados .= 'From: Biblioteca Universidad Icesi <referencia-bib@listas.icesi.edu.co>' . "\r\n";
    return mail($para, $asunto, $mensaje, $encabezados);
  }
   
  
  public static function notificarEncargadoCaso($idCasoMantis, $solicitud, $correoUsuarioEncargado){
    $asunto = utf8_decode('Nueva solicitud de préstamo interbibliotecario recibida: '.$idCasoMantis);
    //El texto de la variable tiene saltos de línea para que el texto tenga los mismo saltos de línea
    $datosSolicitud = '<html>
      <head>
        <title>Nueva solicitud de pr&eacute;stamo interbibliotecario recibida</title>
		<style>
		  body {
		  font-family:Arial, Helvetica, sans-serif;
		  font-size:15px }
		</style>
      </head>
      <body>
        C&oacute;digo del caso: '.$idCasoMantis.'<br/>
https://'.$_SERVER['SERVER_NAME'].'/solicitud_servicios/view.php?id='.$idCasoMantis.'
'.$solicitud.'
    </body>
    </html>';
        $encabezados .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$encabezados .= 'From: Biblioteca Universidad Icesi <referencia-bib@listas.icesi.edu.co>';
	
	mail($correoUsuarioEncargado, $asunto, $datosSolicitud, $encabezados);
  }
}