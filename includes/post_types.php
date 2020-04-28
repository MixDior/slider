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
                'singular_name' => __( 'Слайдер-' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'movies'),
            'show_in_rest' => true,

        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', __NAMESPACE__.'/create_posttype' );
