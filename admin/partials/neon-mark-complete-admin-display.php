<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <h2 class="nav-tab-wrapper">
        <a href="?page=neon-mark-complete" class="nav-tab <?php echo isset( $_GET['page'] ) && $_GET['page'] == 'neon-mark-complete' ? 'nav-tab-active' : ''; ?>">Dashboard</a>
        <a href="?page=neon-mark-complete-styles" class="nav-tab <?php echo isset( $_GET['page'] ) && $_GET['page'] == 'neon-mark-complete-styles' ? 'nav-tab-active' : ''; ?>">Styles</a>
        <a href="?page=neon-mark-complete-settings" class="nav-tab <?php echo isset( $_GET['page'] ) && $_GET['page'] == 'neon-mark-complete-settings' ? 'nav-tab-active' : ''; ?>">Settings</a>
    </h2>
    <div class="tab-content">
        <p>Welcome to the Neon Mark Complete plugin dashboard!</p>
    </div>
</div>
