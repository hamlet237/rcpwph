<?php
/**
 * Load the plugin no private Ajax functions.
 *
 * Load the plugin no private Ajax functions to be executed in background.
 *
 * @link       wordpress-heroes.com/
 * @since      1.0.0
 * @package    RCPWPH
 * @subpackage RCPWPH/includes
 * @author     wordpress-heroes <info@wordpress-heroes.com>
 */
class RCPWPH_Ajax_Nopriv {
	/**
	 * Load the plugin templates.
	 *
	 * @since    1.0.0
	 */
	public function rcpwph_ajax_nopriv_server() {
    if (array_key_exists('rcpwph_ajax_nopriv_type', $_POST)) {
      if (array_key_exists('ajax_nonce', $_POST) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['ajax_nonce'])), 'rcpwph-nonce')) {
        echo wp_json_encode(['error_key' => 'rcpwph_nonce_error', ]);exit();
      }

  		$rcpwph_ajax_nopriv_type = RCPWPH_Forms::sanitizer($_POST['rcpwph_ajax_nopriv_type']);
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

      switch ($rcpwph_ajax_nopriv_type) {
        case 'rcpwph_form_save':
          $rcpwph_form_type = $_POST['rcpwph_form_type'];

          if (!empty($key_value) && !empty($rcpwph_form_type)) {
            $rcpwph_form_id = $_POST['rcpwph_form_id'];
            $user_id = $_POST['rcpwph_form_user_id'];
            $post_id = $_POST['rcpwph_form_post_id'];

            if (($rcpwph_form_type == 'user' && empty($user_id)) || ($rcpwph_form_type == 'post' && empty($post_id)) || ($rcpwph_form_type == 'option' && !is_user_logged_in())) {
              session_start();

              $_SESSION['wph_form'] = [];
              $_SESSION['wph_form'][$rcpwph_form_id] = [];
              $_SESSION['wph_form'][$rcpwph_form_id]['form_type'] = $rcpwph_form_type;
              $_SESSION['wph_form'][$rcpwph_form_id]['values'] = $key_value;

              if (!empty($post_id)) {
                $_SESSION['wph_form'][$rcpwph_form_id]['post_id'] = $post_id;
              }

              echo wp_json_encode(['error_key' => 'rcpwph_form_save_error_unlogged', ]);exit();
            }else{
              foreach ($key_value as $key => $value) {
                if (!in_array($key, ['action', 'rcpwph_ajax_nopriv_type'])) {
                  switch ($rcpwph_form_type) {
                    case 'user':
                      update_user_meta($user_id, $key, $value);
                      break;
                    case 'post':
                      update_post_meta($post_id, $key, $value);
                      break;
                    case 'option':
                      update_option($key, $value);
                      break;
                  }
                }
              }

              if ($rcpwph_form_type == 'option') {
                update_option('rcpwph_form_changed', true);
              }

              switch ($rcpwph_form_type) {
                case 'user':
                  do_action('rcpwph_form_save', $user_id, $key_value);
                  break;
                case 'post':
                  do_action('rcpwph_form_save', $post_id, $key_value);
                  break;
                case 'option':
                  do_action('rcpwph_form_save', 0, $key_value);
                  break;
              }

              echo wp_json_encode(['error_key' => '', ]);exit();
            }
          }else{
            echo wp_json_encode(['error_key' => 'rcpwph_form_save_error', ]);exit();
          }
          break;
      }

      echo wp_json_encode(['error_key' => '', ]);exit();
  	}
  }
}