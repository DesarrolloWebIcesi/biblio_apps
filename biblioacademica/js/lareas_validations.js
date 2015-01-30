/**
 * En este documento se maneja todo el javascript relacionado con la funcionalidad del listado
 * de elementos multimedia
 *
 * @author David Andrés Manzano - damanzano
 * @since 11/02/11
 *
 **/

/**
 * Variable global donde se almacena la última tab activa 
 **/
var last_tab=0;

jQuery(document).ready(function(){    
    jQuery("#application").hide();
	jQuery("#backarea").hide();
    loadAreas();
    back();
    /*tabsContent();*/
});


/**
 *Esta función se encarga de hacer un llamado asincrónico al servidor para
 *cargar los resultados el listado de areas
 *el usuario.
 *
 *@author damanzano
 *@since 11/02/11

 **/
function loadAreas(){
    jQuery( "#dialog:ui-dialog" ).dialog( "destroy" );
	
    /*jQuery( "#app_content_areas" ).dialog({        
        closeOnEscape: false,
        open: function(event, ui) { $(".ui-dialog-titlebar-close").hide(); },
        width:'90%',
        position:'top',
        modal: true,        
        close: function(event, ui) {
            jQuery("#application").show();
            biblioTabs(last_tab);                   
        }
    });*/
    
    jQuery("#app_content_areas").html("<div class=\"loader\"><img src=\""+biblioappsURL+"/commons/images/loader.gif\"/><div>");
    //Carga los resultados
    jQuery.ajax({
        type: "POST",
        url: biblioacademicaURL+"/ajaxview/htmlAreas.php",        
        success: function(list){
            jQuery("#app_content_areas").html(list);
        }
    });    
}

/**
 *Efectos de la lista de areas
 *
 *@author damanzano
 *@since 11/02/11
 **/
function effects(){
    var selectedEffect = "slide";
    var options = {};

    // run the effect
    jQuery( ".area" ).each(function(){
        setTimeout(function(){},5000);
        jQuery(this).effect( selectedEffect, options, 500, callback );        
    });
    // callback function to bring a hidden box back
    function callback() {
        setTimeout(function() {
            jQuery( ".area" ).removeAttr( "style" ).hide().fadeIn();
        }, 1000 );
    };   
}

/**
 *Esta función se encarga de separar en tabs la diferentes opciones en el módulo de litado de revistas
 *
 *@author damanzano
 *@since 26/11/10
 **/
function biblioTabs(tabToOpen){
    
    jQuery("#app_content_categorias").tabs({
        ajaxOptions: {
            error: function( xhr, status, index, anchor ) {
                $( anchor.hash ).html(
                    "No se ha podido cargar esta pestaña. Trataremos de arreglar este problema lo más pronto posible. ");
            }            
        },
        selected: tabToOpen,
        show: function(event, ui){
                var selected_tab=ui.index;
                var selected_tab_panel=ui.panel.id;
                var url_content="";
                var url_nav="";
            
                switch(selected_tab_panel){
                    case "bdatos":
                        url_content=biblioacademicaURL+"/ajaxview/htmlBD.php";
                        url_nav=biblioacademicaURL+"/ajaxview/htmlBDNav.php";
                        break;
                    case 'cestudio':                        
                        url_content=biblioacademicaURL+"/ajaxview/htmlCasos.php";
                        url_nav=biblioacademicaURL+"/ajaxview/htmlCasosNav.php";
                        break;
                    case 'revistas':
                        url_content=biblioacademicaURL+"/ajaxview/htmlRevistas.php";
                        url_nav=biblioacademicaURL+"/ajaxview/htmlRevistasNav.php";
                        break;
                    case 'mapas':
                        url_content=biblioacademicaURL+"/ajaxview/htmlMapas.php";
                        url_nav=biblioacademicaURL+"/ajaxview/htmlMapasNav.php";
                        break;
                    case 'mmedia':
                        url_content=biblioacademicaURL+"/ajaxview/htmlMmedia.php";
                        url_nav=biblioacademicaURL+"/ajaxview/htmlMmediaNav.php";
                        break;
                    case 'sonoteca':
                        url_content=biblioacademicaURL+"/ajaxview/htmlAudio.php";
                        url_nav=biblioacademicaURL+"/ajaxview/htmlAudioNav.php";
                        break;
                    case 'videoteca':
                        url_content=biblioacademicaURL+"/ajaxview/htmlVideos.php";
                        url_nav=biblioacademicaURL+"/ajaxview/htmlVideosNav.php";
                        break;
                    /*
                    case 'otros':
                        url_content=biblioacademicaURL+"/ajaxview/htmlBD.php";
                        url_nav=biblioacademicaURL+"/ajaxview/htmlBDNav.php";
                        break;
                    */
                }
                //alert("Selecciono la tab "+selected_tab+" id "+selected_tab_panel);
            
                loadBDResults(0,10, 's',url_content, url_nav, selected_tab_panel);                
            }
    });

}

/**
 *Este método permite regresar a la página de inicio para seleccionar otra área
 *
 *@author damanzano
 *@since 12/02/11
 **/
function back(){
    jQuery("#backarea").button();    
    jQuery("#backarea").click(function(e){
        last_tab=jQuery("#app_content_categorias").tabs('option','selected');        
        jQuery("#app_content_categorias").tabs('destroy');
        jQuery("#application").hide();
        jQuery.ajax({
            type: "POST",
            url: biblioacademicaURL+"/control/ControlSession.php",
            dataType : 'json',
            data: {
                area:null
            },
            success: function(data){
                if(data.error === false){
                    if(data.area == null){
                        error = false;
                        //jQuery( "#app_content_areas" ).dialog( "open" );
						jQuery( "#app_content_areas" ).show();
                    }else{
                        //desplegarDialogo("No ha seleccionado ning&uacute;n &aacute;rea", 'Error', 300 , 110, 3);
                    }
                }else{
                    //desplegarDialogo(data.msg, 'Error', 300 , 110, 3);
                }
            }
        });
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
function loadBDResults(cont,size, newsearch,url_content, url_nav, selected_tab_panel){
    jQuery("#"+selected_tab_panel+" .app_results").html("<div class=\"loader\"><img src=\""+biblioappsURL+"/commons/images/loader.gif\"/><div>");    
    //Carga los resultados     

    jQuery.ajax({
        type: "POST",
        url: url_content,
        data: {            
            cont:cont,
            size:size,
            newsearch:newsearch                    
        },
        success: function(list){                    
            jQuery("#"+selected_tab_panel+" .app_results").html(list);
            //Carga las barras de navegación
            jQuery.ajax({
                type: "POST",
                url: url_nav,
                data: {                    
                    cont:cont,
                    size:size,
                    newsearch:newsearch                            
                },
                success: function(list){
                    jQuery("#"+selected_tab_panel+" .app_navigation").html(list);
                }
            });
        }
    });
}