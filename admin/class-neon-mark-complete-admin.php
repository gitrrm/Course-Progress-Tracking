<?php

class Neon_Mark_Complete_Admin {
    private $plugin_name;
    private $version;

    public function __construct( $plugin_name, $version ) {
	    $this->plugin_name = $plugin_name;
	    $this->version = $version;

	    add_action( 'admin_init', array( $this, 'register_settings' ) );
	    add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
	}

    
    public function enqueue_styles() {
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/neon-mark-complete-admin.css', array(), $this->version, 'all' );
    }
    public function add_plugin_admin_menu() {
        add_menu_page(
            'Neon Mark Complete',
            'Neon Mark Complete',
            'manage_options',
            $this->plugin_name,
            array( $this, 'display_plugin_admin_dashboard' ),
            'dashicons-admin-generic',
            6
        );

        add_submenu_page(
            $this->plugin_name,
            'Dashboard',
            'Dashboard',
            'manage_options',
            $this->plugin_name,
            array( $this, 'display_plugin_admin_dashboard' )
        );

        add_submenu_page(
            $this->plugin_name,
            'Styles',
            'Styles',
            'manage_options',
            $this->plugin_name . '-styles',
            array( $this, 'display_plugin_admin_styles' )
        );

        add_submenu_page(
            $this->plugin_name,
            'Settings',
            'Settings',
            'manage_options',
            $this->plugin_name . '-settings',
            array( $this, 'display_plugin_admin_settings' )
        );
    }

    public function display_plugin_admin_dashboard() {
        include_once 'partials/neon-mark-complete-admin-display.php';
    }

    public function display_plugin_admin_styles() {
        echo '<div class="wrap"><h1>Styles</h1></div>';
    }

