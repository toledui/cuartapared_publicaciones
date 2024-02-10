<?php
/*
Plugin Name: Cuarta Pared Publicaciones
Plugin URI: https://www.cuartapared.com/
Description: Este plugin es para crear galería de imágenes para las publicaciones
Version: 1.0.3
Author: Luis Toledo
Author URI: https://www.cuartapared.com/
License: GPL
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: cuartapared_publicaciones
*/
if(!defined('ABSPATH')) die();
if(!function_exists('cuartapared_publicaciones_instalar')){
    function cuartapared_publicaciones_instalar(){
       
         //creamos tablas
        global $wpdb;
        $sql ="create table if not exists 
            {$wpdb->prefix}cuartapared_publicaciones
            (
            id int not null auto_increment,
            nombre varchar(255) not null,
            fecha date,
            primary key (id)
            ); 
            ";
        $wpdb->query($sql);
        $sql2 ="create table if not exists 
            {$wpdb->prefix}cuartapared_publicacion
            (
            id int not null auto_increment,
            cuartapared_publicaciones_id int,
            descripcion varchar(255) not null,
            wordpress_id int,
            nombre varchar(255) not null,
            url varchar(500) not null,
            primary key (id)
            ); 
            ";
        $wpdb->query($sql2);
        $fk="alter table {$wpdb->prefix}cuartapared_publicacion add constraint fk_cuartapared_publicaciones_id foreign key (cuartapared_publicaciones_id) references {$wpdb->prefix}cuartapared_publicaciones(id);";
        $wpdb->query($fk);

        $sql3 ="create table if not exists 
        {$wpdb->prefix}cuartapared_publicacion_contenido
        (
        id int not null auto_increment,
        cuartapared_publicacion_id int,
        wordpress_id int,
        nombre varchar(255) not null,
        url varchar(500) not null,
        primary key (id)
        ); 
        ";
        $wpdb->query($sql3);
        $fk="alter table {$wpdb->prefix}cuartapared_publicacion_contenido add constraint fk_cuartapared_publicacion_id foreign key (cuartapared_publicacion_id) references {$wpdb->prefix}thagencia_publicacion(id);";
        $wpdb->query($fk);
        
    }
    
}
if(!function_exists('cuartapared_publicaciones_desactivar')){
    function cuartapared_publicaciones_desactivar(){

        #limpiador de enlaces permanentes
        flush_rewrite_rules( );
    } 
}
 

#activar plugins
register_activation_hook( __FILE__, 'cuartapared_publicaciones_instalar' );
#desactivar
register_deactivation_hook( __FILE__, 'cuartapared_publicaciones_desactivar' );

#enqueue
if(!function_exists('thagencia_galeria_scripts')){
    function thagencia_galeria_scripts($hook){
        if($hook=='cuartapared_publicaciones/admin/listar.php' or $hook=='cuartapared_publicaciones/admin/editar.php' or $hook=='cuartapared_publicaciones/admin/contenido.php' or $hook=='cuartapared_publicacion'){
        wp_enqueue_style( "bootstrapcss",  plugins_url( 'assets/css/bootstrap.min.css', __FILE__ ) );
        wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');
        wp_enqueue_style( "sweetalert2",  plugins_url( 'assets/css/sweetalert2.css', __FILE__ ) );
        wp_enqueue_script( "bootstrapjs",  plugins_url( 'assets/js/bootstrap.min.js', __FILE__ ), array('jquery')); 
        wp_enqueue_script( "sweetalert2",  plugins_url( 'assets/js/sweetalert2.js', __FILE__ ), array('jquery'));
        wp_enqueue_script( "funcionesj",  plugins_url( 'assets/js/funciones.js', __FILE__ ) );

        wp_localize_script('funcionesj','datosajax',[
            'url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('seg')
        ]);
        //llamamos a lo necesario para manejar media
        wp_enqueue_media();
        }else{
            return;
        }
        
       
     }
     add_action('admin_enqueue_scripts', 'thagencia_galeria_scripts'); 
}


