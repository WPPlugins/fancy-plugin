<?php
/*
Plugin Name: Fancy Dolly
Plugin URI: http://www.lycie.com
Description: Fancy Dolly displays whatever text you want randomly in a widget position on the frontend.
Author: Onur Kocatas
Version: 2
Author URI: http://www.iwasinturkey.com
*/

/* Add our function to the widgets_init hook. */
add_action( 'widgets_init', 'fancy_dolly_load_widgets' );

/* Function that registers our widget. */
function fancy_dolly_load_widgets() {
	register_widget( 'Fancy_Dolly_Widget' );
}

class Fancy_Dolly_Widget extends WP_Widget {
function Fancy_Dolly_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Fancy_Dolly', 'description' => 'Fancy Dolly displays whatever text you want randomly in a widget position on the frontend.' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 600,  'id_base' => 'fancy-dolly-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'fancy-dolly-widget', 'Fancy Dolly', $widget_ops, $control_ops );
	}
	
	
	function widget( $args, $instance ) {
		extract( $args );

		/* User-selected settings. */
$title = apply_filters('widget_title', $instance['title'] );
$dtext = $instance['dtext'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;
		
// These are the lyrics to Hello Dolly
$dolly = $dtext;

// Here we split it into lines
$dolly = explode("\n", $dolly);
// And then randomly choose a line
$chosen = wptexturize( $dolly[ mt_rand(0, count($dolly) - 1) ] );

// This just echoes the chosen line, we'll position it later
	echo '<p id="dolly">' .$chosen. '</p>';

		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	
		function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
$instance['title'] = strip_tags( $new_instance['title'] );
$instance['dtext'] = strip_tags( $new_instance['dtext'] );

		return $instance;
	}
	
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'We love you Dolly', 'dtext' => 'Hello, Dolly
Well, hello, Dolly
It\'s so nice to have you back where you belong
You\'re lookin\' swell, Dolly');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
</p>
<p>
<label for="<?php echo $this->get_field_id( 'dtext' ); ?>">Text (each row will be displayed randomly, use Notepad to copy and paste):</label>
<textarea rows="16" cols="80" id="<?php echo $this->get_field_id( 'dtext' ); ?>" name="<?php echo $this->get_field_name( 'dtext' ); ?>" value="<?php echo $instance['dtext']; ?>"><?php echo $instance['dtext']; ?></textarea>
</p>
<?php
	}
}
?>