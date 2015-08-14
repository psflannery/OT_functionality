<?php
/**
* Plugin Name: Opening Times Mailing List Subscribe Form
* Description: A simple mailing list widget. Outputs a phpList mailing list signup form.
* Version: 1.0
* Author: Paul Flannery
* Author URI: http://www.paulflannery.co.uk
* License: GNU General Public License v3 or later
* License URI: http://www.gnu.org/licenses/gpl-3.0.html
* Text Domain: opening_times
* Domain Path: translation
* Inspired By: https://wordpress.org/plugins/very-simple-contact-form/
* Guided By: https://github.com/Automattic/jetpack/blob/master/modules/widgets/image-widget.php
*/

// Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

// Create the widget 
class Opening_Times_Mailing_List extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
    public function __construct() {
        parent::__construct(
            // Base ID of your widget
            'ot_mailing_list', 

            // Widget name will appear in UI
            __('phpList Mailing List Widget', 'opening_times'), 

            // Widget description
            array(
                'classname'   => 'ot_mailling_list_widget',
                'description' => __( 'A simple widget to create a phpList mailing list sign up form.', 'opening_times' )
            )
        );
    }

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
     
	public function widget( $args, $instance ) {
		extract( $args );

		echo $before_widget;

        $instance = wp_parse_args( $instance, array(
			'title' => '',
			'subscribe' => ''
		) );

        $title = apply_filters( 'widget_title', $instance['title'] );

        if ( $title ) {
            echo $before_title . $title . $after_title;
        }
        
        if ( '' != $instance['subscribe'] ) {
            $output = '<form class="form-horizontal row" method="post" action="' . esc_attr( $instance['subscribe'] ) . '" name="subscribeform"';
            $output .= '<fieldset>';
            $output .= '<div class="form-group">
                            <legend class="col-sm-3 control-label">' . esc_html__( 'Subscribe to our mailing list', 'opening_times' ) . '</legend>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" id="ot-mail" for="email">' . esc_html__( 'Email Address', 'opening_times' ) . '</label>
                            <div class="col-sm-4">
                                <input id="field-ot-mail" class="form-control" name="email" type="email" value="" maxlength="255" required="required" tabindex="1">
                            </div>
                        </div>	
                        <div class="form-group">
                            <label class="col-sm-3 control-label" id="ot-mail-confirm" for="emailconfirm">' . esc_html__( 'Confirm Email', 'opening_times' ) . '</label>
                            <div class="col-sm-4">
                                <input id="field-ot-mail-confirm" class="form-control" name="emailconfirm" type="email" value="" maxlength="255" required="required" tabindex="2">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" id="ot-first-name" for="first-name">' . esc_html__( 'First Name', 'opening_times' ) . '</label>
                            <div class="col-sm-4">
                                <input id="field-ot-first-name" class="form-control" name="first-name" type="text" class="field text fn" value="" required="required" tabindex="3">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" id="ot-last-name" for="last-name">' . esc_html__( 'Surname', 'opening_times' ) . '</label>
                            <div class="col-sm-4">
                                <input id="field-ot-last-name" class="form-control" name="last-name" type="text" class="field text fn" value="" tabindex="4">
                            </div>
                        </div>';
            if ( '' != $instance['listID'] ) {
                $output .= '<div class="form-group">
                                <div class="col-sm-offset-3 col-sm-7">
                                    <input name="list[' . esc_attr( $instance['listID'] ) . ']" value="signup" type="hidden">
                                    <input name="listname[' . esc_attr( $instance['listID'] ) . ']" value="Opening Times General List" type="hidden">
                                    <input id="ot-subscribe" name="subscribe" type="submit" value="' . esc_html__( 'Subscribe', 'opening_times' ) .'" class="ot-button" onclick="return checkform();" tabindex="5">
                                </div>
                            </div>';
            }
            if ( '' != $instance['unsubscribe'] ) {
                $output .= '<div class="form-group">
                                <div class="col-sm-offset-3 col-sm-7">
                                    <a href="' . esc_attr( $instance['unsubscribe'] ) . '" class="ot-mail-unsubscribe">' . esc_html__( 'Unubscribe', 'opening_times' ) . '</a>
                                </div>
                            </div>';
            }
            $output .= '</fieldset>';
            $output .= '</form>';
            
            echo '<div class="mailing-list-inner col-sm-8 col-lg-6 col-sm-offset-1 col-lg-offset-2">' . $output . '</div>';
        }
        echo "\n" . $after_widget;     
	}
    
    /**
	 * Processing and sanitizing widget options on save
	 *
     * @see WP_Widget::update()
     *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
     *
     * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
        $instance = $old_instance;

        $instance['title']       = strip_tags( $new_instance['title'] );
        $instance['subscribe']   = esc_url( $new_instance['subscribe'], null, 'display' );
        $instance['unsubscribe'] = esc_url( $new_instance['unsubscribe'], null, 'display' );
        $instance['listID']      = absint( $new_instance['listID'] );

        return $instance;
	}

    /**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
        // Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'subscribe' => '', 'unsubscribe' => '', 'listID' => '' ) );
         
		// Outputs the options form on admin
        $title       = esc_attr( $instance['title'] );
        $subscribe   = esc_url( $instance['subscribe'], null, 'display' );
        $unsubscribe = esc_url( $instance['unsubscribe'], null, 'display' );
        $listID      = absint( $instance['listID'] );

        echo '<p><label for="' . $this->get_field_id( 'title' ) . '">' . esc_html__( 'Widget title:', 'opening_times' ) . '</label>
            <input class="widefat" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . $title . '" />
            </p>
            <p><label for="' . $this->get_field_id( 'subscribe' ) . '">' . esc_html__( 'Subscribe Link:', 'opening_times' ) . '</label>
            <input class="widefat" id="' . $this->get_field_id( 'subscribe' ) . '" name="' . $this->get_field_name( 'subscribe' ) . '" type="text" value="' . $subscribe . '" />
            </p>
            <p><label for="' . $this->get_field_id( 'unsubscribe' ) . '">' . esc_html__( 'Unsubscribe Link:', 'opening_times' ) . '</label>
            <input class="widefat" id="' . $this->get_field_id( 'unsubscribe' ) . '" name="' . $this->get_field_name( 'unsubscribe' ) . '" type="text" value="' . $unsubscribe . '" />
            </p>
            <p><label for="' . $this->get_field_id( 'listID' ) . '">' . esc_html__( 'List ID:', 'opening_times' ) . '</label>
            <input class="widefat" id="' . $this->get_field_id( 'listID' ) . '" name="' . $this->get_field_name( 'listID' ) . '" type="text" value="' . $listID . '" />
            </p>';
	}
}

/**
 * Register and load the widget for use in Appearance -> Widgets
 */
add_action( 'widgets_init', function() {
    register_widget( 'Opening_Times_Mailing_List' );
});
