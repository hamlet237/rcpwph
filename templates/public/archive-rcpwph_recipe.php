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

	if(wp_is_block_theme()) {
  	wp_head();
		block_template_part('header');
	}else{
  	get_header();
	}

	if (class_exists('Polylang')) {
		$recipes = get_posts(['numberposts' => -1, 'fields' => 'ids', 'post_type' => 'rcpwph_recipe', 'lang' => pll_current_language(), 'post_status' => ['publish'], 'order' => 'DESC', ]);
	}else{
		$recipes = get_posts(['numberposts' => -1, 'fields' => 'ids', 'post_type' => 'rcpwph_recipe', 'post_status' => ['publish'], 'order' => 'DESC', ]);
	}
?>

<div class="rcpwph-wrapper rcpwph-recipe-wrapper">
  <h1 class="rcpwph-p-20"><?php esc_html_e('Recipes', 'rcpwph'); ?></h1>
	
	<div class="rcpwph-display-table rcpwph-width-100-percent rcpwph-mt-50 rcpwph-mb-50">
		<?php if (!empty($recipes)): ?>
	  	<?php foreach ($recipes as $recipe_id): ?>
				<div class="rcpwph-display-inline-table rcpwph-width-33-percent rcpwph-tablet-display-block rcpwph-tablet-width-100-percent rcpwph-p-20 rcpwph-text-align-center rcpwph-vertical-align-top">
					<div class="rcpwph-mb-30">
						<a href="<?php echo esc_url(get_permalink($recipe_id)); ?>">
							<?php if (has_post_thumbnail($recipe_id)): ?>
						    <?php echo get_the_post_thumbnail($recipe_id, 'full', ['class' => 'rcpwph-border-radius-20 rcpwph-width-100-percent']); ?>
						  <?php else: ?>
						  	<img src="<?php echo esc_url(RCPWPH_URL . 'assets/media/rcpwph-image.jpg'); ?>" class="rcpwph-border-radius-20 rcpwph-width-100-percent">
						  <?php endif ?>
						</a>
					</div>

					<a href="<?php echo esc_url(get_permalink($recipe_id)); ?>"><h4 class="rcpwph-color-main-hover rcpwph-mb-20"><?php echo esc_html(get_the_title($recipe_id)); ?></h4></a>

					<?php if (current_user_can('administrator') || current_user_can('rcpwph_role_manager')): ?>
		  			<a href="<?php echo esc_url(admin_url('post.php?post=' . $recipe_id . '&action=edit')); ?>"><i class="material-icons-outlined rcpwph-font-size-30 rcpwph-vertical-align-middle rcpwph-mr-10 rcpwph-color-main-0">edit</i> <?php esc_html_e('Edit recipe', 'rcpwph'); ?></a>
		  		<?php endif ?>
				</div>
	  	<?php endforeach ?>
		<?php endif ?>

		<?php if (current_user_can('administrator') || current_user_can('rcpwph_role_manager')): ?>
			<div class="rcpwph-display-inline-table rcpwph-width-33-percent rcpwph-tablet-display-block rcpwph-tablet-width-100-percent rcpwph-p-20 rcpwph-text-align-center rcpwph-vertical-align-top">
				<div class="rcpwph-mb-30">
					<a href="<?php echo esc_url(admin_url('post-new.php?post_type=rcpwph_recipe')); ?>">
						<img src="<?php echo esc_url(RCPWPH_URL . 'assets/media/rcpwph-image.jpg'); ?>" class="rcpwph-border-radius-20 rcpwph-width-100-percent rcpwph-filter-grayscale">
					</a>
				</div>

				<a href="<?php echo esc_url(admin_url('post-new.php?post_type=rcpwph_recipe')); ?>"><h4 class="rcpwph-color-main-hover rcpwph-mb-20"><i class="material-icons-outlined rcpwph-vertical-align-middle rcpwph-mr-10">add</i> <?php esc_html_e('Add recipe', 'rcpwph'); ?></h4></a>
			</div>
		<?php endif ?>
	</div>
</div>

<?php 
	if(wp_is_block_theme()) {
  	wp_head();
		block_template_part('footer');
	}else{
  	get_footer();
	}
?>