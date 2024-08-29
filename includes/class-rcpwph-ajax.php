<?php
/**
 * Load the plugin Ajax functions.
 *
 * Load the plugin Ajax functions to be executed in background.
 *
 * @link       wordpress-heroes.com/
 * @since      1.0.0
 * @package    RCPWPH
 * @subpackage RCPWPH/includes
 * @author     wordpress-heroes <info@wordpress-heroes.com>
 */
class RCPWPH_Ajax {
	/**
	 * Load ajax functions.
	 *
	 * @since    1.0.0
	 */
	public function rcpwph_ajax_server() {
    if (array_key_exists('rcpwph_ajax_type', $_POST)) {
      if (array_key_exists('ajax_nonce', $_POST) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['ajax_nonce'])), 'rcpwph-nonce')) {
        echo wp_json_encode(['error_key' => 'rcpwph_nonce_error', ]);exit();
      }

  		$rcpwph_ajax_type = RCPWPH_Forms::sanitizer($_POST['rcpwph_ajax_type']);
      $ajax_keys = $_POST['ajax_keys'];
      $key_value = [];

      if (!empty($ajax_keys)) {
        foreach ($ajax_keys as $key) {
          if (strpos($key['id'], '[]') !== false) {
            $clear_key = str_replace('[]', '', $key['id']);
            ${$clear_key} = $key_value[$clear_key] = [];

            if (!empty($_POST[$clear_key])) {
              foreach ($_POST[$clear_key] as $multi_key => $multi_value) {
                ${$clear_key}[$multi_key] = RCPWPH_Forms::sanitizer($_POST[$clear_key][$multi_key], $key['node'], $key['type']);
                $key_value[$clear_key][$multi_key] = RCPWPH_Forms::sanitizer($_POST[$clear_key][$multi_key], $key['node'], $key['type']);
              }
            }else{
              ${$clear_key} = '';
              $key_value[$clear_key][$multi_key] = '';
            }
          }else{
            ${$key['id']} = RCPWPH_Forms::sanitizer($_POST[$key['id']], $key['node'], $key['type']);
            $key_value[$key['id']] = RCPWPH_Forms::sanitizer($_POST[$key['id']], $key['node'], $key['type']);
          }
        }
      }

      switch ($rcpwph_ajax_type) {
        case 'rcpwph_options_save':
          if (!empty($key_value)) {
            foreach ($key_value as $key => $value) {
              if (!in_array($key, ['action', 'rcpwph_ajax_type'])) {
                update_option($key, $value);
              }
            }

            update_option('rcpwph_options_changed', true);
            echo wp_json_encode(['error_key' => '', ]);exit();
          }else{
            echo wp_json_encode(['error_key' => 'rcpwph_options_save_error', ]);exit();
          }
          break;
      }

      echo wp_json_encode(['error_key' => 'rcpwph_save_error', ]);exit();
    }
	}
}