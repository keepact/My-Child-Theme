<?php

/**
 *  Custom Footer Navigation
 *
 * @param  string astra_footer_content_top action.
 * @return html      Markup.
 */

add_action( 'astra_footer_content_top', 'rioexp_add_footer_layout' );
function rioexp_add_footer_layout() { 
    ?>
        <nav class="footer-layout has-gb-auto-mx">
            <div class="wp-block-group__inner-container">
                <ul class="wp-block-columns">
       
	                <li class="wp-block-column is-vertically-aligned-center has-text-align-center">
                        <p class="has-font-family-h1 has-no-mb"><?php bloginfo( 'name' ); ?></p>
                        <p><?php esc_html_e( 'All rights reserved ©', 'astra' ); ?></p>
	                </li>
        
                    <li class="wp-block-column">
                        <p class="has-font-family-h1"><?php esc_html_e( 'Contact Us', 'astra' ); ?></p>
                        
                        <p><?php           
                        $email = "rioexperiences@gmail.com";
                        $email = sanitize_email($email);
                        echo '<a href="mailto:'.antispambot($email,1).'" title="'.esc_attr__( 'Click to send a message', 'astra' ).'">'.antispambot($email).'</a>'; ?></p> 
                        
                        <p><?php           
                        $phone_url = "https://wa.me/5521994397191";
                        $phone = "+55-21-99439-7191";
                        $phone = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
                        echo '<a href="'. esc_url($phone_url) .'" title="'.esc_attr__( 'Click to send a message', 'astra' ).'">'.antispambot($phone).'</a>'; ?></p>	     
                    </li>

                    <li class="wp-block-column">
	                    <p class="has-font-family-h1">FAQ</p>
	                    <?php echo esc_html(rioexp_footer_faq_link()); ?>
	                </li>

                    <li class="wp-block-column">
                        <p class="has-font-family-h1"><?php esc_html_e( 'Categories', 'astra' ); ?></p>
	                    <?php echo esc_html(rioexp_footer_exps_link()); ?>
	                </li>

                    <li class="wp-block-column has-no-ml">
                        <p class="has-font-family-h1">Blog</p>
                        <ul class="wp-block-latest-posts wp-block-latest-posts__list">
                            <?php echo esc_html(rioexp_footer_recents_posts()); ?>   
                        </ul>
                    </li>
	            </ul>
            </div>
     </nav><!-- .footer-layout -->
 <?php 
}