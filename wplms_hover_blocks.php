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



/**
 * Objective: Register & Enqueue your Custom scripts
 * Developer notes:
 * Hook you custom scripts required for the plugin here.
 */

if(!class_exists('wplms_hover_blocks'))
{   
    class wplms_hover_blocks  // We'll use this just to avoid function name conflicts 
    {
    	public function __construct(){
    		add_action('wp_enqueue_scripts',array($this,'wplms_customizer_custom_cssjs'));
    		add_filter('vibe_builder_thumb_styles',array($this,'custom_vibe_builder_thumb_styles_hover'));
			add_filter('vibe_featured_thumbnail_style',array($this,'custom_vibe_featured_thumbnail_style'),10,3);
    	}

    	function wplms_customizer_custom_cssjs(){
		    wp_enqueue_style( 'wplms-hover-blocks-css', plugins_url( 'css/component.css' , __FILE__ ));
		    wp_enqueue_script( 'wplms-hover-blocks-modernizr', plugins_url( 'js/modernizr.custom.js' , __FILE__ ));
		    wp_enqueue_script( 'wplms-hover-blocks-toucheffects', plugins_url( 'js/toucheffects.js' , __FILE__ ));
		}

		function custom_vibe_builder_thumb_styles_hover($thumb_array){
			$thumb_array['hover_squeeze']= 'http://i.imgur.com/MtUNWIA.png';
		    return $thumb_array;
		}

		function custom_vibe_featured_thumbnail_style($thumbnail_html,$post,$style){
		    if($style == 'hover_squeeze'){ //Custom block is the same name as added for the thumbnail in pagebuilder
		        $thumbnail_html = '<div class="block hover_squeeze">';
		        $thumbnail_html .='<div class="block_media">';
                $thumbnail_html .= apply_filters('vibe_thumb_featured_image','<a href="'.get_permalink($post->ID).'">'.featured_component($post->ID,'medium').'</a>',$style);
                $thumbnail_html .='</div>';
		        $thumbnail_html .='<div class="block_content">';
		        $thumbnail_html .= apply_filters('vibe_thumb_heading','<h4 class="block_title"><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">'.$post->post_title.'</a></h4>',$style);
		        if($post->post_type == 'course'){
                        $rating=get_post_meta($post->ID,'average_rating',true);
                        $rating_count=get_post_meta($post->ID,'rating_count',true);
                        $meta = '<div class="star-rating">';
                        for($i=1;$i<=5;$i++){

                            if(isset($rating)){
                                if($rating >= 1){
                                    $meta .='<span class="fill"></span>';
                                }elseif(($rating < 1 ) && ($rating > 0.4 ) ){
                                    $meta .= '<span class="half"></span>';
                                }else{
                                    $meta .='<span></span>';
                                }
                                $rating--;
                            }else{
                                $meta .='<span></span>';
                            }
                        }
                        $meta =  apply_filters('vibe_thumb_rating',$meta,$featured_style,$rating);
                        $meta .= apply_filters('vibe_thumb_reviews','(&nbsp;'.(isset($rating_count)?$rating_count:'0').'&nbsp;'.__('REVIEWS','vibe-customtypes').'&nbsp;)',$featured_style).'</div>';

                        $free_course = get_post_meta($post->ID,'vibe_course_free',true);
                        $st = get_post_meta($post->ID,'vibe_students',true);
                        if(isset($st) && $st !='')
                            $meta .= apply_filters('vibe_thumb_student_count','<strong><i class="icon-users"></i>&nbsp;'.$st.'</strong>');

                        $meta .='<span class="clear"></span>';

                        
                        $instructor_meta='';
                        if(function_exists('bp_course_get_instructor'))
                            $instructor_meta .= bp_course_get_instructor();
                        
                        $meta .= apply_filters('vibe_thumb_instructor_meta',$instructor_meta,$featured_style);
                        $meta .= bp_course_get_course_credits(array('id'=>$post->ID));

                        $thumbnail_html .= $meta;
                }
		        $thumbnail_html .= '</div>';
		        $thumbnail_html .= '</div>';
		    }
		    return $thumbnail_html;
		}

	}
}

new wplms_hover_blocks;
?>