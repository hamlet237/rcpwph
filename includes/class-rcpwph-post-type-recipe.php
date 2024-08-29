<?php
/**
 * Recipes creator.
 *
 * This class defines Recipes options, menus and templates.
 *
 * @link       wordpress-heroes.com/
 * @since      1.0.0
 * @package    RCPWPH
 * @subpackage RCPWPH/includes
 * @author     wordpress-heroes <info@wordpress-heroes.com>
 */
class RCPWPH_Post_Type_Recipe {
  public function get_fields() {
    $rcpwph_fields = [];
      $rcpwph_fields['rcpwph_ingredients'] = [
        'id' => 'rcpwph_ingredients',
        'input' => 'html_multi',
        'label' => __('Ingredients', 'rcpwph'),
        'html_multi_fields' => [[
          'id' => 'rcpwph_ingredients_name',
          'class' => 'rcpwph-input rcpwph-width-100-percent',
          'input' => 'input',
          'type' => 'text',
          'multiple' => true,
          'label' => __('Ingredient', 'rcpwph'),
          'placeholder' => __('Ingredient', 'rcpwph'),
        ]],
      ];
      $rcpwph_fields['rcpwph_steps'] = [
        'id' => 'rcpwph_steps',
        'input' => 'html_multi',
        'label' => __('Steps', 'rcpwph'),
        'html_multi_fields' => [[
          'id' => 'rcpwph_steps_name',
          'class' => 'rcpwph-input rcpwph-width-100-percent',
          'input' => 'input',
          'type' => 'text',
          'multiple' => true,
          'label' => __('Step title', 'rcpwph'),
          'placeholder' => __('Step title', 'rcpwph'),
        ],[
          'id' => 'rcpwph_steps_description',
          'class' => 'rcpwph-input rcpwph-width-100-percent',
          'input' => 'textarea',
          'multiple' => true,
          'label' => __('Step description', 'rcpwph'),
          'placeholder' => __('Step description', 'rcpwph'),
        ],[
          'id' => 'rcpwph_steps_time',
          'class' => 'rcpwph-input rcpwph-width-100-percent',
          'input' => 'input',
          'type' => 'time',
          'multiple' => true,
          'label' => __('Step time (hours:minutes)', 'rcpwph'),
          'placeholder' => __('Step time (hours:minutes)', 'rcpwph'),
        ],
      ]];
      $rcpwph_fields['rcpwph_time'] = [
        'id' => 'rcpwph_time',
        'class' => 'rcpwph-input rcpwph-width-100-percent',
        'input' => 'input',
        'type' => 'time',
        'label' => __('Recipe total time (hours:minutes)', 'rcpwph'),
        'placeholder' => __('Recipe total time (hours:minutes)', 'rcpwph'),
      ];
      $rcpwph_fields['rcpwph_suggestions'] = [
        'id' => 'rcpwph_suggestions',
        'class' => 'rcpwph-input rcpwph-width-100-percent',
        'input' => 'editor',
        'label' => __('Recipe suggestions', 'rcpwph'),
      ];
      $rcpwph_fields['rcpwph_images'] = [
        'id' => 'rcpwph_images',
        'class' => 'rcpwph-input rcpwph-width-100-percent',
        'input' => 'image',
        'multiple' => true,
        'label' => __('Recipe gallery', 'rcpwph'),
        'placeholder' => __('Recipe gallery', 'rcpwph'),
      ];
      $rcpwph_fields['rcpwph_video_url'] = [
        'id' => 'rcpwph_video_url',
        'class' => 'rcpwph-input rcpwph-width-100-percent',
        'input' => 'input',
        'type' => 'url',
        'label' => __('Recipe video url', 'rcpwph'),
        'placeholder' => __('Recipe video url', 'rcpwph'),
        'description' => __('You can set a video repository url here (like YouTube or Vimeo) to show the content in the recipe\'s page.', 'rcpwph'),
      ];
      $rcpwph_fields['rcpwph_nonce'] = [
        'id' => 'rcpwph_nonce',
        'input' => 'input',
        'type' => 'hidden',
      ];
    return $rcpwph_fields;
  }

	/**
	 * Register Recipe.
	 *
	 * @since    1.0.0
	 */
	public function register_post_type() {
		$labels = [
      'name'                => _x('Recipes', 'Post Type general name', 'rcpwph'),
      'singular_name'       => _x('Recipe', 'Post Type singular name', 'rcpwph'),
      'menu_name'           => esc_html(__('Recipes', 'rcpwph')),
      'parent_item_colon'   => esc_html(__('Parent Recipe', 'rcpwph')),
      'all_items'           => esc_html(__('All Recipes', 'rcpwph')),
      'view_item'           => esc_html(__('View Recipe', 'rcpwph')),
      'add_new_item'        => esc_html(__('Add new Recipe', 'rcpwph')),
      'add_new'             => esc_html(__('Add New', 'rcpwph')),
      'edit_item'           => esc_html(__('Edit Recipe', 'rcpwph')),
      'update_item'         => esc_html(__('Update Recipe', 'rcpwph')),
      'search_items'        => esc_html(__('Search Recipe', 'rcpwph')),
      'not_found'           => esc_html(__('Not Recipes found', 'rcpwph')),
      'not_found_in_trash'  => esc_html(__('Not Recipes found in Trash', 'rcpwph')),
    ];

    $args = [
      'labels'              => $labels,
      'rewrite'             => ['slug' => (!empty(get_option('rcpwph_slug')) ? get_option('rcpwph_slug') : 'recipes'), 'with_front' => false],
      'label'               => esc_html(__('Recipes', 'rcpwph')),
      'description'         => esc_html(__('Recipes description', 'rcpwph')),
      'supports'            => ['title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', ],
      'hierarchical'        => true,
      'public'              => true,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'show_in_nav_menus'   => true,
      'show_in_admin_bar'   => true,
      'menu_position'       => 5,
      'menu_icon'           => esc_url(RCPWPH_URL . 'assets/media/rcpwph-menu-icon.svg'),
      'can_export'          => true,
      'has_archive'         => true,
      'exclude_from_search' => true,
      'publicly_queryable'  => true,
      'capability_type'     => 'page',
      'taxonomies'          => RCPWPH_ROLE_CAPABILITIES,
      'show_in_rest'        => true, /* REST API */
    ];

		register_post_type('rcpwph_recipe', $args);
    add_theme_support('post-thumbnails', ['page', 'rcpwph_recipe']);
	}

