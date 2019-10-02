<?php

/**
 * Function Most Recent Posts for Footer Layout
 *
 * @since 1.0.0
 * @return html
 */


function rioexp_footer_recents_posts() {
	$args = array (
	 'post_type'              => 'post',
	 'posts_per_page'         => '3',
	 'order'                  => 'DESC',
	 'orderby'                => 'post_date',
	 'post__not_in'           => array(get_the_ID()),
	 'category'               => '0'
    );
 
    $query = new WP_Query( $args );
    while ($query->have_posts()) : $query->the_post(); ?>  
  
     <li>
         <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
     </li>
     
	<?php endwhile;wp_reset_query();
}





/**
 *  Post Grid for Home Page
 * 
 * @param  string mytheme_setup_theme_supported_features filter.
 * @return html      Markup.
 */

function rioexp_home_posts_markup() { 
    ?>    
        <div class="wp-block-columns has-cb-flex-grow has-position-relative has-medium-mb has-flex-wrap">
   
            <?php $query = $args = array (
	        'post_type'              => 'post',
	        'posts_per_page'         => '4',
	        'order'                  => 'DESC',
	        'orderby'                => 'post_date',
	        'post__not_in'           => array(get_the_ID()),
            );
 
            $query = new WP_Query( $args );
            while($query->have_posts()) : $query->the_post(); ?>
        
            <div class="wp-block-column">
        
                <article itemtype="https://schema.org/CreativeWork" itemscope="itemscope" id="post-<?php the_ID(); ?>" class="wp-block-cover has-background-dim-40 has-background-dim" style="background-image:url(<?php echo esc_url(get_the_post_thumbnail_url($post_id, 'large' , 'thumbnail')); ?>)">
                    <div class="wp-block-cover__inner-container">
                        <p class="has-medium-font-size has-font-family-h1" itemprop="headline"><?php the_title(); ?></p>
                        <p><?php $excerpt = get_the_excerpt(); echo substr( esc_html($excerpt), 0, 80 ) . '&hellip;';?></p>
                        <p class="has-bold has-text-align-right"><?php esc_html_e( 'Read more', 'astra' ); ?></p>
                    </div>

                    <div class="wp-block-button tag-flag">
                        <a class="wp-block-button__link" itemprop="dateModified"><?php the_time('F j, Y'); ?></a>
                    </div> 
                </article>

                <div class="wp-block-button column-link-overlay">
                    <a class="wp-block-button__link" href="<?php the_permalink();?>"></a>
                </div>
            </div>

            <?php endwhile; ?>
		    <?php wp_reset_postdata(); // reset the query ?>

            <div class="wp-block-column has-flex-center has-black-background-color has-white-color">
                <p class="has-text-align-center has-medium-font-size has-font-family-h1"><?php esc_html_e( 'More Articles', 'astra' ); ?></p>
        
                <div class="wp-block-button column-link-overlay">
	                <?php esc_html(rioexp_home_more_posts()); ?>
		        </div>
            </div>
        </div>
    <?php
}




/**
 * Recent Posts for Thank You Page
 *
 * @param  string astra_entry_bottom filter.
 * @return html      Markup.
 */

function rioexp_recent_posts_markup() { 
    ?>
        <div class="wp-block-columns has-medium-mt">

            <?php $query = $args = array (
            'post_type'              => 'post',
            'posts_per_page'         => '3',
            'order'                  => 'DESC',
            'orderby'                => 'modified',
            );
  
            $query = new WP_Query( $args );
            while($query->have_posts()) : $query->the_post(); ?> 
    
            <div class="wp-block-column">
                <article itemtype="https://schema.org/CreativeWork" itemscope="itemscope" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
               
                    <figure><img src="<?php echo esc_url(get_the_post_thumbnail_url($post_id, 'large' , 'thumbnail')); ?>" itemprop="image"></figure>
            
                    <?php astra_the_title( sprintf( '<h3 class="entry-title" itemprop="headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
       
                    <span class="related-articles-data-post" itemprop="dateModified"><?php the_time('F j, Y'); ?></span>
                    <p class="has-small-mt"><?php $excerpt = get_the_excerpt(); echo substr( esc_html($excerpt), 0, 100 ) . '&hellip;';?></p>                
                    
                    <?php esc_html(rioexp_read_more()); ?>                
                </article>
            </div>

            <?php endwhile; ?>
            <?php wp_reset_postdata(); // reset the query ?>
     </div>
 <?php
}





/**
 * Related Posts for Single Posts
 *
 * @param  string astra_entry_bottom filter.
 * @return html      Markup.
 */

add_filter( 'astra_entry_bottom', 'rioexp_add_related_posts' );
function rioexp_add_related_posts() {
    if ( is_single()) { 
    ?>
	    <footer class="entry-footer">
	        <div class="related-articles has-medium-my has-auto-mx has-main-padding">
	            <h3 class="has-text-align-center has-small-mb"><?php esc_html_e( 'Related Posts', 'astra' ); ?></h3>
	            <hr class="wp-block-separator divider" />
	            <div class="wp-block-columns has-justify-content-center">
            
                    <?php $query = $args = array (
	                'post_type'              => 'post',
	                'posts_per_page'         => '3',
	                'order'                  => 'DESC',
	                'orderby'                => 'post_date',
	                'post__not_in'           => array(get_the_ID()),
	                'category'               => 'neque'
                    );
 
                    $query = new WP_Query( $args );
		            while($query->have_posts()) : $query->the_post(); ?> 
        
                    <div class="wp-block-column">
		                <article itemtype="https://schema.org/CreativeWork" itemscope="itemscope" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				
			                <figure><img src="<?php echo esc_url(get_the_post_thumbnail_url($post_id, 'large' , 'thumbnail')); ?>" itemprop="image"></figure>
			                <div>
			                    <?php astra_the_title( sprintf( '<h3 class="entry-title" itemprop="headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
				                <span class="related-articles-data-post" itemprop="dateModified"><?php the_time('F j, Y'); ?></span>
                            </div>
                        </article>
                    </div>
        
		            <?php endwhile; ?>
		            <?php wp_reset_postdata(); // reset the query ?>
                </div>
            </div>
        </footer><!-- .entry-footer -->
 <?php
 }
}