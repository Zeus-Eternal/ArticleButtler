<?php
/**
 * ArticleButtler_Admin Class
 *
 * Handles the administration functionality of the ArticleButtler plugin.
 */
class ArticleButtler_Admin {
    /**
     * Initialize the admin functionality.
     */
    public function init() {
        // Add the plugin settings page.
        add_action('admin_menu', array($this, 'add_settings_page'));
    }

    /**
     * Add the settings page to the admin menu.
     */
    public function add_settings_page() {
        // Add a new top-level menu page.
        add_menu_page(
            'ArticleButtler Settings',
            'ArticleButtler',
            'manage_options',
            'articlebuttler-settings',
            array($this, 'render_settings_page'),
            'dashicons-admin-generic',
            80
        );
    }

    /**
     * Render the plugin settings page.
     */
    public function render_settings_page() {
        include plugin_dir_path(__FILE__) . '../admin/partials/articlebuttler-admin-display.php';
    }
}
