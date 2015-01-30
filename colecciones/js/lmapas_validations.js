/**
 * En este documento se maneja todo el javascript relacionado con la funcionalidad del listado
 * de mapas
 *
 * @author David Andrés Manzano - damanzano
 *
 **/
jQuery(document).ready(function(){    
    titleSearcher();    
});


/**
 *En esta función se ejecutan las funciones necesarias para la validación del buscador
 *de mapas por título
 *
 *@author damanzano
 *@since 26/11/10
 **/
function titleSearcher(){
    //Manejador del onclick del los enlaces de navegación
    jQuery(".app_navlink").click(function(e){
        e.preventDefault();
    });

    //manejador del submit del formulario
    jQuery("form#mapForm").validate({
        rules: {},
        messages: {},
        submitHandler:
        function(form) {
            //alert(jQuery("#pTipoAcceso").val().toString());
            loadBDResults(0, jQuery("form#mapForm #size").val(), jQuery("form#mapForm #newsearch").val(), jQuery("form#mapForm #pkeyword").val());
        }
    });
}

/**
 *Esta función se encarga de hacer un llamado asincronico al servidor para
 *cargar los resultados de busqueda deacuerdo a los parametros establecidos por
 *el usuario.
 *
 *@author damanzano
 *@since 22/11/10
 *
 *@param int cont
 *@param int size
 *@param char newsearch
 *@param string pkeyword
 **/
function loadBDResults(cont,size, newsearch,pkeyword){
    jQuery("#busqueda_titulo #app_results").html("<div class=\"loader\"><img src=\""+biblioappsURL+"/commons/images/loader.gif\"/><div>");
    //Carga los resultados
    jQuery.ajax({
        type: "POST",
        url: coleccionesURL+"/ajaxview/htmlMapas.php",
        data: {
            cont:cont,
            size:size,
            newsearch:newsearch,
            pkeyword:pkeyword
        },
        success: function(list){
            jQuery("#app_results").html(list);
            //Carga las barras de navegación
            jQuery.ajax({
                type: "POST",
                url: coleccionesURL+"/ajaxview/htmlMapasNav.php",
                data: {
                    cont:cont,
                    size:size,
                    newsearch:newsearch,
                    pkeyword:pkeyword
                },
                success: function(list){
                    jQuery(".app_navigation").html(list);
                }
            });
        }
    });

    
}