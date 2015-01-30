/**
 * En este documento se maneja todo el javascript relacionado con la funcionalidad del listado
 * de bases de datos
 *
 * @author David Andrés Manzano - damanzano
 *
 **/
jQuery(document).ready(function(){
    //Llama listado de areas
    jQuery.ajax({
        type: "POST",
        url: coleccionesURL+"/ajaxview/ListasHTML.php",
        data: "listtype=areasna",
        success: function(list){
            jQuery("#idArea").html(list);
        }
    });
   

    //Manejador del onclick del los enlaces de navegación
    jQuery(".app_navlink").click(function(e){
        e.preventDefault();        
    });

    //manejador del submit del formulario
    jQuery("#naForm").validate({
        rules: {
            idArea:{
                required:true
            }
        },
        messages: {
            idArea:{
                required:"Seleccione un &aacute;rea para consultar"
            }
        },
        submitHandler:
        function() {
            //alert(jQuery("#pTipoAcceso").val().toString());
            loadBDResults(0, jQuery("#size").val(), jQuery("#newsearch").val(), jQuery("#idArea").val());
        }
    });

    
});

/**
 *Esta función se encarga de hacer un llamado asincrónico al servidor para
 *cargar los resultados de búsqueda deacuerdo a los parámetros establecidos por
 *el usuario.
 *
 *@author damanzano
 *@since 20/10/10
 *
 *@param int cont
 *@param int size
 *@param char newsearch 
 **/
function loadBDResults(cont,size, newsearch,idArea){
    jQuery("#app_results").html("<div class=\"loader\"><img src=\""+biblioappsURL+"/commons/images/loader.gif\"/><div>");
    //Carga los resultados
    jQuery.ajax({
        type: "POST",
        url: coleccionesURL+"/ajaxview/htmlNuevasAdquisiciones.php",
        data: {
            cont:cont,
            size:size,
            newsearch:newsearch,
            idArea:idArea
        },
        success: function(list){
            jQuery("#app_results").html(list);
            //Carga las barras de navegación
            jQuery.ajax({
                type: "POST",
                url: coleccionesURL+"/ajaxview/htmlNuevasAdquisicionesNav.php",
                data: {
                    cont:cont,
                    size:size,
                    newsearch:newsearch,
                    idArea:idArea
                },
                success: function(list){
                    jQuery(".app_navigation").html(list);
                }
            });
        }
    });

   
}