#agregar al menú
add_action('admin_menu', function(){
    add_menu_page( 
        "Cuarta Pared Publicaciones", 
        "Cuarta Pared Publicaciones", 
        "manage_options",  
        plugin_dir_path( __FILE__ )."admin/listar.php", 
        null, 
        plugin_dir_url( __FILE__ )."assets/images/galeria.png", 
        140 );
    add_submenu_page(
        plugin_dir_path( __FILE__ )."admin/listar.php",
        "Publicaciones",
        "Publicaciones",
        "manage_options",
        plugin_dir_path( __FILE__ )."admin/editar.php", 
        null

    );
    add_submenu_page(
        plugin_dir_path( __FILE__ )."admin/contenido.php",
        "Contenido de la publicación",
        "Contenido",
        "manage_options",
        plugin_dir_path( __FILE__ )."admin/contenido.php", 
        null

    );
});
//shortcode
//[cuartapared_publicacion id="10"]
add_action('init', function(){
    add_shortcode( 'cuartapared_publicacion', 'thagencia_galeria_codigo_corto_display' );
});
if(!function_exists('thagencia_galeria_codigo_corto_display')){

    add_action( 'wp_enqueue_scripts', 'cuartapared_plugin_assets' );
        function cuartapared_plugin_assets() {
            // wp_register_style( 'swipercss', 'https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.2.2/css/swiper.min.css' );
            wp_register_style( 'swipercss',  plugins_url('assets/css/swiper4-2-2.min.css', __FILE__ ), '4.2.2' );
            wp_register_style( 'bootstrapcss',  plugins_url('assets/css/bootstrap.min.css', __FILE__ ) );
            // wp_register_style( 'swipercss', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css' );
            wp_register_style( 'swipercustomcss', plugins_url( 'assets/css/swipercustom.css', __FILE__ ) );
            wp_register_script( 'swiperjs', plugins_url('assets/js/swiper4-2-2.min.js', __FILE__), array('jquery'), '4.2.2' );
            wp_register_script( 'bootstrapjs', plugins_url('assets/js/bootstrap.min.js', __FILE__), array('jquery'), '', true );
            // wp_register_script( 'swipercustomjs', plugins_url('assets/js/swipercustom.js', __FILE__));
            wp_register_script( "funcionesj",  plugins_url( 'assets/js/funciones.js', __FILE__ ), array('jquery'), '', true );

            wp_localize_script('funcionesj','datosajax',[
                'url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('seg')
            ]);

            wp_enqueue_style( 'swipercss' );
            wp_enqueue_style( 'bootstrapcss' );
            wp_enqueue_style( 'swipercustomcss' );
            wp_enqueue_script( 'bootstrapjs' );
            wp_enqueue_script( 'funcionesj' );
            wp_enqueue_script( 'swiperjs' );
            // wp_enqueue_script( 'swipercustomjs' );
        }

    function thagencia_galeria_codigo_corto_display($argumentos, $content=""){
        global $wpdb;
        $query="select * from {$wpdb->prefix}cuartapared_publicacion where cuartapared_publicaciones_id='".sanitize_text_field($argumentos['id'])."' order by id desc;"; 
        $datos=$wpdb->get_results($query, ARRAY_A);
        ?>

        <!-- Demo styles -->
  <style>
 
  
  </style>

<div class="swiper-container swiperid<?php echo $argumentos['id']; ?>" id=".swiperid<?php echo $argumentos['id']; ?>">
  <div class="swiper-wrapper grid-container">
    <?php foreach($datos as $dato): ?>
    <div class="swiper-slide publicacionInd" style="background-image: url('<?php echo site_url() . $dato['url']; ?>'); "><div onclick="get_contenidos_publicacion(<?php echo $dato['id']; ?>)" class="namePubli"><?php echo $dato['descripcion']; ?></div></div>
    <?php endforeach; ?>
  </div>
  <!-- Add Pagination -->
  <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
  <div class="swiper-pagination"></div>
</div>
  <!-- Swiper JS -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.2.2/js/swiper.min.js"></script> -->
 

  <!-- Initialize Swiper -->
  <script>
    const mySwiper<?php echo $argumentos['id']; ?> = new Swiper('.swiperid<?php echo $argumentos['id']; ?>', {
    slidesPerView: 3,
    slidesPerColumn: 2,
    slidesPerGroup :3,
    spaceBetween: 15,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    on: {
      init: function () {},
      orientationchange: function(){},
      beforeResize: function(){
        let vw = window.innerWidth;
        if(vw > 1000){
          mySwiper<?php echo $argumentos['id']; ?>.params.slidesPerView = 3
            mySwiper<?php echo $argumentos['id']; ?>.params.slidesPerColumn = 2
            mySwiper<?php echo $argumentos['id']; ?>.params.slidesPerGroup = 3;
        } else {
          mySwiper<?php echo $argumentos['id']; ?>.params.slidesPerView = 2
            mySwiper<?php echo $argumentos['id']; ?>.params.slidesPerColumn = 2
            mySwiper<?php echo $argumentos['id']; ?>.params.slidesPerGroup =2;
        }
        mySwiper<?php echo $argumentos['id']; ?>.init();
        if(vw < 768){
          mySwiper<?php echo $argumentos['id']; ?>.params.slidesPerView = 2
            mySwiper<?php echo $argumentos['id']; ?>.params.slidesPerColumn = 2
            mySwiper<?php echo $argumentos['id']; ?>.params.slidesPerGroup =2;
        }
      },
    },
});
    

  </script>
      

      <!-- Insertamos el modal para el segundo slider -->
          <!-- Modal -->
          <div class="modal fade" id="contenidosModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalContBody">
                  
                </div>
              </div>
            </div>
          </div>

      <?php
    }
}

