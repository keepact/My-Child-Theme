<?php
/**
 * astra-child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package astra-child
 * @since 1.0.0
 */

include('custom-shortcodes.php');
include('contact-form.php');
include('custom-querys.php');
include('posts-widget.php');
include('footer-layout.php');
include('schema-markup.php');


/**
 * Enqueue styles
 */


/* Wordpress Dashicons CSS */

function ww_load_dashicons(){
    wp_enqueue_style('dashicons');
}
add_action('wp_enqueue_scripts', 'ww_load_dashicons');

/* Astra Child CSS */

function my_theme_enqueue_styles() {

    $parent_style = 'astra-child-theme'; 

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );






/**
 * Function to add Custom Color Palete To Gutenberg Editor
 *
 * @param  string mytheme_setup_theme_supported_features filter.
 * @return html      Markup.
 */

function rioexp_setup_theme_supported_features() {
    add_theme_support( 'editor-color-palette', array(
        array(
            'name' => __( 'whitesmoke', 'astra' ),
            'slug' => 'white-smoke',
            'color' => '#f5f5f5',
        ),
        array(
            'name' => __( 'light orange', 'astra' ),
            'slug' => 'light-orange',
            'color' => '#fed620',
        ),
        array(
            'name' => __( 'very light gray', 'astra' ),
            'slug' => 'very-light-gray',
            'color' => '#eee',
        ),
        array(
            'name' => __( 'black', 'astra' ),
            'slug' => 'black',
            'color' => '#000',
		),
		array(
            'name' => __( 'white', 'astra' ),
            'slug' => 'white',
            'color' => '#ffffff',
		),
		array(
            'name' => __( 'light green cyan', 'astra' ),
            'slug' => 'light-green-cyan',
            'color' => '#7bdcb5',
		),
		array(
            'name' => __( 'light blue', 'astra' ),
            'slug' => 'light-blue',
            'color' => '#395697',
        ),
    ) );
}
 
add_action( 'after_setup_theme', 'rioexp_setup_theme_supported_features' );






/**
 * Function to change Astra Body Classes
 *
 * @since 1.0.0
 * @return html
 */

function astra_body_classes( $classes ) {

	// Apply separate container class to the body.
	$content_layout = astra_get_content_layout();
	if ( is_archive() || is_home() ) { 
	    $classes[] = 'ast-header-custom-item-inside';
		$classes[] = 'ast-right-sidebar';
		$classes[] = 'ast-separate-container';
		$classes[] = 'ast-two-container';
	} else 
		$classes[] = 'ast-page-builder-template';
		$classes[] = 'ast-header-custom-item-inside';
		$classes[] = 'ast-no-sidebar';
    return $classes;
}
add_filter( 'body_class', 'astra_body_classes' );






/**
 * Function to Remove Specific Body Classes
 *
 * @since 1.0.0
 * @return html
 */

add_filter( 'body_class', function( $classes ) {
    foreach($classes as $key => $class) {
        if( $class == "post-template-featuredarticle-php" || $class == "page-template-front-page-php" ) {
            unset($classes[$key]);
        }
    }
    return $classes;
}, 1000);





/**
 * Function to remove Sidebar From Search Page
 *
 * @param  string astra_blog_post_meta' filter.
 * @since 1.0.0
 * @return html
 */

add_filter( 'astra_page_layout', 'rioexp_remove_sidebar_search' );
function rioexp_remove_sidebar_search( $sidebar ) {
    if ( is_search() ) {
        $sidebar = 'no-sidebar';
    }
    return $sidebar;
}





/**
 * Function to Remove Pages From Search Results
 *
 * @param  string astra_entry_content_after' filter.
 * @since 1.0.0
 * @return html
 */

add_filter('register_post_type_args', function($args, $post_type) {    
    if (!is_admin() && $post_type == 'page') {
	$args['exclude_from_search'] = true;
	}
    return $args;
    
}, 10, 2);





/**
 * Function remove Emojis 
 *
 * @since 1.0.0
 * @return html
 */

remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );





/**
 * Function to support SVG images
 *
 * @since 1.0.0
 * @return html
 */

add_action('upload_mimes', 'rioexp_add_svg_to_uploads');
function rioexp_add_svg_to_uploads($file_types){    
    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types = array_merge($file_types, $new_filetypes );
  
    return $file_types;
}

