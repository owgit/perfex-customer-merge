<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer_merge_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('clients_model');
    }

    /**
     * Merge two customers
     * @param  int $source_customer_id      The customer to be merged (will be deleted)
     * @param  int $target_customer_id      The customer to merge into (will be kept)
     * @param  array $merge_options         Options for merging specific data
     * @return boolean                      True if successful, false otherwise
     */
    public function merge_customers($source_customer_id, $target_customer_id, $merge_options = [])
    {
        if ($source_customer_id == $target_customer_id) {
            log_activity('Customer Merge Error: Source and target customers are the same');
            return false;
        }

        $source_customer = $this->clients_model->get($source_customer_id);
        $target_customer = $this->clients_model->get($target_customer_id);

        if (!$source_customer || !$target_customer) {
            log_activity('Customer Merge Error: Source or target customer not found');
            return false;
        }

        // Start transaction
        $this->db->trans_begin();

        try {
            // Track what was merged for history
            $merged_data = [];
            
            // Always merge contacts first to ensure all contact-related data is properly handled
            $this->merge_contacts($source_customer_id, $target_customer_id);
            $merged_data[] = 'contacts';

            // Continue with other merges based on options
            // Merge invoices
            if (!isset($merge_options['invoices']) || $merge_options['invoices'] == 1) {
                $this->merge_related_records('invoices', 'clientid', $source_customer_id, $target_customer_id);
                $merged_data[] = 'invoices';
            }

            // Merge estimates
            if (!isset($merge_options['estimates']) || $merge_options['estimates'] == 1) {
                $this->merge_related_records('estimates', 'clientid', $source_customer_id, $target_customer_id);
                $merged_data[] = 'estimates';
            }

            // Merge credit notes
            if (!isset($merge_options['credit_notes']) || $merge_options['credit_notes'] == 1) {
                $this->merge_related_records('creditnotes', 'clientid', $source_customer_id, $target_customer_id);
                $merged_data[] = 'credit_notes';
            }

            // Merge projects
            if (!isset($merge_options['projects']) || $merge_options['projects'] == 1) {
                $this->merge_related_records('projects', 'clientid', $source_customer_id, $target_customer_id);
                $merged_data[] = 'projects';
            }

            // Merge expenses
            if (!isset($merge_options['expenses']) || $merge_options['expenses'] == 1) {
                $this->merge_related_records('expenses', 'clientid', $source_customer_id, $target_customer_id);
                $merged_data[] = 'expenses';
            }

            // Merge proposals
            if (!isset($merge_options['proposals']) || $merge_options['proposals'] == 1) {
                $this->merge_related_records('proposals', 'rel_id', $source_customer_id, $target_customer_id, "rel_type = 'customer'");
                $merged_data[] = 'proposals';
            }

            // Merge tickets
            if (!isset($merge_options['tickets']) || $merge_options['tickets'] == 1) {
                $this->merge_related_records('tickets', 'userid', $source_customer_id, $target_customer_id);
                $merged_data[] = 'tickets';
            }

            // Merge contracts
            if (!isset($merge_options['contracts']) || $merge_options['contracts'] == 1) {
                $this->merge_related_records('contracts', 'client', $source_customer_id, $target_customer_id);
                $merged_data[] = 'contracts';
            }

            // Merge customer files
            if (!isset($merge_options['files']) || $merge_options['files'] == 1) {
                $this->merge_related_records('files', 'rel_id', $source_customer_id, $target_customer_id, "rel_type = 'customer'");
                $merged_data[] = 'files';
            }

            // Merge customer notes
            if (!isset($merge_options['notes']) || $merge_options['notes'] == 1) {
                $this->merge_notes($source_customer_id, $target_customer_id);
                $merged_data[] = 'notes';
            }

            // Merge customer reminders
            if (!isset($merge_options['reminders']) || $merge_options['reminders'] == 1) {
                $this->merge_related_records('reminders', 'rel_id', $source_customer_id, $target_customer_id, "rel_type = 'customer'");
                $merged_data[] = 'reminders';
            }

            // Merge customer vault entries
            if (!isset($merge_options['vault']) || $merge_options['vault'] == 1) {
                $this->merge_related_records('vault', 'customer_id', $source_customer_id, $target_customer_id);
                $merged_data[] = 'vault';
            }

            // Merge tasks
            if (!isset($merge_options['tasks']) || $merge_options['tasks'] == 1) {
                $this->merge_tasks($source_customer_id, $target_customer_id);
                $merged_data[] = 'tasks';
            }

            // Merge payments
            if (!isset($merge_options['payments']) || $merge_options['payments'] == 1) {
                $this->merge_payments($source_customer_id, $target_customer_id);
                $merged_data[] = 'payments';
            }

            // Merge customer groups
            if (!isset($merge_options['customer_groups']) || $merge_options['customer_groups'] == 1) {
                $this->merge_customer_groups($source_customer_id, $target_customer_id);
                $merged_data[] = 'customer_groups';
            }

            // Merge custom fields
            if (!isset($merge_options['custom_fields']) || $merge_options['custom_fields'] == 1) {
                $this->merge_custom_fields($source_customer_id, $target_customer_id);
                $merged_data[] = 'custom_fields';
                
                // Add a note about enhanced custom fields handling
                log_activity('Customer Merge: Enhanced custom fields merging completed with priority on combining values for select fields like customers_kundtyp');
            }

            // Merge customer admins (staff assigned to customer)
            if (!isset($merge_options['customer_admins']) || $merge_options['customer_admins'] == 1) {
                $this->merge_customer_admins($source_customer_id, $target_customer_id);
                $merged_data[] = 'customer_admins';
            }

            // Update customer data if selected
            if (isset($merge_options['customer_data']) && is_array($merge_options['customer_data'])) {
                $this->update_customer_data($target_customer_id, $source_customer_id, $merge_options['customer_data']);
                $merged_data[] = 'customer_data';
            }

            // Log the merge in history
            $this->log_merge_history($source_customer_id, $source_customer->company, $target_customer_id, $target_customer->company, $merged_data);

            // Delete the source customer
            if (!isset($merge_options['delete_source']) || $merge_options['delete_source'] == 1) {
                // We don't use the clients_model->delete() method because we've already migrated all the data
                // and don't want to delete related records
                $this->db->where('userid', $source_customer_id);
                $this->db->delete(db_prefix() . 'clients');
            }

            // Commit transaction
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                log_activity('Customer Merge Error: Transaction failed');
                return false;
            } else {
                $this->db->trans_commit();
                log_activity('Customer Merge Success: Merged customer ' . $source_customer->company . ' into ' . $target_customer->company);
                return true;
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_activity('Customer Merge Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Merge contacts from source customer to target customer
     * @param  int $source_customer_id The source customer ID
     * @param  int $target_customer_id The target customer ID
     * @return boolean
     */
    private function merge_contacts($source_customer_id, $target_customer_id)
    {
        try {
            // Get all contacts from source customer
            $this->db->where('userid', $source_customer_id);
            $source_contacts = $this->db->get(db_prefix() . 'contacts')->result_array();

            // Get all contacts from target customer for comparison
            $this->db->where('userid', $target_customer_id);
            $target_contacts = $this->db->get(db_prefix() . 'contacts')->result_array();
            
            // Create an array of target contact emails for easy lookup
            $target_contact_emails = [];
            foreach ($target_contacts as $contact) {
                $target_contact_emails[strtolower($contact['email'])] = $contact;
            }
            
            // Get primary contacts
            $source_primary_contact_id = null;
            $target_primary_contact_id = null;
            
            foreach ($source_contacts as $contact) {
                if ($contact['is_primary'] == 1) {
                    $source_primary_contact_id = $contact['id'];
                    break;
                }
            }
            
            foreach ($target_contacts as $contact) {
                if ($contact['is_primary'] == 1) {
                    $target_primary_contact_id = $contact['id'];
                    break;
                }
            }

            // Process each source contact
            foreach ($source_contacts as $source_contact) {
                $source_email = strtolower($source_contact['email']);
                
                // Always uncheck primary status for source contacts
                $is_source_primary = ($source_contact['is_primary'] == 1);
                if ($is_source_primary) {
                    $source_contact['is_primary'] = 0;
                }
                
                // Check if contact with same email already exists in target customer
                if (array_key_exists($source_email, $target_contact_emails)) {
                    $target_contact = $target_contact_emails[$source_email];
                    
                    // Merge contact permissions
                    $this->merge_contact_permissions($source_contact['id'], $target_contact['id']);
                    
                    // Merge contact data if needed (e.g., if target contact is missing some data)
                    $this->merge_contact_data($source_contact, $target_contact);
                    
                    // Merge contact-related records
                    $this->merge_contact_related_records($source_contact['id'], $target_contact['id']);
                } else {
                    // No duplicate found, move contact to target customer
                    $this->db->where('id', $source_contact['id']);
                    $this->db->update(db_prefix() . 'contacts', [
                        'userid' => $target_customer_id,
                        'is_primary' => 0 // Ensure source contacts are never primary
                    ]);
                    
                    // Log the contact transfer
                    $this->log_activity('Contact transferred: ' . $source_contact['firstname'] . ' ' . $source_contact['lastname']);
                }
            }

            // Ensure target customer has a primary contact
            if (!$target_primary_contact_id && count($target_contacts) == 0 && count($source_contacts) > 0) {
                // If target has no contacts and no primary, set the first transferred contact as primary
                $this->db->where('userid', $target_customer_id);
                $this->db->limit(1);
                $this->db->update(db_prefix() . 'contacts', ['is_primary' => 1]);
                
                $this->log_activity('Set first transferred contact as primary for target customer');
            }
            
            return true;
        } catch (Exception $e) {
            $this->log_activity('Error merging contacts: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Merge contact data
     * @param  array $source_contact The source contact data
     * @param  array $target_contact The target contact data
     * @return boolean
     */
    private function merge_contact_data($source_contact, $target_contact)
    {
        $update_data = [];
        
        // Fields to check and potentially update
        $fields_to_check = [
            'firstname', 'lastname', 'phonenumber', 'title', 
            'profile_image', 'last_login', 'active'
        ];
        
        foreach ($fields_to_check as $field) {
            // If target contact is missing data but source has it, use source data
            if (empty($target_contact[$field]) && !empty($source_contact[$field])) {
                $update_data[$field] = $source_contact[$field];
            }
        }
        
        // Special handling for email notification preferences
        $notification_fields = [
            'invoice_emails', 'estimate_emails', 'credit_note_emails', 
            'contract_emails', 'task_emails', 'project_emails', 'ticket_emails'
        ];
        
        foreach ($notification_fields as $field) {
            // If source has notifications enabled but target doesn't, enable for target
            if ($source_contact[$field] == 1 && $target_contact[$field] == 0) {
                $update_data[$field] = 1;
            }
        }
        
        // Update target contact if we have data to update
        if (!empty($update_data)) {
            $this->db->where('id', $target_contact['id']);
            $this->db->update(db_prefix() . 'contacts', $update_data);
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Merge contact-related records
     * @param  int $source_contact_id The source contact ID
     * @param  int $target_contact_id The target contact ID
     * @return boolean
     */
    private function merge_contact_related_records($source_contact_id, $target_contact_id)
    {
        // Tables and fields to update
        $tables_to_update = [
            'tblcontact_permissions' => 'userid',
            'tblconsents' => 'contact_id',
            'tblticket_replies' => 'contactid',
            'tblprojectdiscussioncomments' => 'contact_id',
            'tblprojectdiscussions' => 'contact_id',
            'tblproject_files' => 'contact_id',
            'tblproject_activity' => 'contact_id',
            'tblfiles' => 'contact_id'
        ];
        
        foreach ($tables_to_update as $table => $field) {
            // Check if the table exists - use the table name as is since it already includes the prefix
            if ($this->db->table_exists($table)) {
                // Update records to point to the target contact
                $this->db->where($field, $source_contact_id);
                $this->db->update($table, [$field => $target_contact_id]);
            }
        }
        
        return true;
    }
    
    /**
     * Log activity for tracking
     * @param  string $description Activity description
     * @return void
     */
    private function log_activity($description)
    {
        if (function_exists('log_activity')) {
            log_activity($description);
        }
    }

    /**
     * Merge contact permissions
     * @param  int $source_contact_id The source contact ID
     * @param  int $target_contact_id The target contact ID
     * @return boolean
     */
    private function merge_contact_permissions($source_contact_id, $target_contact_id)
    {
        // Get all permissions from source contact
        $this->db->where('userid', $source_contact_id);
        $permissions = $this->db->get(db_prefix() . 'contact_permissions')->result_array();

        foreach ($permissions as $permission) {
            // Check if permission already exists for target contact
            $this->db->where('userid', $target_contact_id);
            $this->db->where('permission_id', $permission['permission_id']);
            $existing_permission = $this->db->get(db_prefix() . 'contact_permissions')->row();

            if (!$existing_permission) {
                // Add permission to target contact
                $this->db->insert(db_prefix() . 'contact_permissions', [
                    'userid' => $target_contact_id,
                    'permission_id' => $permission['permission_id']
                ]);
            }
        }

        return true;
    }

    /**
     * Merge related records from one customer to another
     * @param  string $table           The table name
     * @param  string $customer_field  The field name that contains the customer ID
     * @param  int $source_customer_id The source customer ID
     * @param  int $target_customer_id The target customer ID
     * @param  string $additional_where Additional WHERE clause
     * @return boolean
     */
    private function merge_related_records($table, $customer_field, $source_customer_id, $target_customer_id, $additional_where = '')
    {
        try {
            // Remove 'tbl' prefix if it's already included in the table name
            $table_name = (strpos($table, 'tbl') === 0) ? $table : db_prefix() . $table;
            
            // Check if table exists before attempting to update
            if (!$this->db->table_exists($table_name)) {
                log_activity('Customer Merge Error: Table ' . $table_name . ' does not exist');
                return false;
            }
            
            $this->db->where($customer_field, $source_customer_id);
            
            if ($additional_where != '') {
                // Remove the leading space and "AND" if present to avoid SQL syntax errors
                $additional_where = trim($additional_where);
                if (strtoupper(substr($additional_where, 0, 3)) === 'AND') {
                    $additional_where = substr($additional_where, 3);
                }
                $additional_where = trim($additional_where);
                
                // Now add the condition properly
                $this->db->where($additional_where);
            }
            
            $result = $this->db->update($table_name, [$customer_field => $target_customer_id]);
            
            // Log the number of records updated
            $affected_rows = $this->db->affected_rows();
            log_activity('Customer Merge: Updated ' . $affected_rows . ' records in ' . $table_name);
            
            return $result;
        } catch (Exception $e) {
            log_activity('Customer Merge Error: ' . $e->getMessage() . ' in table ' . $table);
            return false;
        }
    }

    /**
     * Merge customer groups
     * @param  int $source_customer_id The source customer ID
     * @param  int $target_customer_id The target customer ID
     * @return boolean
     */
    private function merge_customer_groups($source_customer_id, $target_customer_id)
    {
        // Get all groups from source customer
        $this->db->where('customer_id', $source_customer_id);
        $groups = $this->db->get(db_prefix() . 'customer_groups')->result_array();

        foreach ($groups as $group) {
            // Check if group already exists for target customer
            $this->db->where('customer_id', $target_customer_id);
            $this->db->where('groupid', $group['groupid']);
            $existing_group = $this->db->get(db_prefix() . 'customer_groups')->row();

            if (!$existing_group) {
                // Add group to target customer
                $this->db->insert(db_prefix() . 'customer_groups', [
                    'customer_id' => $target_customer_id,
                    'groupid' => $group['groupid']
                ]);
            }
        }

        return true;
    }

    /**
     * Merge custom fields
     * @param  int $source_customer_id The source customer ID
     * @param  int $target_customer_id The target customer ID
     * @return boolean
     */
    private function merge_custom_fields($source_customer_id, $target_customer_id)
    {
        // Get all custom fields for customers
        $this->db->where('fieldto', 'customers');
        $custom_fields = $this->db->get(db_prefix() . 'customfields')->result_array();
        
        $merged_fields = [];

        foreach ($custom_fields as $field) {
            // Get value for source customer
            $this->db->where('relid', $source_customer_id);
            $this->db->where('fieldid', $field['id']);
            $this->db->where('fieldto', 'customers');
            $source_value = $this->db->get(db_prefix() . 'customfieldsvalues')->row();

            if ($source_value) {
                // Check if target customer has a value for this field
                $this->db->where('relid', $target_customer_id);
                $this->db->where('fieldid', $field['id']);
                $this->db->where('fieldto', 'customers');
                $target_value = $this->db->get(db_prefix() . 'customfieldsvalues')->row();

                if (!$target_value) {
                    // Target customer doesn't have a value, copy from source
                    $this->db->insert(db_prefix() . 'customfieldsvalues', [
                        'relid' => $target_customer_id,
                        'fieldid' => $field['id'],
                        'fieldto' => 'customers',
                        'value' => $source_value->value
                    ]);
                    
                    $merged_fields[] = $field['name'] . ': ' . $source_value->value . ' (copied)';
                } else {
                    // Target customer has a value, decide how to merge based on field type
                    $new_value = $target_value->value;
                    $updated = false;
                    
                    // Handle different field types differently
                    switch ($field['type']) {
                        case 'select':
                        case 'multiselect':
                            // For select/multiselect fields, combine values if they're different
                            if ($source_value->value != $target_value->value) {
                                // For multiselect, values are comma-separated
                                $source_values = explode(',', $source_value->value);
                                $target_values = explode(',', $target_value->value);
                                
                                // Combine unique values
                                $combined_values = array_unique(array_merge($target_values, $source_values));
                                $new_value = implode(',', $combined_values);
                                $updated = true;
                                
                                // Special handling for customers_kundtyp
                                if ($field['slug'] == 'customers_kundtyp') {
                                    // If both have values, prioritize combining them
                                    if (!empty($source_value->value) && !empty($target_value->value)) {
                                        $merged_fields[] = $field['name'] . ': ' . $target_value->value . ' + ' . $source_value->value . ' → ' . $new_value;
                                    }
                                }
                            }
                            break;
                            
                        case 'checkbox':
                            // For checkboxes, if source is checked and target is not, check the target
                            if ($source_value->value == 1 && $target_value->value == 0) {
                                $new_value = 1;
                                $updated = true;
                            }
                            break;
                            
                        case 'date':
                        case 'datetime':
                            // For dates, keep the most recent one
                            $source_date = strtotime($source_value->value);
                            $target_date = strtotime($target_value->value);
                            if ($source_date > $target_date) {
                                $new_value = $source_value->value;
                                $updated = true;
                            }
                            break;
                            
                        case 'textarea':
                        case 'text':
                            // For text fields, combine if both have content
                            if (!empty($source_value->value) && !empty($target_value->value) && $source_value->value != $target_value->value) {
                                $new_value = $target_value->value . "\n\n" . $source_value->value;
                                $updated = true;
                            } elseif (empty($target_value->value) && !empty($source_value->value)) {
                                $new_value = $source_value->value;
                                $updated = true;
                            }
                            break;
                            
                        default:
                            // For other types, only update if target is empty and source has value
                            if (empty($target_value->value) && !empty($source_value->value)) {
                                $new_value = $source_value->value;
                                $updated = true;
                            }
                            break;
                    }
                    
                    // Update the target value if needed
                    if ($updated) {
                        $this->db->where('id', $target_value->id);
                        $this->db->update(db_prefix() . 'customfieldsvalues', ['value' => $new_value]);
                        
                        $merged_fields[] = $field['name'] . ': ' . $target_value->value . ' → ' . $new_value;
                    }
                }
            }
        }
        
        // Log the merged fields
        if (!empty($merged_fields)) {
            log_activity('Customer Merge: Merged custom fields: ' . implode(', ', $merged_fields));
        }

        return true;
    }

    /**
     * Merge customer admins (staff assigned to customer)
     * @param  int $source_customer_id The source customer ID
     * @param  int $target_customer_id The target customer ID
     * @return boolean
     */
    private function merge_customer_admins($source_customer_id, $target_customer_id)
    {
        // Get all admins from source customer
        $this->db->where('customer_id', $source_customer_id);
        $admins = $this->db->get(db_prefix() . 'customer_admins')->result_array();

        foreach ($admins as $admin) {
            // Check if admin already exists for target customer
            $this->db->where('customer_id', $target_customer_id);
            $this->db->where('staff_id', $admin['staff_id']);
            $existing_admin = $this->db->get(db_prefix() . 'customer_admins')->row();

            if (!$existing_admin) {
                // Add admin to target customer
                $this->db->insert(db_prefix() . 'customer_admins', [
                    'customer_id' => $target_customer_id,
                    'staff_id' => $admin['staff_id'],
                    'date_assigned' => $admin['date_assigned']
                ]);
            }
        }

        return true;
    }

    /**
     * Update customer data based on selected fields
     * @param  int $target_customer_id The target customer ID
     * @param  int $source_customer_id The source customer ID
     * @param  array $fields           The fields to update
     * @return boolean
     */
    private function update_customer_data($target_customer_id, $source_customer_id, $fields)
    {
        if (empty($fields)) {
            return false;
        }

        $source_customer = $this->clients_model->get($source_customer_id);
        $update_data = [];

        foreach ($fields as $field) {
            if (isset($source_customer->$field) && !empty($source_customer->$field)) {
                $update_data[$field] = $source_customer->$field;
            }
        }

        if (!empty($update_data)) {
            $this->db->where('userid', $target_customer_id);
            $this->db->update(db_prefix() . 'clients', $update_data);
        }

        return true;
    }

    /**
     * Log merge history
     * @param  int $source_customer_id    The source customer ID
     * @param  string $source_customer_name The source customer name
     * @param  int $target_customer_id    The target customer ID
     * @param  string $target_customer_name The target customer name
     * @param  array $merged_data         The data that was merged
     * @return boolean
     */
    private function log_merge_history($source_customer_id, $source_customer_name, $target_customer_id, $target_customer_name, $merged_data)
    {
        return $this->db->insert(db_prefix() . 'customer_merge_history', [
            'source_customer_id' => $source_customer_id,
            'source_customer_name' => $source_customer_name,
            'target_customer_id' => $target_customer_id,
            'target_customer_name' => $target_customer_name,
            'date' => date('Y-m-d H:i:s'),
            'staff_id' => get_staff_user_id(),
            'merged_data' => serialize($merged_data)
        ]);
    }

    /**
     * Get merge history
     * @param  int $customer_id Optional customer ID to filter by
     * @return array
     */
    public function get_merge_history($customer_id = null)
    {
        if ($customer_id) {
            $this->db->where('target_customer_id', $customer_id);
        }
        
        $this->db->order_by('date', 'desc');
        return $this->db->get(db_prefix() . 'customer_merge_history')->result_array();
    }

    /**
     * Get customers for merge
     * @param  string $search Search term
     * @param  int $exclude_id Customer ID to exclude
     * @return array
     */
    public function get_customers_for_merge($search = '', $exclude_id = null)
    {
        $this->db->select('userid, company');
        $this->db->from(db_prefix() . 'clients');
        
        if ($exclude_id) {
            $this->db->where('userid !=', $exclude_id);
        }
        
        if ($search) {
            $this->db->like('company', $search);
        }
        
        $this->db->order_by('company', 'asc');
        $this->db->limit(100);
        
        return $this->db->get()->result_array();
    }

    /**
     * Merge tasks from source customer to target customer
     * @param  int $source_customer_id The source customer ID
     * @param  int $target_customer_id The target customer ID
     * @return boolean
     */
    private function merge_tasks($source_customer_id, $target_customer_id)
    {
        try {
            // First, handle tasks directly related to the customer
            $this->merge_related_records('tasks', 'rel_id', $source_customer_id, $target_customer_id, "rel_type = 'customer'");
            
            // Then, handle tasks related to customer contacts
            // Get all contacts from source customer
            $this->db->where('userid', $source_customer_id);
            $source_contacts = $this->db->get(db_prefix() . 'contacts')->result_array();
            
            foreach ($source_contacts as $contact) {
                // Update tasks related to this contact
                $this->db->where('rel_id', $contact['id']);
                $this->db->where('rel_type', 'contact');
                $this->db->update(db_prefix() . 'tasks', ['rel_id' => $contact['id'], 'rel_type' => 'contact']);
            }
            
            // Handle task assignees, followers, and comments
            // These will be handled automatically when the contacts are merged
            
            log_activity('Customer Merge: Tasks merged successfully');
            return true;
        } catch (Exception $e) {
            log_activity('Customer Merge Error: Failed to merge tasks - ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Merge payments from source customer to target customer
     * @param  int $source_customer_id The source customer ID
     * @param  int $target_customer_id The target customer ID
     * @return boolean
     */
    private function merge_payments($source_customer_id, $target_customer_id)
    {
        try {
            // Update invoice payment records
            $this->merge_related_records('invoicepaymentrecords', 'customerid', $source_customer_id, $target_customer_id);
            
            // Update payment modes
            $this->db->where('clientid', $source_customer_id);
            $payment_modes = $this->db->get(db_prefix() . 'payment_modes')->result_array();
            
            foreach ($payment_modes as $mode) {
                // Check if target customer already has this payment mode
                $this->db->where('clientid', $target_customer_id);
                $this->db->where('id !=', $mode['id']);
                $this->db->where('name', $mode['name']);
                $existing_mode = $this->db->get(db_prefix() . 'payment_modes')->row();
                
                if (!$existing_mode) {
                    // Update the payment mode to point to the target customer
                    $this->db->where('id', $mode['id']);
                    $this->db->update(db_prefix() . 'payment_modes', ['clientid' => $target_customer_id]);
                }
            }
            
            // Update credit card info if any
            $this->db->where('customer_id', $source_customer_id);
            $this->db->update(db_prefix() . 'subscriptions', ['customer_id' => $target_customer_id]);
            
            log_activity('Customer Merge: Payments merged successfully');
            return true;
        } catch (Exception $e) {
            log_activity('Customer Merge Error: Failed to merge payments - ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Merge customer notes
     * @param  int $source_customer_id The source customer ID
     * @param  int $target_customer_id The target customer ID
     * @return boolean
     */
    private function merge_notes($source_customer_id, $target_customer_id)
    {
        try {
            // Get all notes from source customer
            $this->db->where('rel_id', $source_customer_id);
            $this->db->where('rel_type', 'customer');
            $source_notes = $this->db->get(db_prefix() . 'notes')->result_array();
            
            $notes_count = count($source_notes);
            log_activity('Customer Merge: Found ' . $notes_count . ' notes to merge from customer ID ' . $source_customer_id);
            
            // Update all notes to point to the target customer
            $this->db->where('rel_id', $source_customer_id);
            $this->db->where('rel_type', 'customer');
            $this->db->update(db_prefix() . 'notes', ['rel_id' => $target_customer_id]);
            
            $affected_rows = $this->db->affected_rows();
            log_activity('Customer Merge: Successfully merged ' . $affected_rows . ' notes to customer ID ' . $target_customer_id);
            
            return true;
        } catch (Exception $e) {
            log_activity('Customer Merge Error: Failed to merge notes - ' . $e->getMessage());
            return false;
        }
    }
} 