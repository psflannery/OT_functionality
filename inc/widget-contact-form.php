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
            __('phpList Mailing List', 'opening_times'), 
            
            // Widget description
            array(
                'classname'   => 'ot_mailling_list_widget',
                'description' => __( 'A phpList mailing list sign up form.', 'opening_times' )
            )
        );
    }
    
    /**
     * Outputs the content of the widget on the Front End
     *
     * @param array $args
     * @param array $instance
     */
    
    public function widget( $args, $instance ) {
        extract( $args );
        
        echo $before_widget;
        
        $instance = wp_parse_args( $instance, array(
            'title'       => '',
            'subscribe'   => '',
            'listID'      => '',
            'unsubscribe' => '',
            'form'        => '<form id="mailing-list-subscribe" class="row" method="post" action="%1$s" name="subscribeform" novalidate><fieldset class="col-lg-12">%2$s</fieldset></form>',
            'container'   => '<div class="col">%1$s</div>',
            'width'       => 'col-md-4',
            'offset'      => 'offset-md-4',
        ) );
        
        /**
         * Filters the arguments used to display the mailing list widget.
         *
         * @since 2.0.7
         *
         * @param array $args Array of widget arguments.
         */
        $instance = apply_filters( 'ot_mailing_list_widget_args', $instance );
        
        /** This filter is documented in core/src/wp-includes/default-widgets.php */
        $title = apply_filters( 'widget_title', $instance['title'] );
        
        $form = '';
        
        if ( '' != $instance['subscribe'] ) {                        
            if ( $title ) {
                $form .= '<div class="form-group row"><legend class="' . esc_attr( $instance['width'] ) . ' control-label">' . $before_title . $title . $after_title . '</legend></div>';
            }
            
            $form .=  '<div class="form-group row">
                            <label class="' . esc_attr( $instance['width'] ) . ' control-label" id="ot-mail" for="email">' . esc_html__( 'Email Address', 'opening_times' ) . '</label>
                            <div class="' . esc_attr( $instance['width'] ) . '">
                                <input id="field-ot-mail" class="form-control" name="email" type="email" value="" maxlength="255" required="required" tabindex="1">
                                <div class="invalid-feedback">' . esc_html__( 'Please provide a valid email.', 'opening_times' ) . '</div>
                            </div>
                        </div>  
                        <div class="form-group row">
                            <label class="' . esc_attr( $instance['width'] ) . ' control-label" id="ot-mail-confirm" for="emailconfirm">' . esc_html__( 'Confirm Email', 'opening_times' ) . '</label>
                            <div class="' . esc_attr( $instance['width'] ) . '">
                                <input id="field-ot-mail-confirm" class="form-control" name="emailconfirm" type="email" value="" maxlength="255" required="required" tabindex="2">
                                <div class="invalid-feedback" data-text-swap="' . esc_html__( 'Please provide a valid email.', 'opening_times' ) . '">' . esc_html__( 'Emails do not match.', 'opening_times' ) . '</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="' . esc_attr( $instance['width'] ) . ' control-label" id="ot-first-name" for="first-name">' . esc_html__( 'First Name', 'opening_times' ) . '</label>
                            <div class="' . esc_attr( $instance['width'] ) . '">
                                <input id="field-ot-first-name" class="form-control" name="first-name" type="text" class="field text fn" value="" required="required" tabindex="3">
                                <div class="invalid-feedback">' . esc_html__( 'Please enter your name.', 'opening_times' ) . '</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="' . esc_attr( $instance['width'] ) . ' control-label" id="ot-last-name" for="last-name">' . esc_html__( 'Surname', 'opening_times' ) . '</label>
                            <div class="' . esc_attr( $instance['width'] ) . '">
                                <input id="field-ot-last-name" class="form-control" name="last-name" type="text" class="field text fn" value="" tabindex="4">
                            </div>
                        </div>';
        }
        
        if ( '' != $instance['listID'] ) {
            $form .= '<div class="form-group row">
                            <div class="offset-md-4 ' . esc_attr( $instance['width'] ) . '">
                                <input name="list[' . esc_attr( $instance['listID'] ) . ']" value="signup" type="hidden">
                                <input name="listname[' . esc_attr( $instance['listID'] ) . ']" value="Opening Times General List" type="hidden">
                                <button class="btn btn-outline-secondary" name="subscribe" type="submit" tabindex="5">' . esc_html__( 'Subscribe', 'opening_times' ) . '</button>
                            </div>
                        </div>';
        }
        
        if ( '' != $instance['unsubscribe'] ) {
            $form .= '<div class="form-group row">
                            <div class="offset-md-4 ' . esc_attr( $instance['width'] ) . '">
                                <a href="' . esc_attr( $instance['unsubscribe'] ) . '" class="ot-mail-unsubscribe btn-link">' . esc_html__( 'Unubscribe', 'opening_times' ) . '</a>
                            </div>
                        </div>';
        }
        
        /**
         * Filters the HTML output of the form.
         *
         * @since 2.0.7
         *
         * @param string $args     HTML output.
         * @param array  $instance Array of widget arguments
         */
        $form = apply_filters( 'ot_mailing_list_form', $form, $instance );
        
        $output = sprintf(
            $instance['form'],
            esc_attr( $instance['subscribe'] ),
            $form
        );
        
        if ( '' != $instance['container'] ) {
            $container = sprintf(
                $instance['container'],
                $output
            );
            
            echo $container;
        } else {
            echo $output;
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
    
        echo '<p><label for="' . $this->get_field_id( 'title' ) . '">' . esc_html__( 'Title:', 'opening_times' ) . '</label>
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

// Register and load the widget for use in Appearance -> Widgets
add_action( 'widgets_init', function() {
    register_widget( 'Opening_Times_Mailing_List' );
});
