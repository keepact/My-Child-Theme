<?php

/**
 * SCHEMA MARKUP - REMOVE FUNCTIONS
 *
 * @since 1.0.0
 * @return html
 */


/**
 * Function to add Schema Markup by JSON
 *
 * @since 1.0.0
 * @return html
 */

add_action( 'astra_masthead_content', 'astra_site_branding_markup', 8 );
function astra_site_branding_markup() {
  ?>

		<div class="site-branding">
		 <div class="ast-site-identity">
          <script type="application/ld+json"> {
             "@context": "http://schema.org",
             "@type": "Organization",
             "address": {
             "@type": "PostalAddress",
             "addressRegion": "Rio de Janeiro",
             "streetAddress": "Nossa Senhora de Copacabana Avenue"
             },
              "description": "Rio Experiences is a pioneer in promoting tourism experiences in Brazil.",
              "name": "Rio Experiences",
              "url": "http://192.164.64.3/wordpress",
			  "telephone": "+55 21 99439 7191" }
		  </script>
			        <?php astra_logo(); ?>	
			</div>
		</div>
		<!-- .site-branding -->
	<?php
}


/**
 * Function to remove Astra Schema Markup from Header
 *
 * @since 1.0.0
 * @return html
 */

function astra_header_markup() {

    do_action( 'astra_header_markup_before' );
    ?>

    <header id="masthead" <?php astra_header_classes(); ?> role="banner">

        <?php astra_masthead_top(); ?>

        <?php astra_masthead(); ?>

        <?php astra_masthead_bottom(); ?>

    </header><!-- #masthead -->

    <?php
    do_action( 'astra_header_markup_after' );

}
add_action( 'astra_header', 'astra_header_markup' );


/**
* Function to remove Astra Schema Markup from Footer
*
* @since 1.0.0
* @return html
*/

function astra_footer_markup() {
    ?>

    <footer id="colophon" <?php astra_footer_classes(); ?> role="contentinfo">

        <?php astra_footer_content_top(); ?>

        <?php astra_footer_content(); ?>

        <?php astra_footer_content_bottom(); ?>

    </footer><!-- #colophon -->
    <?php
}

add_action( 'astra_footer', 'astra_footer_markup' );


/**
* Function to remove Astra Schema Markup from Navigation menu
*
* @since 1.0.0
* @return html
*/

add_filter(
'wp_nav_menu_args',
function( $args ) {
    if ( 'primary' == $args['theme_location'] ) {
        $args[ 'items_wrap' ] = '<nav id="site-navigation" class="ast-flex-grow-1 navigation-accessibility" role="navigation" aria-label="' . esc_attr( 'Site Navigation', 'astra' ) . '">';
        $args[ 'items_wrap' ] .= '<div class="main-navigation">';
        $args[ 'items_wrap' ] .= '<ul id="%1$s" class="%2$s">%3$s</ul>';
        $args[ 'items_wrap' ] .= '</div>';
        $args[ 'items_wrap' ] .= '</nav>';
    }

    return $args;
}
);

/**
* Function to remove Astra Schema Markup from Body
*
* @since 1.0.0
* @return html
*/

add_filter( 'astra_schema_body', '__return_empty_string' );



/**
* Function to Remove hentry class name from post_class.
*
* @since 1.0.0
* @return html
*/

function _s_remove_hentry( $classes ) {
if ( 'post' != get_post_type()) {
    $classes = array_diff( $classes, array( 'hentry' ) );
}
return $classes;
}
add_filter( 'post_class','_s_remove_hentry' );



/**
* Function to Remove class hfeed from div#page
*
* @since 1.0.0
* @return html
*/

add_filter(
'astra_attr_site',
function( $attr ) {
    if (!is_home() && !is_archive() ) { 
    $attr['class'] = str_replace( 'hfeed ', '', $attr['class'] );
    }
    return $attr;
}
);


/**
* Function to Remove Schema Markup from article#page
*
* @since 1.0.0
* @return html
*/

add_filter(
'astra_attr_article-page',
function( $attr ) {
    $attr['itemtype'] = '' ;
    $attr['itemscope'] = '' ;

    return $attr;
}
);
