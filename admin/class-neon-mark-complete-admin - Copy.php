<?php

class Neon_Mark_Complete_Admin {
    private $plugin_name;
    private $version;

    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;

        add_action( 'admin_init', array( $this, 'register_settings' ) );
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
            'Neon Mark Complete Button Settings',
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

    public function display_plugin_admin_settings() {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields( 'neon_mark_complete_settings' );
                do_settings_sections( 'neon_mark_complete_settings' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function register_settings() {
        register_setting(
            'neon_mark_complete_settings',
            'neon_mark_complete_options',
            array( $this, 'sanitize_settings' )
        );

        add_settings_section(
            'neon_mark_complete_settings_section',
            'Button Labels',
            null,
            'neon_mark_complete_settings'
        );

        add_settings_field(
            'button_label',
            'Button Label',
            array( $this, 'button_label_callback' ),
            'neon_mark_complete_settings',
            'neon_mark_complete_settings_section'
        );

        add_settings_field(
            'saving_label',
            'Saving Label',
            array( $this, 'saving_label_callback' ),
            'neon_mark_complete_settings',
            'neon_mark_complete_settings_section'
        );

        add_settings_field(
            'saved_label',
            'Saved Label',
            array( $this, 'saved_label_callback' ),
            'neon_mark_complete_settings',
            'neon_mark_complete_settings_section'
        );
        add_settings_section(
            'neon_mark_complete_content_section',
            'Content Types',
            null,
            'neon_mark_complete_settings'
        );
        add_settings_field(
            'content_types',
            'Content Types',
            array( $this, 'content_types_callback' ),
            'neon_mark_complete_settings',
            'neon_mark_complete_settings_section'
        );
    }

    public function sanitize_settings( $input ) {
        $new_input = array();
        if ( isset( $input['button_label'] ) ) {
            $new_input['button_label'] = sanitize_text_field( $input['button_label'] );
        }
        if ( isset( $input['saving_label'] ) ) {
            $new_input['saving_label'] = sanitize_text_field( $input['saving_label'] );
        }
        if ( isset( $input['saved_label'] ) ) {
            $new_input['saved_label'] = sanitize_text_field( $input['saved_label'] );
        }
        return $new_input;
    }

    public function button_label_callback() {
        $options = get_option( 'neon_mark_complete_options' );
        ?>
        <input type="text" name="neon_mark_complete_options[button_label]" value="<?php echo isset( $options['button_label'] ) ? esc_attr( $options['button_label'] ) : ''; ?>" />
        <?php
    }

    public function saving_label_callback() {
        $options = get_option( 'neon_mark_complete_options' );
        ?>
        <input type="text" name="neon_mark_complete_options[saving_label]" value="<?php echo isset( $options['saving_label'] ) ? esc_attr( $options['saving_label'] ) : ''; ?>" />
        <?php
    }

    public function saved_label_callback() {
        $options = get_option( 'neon_mark_complete_options' );
        ?>
        <input type="text" name="neon_mark_complete_options[saved_label]" value="<?php echo isset( $options['saved_label'] ) ? esc_attr( $options['saved_label'] ) : ''; ?>" />
        <?php
    }
    public function content_types_callback() {
        $options = get_option( 'neon_mark_complete_options' );
        $args       = array(
			'public' => true,
		);
		$post_types = get_post_types( $args, 'objects' );
		?>

		<select class="widefat" name="post_type">
		    <?php foreach ( $post_types as $post_type_obj ):
		        $labels = get_post_type_labels( $post_type_obj );
		        ?>
		        <option value="<?php echo esc_attr( $post_type_obj->name ); ?>"><?php echo esc_html( $labels->name ); ?></option>
		    <?php endforeach; ?>
		</select>
		<?php
    }
}
