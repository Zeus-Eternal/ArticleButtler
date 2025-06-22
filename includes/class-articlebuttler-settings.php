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
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('ArticleButtler Settings', 'articlebuttler'); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('articlebuttler_settings_group');
                do_settings_sections('articlebuttler-settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register the settings.
     */
    public function register_settings() {
        register_setting(
            'articlebuttler_settings_group',
            'articlebuttler_options',
            array('sanitize_callback' => array($this, 'sanitize_options'))
        );

        add_settings_section(
            'articlebuttler_main',
            __('Main Settings', 'articlebuttler'),
            null,
            'articlebuttler-settings'
        );

        add_settings_field(
            'articlebuttler_api_key',
            __('OpenAI API Key', 'articlebuttler'),
            array($this, 'api_key_field'),
            'articlebuttler-settings',
            'articlebuttler_main'
        );

        add_settings_field(
            'articlebuttler_prompt',
            __('Default Prompt', 'articlebuttler'),
            array($this, 'prompt_field'),
            'articlebuttler-settings',
            'articlebuttler_main'
        );

        add_settings_field(
            'articlebuttler_image_library',
            __('Image Library', 'articlebuttler'),
            array($this, 'image_library_field'),
            'articlebuttler-settings',
            'articlebuttler_main'
        );
    }

    public function api_key_field() {
        $options = get_option('articlebuttler_options');
        $api_key = isset($options['api_key']) ? esc_attr($options['api_key']) : '';
        echo '<input type="text" name="articlebuttler_options[api_key]" value="' . $api_key . '" class="regular-text" />';
    }

    public function prompt_field() {
        $options = get_option('articlebuttler_options');
        $prompt = isset($options['prompt']) ? esc_attr($options['prompt']) : '';
        echo '<input type="text" name="articlebuttler_options[prompt]" value="' . $prompt . '" class="regular-text" />';
    }

    public function image_library_field() {
        $options = get_option('articlebuttler_options');
        $library = isset($options['image_library']) ? $options['image_library'] : 'gd';
        ?>
        <select name="articlebuttler_options[image_library]">
            <option value="gd" <?php selected($library, 'gd'); ?>>GD</option>
            <option value="imagick" <?php selected($library, 'imagick'); ?>>Imagick</option>
            <option value="api" <?php selected($library, 'api'); ?>>API</option>
        </select>
        <?php
    }

    /**
     * Sanitize all plugin options.
     *
     * @param array $input Raw input values.
     * @return array Sanitized options array.
     */
    public function sanitize_options($input) {
        $output = array();

        if (isset($input['api_key'])) {
            $output['api_key'] = sanitize_text_field($input['api_key']);
        }

        if (isset($input['prompt'])) {
            $output['prompt'] = sanitize_text_field($input['prompt']);
        }

        if (isset($input['image_library'])) {
            $allowed             = array('gd', 'imagick', 'api');
            $output['image_library'] = in_array($input['image_library'], $allowed, true) ? $input['image_library'] : 'gd';
        }

        return $output;
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