//enable upload for webp image files.
add_action('upload_mimes', 'rioexp_add_webp_to_uploads');
function rioexp_add_webp_to_uploads($file_types){    
    $new_filetypes = array();
    $new_filetypes['webp'] = 'image/webp';
    $file_types = array_merge($file_types, $new_filetypes );
  
    return $file_types;
}

/**
 * Sets the extension and mime type for .webp files.
 *
 * @param array  $wp_check_filetype_and_ext File data array containing 'ext', 'type', and
 *                                          'proper_filename' keys.
 * @param string $file                      Full path to the file.
 * @param string $filename                  The name of the file (may differ from $file due to
 *                                          $file being in a tmp directory).
 * @param array  $mimes                     Key is the file extension with value as the mime type.
 */
add_filter( 'wp_check_filetype_and_ext', 'wpse_file_and_ext_webp', 10, 4 );
function wpse_file_and_ext_webp( $types, $file, $filename, $mimes ) {
    if ( false !== strpos( $filename, '.webp' ) ) {
        $types['ext'] = 'webp';
        $types['type'] = 'image/webp';
    }

    return $types;
}

/**
 * Adds webp filetype to allowed mimes
 * 
 * @see https://codex.wordpress.org/Plugin_API/Filter_Reference/upload_mimes
 * 
 * @param array $mimes Mime types keyed by the file extension regex corresponding to
 *                     those types. 'swf' and 'exe' removed from full list. 'htm|html' also
 *                     removed depending on '$user' capabilities.
 *
 * @return array
 */
add_filter( 'upload_mimes', 'wpse_mime_types_webp' );
function wpse_mime_types_webp( $mimes ) {
    $mimes['webp'] = 'image/webp';

  return $mimes;
}


//enable preview / thumbnail for webp image files.
function webp_is_displayable($result, $path) {
    if ($result === false) {
        $displayable_image_types = array( IMAGETYPE_WEBP );
        $info = @getimagesize( $path );

        if (empty($info)) {
            $result = false;
        } elseif (!in_array($info[2], $displayable_image_types)) {
            $result = false;
        } else {
            $result = true;
        }
    }

    return $result;
}
add_filter('file_is_displayable_image', 'webp_is_displayable', 10, 2);






/**
 * Function to remove URL Field from Comments
 *
 * @param  string ry_remove_auhtor_link filter.
 * @return html      Markup.
 */

add_filter( 'comment_form_default_fields', 'rioexp_remove_comment_fields', 60 );
function rioexp_remove_comment_fields( $fields ) {    
	unset( $fields['url'] );
	return $fields;
}






/**
 * Function to change H1 to Span tag on Site Title
 *
 * @param  string widget_title_tag filter.
 * @return html      Markup.
 */


add_filter( 'astra_site_title_tag' , 'rioexp_site_title_tag', 10, 3 );
function rioexp_site_title_tag( $tag ) {   
    $tag = 'span';
    return $tag;
}






/**
 * Function to remove HTML comments link
 *
 * @param  string $incoming_comment filter.
 * @return html      Markup.
 */

function rioexp_comment_post( $incoming_comment ) {
    $incoming_comment['comment_content'] = htmlspecialchars($incoming_comment['comment_content']);
    $incoming_comment['comment_content'] = str_replace( "'", '&apos;', $incoming_comment['comment_content'] );
    return( $incoming_comment );
}

function rioexp_comment_display( $comment_to_display ) {
    $comment_to_display = str_replace( '&apos;', "'", $comment_to_display );
    return $comment_to_display;
}
add_filter( 'preprocess_comment', 'rioexp_comment_post', '', 1);
add_filter( 'comment_text', 'rioexp_comment_display', '', 1);
add_filter( 'comment_text_rss', 'rioexp_comment_display', '', 1);
add_filter( 'comment_excerpt', 'rioexp_comment_display', '', 1);
remove_filter( 'comment_text', 'make_clickable', 9 );





/**
 * Function to Remove the Default Author String from Astra Theme
 *
 * @param  string string-blog-meta-author-by filter.
 * @since 1.0.0
 * @return html
 */

function rioexp_remove_author_string( $strings ) {
	$strings['string-blog-meta-author-by']		= __( ' ', 'astra' );
	return $strings;
}
add_filter( 'astra_default_strings', 'rioexp_remove_author_string', 10 );





