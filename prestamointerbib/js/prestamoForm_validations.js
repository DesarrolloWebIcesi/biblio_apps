/**
 * En este archivo se realizan todas las validaciones de los campos del
 * formulario de prestamo interbibliotecario, asi cómo los llamados Ajax necesarios
 *
 * @author David Andrés Manzano - damanzano
 * @since 13/01/11
 **/
jQuery(document).ready(function(){
  formVerification();
  closeSession();
  jQuery("#addbook").click(function(event){
      event.preventDefault();
      addBook();
      return false;
  })
  
});

function formVerification(){
    jQuery("form#prestamoForm").validate({
        messages:{
            required: "Este campo es requerido",
            number: "este campo debe num&eacute;rico",
            email:"Escribe una dirección de correo electr&oacute; v&aacute;lida"
        },
        submitHandler:
        function(form) {
            var data= jQuery("form#prestamoForm").serializeArray();
            formSendData(data);
        }
    });
}
function formSendData(data){
    jQuery.ajax({
        type: "POST",
        url: approuteURL+"/control/ControlProcesarSolicitud.php",
        dataType : 'json',
        data: data,
        success : function(data){
            if(data.error === false){                   
                    desplegarDialogo(data.msg, 'Información', 300 , 110, 4);              
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

function closeSession(){
    jQuery("a#close_session").click(function(event){
        event.preventDefault();
        jQuery.ajax({
            type: "POST",
            url: approuteURL+"/control/ControlSession.php",
            dataType : 'json',
            data: {
                action:"cerrar"
            },
            success : function(data){
                if(data.error === false){               
                    error = false;
                    location.href="formulario_prestamo_interbibliotecario.php";               
                }else{
                    desplegarDialogo(data.msg, 'Error', 300 , 110, 3);
                }
            },
            error : function(XMLHttpRequest, textStatus, errorThrown) {
                mensaje = "Ha ocurrido un error al conectarse en el servidor.<br />" + textStatus;
                desplegarDialogo(mensaje, 'Error', 300, 110, 3);            
            }
        });
    });
}

function addBook(){
    var books = jQuery("#booksnumber").val();
    books=parseInt(books);
    var bookid = jQuery("#booksid").val();   
    bookid=parseInt(bookid);
    //alert("libro: "+bookid);
    if(books>=2){
        //alert("no puedes agregar más libros");
        desplegarDialogo("Puedes seleccionar m&aacute;ximno 3 libros", 'Advertencia', 300 , 110, 2);
    }else{
        bookid+=1;
        jQuery("#book_data").append("<div class=\"book\" id=\"book"+bookid+"\">"+
                    "<table cellpadding=\"4\" cellspacing=\"1\" border=\"0\" width=\"90%\">"+
                        "<tr>"+
                            "<td colspan=\"4\" class=\"booktitle\">"+
                                "Libro"+(bookid+1)+
                            "</td>"+
                        "</tr>"+
                        "<tr>"+
                            "<td><strong>T&iacute;tulo del libro *</strong></td>"+
                            "<td colspan=\"3\">"+
                                "<input name=\"libros["+bookid+"][titulo]\" type=\"text\"  class=\"required\" size=\"70\"/>"+
                            "</td>"+
                        "</tr>"+
                        "<tr>"+
                            "<td><strong>Edici&oacute;n del libro *</strong></td>"+
                            "<td colspan=\"3\">"+
                                "<input name=\"libros["+bookid+"][edicion]\" type=\"text\"  class=\"required\" size=\"70\"/>"+
                            "</td>"+
                        "</tr>"+
                        "<tr>"+
                            "<td>Autor</td>"+
                            "<td>"+
                                    "<input name=\"libros["+bookid+"][autor]\" type=\"text\" size=\"40\" maxlength=\"30\"/>"+
                            "</td>"+
                            "<td>Signatura o n&uacute;mero topogr&aacute;fico</td>"+
                            "<td>"+
                                    "<input name=\"libros["+bookid+"][signatura]\" type=\"text\" size=\"20\" maxlength=\"30\" />"+
                            "</td>"+
                        "</tr>"+
                        "<tr>"+
                            "<td>"+
                                "<strong>Instituci&oacute;n prestante del material *</strong>"+
                            "</td>"+
                            "<td colspan=\"4\">"+
                                "<input name=\"libros["+bookid+"][institucion]\" type=\"text\" class=\"required\" size=\"40\" maxlength=\"50\" />"+
                            "</td>"+
                        "</tr>"+
                    "</table>"+
                    "<span href=\"#\" class=\"deletebook\" onclick=\"deleteBook('#book"+bookid+"')\">Quitar este libro</span>"+
                "</div>");
            efecto("#book"+bookid);
            jQuery("#booksid").val(bookid);
            jQuery("#booksnumber").val(parseInt(jQuery("#booksnumber").val())+1);
    }
}
function deleteBook(bookid){
    var books = jQuery("#booksnumber").val();
    books=parseInt(books);
    if(books<=0){
        desplegarDialogo("Debes solicitar al menos un libro", 'Advertencia', 300 , 110, 2);
    }else{
        jQuery(bookid).remove();
        jQuery("#booksnumber").val(parseInt(jQuery("#booksnumber").val())-1);
    }
}

function efecto(divid){
    var options = {};
    jQuery(divid).effect("bounce", options, 500, efectocallback )
}
// callback function to bring a hidden box back
function efectocallback(divid) {
    setTimeout(function() {
        jQuery( divid ).removeAttr( "style" ).hide().fadeIn();
    }, 1000 );
};