    /*public function display_plugin_admin_settings() {
        ?>
        <div class="wrap">
            <h1>Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields( 'neon_mark_complete_settings_group' );
                do_settings_sections( 'neon_mark_complete_settings' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }*/
    public function display_plugin_admin_settings() {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('neon_mark_complete_option_group');
                do_settings_sections('neon-mark-complete-settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function register_settings() {
        register_setting( 'neon_mark_complete_settings_group', 'neon_mark_complete_settings' );

        add_settings_section(
            'neon_mark_complete_general_section',
            'General Settings',
            null,
            'neon_mark_complete_settings'
        );

        add_settings_field(
            'button_label',
            'Button Label Text',
            array( $this, 'render_text_input' ),
            'neon_mark_complete_settings',
            'neon_mark_complete_general_section',
            array( 'name' => 'button_label' )
        );

        add_settings_field(
            'saving_label',
            'Saving Label Text',
            array( $this, 'render_text_input' ),
            'neon_mark_complete_settings',
            'neon_mark_complete_general_section',
            array( 'name' => 'saving_label' )
        );

        add_settings_field(
            'saved_label',
            'Saved Label Text',
            array( $this, 'render_text_input' ),
            'neon_mark_complete_settings',
            'neon_mark_complete_general_section',
            array( 'name' => 'saved_label' )
        );

        add_settings_field(
            'content_types',
            'Content Types',
            array( $this, 'render_content_types_multiselect' ),
            'neon_mark_complete_settings',
            'neon_mark_complete_general_section'
        );

        add_settings_field(
            'show_widget_in_dashboard',
            'Show widget in WP dashboard',
            array( $this, 'render_switch' ),
            'neon_mark_complete_settings',
            'neon_mark_complete_general_section',
            array( 'name' => 'show_widget_in_dashboard' )
        );

        add_settings_field(
            'user_types',
            'User Types',
            array( $this, 'render_user_types_multiselect' ),
            'neon_mark_complete_settings',
            'neon_mark_complete_general_section'
        );

        add_settings_field(
            'enable_add_to_new_posts',
            'Enable add to any newly created posts',
            array( $this, 'render_switch' ),
            'neon_mark_complete_settings',
            'neon_mark_complete_general_section',
            array( 'name' => 'enable_add_to_new_posts' )
        );

        add_settings_field(
            'enable_add_to_new_pages',
            'Enable add to any newly created pages',
            array( $this, 'render_switch' ),
            'neon_mark_complete_settings',
            'neon_mark_complete_general_section',
            array( 'name' => 'enable_add_to_new_pages' )
        );

        add_settings_field(
            'bulk_enable',
            'Bulk Enable',
            array( $this, 'render_bulk_enable_multiselect' ),
            'neon_mark_complete_settings',
            'neon_mark_complete_general_section'
        );

        add_settings_field(
            'quick_edit_checkbox',
            'Quick Edit Checkbox',
            array( $this, 'render_checkbox' ),
            'neon_mark_complete_settings',
            'neon_mark_complete_general_section',
            array( 'name' => 'quick_edit_checkbox' )
        );

        add_settings_field(
            'post_page_switch',
            'Enable Button in Posts and Pages',
            array( $this, 'render_switch' ),
            'neon_mark_complete_settings',
            'neon_mark_complete_general_section',
            array( 'name' => 'post_page_switch' )
        );

        add_settings_field(
            'placement',
            'Placement',
            array( $this, 'render_placement_checkbox' ),
            'neon_mark_complete_settings',
            'neon_mark_complete_general_section'
        );
    }

    public function render_text_input( $args ) {
        $options = get_option( 'neon_mark_complete_settings' );
        ?>
        <input type="text" name="neon_mark_complete_settings[<?php echo esc_attr( $args['name'] ); ?>]" value="<?php echo esc_attr( $options[ $args['name'] ] ?? '' ); ?>" />
        <?php
    }

    public function render_switch( $args ) {
        $options = get_option( 'neon_mark_complete_settings' );
        ?>
        <label class="switch">
            <input type="checkbox" name="neon_mark_complete_settings[<?php echo esc_attr( $args['name'] ); ?>]" value="1" <?php checked( $options[ $args['name'] ] ?? 0, 1 ); ?> />
            <span class="slider round"></span>
        </label>
        <?php
    }

    public function render_content_types_multiselect() {
        $options = get_option( 'neon_mark_complete_settings' );
        $post_types = get_post_types( array( 'public' => true ), 'objects' );
        ?>
        <select multiple name="neon_mark_complete_settings[content_types][]">
            <?php foreach ( $post_types as $post_type ) : ?>
                <option value="<?php echo esc_attr( $post_type->name ); ?>" <?php selected( in_array( $post_type->name, $options['content_types'] ?? array() ) ); ?>>
                    <?php echo esc_html( $post_type->label ); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php
    }

    public function render_user_types_multiselect() {
        $options = get_option( 'neon_mark_complete_settings' );
        $roles = wp_roles()->roles;
        ?>
        <select multiple name="neon_mark_complete_settings[user_types][]">
            <?php foreach ( $roles as $role_key => $role ) : ?>
                <option value="<?php echo esc_attr( $role_key ); ?>" <?php selected( in_array( $role_key, $options['user_types'] ?? array() ) ); ?>>
                    <?php echo esc_html( $role['name'] ); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php
    }

    public function render_bulk_enable_multiselect() {
        $options = get_option( 'neon_mark_complete_settings' );
        $posts = get_posts( array( 'numberposts' => -1, 'post_type' => 'any', 'post_status' => 'publish' ) );
        ?>
        <select multiple name="neon_mark_complete_settings[bulk_enable][]">
            <?php foreach ( $posts as $post ) : ?>
                <option value="<?php echo esc_attr( $post->ID ); ?>" <?php selected( in_array( $post->ID, $options['bulk_enable'] ?? array() ) ); ?>>
                    <?php echo esc_html( $post->post_title ); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php
    }

    public function render_checkbox( $args ) {
        $options = get_option( 'neon_mark_complete_settings' );
        ?>
        <input type="checkbox" name="neon_mark_complete_settings[<?php echo esc_attr( $args['name'] ); ?>]" value="1" <?php checked( $options[ $args['name'] ] ?? 0, 1 ); ?> />
        <?php
    }

    public function render_placement_checkbox() {
        $options = get_option( 'neon_mark_complete_settings' );
        ?>
        <label>
            <input type="checkbox" name="neon_mark_complete_settings[placement][]" value="top" <?php checked( in_array( 'top', $options['placement'] ?? array() ) ); ?> />
            Top
        </label>
        <label>
            <input type="checkbox" name="neon_mark_complete_settings[placement][]" value="bottom" <?php checked( in_array( 'bottom', $options['placement'] ?? array() ) ); ?> />
            Bottom
        </label>
        <?php
    }
}
