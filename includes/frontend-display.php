<?php
// Prevent direct access to the file
if (!defined('ABSPATH')) {
    exit;
}

function append_mark_complete_button_existing_posts($content) {
    if (is_singular('post')) {
        // Retrieve the options from the database
        $options = get_option('neon_mark_complete_options');

        // Check if the button label is set
        $button_label = isset($options['button_label']) ? $options['button_label'] : 'Mark Complete';

        // Check if the button should be displayed on existing posts
        $enable_existing_posts = isset($options['enable_existing_posts']) && $options['enable_existing_posts'] === '1';

        // Display the button if enabled
        if ($enable_existing_posts) {
            $content .= '<button class="mark-complete-button">' . esc_html($button_label) . '</button>';
        }
    }
    return $content;
}

add_filter('the_content', 'append_mark_complete_button_existing_posts');

function append_mark_complete_button_existing_pages($content) {

    // Check if we are on a single page and not on the homepage
    if (is_page() && !is_front_page()) {
        // Retrieve the options from the database
        $options = get_option('neon_mark_complete_options');

        // Check if the button label is set
        $button_label = isset($options['button_label']) ? $options['button_label'] : 'Mark Complete';

        // Check if the button should be displayed on existing pages
        $enable_existing_pages = isset($options['enable_existing_pages']) && $options['enable_existing_pages'] === '1';

        // Append the button to the content if enabled
        if ($enable_existing_pages) {
            $content .= '<button class="mark-complete-button">' . esc_html($button_label) . '</button>';
        }
    }
    return $content;
}

// Hook the function to 'the_content' filter
add_filter('the_content', 'append_mark_complete_button_existing_pages');
