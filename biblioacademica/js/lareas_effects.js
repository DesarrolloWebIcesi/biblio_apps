/**
 * En este documento se maneja todo el javascript relacionado con la funcionalidad del listado
 * de elementos multimedia
 *
 * @author David Andrés Manzano - damanzano
 * @since 11/02/11
 *
 **/
jQuery(document).ready(function(){    
    loadAreaResults();
});

/**
 *Esta función se ancarga de hacer un llamado asincrónico al servidor para
 *consultar el material disponible para un area especifica
 **/
function loadAreaResults(){
    jQuery(".area").click(function(e){
        var area=jQuery(this).attr("id");
        //alert('Area:' +area);
        jQuery.ajax({
            type: "POST",
            url: biblioacademicaURL+"/control/ControlSession.php",
            dataType : 'json',
            data: {
                area:area                
            },
            success: function(data){
                if(data.error === false){
                    if(data.area != null){
                        error = false;
                        jQuery("#selectedarea").html("Resultados para <strong>"+data.area_desc+"</strong>");
                        jQuery( "#app_content_areas" ).hide();
                        jQuery("#application").show();
                        biblioTabs(last_tab);
                        jQuery("#backarea").show();                     
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
