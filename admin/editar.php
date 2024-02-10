<?php
if(!defined('ABSPATH')) die();
if(!isset($_GET['id'])){
    ?>
    <script>
        window.location='<?php echo get_site_url() ?>/wp-admin/admin.php?page=cuartapared_publicaciones%2Fadmin%2Flistar.php';
    </script>
    <?php
}
$id=sanitize_text_field($_GET['id']);
global $wpdb;
$tabla = "{$wpdb->prefix}cuartapared_publicaciones";
$tabla2 = "{$wpdb->prefix}cuartapared_publicacion";
$tabla3 = "{$wpdb->prefix}cuartapared_publicacion_contenido";
if(isset($_POST['nonce'])){
     switch($_POST['accion']){
        case '1':
            $data = [
                'cuartapared_publicaciones_id'=>$id,
                'nombre' => sanitize_text_field($_POST['thagencia_galeria_agregar_foto_foto']),
                'descripcion' => sanitize_text_field($_POST['thagencia_galeria_agregar_descripcion']),
                'wordpress_id' => sanitize_text_field($_POST['thagencia_galeria_agregar_foto_wordpress_id']),
                'url'=>substr($_POST['thagencia_galeria_agregar_foto_url'],strlen(get_site_url()), strlen($_POST['thagencia_galeria_agregar_foto_url']))
                //'url' => sanitize_text_field($_POST['thagencia_galeria_agregar_foto_url']) 
            ]; 
              $wpdb->insert($tabla2, $data);
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
            $wpdb->delete($tabla2, array('id' =>$_POST['foto_id']));
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

$query="select * from {$tabla} where id='".$id."';";
$datos=$wpdb->get_results($query, ARRAY_A);
if(empty($datos)){?>
    <script>
        window.location='<?php echo get_site_url() ?>/wp-admin/admin.php?page=cuartapared_publicaciones%2Fadmin%2Flistar.php';
    </script>
    <?php }
$fotos=$wpdb->get_results("select * from {$tabla2} where cuartapared_publicaciones_id='".$id."' order by id desc;");
?>
<div class="wrap">
    <div class="container-fluid">
        <div class="row">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=cuartapared_publicaciones%2Fadmin%2Flistar.php">Cuartapared Publicacion</a></li> 
            <li class="breadcrumb-item active" aria-current="page">Crea tus <strong><?php echo $datos[0]['nombre'];?></strong></li>
        </ol>
        <h1 class="wp-heading-inline">Crea tus <strong><?php echo $datos[0]['nombre'];?></strong></h1>
        <p class="d-flex justify-content-end">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="agregar_nombre_publicacion();">
                        Agregar Publicación
                </button>
        </p>
        <hr/>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Foto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach($fotos as $foto){
                        ?>
                    <tr>
                        <td style="text-align:center; gap:20px;">
                            <p><?php echo $foto->descripcion; ?></p>
                        </td>
                        <td style="text-align:center;">
                            <img src="<?php echo get_site_url().$foto->url;?>" style=" height:200px" />
                        </td>
                        <td style="text-align:center;" class="">
                        <a href="<?php echo get_site_url();?>/wp-admin/admin.php?page=cuartapared_publicaciones%2Fadmin%2Fcontenido.php&id=<?php echo $foto->id;?>&lastId=<?php echo $id; ?>"><i class="fas fa-images"></i></a>
                            <a class="ml-6" href="javascript:void(0);" title="Eliminar" onclick="get_eliminar_foto_galeria('<?php echo $foto->cuartapared_publicaciones_id;?>', '<?php echo $foto->id;?>', '<?php echo $foto->url;?>');"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                        <?php
                    }?>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>
<!--formulario crear-->
<form action="" name="thagencia_galeria_agregar_foto" method="POST">
<input type="hidden" name="nonce" value="<?php echo wp_create_nonce('seg');?>" id="nonce" />
<input type="hidden" name="accion" value="1" />
    <input type="hidden" name="thagencia_galeria_agregar_foto_wordpress_id" />
    <input type="hidden" name="thagencia_galeria_agregar_foto_foto" />
    <input type="hidden" id="addDescrip" name="thagencia_galeria_agregar_descripcion" />
    <input type="hidden" name="thagencia_galeria_agregar_foto_url" />
</form>
<!--/formulario crear-->
<!--eliminar foto-->
<form action="" name="thagencia_galeria_eliminar_foto" method="POST">
<input type="hidden" name="nonce" value="<?php echo wp_create_nonce('seg');?>" id="nonce" />
<input type="hidden" name="accion" id="thagencia_galeria_eliminar_foto_que" />
    <input type="hidden" name="galeria_id" id="thagencia_galeria_eliminar_foto_galeria_id" />
    <input type="hidden" name="foto_id" id="thagencia_galeria_eliminar_foto_foto_id" />
    <input type="hidden" name="foto" id="thagencia_galeria_eliminar_foto_foto" />
</form>
<!--/eliminar foto-->

<!-- Modal para darle un nombre a la publicacion y después agregar la foto -->
<!-- <div class="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nombre de la publicación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="text" name="descripcion" id="publicacionDescripcion">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="addImagePublicacion">Agregar Imagen</button>
      </div>
    </div>
  </div>
</div> -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Nombre de la publicación</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formName">
             <input type="text" name="descripcion" id="descripcion" placeholder="Agregar Nombre">
             <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Agregar Publicación</button>
        </div>
        </form>
      </div>

    </div>
  </div>
</div>