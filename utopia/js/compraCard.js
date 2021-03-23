jQuery(document).on('submit',' #form_insert', function(event){
    event.preventDefault();
    jQuery.ajax({
        url: '../php/insertar.php',
        type: 'POST',
        dataType: 'json',
        data: $(this).serialize() ,
    })
    .done(function(respuesta){
        console.log(respuesta);
        if(!respuesta.error){
            alert("Su Compra Ha Sido Exitosa");

        }else{
            alert("ERROR, INTENTE NUEVAMENTE");
        }
        
    })
    .fail(function(resp){
        console.log(resp.responseText);
    })
    .always(function(){
        console.log("complete");
    })
});