if(!function_exists('cuartapared_contenido_ajax')){
  function cuartapared_contenido_ajax(){
    $nonce = $_POST['nonce'];
    if(!wp_verify_nonce($nonce, 'seg')){
        die('no tiene permisos para ejecutar ese ajax');
    }
    global $wpdb;
        $query="select * from {$wpdb->prefix}cuartapared_publicacion_contenido where cuartapared_publicacion_id='".sanitize_text_field($_POST['id'])."' order by id asc;";
        $contenidos=$wpdb->get_results($query, ARRAY_A);
    ?>
      <div class="swiper-container swiper<?php echo $_POST['id']; ?>" id="swiper<?php echo $_POST['id']; ?>">
  <div class="swiper-wrapper grid-container">
    <?php foreach($contenidos as $contenido): ?>
    <div class="swiper-slide swiper-slide2 publicacionInd"><img src="<?php echo site_url() . $contenido['url']; ?>" alt="Imagen del contenido"></div>
    <?php endforeach; ?>
  </div>
  <!-- Add Pagination -->
  <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
  <div class="swiper-pagination"></div>
</div>
  <!-- Swiper JS -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.2.2/js/swiper.min.js"></script> -->

  <!-- Initialize Swiper -->
  <script>
    
    function show_swiper_slider(){
      
    const mySwiper2<?php echo $_POST['id']; ?> = new Swiper('.swiper<?php echo $_POST['id']; ?>', {
    slidesPerView: 1,
    slidesPerColumn: 1,
    slidesPerGroup :1,
    spaceBetween: 30,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    on: {
      init: function () {},
      orientationchange: function(){},
      beforeResize: function(){
        let vw = window.innerWidth;
        if(vw > 1000){
          mySwiper2<?php echo $_POST['id']; ?>.params.slidesPerView = 1
            mySwiper2<?php echo $_POST['id']; ?>.params.slidesPerColumn = 1
            mySwiper2<?php echo $_POST['id']; ?>.params.slidesPerGroup = 1;
        } else {
          mySwiper2<?php echo $_POST['id']; ?>.params.slidesPerView = 1
            mySwiper2<?php echo $_POST['id']; ?>.params.slidesPerColumn = 1
            mySwiper2<?php echo $_POST['id']; ?>.params.slidesPerGroup =1;
        }
        mySwiper2<?php echo $_POST['id']; ?>.init();
      },
    },
});
      }
    
  </script>
    <?php
    die();
  }

  add_action('wp_ajax_cuartapared_contenido_ajax', 'cuartapared_contenido_ajax');
}