/**
 * Function to Change Astra Single Post Thumbnail Default Size
 *
 * @param  string astra_post_thumbnail_default_size filter.
 * @since 1.0.0
 * @return html
 */
	 
function rioexp_update_featured_images_size( $size ) {
    $size = ( 'full' ); // Update the 500(Width), 500(Height) as per your requirment.
	return $size;
}
add_filter( 'astra_post_thumbnail_default_size', 'rioexp_update_featured_images_size' );






/**
 * Function to change H2 to H4 tag on Sidebar Widgets
 *
 * @param  string widget_title_tag filter.
 * @return html      Markup.
 */

function rioexp_widget_title_tag( $atts ) {
    $atts['before_title'] = '<div class="widget-inner-title"><h4 class="border-blog has-text-align-center">';
    $atts['after_title'] = '</h4></div>';
    return $atts;
}
add_filter( 'astra_widgets_init', 'rioexp_widget_title_tag', 10, 1 );






/**
 * Function to add Description on Archive Pages
 *
 * @param  string widget_title_tag filter.
 * @return html      Markup.
 */

function rioexp_custom_archive_description( $description ) {
    if ( is_post_type_archive() || is_month() || is_year() || is_day() ) {
     $description = apply_filters( 'the_archive_description', esc_html_e( '<p>Check the list of all published articles</p>', 'astra' ) );
    }
    return $description;
}
add_filter( 'get_the_archive_description', 'rioexp_custom_archive_description' );






/**
 * Function to change the Default Astra Blog Post Meta
 *
 * @param  string astra_blog_post_meta' filter.
 * @since 1.0.0
 * @return html
 */

function rioexp_custom_blog_meta($old_meta) {
    $post_meta = astra_get_option('blog-meta');
	 
	if (!$post_meta) return $old_meta;
    $new_output = astra_get_post_meta($post_meta, $separator = '<span class="author-string has-bold"> ' . esc_html__( 'By', 'astra' ) . ' </span>');
	 
	if (!$new_output) return $old_meta;
    return "<div class='entry-meta'><span class='border-blog'>$new_output</span></div>";
}
add_filter('astra_blog_post_meta', 'rioexp_custom_blog_meta');






/**
 * Function to change the Default Astra Single Post Meta
 *
 * @param  string astra_blog_post_meta' filter.
 * @since 1.0.0
 * @return html
 */

function rioexp_custom_post_meta($old_meta) {
    $post_meta = astra_get_option('blog-single-meta');
     
    if (!$post_meta) return $old_meta;
    $new_output = astra_get_post_meta($post_meta, $separator = '<span class="author-string has-bold"> ' . esc_html__( 'By', 'astra' ) . ' </span>');
     
    if (!$new_output) return $old_meta;
    return "<div class='entry-meta has-text-align-center'><span class='border-blog'>$new_output</span></div>";
}
add_filter('astra_single_post_meta', 'rioexp_custom_post_meta');






/**
 * Function to Display only last modified date in the post metadata.
 *
 * @param String $output Markup for the last modified date.
 * @return void
 */

add_filter( 'astra_post_date', 'rioexp_post_date' );
function rioexp_post_date( $output ) {
	$output        = '';
	$format        = apply_filters( 'astra_post_date_format', '' );
	$modified_date = esc_html( get_the_modified_date( $format ) );
	$modified_on   = sprintf(
		esc_html( '%s' ),
		$modified_date
	);
	$output       .= '<span class="posted-on">';
	$output       .= '<span class="post-updated" itemprop="dateModified"> ' . $modified_on . '</span>';
	$output       .= '</span>';
	return $output;
}






/**
 * Hook to add the Breadcrumbs on Single Posts
 *
 * @param  string astra_single_header_top filter.
 * @return html      Markup.
 */

function rioexp_add_breadcrumb() { 
	if ( is_single() ) {
        esc_html(astra_get_breadcrumb( $echo = true )); 
    }
}
add_action( 'astra_single_header_top', 'rioexp_add_breadcrumb' );





/**
 * Hook to add the Category on Blog Page Header
 *
 * @param  string astra_single_header_top filter.
 * @return html      Markup.
 */

function rioexp_add_category_blog_header() { 
	if ( is_home() || is_search() ) {
	    the_category();
    }
}
add_action( 'astra_archive_post_title_before', 'rioexp_add_category_blog_header' );






