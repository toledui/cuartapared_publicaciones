function validaCorreo(valor) {
  if (/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(valor)){
   return true;
  } else {
   return false;
  }
}
 
 function confirmaAlert(pregunta, ruta) {
     jCustomConfirm(pregunta, 'THagencia', 'Aceptar', 'Cancelar', function(r) {
         if (r) {
             window.location = ruta;
         }
     });
 }
 function cerrarSesion(ruta)
 {
     Swal.fire({
         title: 'Realmente deseas cerrar tu sesión?',
         icon: 'info',
         showDenyButton: true,
         showCancelButton: true,
         confirmButtonText: 'Si',
         confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             cancelButtonText: 'NO' 
       }).then((result) => {
         
         if (result.isConfirmed) {
           window.location=ruta;
         }  
       })
 }
 function confirmarSweet(pregunta, ruta)
 {
     Swal.fire({
         title: pregunta,
         icon: 'error',
         showDenyButton: true,
         showCancelButton: true,
         confirmButtonText: 'Si',
         confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             cancelButtonText: 'NO' 
       }).then((result) => {
         
         if (result.isConfirmed) {
           window.location=ruta;
         }  
       })
 }
 
 function buscador()
 {
    if(document.getElementById('s').value==0)
    {
        return false;
    }
    document.search.submit();
 }
 function soloNumeros(evt) {
     key = (document.all) ? evt.keyCode : evt.which;
     //alert(key);
     if (key == 17) return false;
     /* digitos,del, sup,tab,arrows*/
     return ((key >= 48 && key <= 57) || key == 8 || key == 127 || key == 9 || key == 0);
 }
 function get_respuestas_formulario(id){
    jQuery(document).ready(function($){
        $("#respuesta_modal").modal("show");
        document.getElementById('respuesta_moda_title').innerHTML="Respuestas formulario N°"+id;
        $.ajax({
            type: "POST",
            url: datosajax.url,
            data:{
                action : "thagencia_form_contact_respuestas_ajax",
                nonce : datosajax.nonce,
                id: id,
            },
            success:function(resp){
                //document.getElementById('respuesta_moda_body').innerHTML=resp;
                $("#respuesta_moda_body").html(resp);
                return false;
            }
        });
    });
    
 }
 function get_crear_galeria (){
    jQuery(document).ready(function($){
        $("#thagencia_galeria_crear").modal("show"); 
        
         
    });
 }
 function thagencia_galeria_crear(){
    var form=document.thagencia_galeria_crear_form;
    if(form.nombre.value==0)
    { 
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'El campo nombre es obligatorio',
    });
    form.nombre.value='';
    return false;
    }
    
    
    
    form.submit();
 }
 function get_eliminar_galeria(id){
    Swal.fire({
        title: 'Realmente desea eliminar este registro?',
        icon: 'warning',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Si',
        confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'NO' 
      }).then((result) => {
        
        if (result.isConfirmed) {
             
          document.thagencia_form_contact_form_eliminar.accion.value='3';
          document.thagencia_form_contact_form_eliminar.id.value=id;
          document.thagencia_form_contact_form_eliminar.submit();
        }  
      });
      return false;
 }
 function get_eliminar_foto_galeria(galeria_id, foto_id, foto){
    Swal.fire({
        title: 'Realmente desea eliminar este registro?',
        icon: 'warning',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Si',
        confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'NO' 
      }).then((result) => {
        
        if (result.isConfirmed) { 
          document.thagencia_galeria_eliminar_foto.accion.value='3';
          document.thagencia_galeria_eliminar_foto.galeria_id.value=galeria_id;
          document.thagencia_galeria_eliminar_foto.foto_id.value=foto_id;
          document.thagencia_galeria_eliminar_foto.foto.value=foto;
          document.thagencia_galeria_eliminar_foto.submit();
        }  
      });
      return false;
 }

