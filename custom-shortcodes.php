<?php

/**
 *  SHORTCODES REGISTRATION
 */


 
/**
 *  Show Shortcodes on Widgets
 *
*/ 

add_filter( 'widget_text', 'do_shortcode' );


/**
 *  Post Grid Shortcode
 *
 * Usage: Contact Page
 * 
 * @param  string input filter.
 * @return data.
 */

function rioexp_post_grid() {
    ob_start();

    esc_html(rioexp_home_posts_markup());

    return ob_get_clean();
}
add_shortcode('post_grid', 'rioexp_post_grid');



/**
 *  Form shortcode
 *
 * Usage: Contact Page
 * 
 * @param  string input filter.
 * @return data.
 */

function rioexp_contact_form() {
    ob_start();

    esc_html(rioexp_form_markup());

    return ob_get_clean();
}
add_shortcode('contact_form', 'rioexp_contact_form');



/**
 * Function Selector Language Shortcode 
 *
 * Usage: All Pages
 * 
 * @param  string input filter.
 * @return data.
 */
function rioexp_select_shortcode() {
    ob_start();

    esc_html(rioexp_select_markup());

    return ob_get_clean();
}
add_shortcode('select_lang', 'rioexp_select_shortcode');




/**
 *  Recent Posts Shortcode
 *
 * Usage: Thank You Page
 *
 * @param  string input filter.
 * @return data.
 */

function rioexp_recent_posts_shortcode() {
    ob_start();

    esc_html(rioexp_recent_posts_markup());

    return ob_get_clean();
}
add_shortcode('recent_posts', 'rioexp_recent_posts_shortcode');





/**
 * Hide email from Spam Bots Shortcode
 * 
 * * Usage: Contact Page & Footer Layout
 *
 * @param array  $atts    Shortcode attributes. Not used.
 * @param string $content The shortcode content. Should be an email address.
 * @return string The obfuscated email address. 
 */

function rioexp_hide_email_shortcode( $atts , $content = null ) {
    if ( ! is_email( $content ) ) {
        return;
    }
    return '<a href="mailto:' . esc_url( antispambot($content,1) ) . '" title="' . esc_attr__( 'Click to send a e-mail', 'astra' ).'">' . esc_html( antispambot($content) ) . '</a>';
}
add_shortcode( 'email', 'rioexp_hide_email_shortcode' );




/**
 * Hide (Try) Phone number from Spam Bots Shortcode
 * 
 * * Usage: Contact Page & Footer Layout
 *
 * @param array  $atts = 'link' and 'title' Shortcode attributes.
 * @param string $content The shortcode content. Should be telephone number or text.
 * @return string The obfuscated phone number. 
 */

function rioexp_whatsapp_shortcode($atts = [], $content = null, $tag = '')
{
    // normalize attribute keys, lowercase
    $atts = array_change_key_case((array)$atts, CASE_LOWER);
 
    // override default attributes with user attributes
    $wporg_atts = shortcode_atts([
                                     'link' => 'https://www.WordPress.org',
                                     'title' => 'Phone',
                                 ], $atts, $tag);
 
    // start output
    $o = '';
 
    // start box
    $o .= '<div class="has-small-mt">';

    $o .= '<p class="has-no-mb has-bold">' . esc_html($wporg_atts['title']) . '</p>';
  
    // enclosing tags
    if (!is_null($content)) {
        // secure output by executing the_content filter hook on $content
        $o .= '<span>' . apply_filters('the_content', $content) . '</span>';
    
        $o .= '<a href="' . esc_url( $wporg_atts['link']) . '" class="dashicons-all-gb dashicons-phone has-small-mt icon-whatsapp-contato-gb"></a>';
    }
    
    // end box
    $o .= '</div>';
 
    // return output
    return $o;
}
 
function rioexp_whatsapp_shortcode_init()
{
    add_shortcode('whatsapp', 'rioexp_whatsapp_shortcode');
}
 
add_action('init', 'rioexp_whatsapp_shortcode_init');