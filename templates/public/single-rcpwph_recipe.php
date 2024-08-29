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

	global $post;
	$post_id = $post->ID;

	$ingredients = get_post_meta($post_id, 'rcpwph_ingredients_name', true);
	$steps = get_post_meta($post_id, 'rcpwph_steps_name', true);
	$steps_description = get_post_meta($post_id, 'rcpwph_steps_description', true);
	$steps_time = get_post_meta($post_id, 'rcpwph_steps_time', true);
	$steps_total_time = get_post_meta($post_id, 'rcpwph_time', true);
	$rcpwph_images = explode(',', get_post_meta($post_id, 'rcpwph_images', true));
	$suggestions = get_post_meta($post_id, 'rcpwph_suggestions', true);
	$steps_count = (!empty($steps) && !empty($steps[0]) && is_array($steps) && count($steps) > 0) ? count($steps) : 0;
	$ingredients_count = (!empty($ingredients) && !empty($ingredients[0]) && is_array($ingredients) && count($ingredients) > 0) ? count($ingredients) : 0;

	function rcpwph_minutes($time){
		if ($time) {
			$time = explode(':', $time);
			return ($time[0] * 60) + ($time[1]);
		}else{
			return 0;
		}
	}
?>

<div id="rcpwph-recipe-wrapper" class="rcpwph-wrapper rcpwph-recipe-wrapper" data-rcpwph-ingredients-count="<?php echo intval($ingredients_count); ?>" data-rcpwph-steps-count="<?php echo intval($steps_count); ?>">
  <div class="rcpwph-display-table rcpwph-width-100-percent">
  	<div class="rcpwph-display-inline-table rcpwph-width-50-percent rcpwph-tablet-display-block rcpwph-tablet-width-100-percent">
  		<a href="<?php echo esc_url(get_post_type_archive_link('rcpwph_recipe')); ?>"><i class="material-icons-outlined rcpwph-font-size-30 rcpwph-vertical-align-middle rcpwph-mr-10 rcpwph-color-main-0">keyboard_arrow_left</i> <?php esc_html_e('More recipes', 'rcpwph'); ?></a>
  	</div>
  	<div class="rcpwph-display-inline-table rcpwph-width-50-percent rcpwph-tablet-display-block rcpwph-tablet-width-100-percent rcpwph-text-align-right">
  		<?php if (current_user_can('administrator') || current_user_can('rcpwph_role_manager')): ?>
  			<a href="<?php echo esc_url(admin_url('post.php?post=' . $post_id . '&action=edit')); ?>"><i class="material-icons-outlined rcpwph-font-size-30 rcpwph-vertical-align-middle rcpwph-mr-10 rcpwph-color-main-0">edit</i> <?php esc_html_e('Edit recipe', 'rcpwph'); ?></a>
  		<?php endif ?>
  	</div>
  </div>
	
	<h1 class="rcpwph-text-align-center rcpwph-mb-50"><?php echo esc_html(get_the_title($post_id)); ?></h1>

	<div class="rcpwph-display-block rcpwph-width-100-percent rcpwph-mb-30">
		<div class="rcpwph-display-inline-table rcpwph-width-50-percent rcpwph-tablet-display-block rcpwph-tablet-width-100-percent rcpwph-mb-30 rcpwph-vertical-align-top">
			<div class="rcpwph-image rcpwph-p-20 rcpwph-mb-30">
				<?php if (has_post_thumbnail($post_id)): ?>
			    <?php echo get_the_post_thumbnail($post_id, 'full', ['class' => 'rcpwph-border-radius-20']); ?>
			  <?php else: ?>
					<img src="<?php echo esc_url(RCPWPH_URL . 'assets/media/rcpwph-image.jpg'); ?>" class="rcpwph-border-radius-20 rcpwph-width-100-percent">
			  <?php endif ?>
			</div>

			<?php if (!empty($rcpwph_images)): ?>
				<div class="rcpwph-carousel rcpwph-carousel-main-images">
	        <div class="owl-carousel owl-theme">
	          <?php if (!empty($rcpwph_images)): ?>
	          	<?php if (has_post_thumbnail($post_id)): ?>
		          	<div class="rcpwph-image rcpwph-cursor-grab">
	                <a href="#" data-fancybox="gallery" data-src="<?php echo esc_url(get_the_post_thumbnail_url($post_id, 'full', ['class' => 'rcpwph-border-radius-10'])); ?>"><?php echo esc_html(get_the_post_thumbnail($post_id, 'thumbnail', ['class' => 'rcpwph-border-radius-10'])); ?></a>  
	              </div>
						  <?php endif ?>

	            <?php foreach ($rcpwph_images as $image_id): ?>
              	<?php if (!empty($image_id)): ?>
	              	<div class="rcpwph-image rcpwph-cursor-grab">
	                	<a href="#" data-fancybox="gallery" data-src="<?php echo esc_url(wp_get_attachment_image_src($image_id, 'full')[0]); ?>"><?php echo esc_html(wp_get_attachment_image($image_id, 'thumbnail', false, ['class' => 'rcpwph-border-radius-10'])); ?></a>  
	              	</div>
              	<?php endif ?>
	            <?php endforeach ?>
	          <?php endif ?>
	        </div>
	      </div>
			<?php endif ?>
		</div>

		<div class="rcpwph-display-inline-table rcpwph-width-50-percent rcpwph-tablet-display-block rcpwph-tablet-width-100-percent rcpwph-mb-30 rcpwph-vertical-align-top rcpwph-mb-30">
			<div class="rcpwph-recipe-content rcpwph-p-20">
				<?php echo wp_kses_post(str_replace(']]>', ']]&gt;', apply_filters('the_content', get_post($post_id)->post_content))); ?>
			</div>
		</div>
	</div>

	<div class="rcpwph-display-table rcpwph-width-100-percent rcpwph-mb-50">
		<div class="rcpwph-display-inline-table rcpwph-width-50-percent rcpwph-tablet-display-block rcpwph-tablet-width-100-percent rcpwph-mb-30 rcpwph-vertical-align-top">
			<div class="rcpwph-ingredients rcpwph-p-20">
				<?php if ($ingredients_count): ?>
					<h2 class="rcpwph-mb-30"><?php esc_html_e('Ingredients', 'rcpwph'); ?></h2>
					<ul>
						<?php foreach ($ingredients as $ingredient): ?>
							<li class="rcpwph-mb-20 rcpwph-font-size-20 rcpwph-list-style-none">
								<div class="rcpwph-display-table rcpwph-width-100-percent">
									<div class="rcpwph-display-inline-table rcpwph-width-90-percent">
										<?php echo esc_html($ingredient); ?>
									</div>
									<div class="rcpwph-display-inline-table rcpwph-width-10-percent">
										<i class="material-icons-outlined rcpwph-ingredient-checkbox rcpwph-cursor-pointer rcpwph-vertical-align-middle rcpwph-font-size-30">radio_button_unchecked</i>
									</div>
								</div>
							</li>
						<?php endforeach ?>
					</ul>
				<?php endif ?>
			</div>
		</div>

		<div class="rcpwph-display-inline-table rcpwph-width-50-percent rcpwph-tablet-display-block rcpwph-tablet-width-100-percent rcpwph-mb-30 rcpwph-vertical-align-top">
			<div class="rcpwph-steps rcpwph-p-20 rcpwph-mb-50">
				<?php if ($steps_count): ?>
					<div class="rcpwph-mb-30">
						<div class="rcpwph-display-table rcpwph-width-100-percent">
							<div class="rcpwph-display-inline-table rcpwph-width-80-percent">
								<h2><?php esc_html_e('Elaboration steps', 'rcpwph'); ?></h2>
							</div>
							<div class="rcpwph-display-inline-table rcpwph-width-20-percent">
								<a href="#" class="rcpwph-popup-player-btn" data-fancybox data-src="#rcpwph-popup-player"><i class="material-icons-outlined rcpwph-mr-10 rcpwph-font-size-50 rcpwph-float-right rcpwph-vertical-align-middle rcpwph-tooltip" title="<?php esc_html_e('Play recipe', 'rcpwph'); ?>">play_circle_outline</i></a>
							</div>
						</div>
								
						<?php if (!empty($steps_total_time)): ?>
							<div class="rcpwph-text-align-right">
								<i class="material-icons-outlined rcpwph-mr-10 rcpwph-font-size-10 rcpwph-vertical-align-middle">timer</i> <small><strong><?php esc_html_e('Total time', 'rcpwph'); ?></strong> <?php echo esc_html($steps_total_time); ?> (<?php esc_html_e('hours', 'rcpwph'); ?>:<?php esc_html_e('minutes', 'rcpwph'); ?>)</small>
							</div>
						<?php endif ?>
					</div>

					<ol>
						<?php foreach ($steps as $index => $step): ?>
							<li class="rcpwph-mb-50">
								<div class="rcpwph-display-table rcpwph-width-100-percent">
									<div class="rcpwph-display-inline-table rcpwph-width-80-percent">
										<?php if (!empty($step)): ?>
											<h4 class="rcpwph-mb-10"><?php echo esc_html($step); ?></h4>
										<?php endif ?>
									</div>

									<div class="rcpwph-display-inline-table rcpwph-width-20-percent">
										<h5 class="rcpwph-mb-10"><i class="material-icons-outlined rcpwph-mr-10 rcpwph-font-size-10 rcpwph-vertical-align-middle">timer</i><?php echo !empty($steps_time[$index]) ? esc_html($steps_time[$index]) : '00:00'; ?></h5>
									</div>
								</div>

								<?php if (!empty($steps_description[$index])): ?>
									<p><?php echo esc_html($steps_description[$index]); ?></p>
								<?php endif ?>
							</li>
						<?php endforeach ?>
					</ol>

					<div id="rcpwph-popup-player" class="rcpwph-display-none-soft">
						<div id="rcpwph-popup-steps" class="rcpwph-mb-30" data-rcpwph-current-step="1">
							<?php foreach ($steps as $index => $step): ?>
								<div class="rcpwph-player-step <?php echo $index != 0 ? 'rcpwph-display-none-soft' : ''; ?>" data-rcpwph-step="<?php echo number_format($index + 1); ?>">
									<div class="rcpwph-display-table rcpwph-width-100-percent">
										<div class="rcpwph-display-inline-table rcpwph-width-80-percent rcpwph-vertical-align-top">
											<?php if (!empty($step)): ?>
												<h3 class="rcpwph-mb-10"><?php echo esc_html($step); ?></h3>
											<?php endif ?>
										</div>
										<div class="rcpwph-display-inline-table rcpwph-width-20-percent rcpwph-vertical-align-top  rcpwph-text-align-right">
											<h3>
												<i class="material-icons-outlined rcpwph-display-inline rcpwph-player-timer-icon rcpwph-mr-10 rcpwph-font-size-30 rcpwph-vertical-align-middle">timer</i> 
												<span class="rcpwph-player-timer rcpwph-display-inline"><?php echo number_format(rcpwph_minutes($steps_time[$index])); ?></span>'
											</h3>
										</div>
									</div>

									<?php if (!empty($steps_description[$index])): ?>
										<div class="rcpwph-step-description"><?php echo esc_html($steps_description[$index]); ?></div>
									<?php endif ?>
								</div>
							<?php endforeach ?>
						</div>

						<div class="rcpwph-display-table rcpwph-width-100-percent">
							<div class="rcpwph-display-inline-table rcpwph-width-50-percent rcpwph-text-align-center rcpwph-mb-20">
								<a href="#" class="rcpwph-steps-prev rcpwph-display-none"><?php esc_html_e('Previous', 'rcpwph'); ?></a>
							</div>
							<div class="rcpwph-display-inline-table rcpwph-width-50-percent rcpwph-text-align-center rcpwph-mb-20">
								<a href="#" class="rcpwph-btn rcpwph-btn-mini rcpwph-steps-next"><?php esc_html_e('Next', 'rcpwph'); ?></a>
							</div>
						</div>
					</div>
				<?php endif ?>
			</div>

			<?php if (!empty($suggestions)): ?>
				<div class="rcpwph-suggestions rcpwph-mb-50">
					<div class="rcpwph-text-align-center rcpwph-mb-10"><i class="material-icons-outlined rcpwph-font-size-50 rcpwph-tooltip" title="<?php esc_html_e('Suggestions', 'rcpwph'); ?>">lightbulb</i></div>

					<?php echo wp_kses_post(wp_specialchars_decode($suggestions)); ?>
				</div>
			<?php endif ?>
		</div>
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