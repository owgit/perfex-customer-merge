<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_101 extends App_module_migration
{
    public function up()
    {
        // Check if the rolled_back column already exists
        $table = db_prefix() . 'customer_merge_history';
        $field = 'rolled_back';
        
        $query = $this->ci->db->query("SHOW COLUMNS FROM `{$table}` LIKE '{$field}'");
        $column_exists = $query->num_rows() > 0;
        
        if (!$column_exists) {
            // Add rolled_back column
            $this->ci->db->query("ALTER TABLE `{$table}` ADD COLUMN `rolled_back` TINYINT(1) NOT NULL DEFAULT 0");
        }
        
        // Check if the rollback_date column already exists
        $field = 'rollback_date';
        $query = $this->ci->db->query("SHOW COLUMNS FROM `{$table}` LIKE '{$field}'");
        $column_exists = $query->num_rows() > 0;
        
        if (!$column_exists) {
            // Add rollback_date column
            $this->ci->db->query("ALTER TABLE `{$table}` ADD COLUMN `rollback_date` DATETIME NULL");
        }
    }
} 