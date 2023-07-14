<?php
/**
 * ArticleButtler_Settings Class
 *
 * Responsible for managing the settings functionality of the ArticleButtler plugin.
 */
class ArticleButtler_Settings {

    /**
     * Initialize the settings functionality.
     */
    public function init() {
        add_action('admin_menu', array($this, 'register_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));

        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'add_settings_link'));
    }

    /**
     * Register the settings page.
     */
    public function register_settings_page() {
        add_options_page('ArticleButtler Settings', 'ArticleButtler', 'manage_options', 'articlebuttler-settings', array($this, 'render_settings_page'));
    }

    /**
     * Render the settings page.
     */
    public function render_settings_page() {
        // Display settings page content here.
    }

    /**
     * Register the settings.
     */
    public function register_settings() {
        // Register your settings here using the Settings API.
        register_setting('articlebuttler_settings_group', 'articlebuttler_option');
    }

    /**
     * Add settings link to the plugin page.
     *
     * @param array $links Array of plugin action links.
     * @return array Updated array of plugin action links.
     */
    public function add_settings_link($links) {
        $settings_link = '<a href="' . admin_url('options-general.php?page=articlebuttler-settings') . '">' . __('Settings', 'articlebuttler') . '</a>';
        array_push($links, $settings_link);
        return $links;
    }
}
