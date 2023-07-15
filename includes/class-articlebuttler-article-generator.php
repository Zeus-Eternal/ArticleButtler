<?php
/**
 * ArticleButtler_Article_Generator Class
 *
 * Responsible for generating articles based on prompts in the ArticleButtler plugin.
 */
class ArticleButtler_Article_Generator {
    /**
     * Chat-GPT model instance.
     *
     * @var GPT_Model
     */
    private $chat_gpt_model;

    /**
     * Initialize the article generator.
     *
     * @param GPT_Model $chat_gpt_model The instance of the chat-GPT model.
     */
    public function __construct($chat_gpt_model) {
        $this->chat_gpt_model = $chat_gpt_model;
    }

    /**
     * Initialize the article generator.
     */
    public function init() {
        // Register AJAX handler for generating an article.
        add_action('wp_ajax_generate_article', array($this, 'ajax_generate_article'));
        add_action('wp_ajax_nopriv_generate_article', array($this, 'ajax_generate_article'));
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
     * Generate an article based on the given prompt.
     *
     * @param string $prompt The prompt for generating the article.
     * @return string The generated article.
     */
    private function generate_article($prompt) {
        // Implement your article generation logic here.
        // Use the chat-GPT model to generate the article based on the prompt.

        $generated_article = $this->chat_gpt_model->generateArticle($prompt);

        return $generated_article;
    }
}
