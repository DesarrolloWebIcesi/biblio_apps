<?php
echo	'<table cellpadding="4" cellspacing="1" border="0" width="100%">';
echo 	'<tr>'.
		'<td colspan="4" bgcolor="#CCCCCC">'.
		'<font face="Verdana, Arial, Helvetica, sans-serif" size="2">Libro 1</font>'.
        '</td>'.
	'</tr>'; 
                 		
echo	'<tr bgcolor="#FFFFFF">'. 
       	'<td class="etiquetaFormReq" width="23%">'.
		'T&iacute;tulo del libro'.
		'</td>'.
        '<td colspan="3">'.
		'<font face="Verdana, Arial, Helvetica, sans-serif" size="2">'. 
        '<input name="titulo_del_libro" type="text" id="titulo_del_libro" size="70"/>'.
		'</font>'.
		'</td>'.
        '</tr>';                            	

echo 	'<tr bgcolor="#FFFFFF" class="etiquetaFormReq">'. 
        '<td>Autor</td>'.
        '<td width="36%">'.
		'<font size="2" face="Verdana, Arial, Helvetica, sans-serif">'. 
        '<input name="autor" type="text" id="autor" size="40" maxlength="30"/>'.
        '</font>'.
		'</td>'.
        '<td width="10%" class="etiquetaFormReq">'.
		'Ubicaci&oacute;n'.
		'</td>'.
        '<td width="31%">'.
		'<font size="2" face="Verdana, Arial, Helvetica, sans-serif">'. 
        '<input name="ubicacion" type="text" id="ubicacion" size="20" maxlength="30" />'.
        '</font>'.
		'</td>'.
        '</tr>';							

echo	'<tr bgcolor="#FFFFFF">'.
        '<td class="etiquetaFormReq">'.
		'Instituci&oacute;n prestante del material'.
		'</td>'.
		'<td colspan="4">'.
		'<font size="2" face="Verdana, Arial, Helvetica, sans-serif">'.
        '<input name="institucion_prestante" type="text" id="institucion_prestante" size="40" maxlength="50" />'.
        '</font>'.
		'</td>'.
        '</tr>';                            
                            
if($_POST["cantidad"] != null){
	if(($_POST["cantidad"])=="2" || ($_POST["cantidad"])=="3"){
echo	'<tr>'.
		'<td colspan="4" bgcolor="#CCCCCC">'.
		'<font face="Verdana, Arial, Helvetica, sans-serif" size="2">Libro 2</font>'. 
		'</td>'.
		'</tr>';	
		 					
echo	'<tr bgcolor="#FFFFFF">'.
        '<td class="etiquetaFormReq">'.
		'T&iacute;tulo del libro'.
		'</td>'.
        '<td colspan="3">'.
		'<font face="Verdana, Arial, Helvetica, sans-serif" size="2">'. 
        '<input name="titulo_del_libro2" type="text" id="titulo_del_libro2" size="70" />'.
        '</font>'.
		'</td>'.
        '</tr>';

echo	'<tr bgcolor="#FFFFFF" class="etiquetaFormReq">'. 
        '<td>Autor</td>'.
        '<td width="36%">'.
		'<font size="2" face="Verdana, Arial, Helvetica, sans-serif">'. 
        '<input name="autor2" type="text" id="autor2" size="40" maxlength="30" />'.
        '</font>'.
		'</td>'.
        '<td width="10%" class="etiquetaFormReq">Ubicaci&oacute;n</td>'.
        '<td width="31%">'.
		'<font size="2" face="Verdana, Arial, Helvetica, sans-serif">'. 
        '<input name="ubicacion2" type="text" id="ubicacion2" size="20" maxlength="30" />'.
        '</font>'.
		'</td>'.
        '</tr>';                            

echo	'<tr bgcolor="#FFFFFF">'.
        '<td class="etiquetaFormReq">'.
		'Instituci&oacute;n prestante del material'.
		'</td>'.
		'<td colspan="3">'.
		'<font size="2" face="Verdana, Arial, Helvetica, sans-serif">'. 
        '<input name="institucion_prestante2" type="text" id="institucion_prestante2" size="40" maxlength="50" />'.
        '</font>'.
		'</td>'.
        '</tr>';							
	}
}

if($_POST["cantidad"] != null){
	if(($_POST["cantidad"])=="3"){

echo	'<tr>'.
		'<td colspan="4" bgcolor="#CCCCCC">'.
		'<font face="Verdana, Arial, Helvetica, sans-serif" size="2">Libro 3 </font>'.
        '</td>'.
		'</tr>';
		
echo	'<tr bgcolor="#FFFFFF">'. 
        '<td class="etiquetaFormReq">'.
		'T&iacute;tulo del libro'.
		'</td>'.
        '<td colspan="3">'.
		'<font face="Verdana, Arial, Helvetica, sans-serif" size="2">'. 
        '<input name="titulo_del_libro3" type="text" id="titulo_del_libro3" size="70" />'.
        '</font>'.
		'</td>'.
        '</tr>';
							
echo	'<tr bgcolor="#FFFFFF" class="etiquetaFormReq">'. 
        '<td>Autor</td>'.
        '<td width="36%">'.
		'<font size="2" face="Verdana, Arial, Helvetica, sans-serif">'. 
        '<input name="autor3" type="text" id="autor3" size="40" maxlength="30" />'.
        '</font>'.
		'</td>'.
        '<td width="10%" class="etiquetaFormReq">Ubicaci&oacute;n</td>'.
        '<td width="31%">'.
		'<font size="2" face="Verdana, Arial, Helvetica, sans-serif">'. 
        '<input name="ubicacion3" type="text" id="ubicacion3" size="20" maxlength="30" />'.
        '</font>'.
		'</td>'.
        '</tr>';

echo	'<tr bgcolor="#FFFFFF">'. 
        '<td class="etiquetaFormReq">'.
		'Instituci&oacute;n prestante del material'.
		'</td>'.
		'<td colspan="3">'.
		'<font size="2" face="Verdana, Arial, Helvetica, sans-serif">'. 
        '<input name="institucion_prestante3" type="text" id="institucion_prestante3" size="40" maxlength="50" />'.
        '</font></td>'.
        '</tr>';
	}
}	
		
echo '</table>';							  
?>
							
							  