<?php

// Function to Create a POPULAR POST WIDGET
 

 /**
 * Adds Popular_Posts widget.
 */
class Popular_Posts extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'popular_posts',
			'description' => 'Show Popular Posts',
		);
		parent::__construct( 'popular_posts', 'Popular Posts', $widget_ops );
	}
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
	
		if( ! empty( $instance['selected_posts'] ) && is_array( $instance['selected_posts'] ) ){ 
	
			$selected_posts = get_posts( array( 'post__in' => $instance['selected_posts'] ) );
			?>
			<div class="widget-posts has-auto-mx">
			<?php foreach ( $selected_posts as $post ) { ?>
				<div class="wp-block-media-text">
					   <figure class="wp-block-media-text__media"><img src="<?php echo esc_url(get_the_post_thumbnail_url($post->ID, 'small' , 'thumbnail')); ?>"></figure>
						      <div class="wp-block-media-text__content">
							  <p class="has-bold"><a href="<?php echo esc_url(get_permalink( $post->ID )); ?>">
				<?php echo esc_html($post->post_title); ?>
				</a></p>
                                  <p><?php echo $post->$post_date = esc_html(get_the_modified_date( 'F j, Y' )); ?></p>
                                  </div></div>		
			<?php } ?>
			</div>
			<?php 
			
		}else{
			echo esc_html__( 'No posts selected!', 'astra' );	
		}
	
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'astra' );
		$posts = get_posts( array( 
				'posts_per_page' => 10,
				'offset' => 0
			) );
		$selected_posts = ! empty( $instance['selected_posts'] ) ? $instance['selected_posts'] : array();
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'astra' ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<div style="max-height: 120px; overflow: auto;">
		<ul>
		<?php foreach ( $posts as $post ) { ?>
	
			<li><input 
				type="checkbox" 
				name="<?php echo esc_attr( $this->get_field_name( 'selected_posts' ) ); ?>[]" 
				value="<?php echo $post->ID; ?>" 
				<?php checked( ( in_array( $post->ID, $selected_posts ) ) ? $post->ID : '', $post->ID ); ?> />
				<?php echo get_the_title( $post->ID ); ?></li>
	
		<?php } ?>
		</ul>
		</div>
		<?php
	}
	

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			
		$selected_posts = ( ! empty ( $new_instance['selected_posts'] ) ) ? (array) $new_instance['selected_posts'] : array();
		$instance['selected_posts'] = array_map( 'sanitize_text_field', $selected_posts );
	
		return $instance;
	 }
	}
	// class Popular_Posts

// register Popular_Posts widget
add_action( 'widgets_init', function(){
	register_widget( 'Popular_Posts' );
});
