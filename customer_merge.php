<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Customer Merge
Description: Merge duplicate customers with all their associated data
Version: 1.0.0
Requires at least: 2.3.*
Author: Uygar Duzgun
Author URI: https://uygarduzgun.com
Author Email: info@uygarduzgun.com
*/

// Define module name constant
define('CUSTOMER_MERGE_MODULE', 'customer_merge');

// Register activation hook
register_activation_hook(CUSTOMER_MERGE_MODULE, 'customer_merge_activation_hook');

// Register language files
register_language_files(CUSTOMER_MERGE_MODULE, [CUSTOMER_MERGE_MODULE]);

// Register Swedish language
hooks()->add_action('after_setup_theme', 'customer_merge_register_swedish_language');

// Register permissions
hooks()->add_action('admin_init', 'customer_merge_register_permissions');

// Add module's CSS and JS files
hooks()->add_action('admin_init', 'customer_merge_init_css');
hooks()->add_action('app_admin_head', 'customer_merge_add_head_components');
hooks()->add_action('app_admin_footer', 'customer_merge_add_footer_components');

// Add menu item to admin area
hooks()->add_action('admin_init', 'customer_merge_add_menu_item');

// Add button to customer view
hooks()->add_action('after_customer_admins_tab_content', 'customer_merge_add_merge_button');

/**
 * Module activation hook
 */
function customer_merge_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}

/**
 * Initialize module's CSS
 */
function customer_merge_init_css()
{
    $CI = &get_instance();
    
    $CI->app_css->add('customer-merge-css', base_url('modules/customer_merge/assets/css/customer_merge.css'));
}

/**
 * Add components to admin head
 */
function customer_merge_add_head_components()
{
    echo '<link href="' . base_url('modules/customer_merge/assets/css/customer_merge.css') . '" rel="stylesheet" type="text/css" />';
}

/**
 * Add components to admin footer
 */
function customer_merge_add_footer_components()
{
    echo '<script src="' . base_url('modules/customer_merge/assets/js/customer_merge.js') . '"></script>';
}

/**
 * Add menu item to admin area
 */
function customer_merge_add_menu_item()
{
    $CI = &get_instance();

    if (has_permission('customer_merge', '', 'view')) {
        $CI->app_menu->add_sidebar_menu_item('customer-merge', [
            'name'     => _l('customer_merge'),
            'href'     => admin_url('customer_merge'),
            'position' => 6,
            'icon'     => 'fa fa-puzzle-piece',
            'parent_slug' => 'customers',
        ]);
    }
}

/**
 * Add merge button to customer view
 */
function customer_merge_add_merge_button($customer_id)
{
    if (has_permission('customer_merge', '', 'create')) {
        echo '<a href="' . admin_url('customer_merge/merge/' . $customer_id) . '" class="btn btn-info mright5 mtop15">' . _l('merge_with_another_customer') . '</a>';
    }
}

/**
 * Register module permissions
 */
function customer_merge_register_permissions()
{
    $capabilities = [];

    $capabilities['capabilities'] = [
        'view'   => _l('permission_view') . ' ' . _l('customer_merge'),
        'create' => _l('permission_create') . ' ' . _l('customer_merge'),
    ];

    register_staff_capabilities('customer_merge', $capabilities, _l('customer_merge'));
}

/**
 * Register Swedish language
 */
function customer_merge_register_swedish_language()
{
    $CI = &get_instance();
    
    // Check if Swedish language is available in the system
    if (file_exists(APPPATH . 'language/swedish')) {
        // Register the module's Swedish language file
        $CI->lang->load('customer_merge_lang', 'swedish', false, true, FCPATH . 'modules/customer_merge/language/');
    }
}

/**
 * Get module author information
 * 
 * @return array Author information
 */
function customer_merge_get_author_info()
{
    $CI = &get_instance();
    
    // Default author information
    $author = [
        'name' => 'Uygar Duzgun',
        'url' => 'https://uygarduzgun.com',
        'email' => 'info@uygarduzgun.com'
    ];
    
    // Try to get author information from database
    $CI->db->where('name', 'customer_merge_author');
    $option = $CI->db->get(db_prefix() . 'options')->row();
    
    if ($option && !empty($option->value)) {
        $saved_author = unserialize($option->value);
        if (is_array($saved_author)) {
            $author = $saved_author;
        }
    }
    
    return $author;
}

/**
 * Add module information to the modules settings page
 */
hooks()->add_filter('module_customer_merge_action_links', 'customer_merge_add_module_info');

function customer_merge_add_module_info($actions)
{
    $author = customer_merge_get_author_info();
    
    $module_info = '
    <div class="module-info">
        <div class="module-author">
            <strong>' . _l('module_developed_by') . '</strong>: 
            <a href="' . $author['url'] . '" target="_blank">' . $author['name'] . '</a>
        </div>
        <div class="module-support">
            <strong>' . _l('support') . '</strong>: 
            <a href="mailto:' . $author['email'] . '">' . $author['email'] . '</a>
        </div>
    </div>';
    
    $actions[] = $module_info;
    
    return $actions;
} 