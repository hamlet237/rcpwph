<?php
/**
 * Recipes taxonomies creator.
 *
 * This class defines Recipes taxonomies.
 *
 * @link       wordpress-heroes.com/
 * @since      1.0.0
 * @package    RCPWPH
 * @subpackage RCPWPH/includes
 * @author     wordpress-heroes <info@wordpress-heroes.com>
 */
class RCPWPH_Taxonomies_Recipe { 
	/**
	 * Register taxonomies.
	 *
	 * @since    1.0.0
	 */
	public static function register_taxonomies() {
		$taxonomies = [
			'rcpwph_recipe_category' => [
				'name'               	=> _x('Recipe categories', 'Taxonomy general name', 'rcpwph'),
				'singular_name'      	=> _x('Recipe category', 'Taxonomy singular name', 'rcpwph'),
				'search_items'      	=> esc_html(__('Search Recipe categories', 'rcpwph')),
        'all_items'         	=> esc_html(__('All Recipe categories', 'rcpwph')),
        'parent_item'       	=> esc_html(__('Parent Recipe category', 'rcpwph')),
        'parent_item_colon' 	=> esc_html(__('Parent Recipe category:', 'rcpwph')),
        'edit_item'         	=> esc_html(__('Edit Recipe category', 'rcpwph')),
        'update_item'       	=> esc_html(__('Update Recipe category', 'rcpwph')),
        'add_new_item'      	=> esc_html(__('Add New Recipe category', 'rcpwph')),
        'new_item_name'     	=> esc_html(__('New Recipe category', 'rcpwph')),
        'menu_name'         	=> esc_html(__('Recipe categories', 'rcpwph')),
				'manage_terms'      	=> 'manage_rcpwph_recipe_category',
	      'edit_terms'        	=> 'edit_rcpwph_recipe_category',
	      'delete_terms'      	=> 'delete_rcpwph_recipe_category',
	      'assign_terms'      	=> 'assign_rcpwph_recipe_category',
	      'archive'			      	=> false,
	      'slug'			      		=> 'recipes',
			],
		];;

	  foreach ($taxonomies as $taxonomy => $options) {
	  	$labels = [
				'name'          		=> $options['name'],
				'singular_name' 		=> $options['singular_name'],
				
			];

			$capabilities = [
				'manage_terms'      => $options['manage_terms'],
				'edit_terms'      	=> $options['edit_terms'],
				'delete_terms'      => $options['delete_terms'],
				'assign_terms'      => $options['assign_terms'],
	    ];

			$args = [
				'labels'            => $labels,
				'hierarchical'      => true,
				'public'            => false,
				'show_ui' 					=> false,
				'query_var'         => false,
				'rewrite'           => false,
				'show_in_rest'      => true,
	    	'capabilities'      => $capabilities,
			];

			if ($options['archive']) {
				$args['public'] = true;
				$args['publicly_queryable'] = true;
				$args['show_in_nav_menus'] = true;
				$args['query_var'] = $taxonomy;
				$args['show_ui'] = true;
				$args['rewrite'] = [
					'slug' => $options['slug'],
				];
			}

			register_taxonomy($taxonomy, 'rcpwph_recipe', $args);
			register_taxonomy_for_object_type($taxonomy, 'rcpwph_recipe');
		}
	}
}