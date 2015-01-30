/* 
 * Consultas con ajax
 */
$(document).ready(function(){
    $.ajax({
        type: "POST",
        url: "http://192.168.220.28/biblioteca/blognews/view/posts_view.php",
        data: "ctd=0",
        success: function(list){
            $("#blognews").html(list);
        }
    });
});

