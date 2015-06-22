<?php
/*
Plugin Name: WPLMS Hover Blocks
Plugin URI: http://www.Vibethemes.com
Description: WordPress plugin to add new fured blocks in WPLMS
Version: 1.0
Author: VibeThemes
Author URI: http://www.vibethemes.com
License: GPL2
*/

include_once 'classes/slide_info.php';
include_once 'classes/hover_squeeze.php';

function wplms_hover_enqueue_scripts(){
    wp_enqueue_style( 'wplms-hover-component-css', plugins_url( 'css/component.css' , __FILE__ ));
    wp_enqueue_script( 'wplms-hover1-js', plugins_url( 'js/modernizr.custom.js' , __FILE__ ));
    wp_enqueue_script( 'wplms-hover2-js', plugins_url( 'js/toucheffects.js' , __FILE__ ));
}

add_action('wp_head','wplms_hover_enqueue_scripts');
add_action('wp_enqueue_scripts','wplms_hover_enqueue_scripts');

//add_action('init','wplms_hover_blocks_init');
//function wplms_hover_blocks_init(){ 
    new wplms_hover_squeeze;
    new wplms_slide_info;
//}


?>
