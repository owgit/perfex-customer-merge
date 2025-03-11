<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_102 extends App_module_migration
{
    public function up()
    {
        // This migration doesn't need to modify the database structure
        // It's used to update the module version number
        
        // However, we can add a hook to ensure primary contacts are always set to active
        // when they're created or updated
        
        if (!$this->ci->db->field_exists('active_fix_applied', db_prefix() . 'modules')) {
            $this->ci->db->query('ALTER TABLE `' . db_prefix() . 'modules` 
                ADD COLUMN `active_fix_applied` TINYINT(1) NOT NULL DEFAULT 0');
        }
        
        // Mark the module as having the active fix applied
        $this->ci->db->where('module_name', 'customer_merge');
        $this->ci->db->update(db_prefix() . 'modules', ['active_fix_applied' => 1]);
    }
} 