/*
*  Function to create CPT for Experiences Pages
*/
 
function rioexp_custom_post_type() {
 
    // Set UI labels for Custom Post Type
        $labels = array(
            'name'                => _x( 'Experiences', 'Post Type General Name', 'astra' ),
            'singular_name'       => _x( 'Experience', 'Post Type Singular Name', 'astra' ),
            'menu_name'           => __( 'Experiences', 'astra' ),
            'parent_item_colon'   => __( 'Parent Experiences', 'astra' ),
            'all_items'           => __( 'All Experiences', 'astra' ),
            'view_item'           => __( 'View Experience', 'astra' ),
            'add_new_item'        => __( 'Add New Experience', 'astra' ),
            'add_new'             => __( 'Add New', 'astra' ),
            'edit_item'           => __( 'Edit Experience', 'astra' ),
            'update_item'         => __( 'Update Experience', 'astra' ),
            'search_items'        => __( 'Search Experience', 'astra' ),
            'not_found'           => __( 'Not Found', 'astra' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'astra' ),
        );
         
    // Set other options for Custom Post Type
         
        $args = array(
            'label'               => __( 'experiences', 'astra' ),
            'description'         => __( 'Experiences and tours', 'astra' ),
            'labels'              => $labels,
            // Features this CPT supports in Post Editor
            'supports'            => array( 'title', 'author', 'excerpt' , 'thumbnail' , 'revisions', 'custom-fields', ),
            // You can associate this CPT with a taxonomy or custom taxonomy. 
            'taxonomies'          => array( 'genre' ),
            /* A hierarchical CPT is like Pages and can have
            * Parent and child items. A non-hierarchical CPT
            * is like Posts.
            */ 
            'hierarchical'        => true,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'can_export'          => true,
            'has_archive'         => false,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
            'menu_icon'           => 'dashicons-admin-site',
        );
         
        // Registering your Custom Post Type
        register_post_type( 'experiences', $args );
     
    }
     
    /* Hook into the 'init' action so that the function
    * Containing our post type registration is not 
    * unnecessarily executed. 
    */
     
add_action( 'init', 'rioexp_custom_post_type', 0 );






/**
 * Function to add link to Last Column on Home Blog Post Grid
 * 
 * @param  string mytheme_setup_theme_supported_features filter.
 * @return html      Markup.
 */ 

function rioexp_home_more_posts() {

	if (get_locale() == 'pt_BR') {			
	    echo '<a class="wp-block-button__link" href="http://192.168.64.3/wordpress/blog/"></a>';   
    
    } elseif (get_locale() == 'es_ES') {
	    echo '<a class="wp-block-button__link" href="http://192.168.64.3/wordpress/es/blog/"></a>';
    
    } elseif (get_locale() == 'en_US') {
	    echo '<a class="wp-block-button__link" href="http://192.168.64.3/wordpress/en/blog/"></a>';   
    }
}






/**
 * Selector Languange
 *
 * @param array  $atts    Shortcode attributes. Not used.
 * @param string $content The shortcode content. Should be an email address.
 * @return string The obfuscated email address. 
 */

function rioexp_select_markup() { 

    if ( ! is_page( array ( 5499, 640, 535, 3105, 16800 ) ) && ! is_single() && ! is_archive() &&  ! is_search() ) {
        echo '<select class="select-language" onchange="if (this.value) window.location.href=this.value">';
            if (get_locale() == 'pt_BR') { 
            ?>
                <option value="<?php esc_url(rioexp_change_language_br()); ?>">Português</option>
                <option value="<?php esc_url(rioexp_change_language_es()); ?>">Español</option>
                <option value="<?php esc_url(rioexp_change_language_en()); ?>">English</option>
            <?php 
            } elseif (get_locale() == 'es_ES') {  
            ?>
                <option value="<?php esc_url(rioexp_change_language_es()); ?>">Español</option>
                <option value="<?php esc_url(rioexp_change_language_br()); ?>">Português</option>
                <option value="<?php esc_url(rioexp_change_language_en()); ?>">English</option>
            <?php
            } elseif (get_locale() == 'en_US') { 
            ?>
                <option value="<?php esc_url(rioexp_change_language_en()); ?>">English</option>
                <option value="<?php esc_url(rioexp_change_language_br()); ?>">Português</option>
                <option value="<?php esc_url(rioexp_change_language_es()); ?>">Español</option>
            <?php
            } 
        echo '</select>';
    } 
    
}





