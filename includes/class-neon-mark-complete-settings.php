<?php

class Neon_Mark_Complete_Settings {
    private $options;

    public function __construct() {
        $this->options = get_option('neon_mark_complete_options');
    }

    public function register_settings() {
        add_action('admin_init', array($this, 'settings_init'));
    }

    public function settings_init() {
        register_setting('neon_mark_complete_option_group', 'neon_mark_complete_options', array($this, 'sanitize'));

        add_settings_section(
            'neon_mark_complete_setting_section',
            'Neon Mark Complete Settings',
            array($this, 'print_section_info'),
            'neon-mark-complete-settings'
        );

        add_settings_field(
            'button_label',
            'Button Label text',
            array($this, 'button_label_callback'),
            'neon-mark-complete-settings',
            'neon_mark_complete_setting_section'
        );

        add_settings_field(
            'saving_label',
            'Saving Label text',
            array($this, 'saving_label_callback'),
            'neon-mark-complete-settings',
            'neon_mark_complete_setting_section'
        );

        add_settings_field(
            'saved_label',
            'Saved Label text',
            array($this, 'saved_label_callback'),
            'neon-mark-complete-settings',
            'neon_mark_complete_setting_section'
        );

        add_settings_field(
            'content_types',
            'Content Types',
            array($this, 'content_types_callback'),
            'neon-mark-complete-settings',
            'neon_mark_complete_setting_section'
        );

        add_settings_field(
            'show_widget',
            'Show widget in WP dashboard',
            array($this, 'show_widget_callback'),
            'neon-mark-complete-settings',
            'neon_mark_complete_setting_section'
        );

        add_settings_field(
            'user_types',
            'User Types',
            array($this, 'user_types_callback'),
            'neon-mark-complete-settings',
            'neon_mark_complete_setting_section'
        );

        add_settings_field(
            'enable_new_posts',
            'Enable add to any newly created posts',
            array($this, 'enable_new_posts_callback'),
            'neon-mark-complete-settings',
            'neon_mark_complete_setting_section'
        );

        add_settings_field(
            'enable_new_pages',
            'Enable add to any newly created pages',
            array($this, 'enable_new_pages_callback'),
            'neon-mark-complete-settings',
            'neon_mark_complete_setting_section'
        );

        add_settings_field(
            'bulk_enable',
            'Bulk Enable',
            array($this, 'bulk_enable_callback'),
            'neon-mark-complete-settings',
            'neon_mark_complete_setting_section'
        );

        add_settings_field(
            'quick_edit',
            'Quick Edit Checkbox',
            array($this, 'quick_edit_callback'),
            'neon-mark-complete-settings',
            'neon_mark_complete_setting_section'
        );

       /* add_settings_field(
            'post_page_switch',
            'Enable in Posts and Pages',
            array($this, 'post_page_switch_callback'),
            'neon-mark-complete-settings',
            'neon_mark_complete_setting_section'
        );*/

        add_settings_field(
            'enable_existing_posts',
            'Enable in Posts',
            array($this, 'enable_posts_callback'),
            'neon-mark-complete-settings',
            'neon_mark_complete_setting_section'
        );
        add_settings_field(
            'enable_existing_pages',
            'Enable in Pages',
            array($this, 'enable_existing_pages_callback'),
            'neon-mark-complete-settings',
            'neon_mark_complete_setting_section'
        );


        add_settings_field(
            'placement',
            'Placement',
            array($this, 'placement_callback'),
            'neon-mark-complete-settings',
            'neon_mark_complete_setting_section'
        );
    }

