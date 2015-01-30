/**
 * En este documento se maneja todo el javascript relacionado con la funcionalidad del listado
 * de revistas
 *
 * @author David Andrés Manzano - damanzano
 *
 **/
jQuery(document).ready(function(){
    tabs();
    titleSearcher();
    alphabetiList();
});

/**
 *Esta función se encarga de separar en tabs la diferentes opciones en el módulo de litado de revistas
 *
 *@author damanzano
 *@since 26/11/10
 **/
function tabs(){
    jQuery("#biblio_apps").tabs({
        ajaxOptions: {
            error: function( xhr, status, index, anchor ) {
                $( anchor.hash ).html(
                    "No se ha podido cargar esta pestaña. Trataremos de arreglar este problema lo más pronto posible. ");
            }
        }
    });

}

/**
 *En esta función se ejecutan las funciones necesarias para la validación del buscador
 *de revistas por título
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
    jQuery("#busqueda_titulo form#reForm").validate({
        rules: {},
        messages: {},
        submitHandler:
        function(form) {
            //alert(jQuery("#pTipoAcceso").val().toString());
            loadBDResults(0, jQuery("form#reForm #size").val(), jQuery("form#reForm #newsearch").val(), jQuery("form#reForm #pkeyword").val());
        }
    });
}

/**
 *Esta función se encarga de controlar la funcionalidad referente al listado alfabético de revistas
 *
 *@author damanzano
 *@since 26/11/10
 **/
function alphabetiList(){
    jQuery.ajax({
        type: "POST",
        url: coleccionesURL+"/ajaxview/htmlRevistasAZNav.php",
        success: function(list){
            jQuery("#listado_az .app_navigation").html(list);
            jQuery("#listado_az .app_navigation").tabs({
                select: function(event, ui) {
                    var selected_tab=ui.index;
                    //alert("Selecciono la tab "+selected_tab);
                    jQuery("#ui-tabs-"+selected_tab).html("<div class=\"loader\"><img src=\""+biblioappsURL+"/commons/images/loader.gif\"/><div>");
                    jQuery("#listado_az .app_navigation").tabs( "option", "ajaxOptions", { type:"POST",data:{letra:selected_tab} })
                }
            });
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
        url: coleccionesURL+"/ajaxview/htmlRevistas.php",
        data: {
            cont:cont,
            size:size,
            newsearch:newsearch,
            pkeyword:pkeyword
        },
        success: function(list){
            jQuery("#busqueda_titulo .app_results").html(list);
            //Carga las barras de navegación
            jQuery.ajax({
                type: "POST",
                url: coleccionesURL+"/ajaxview/htmlRevistasNav.php",
                data: {
                    cont:cont,
                    size:size,
                    newsearch:newsearch,
                    pkeyword:pkeyword
                },
                success: function(list){
                    jQuery("#busqueda_titulo .app_navigation").html(list);
                }
            });
        }
    });

    
}