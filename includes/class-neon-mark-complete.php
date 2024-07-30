<?php

class Neon_Mark_Complete {
    protected $loader;
    protected $plugin_name;
    protected $version;

    public function __construct() {
        $this->plugin_name = 'neon-mark-complete';
        $this->version = NEON_MARK_COMPLETE_VERSION;

        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    private function load_dependencies() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-neon-mark-complete-loader.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-neon-mark-complete-admin.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-neon-mark-complete-public.php';

        $this->loader = new Neon_Mark_Complete_Loader();
    }

    private function define_admin_hooks() {
        $plugin_admin = new Neon_Mark_Complete_Admin( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );
    }

    private function define_public_hooks() {
        $plugin_public = new Neon_Mark_Complete_Public( $this->get_plugin_name(), $this->get_version() );
    }

    public function run() {
        $this->loader->run();
    }

    public function get_plugin_name() {
        return $this->plugin_name;
    }

    public function get_version() {
        return $this->version;
    }
}