    public function sanitize($input) {
        $new_input = array();

        if (isset($input['button_label'])) {
            $new_input['button_label'] = sanitize_text_field($input['button_label']);
        }
        if (isset($input['saving_label'])) {
            $new_input['saving_label'] = sanitize_text_field($input['saving_label']);
        }
        if (isset($input['saved_label'])) {
            $new_input['saved_label'] = sanitize_text_field($input['saved_label']);
        }
        if (isset($input['content_types'])) {
            $new_input['content_types'] = array_map('sanitize_text_field', $input['content_types']);
        }
        if (isset($input['show_widget'])) {
            $new_input['show_widget'] = $input['show_widget'] ? '1' : '0';
        }
        if (isset($input['user_types'])) {
            $new_input['user_types'] = array_map('sanitize_text_field', $input['user_types']);
        }
        if (isset($input['enable_new_posts'])) {
            $new_input['enable_new_posts'] = $input['enable_new_posts'] ? '1' : '0';
        }
        if (isset($input['enable_new_pages'])) {
            $new_input['enable_new_pages'] = $input['enable_new_pages'] ? '1' : '0';
        }
        if (isset($input['bulk_enable'])) {
            $new_input['bulk_enable'] = array_map('sanitize_text_field', $input['bulk_enable']);
        }
        if (isset($input['quick_edit'])) {
            $new_input['quick_edit'] = $input['quick_edit'] ? '1' : '0';
        }
        if (isset($input['enable_existing_posts'])) {
            $new_input['enable_existing_posts'] = $input['enable_existing_posts'] ? '1' : '0';
        }
        if (isset($input['enable_existing_pages'])) {
            $new_input['enable_existing_pages'] = $input['enable_existing_pages'] ? '1' : '0';
        }
        if (isset($input['placement'])) {
            $new_input['placement'] = sanitize_text_field($input['placement']);
        }

        return $new_input;
    }

    public function print_section_info() {
        echo 'Customize the settings for the Neon Mark Complete plugin:';
    }

    public function button_label_callback() {
        printf(
            '<input type="text" id="button_label" name="neon_mark_complete_options[button_label]" value="%s" />',
            isset($this->options['button_label']) ? esc_attr($this->options['button_label']) : ''
        );
    }

    public function saving_label_callback() {
        printf(
            '<input type="text" id="saving_label" name="neon_mark_complete_options[saving_label]" value="%s" />',
            isset($this->options['saving_label']) ? esc_attr($this->options['saving_label']) : ''
        );
    }

    public function saved_label_callback() {
        printf(
            '<input type="text" id="saved_label" name="neon_mark_complete_options[saved_label]" value="%s" />',
            isset($this->options['saved_label']) ? esc_attr($this->options['saved_label']) : ''
        );
    }

    public function content_types_callback() {
        // Get all public post types
        $post_types = get_post_types(array('public' => true), 'objects');
        
        // Filter to include only 'post', 'page', and custom post types (excluding built-in types other than 'post' and 'page')
        $filtered_post_types = array_filter($post_types, function($post_type) {
            return $post_type->name === 'post' || $post_type->name === 'page' || !in_array($post_type->name, array('attachment', 'revision', 'nav_menu_item'));
        });

        foreach ($filtered_post_types as $post_type) {
            $checked = isset($this->options['content_types']) && in_array($post_type->name, $this->options['content_types']) ? 'checked' : '';
            printf(
                '<label><input type="checkbox" name="neon_mark_complete_options[content_types][]" value="%s" %s> %s</label><br>',
                esc_attr($post_type->name),
                $checked,
                esc_html($post_type->labels->name)
            );
        }
    }


    /*public function content_types_callback() {
        $post_types = get_post_types(array('public' => true), 'objects');
        foreach ($post_types as $post_type) {
            $checked = isset($this->options['content_types']) && in_array($post_type->name, $this->options['content_types']) ? 'checked' : '';
            printf(
                '<label><input type="checkbox" name="neon_mark_complete_options[content_types][]" value="%s" %s> %s</label><br>',
                esc_attr($post_type->name),
                $checked,
                esc_html($post_type->labels->name)
            );
        }
    }*/

    public function show_widget_callback() {
        printf(
            '<label class="switch"><input type="checkbox" id="show_widget" name="neon_mark_complete_options[show_widget]" value="1" %s /><span class="slider round"></span> </label>',
            isset($this->options['show_widget']) && $this->options['show_widget'] === '1' ? 'checked' : ''
        );
    }

