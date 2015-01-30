/**
 * En este archivo se realizan todas las validaciones de los campos del
 * formulario de login, asi cómo los llamados Ajax necesarios
 *
 * @author David Andrés Manzano - damanzano
 * @since 13/01/11
 **/
jQuery(document).ready(function(){
    //verificar si no se ha iniciado sessión
    jQuery.ajax({
        type: "POST",
        url: approuteURL+"/control/ControlSession.php",
        dataType : 'json',
        data: {
            action:"verificar"
        },
        success : function(data){
            if(data.error === false){               
                error = false;
                loadUserData();
                loadPrestamoForm();                
            }else{
                loginFormVerification();
            }
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            mensaje = "Error de sessión.<br />" + textStatus;
            desplegarDialogo(mensaje, 'Error', 300, 110, 3);            
        }
    });
//loginFormVerification();
});

/**
 *Esta función se encarga de verificar que los campos del formulario de login
 *esten bien diligenciados (en terminos de formato). Si la verificación es correcta
 *se pasa a la fase de validación a través del método loginFormValidation(puser, ppassword)
 *
 *@author damanzano
 *@since 13/01/11
 **/
function loginFormVerification(){
    //manejador del onsubmit del formulario
    jQuery("form#loginForm").validate({
        rules: {
            usuario:{
                required:true,
                minlength:6
            },
            password:{
                required:true 
            }
        },
        messages: {},
        submitHandler:
        function(form) {            
            loginFormValidation(jQuery("form#loginForm #usuario").val(), jQuery("form#loginForm #password").val());
        }
    });
}

/**
 *Se hace una llamada asincrona al servidor para validar el usuario contral el
 *servidor LDAP.
 *
 *@author damanzano
 *@since 13/01/11
 *
 *@param string puser nombre de usuario
 *@param string ppassword contraseña
 **/
function loginFormValidation(puser, ppassword){    
    //Carga los resultados
    jQuery.ajax({
        type: "POST",
        url: approuteURL+"/control/ControlAuth.php",
        dataType : 'json',
        data: {
            puser:puser,
            ppassword:ppassword
        },
        success : function(data){
            if(data.error === false){
                if(data.dn != null){
                    error = false;
                    //poner formulario de prestamo
                    loadUserData();
                    loadPrestamoForm();                    
                }else{                    
                    desplegarDialogo("Identificaci&oacute;n o contrase&ntilde;a incorrectos", 'Error', 300 , 110, 3);
                }
            }else{                
                desplegarDialogo(data.msg, 'Error', 300 , 110, 3);
            }
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            mensaje = "Ha ocurrido un error al conectarse a la base de datos.<br />" + textStatus;
            desplegarDialogo(mensaje, 'Error', 300, 110, 3);            
        }
    });
}

function loadPrestamoForm(){
    jQuery.ajax({
        type: "POST",
        url: approuteURL+"/view/formularioPrestamo.php",                        
        success : function(html){                            
            jQuery("#pib_app_form").html('');
            jQuery("#pib_app_form").html(html);
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            mensaje = "no se encuentra la vista requerida.<br />" + textStatus;
            desplegarDialogo(mensaje, 'Error', 300, 110, 3);            
        }
    });
}
function loadUserData(){
    jQuery.ajax({
        type: "POST",
        url: approuteURL+"/view/datosUsuario.php",                        
        success : function(html){                            
            jQuery("#user_data").html('');
            jQuery("#user_data").html(html);
        },
        error : function(XMLHttpRequest, textStatus, errorThrown) {
            mensaje = "no se encuentra la vista requerida.<br />" + textStatus;
            desplegarDialogo(mensaje, 'Error', 300, 110, 3);            
        }
    });
}