//  Agregar nombre de publicacion
function agregar_nombre_publicacion(){
    document.getElementById('formName').addEventListener('submit', function(e){
    e.preventDefault();
    const descripcion = document.getElementById('descripcion').value;
    const addDescrip = document.getElementById('addDescrip');
    addDescrip.value=  descripcion;
    jQuery('#exampleModal').modal('hide');
    addImage();
  });
}
 
 //media de wordpress
 
  jQuery(document).ready(function($){
    var marco, $btn_marco=$('.btnMarco');
    $btn_marco.on('click', function(){
      if (marco){
        marco.open();
        return;
      }
      var marco = wp.media({
        frame: 'select',
        title: 'Seleccionar imagen para la galería',
        button: {
            text: 'Usar esta imagen'
        },
        multiple: false,
        library: {
            type: 'image',
            order:'DESC',
            orderby:'name'
        }
    });
    marco.on( 'select', function(){
              
          //aquí es en donde tú puedes trabajar para obtener la data de la imagen seleccionada y empoderarte de ella
            //console.log(marco.state().get('selection').first().toJSON());
            //console.log(marco.state().get('selection').first().toJSON().id);
            //console.log(marco.state().get('selection').first().toJSON().filename);
            //console.log(marco.state().get('selection').first().toJSON().url);
            let form=document.thagencia_galeria_agregar_foto;
            form.thagencia_galeria_agregar_foto_wordpress_id.value=  marco.state().get('selection').first().toJSON().id;
            form.thagencia_galeria_agregar_foto_foto.value=  marco.state().get('selection').first().toJSON().filename;
            
            form.thagencia_galeria_agregar_foto_url.value=  marco.state().get('selection').first().toJSON().url;
            form.submit();
          });
          
          marco.open();
    });
  });

  function addImage(){
      var marco = wp.media({
        frame: 'select',
        title: 'Seleccionar imagen para la galería',
        button: {
            text: 'Usar esta imagen'
        },
        multiple: false,
        library: {
            type: 'image',
            order:'DESC',
            orderby:'name'
        }
    });
    marco.on( 'select', function(){
              
          //aquí es en donde tú puedes trabajar para obtener la data de la imagen seleccionada y empoderarte de ella
            //console.log(marco.state().get('selection').first().toJSON());
            //console.log(marco.state().get('selection').first().toJSON().id);
            //console.log(marco.state().get('selection').first().toJSON().filename);
            //console.log(marco.state().get('selection').first().toJSON().url);
            let form=document.thagencia_galeria_agregar_foto;
            form.thagencia_galeria_agregar_foto_wordpress_id.value=  marco.state().get('selection').first().toJSON().id;
            form.thagencia_galeria_agregar_foto_foto.value=  marco.state().get('selection').first().toJSON().filename;
            
            form.thagencia_galeria_agregar_foto_url.value=  marco.state().get('selection').first().toJSON().url;
            form.submit();
          });
          
          marco.open();
  }

  //media de wordpress
 jQuery(document).ready(function($){
  var marco, $btn_marco=$('.btnMarco');
  $btn_marco.on('click', function(){
    if (marco){
      marco.open();
      return;
    }
    var marco = wp.media({
      frame: 'select',
      title: 'Seleccionar imagen para la galería',
      button: {
          text: 'Usar esta imagen'
      },
      multiple: false,
      library: {
          type: 'image',
          order:'DESC',
          orderby:'name'
      }
  });
  marco.on( 'select', function(){
            
        //aquí es en donde tú puedes trabajar para obtener la data de la imagen seleccionada y empoderarte de ella
          //console.log(marco.state().get('selection').first().toJSON());
          //console.log(marco.state().get('selection').first().toJSON().id);
          //console.log(marco.state().get('selection').first().toJSON().filename);
          //console.log(marco.state().get('selection').first().toJSON().url);
          let form=document.thagencia_galeria_agregar_foto2;
          form.thagencia_galeria_agregar_foto_wordpress_id2.value=  marco.state().get('selection').first().toJSON().id;
          form.thagencia_galeria_agregar_foto_foto2.value=  marco.state().get('selection').first().toJSON().filename;
          form.thagencia_galeria_agregar_foto_url2.value=  marco.state().get('selection').first().toJSON().url;
          form.submit();
        });
        
        marco.open();
  });
});
 

// Eliminar foto de contenido
function get_eliminar_foto_contenido(galeria_id, foto_id, foto){
  Swal.fire({
      title: 'Realmente desea eliminar este registro?',
      icon: 'warning',
      showDenyButton: true,
      showCancelButton: true,
      confirmButtonText: 'Si',
      confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'NO' 
    }).then((result) => {
      
      if (result.isConfirmed) { 
        document.thagencia_galeria_eliminar_foto2.accion.value='3';
        document.thagencia_galeria_eliminar_foto2.galeria_id.value=galeria_id;
        document.thagencia_galeria_eliminar_foto2.foto_id.value=foto_id;
        document.thagencia_galeria_eliminar_foto2.foto.value=foto;
        document.thagencia_galeria_eliminar_foto2.submit();
      }  
    });
    return false;
}
// Eliminar proyecto
function get_eliminar_proyecto(id){
  Swal.fire({
      title: 'Realmente desea eliminar este registro?',
      icon: 'warning',
      showDenyButton: true,
      showCancelButton: true,
      confirmButtonText: 'Si',
      confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'NO' 
    }).then((result) => {
      
      if (result.isConfirmed) { 
        document.cuartapared_proyecto_eliminar.accion.value='3';
        document.cuartapared_proyecto_eliminar.proyecto_id.value = id;
        document.cuartapared_proyecto_eliminar.submit();
      }  
    });
    return false;
}


// Vamos a abrir el slider con los datos de la publicacion que queremos abrir

function get_contenidos_publicacion(id){

  jQuery(document).ready(function($){
    
    $("#contenidosModal").modal("show");
    $.ajax({
        type: "POST",
        url: datosajax.url,
        data:{
            action : "cuartapared_contenido_ajax",
            nonce : datosajax.nonce,
            id: id,
        },
        success:function(resp){
            $("#modalContBody").html(resp);
            show_swiper_slider();
            // show_swiper_slider2(id);
            return false;
            
        }
    });

    // Swiper
  });

}
