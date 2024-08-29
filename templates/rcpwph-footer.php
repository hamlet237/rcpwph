<?php
/**
 * Provide a common footer area view for the plugin
 *
 * This file is used to markup the common footer facing aspects of the plugin.
 *
 * @link       wordpress-heroes.com/
 * @since      1.0.0
 *
 * @package    RCPWPH
 * @subpackage RCPWPH/common/templates
 */

  if (!defined('ABSPATH')) exit; // Exit if accessed directly

  $rcpwph_data = $GLOBALS['rcpwph_data'];
?>

<div id="rcpwph-main-message" class="rcpwph-main-message rcpwph-display-none-soft rcpwph-z-index-top" data-user-id="<?php echo esc_attr($rcpwph_data['user_id']); ?>" data-post-id="<?php echo esc_attr($rcpwph_data['post_id']); ?>">
  <span id="rcpwph-main-message-span"></span><i class="material-icons-outlined rcpwph-vertical-align-bottom rcpwph-ml-20 rcpwph-cursor-pointer rcpwph-color-white rcpwph-close-icon">close</i>

  <div id="rcpwph-bar-wrapper">
  	<div id="rcpwph-bar"></div>
  </div>
</div>
