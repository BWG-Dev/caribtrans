<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

include_once get_stylesheet_directory() . '/src/settings.php';
include_once get_stylesheet_directory() . '/src/ajax.php';
/**
 *
 */
add_action( 'wp_enqueue_scripts', 'ct_enqueue_scripts' );
/**
 * Enqueue scripts and styles for the ct_enqueue_scripts function.
 *
 * This function is used to enqueue scripts and styles in WordPress. In this
 * particular function, it enqueues the Leaflet JavaScript library.
 *
 * @return void
 */
function ct_enqueue_scripts() {

	wp_enqueue_style( 'leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css' );
	wp_enqueue_style( 'main-ct-css', get_stylesheet_directory_uri() . '/src/css/main.css' );

	wp_enqueue_script( 'leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', array(), '1.9.4', true );
	wp_enqueue_script( 'main-ct-js', get_stylesheet_directory_uri() . '/src/js/main.js', array( 'leaflet-js', 'jquery' ), '1.0.0', true );
	wp_localize_script( 'main-ct-js', 'parameters', ['ajax_url'=> admin_url('admin-ajax.php')]);
}


if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        if ( !file_exists( trailingslashit( get_stylesheet_directory() ) . 'src/css/main.css' ) ):
            wp_deregister_style( 'main-ct-css' );
            wp_register_style( 'main-ct-css', trailingslashit( get_template_directory_uri() ) . 'src/css/main.css' );
        endif;
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'main-ct-css','hello-elementor','hello-elementor','hello-elementor-theme-style','hello-elementor-header-footer' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );

// END ENQUEUE PARENT ACTION


function accordion_post_listing_shortcode($atts) {
    $output = '';
?>
<script>
jQuery(document).ready(function(){
    jQuery('.accordion-body').hide(); // Hide all accordion bodies initially
    jQuery('.accordion-body:first').show(); // Show the first accordion body
    jQuery('.accordion-header:first').addClass('active'); // Add active class to the first header
    
    jQuery('.accordion-header').click(function(){
        var isActive = jQuery(this).hasClass('active');

        jQuery('.accordion-body').slideUp(); // Close all accordion bodies
        jQuery('.accordion-header').removeClass('active'); // Remove active class from all headers

        if (!isActive) {
            jQuery(this).next('.accordion-body').slideDown(); // Open the clicked accordion body
            jQuery(this).addClass('active'); // Add active class to the clicked header
        }
    });
});
</script>
<?php
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    if (!empty($atts['category'])) {
        $args['category_name'] = $atts['category'];
    }

    $posts = new WP_Query($args);

    if ($posts->have_posts()) {
        $posts_by_year = array();

        while ($posts->have_posts()) {
            $posts->the_post();
            $year = get_the_date('Y');

            $posts_by_year[$year][] = array(
                'title' => get_the_title(),
                'permalink' => get_permalink(),
            );
        }

        $output .= '<div class="accordion">';

        foreach ($posts_by_year as $year => $year_posts) {
            $output .= '<div class="accordion-item">';
                $output .= '<div class="accordion-header">' . $year . ' <i class="fa fa-angle-down" aria-hidden="true"></i></div>';
                $output .= '<div class="accordion-body">';
                foreach ($year_posts as $post) {
                    $output .= '<p>' . get_the_date("j/n/Y") . ' <a href="' . $post['permalink'] . '">' . $post['title'] . '</a></p>';
                }
                $output .= '</div>';

            $output .= '</div>';
        }

        $output .= '</div>';
    } else {
        $output .= 'No posts found.';
    }

    wp_reset_postdata();
    return $output;
}
add_shortcode('accordion_post_listing', 'accordion_post_listing_shortcode');
