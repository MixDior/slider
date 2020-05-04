<?php
/*
Plugin Name: slider
Description: Тестовый слайдер
Plugin URI: https://
Description: --
Version: 1.0
Author: mixdior
Author URI: https://
License: A "Slug" license name e.g. GPL2
Text domain: slider
Date: 28.04.2020
*/

namespace slider;

require 'includes/post_types.php';

function get_plugin_path() {

	$plugin_path = plugin_dir_path( __FILE__ );
	$plugin_path = explode( '/', $plugin_path );
	$plugin_name = array_filter( $plugin_path, function ( $value ) {
		return ! empty( $value );
	} );
	$plugin_name = end( $plugin_name );

	return trailingslashit( plugins_url() ) . $plugin_name;
}


/**
 * Форма создания/редактирования публикации
 *
 * @return string
 */
function get_template($file, $atts) {

	$pathes = array(
		plugin_dir_path(__FILE__).'/templates/'.$file.'.php',
		get_stylesheet_directory_uri().'/templates/'.$file.'.php',
	);

	foreach ($pathes as $path){
		if(file_exists($path)){



	ob_start();

	include 'templates/'.$file.'.php';


	$out = ob_get_contents();
	ob_clean();

	return $out;
		}
	}

	return '';
}

/*
//***
 * Enqueues script with WordPress and adds version number that is a timestamp of the file modified date.
 *
 * @param string      $handle    Name of the script. Should be unique.
 * @param string|bool $src       Path to the script from the theme directory of WordPress. Example: '/js/myscript.js'.
 * @param array       $deps      Optional. An array of registered script handles this script depends on. Default empty array.
 * @param bool        $in_footer Optional. Whether to enqueue the script before </body> instead of in the <head>.
 *                               Default 'false'.
 */
/*function enqueue_versioned_script( $handle, $src = false, $deps = array(), $in_footer = false ) {
	wp_enqueue_script( $handle, get_stylesheet_directory_uri() . $src, $deps, filemtime( get_stylesheet_directory() . $src ), $in_footer );
}*/

/**
 * Enqueues stylesheet with WordPress and adds version number that is a timestamp of the file modified date.
 *
 * @param string      $handle Name of the stylesheet. Should be unique.
 * @param string|bool $src    Path to the stylesheet from the theme directory of WordPress. Example: '/css/mystyle.css'.
 * @param array       $deps   Optional. An array of registered stylesheet handles this stylesheet depends on. Default empty array.
 * @param string      $media  Optional. The media for which this stylesheet has been defined.
 *                            Default 'all'. Accepts media types like 'all', 'print' and 'screen', or media queries like
 *                            '(orientation: portrait)' and '(max-width: 640px)'.
 */
/*function enqueue_versioned_style( $handle, $src = false, $deps = array(), $media = 'all' ) {
	wp_enqueue_style( $handle, get_stylesheet_directory_uri() . $src, $deps = array(), filemtime( get_stylesheet_directory() . $src ), $media );
}*/



function enqueue_stiles(){
	wp_enqueue_style(__NAMESPACE__,get_plugin_path().'/assets/styles/style.css'/*,array(),date('His')*/);
	//enqueue_versioned_style( __NAMESPACE__,get_plugin_path().'/assets/styles/style.css');
	wp_enqueue_script('slider-script', get_plugin_path().'/assets/js/functions.js',array('jquery'),true);
	//enqueue_versioned_script( 'slider-script', get_plugin_path().'/assets/js/functions.js', array( 'jquery'), true );
}

add_action('wp_enqueue_scripts',__NAMESPACE__.'\enqueue_stiles');


function get_slider(){
		$attr=array(
			//Тип публикации
			'post_type'=>'slide',
			//Количество получаемых публикаций
			'post_per_page'=>3,
			//статус публикаций
			'post_status'=>'publish',
		);
		$slides=new \WP_Query($attr);
		if(empty($slides->posts)){
			return '';
		}

		$slider=array();
	foreach ( $slides->posts as $i=>$slide ) {
		$slide = (array)$slide;
		/*echo '<pre>';
		print_r($slide);
		echo '</pre>';*/

		$post_id=$slide['ID'];
		$slide['url']=get_the_post_thumbnail_url($post_id,'post-thumbnail');

		if(0==$i){
			$slide['active']=' active';
		}else{
			$slide['active']='';
		}
		$slide['index']=' data-slide="'.$i.'"';
		$slider[]=get_template('slide', $slide);

		}

	$slides_count=sizeof($slider);

	$slider=array('items'=>implode('',$slider));
	$slider['dots']='';
	/*echo '<pre>';
	print_r($slider);
	echo '</pre>';*/
	for ($i=0; $i<$slides_count;$i++){
		if(0==$i){
			$active=' active';
		}else{
			$active='';
		}

		$slider['dots'].='<li class="slider__dot'.$active.' js-slider-dot" data-index="'.$i.'"></li>';
	}
	$slider=get_template('slider', $slider);
	//$slider='<ul class="slider js-slider">'.implode('',$slider).'</ul>';

	return $slider;

		//

}

add_shortcode('slider',__NAMESPACE__.'\get_slider');

//eof