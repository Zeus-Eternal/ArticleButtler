<?php
/**
 * ArticleButtler_Generator Class
 *
 * Responsible for generating articles and images based on prompts in the ArticleButtler plugin.
 */
class ArticleButtler_Generator {

    /**
     * Initialize the generator.
     */
    public function init() {
        // Register AJAX handlers.
        add_action('wp_ajax_generate_article', array($this, 'ajax_generate_article'));
        add_action('wp_ajax_nopriv_generate_article', array($this, 'ajax_generate_article'));

        add_action('wp_ajax_generate_image', array($this, 'ajax_generate_image'));
        add_action('wp_ajax_nopriv_generate_image', array($this, 'ajax_generate_image'));
    }

    /**
     * AJAX handler for generating an article based on a prompt.
     */
    public function ajax_generate_article() {
        // Verify the nonce for security.
        check_ajax_referer('articlebuttler_generate_article', 'nonce');

        // Get the prompt from the AJAX request.
        $prompt = isset($_POST['prompt']) ? sanitize_text_field($_POST['prompt']) : '';

        // Perform article generation logic here.
        $generated_article = $this->generate_article($prompt);

        // Prepare the response.
        $response = array(
            'success' => true,
            'article' => $generated_article,
        );

        // Send the JSON response.
        wp_send_json($response);
    }

    /**
     * AJAX handler for generating an image based on a prompt.
     */
    public function ajax_generate_image() {
        // Verify the nonce for security.
        check_ajax_referer('articlebuttler_generate_image', 'nonce');

        // Get the prompt from the AJAX request.
        $prompt = isset($_POST['prompt']) ? sanitize_text_field($_POST['prompt']) : '';

        // Perform image generation logic here.
        $generated_image_url = $this->generate_image($prompt);

        // Prepare the response.
        $response = array(
            'success' => true,
            'image_url' => $generated_image_url,
        );

        // Send the JSON response.
        wp_send_json($response);
    }

    /**
     * Generate an article based on the given prompt.
     *
     * @param string $prompt The prompt for generating the article.
     * @return string The generated article.
     */
    private function generate_article($prompt) {
        $options = get_option('articlebuttler_options');
        $api_key = isset($options['api_key']) ? trim($options['api_key']) : '';

        if (empty($api_key)) {
            return __('OpenAI API key is not configured.', 'articlebuttler');
        }

        $args = array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type'  => 'application/json',
            ),
            'body'    => wp_json_encode(array(
                'model'       => 'text-davinci-003',
                'prompt'      => $prompt,
                'max_tokens'  => 150,
                'temperature' => 0.7,
            )),
            'timeout' => 20,
        );

        $response = wp_remote_post('https://api.openai.com/v1/completions', $args);
        if (is_wp_error($response)) {
            return $response->get_error_message();
        }

        $data = json_decode(wp_remote_retrieve_body($response), true);
        if (isset($data['choices'][0]['text'])) {
            return sanitize_textarea_field($data['choices'][0]['text']);
        }

        return __('Failed to generate article.', 'articlebuttler');
    }

    /**
     * Generate an image based on the given prompt.
     *
     * @param string $prompt The prompt for generating the image.
     * @return string The URL of the generated image.
     */
    private function generate_image($prompt) {
        // Perform the image generation logic here using libraries, APIs, or other techniques.
        // You can customize this method to suit your specific requirements and integrate with the necessary image generation tools.

        // Return the URL of the generated image.
        return 'https://example.com/generated-image.jpg';
    }
}
