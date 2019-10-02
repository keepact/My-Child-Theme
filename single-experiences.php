<?php
/**
 * The template for displaying Experiences Post Types.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Astra
 * @since 1.0.0
 */

get_header(); ?>

<?php if ( astra_page_layout() == 'left-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

	<div id="primary" <?php astra_primary_class(); ?>>

    <?php astra_primary_content_top(); ?>
    <main id="main" class="site-main" role="main">
    <header class="entry-header ast-header-without-markup"></header>
    <div class="entry-content clear">

<section class="sec-1-anuncio">
 <div class="wp-block-columns">
  
  <div class="wp-block-column col-1-anuncio-gb has-full-flex-basis">
   <div class="carousel-wrapper">
     <span id="item-1"></span>
     <span id="item-2"></span>
     <span id="item-3"></span>
    
     <div class="carousel-item item-1" style="background-image:url(<?php $host_photo_1 = get_post_meta($post->ID, 'host_photo_1', true);
     if ($host_photo_1) { ?><? echo esc_url( $host_photo_1 ); ?><?php  } else { }?>);">
     <a class="arrow arrow-prev" href="#item-3"></a>
      <a class="arrow arrow-next" href="#item-2"></a>
     </div>

     <div class="carousel-item item-2" style="background-image:url(<?php $host_photo_2 = get_post_meta($post->ID, 'host_photo_2', true);
     if ($host_photo_2) { ?><? echo esc_url( $host_photo_2) ; ?><?php } else { }?>);">
     <a class="arrow arrow-prev" href="#item-1"></a>
     <a class="arrow arrow-next" href="#item-3"></a>
    </div>

    <div class="carousel-item item-3" style="background-image:url(<?php $host_photo_3 = get_post_meta($post->ID, 'host_photo_3', true);
     if ($host_photo_3) { ?><? echo esc_url( $host_photo_3 ); ?><?php } else { }?>);">
     <a class="arrow arrow-prev" href="#item-2"></a>
     <a class="arrow arrow-next" href="#item-1"></a>
     </div>
   </div>

   <div class="wp-block-columns has-flex-nowrap">
   <div class="wp-block-column has-full-flex-basis">  
   <p class="has-small-mt"><?php $tour_reviews = get_post_meta($post->ID, 'tour_reviews', true);
   if ($tour_reviews) { ?><? echo esc_html( $tour_reviews ); ?><?php } else { }?> 
          <?php esc_html_e( 'reviews', 'astra' ); ?></p>
   </div>

   <div class="wp-block-column">
   <div class="wp-block-image"><figure class="alignright is-resized">
    <a href="<?php $airbnb_link = get_post_meta($post->ID, 'airbnb_link', true);
    if ($airbnb_link) { ?><? echo esc_url( $airbnb_link ); ?><?php } else { } ?>">
    <img src="http://192.168.64.3/wordpress/wp-content/uploads/2019/05/airbnb-2.png" alt="" class="wp-image-3694" width="32" height="32"/></a>
    </figure>
    </div>
    </div>
   </div>
   <div class="wp-block-image is-style-circle-mask">
     <figure class="aligncenter has-small-mt">
     <img src="<?php $host_photo_profile = get_post_meta($post->ID, 'host_photo_profile', true);
     if ($host_photo_profile) { ?><? echo esc_url( $host_photo_profile ); ?><?php } else { } ?>" alt="" width="150" height="150" />
     </figure>
   </div> 
  </div>



  <div class="wp-block-column col-2-anuncio-gb has-full-flex-basis">
   <span><?php $tour_category = get_post_meta($post->ID, 'tour_category', true);
   if ($tour_category) { ?><? echo esc_html( $tour_category ); ?><?php } else { } ?></span>
   <span><?php $tour_price = get_post_meta($post->ID, 'tour_price', true);
   if ($tour_price) { ?><? echo esc_html( $tour_price ); ?><?php } else { } ?></span>

   <h1><?php the_title(); ?></h1>
   
   <p> <?php $dashicon_location = get_post_meta($post->ID, 'dashicon_location', true);
     if ($dashicon_location) { ?><? echo esc_html( $dashicon_location ); ?><?php } else { } ?>
   </p>

   <p> <?php $dashicon_time = get_post_meta($post->ID, 'dashicon_time', true);
     if ($dashicon_time) { ?><? echo esc_html( $dashicon_time ); ?><?php } else { } ?>
    </p>

   <p> <?php $dashicon_language = get_post_meta($post->ID, 'dashicon_language', true);
     if ($dashicon_language) { ?><? echo esc_html( $dashicon_language ); ?><?php } else { } ?> 
    </p>
 
   <h2><?php esc_html_e( 'About your host', 'astra' ); ?></h2>

   <p>
     <?php $host_text = get_post_meta($post->ID, 'host_text', true);
     if ($host_text) { ?><? echo esc_html( $host_text ); ?><?php } else { } ?>
    </p>

   <h3><?php esc_html_e( 'What we’ll do', 'astra' ); ?></h3>
      
     <?php the_excerpt(); ?>

   <div class="wp-block-columns has-medium-mt">
     <div class="wp-block-column">
       <h4><?php esc_html_e( 'What I’ll provide', 'astra' ); ?></h4>

       <ul>
        <li><?php esc_html_e( 'Water', 'astra' ); ?></li>
        
        <li><?php $car_type = get_post_meta($post->ID, 'car_type', true);
        if ($car_type) { ?><? echo esc_html( $car_type ); ?><?php } else { } ?></li>
        
        <li><?php $include_photos_pack = get_post_meta($post->ID, 'include_photos_pack', true);
        if ($include_photos_pack) { ?><? echo esc_html( $include_photos_pack ); ?><?php } else { } ?></li>
       </ul>
   </div>
   
   <div class="wp-block-column">
       <h4><?php esc_html_e( 'What to bring', 'astra' ); ?></h4>
       <ul>
        <li><?php $clothes_bring = get_post_meta($post->ID, 'clothes_bring', true);
        if ($clothes_bring) { ?><? echo esc_html( $clothes_bring ); ?><?php } else { } ?></li>
        
        <li><?php esc_html_e( 'Snacks', 'astra' ); ?></li>
       
        <li><?php $extra_bring = get_post_meta($post->ID, 'extra_bring', true);
        if ($extra_bring) { ?><? echo esc_html( $extra_bring ); ?><?php } else { } ?></li>
       </ul>
      </div>
    </div>
   </div>
 </div>
