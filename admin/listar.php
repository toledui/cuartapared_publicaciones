<?php
if(!defined('ABSPATH')) die();
global $wpdb;
$tabla = "{$wpdb->prefix}cuartapared_publicaciones";
$tabla2 = "{$wpdb->prefix}cuartapared_publicacion";
if(isset($_POST['nonce'])){
    switch($_POST["accion"]){
        case '1':
            $data = [
        
                'nombre' => sanitize_text_field($_POST['nombre']),  
                'fecha'=>date('Y-m-d')
            ]; 
              $wpdb->insert($tabla, $data);
              ?>
              <script>
                  Swal.fire({
                      icon: 'success',
                      title: 'OK',
                      text: 'Se creó el registro exitosamente',
                  });
                  setInterval(() => {
                    window.location=location.href;
                  }, 5000);
              </script>
                        <?php 
        break;
        case '3':
            $wpdb->delete($tabla, array('id' =>$_POST['proyecto_id']));
            ?>
              <script>
                  Swal.fire({
                      icon: 'success',
                      title: 'OK',
                      text: 'Se eliminó el registro exitosamente',
                  });
                  setInterval(() => {
                    window.location=location.href;
                  }, 3000);
              </script>
                        <?php
        break;
    }
}
$query="select * from {$tabla} order by id desc;";
$datos=$wpdb->get_results($query, ARRAY_A);
?>
<div class="wrap">
<h1 class="wp-heading-inline"><?php echo get_admin_page_title()?></h1>
<p class="d-flex justify-content-end">
    <a href="javascript:void(0);" class="btn btn-primary" title="Crear" onclick="get_crear_galeria();"><i class="fas fa-plus"></i> Crear</a>
</p>
<hr />
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre de la publicación</th>
                <th>Shortcode</th>
                <th>Contenido</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach($datos as $dato){
                ?>
            <tr>
                <td><?php echo $dato['id'];?></td>
                <td><?php echo $dato['nombre'];?></td>
                <td style="text-align:center;">[cuartapared_publicacion id=<?php echo $dato['id'];?>]</td>
                <td style="text-align:center;">
                    <a href="<?php echo get_site_url();?>/wp-admin/admin.php?page=cuartapared_publicaciones%2Fadmin%2Feditar.php&id=<?php echo $dato['id'];?>"><i class="fas fa-images"></i></a>
                </td>
                <td style="text-align:center;">
                    <a href="javascript:void(0);" onclick="get_eliminar_proyecto(<?php echo $dato['id']; ?>);"><i class="fas fa-trash"></i></a>
                </td>
            </tr>    
                <?php
            }
            ?>
        </tbody>
    </table>
</div>
</div>
<!--crear-->
<div class="modal fade" id="thagencia_galeria_crear" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="thagencia_galeria_crear_title">Crear nuevo grupo de publicaciones</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!--formulario-->
            <div class="row">
            <form action="" method="POST" name="thagencia_galeria_crear_form">    
            <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" name="nombre" id="thagencia_galeria_nombre" class="form-control" placeholder="Nombre" /> 
                   
                    <hr />
                    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('seg');?>" id="nonce" />
                    <input type="hidden" name="accion" id="thagencia_galeria_que" value="1" />
                    <a href="javascript:void(0);" class="btn btn-warning" onclick="thagencia_galeria_crear()" title="Enviar"><i class="fas fa-plus"></i> Enviar</a>
               </div>
               </form>
            </div>
        <!--//formulario-->
      </div>
      
    </div>
  </div>
</div>
<!--//crear-->
 
<!-- Formulario de eliminar -->

<form action="" name="cuartapared_proyecto_eliminar" method="POST">
<input type="hidden" name="nonce" value="<?php echo wp_create_nonce('seg');?>" id="nonce" />
<input type="hidden" name="accion" id="cuartapared_proyecto_eliminar_foto_que" />
<input type="hidden" name="proyecto_id" id="cuartapared_proyecto_id" />
</form>