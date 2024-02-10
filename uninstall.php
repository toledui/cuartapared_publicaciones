<?php
if(!defined('ABSPATH')) die();
if(!function_exists('thagencia_galeria_eliminar')){
    function thagencia_galeria_eliminar(){
        global $wpdb;
        $wpdb->query("drop table {$wpdb->prefix}thagencia_galeria_fotos ;");
        $wpdb->query("drop table {$wpdb->prefix}thagencia_galeria ;");
    }
}
thagencia_galeria_eliminar();
