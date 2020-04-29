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


function enqueue_stiles(){
	wp_enqueue_style(__NAMESPACE__,get_plugin_path().'/assets/styles/style.css'/*,array(),date('His')*/);
	wp_enqueue_script(__NAMESPACE__, get_plugin_path().'/assets/js/functions.js',array('jquery'),'1',true);
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
	foreach ( $slides->posts as $slide ) {
		$slide = (array)$slide;

		$post_id=$slide['ID'];
		$slide['url']=get_the_post_thumbnail_url($post_id,'full');

		$slider[]=get_template('slide', $slide);

		}

	$slider='<ul class="slider js-slider">'.implode('',$slider).'</ul>';

	return $slider;

		//

}

add_shortcode('slider',__NAMESPACE__.'\get_slider');

//eof