</section>


<div class="map-container">
  <p class="alignfull">

  <?php
  $allowed_html = [
    'iframe'      => [
        'src'  => [],
        'width' => [],
        'height' => [],
        'style' => [],
        'frameborder' => [],
        'allowfullscreen' => [],
    ],
];
  $map_iframe = get_post_meta($post->ID, 'map_iframe', true);
     if ($map_iframe) { ?><? echo wp_kses( $map_iframe, $allowed_html ); ?><?php } else { } ?>
 </p>
</div>


<section class="sec-2-anuncio">
 <div class="wp-block-columns">
   <div class="wp-block-column">

    <h5 class="has-text-align-center"><?php esc_html_e( 'Where we’ll be', 'astra' ); ?></h5>

    <p class="has-medium-font-size"><?php $host_tour_location = get_post_meta($post->ID, 'host_tour_location', true);
     if ($host_tour_location) { ?><? echo esc_html( $host_tour_location ); ?><?php } else { } ?></p>
   </div>


   <div class="wp-block-column">
    
    <h6><?php esc_html_e( 'Group size', 'astra' ); ?></h6>
    <p><?php $host_tour_seats = get_post_meta($post->ID, 'host_tour_seats', true);
     if ($host_tour_seats) { ?><? echo esc_html( $host_tour_seats ); ?><?php } else { } ?></p>

    <h6><?php esc_html_e( 'Who can come', 'astra' ); ?></h6>
    <p><?php $host_tour_warning = get_post_meta($post->ID, 'host_tour_warning', true);
     if ($host_tour_warning) { ?><? echo esc_html( $host_tour_warning ); ?><?php } else { } ?></p>

    <h6><?php esc_html_e( 'Payment Methods', 'astra' ); ?></h6>

    <ul class="has-small-mt"><li><?php _e( 'Bank transfer', 'astra' ); ?></li>
     <li><?php esc_html_e( 'Bank deposit', 'astra' ); ?></li>
     <li><?php esc_html_e( 'Credit card via Airbnb', 'astra' ); ?></li>
    </ul>
   </div>
 </div>

    <h6><?php esc_html_e( 'Cancellation policy', 'astra' ); ?></h6>
    <p><?php esc_html_e( 'Any experience can be canceled and fully refunded within 24 hours of purchase.', 'astra' ); ?></p>

</section>

<section class="add-airbnb-booking has-large-my">
   <h6 class="has-text-align-center"><?php esc_html_e( 'Check availability', 'astra' ); ?></h6>
   <hr class="wp-block-separator divider" />

  <div class="airbnb-calendar has-auto-mx">
   
  <?php
  $allowed_html = [
    'a'      => [
        'href'  => [],
        'rel' => [],
    ],
    'div'     => [
        'class' => [],
        'data-id' => [],
        'data-eid' => [],
        'data-currency' => [],
        'data-view' => [],
    ],
];
  $airbnb_iframe = get_post_meta($post->ID, 'airbnb_iframe', true);
     if ($airbnb_iframe) { ?><? echo wp_kses( $airbnb_iframe, $allowed_html ); ?><?php } else { } ?>
        
  </div>
</section>

<section class="sec-3-anuncio">
 <div class="wp-block-columns">
   <div class="wp-block-column is-vertically-aligned-center">
   <h6><?php esc_html_e( 'Other Experiences', 'astra' ); ?></h6>
   </div>

   <?php $query = $args = array (
	 'post_type'              => 'experiences',
	 'posts_per_page'         => '3',
	 'order'                  => 'DESC',
	 'orderby'                => 'post_date'
   );
 
   $query = new WP_Query( $args ); // limit number of posts
		while($query->have_posts()) : $query->the_post(); ?>
   
   <div class="wp-block-column">
     <figure class="wp-block-image has-no-mb">
     <img src="<?php echo esc_url(get_the_post_thumbnail_url($post_id, 'full' , 'thumbnail')); ?>" alt="" class="experiences-images" />
   </figure>
   <div>
   <span class="has-bold has-small-font-size"><?php $tour_category = get_post_meta($post->ID, 'tour_category', true);
     if ($tour_category) { echo esc_html( $tour_category ); } else { } ?>
   </span>

   <p class="has-bold"><?php the_title(); ?></p>
   </div></div>
   <?php endwhile; ?>
   <?php wp_reset_postdata(); // reset the query ?>
  </div>
</section>

<div class="wp-block-button is-style-squared botao-anuncio-gb has-text-align-center">
  <a class="wp-block-button__link has-light-orange-background-color">
    <?php esc_html_e( 'Send a message', 'astra' ); ?>&nbsp;
   </a>
</div>
</div><!-- .entry-content .clear -->
    
   <?php astra_primary_content_bottom(); ?>
   </main><!-- #main -->
</div><!-- #primary -->

<?php if ( astra_page_layout() == 'right-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>

<?php get_footer(); ?>
