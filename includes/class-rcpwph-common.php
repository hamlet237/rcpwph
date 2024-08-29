<?php
/**
 * The-global functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to enqueue the-global stylesheet and JavaScript.
 *
 * @link       wordpress-heroes.com/
 * @since      1.0.0
 * @package    RCPWPH
 * @subpackage RCPWPH/includes
 * @author     wordpress-heroes <info@wordpress-heroes.com>
 */
class RCPWPH_Common {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version) {
		$this->plugin_name = $plugin_name;
		$this->version = '3';
	}

	/**
	 * Register the stylesheets.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		if (!wp_style_is($this->plugin_name . '-material-icons-outlined', 'enqueued')) {
			wp_enqueue_style($this->plugin_name . '-material-icons-outlined', RCPWPH_URL . 'assets/css/material-icons-outlined.min.css', array(), $this->version, 'all');
    }

    if (!wp_style_is($this->plugin_name . '-select2', 'enqueued')) {
			wp_enqueue_style($this->plugin_name . '-select2', RCPWPH_URL . 'assets/css/select2.min.css', array(), $this->version, 'all');
    }

    if (!wp_style_is($this->plugin_name . '-trumbowyg', 'enqueued')) {
			wp_enqueue_style($this->plugin_name . '-trumbowyg', RCPWPH_URL . 'assets/css/trumbowyg.min.css', array(), $this->version, 'all');
    }

    if (!wp_style_is($this->plugin_name . '-fancybox', 'enqueued')) {
			wp_enqueue_style($this->plugin_name . '-fancybox', RCPWPH_URL . 'assets/css/fancybox.min.css', array(), $this->version, 'all');
    }

    if (!wp_style_is($this->plugin_name . '-tooltipster', 'enqueued')) {
			wp_enqueue_style($this->plugin_name . '-tooltipster', RCPWPH_URL . 'assets/css/tooltipster.min.css', array(), $this->version, 'all');
    }

    if (!wp_style_is($this->plugin_name . '-owl', 'enqueued')) {
			wp_enqueue_style($this->plugin_name . '-owl', RCPWPH_URL . 'assets/css/owl.min.css', array(), $this->version, 'all');
    }

		wp_enqueue_style($this->plugin_name, RCPWPH_URL . 'assets/css/rcpwph.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
    if(!wp_script_is($this->plugin_name . '-select2', 'enqueued')) {
			wp_enqueue_script($this->plugin_name . '-select2', RCPWPH_URL . 'assets/js/select2.min.js', ['jquery'], $this->version, false);
    }

    if(!wp_script_is($this->plugin_name . '-trumbowyg', 'enqueued')) {
			wp_enqueue_script($this->plugin_name . '-trumbowyg', RCPWPH_URL . 'assets/js/trumbowyg.min.js', ['jquery'], $this->version, false);
    }

    if(!wp_script_is($this->plugin_name . '-fancybox', 'enqueued')) {
			wp_enqueue_script($this->plugin_name . '-fancybox', RCPWPH_URL . 'assets/js/fancybox.min.js', ['jquery'], $this->version, false);
    }

    if(!wp_script_is($this->plugin_name . '-tooltipster', 'enqueued')) {
			wp_enqueue_script($this->plugin_name . '-tooltipster', RCPWPH_URL . 'assets/js/tooltipster.min.js', ['jquery'], $this->version, false);
    }

    if(!wp_script_is($this->plugin_name . '-owl', 'enqueued')) {
			wp_enqueue_script($this->plugin_name . '-owl', RCPWPH_URL . 'assets/js/owl.min.js', ['jquery'], $this->version, false);
    }

		wp_enqueue_script($this->plugin_name, RCPWPH_URL . 'assets/js/rcpwph.js', ['jquery'], $this->version, false);

		wp_localize_script($this->plugin_name, 'rcpwph_ajax', [
			'ajax_url' => admin_url('admin-ajax.php'),
			'ajax_nonce' => wp_create_nonce('rcpwph-nonce'),
		]);

		wp_localize_script($this->plugin_name, 'rcpwph_trumbowyg', [
			'path' => RCPWPH_URL . 'assets/media/trumbowyg-icons.svg',
		]);

		wp_localize_script('rcpwph', 'rcpwph_i18n', [
			'an_error_has_occurred' => esc_html(__('An error has occurred. Please try again in a few minutes.', 'rcpwph')),
			'user_unlogged' => esc_html(__('Please create a new user or login to save the information.', 'rcpwph')),
			'saved_successfully' => esc_html(__('Saved successfully', 'rcpwph')),
			'edit_image' => esc_html(__('Edit image', 'rcpwph')),
			'edit_images' => esc_html(__('Edit images', 'rcpwph')),
			'select_image' => esc_html(__('Select image', 'rcpwph')),
			'select_images' => esc_html(__('Select images', 'rcpwph')),
			'edit_video' => esc_html(__('Edit video', 'rcpwph')),
			'edit_videos' => esc_html(__('Edit videos', 'rcpwph')),
			'select_video' => esc_html(__('Select video', 'rcpwph')),
			'select_videos' => esc_html(__('Select videos', 'rcpwph')),
			'edit_audio' => esc_html(__('Edit audio', 'rcpwph')),
			'edit_audios' => esc_html(__('Edit audios', 'rcpwph')),
			'select_audio' => esc_html(__('Select audio', 'rcpwph')),
			'select_audios' => esc_html(__('Select audios', 'rcpwph')),
			'edit_file' => esc_html(__('Edit file', 'rcpwph')),
			'edit_files' => esc_html(__('Edit files', 'rcpwph')),
			'select_file' => esc_html(__('Select file', 'rcpwph')),
			'select_files' => esc_html(__('Select files', 'rcpwph')),
			'ordered_element' => esc_html(__('Ordered element', 'rcpwph')),
		]);
	}
}
