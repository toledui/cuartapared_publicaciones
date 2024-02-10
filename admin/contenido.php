<?php 
if(!defined('ABSPATH')) die();
$id = sanitize_text_field($_GET['id']);
$lastId = sanitize_text_field($_GET['lastId']);
global $wpdb;
$tabla2 = "{$wpdb->prefix}cuartapared_publicacion";
$tabla3 = "{$wpdb->prefix}cuartapared_publicacion_contenido";
$contenidos=$wpdb->get_results("select * from {$tabla3} where cuartapared_publicacion_id='".$id."' order by id desc;");
$query="select * from {$tabla2} where id='".$id."';";
$datos=$wpdb->get_results($query, ARRAY_A);

if(isset($_POST['nonce'])){
    switch($_POST['accion']){
       case '1':
           $data = [
               'cuartapared_publicacion_id'=>$id,
               'nombre' => sanitize_text_field($_POST['thagencia_galeria_agregar_foto_foto2']),
               'wordpress_id' => sanitize_text_field($_POST['thagencia_galeria_agregar_foto_wordpress_id2']),
               'url'=>substr($_POST['thagencia_galeria_agregar_foto_url2'],strlen(get_site_url()), strlen($_POST['thagencia_galeria_agregar_foto_url2']))
               //'url' => sanitize_text_field($_POST['thagencia_galeria_agregar_foto_url']) 
           ]; 
             $wpdb->insert($tabla3, $data);
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
           $wpdb->delete($tabla3, array('id' =>$_POST['foto_id']));
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


?>
       <div class="wrap">
    <div class="container-fluid">
        <div class="row">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=cuartapared_publicaciones%2Fadmin%2Flistar.php">Proyecto</a></li> 
            <li class="breadcrumb-item"><a href="<?php echo get_site_url() ?>/wp-admin/admin.php?page=cuartapared_publicaciones%2Fadmin%2Feditar.php&id=<?php echo $lastId; ?>">Publicación</a></li> 
            <li class="breadcrumb-item active" aria-current="page">Contenido <strong><?php echo $datos[0]['descripcion'];?></strong></li>
        </ol>
        <h1 class="wp-heading-inline">Crea tus contenidos para la publicación <strong><?php echo $datos[0]['descripcion'];?></strong></h1>
        <p class="d-flex justify-content-end">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary btnMarco"  >
                <i class="fas fa-plus"></i> Agregar Contenido
                </button>
        </p>
        <hr/>
       
       <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    foreach($contenidos as $contenido){
                        ?>
                    <tr>
                        <td style="text-align:center;">
                            <img src="<?php echo get_site_url().$contenido->url;?>" style=" height:200px" />
                        </td>
                        <td style="text-align:center;">
                            <a href="javascript:void(0);" title="Eliminar" onclick="get_eliminar_foto_contenido('<?php echo $contenido->cuartapared_publicacion_id;?>', '<?php echo $contenido->id;?>', '<?php echo $contenido->url;?>');"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                        <?php
                    }?>
                </tbody>
            </table>
        </div>
    </div>

    <!--formulario crear-->
<form action="" name="thagencia_galeria_agregar_foto2" method="POST">
<input type="hidden" name="nonce" value="<?php echo wp_create_nonce('seg');?>" id="nonce" />
<input type="hidden" name="accion" value="1" />
    <input type="hidden" name="thagencia_galeria_agregar_foto_wordpress_id2" />
    <input type="hidden" name="thagencia_galeria_agregar_foto_foto2" />
    <input type="hidden" name="thagencia_galeria_agregar_foto_url2" />
</form>
<!--/formulario crear-->
<!--eliminar foto-->
<form action="" name="thagencia_galeria_eliminar_foto2" method="POST">
<input type="hidden" name="nonce" value="<?php echo wp_create_nonce('seg');?>" id="nonce" />
<input type="hidden" name="accion" id="thagencia_galeria_eliminar_foto_que2" />
    <input type="hidden" name="galeria_id" id="thagencia_galeria_eliminar_foto_galeria_id2" />
    <input type="hidden" name="foto_id" id="thagencia_galeria_eliminar_foto_foto_id2" />
    <input type="hidden" name="foto" id="thagencia_galeria_eliminar_foto_foto2" />
</form>
<!--/eliminar foto-->