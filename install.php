<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Install the Customer Merge module
 */

// Create the customer_merge_history table to track merge operations
if (!$CI->db->table_exists(db_prefix() . 'customer_merge_history')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . 'customer_merge_history` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `source_customer_id` INT(11) NOT NULL,
        `source_customer_name` VARCHAR(191) NOT NULL,
        `target_customer_id` INT(11) NOT NULL,
        `target_customer_name` VARCHAR(191) NOT NULL,
        `date` DATETIME NOT NULL,
        `staff_id` INT(11) NOT NULL,
        `merged_data` TEXT NULL,
        `rolled_back` TINYINT(1) NOT NULL DEFAULT 0,
        `rollback_date` DATETIME NULL,
        PRIMARY KEY (`id`),
        KEY `target_customer_id` (`target_customer_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');
}

// We don't need to add permissions here as they will be registered
// through the register_staff_capabilities function in the main module file

// Register the module in the database
$module_data = [
    'module_name' => 'customer_merge',
    'installed_version' => '1.0.0',
    'active' => 1
];

// Check if module exists
$CI->db->where('module_name', $module_data['module_name']);
$exists = $CI->db->get(db_prefix() . 'modules')->row();

if ($exists) {
    // Update existing module
    $CI->db->where('module_name', $module_data['module_name']);
    $CI->db->update(db_prefix() . 'modules', ['installed_version' => $module_data['installed_version']]);
} else {
    // Insert new module
    $CI->db->insert(db_prefix() . 'modules', $module_data);
}

// Store module author information in options table
$author_data = [
    'name' => 'Uygar Duzgun',
    'url' => 'https://uygarduzgun.com',
    'email' => 'info@uygarduzgun.com'
];

$CI->db->where('name', 'customer_merge_author');
if ($CI->db->count_all_results(db_prefix() . 'options') > 0) {
    $CI->db->where('name', 'customer_merge_author');
    $CI->db->update(db_prefix() . 'options', ['value' => serialize($author_data)]);
} else {
    $CI->db->insert(db_prefix() . 'options', [
        'name' => 'customer_merge_author',
        'value' => serialize($author_data)
    ]);
} 