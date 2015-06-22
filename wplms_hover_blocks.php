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

if(class_exists('WPLMS_HoverBlock_Plugin_Class'))
{	
    // Installation and uninstallation hooks
    register_activation_hook(__FILE__, array('WPLMS_HoverBlock_Plugin_Class', 'activate'));
    register_deactivation_hook(__FILE__, array('WPLMS_HoverBlock_Plugin_Class', 'deactivate'));

    // instantiate the plugin class
    new wplms_hover_squeeze();
    new wplms_slide_info();
}

function wplms_hover_enqueue_scripts(){
    wp_enqueue_style( 'wplms-hover1-css', plugins_url( 'css/component.css' , __FILE__ ));
    wp_enqueue_style( 'wplms-hover2-css', plugins_url( 'css/default.css' , __FILE__ ));
    wp_enqueue_script( 'wplms-hover1-js', plugins_url( 'js/modernizr.custom.js' , __FILE__ ));
     wp_enqueue_script( 'wplms-hover2-js', plugins_url( 'js/toucheffects.js' , __FILE__ ));
}

add_action('wp_head','wplms_hover_enqueue_scripts');
add_action('wp_enqueue_scripts','wplms_hover_custom_cssjs');


?>
