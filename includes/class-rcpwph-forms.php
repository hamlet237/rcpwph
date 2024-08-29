<?php
/**
 * Fired from activate() function.
 *
 * This class defines all post types necessary to run during the plugin's life cycle.
 *
 * @link       wordpress-heroes.com/
 * @since      1.0.0
 * @package    RCPWPH
 * @subpackage RCPWPH/includes
 * @author     wordpress-heroes <info@wordpress-heroes.com>
 */
class RCPWPH_Forms {
	/**
	 * Plaform forms.
	 *
	 * @since    1.0.0
	 */

  public static function input_builder($rcpwph_input, $rcpwph_type, $rcpwph_id = 0, $rcpwph_disabled_fields = false, $rcpwph_meta_array = false, $rcpwph_array_index = 0) {
    if ($rcpwph_meta_array) {
      switch ($rcpwph_type) {
        case 'user':
          $user_meta = get_user_meta($rcpwph_id, $rcpwph_input['id'], true);

          if (is_array($user_meta) && array_key_exists($rcpwph_array_index, $user_meta) && !empty($user_meta[$rcpwph_array_index])) {
            $rcpwph_value = $user_meta[$rcpwph_array_index];
          }else{
            if (array_key_exists('value', $rcpwph_input)) {
              $rcpwph_value = $rcpwph_input['value'];
            }else{
              $rcpwph_value = '';
            }
          }
          break;
        case 'post':
          $post_meta = get_post_meta($rcpwph_id, $rcpwph_input['id'], true);

          if (is_array($post_meta) && array_key_exists($rcpwph_array_index, $post_meta) && !empty($post_meta[$rcpwph_array_index])) {
            $rcpwph_value = $post_meta[$rcpwph_array_index];
          }else{
            if (array_key_exists('value', $rcpwph_input)) {
              $rcpwph_value = $rcpwph_input['value'];
            }else{
              $rcpwph_value = '';
            }
          }
          break;
        case 'option':
          $option = get_option($rcpwph_input['id']);

          if (is_array($option) && array_key_exists($rcpwph_array_index, $option) && !empty($option[$rcpwph_array_index])) {
            $rcpwph_value = $option[$rcpwph_array_index];
          }else{
            if (array_key_exists('value', $rcpwph_input)) {
              $rcpwph_value = $rcpwph_input['value'];
            }else{
              $rcpwph_value = '';
            }
          }
          break;
      }
    }else{
      switch ($rcpwph_type) {
        case 'user':
          $user_meta = get_user_meta($rcpwph_id, $rcpwph_input['id'], true);

          if ($user_meta != '') {
            $rcpwph_value = $user_meta;
          }else{
            if (array_key_exists('value', $rcpwph_input)) {
              $rcpwph_value = $rcpwph_input['value'];
            }else{
              $rcpwph_value = '';
            }
          }
          break;
        case 'post':
          $post_meta = get_post_meta($rcpwph_id, $rcpwph_input['id'], true);

          if ($post_meta != '') {
            $rcpwph_value = $post_meta;
          }else{
            if (array_key_exists('value', $rcpwph_input)) {
              $rcpwph_value = $rcpwph_input['value'];
            }else{
              $rcpwph_value = '';
            }
          }
          break;
        case 'option':
          $option = get_option($rcpwph_input['id']);

          if ($option != '') {
            $rcpwph_value = $option;
          }else{
            if (array_key_exists('value', $rcpwph_input)) {
              $rcpwph_value = $rcpwph_input['value'];
            }else{
              $rcpwph_value = '';
            }
          }
          break;
      }
    }

    $rcpwph_parent_block = (!empty($rcpwph_input['parent']) ? 'data-rcpwph-parent="' . $rcpwph_input['parent'] . '"' : '') . ' ' . (!empty($rcpwph_input['parent_option']) ? 'data-rcpwph-parent-option="' . $rcpwph_input['parent_option'] . '"' : '');

    switch ($rcpwph_input['input']) {
      case 'input':
        switch ($rcpwph_input['type']) {
          case 'file':
            ?>
              <?php if (empty($rcpwph_value)): ?>
                <p class="rcpwph-m-10"><?php esc_html_e('No file found', 'wph'); ?></p>
              <?php else: ?>
                <p class="rcpwph-m-10">
                  <a href="<?php echo esc_url(get_post_meta($rcpwph_id, $rcpwph_input['id'], true)['url']); ?>" target="_blank"><?php echo esc_html(basename(get_post_meta($rcpwph_id, $rcpwph_input['id'], true)['url'])); ?></a>
                </p>
              <?php endif ?>
            <?php
            break;
          case 'checkbox':
            ?>
              <label class="rcpwph-switch">
                <input id="<?php echo esc_attr($rcpwph_input['id']); ?>" name="<?php echo esc_attr($rcpwph_input['id']); ?>" class="<?php echo array_key_exists('class', $rcpwph_input) ? esc_attr($rcpwph_input['class']) : ''; ?> rcpwph-checkbox rcpwph-checkbox-switch rcpwph-field" type="<?php echo esc_attr($rcpwph_input['type']); ?>" <?php echo $rcpwph_value == 'on' ? 'checked="checked"' : ''; ?> <?php echo (((array_key_exists('disabled', $rcpwph_input) && $rcpwph_input['disabled'] == 'true') || $rcpwph_disabled_fields) ? 'disabled' : ''); ?> <?php echo ((array_key_exists('required', $rcpwph_input) && $rcpwph_input['required'] == 'true') ? 'required' : ''); ?> <?php echo wp_kses_post($rcpwph_parent_block); ?>>
                <span class="rcpwph-slider rcpwph-round"></span>
              </label>
            <?php
            break;
          case 'range':
            ?>
              <div class="rcpwph-input-range-wrapper">
                <div class="rcpwph-width-100-percent">
                  <?php if (!empty($rcpwph_input['rcpwph_label_min'])): ?>
                    <p class="rcpwph-input-range-label-min"><?php echo esc_html($rcpwph_input['rcpwph_label_min']); ?></p>
                  <?php endif ?>

                  <?php if (!empty($rcpwph_input['rcpwph_label_max'])): ?>
                    <p class="rcpwph-input-range-label-max"><?php echo esc_html($rcpwph_input['rcpwph_label_max']); ?></p>
                  <?php endif ?>
                </div>

                <input type="<?php echo esc_attr($rcpwph_input['type']); ?>" id="<?php echo esc_attr($rcpwph_input['id']) . ((array_key_exists('multiple', $rcpwph_input) && $rcpwph_input['multiple']) ? '[]' : ''); ?>" name="<?php echo esc_attr($rcpwph_input['id']); ?>" class="rcpwph-input-range <?php echo array_key_exists('class', $rcpwph_input) ? esc_attr($rcpwph_input['class']) : ''; ?>" <?php echo ((array_key_exists('required', $rcpwph_input) && $rcpwph_input['required'] == 'true') ? 'required' : ''); ?> <?php echo (((array_key_exists('disabled', $rcpwph_input) && $rcpwph_input['disabled'] == 'true') || $rcpwph_disabled_fields) ? 'disabled' : ''); ?> <?php echo (isset($rcpwph_input['rcpwph_max']) ? 'max=' . esc_attr($rcpwph_input['rcpwph_max']) : ''); ?> <?php echo (isset($rcpwph_input['rcpwph_min']) ? 'min=' . esc_attr($rcpwph_input['rcpwph_min']) : ''); ?> <?php echo (((array_key_exists('step', $rcpwph_input) && $rcpwph_input['step'] != '')) ? 'step="' . esc_attr($rcpwph_input['step']) . '"' : ''); ?> <?php echo (array_key_exists('multiple', $rcpwph_input) && $rcpwph_input['multiple'] ? 'multiple' : ''); ?> value="<?php echo (!empty($rcpwph_input['button_text']) ? esc_html($rcpwph_input['button_text']) : esc_html($rcpwph_value)); ?>"/>
                <h3 class="rcpwph-input-range-output"></h3>
              </div>
            <?php
            break;
          case 'stars':
            $rcpwph_stars = !empty($rcpwph_input['stars_number']) ? $rcpwph_input['stars_number'] : 5;
            ?>
              <div class="rcpwph-input-stars-wrapper">
                <div class="rcpwph-width-100-percent">
                  <?php if (!empty($rcpwph_input['rcpwph_label_min'])): ?>
                    <p class="rcpwph-input-stars-label-min"><?php echo esc_html($rcpwph_input['rcpwph_label_min']); ?></p>
                  <?php endif ?>

                  <?php if (!empty($rcpwph_input['rcpwph_label_max'])): ?>
                    <p class="rcpwph-input-stars-label-max"><?php echo esc_html($rcpwph_input['rcpwph_label_max']); ?></p>
                  <?php endif ?>
                </div>

                <div class="rcpwph-input-stars rcpwph-text-align-center rcpwph-pt-20">
                  <?php foreach (range(1, $rcpwph_stars) as $index => $star): ?>
                    <i class="material-icons-outlined rcpwph-input-star">star_outlined</i>
                  <?php endforeach ?>
                </div>

                <input type="number" <?php echo ((array_key_exists('required', $rcpwph_input) && $rcpwph_input['required'] == 'true') ? 'required' : ''); ?> <?php echo ((array_key_exists('disabled', $rcpwph_input) && $rcpwph_input['disabled'] == 'true') ? 'disabled' : ''); ?> id="<?php echo esc_attr($rcpwph_input['id']) . ((array_key_exists('multiple', $rcpwph_input) && $rcpwph_input['multiple']) ? '[]' : ''); ?>" name="<?php echo esc_attr($rcpwph_input['id']); ?>" class="rcpwph-input-hidden-stars <?php echo array_key_exists('class', $rcpwph_input) ? esc_attr($rcpwph_input['class']) : ''; ?>" min="1" max="<?php echo esc_attr($rcpwph_stars) ?>">
              </div>
            <?php
            break;
          case 'submit':
            ?>
              <div class="rcpwph-text-align-right">
                <input type="submit" value="<?php echo esc_attr($rcpwph_input['value']); ?>" name="<?php echo esc_attr($rcpwph_input['id']); ?>" id="<?php echo esc_attr($rcpwph_input['id']); ?>" class="rcpwph-btn" data-rcpwph-type="<?php echo esc_attr($rcpwph_type); ?>" data-rcpwph-user-id="<?php echo esc_attr($rcpwph_id); ?>" data-rcpwph-post-id="<?php echo esc_attr(get_the_ID()); ?>"/><img class="rcpwph-waiting rcpwph-display-none-soft" src="<?php echo esc_url(RCPWPH_URL . 'assets/media/ajax-loader.gif'); ?>" alt="<?php esc_html_e('Loading...', 'rcpwph'); ?>">
              </div>
            <?php
            break;
          case 'hidden':
            ?>
              <input type="hidden" id="<?php echo esc_attr($rcpwph_input['id']); ?>" name="<?php echo esc_attr($rcpwph_input['id']); ?>" value="<?php echo esc_attr(wp_create_nonce('rcpwph-nonce')); ?>">
            <?php
            break;
          default:
            ?>
              <input id="<?php echo esc_attr($rcpwph_input['id']) . ((array_key_exists('multiple', $rcpwph_input) && $rcpwph_input['multiple']) ? '[]' : ''); ?>" name="<?php echo esc_attr($rcpwph_input['id']) . ((array_key_exists('multiple', $rcpwph_input) && $rcpwph_input['multiple']) ? '[]' : ''); ?>" <?php echo (array_key_exists('multiple', $rcpwph_input) && $rcpwph_input['multiple'] ? 'multiple' : ''); ?> class="rcpwph-field <?php echo array_key_exists('class', $rcpwph_input) ? esc_attr($rcpwph_input['class']) : ''; ?>" type="<?php echo esc_attr($rcpwph_input['type']); ?>" <?php echo ((array_key_exists('required', $rcpwph_input) && $rcpwph_input['required'] == 'true') ? 'required' : ''); ?> <?php echo (((array_key_exists('disabled', $rcpwph_input) && $rcpwph_input['disabled'] == 'true') || $rcpwph_disabled_fields) ? 'disabled' : ''); ?> <?php echo (((array_key_exists('step', $rcpwph_input) && $rcpwph_input['step'] != '')) ? 'step="' . esc_attr($rcpwph_input['step']) . '"' : ''); ?> <?php echo (isset($rcpwph_input['max']) ? 'max=' . esc_attr($rcpwph_input['max']) : ''); ?> <?php echo (isset($rcpwph_input['min']) ? 'min=' . esc_attr($rcpwph_input['min']) : ''); ?> value="<?php echo (!empty($rcpwph_input['button_text']) ? esc_html($rcpwph_input['button_text']) : esc_html($rcpwph_value)); ?>" placeholder="<?php echo (array_key_exists('placeholder', $rcpwph_input) ? esc_html($rcpwph_input['placeholder']) : ''); ?>" <?php echo wp_kses_post($rcpwph_parent_block); ?>/>
            <?php
            break;
        }
        break;
      case 'select':
        ?>
          <select <?php echo ((array_key_exists('required', $rcpwph_input) && $rcpwph_input['required'] == 'true') ? 'required' : ''); ?> <?php echo (((array_key_exists('disabled', $rcpwph_input) && $rcpwph_input['disabled'] == 'true') || $rcpwph_disabled_fields) ? 'disabled' : ''); ?> <?php echo (array_key_exists('multiple', $rcpwph_input) && $rcpwph_input['multiple'] ? 'multiple' : ''); ?> id="<?php echo esc_attr($rcpwph_input['id']) . ((array_key_exists('multiple', $rcpwph_input) && $rcpwph_input['multiple']) ? '[]' : ''); ?>" name="<?php echo esc_attr($rcpwph_input['id']) . ((array_key_exists('multiple', $rcpwph_input) && $rcpwph_input['multiple']) ? '[]' : ''); ?>" class="rcpwph-field <?php echo array_key_exists('class', $rcpwph_input) ? esc_attr($rcpwph_input['class']) : ''; ?>" placeholder="<?php echo (array_key_exists('placeholder', $rcpwph_input) ? esc_attr($rcpwph_input['placeholder']) : ''); ?>" data-placeholder="<?php echo (array_key_exists('placeholder', $rcpwph_input) ? esc_attr($rcpwph_input['placeholder']) : ''); ?>" <?php echo wp_kses_post($rcpwph_parent_block); ?>>

            <?php if (array_key_exists('multiple', $rcpwph_input) && $rcpwph_input['multiple']): ?>
              <?php 
                switch ($rcpwph_type) {
                  case 'user':
                    $rcpwph_selected_values = !empty(get_user_meta($rcpwph_id, $rcpwph_input['id'], true)) ? get_user_meta($rcpwph_id, $rcpwph_input['id'], true) : [];
                    break;
                  case 'post':
                    $rcpwph_selected_values = !empty(get_post_meta($rcpwph_id, $rcpwph_input['id'], true)) ? get_post_meta($rcpwph_id, $rcpwph_input['id'], true) : [];
                    break;
                  case 'option':
                    $rcpwph_selected_values = !empty(get_option($rcpwph_input['id'])) ? get_option($rcpwph_input['id']) : [];
                    break;
                }
              ?>
              
              <?php foreach ($rcpwph_input['options'] as $rcpwph_input_option_key => $rcpwph_input_option_value): ?>
                <option value="<?php echo esc_attr($rcpwph_input_option_key); ?>" <?php echo ((array_key_exists('all_selected', $rcpwph_input) && $rcpwph_input['all_selected'] == 'true') || (is_array($rcpwph_selected_values) && in_array($rcpwph_input_option_key, $rcpwph_selected_values)) ? 'selected' : ''); ?>><?php echo esc_html($rcpwph_input_option_value) ?></option>
              <?php endforeach ?>
            <?php else: ?>
              <option value="" <?php echo $rcpwph_value == '' ? 'selected' : '';?>><?php esc_html_e('Select an option', 'wph'); ?></option>
              
              <?php foreach ($rcpwph_input['options'] as $rcpwph_input_option_key => $rcpwph_input_option_value): ?>
                <option value="<?php echo esc_attr($rcpwph_input_option_key); ?>" <?php echo ((array_key_exists('all_selected', $rcpwph_input) && $rcpwph_input['all_selected'] == 'true') || ($rcpwph_value != '' && $rcpwph_input_option_key == $rcpwph_value) ? 'selected' : ''); ?>><?php echo esc_html($rcpwph_input_option_value); ?></option>
              <?php endforeach ?>
            <?php endif ?>
          </select>
        <?php
        break;
      case 'textarea':
        ?>
          <textarea id="<?php echo esc_attr($rcpwph_input['id']) . ((array_key_exists('multiple', $rcpwph_input) && $rcpwph_input['multiple']) ? '[]' : ''); ?>" name="<?php echo esc_attr($rcpwph_input['id']) . ((array_key_exists('multiple', $rcpwph_input) && $rcpwph_input['multiple']) ? '[]' : ''); ?>" <?php echo wp_kses_post($rcpwph_parent_block); ?> class="rcpwph-field <?php echo array_key_exists('class', $rcpwph_input) ? esc_attr($rcpwph_input['class']) : ''; ?>" <?php echo ((array_key_exists('required', $rcpwph_input) && $rcpwph_input['required'] == 'true') ? 'required' : ''); ?> <?php echo (((array_key_exists('disabled', $rcpwph_input) && $rcpwph_input['disabled'] == 'true') || $rcpwph_disabled_fields) ? 'disabled' : ''); ?> <?php echo (array_key_exists('multiple', $rcpwph_input) && $rcpwph_input['multiple'] ? 'multiple' : ''); ?> placeholder="<?php echo (array_key_exists('placeholder', $rcpwph_input) ? esc_attr($rcpwph_input['placeholder']) : ''); ?>"><?php echo esc_html($rcpwph_value); ?></textarea>
        <?php
        break;
      case 'image':
        ?>
          <div class="rcpwph-field rcpwph-images-block" <?php echo wp_kses_post($rcpwph_parent_block); ?> data-rcpwph-multiple="<?php echo (array_key_exists('multiple', $rcpwph_input) && $rcpwph_input['multiple']) ? 'true' : 'false'; ?>">
            <?php if (!empty($rcpwph_value)): ?>
              <div class="rcpwph-images">
                <?php foreach (explode(',', $rcpwph_value) as $rcpwph_image): ?>
                  <?php echo wp_get_attachment_image($rcpwph_image, 'medium'); ?>
                <?php endforeach ?>
              </div>

              <div class="rcpwph-text-align-center rcpwph-position-relative"><a href="#" class="rcpwph-btn rcpwph-btn-mini rcpwph-image-btn"><?php echo (array_key_exists('multiple', $rcpwph_input) && $rcpwph_input['multiple']) ? esc_html(__('Edit images', 'wph')) : esc_html(__('Edit image', 'wph')); ?></a></div>
            <?php else: ?>
              <div class="rcpwph-images"></div>

              <div class="rcpwph-text-align-center rcpwph-position-relative"><a href="#" class="rcpwph-btn rcpwph-btn-mini rcpwph-image-btn"><?php echo (array_key_exists('multiple', $rcpwph_input) && $rcpwph_input['multiple']) ? esc_html(__('Add images', 'wph')) : esc_html(__('Add image', 'wph')); ?></a></div>
            <?php endif ?>

            <input name="<?php echo esc_attr($rcpwph_input['id']); ?>" id="<?php echo esc_attr($rcpwph_input['id']); ?>" class="rcpwph-display-none rcpwph-image-input" type="text" value="<?php echo esc_attr($rcpwph_value); ?>"/>
          </div>
        <?php
        break;
      case 'video':
        ?>
        <div class="rcpwph-field rcpwph-videos-block" <?php echo wp_kses_post($rcpwph_parent_block); ?>>
            <?php if (!empty($rcpwph_value)): ?>
              <div class="rcpwph-videos">
                <?php foreach (explode(',', $rcpwph_value) as $rcpwph_video): ?>
                  <div class="rcpwph-video rcpwph-tooltip" title="<?php echo esc_html(get_the_title($rcpwph_video)); ?>"><i class="dashicons dashicons-media-video"></i></div>
                <?php endforeach ?>
              </div>

              <div class="rcpwph-text-align-center rcpwph-position-relative"><a href="#" class="rcpwph-btn rcpwph-video-btn"><?php echo (array_key_exists('multiple', $rcpwph_input) && $rcpwph_input['multiple']) ? esc_html(__('Edit videos', 'wph')) : esc_html(__('Edit video', 'wph')); ?></a></div>
            <?php else: ?>
              <div class="rcpwph-videos"></div>

              <div class="rcpwph-text-align-center rcpwph-position-relative"><a href="#" class="rcpwph-btn rcpwph-video-btn"><?php echo (array_key_exists('multiple', $rcpwph_input) && $rcpwph_input['multiple']) ? esc_html(__('Add videos', 'wph')) : esc_html(__('Add video', 'wph')); ?></a></div>
            <?php endif ?>

            <input name="<?php echo esc_attr($rcpwph_input['id']); ?>" id="<?php echo esc_attr($rcpwph_input['id']); ?>" class="rcpwph-display-none rcpwph-video-input" type="text" value="<?php echo esc_attr($rcpwph_value); ?>"/>
          </div>
        <?php
        break;
      case 'audio':
        ?>
          <div class="rcpwph-field rcpwph-audios-block" <?php echo wp_kses_post($rcpwph_parent_block); ?>>
            <?php if (!empty($rcpwph_value)): ?>
              <div class="rcpwph-audios">
                <?php foreach (explode(',', $rcpwph_value) as $rcpwph_audio): ?>
                  <div class="rcpwph-audio rcpwph-tooltip" title="<?php echo esc_html(get_the_title($rcpwph_audio)); ?>"><i class="dashicons dashicons-media-audio"></i></div>
                <?php endforeach ?>
              </div>

              <div class="rcpwph-text-align-center rcpwph-position-relative"><a href="#" class="rcpwph-btn rcpwph-btn-mini rcpwph-audio-btn"><?php echo (array_key_exists('multiple', $rcpwph_input) && $rcpwph_input['multiple']) ? esc_html(__('Edit audios', 'wph')) : esc_html(__('Edit audio', 'wph')); ?></a></div>
            <?php else: ?>
              <div class="rcpwph-audios"></div>

              <div class="rcpwph-text-align-center rcpwph-position-relative"><a href="#" class="rcpwph-btn rcpwph-btn-mini rcpwph-audio-btn"><?php echo (array_key_exists('multiple', $rcpwph_input) && $rcpwph_input['multiple']) ? esc_html(__('Add audios', 'wph')) : esc_html(__('Add audio', 'wph')); ?></a></div>
            <?php endif ?>

            <input name="<?php echo esc_attr($rcpwph_input['id']); ?>" id="<?php echo esc_attr($rcpwph_input['id']); ?>" class="rcpwph-display-none rcpwph-audio-input" type="text" value="<?php echo esc_attr($rcpwph_value); ?>"/>
          </div>
        <?php
        break;
      case 'file':
        ?>
          <div class="rcpwph-field rcpwph-files-block" <?php echo wp_kses_post($rcpwph_parent_block); ?>>
            <?php if (!empty($rcpwph_value)): ?>
              <div class="rcpwph-files rcpwph-text-align-center">
                <?php foreach (explode(',', $rcpwph_value) as $rcpwph_file): ?>
                  <embed src="<?php echo esc_url(wp_get_attachment_url($rcpwph_file)); ?>" type="application/pdf" class="rcpwph-embed-file"/>
                <?php endforeach ?>
              </div>

              <div class="rcpwph-text-align-center rcpwph-position-relative"><a href="#" class="rcpwph-btn rcpwph-btn-mini rcpwph-file-btn"><?php echo (array_key_exists('multiple', $rcpwph_input) && $rcpwph_input['multiple']) ? esc_html(__('Edit files', 'wph')) : esc_html(__('Edit file', 'wph')); ?></a></div>
            <?php else: ?>
              <div class="rcpwph-files"></div>

              <div class="rcpwph-text-align-center rcpwph-position-relative"><a href="#" class="rcpwph-btn rcpwph-btn-mini rcpwph-btn-mini rcpwph-file-btn"><?php echo (array_key_exists('multiple', $rcpwph_input) && $rcpwph_input['multiple']) ? esc_html(__('Add files', 'wph')) : esc_html(__('Add file', 'wph')); ?></a></div>
            <?php endif ?>

            <input name="<?php echo esc_attr($rcpwph_input['id']); ?>" id="<?php echo esc_attr($rcpwph_input['id']); ?>" class="rcpwph-display-none rcpwph-file-input rcpwph-btn-mini" type="text" value="<?php echo esc_attr($rcpwph_value); ?>"/>
          </div>
        <?php
        break;
      case 'editor':
        ?>
          <div class="rcpwph-field" <?php echo wp_kses_post($rcpwph_parent_block); ?>>
            <textarea id="<?php echo esc_attr($rcpwph_input['id']); ?>" name="<?php echo esc_attr($rcpwph_input['id']); ?>" class="rcpwph-input rcpwph-width-100-percent rcpwph-wysiwyg"><?php echo ((empty($rcpwph_value)) ? (array_key_exists('placeholder', $rcpwph_input) ? esc_attr($rcpwph_input['placeholder']) : '') : esc_html($rcpwph_value)); ?></textarea>
          </div>
        <?php
        break;
      case 'html':
        ?>
          <div class="rcpwph-field" <?php echo wp_kses_post($rcpwph_parent_block); ?>>
            <?php echo !empty($rcpwph_input['html_content']) ? wp_kses_post(html_entity_decode(do_shortcode($rcpwph_input['html_content']))) : ''; ?>
          </div>
        <?php
        break;
      case 'html_multi':
        switch ($rcpwph_type) {
          case 'user':
            $html_multi_fields_length = !empty(get_user_meta($rcpwph_id, $rcpwph_input['html_multi_fields'][0]['id'], true)) ? count(get_user_meta($rcpwph_id, $rcpwph_input['html_multi_fields'][0]['id'], true)) : 0;
            break;
          case 'post':
            $html_multi_fields_length = !empty(get_post_meta($rcpwph_id, $rcpwph_input['html_multi_fields'][0]['id'], true)) ? count(get_post_meta($rcpwph_id, $rcpwph_input['html_multi_fields'][0]['id'], true)) : 0;
            break;
          case 'option':
            $html_multi_fields_length = !empty(get_option($rcpwph_input['html_multi_fields'][0]['id'])) ? count(get_option($rcpwph_input['html_multi_fields'][0]['id'])) : 0;
        }

        ?>
          <div class="rcpwph-html-multi-wrapper rcpwph-mb-50" <?php echo wp_kses_post($rcpwph_parent_block); ?>>
            <?php if ($html_multi_fields_length): ?>
              <?php foreach (range(0, ($html_multi_fields_length - 1)) as $length_index): ?>
                <div class="rcpwph-html-multi-group rcpwph-display-table rcpwph-width-100-percent rcpwph-mb-30">
                  <div class="rcpwph-display-inline-table rcpwph-width-90-percent">
                    <?php foreach ($rcpwph_input['html_multi_fields'] as $index => $html_multi_field): ?>
                      <?php self::input_builder($html_multi_field, $rcpwph_type, $rcpwph_id, false, true, $length_index); ?>
                    <?php endforeach ?>
                  </div>
                  <div class="rcpwph-display-inline-table rcpwph-width-10-percent rcpwph-text-align-center">
                    <i class="material-icons-outlined rcpwph-cursor-move rcpwph-multi-sorting rcpwph-vertical-align-super rcpwph-tooltip" title="<?php esc_html_e('Order element', 'rcpwph'); ?>">drag_handle</i>
                  </div>

                  <div class="rcpwph-text-align-right">
                    <a href="#" class="rcpwph-html-multi-remove-btn"><i class="material-icons-outlined rcpwph-cursor-pointer rcpwph-tooltip" title="<?php esc_html_e('Remove element', 'wph'); ?>">remove</i></a>
                  </div>
                </div>
              <?php endforeach ?>
            <?php else: ?>
              <div class="rcpwph-html-multi-group rcpwph-mb-50">
                <div class="rcpwph-display-inline-table rcpwph-width-90-percent">
                  <?php foreach ($rcpwph_input['html_multi_fields'] as $html_multi_field): ?>
                    <?php self::input_builder($html_multi_field, $rcpwph_type); ?>
                  <?php endforeach ?>
                </div>
                <div class="rcpwph-display-inline-table rcpwph-width-10-percent rcpwph-text-align-center">
                  <i class="material-icons-outlined rcpwph-cursor-move rcpwph-multi-sorting rcpwph-vertical-align-super rcpwph-tooltip" title="<?php esc_html_e('Order element', 'rcpwph'); ?>">drag_handle</i>
                </div>

                <div class="rcpwph-text-align-right">
                  <a href="#" class="rcpwph-html-multi-remove-btn rcpwph-tooltip" title="<?php esc_html_e('Remove element', 'wph'); ?>"><i class="material-icons-outlined rcpwph-cursor-pointer">remove</i></a>
                </div>
              </div>
            <?php endif ?>

            <div class="rcpwph-text-align-right">
              <a href="#" class="rcpwph-html-multi-add-btn rcpwph-tooltip" title="<?php esc_html_e('Add element', 'wph'); ?>"><i class="material-icons-outlined rcpwph-cursor-pointer rcpwph-font-size-40">add</i></a>
            </div>
          </div>
        <?php
        break;
    }
  }

