<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<div id="biblio_apps">
    <div id="app_form">        
        <div id="minimetabuscador">
            <form action="http://biblioteca2.icesi.edu.co/cgi-olib" method="get" id="olibForm">
				<!-- 2012-06-05 damanzano se comenta para corregir error reportado en el caso56112 de mantis
				<input type="text" name="keyword" id="keyword" value="Buscar">
				-->
				<input type="text" name="keyword" id="keyword">
                <input name="submit" type="submit" value=".">
            </form>
        </div>
        <div id="advance_search"><a href="http://biblioteca2.icesi.edu.co/cgi-olib?session=79878950&infile=advsearchform.glu&style=adv" target="_blank">B&uacute;squeda avanzada</a></div>
    </div>
</div>