  /**
   * Add Recipe dashboard metabox.
   *
   * @since    1.0.0
   */
  public function add_meta_box() {
    add_meta_box('rcpwph_meta_box', esc_html(__('Recipe details', 'rcpwph')), [$this, 'rcpwph_meta_box_function'], 'rcpwph_recipe', 'normal', 'high', ['__block_editor_compatible_meta_box' => true,]);
  }

  /**
   * Defines Recipe dashboard contents.
   *
   * @since    1.0.0
   */
  public function rcpwph_meta_box_function($post) {
    foreach ($this->get_fields() as $wph_field) {
      RCPWPH_Forms::input_wrapper_builder($wph_field, 'post', $post->ID);
    }
  }

  /**
   * Defines single template for Recipe.
   *
   * @since    1.0.0
   */
  public function single_template($single) {
    if (get_post_type() == 'rcpwph_recipe') {
      if (file_exists(RCPWPH_DIR . 'templates/public/single-rcpwph_recipe.php')) {
        return RCPWPH_DIR . 'templates/public/single-rcpwph_recipe.php';
      }
    }

    return $single;
  }

  /**
   * Defines archive template for Recipe.
   *
   * @since    1.0.0
   */
  public function archive_template($archive) {
    if (get_post_type() == 'rcpwph_recipe') {
      if (file_exists(RCPWPH_DIR . 'templates/public/archive-rcpwph_recipe.php')) {
        return RCPWPH_DIR . 'templates/public/archive-rcpwph_recipe.php';
      }
    }

    return $archive;
  }

  public function activated_plugin($plugin) {
    if($plugin == 'rcpwph/rcpwph.php') {
      wp_redirect(home_url((!empty(get_option('rcpwph_slug')) ? get_option('rcpwph_slug') : 'recipes')));exit();
    }
  }

  public function save_post($post_id, $cpt, $update) {
    if (array_key_exists('rcpwph_nonce', $_POST) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['rcpwph_nonce'])), 'rcpwph-nonce')) {
      echo wp_json_encode(['error_key' => 'rcpwph_nonce_error', ]);exit();
    }

    foreach ($this->get_fields() as $wph_field) {
      $wph_input = array_key_exists('input', $wph_field) ? $wph_field['input'] : '';

      if (array_key_exists($wph_field['id'], $_POST) || $wph_input == 'html_multi') {
        $wph_value = array_key_exists($wph_field['id'], $_POST) ? RCPWPH_Forms::sanitizer($_POST[$wph_field['id']], $wph_field['input'], !empty($wph_field['type']) ? $wph_field['type'] : '') : '';

        if (!empty($wph_input)) {
          switch ($wph_input) {
            case 'input':
              if (array_key_exists('type', $wph_field) && $wph_field['type'] == 'checkbox') {
                if (isset($_POST[$wph_field['id']])) {
                  update_post_meta($post_id, $wph_field['id'], $wph_value);
                }else{
                  update_post_meta($post_id, $wph_field['id'], '');
                }
              }else{
                update_post_meta($post_id, $wph_field['id'], $wph_value);
              }

              break;
            case 'select':
              if (array_key_exists('multiple', $wph_field) && $wph_field['multiple']) {
                $multi_array = [];
                $empty = true;

                foreach ($_POST[$wph_field['id']] as $multi_value) {
                  $multi_array[] = RCPWPH_Forms::sanitizer($multi_value, $wph_field['input'], !empty($wph_field['type']) ? $wph_field['type'] : '');
                }

                update_post_meta($post_id, $wph_field['id'], $multi_array);
              }else{
                update_post_meta($post_id, $wph_field['id'], $wph_value);
              }
              
              break;
            case 'html_multi':
              foreach ($wph_field['html_multi_fields'] as $wph_multi_field) {
                if (array_key_exists($wph_multi_field['id'], $_POST)) {
                  $multi_array = [];
                  $empty = true;

                  foreach ($_POST[$wph_multi_field['id']] as $multi_value) {
                    if (!empty($multi_value)) {
                      $empty = false;
                    }

                    $multi_array[] = RCPWPH_Forms::sanitizer($multi_value, $wph_multi_field['input'], !empty($wph_multi_field['type']) ? $wph_multi_field['type'] : '');
                  }

                  if (!$empty) {
                    update_post_meta($post_id, $wph_multi_field['id'], $multi_array);
                  }else{
                    update_post_meta($post_id, $wph_multi_field['id'], '');
                  }
                }
              }

              break;
            default:
              update_post_meta($post_id, $wph_field['id'], $wph_value);
              break;
          }
        }
      }else{
        update_post_meta($post_id, $wph_field['id'], '');
      }
    }
  }
}