    public function user_types_callback() {
        $roles = get_editable_roles();
        foreach ($roles as $role_name => $role_info) {
            $checked = isset($this->options['user_types']) && in_array($role_name, $this->options['user_types']) ? 'checked' : '';
            printf(
                '<label><input type="checkbox" name="neon_mark_complete_options[user_types][]" value="%s" %s> %s</label><br>',
                esc_attr($role_name),
                $checked,
                esc_html($role_info['name'])
            );
        }
    }

    public function enable_new_posts_callback() {
        printf(
            '<label class="switch"><input type="checkbox" id="enable_new_posts" name="neon_mark_complete_options[enable_new_posts]" value="1" %s /><span class="slider round"></span> </label>',
            isset($this->options['enable_new_posts']) && $this->options['enable_new_posts'] === '1' ? 'checked' : ''
        );
    }

    public function enable_new_pages_callback() {
        printf(
            '<label class="switch"><input type="checkbox" id="enable_new_pages" name="neon_mark_complete_options[enable_new_pages]" value="1" %s /><span class="slider round"></span> </label>',
            isset($this->options['enable_new_pages']) && $this->options['enable_new_pages'] === '1' ? 'checked' : ''
        );
    }

    public function bulk_enable_callback() {
        // Get all public post types
        $post_types = get_post_types(array('public' => true), 'objects');
        
        // Filter to include only 'post', 'page', and custom post types (excluding built-in types other than 'post' and 'page')
        $filtered_post_types = array_filter($post_types, function($post_type) {
            return $post_type->name === 'post' || $post_type->name === 'page' || !in_array($post_type->name, array('attachment', 'revision', 'nav_menu_item', 'template'));
        });

        foreach ($filtered_post_types as $post_type) {
            $posts = get_posts(array('post_type' => $post_type->name, 'numberposts' => -1));
            foreach ($posts as $post) {
                $checked = isset($this->options['bulk_enable']) && in_array($post->ID, $this->options['bulk_enable']) ? 'checked' : '';
                printf(
                    '<label><input type="checkbox" name="neon_mark_complete_options[bulk_enable][]" value="%s" %s> %s (%s)</label><br>',
                    esc_attr($post->ID),
                    $checked,
                    esc_html($post->post_title),
                    esc_html($post_type->labels->singular_name)
                );
            }
        }
    }


    public function quick_edit_callback() {
        printf(
            '<label class="switch"><input type="checkbox" id="quick_edit" name="neon_mark_complete_options[quick_edit]" value="1" %s /><span class="slider round"></span> </label>',
            isset($this->options['quick_edit']) && $this->options['quick_edit'] === '1' ? 'checked' : ''
        );
    }

     public function enable_posts_callback() {
        printf(
            '<label class="switch"><input type="checkbox" id="enable_existing_posts" name="neon_mark_complete_options[enable_existing_posts]" value="1" %s /><span class="slider round"></span> </label>',
            isset($this->options['enable_existing_posts']) && $this->options['enable_existing_posts'] === '1' ? 'checked' : ''
        );
    }

    public function enable_existing_pages_callback() {
        printf(
            '<label class="switch"><input type="checkbox" id="enable_existing_pages" name="neon_mark_complete_options[enable_existing_pages]" value="1" %s /><span class="slider round"></span> </label>',
            isset($this->options['enable_existing_pages']) && $this->options['enable_existing_pages'] === '1' ? 'checked' : ''
        );
    }


    /*public function post_page_switch_callback() {
        printf(
            '<label class="switch"><input type="checkbox" id="post_page_switch" name="neon_mark_complete_options[post_page_switch]" value="1" %s /><span class="slider round"></span> </label>',
            isset($this->options['post_page_switch']) && $this->options['post_page_switch'] === '1' ? 'checked' : ''
        );
    }*/

    public function placement_callback() {
        $placements = array('top' => 'Top', 'bottom' => 'Bottom');
        foreach ($placements as $value => $label) {
            $checked = isset($this->options['placement']) && $this->options['placement'] === $value ? 'checked' : '';
            printf(
                '<label><input type="checkbox" name="neon_mark_complete_options[placement]" value="%s" %s> %s</label><br>',
                esc_attr($value),
                $checked,
                esc_html($label)
            );
        }
    }
}
