<?php
/**  */

namespace slider;
// Our custom post type function

function create_post_type() {

    register_post_type( 'slide',
        // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Слайдер',__NAMESPACE__ ),
                'singular_name' => __( 'Слайдер-', __NAMESPACE__ )
            ),
            'public' => true,
            'has_archive' => true,
	        'arhives'=>false,
	        'supports'=>array(
	        	'title','editor','thumbnail',
	        )


        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', __NAMESPACE__.'\create_post_type' );
