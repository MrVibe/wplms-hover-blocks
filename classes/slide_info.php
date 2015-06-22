<?php

if(!class_exists('wplms_slide_info'))
{   
    class wplms_slide_info  // We'll use this just to avoid function name conflicts 
    {
            
        public function __construct(){   
      
 		add_filter('vibe_builder_thumb_styles',array($this,'custom_vibe_builder_thumb_styles'));
    	add_filter('vibe_featured_thumbnail_style',array($this,'hover_vibe_featured_thumbnail_style'),10,3);
      	add_action('wplms_customizer_custom_css',array($this,'customize_color'),10,1);

        } // END public function __construct
        function custom_vibe_builder_thumb_styles($thumb_array){
            $thumb_array['slide_info']= plugins_url( 'images/slide_info.jpg', dirname(__FILE__) );
            return $thumb_array;
        }
        function hover_vibe_featured_thumbnail_style($thumbnail_html,$post,$style){
		    if($style == 'slide_info'){ //Custom block is the same name as added for the thumbnail in pagebuilder
		         $thumbnail_html ='<div class="block slide_info">';
		        $thumbnail_html .= '<div class="block_media">';
		        $thumbnail_html .= '<a href="'.get_permalink($post->ID).'">'.get_the_post_thumbnail($post->ID,'medium').'</a>';
		        $thumbnail_html .= '</div>';
		        $thumbnail_html .= '<div class="block_content">';
		        $thumbnail_html .= apply_filters('vibe_thumb_heading','<h4 class="block_title"><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">'.$post->post_title.'</a></h4>',$featured_style);

                if(get_post_type($post->ID) == 'course'){
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

                    $meta .=bp_course_get_course_credits(array('id'=>$post->ID));
                    
                    $meta .='<span class="clear"></span>';

                    
                    $instructor_meta='';
                    if(function_exists('bp_course_get_instructor'))
                        $instructor_meta .= bp_course_get_instructor();
                    
                    $meta .= apply_filters('vibe_thumb_instructor_meta',$instructor_meta,$featured_style);

                    $st = get_post_meta($post->ID,'vibe_students',true);
                    if(isset($st) && $st !='')
                        $meta .= apply_filters('vibe_thumb_student_count','<strong>'.$st.' '.__('Students','vibe-customtypes').'</strong>');

                    
                    $thumbnail_html .= $meta;
                }
		        $thumbnail_html .= '</div>';
		        $thumbnail_html .= '</div>';
		    }
		    return $thumbnail_html;
		}
	


		function customize_color($customizer){
			if(isset($customizer['single_dark_color'])){
	          echo '.block.slide_info .block_content{background: '.$customizer['single_dark_color'].' !important;}';
	        }
		}
                           

         // ADD custom Code in clas
        
    } // END class WPLMS_HoverBlock_Plugin_Class
} // END if(!class_exists('WPLMS_HoverBlock_Plugin_Class'))

?>