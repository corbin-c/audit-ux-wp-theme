<?php
/**
 * Creates a new widget which expects the ID of a reusable block
 * and displays it.
 * It's a simple way to reuse some content in the theme template & inside posts
 * 
 * @link https://wordpress.com/support/wordpress-editor/blocks/reusable-block/
 */
class reuse_widget extends WP_Widget {
    
  function __construct() {
    parent::__construct(
      'reuse_widget', 
      __('Reusable block Widget', 'reuse_widget_domain'), 
      array( 'description' => __( 'A widget to include a reusable block', 'reuse_widget_domain' ), ) 
    );
  }
  
  public function widget( $args, $instance ) {
    $id = $instance['r_block_id'];
    echo $args['before_widget'];
    $reuse_block = get_post($id);
    $reuse_block_content = apply_filters( 'the_content', $reuse_block->post_content);
    echo $reuse_block_content;
    echo $args['after_widget'];
  }

  public function form( $instance ) {
    if ( isset( $instance[ 'r_block_id' ] ) ) {
      $id = $instance[ 'r_block_id' ];
    }
    else {
      $id = __( 'Block ID', 'reuse_widget_domain' );
    }
?>
    <p>
      <label for="<?php echo $this->get_field_id( 'r_block_id' ); ?>"><?php _e( 'Reusable block ID:' ); ?></label> 
      <input class="widefat" id="<?php echo $this->get_field_id( 'r_block_id' ); ?>" name="<?php echo $this->get_field_name( 'r_block_id' ); ?>" type="text" value="<?php echo esc_attr( $id ); ?>" />
    </p>
<?php 
  }
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['r_block_id'] = ( ! empty( $new_instance['r_block_id'] ) ) ? strip_tags( $new_instance['r_block_id'] ) : '';
    return $instance;
  }
} 
function reuse_widget_load_widget() {
  register_widget( 'reuse_widget' );
}
add_action( 'widgets_init', 'reuse_widget_load_widget' );
