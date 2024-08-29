<?php
/**
 * Plugin menus manager.
 *
 * This class defines plugin menus, both in dashboard or in front-end.
 *
 * @link       wordpress-heroes.com/
 * @since      1.0.0
 * @package    RCPWPH
 * @subpackage RCPWPH/includes
 * @author     wordpress-heroes <info@wordpress-heroes.com>
 */
class RCPWPH_Menus {
  public function get_options() {
    $rcpwph_options = [];
    $rcpwph_options['rcpwph_slug'] = [
      'id' => 'rcpwph_slug',
      'class' => 'rcpwph-input rcpwph-width-100-percent',
      'input' => 'input',
      'type' => 'text',
      'label' => __('Recipe slug', 'rcpwph'),
      'placeholder' => __('Recipe slug', 'rcpwph'),
      'description' => __('This option sets the slug of the main recipes archive page, and the recipe pages. By default they will be:', 'rcpwph') . '<br><a href="' . esc_url(home_url('/recipes')) . '" target="_blank">' . esc_url(home_url('/recipes')) . '</a><br>' . esc_url(home_url('/recipes/recipe-name')),
    ];
    $rcpwph_options['rcpwph_options_remove'] = [
      'id' => 'rcpwph_options_remove',
      'class' => 'rcpwph-input rcpwph-width-100-percent',
      'input' => 'input',
      'type' => 'checkbox',
      'label' => __('Remove plugin options on deactivation', 'rcpwph'),
      'description' => __('If you activate this option the plugin will remove all options on deactivation. Please, be careful. This process cannot be undone.', 'rcpwph'),
    ];
    $rcpwph_options['rcpwph_nonce'] = [
      'id' => 'rcpwph_nonce',
      'input' => 'input',
      'type' => 'hidden',
    ];
    $rcpwph_options['rcpwph_submit'] = [
      'id' => 'rcpwph_submit',
      'input' => 'input',
      'type' => 'submit',
      'value' => __('Save options', 'rcpwph'),
    ];

    return $rcpwph_options;
  }

	/**
	 * Administrator menu.
	 *
	 * @since    1.0.0
	 */
	public function rcpwph_admin_menu() {
		add_submenu_page('edit.php?post_type=rcpwph_recipe', esc_html(__('Settings', 'rcpwph')), esc_html(__('Settings', 'rcpwph')), 'manage_rcpwph_options', 'rcpwph-options', [$this, 'rcpwph_options'], );
	}

	public function rcpwph_options() {
	  ?>
	    <div class="rcpwph-options rcpwph-max-width-1000 rcpwph-margin-auto rcpwph-mt-50 rcpwph-mb-50">
        <h1 class="rcpwph-mb-30"><?php esc_html_e('Recipes Manager - WPH Options', 'rcpwph'); ?></h1>
        <div class="rcpwph-options-fields rcpwph-mb-30">
          <form action="" method="post" id="rcpwph_form" class="rcpwph-form">
            <?php foreach ($this->get_options() as $rcpwph_option): ?>
              <?php RCPWPH_Forms::input_wrapper_builder($rcpwph_option, 'option', 0, 'half'); ?>
            <?php endforeach ?>
          </form> 
        </div>
      </div>
	  <?php
	}		
}