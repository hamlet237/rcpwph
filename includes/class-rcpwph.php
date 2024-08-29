<?php
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current version of the plugin.
 *
 * @link       wordpress-heroes.com/
 * @since      1.0.0
 * @package    RCPWPH
 * @subpackage RCPWPH/includes
 * @author     wordpress-heroes <info@wordpress-heroes.com>
 */

class RCPWPH {
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      RCPWPH_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin. Load the dependencies, define the locale, and set the hooks for the admin area and the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if (defined('RCPWPH_VERSION')) {
			$this->version = RCPWPH_VERSION;
		} else {
			$this->version = '1.0.0';
		}

		$this->plugin_name = 'rcpwph';

		$this->define_constants();
		$this->load_dependencies();
		$this->set_i18n();
		$this->define_common_hooks();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_post_types();
		$this->define_taxonomies();
		$this->load_ajax();
		$this->load_ajax_nopriv();
		$this->load_data();
		$this->load_templates();
		$this->load_menus();
		$this->load_shortcodes();
	}

	/**
	 * Define the plugin main constants.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_constants() {
		define('RCPWPH_DIR', plugin_dir_path(dirname(__FILE__)));
		define('RCPWPH_URL', plugin_dir_url(dirname(__FILE__)));
		
		define('RCPWPH_ROLE_CAPABILITIES', ['edit_post' => 'edit_wph_recipe', 'edit_posts' => 'edit_rcpwph', 'edit_private_posts' => 'edit_private_rcpwph', 'edit_published_posts' => 'edit_published_rcpwph', 'edit_others_posts' => 'edit_other_rcpwph', 'publish_posts' => 'publish_rcpwph', 'read_post' => 'read_wph_recipe', 'read_private_posts' => 'read_private_rcpwph', 'delete_post' => 'delete_wph_recipe', 'delete_posts' => 'delete_rcpwph', 'delete_private_posts' => 'delete_private_rcpwph', 'delete_published_posts' => 'delete_published_rcpwph', 'delete_others_posts' => 'delete_others_rcpwph', 'upload_files' => 'upload_files', 'manage_terms' => 'manage_rcpwph_category', 'edit_terms' => 'edit_rcpwph_category', 'delete_terms' => 'delete_rcpwph_category', 'assign_terms' => 'assign_rcpwph_category', 'manage_options' => 'manage_rcpwph_options', ]);

		define('RCPWPH_KSES', ['div' => ['id' => [], 'class' => [], ], 'span' => ['id' => [], 'class' => [], ], 'p' => ['id' => [], 'class' => [], ], 'ul' => ['id' => [], 'class' => [], ], 'ol' => ['id' => [], 'class' => [], ], 'li' => ['id' => [], 'class' => [], ], 'small' => ['id' => [], 'class' => [], ], 'a' => ['id' => [], 'class' => [], 'href' => [], 'title' => [], 'target' => [], ], 'input' => ['name' => [], 'id' => [], 'class' => [], 'type' => [], 'checked' => [], 'multiple' => [], 'disabled' => [], 'value' => [], ], 'label' => ['id' => [], 'class' => [], 'for' => [], ], 'i' => ['id' => [], 'class' => [], ], 'br' => [], 'em' => [], 'strong' => [], 'h1' => ['id' => [], 'class' => [], ], 'h2' => ['id' => [], 'class' => [], ], 'h3' => ['id' => [], 'class' => [], ], 'h4' => ['id' => [], 'class' => [], ], 'h5' => ['id' => [], 'class' => [], ], 'h6' => ['id' => [], 'class' => [], ], ]);
	}
			
	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 * - RCPWPH_Loader. Orchestrates the hooks of the plugin.
	 * - RCPWPH_i18n. Defines internationalization functionality.
	 * - RCPWPH_Common. Defines hooks used accross both, admin and public side.
	 * - RCPWPH_Admin. Defines all hooks for the admin area.
	 * - RCPWPH_Public. Defines all hooks for the public side of the site.
	 * - RCPWPH_Post_Type_Recipe. Defines Recipe custom post type.
	 * - RCPWPH_Taxonomies_Recipe. Defines Recipe taxonomies.
	 * - RCPWPH_Templates. Load plugin templates.
	 * - RCPWPH_Data. Load main usefull data.
	 * - RCPWPH_Functions_Post. Posts management functions.
	 * - RCPWPH_Functions_Attachment. Attachments management functions.
	 * - RCPWPH_Functions_Menus. Define menus.
	 * - RCPWPH_Functions_Forms. Forms management functions.
	 * - RCPWPH_Functions_Ajax. Ajax functions.
	 * - RCPWPH_Functions_Ajax_Nopriv. Ajax No Private functions.
	 * - RCPWPH_Functions_Shortcodes. Define all shortcodes for the platform.
	 *
	 * Create an instance of the loader which will be used to register the hooks with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		/**
		 * The class responsible for orchestrating the actions and filters of the core plugin.
		 */
		require_once RCPWPH_DIR . 'includes/class-rcpwph-loader.php';

		/**
		 * The class responsible for defining internationalization functionality of the plugin.
		 */
		require_once RCPWPH_DIR . 'includes/class-rcpwph-i18n.php';

		/**
		 * The class responsible for defining all actions that occur both in the admin area and in the public-facing side of the site.
		 */
		require_once RCPWPH_DIR . 'includes/class-rcpwph-common.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once RCPWPH_DIR . 'includes/admin/class-rcpwph-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing side of the site.
		 */
		require_once RCPWPH_DIR . 'includes/public/class-rcpwph-public.php';

		/**
		 * The class responsible for create the Project custom post type.
		 */
		require_once RCPWPH_DIR . 'includes/class-rcpwph-post-type-recipe.php';

		/**
		 * The class responsible for create the Project custom taxonomies.
		 */
		require_once RCPWPH_DIR . 'includes/class-rcpwph-taxonomies-recipe.php';

		/**
		 * The class responsible for plugin templates.
		 */
		require_once RCPWPH_DIR . 'includes/class-rcpwph-templates.php';

		/**
		 * The class getting key data of the platform.
		 */
		require_once RCPWPH_DIR . 'includes/class-rcpwph-data.php';

		/**
		 * The class defining posts management functions.
		 */
		require_once RCPWPH_DIR . 'includes/class-rcpwph-functions-post.php';

		/**
		 * The class defining attahcments management functions.
		 */
		require_once RCPWPH_DIR . 'includes/class-rcpwph-functions-attachment.php';

		/**
		 * The class defining menus.
		 */
		require_once RCPWPH_DIR . 'includes/class-rcpwph-menus.php';

		/**
		 * The class defining form management.
		 */
		require_once RCPWPH_DIR . 'includes/class-rcpwph-forms.php';

		/**
		 * The class defining ajax functions.
		 */
		require_once RCPWPH_DIR . 'includes/class-rcpwph-ajax.php';

		/**
		 * The class defining no private ajax functions.
		 */
		require_once RCPWPH_DIR . 'includes/class-rcpwph-ajax-nopriv.php';

		/**
		 * The class defining shortcodes.
		 */
		require_once RCPWPH_DIR . 'includes/class-rcpwph-shortcodes.php';

		$this->loader = new RCPWPH_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the RCPWPH_i18n class in order to set the domain and to register the hook with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_i18n() {
		$plugin_i18n = new RCPWPH_i18n();

		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');

		if (class_exists('Polylang')) {
			$this->loader->add_filter('pll_get_post_types', $plugin_i18n, 'rcpwph_pll_get_post_types', 10, 2);
    }
	}

	/**
	 * Register all of the hooks related to the main functionalities of the plugin, common to public and admin faces.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_common_hooks() {
		$plugin_common = new RCPWPH_Common($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('wp_enqueue_scripts', $plugin_common, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_common, 'enqueue_scripts');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_common, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_common, 'enqueue_scripts');
	}

	/**
	 * Register all of the hooks related to the admin area functionality of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new RCPWPH_Admin($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new RCPWPH_Public($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
	}

	/**
	 * Register all Post Types with meta boxes and templates.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_post_types() {
		$plugin_post_type_recipe = new RCPWPH_Post_Type_Recipe();
		$this->loader->add_action('init', $plugin_post_type_recipe, 'register_post_type');
		$this->loader->add_action('admin_init', $plugin_post_type_recipe, 'add_meta_box');
		$this->loader->add_action('save_post_rcpwph_recipe', $plugin_post_type_recipe, 'save_post', 10, 3);

		$this->loader->add_filter('single_template', $plugin_post_type_recipe, 'single_template', 10, 3);
		$this->loader->add_filter('archive_template', $plugin_post_type_recipe, 'archive_template', 10, 3);
		
		$this->loader->add_action('activated_plugin', $plugin_post_type_recipe, 'activated_plugin');
	}

	/**
	 * Register all of the hooks related to Taxonomies.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_taxonomies() {
		$plugin_taxonomies_recipe = new RCPWPH_Taxonomies_Recipe();

		$this->loader->add_action('init', $plugin_taxonomies_recipe, 'register_taxonomies');
	}

	/**
	 * Load most common data used on the platform.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_data() {
		$plugin_data = new RCPWPH_Data();

		if (is_admin()) {
			$this->loader->add_action('init', $plugin_data, 'load_plugin_data');
		}else{
			$this->loader->add_action('wp_footer', $plugin_data, 'load_plugin_data');
		}

		$this->loader->add_action('wp_footer', $plugin_data, 'flush_rewrite_rules');
		$this->loader->add_action('admin_footer', $plugin_data, 'flush_rewrite_rules');
	}

	/**
	 * Register templates.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_templates() {
		if (!defined('DOING_AJAX')) {
			$plugin_templates = new RCPWPH_Templates();

			$this->loader->add_action('wp_footer', $plugin_templates, 'load_plugin_templates');
			$this->loader->add_action('admin_footer', $plugin_templates, 'load_plugin_templates');
			$this->loader->add_action('admin_init', $plugin_templates, 'load_plugin_templates');
		}
	}

	/**
	 * Register menus.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_menus() {
		$plugin_menus = new RCPWPH_Menus();

		$this->loader->add_action('admin_menu', $plugin_menus, 'rcpwph_admin_menu');
	}

	/**
	 * Load ajax functions.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_ajax() {
		$plugin_ajax = new RCPWPH_Ajax();

		$this->loader->add_action('wp_ajax_rcpwph_ajax', $plugin_ajax, 'rcpwph_ajax_server');
	}

	/**
	 * Load no private ajax functions.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_ajax_nopriv() {
		$plugin_ajax = new RCPWPH_Ajax_Nopriv();

		$this->loader->add_action('wp_ajax_rcpwph_ajax_nopriv', $plugin_ajax, 'rcpwph_ajax_nopriv_server');
		$this->loader->add_action('wp_ajax_nopriv_rcpwph_ajax_nopriv', $plugin_ajax, 'rcpwph_ajax_nopriv_server');
	}

	/**
	 * Register shortcodes of the platform.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_shortcodes() {
		$plugin_shortcodes = new RCPWPH_Shortcodes();

		$this->loader->add_shortcode('rcpwph-recipe', $plugin_shortcodes, 'rcpwph_recipe');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress. Then it flushes the rewrite rules if needed.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    RCPWPH_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}