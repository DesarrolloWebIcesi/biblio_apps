<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<div id="biblio_apps">
     <h3 id="principal">B&uacute;squeda en el cat&aacute;logo p&uacute;blico de la Biblioteca de la Universidad Icesi</h3>
    <div id="app_form">       
        <div id="metabuscador">
            <form action="http://biblioteca2.icesi.edu.co/cgi-olib" method="get" id="olibForm">
                <!-- 2012-06-05 damanzano se comenta para corregir error reportado en el caso56112 de mantis
				<input type="text" name="keyword" id="keyword" value="Buscar">
				-->
				<input type="text" name="keyword" id="keyword">
                <input name="submit" type="submit" value=".">
            </form>
        </div>
        <div>            
            <div id="advance_search">
                <a href="http://biblioteca2.icesi.edu.co/cgi-olib?session=79878950&infile=advsearchform.glu&style=adv" target="_blank">B&uacute;squeda avanzada</a>
            </div>
            <div id="extlinks">
                <table align="center" cellspacing="10">
                    <tr>
                        <td>
                            <img src="<?php echo $GLOBALS["app_route"] ?>/images/bibliotecademica_02.png" border="0" width="40" height="40"/>
                        </td>
                        <td>
                            <img src="<?php echo $GLOBALS["app_route"] ?>/images/biblioteca-digital_02.png" border="0" width="40" height="40"/>
                        </td>
                        <td>
                            <img src="<?php echo $GLOBALS["app_route"] ?>/images/bases-datos.png" border="0" width="40" height="40"/>
                        </td>
                    </tr>
                    <tr><td>
                            <a href="http://bibliotecadigital.icesi.edu.co/" title="bibliotecadigital">
                                Biblioteca Digital
                            </a>
                        </td>
                        <td>
                            <a href="http://www.icesi.edu.co/biblioacademica/" title="Biblioacadémica">
                                Biblioacadémica
                            </a>
                        </td>
                        <td>
                            <a href="bases_datos.php" title="Bases de datos">
                                Bases de datos
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
            
        </div>
    </div>
</div>