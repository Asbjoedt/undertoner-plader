<?php

/**
 * Plugin Name: Undertoner infoboks til plader
 * Description: Tilføjer infoboks widget med cover til pladeanmeldelser.
 * Version: 1.0
 * Author: Asbjørn Skødt
 * Author URI: https://youtu.be/boIKuEl6l0Y
 **/

class undertoner_infoboks extends WP_Widget {

// Laver infoboks widget
public function __construct() {
    $widget_options = array( 
      'classname' => 'undertoner_infoboks_plader',
      'description' => 'Infoboks til pladeanmeldelser',
    );
    parent::__construct( 'undertoner_infoboks_plader', 'Undertoner infoboks plader', $widget_options );
  }


// Laver backend inputfelter
public function form( $instance ) {
  $title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>
  <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>">Overskrift:</label>
    <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
  </p><?php 
}

// Viser widget i frontend
public function widget( $args, $instance ) {

    if ( ! is_single() || ! in_category('pladeanmeldelser') ) {
    return;
    }
	
  $title = apply_filters( 'widget_title', $instance[ 'title' ] );
  $selskab = get_field( "selskab" );
  $related = get_field( "related" );
  $udgivet = get_field( "udgivet" );
  echo $args['before_widget'];
	if ( $title ) {
	echo $args['before_title'] . $title . $args['after_title']; } ?>

	<?php   global $post;
	if ( has_post_thumbnail( $post->ID ) )
	echo get_the_post_thumbnail( $post->ID, 'medium' ); 
	?>

<div class="textwidget">
	<?php if(isset($selskab)) { echo "<p><strong>Pladeselskab:</strong> $selskab </p>"; } ?>
	<?php if(isset($related)) { echo "<p><strong>Musikalske slægtninge:</strong> $related </p>"; } ?>
	<?php if(isset($udgivet)) { echo "<p><strong>Udgivelsesår:</strong> $udgivet </p>"; } ?>
</div>

  <?php echo $args['after_widget'];
}

}

// Registrer infoboks som widget
function registrer_undertoner_infoboks() {
	register_widget( 'undertoner_infoboks' );
}
add_action( 'widgets_init', 'registrer_undertoner_infoboks' );

?>