/**
 * Function to add correct links to Custom Footer links
 *
 * @since 1.0.0
 * @return html
 */

function rioexp_footer_faq_link() {   

	if (get_locale() == 'pt_BR') {		
	?>
        <a href="http://192.168.64.3/wordpress/teste-faq/">Principais dúvidas</a>
        <a href="http://192.168.64.3/wordpress/teste-faq/#payment-exp">Pagamentos</a>
        <a href="http://192.168.64.3/wordpress/teste-faq/#cancel-exp">Cancelamentos</a>
    <?php
    } elseif (get_locale() == 'es_ES') {
    ?>
        <a href="http://192.168.64.3/wordpress/teste-faq/">Preguntas principales</a>
        <a href="http://192.168.64.3/wordpress/teste-faq/#payment-exp">Pagos</a>
        <a href="http://192.168.64.3/wordpress/teste-faq/#cancel-exp">Cancelaciones</a>
    <?php
    } elseif (get_locale() == 'en_US') {
	?>
        <a href="http://192.168.64.3/wordpress/teste-faq/">Main questions</a>
        <a href="http://192.168.64.3/wordpress/teste-faq/#payment-exp">Payments</a>
        <a href="http://192.168.64.3/wordpress/teste-faq/#cancel-exp">Cancellations</a>
    <?php    
    }
}


function rioexp_footer_exps_link() {

    if (get_locale() == 'pt_BR') {	
    ?>
        <a href="http://192.168.64.3/wordpress/experiences/praias-selvagens-e-piscina-natural-de-4x4/">Praias Secretas</a>
        <a href="http://192.168.64.3/wordpress/experiences/trilha-na-pedra-do-telegrafo-e-piscina-natural/">Trekking</a>
        <a href="http://192.168.64.3/wordpress/experiences/aulas-de-surf-no-paraiso-dos-surfistas/">Aulas de Surf</a>
        <a href="http://192.168.64.3/wordpress/experiences/trilha-na-pedra-do-telegrafo-e-piscina-natural/">Stand-up</a>
    <?php
    } elseif (get_locale() == 'es_ES') {
	?>
        <a href="http://192.168.64.3/wordpress/experiences/praias-selvagens-e-piscina-natural-de-4x4/">Playas Secretas</a>
        <a href="http://192.168.64.3/wordpress/experiences/trilha-na-pedra-do-telegrafo-e-piscina-natural/">Senderos</a>
        <a href="http://192.168.64.3/wordpress/experiences/aulas-de-surf-no-paraiso-dos-surfistas/">Classes de Surf</a>
        <a href="http://192.168.64.3/wordpress/experiences/trilha-na-pedra-do-telegrafo-e-piscina-natural/">Stand-up</a>
    <?php
    } elseif (get_locale() == 'en_US') {
	?>
        <a href="http://192.168.64.3/wordpress/experiences/praias-selvagens-e-piscina-natural-de-4x4/">Secret Beaches</a>
        <a href="http://192.168.64.3/wordpress/experiences/trilha-na-pedra-do-telegrafo-e-piscina-natural/">Trekking</a>
        <a href="http://192.168.64.3/wordpress/experiences/aulas-de-surf-no-paraiso-dos-surfistas/">Surf Lessons</a>
        <a href="http://192.168.64.3/wordpress/experiences/trilha-na-pedra-do-telegrafo-e-piscina-natural/">Stand-up</a>
    <?php
    }  
}





/**
 * Function to add correct links to selector language
 *
 * @since 1.0.0
 * @return html
 */



function rioexp_change_language_es() {
    if ( is_page( array ( 4484, 525 ) ) ) {
        echo 'http://192.168.64.3/wordpress/es';
    } elseif ( is_page( array ( 3707, 527 ) ) ) {
        echo 'http://192.168.64.3/wordpress/es/pagina-de-contacto';
    } elseif ( is_page( array ( 3815, 529 ) ) ) {
        echo 'http://192.168.64.3/wordpress/es/pagina-de-sobre-mi';
    } elseif ( is_page( array ( 4020, 531 ) ) ) {
        echo 'http://192.168.64.3/wordpress/es/pagina-de-experiencias';
    } elseif ( get_locale() == 'pt_BR' && is_home() || get_locale() == 'en_US' && is_home() ) {
        echo 'http://192.168.64.3/wordpress/es/pagina-de-blog';
    } elseif ( is_page( array ( 5499, 535 ) ) ) {
        echo 'http://192.168.64.3/wordpress/es/pagina-de-anuncio';
    }
}


