<?php
/**
 * Platform shortcodes.
 *
 * This class defines all shortcodes of the platform.
 *
 * @link       wordpress-heroes.com/
 * @since      1.0.0
 * @package    RCPWPH
 * @subpackage RCPWPH/includes
 * @author     wordpress-heroes <info@wordpress-heroes.com>
 */
class RCPWPH_Shortcodes {
	/**
	 * Manage the shortcodes in the platform.
	 *
	 * @since    1.0.0
	 */
	public function rcpwph_recipe($atts) {
    $a = extract(shortcode_atts([
      'user_id' => 0,
      'post_id' => 0,
    ], $atts));

    ?>
      <div class="rcpwph-shortcode-example">
      	Shortcode example
      	<p>User id: <?php echo intval($user_id); ?></p>
      	<p>Post id: <?php echo intval($post_id); ?></p>
      </div>
    <?php
	}
}