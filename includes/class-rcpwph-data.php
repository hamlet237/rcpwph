<?php
/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin so that it is ready for translation.
 *
 * @link       wordpress-heroes.com/
 * @since      1.0.0
 * @package    RCPWPH
 * @subpackage RCPWPH/includes
 * @author     wordpress-heroes <info@wordpress-heroes.com>
 */
class RCPWPH_Data {
	/**
	 * The main data array.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      RCPWPH_Data    $data    Empty array.
	 */
	protected $data = [];

	/**
	 * Load the plugin most usefull data.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_data() {
		$this->data['user_id'] = get_current_user_id();

		if (is_admin()) {
			$this->data['post_id'] = !empty($GLOBALS['_REQUEST']['post']) ? $GLOBALS['_REQUEST']['post'] : 0;
		}else{
			$this->data['post_id'] = get_the_ID();
		}

		$GLOBALS['rcpwph_data'] = $this->data;
	}

	/**
	 * Flus wp rewrite rules.
	 *
	 * @since    1.0.0
	 */
	public function flush_rewrite_rules() {
    if (get_option('rcpwph_options_changed')) {
      flush_rewrite_rules();
      update_option('rcpwph_options_changed', false);
    }
  }
}