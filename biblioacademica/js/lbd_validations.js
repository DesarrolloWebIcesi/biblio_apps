/**
 * En este documento se maneja todo el javascript relacionado con la funcionalidad del listado
 * de bases de datos
 *
 * @author David Andrés Manzano - damanzano
 *
 **/
jQuery(document).ready(function(){
    //Llama listado de bases de datos
    jQuery.ajax({
        type: "POST",
        url: coleccionesURL+"/ajaxview/ListasHTML.php",
        data: "listtype=nombresbd",
        success: function(list){
            jQuery("#pBD").html(list);
        }
    });
    //Llama listado de areas
    jQuery.ajax({
        type: "POST",
        url: coleccionesURL+"/ajaxview/ListasHTML.php",
        data: "listtype=areasbd",
        success: function(list){
            jQuery("#pArea").html(list);
        }
    });
    //Llama listado de tipos de acceso
    jQuery.ajax({
        type: "POST",
        url: coleccionesURL+"/ajaxview/ListasHTML.php",
        data: "listtype=tiposacceso",
        success: function(list){
            jQuery("#pTipoAcceso").html(list);
        }
    });

    //Manejador del onclick del los enlaces de navegación
    jQuery(".app_navlink").click(function(e){
        e.preventDefault();        
    });

    //manejador del submit del formulario
    jQuery("#bdForm").validate({
        rules: {},
        messages: {},
        submitHandler:
        function(form) {
            //alert(jQuery("#pTipoAcceso").val().toString());
            loadBDResults(0, jQuery("#size").val(), jQuery("#newsearch").val(), jQuery("#pBD").val(), jQuery("#pArea").val(), jQuery("#pTipoAcceso").val());
        }
    });

    
});

/**
 *Esta función se encarga de hacer un llamado asincronico al servidor para
 *cargar los resultados de busqueda deacuerdo a los parametros establecidos por
 *el usuario.
 *
 *@author damanzano
 *@since 20/10/10
 *
 *@param int cont
 *@param int size
 *@param char newsearch
 *@param string pBD
 *@param string pArea
 *@param string pTipoAcceso
 **/
function loadBDResults(cont,size, newsearch,pBD,pArea,pTipoAcceso){
    jQuery("#app_results").html("<div class=\"loader\"><img src=\""+biblioappsURL+"/commons/images/loader.gif\"/><div>");
    //Carga los resultados
    jQuery.ajax({
        type: "POST",
        url: coleccionesURL+"/ajaxview/htmlBD.php",
        data: {
            cont:cont,
            size:size,
            newsearch:newsearch,
            pBD:pBD,
            pArea:pArea,
            pTipoAcceso:pTipoAcceso
        },
        success: function(list){
            jQuery("#app_results").html(list);
            //Carga las barras de navegación
            jQuery.ajax({
                type: "POST",
                url: coleccionesURL+"/ajaxview/htmlBDNav.php",
                data: {
                    cont:cont,
                    size:size,
                    newsearch:newsearch,
                    pBD:pBD,
                    pArea:pArea,
                    pTipoAcceso:pTipoAcceso
                },
                success: function(list){
                    jQuery(".app_navigation").html(list);
                }
            });
        }
    });

    
}


