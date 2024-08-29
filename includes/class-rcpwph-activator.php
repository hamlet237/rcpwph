<?php
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @link       wordpress-heroes.com/
 * @since      1.0.0
 * @package    rcpwph
 * @subpackage rcpwph/includes
 * @author     wordpress-heroes <info@wordpress-heroes.com>
 */
class RCPWPH_Activator {
	/**
   * Plugin activation functions
   *
   * Functions to be loaded on plugin activation. This actions creates roles, options and post information attached to the plugin.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
    $post_functions = new RCPWPH_Functions_Post();
    $attachment_functions = new RCPWPH_Functions_Attachment();

    add_role('rcpwph_role_manager', esc_html(__('Recipes manager - WPH', 'rcpwph')));

    $role_admin = get_role('administrator');
    $role_recipes_manager = get_role('rcpwph_role_manager');

    $role_recipes_manager->add_cap('upload_files'); 
    $role_recipes_manager->add_cap('read'); 

    foreach (RCPWPH_ROLE_CAPABILITIES as $cap_key => $cap_value) {
      $role_admin->add_cap($cap_value); 
      $role_recipes_manager->add_cap($cap_value); 
    }

    if (empty(get_posts(['fields' => 'ids', 'numberposts' => -1, 'post_type' => 'rcpwph_recipe', 'post_status' => 'any', ]))) {
      $rcpwph_ingredients_name = [__('2 cups of trust', 'rcpwph'), __('1 cup of respect', 'rcpwph'), __('1/2 cup of understanding', 'rcpwph'), __('1/4 cup of patience', 'rcpwph'), __('1 dash of humor', 'rcpwph'), __('1 dash of joy', 'rcpwph'), __('1 dash of adventure', 'rcpwph'), __('1 dash of tenderness', 'rcpwph'), __('2 hearts brimming with love', 'rcpwph'), ];
      $rcpwph_steps_name = [__('Preparing step', 'rcpwph'), __('Mixing', 'rcpwph'), __('Dashing', 'rcpwph'), __('Hearting', 'rcpwph'), __('Baking', 'rcpwph'), ];
      $rcpwph_steps_description = [__('Preheat the oven to low heat. Love cooks best over a slow flame, with patience and care.', 'rcpwph'), __('In a large bowl, mix together the trust, respect, understanding, and patience. These are the foundations of a strong and lasting relationship.', 'rcpwph'), __('Add a dash of humor, joy, adventure, and tenderness. Life is tastier with a touch of fun and spontaneity.', 'rcpwph'), __('Place the two hearts in the center of the mixture. Love is the main ingredient in this dish.', 'rcpwph'), __('Bake for a lifetime, stirring occasionally. Love is a lifelong journey, full of ups and downs, but it is always worth it.', 'rcpwph'), ];
      $rcpwph_steps_time = ['00:23', '00:30', '00:15', '00:15', '01:00', ];
      $rcpwph_time = '02:23';
      $rcpwph_suggestions = esc_html(__('<p>To serve, garnish with <strong>kind words, loving gestures, and small details</strong>. Share with your loved one and savor the delicious experience of true love.&nbsp;</p><p><ul><li><strong>Don\'t be afraid to experiment</strong>. Add your own special ingredients to create a unique dish that represents your love.&nbsp;</li><li><strong>Use fresh, high-quality ingredients</strong>. True love is a priceless treasure, treat it with care.&nbsp;</li><li><strong>Serve with a smile and an open heart</strong>. Love is best enjoyed when shared.</li></ul></p><p>Enjoy your creation!</p>', 'rcpwph'));
      $rcpwph_post_content = __('<!-- wp:heading {"level":3,"className":"wp-block-heading"} --><h3 class="wp-block-heading">A Feast for the Heart: A Culinary Journey of Love</h3><!-- /wp:heading --><!-- wp:paragraph --><p>To create an original love dish, start with a solid foundation of trust, respect, understanding and patience. Season with humor, joy, adventure and tenderness to bring life to life. Place two hearts overflowing with love in the center. Simmer throughout the process, stirring occasionally to cope with the ups and downs. Garnish with kind words, loving gestures and small details. Share with your loved one and enjoy the delicious taste of true love.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Remember that there is no fixed recipe for Love, everyone creates it in their own way. Experiment, use fresh, high-quality ingredients, and serve with a smile and an open heart. Let love be the spice that adds flavor to your life!</p><!-- /wp:paragraph -->', 'rcpwph');

      $rcpwph_title = __('Love recipe', 'rcpwph');
      $rcpwph_id = $post_functions->insert_post(esc_html($rcpwph_title), $rcpwph_post_content, '', sanitize_title(esc_html($rcpwph_title)), 'rcpwph_recipe', 'publish', 1);

      update_post_meta($rcpwph_id, 'rcpwph_ingredients_name', $rcpwph_ingredients_name);
      update_post_meta($rcpwph_id, 'rcpwph_steps_name', $rcpwph_steps_name);
      update_post_meta($rcpwph_id, 'rcpwph_steps_description', $rcpwph_steps_description);
      update_post_meta($rcpwph_id, 'rcpwph_steps_time', $rcpwph_steps_time);
      update_post_meta($rcpwph_id, 'rcpwph_time', $rcpwph_time);
      update_post_meta($rcpwph_id, 'rcpwph_suggestions', $rcpwph_suggestions);

      if (class_exists('Polylang')) {
        $language = pll_default_language();
        pll_set_post_language($rcpwph_id, $language);
        $locales = pll_languages_list(['hide_empty' => false]);

        if (!empty($locales)) {
          foreach ($locales as $locale) {
            if ($locale != $language) {
              $rcpwph_title = __('Love recipe', 'rcpwph') . ' ' . $locale;
              $translated_rcpwph_id = $post_functions->insert_post(esc_html($rcpwph_title), $rcpwph_post_content, '', sanitize_title(esc_html($rcpwph_title)), 'rcpwph_recipe', 'publish', 1);

              update_post_meta($translated_rcpwph_id, 'rcpwph_ingredients_name', $rcpwph_ingredients_name);
              update_post_meta($translated_rcpwph_id, 'rcpwph_steps_name', $rcpwph_steps_name);
              update_post_meta($translated_rcpwph_id, 'rcpwph_steps_description', $rcpwph_steps_description);
              update_post_meta($translated_rcpwph_id, 'rcpwph_steps_time', $rcpwph_steps_time);
              update_post_meta($translated_rcpwph_id, 'rcpwph_time', $rcpwph_time);
              update_post_meta($translated_rcpwph_id, 'rcpwph_suggestions', $rcpwph_suggestions);

              pll_set_post_language($translated_rcpwph_id, $locale);

              pll_save_post_translations([
                $language => $rcpwph_id,
                $locale => $translated_rcpwph_id,
              ]);
            }
          }
        }
      }
    }

    update_option('rcpwph_options_changed', true);
  }
}