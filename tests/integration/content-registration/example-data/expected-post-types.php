<?php
/**
 * Example data for registering custom post types and custom fields.
 *
 */

return array (
	'dog' =>
		array (
			'name' => 'Dogs',
			'singular_name' => 'Dog',
			'description' => '',
			'public' => false,
			'show_ui' => true,
			'show_in_rest' => true,
			'rest_base' => 'dogs',
			'capability_type' => 'post',
			'show_in_menu' => true,
			'supports' =>
				array (
					'title',
					'editor',
					'thumbnail',
					'custom-fields',
				),
			'labels' =>
				array (
					'name' => 'Dogs',
					'singular_name' => 'Dog',
					'add_new_item' => 'Add new Dog',
					'edit_item' => 'Edit Dog',
					'new_item' => 'New Dog',
					'view_item' => 'View Dog',
					'view_items' => 'View Dogs',
					'search_items' => 'Search Dogs',
					'not_found' => 'No Dogs found',
					'not_found_in_trash' => 'No Dogs found in trash',
					'parent_item_colon' => 'Parent Dog:',
					'all_items' => 'All Dogs',
					'archives' => 'Dog archives',
					'attributes' => 'Dog Attributes',
					'uploaded_to_this_item' => 'Uploaded to this Dog',
					'filter_items_list' => 'Filter Dogs list',
					'items_list_navigation' => 'Dogs list navigation',
					'items_list' => 'Dogs list',
					'item_published' => 'Dog published.',
					'item_published_privately' => 'Dog published privately.',
					'item_reverted_to_draft' => 'Dog reverted to draft.',
					'item_scheduled' => 'Dog scheduled.',
					'item_updated' => 'Dog updated.',
					'parent' => 'Parent Dog',
				),
			'show_in_graphql' => true,
			'graphql_single_name' => 'dog',
			'graphql_plural_name' => 'dogs',
			'menu_icon'           => 'dashicons-saved',
			'rest_controller_class' => 'WPE\AtlasContentModeler\ContentRegistration\REST_Posts_Controller',
			'fields' => array(
				'dog-test-field' => array(
					'slug' => 'dog-test-field',
					'type' => 'string',
					'description' => 'dog-test-field description',
					'show_in_rest' => true,
					'show_in_graphql' => true,
				),
				'another-dog-test-field' => array(
					'slug' => 'another-dog-test-field',
					'type' => 'string',
					'description' => 'another-dog-test-field description',
					'show_in_rest' => false,
					'show_in_graphql' => false,
				),
				'dog-weight' => array(
					'slug' => 'dog-weight',
					'type' => 'number',
					'description' => 'dog-weight description',
					'show_in_rest' => true,
					'show_in_graphql' => true,
				),
				'dog-rich-text' => array(
					'slug' => 'dog-rich-text',
					'type' => 'richtext',
					'description' => 'dog-rich-text description',
					'show_in_rest' => true,
					'show_in_graphql' => true,
				),
				'dog-boolean' => array(
					'slug' => 'dog-boolean',
					'type' => 'boolean',
					'description' => 'dog-boolean description',
					'show_in_rest' => true,
					'show_in_graphql' => true,
				),
			),
		),
	'cat' =>
		array (
			'name' => 'Cats',
			'singular_name' => 'Cat',
			'description' => '',
			'public' => false,
			'show_ui' => true,
			'show_in_rest' => true,
			'rest_base' => 'cats',
			'capability_type' => 'post',
			'show_in_menu' => true,
			'supports' =>
				array (
					'title',
					'editor',
					'thumbnail',
					'custom-fields',
				),
			'labels' =>
				array (
					'name' => 'Cats',
					'singular_name' => 'Cat',
					'add_new_item' => 'Add new Cat',
					'edit_item' => 'Edit Cat',
					'new_item' => 'New Cat',
					'view_item' => 'View Cat',
					'view_items' => 'View Cats',
					'search_items' => 'Search Cats',
					'not_found' => 'No Cats found',
					'not_found_in_trash' => 'No Cats found in trash',
					'parent_item_colon' => 'Parent Cat:',
					'all_items' => 'All Cats',
					'archives' => 'Cat archives',
					'attributes' => 'Cat Attributes',
					'uploaded_to_this_item' => 'Uploaded to this Cat',
					'filter_items_list' => 'Filter Cats list',
					'items_list_navigation' => 'Cats list navigation',
					'items_list' => 'Cats list',
					'item_published' => 'Cat published.',
					'item_published_privately' => 'Cat published privately.',
					'item_reverted_to_draft' => 'Cat reverted to draft.',
					'item_scheduled' => 'Cat scheduled.',
					'item_updated' => 'Cat updated.',
					'parent' => 'Parent Cat',
				),
			'show_in_graphql' => false,
			'graphql_single_name' => 'cat',
			'graphql_plural_name' => 'cats',
			'menu_icon'           => 'dashicons-admin-post',
			'rest_controller_class' => 'WPE\AtlasContentModeler\ContentRegistration\REST_Posts_Controller',
		),
);
