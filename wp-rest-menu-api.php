<?php
/*
Plugin Name: WP REST Menu API
Description: Expose WordPress menu items via custom REST API endpoints.
Version: 1.0
Author: Shivam Pandya
*/

// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

// Register REST API route to get items of a specific menu by name or ID
add_action('rest_api_init', function () {
    register_rest_route('menu/v1', '/items', array(
        'methods' => 'GET',
        'callback' => 'get_menu_items',
        'permission_callback' => '__return_true', // Public access; adjust if needed
        'args' => array(
            'menu' => array(
                'required' => true,
                'validate_callback' => function ($param, $request, $key) {
                    return is_string($param);
                }
            ),
        ),
    ));
});

// Callback function to fetch specific menu items
function get_menu_items($request)
{
    $menu = $request->get_param('menu');
    $menu_obj = wp_get_nav_menu_object($menu);

    if (! $menu_obj) {
        return new WP_Error('menu_not_found', 'Menu not found', array('status' => 404));
    }

    $menu_items = wp_get_nav_menu_items($menu_obj->term_id);

    if (empty($menu_items)) {
        return rest_ensure_response([]); // Return an empty array if no items are found
    }

    // Format menu items for the response
    $items = array();
    foreach ($menu_items as $menu_item) {
        $items[] = array(
            'id' => $menu_item->ID,
            'title' => $menu_item->title,  // Ensure title is included
            'url' => $menu_item->url,
            'parent' => $menu_item->menu_item_parent,
            'order' => $menu_item->menu_order,
            'classes' => $menu_item->classes,
            'type' => $menu_item->type,
        );
    }

    return rest_ensure_response($items);
}

// Register additional REST API route to get all menus with their items
add_action('rest_api_init', function () {
    register_rest_route('menu/v1', '/all', array(
        'methods' => 'GET',
        'callback' => 'get_all_menus_and_items',
        'permission_callback' => '__return_true', // Public access; adjust if needed
    ));
});

// Callback function to fetch all menus and their items
function get_all_menus_and_items($request)
{
    // Get all registered menus
    $menus = wp_get_nav_menus();
    $all_menus = array();

    // Loop through each menu and get its items
    foreach ($menus as $menu) {
        $menu_items = wp_get_nav_menu_items($menu->term_id);
        $items = array();

        // Format each menu item
        if ($menu_items) {
            foreach ($menu_items as $menu_item) {
                $items[] = array(
                    'id' => $menu_item->ID,
                    'title' => $menu_item->title,  // Ensure title is included
                    'url' => $menu_item->url,
                    'parent' => $menu_item->menu_item_parent,
                    'order' => $menu_item->menu_order,
                    'classes' => $menu_item->classes,
                    'type' => $menu_item->type,
                );
            }
        }

        // Add each menu with its items to the response
        $all_menus[] = array(
            'menu_id' => $menu->term_id,
            'menu_name' => $menu->name,
            'menu_slug' => $menu->slug,
            'items' => $items,
        );
    }

    return rest_ensure_response($all_menus);
}
