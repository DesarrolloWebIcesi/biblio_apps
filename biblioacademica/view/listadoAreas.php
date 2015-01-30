<?php
/**
 * Página de inicio de la colección Sonoteca
 *
 * @author damanzano
 * @since 23/11/10
 */
?>
<link type="text/css" rel="stylesheet"  href="<?php echo $GLOBALS["biblio_apps"] ?>/commons/css/commons.css"/>
<link type="text/css" rel="stylesheet"  href="<?php echo $GLOBALS["app_route"] ?>/css/ui.css"/>
<link type="text/css" rel="stylesheet"  href="<?php echo $GLOBALS["app_route"] ?>/css/biblioacademica.css"/>
<script type="text/javascript" src="<?php echo $GLOBALS["biblio_apps"] ?>/commons/js/jquery-1.6.1.min.js" charset="iso-8859-1"></script>
<script type="text/javascript" src="<?php echo $GLOBALS["biblio_apps"] ?>/commons/js/jquery-ui-1.8.13.custom.min.js" charset="iso-8859-1"></script>

<script language="javascript" charset="iso-8859-1">
    var biblioappsURL="<?php echo $GLOBALS["biblio_apps"] ?>";
    var biblioacademicaURL="<?php echo $GLOBALS["app_route"] ?>";    
    $.noConflict();
</script>
<script type="text/javascript" src="<?php echo $GLOBALS["app_route"] ?>/js/lareas_validations.js" charset="iso-8859-1"></script>

<div id="app_content_areas" title="Selecciona un &aacute;rea">    
</div>

<div id="dataarea">
    <table>
        <tr>
            <td>
                <div id="selectedarea">
                    Resultados para -
                </div>
            </td>
            <td style="text-align: right"><div id="backarea">Seleccionar otra &Aacute;rea</div>
    </table>
</div>
<div id="application">
<div id="app_content_categorias">

    <ul>
        <li><a href="#bdatos">Bases de Datos</a></li>
        <li><a href="#cestudio">Casos de Estudio</a></li>
        <li><a href="#revistas">Revistas</a></li>
        <li><a href="#mapas">Mapas</a></li>
        <li><a href="#mmedia">Multimedia</a></li>
        <li><a href="#sonoteca">Sonoteca</a></li>
        <li><a href="#videoteca">Videoteca</a></li>
        <!--<li><a href="#otros">Otros</a></li>-->
    </ul>
    <div id="bdatos">
        <div class="title"><h4>Resultados en Bases de Datos</h4></div>
        <div class="app_info">
            <span>
            </span>
        </div>
        <div class="app_navigation"></div>
        <div class="app_results">
        </div>
    </div>
    <div id="cestudio">
        <div class="title"><h4>Resultados en Casos de estudio</h4></div>
        <div id="app_info">
            <span>
            </span>
        </div>
        <div class="app_navigation"></div>
        <div class="app_results">
        </div>
    </div>
    <div id="revistas">
        <div class="title"><h4>Resultados en Revistas</h4></div>
        <div id="app_info">
            <span>
            </span>
        </div>
        <div class="app_navigation"></div>
        <div class="app_results">
        </div>
    </div>
    <div id="mapas">
        <div class="title"><h4>Resultados de Mapas</h4></div>
        <div id="app_info">
            <span>
            </span>
        </div>
        <div class="app_navigation"></div>
        <div class="app_results">
        </div>
    </div>
    <div id="mmedia">
        <div class="title"><h4>Resultados en Multimedia</h4></div>
        <div id="app_info">
            <span>
            </span>
        </div>
        <div class="app_navigation"></div>
        <div class="app_results">
        </div>
    </div>
    <div id="sonoteca">
        <div class="title"><h4>Resultados en Sonoteca</h4></div>
        <div id="app_info">
            <span>
            </span>
        </div>
        <div class="app_navigation"></div>
        <div class="app_results">
        </div>
    </div>
    <div id="videoteca">
        <div class="title"><h4>Resultados en Videoteca</h4></div>
        <div id="app_info">
            <span>
            </span>
        </div>
        <div class="app_navigation"></div>
        <div class="app_results">
        </div>
    </div>
    <!--
    <div id="otros">
        <div class="title"><h4>Resultados en Otros</h4></div>
        <div id="app_info">
            <span>
            </span>
        </div>
        <div class="app_navigation"></div>
        <div class="app_results">
        </div>
    </div>
    -->
    </div>
</div>