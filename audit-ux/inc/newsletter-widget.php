<?php
/**
 * Creates a new widget which for displaying a newsletter form;
 */
class newsletter_widget extends WP_Widget {
    
  function __construct() {
    parent::__construct(
      'newsletter_widget', 
      __('Newsletter Widget', 'newsletter_widget_domain'), 
      array( 'description' => __( 'Show a form to your visitors so they can subscribe to your newsletter', 'newsletter_widget_domain' ), ) 
    );
  }
  
  public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );
    echo $args['before_widget'];
    if ( ! empty( $title ) ) {
      echo $args['before_title'] . $title . $args['after_title'];
    }
?>
<p class="newsletter_desc"><?php echo esc_html($instance['description']); ?></p>
<form method="POST" action="#">
  <label for="newsletter_email"><?php echo esc_html($instance['email_label']); ?></label>
  <input type="email" id="newsletter_email" name="newsletter_email" placeholder="<?php echo esc_html($instance['email_placeholder']); ?>">
  <label for="accept_email"><?php echo esc_html($instance['checkbox_label']); ?></label>
  <input type="checkbox" id="accept_email" name="accept_email">
  <p><?php echo $instance['tos']; ?></p>
  <input type="submit" value="<?php echo esc_html($instance['button_label']); ?>">
</form>
<?php
    echo $args['after_widget'];
  }

  public function form( $instance ) {
    $items = array(
      'title' => array('default' => 'Subscribe to our newsletter!', 'name' => 'Title', 'value' => ''),
      'description' => array('default' => 'Lorem ipsum dolor sit amet…', 'name' => 'Description', 'value' => ''),
      'email_label' => array('default' =>  'Your email address:', 'name' => 'Email Label', 'value' => ''),
      'email_placeholder' => array('default' =>  'christine.jourdain@entreprisebidule.com', 'name' => 'Email placeholder', 'value' => ''),
      'button_label' => array('default' =>  'Subscribe now!', 'name' => 'Button label', 'value' => ''),
      'checkbox_label' => array('default' =>  'I agree to receive this great newsletter', 'name' => 'Checkbox Label', 'value' => ''),
      'tos' => array('default' =>  'By subscribing, you accept our <a href="#">TOS</a>', 'name' => 'Confidentiality warning', 'value' => ''),
    );
    echo '<p>';
    foreach ($items as $key => $item) {
      if ( isset( $instance[ $key ] ) ) {
        $items[ $key ]['value'] = $instance[ $key ];
      }
      else {
        $items[ $key ]['value'] = __( $item['default'], 'newsletter_widget_domain' );
      }
?>
      <label for="<?php echo $this->get_field_id( $key ); ?>"><?php _e( $item['name'] ); ?></label> 
      <input class="widefat" id="<?php echo $this->get_field_id( $key ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" type="text" value="<?php echo esc_attr( $items[$key]['value'] ); ?>" />
<?php
    }
    echo '</p>';
?>
<?php 
  }
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
    $instance['email_label'] = ( ! empty( $new_instance['email_label'] ) ) ? strip_tags( $new_instance['email_label'] ) : '';
    $instance['email_placeholder'] = ( ! empty( $new_instance['email_placeholder'] ) ) ? strip_tags( $new_instance['email_placeholder'] ) : '';
    $instance['button_label'] = ( ! empty( $new_instance['button_label'] ) ) ? strip_tags( $new_instance['button_label'] ) : '';
    $instance['checkbox_label'] = ( ! empty( $new_instance['checkbox_label'] ) ) ? strip_tags( $new_instance['checkbox_label'] ) : '';
    if ( ! empty( $new_instance['tos'] ) ) {
      if ( current_user_can('unfiltered_html') )
        $instance['tos'] =  $new_instance['tos'];
      else
        $instance['tos'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['tos']) ) );
    } else {
      $instance['tos'] = "";
    }
    return $instance;
  }
} 
function newsletter_widget_load_widget() {
  register_widget( 'newsletter_widget' );
}
add_action( 'widgets_init', 'newsletter_widget_load_widget' );