function rioexp_change_language_en() {
    if ( is_page( array ( 4484, 621 ) ) ) {
        echo 'http://192.168.64.3/wordpress/en';
    } elseif ( is_page( array ( 3707, 630 ) ) ) {
        echo 'http://192.168.64.3/wordpress/en/page-contact';
    } elseif ( is_page( array ( 3815, 637 ) ) ) {
        echo 'http://192.168.64.3/wordpress/en/page-about-me';
    } elseif ( is_page( array ( 4020, 633 ) ) ) {
        echo 'http://192.168.64.3/wordpress/en/page-experiences';
    } elseif ( get_locale() == 'es_ES' && is_home() || get_locale() == 'pt_BR' && is_home() ) {
        echo 'http://192.168.64.3/wordpress/en/page-blog';
    } elseif ( is_page( array ( 5499, 640 ) ) ) {
        echo 'http://192.168.64.3/wordpress/en/page-add';
    }
}

function rioexp_change_language_br() {
    if ( is_page( array ( 621, 525 ) ) ) {
        echo 'http://192.168.64.3/wordpress';
    } elseif ( is_page( array ( 630, 527 ) ) ) {
        echo 'http://192.168.64.3/wordpress/contato';
    } elseif ( is_page( array ( 637, 529 ) ) ) {
        echo 'http://192.168.64.3/wordpress/sobre-mim';
    } elseif ( is_page( array ( 633, 531 ) ) ) {
        echo 'http://192.168.64.3/wordpress/experiencias';
    } elseif ( get_locale() == 'en_US' && is_home() || get_locale() == 'es_ES' && is_home() ) {
        echo 'http://192.168.64.3/wordpress/blog';
    } elseif ( is_page( array ( 640, 535 ) ) ) {
        echo 'http://192.168.64.3/wordpress/anuncio';
    }
}







/* Hook to include selector language on masthead
* @param  string astra_masthead_bottom hook. 
* @return html      Markup.
*/

function rioexp_add_translate_before_header() { 
    if ( ! is_page( array ( 5499, 640, 535, 3105, 16800 ) ) && ! is_single() && ! is_archive() &&  ! is_search() ) {
    ?>
        <div id="selector_language">
            <ul>
                <li>
                    <a href="<?php esc_url(rioexp_change_language_es()); ?>"><img src="http://192.168.64.3/wordpress/wp-content/uploads/2019/05/Flag-of-Spain-256.png" alt="" class="flag1"/></a>
                </li>
      
                <li>
                    <a href="<?php esc_url(rioexp_change_language_en()); ?>"><img src="http://192.168.64.3/wordpress/wp-content/uploads/2019/05/Akrotiri.png" alt="" class="flag2"/></a>
                </li>

                <li>
                    <a href="<?php esc_url(rioexp_change_language_br()); ?>"><img src="http://192.168.64.3/wordpress/wp-content/uploads/2019/05/brazil_flags_flag_16979.png" alt="" class="flag3"/></a>
	            </li>
	        </ul>
        </div>
  <?php 
 }
}
add_action( 'astra_masthead_bottom', 'rioexp_add_translate_before_header' );








/**
 * Hook to fix Astra theme Padding for Gutenberg
 *
 * @since 1.0.0
 * @return html
 */

function rioexp_disable_astra_padding() {
    echo '<style>
    .edit-post-visual-editor .editor-block-list__block .editor-block-list__block-edit {
        padding-left: 0;
        padding-right: 0;
	}
    </style>';
}
add_action('admin_head', 'rioexp_disable_astra_padding');







/**
 * Function to show Social Shares Buttons on Posts
 *
 * @param  string $crunchify filter.
 * @return html      Markup.
 */

