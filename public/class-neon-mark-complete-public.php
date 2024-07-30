<?php

class Neon_Mark_Complete_Public {
    private $plugin_name;
    private $version;

    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;

        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public_styles' ) );
        add_action('wp_enqueue_scripts', array($this, 'neon_mark_complete_enqueue_scripts'));

        add_action('wp_ajax_mark_complete', array($this, 'neon_mark_complete_ajax_handler'));
        add_action('wp_ajax_nopriv_mark_complete', array($this, 'neon_mark_complete_ajax_handler'));
        add_filter('the_content', array($this, 'append_mark_complete_button_existing_pages'));
    }

    public function enqueue_public_styles() {
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/neon-mark-complete-public.css', array(), $this->version, 'all' );
    }

    public function neon_mark_complete_enqueue_scripts() {
        // Enqueue your script
        wp_enqueue_script('neon-mark-complete-script', plugin_dir_url(__FILE__) . 'js/neon-mark-complete-public.js', array('jquery'), null, true);

        // Localize script with options and AJAX URL
        $options = get_option('neon_mark_complete_options');
        $localized_data = array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'savingLabel' => isset($options['saving_label']) ? $options['saving_label'] : 'Saving...',
            'nonce' => wp_create_nonce('neon_mark_complete_nonce')
        );
        wp_localize_script('neon-mark-complete-script', 'NeonMarkCompleteOptions', $localized_data);
    }
    
    /*public function neon_mark_complete_ajax_handler() {
        // Check nonce for security
        check_ajax_referer('neon_mark_complete_nonce', 'nonce');

        // Validate inputs
        $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
        $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;

        if ($post_id && $user_id) {
            // Save the completion status in user meta or a custom table
            // Here, using user meta as an example:
            $completed = get_user_meta($user_id, 'completed_posts', true);
            if (!is_array($completed)) {
                $completed = array();
            }

            if (!in_array($post_id, $completed)) {
                $completed[] = $post_id;
                update_user_meta($user_id, 'completed_posts', $completed);
            }

            // Return success
            // wp_send_json_success();
             wp_send_json_success(array(
                'message' => __('Complete', 'neon-mark-complete'),
                'saved_label' => esc_html($options['saved_label'])
            ));
        }

        // Return error
        wp_send_json_error();
    }*/
    function neon_mark_complete_ajax_handler() {
        // Verify nonce for security
        check_ajax_referer('neon_mark_complete_nonce', 'nonce');

        // Get user ID and post ID
        $user_id = get_current_user_id();
        $post_id = intval($_POST['post_id']);

        // Retrieve the plugin options
        $options = get_option('neon_mark_complete_options');
        $saved_label = isset($options['saved_label']) ? $options['saved_label'] : 'Complete';

        // Update user meta to mark the post as complete
        update_user_meta($user_id, '_neon_mark_complete_' . $post_id, true);

        // Send the saved label in the response
        wp_send_json_success(array(
            'message' => __('Complete', 'text-domain'),
            'saved_label' => esc_html($saved_label)
        ));
    }


    public function append_mark_complete_button_existing_pages($content) {
        if (is_page() && !is_front_page()) {
            // Retrieve the options from the database
            $options = get_option('neon_mark_complete_options');
            $button_label = isset($options['button_label']) ? $options['button_label'] : 'Mark Complete';
            $saved_label = isset($options['saved_label']) ? $options['saved_label'] : 'Completed';

            // Check if the button should be displayed on existing pages
            $enable_existing_pages = isset($options['enable_existing_pages']) && $options['enable_existing_pages'] === '1';

            if ($enable_existing_pages && is_user_logged_in()) {
                $user_id = get_current_user_id();
                $post_id = get_the_ID();

                // Check if the user has already marked this post as complete
                $completed = get_user_meta($user_id, 'completed_posts', true);
                $is_completed = is_array($completed) && in_array($post_id, $completed);

                // Set the button label and disable attribute
                $button_label = $is_completed ? $saved_label : $button_label;
                $disabled_attribute = $is_completed ? 'disabled' : '';

                // Render the button with the correct label and disabled attribute
                $content .= sprintf(
                    '<button class="mark-complete-button" data-post-id="%d" data-user-id="%d" %s>%s</button>',
                    esc_attr($post_id),
                    esc_attr($user_id),
                    $disabled_attribute,
                    esc_html($button_label)
                );
            }
        }
        return $content;
    }

}