  public static function input_wrapper_builder($input_array, $type, $rcpwph_id = 0, $rcpwph_format = 'half'){
    ?>
      <?php if (array_key_exists('section', $input_array) && !empty($input_array['section'])): ?>      
        <?php if ($input_array['section'] == 'start'): ?>
          <div class="rcpwph-toggle-wrapper rcpwph-position-relative rcpwph-mb-30">
            <?php if (array_key_exists('description', $input_array) && !empty($input_array['description'])): ?>
              <i class="material-icons-outlined rcpwph-section-helper rcpwph-color-main-0 rcpwph-tooltip" title="<?php echo esc_attr($input_array['description']); ?>">help</i>
            <?php endif ?>

            <a href="#" class="rcpwph-toggle rcpwph-width-100-percent rcpwph-text-decoration-none">
              <div class="rcpwph-display-table rcpwph-width-100-percent">
                <div class="rcpwph-display-inline-table rcpwph-width-90-percent">
                  <label class="rcpwph-cursor-pointer rcpwph-toggle rcpwph-mb-20"><?php echo esc_html($input_array['label']); ?></label>
                </div>
                <div class="rcpwph-display-inline-table rcpwph-width-10-percent rcpwph-text-align-right">
                  <i class="material-icons-outlined rcpwph-cursor-pointer rcpwph-color-main-0">add</i>
                </div>
              </div>
            </a>

            <div class="rcpwph-content rcpwph-pl-10 rcpwph-toggle-content rcpwph-mb-20 rcpwph-display-none-soft">
        <?php elseif ($input_array['section'] == 'end'): ?>
            </div>
          </div>
        <?php endif ?>
      <?php else: ?>
        <div class="rcpwph-input-wrapper <?php echo esc_attr($input_array['id']); ?> <?php echo !empty($input_array['tabs']) ? 'rcpwph-input-tabbed' : ''; ?> rcpwph-input-field-<?php echo esc_attr($input_array['input']); ?> <?php echo (!empty($input_array['required']) && $input_array['required'] == 'true') ? 'rcpwph-input-field-required' : ''; ?>">
          <?php if (array_key_exists('label', $input_array) && !empty($input_array['label'])): ?>
            <div class="rcpwph-display-inline-table <?php echo (($rcpwph_format == 'half' && !(array_key_exists('type', $input_array) && $input_array['type'] == 'submit')) ? 'rcpwph-width-40-percent' : 'rcpwph-width-100-percent'); ?> rcpwph-tablet-display-block rcpwph-tablet-width-100-percent rcpwph-vertical-align-top">
              <div class="rcpwph-p-10 <?php echo (array_key_exists('parent', $input_array) && !empty($input_array['parent']) && $input_array['parent'] != 'this') ? 'rcpwph-pl-30' : ''; ?>">
                <label class="rcpwph-font-size-16 rcpwph-vertical-align-middle rcpwph-display-block <?php echo (array_key_exists('description', $input_array) && !empty($input_array['description'])) ? 'rcpwph-toggle' : ''; ?>" for="<?php echo esc_attr($input_array['id']); ?>"><?php echo esc_attr($input_array['label']); ?> <?php echo (array_key_exists('required', $input_array) && !empty($input_array['required']) && $input_array['required'] == 'true') ? '<span class="rcpwph-tooltip" title="' . esc_html(__('Required field', 'wph')) . '">*</span>' : ''; ?><?php echo (array_key_exists('description', $input_array) && !empty($input_array['description'])) ? '<i class="material-icons-outlined rcpwph-cursor-pointer rcpwph-float-right">add</i>' : ''; ?></label>

                <?php if (array_key_exists('description', $input_array) && !empty($input_array['description'])): ?>
                  <div class="rcpwph-toggle-content rcpwph-display-none-soft">
                    <small><?php echo wp_kses_post(wp_specialchars_decode($input_array['description'])); ?></small>
                  </div>
                <?php endif ?>
              </div>
            </div>
          <?php endif ?>

          <div class="rcpwph-display-inline-table <?php echo ((array_key_exists('label', $input_array) && empty($input_array['label'])) ? 'rcpwph-width-100-percent' : (($rcpwph_format == 'half' && !(array_key_exists('type', $input_array) && $input_array['type'] == 'submit')) ? 'rcpwph-width-60-percent' : 'rcpwph-width-100-percent')); ?> rcpwph-tablet-display-block rcpwph-tablet-width-100-percent rcpwph-vertical-align-top">
            <div class="rcpwph-p-10 <?php echo (array_key_exists('parent', $input_array) && !empty($input_array['parent']) && $input_array['parent'] != 'this') ? 'rcpwph-pl-30' : ''; ?>">
              <div class="rcpwph-input-field"><?php self::input_builder($input_array, $type, $rcpwph_id); ?></div>
            </div>
          </div>
        </div>
      <?php endif ?>
    <?php
  }

  public static function sanitizer($value, $node = '', $type = '') {
    switch (strtolower($node)) {
      case 'input':
        switch (strtolower($type)) {
          case 'text':
            return sanitize_text_field($value);
          case 'email':
            return sanitize_email($value);
          case 'url':
            return sanitize_url($value);
          case 'color':
            return sanitize_hex_color($value);
          default:
            return sanitize_text_field($value);
        }
      case 'select':
        switch ($type) {
          case 'select-multiple':
            foreach ($value as $key => $values) {
              $value[$key] = sanitize_key($values);
            }

            return $value;
          default:
            return sanitize_key($value);
        }
      case 'textarea':
        return wp_kses_post($value);
      case 'editor':
        return wp_kses_post($value);
      default:
        return sanitize_text_field($value);
    }
  }
}