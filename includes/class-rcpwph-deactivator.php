<?php

/**
 * Fired during plugin deactivation
 *
 * @link       wordpress-heroes.com/
 * @since      1.0.0
 *
 * @package    RCPWPH
 * @subpackage RCPWPH/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    RCPWPH
 * @subpackage RCPWPH/includes
 * @author     wordpress-heroes <info@wordpress-heroes.com>
 */
class RCPWPH_Deactivator {

	/**
	 * Plugin deactivation functions
	 *
	 * Functions to be loaded on plugin deactivation. This actions remove roles, options and post information attached to the plugin.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		$plugin_post_type_recipe = new RCPWPH_Post_Type_Recipe();
		
		if (get_option('rcpwph_options_remove') == 'on') {
      remove_role('rcpwph_role_manager');

      $rcpwph = get_posts(['fields' => 'ids', 'numberposts' => -1, 'post_type' => 'rcpwph_recipe', 'post_status' => 'any', ]);

      if (!empty($rcpwph)) {
        foreach ($rcpwph as $recipe_id) {
          wp_delete_post($recipe_id, true);
        }
      }

      foreach ($plugin_post_type_recipe->get_fields() as $rcpwph_option) {
        delete_option($rcpwph_option['id']);
      }
    }

    update_option('rcpwph_options_changed', true);
	}
}