function rioexp_social_sharing_buttons($content) {
	global $post;
	if( is_single() ) {
	
		// Get current page URL 
		$url = urlencode(get_permalink());
 
		// Get current page title
		$title = htmlspecialchars(urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
		// $crunchifyTitle = str_replace( ' ', '%20', get_the_title());
		
		// Get Post Thumbnail for pinterest
		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
 
		// Construct sharing URL without using any script
		$twitterURL = 'https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$url.'&amp;';
		$facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$url;
		$linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$url.'&amp;title='.$title;
 
		// Based on popular demand added Pinterest too
		$pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$url.'&amp;media='.$thumbnail[0].'&amp;description='.$title;
 
		// Add sharing button at the end of page/page content
		$content .= '<!-- astra_entry_content_after -->';
		$content .= '<div class="social-share-buttons has-bold">';
		$content .= '<h5>Compartilhar</h5> <a class="social-share-link button-twitter" href="'. esc_url( $twitterURL ) .'" target="_blank" rel="noreferrer noopener">Twitter</a>';
		$content .= '<a class="social-share-link button-facebook" href="'. esc_url( $facebookURL ) .'" target="_blank" rel="noreferrer noopener">Facebook</a>';
		$content .= '<a class="social-share-link button-linkedin" href="'. esc_url( $linkedInURL ) .'" target="_blank" rel="noreferrer noopener">LinkedIn</a>';
		$content .= '<a class="social-share-link button-pinterest" href="'. esc_url( $pinterestURL ) . '" data-pin-custom="true" target="_blank" rel="noreferrer noopener">Pin It</a>';
		$content .= '</div>';
		
		return $content;
	}else{
		// if not a post/page then don't include sharing button
		return $content;
	}
};
add_filter( 'the_content', 'rioexp_social_sharing_buttons');






/**
 * Hook to add the Author Section and Sticky Social Buttons on Single Posts
 *
 * @param  string astra_entry_content_after filter.
 * @return html      Markup.
 */

add_action( 'astra_entry_content_after', 'rioexp_add_author_and_social_buttons_on_posts' );
function rioexp_add_author_and_social_buttons_on_posts() { 
	if( is_single() ) {
	?>
        <div class="button-social-blog">
            <div class="social-blog-buttons">
                <span class="dashicons-all-gb dashicons-facebook-alt"></span>
                <span class="dashicons-all-gb dashicons-instagram"></span>
                <span class="dashicons-all-gb dashicons-googleplus"></span>
            </div>
        </div>

        <section class="post-author">
            <div class="wp-block-columns has-medium-container has-medium-mt">
                
                <div class="wp-block-column">
                    <figure class="wp-block-image is-style-circle-mask aligncenter">
                        <?php echo get_avatar( get_the_author_meta( 'ID' ) , 80 ); ?>
                    </figure>
                </div>

                <div class="wp-block-column">
                    <span class="author-name has-medium-font-size aligncenter"><?php the_author(); ?></span> 
                    <p><?php the_author_meta('description'); ?></p>
                </div>
	        </div>
        </section>
    <?php 
 }
}





/**
 * Hook to add the Main cover on Blog Page
 *
 * @param  string astra_header_after filter.
 * @return html      Markup.
 */

add_action( 'astra_header_after', 'rioexp_add_cover_blog' );
function rioexp_add_cover_blog() { 
	if ( is_home() ) {
	?>
        <section class="wp-block-cover blog-main-cover has-align-items-flex-end">
	        <div class="wp-block-cover__inner-container">
                <h1 class="has-text-align-right has-small-mb"><?php esc_html_e( 'Stories about Rio de Janeiro', 'astra' );?></h1>
		    </div>
	    </section>
    <?php 
 }
}







/**
 *  Read More Button
 *
 * @param  string astra_entry_content_after filter.
 * @since 1.0.0
 * @return html
 */

function rioexp_read_more() { 
    ?>
        <div class="read-more is-style-squared">
		    <a class="wp-block-button__link has-white-background-color" href="<?php the_permalink(); ?>">
		        <span class="screen-reader-text"><?php the_title(); ?></span><?php esc_html_e( 'Read more', 'astra' ); ?>
		    </a>
        </div>	
    <?php 
}

/** Hook for Read more **/ 

function rioexp_add_button_after_excerpt() { 
	if ( is_search() || is_home() || is_archive() ) { 
        echo esc_html(rioexp_read_more());
    }
}
add_action( 'astra_entry_content_after', 'rioexp_add_button_after_excerpt' );








/**
 * Hook to Add Custom Search Form to Search Results
 *
 * @param  string astra_primary_content_top' filter.
 * @since 1.0.0
 * @return html
 */

function rioexp_add_search_form_to_header() {
        $custom_search = '<div class="custom-search-form has-text-align-center">
            <form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/' ) ) . '">
                <div class="search-label has-medium-container">
			        <label>
				        <span class="screen-reader-text">' . _x( 'Search for:', 'label', 'astra' ) . '</span>
				        <input type="search" class="search-field" ' . apply_filters( 'astra_search_field_toggle_data_attrs', '' ) . ' placeholder="' . esc_attr_x( 'Search &hellip;', 'placeholder', 'astra' ) . '" value="' . get_search_query() . '" name="s" role="search" tabindex="-1"/>
			        </label>
                    <button type="submit" class="search-submit" value="' . esc_attr__( 'Search', 'astra' ) . '"><i class="astra-search-icon"></i></button>
                </div>
                <div class="search-checkbox has-small-mt">
				    <label>' . esc_html__( 'Experiences', 'astra' ). '</label>
	                <input type="checkbox" value="experiences" name="post_type" id="post_type" />
	                <label>' . esc_html__( 'Blog Articles', 'astra' ). '</label>
                    <input type="checkbox" value="post" name="post_type" id="post_type" />
                </div>
            </form>
        </div>';

		if (is_search() && have_posts() ) { 
              echo $custom_search;
        }
}
add_action('astra_primary_content_top', 'rioexp_add_search_form_to_header' );






/**
 * Hook to add Custom Fields in Search Resultds
 *
 * @param  string astra_single_header_top filter.
 * @return html      Markup.
 */

function rioexp_add_custom_field_search() { 
    if ( is_search() ) {
        global $wp_query;
        $postid = $wp_query->post->ID;
        $value_tour_category = get_post_meta($postid, 'tour_category', true);
        $value_dashicon_time = get_post_meta($postid, 'dashicon_time', true);
        $value_tour_price = get_post_meta($postid, 'tour_price', true);
        $value_dashicon_location = get_post_meta($postid, 'dashicon_location', true);

        if ( $value_tour_category )
            echo '<div class="tag-flag"><span>' . esc_html($value_tour_category) . '</span></div>';
        if ( $value_dashicon_time )
            echo '<span>' . esc_html($value_dashicon_time) . '</span>';
        if ( $value_tour_price )
            echo '<span>' . esc_html($value_tour_price) . '</span>';
        if ( $value_dashicon_location )
            echo '<span>' . esc_html($value_dashicon_location) . '</span>';
        wp_reset_query();
    }
}
add_action( 'astra_entry_content_before', 'rioexp_add_custom_field_search' );







/**
 * Hook to add Script in FAQ Page on Footer
 *
 * @param  string astra_single_header_top filter.
 * @return html      Markup.
 */

function rioexp_add_script_to_faq() { 
    if ( is_page( array ( 16649, 722, 626 ) ) ) {
	?>
        <script>
            var acc = document.getElementsByClassName("accordion");
            var i;

            for (i = 0; i < acc.length; i++) {
                acc[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
            if (panel.style.maxHeight){
                panel.style.maxHeight = null;
            } else {
                panel.style.maxHeight = panel.scrollHeight + "px";
            } 
            });
            }
        </script>
    <?php 
    }
}
add_action( 'astra_body_bottom', 'rioexp_add_script_to_faq' );






/**
 * Hook to add Airbnb Script to Experiences Page
 *
 * @param  string astra_single_header_top filter.
 * @return html      Markup.
 */

function rioexp_add_airbnb_script() { 
    if ( is_singular('experiences') && get_locale() == 'pt_BR')  {
	     
        echo '<script async src="https://www.airbnb.com.br/embeddable/airbnb_jssdk"></script>';

    } elseif ( is_singular('experiences') && get_locale() == 'es_ES')  {
 
        echo '<script async src="https://es.airbnb.com/embeddable/airbnb_jssdk"></script>';

    } elseif ( is_singular('experiences') && get_locale() == 'en_US')  {
    
        echo '<script async src="https://www.airbnb.com/embeddable/airbnb_jssdk"></script>';

    }
}
add_action( 'wp_footer', 'rioexp_add_airbnb_script' );