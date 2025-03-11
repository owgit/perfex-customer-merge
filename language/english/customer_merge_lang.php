<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Module name
$lang['customer_merge'] = 'Customer Merge';
$lang['merge_customers'] = 'Merge Customers';
$lang['merge_new_customers'] = 'Merge New Customers';

// Permissions
$lang['permission_view_customer_merge'] = 'View Customer Merge';
$lang['permission_create_customer_merge'] = 'Create Customer Merge';
$lang['customer_merge_permission_notice'] = 'You do not have permission to merge customers. Please contact your administrator if you need this access.';

// Merge page
$lang['source_customer'] = 'Source Customer';
$lang['target_customer'] = 'Target Customer';
$lang['will_be_deleted'] = 'Will be deleted';
$lang['will_be_kept'] = 'Will be kept';
$lang['select_customer'] = 'Select Customer';
$lang['search_customers'] = 'Search Customers';
$lang['customer_id'] = 'Customer ID';
$lang['merge_options'] = 'Merge Options';
$lang['data_to_merge'] = 'Data to Merge';
$lang['customer_data_to_transfer'] = 'Customer Data to Transfer';
$lang['customer_data_transfer_info'] = 'Select which data from the source customer should be transferred to the target customer (only if the target customer does not already have this data).';
$lang['billing_details'] = 'Billing Details';
$lang['shipping_details'] = 'Shipping Details';
$lang['customer_default_currency'] = 'Default Currency';
$lang['warning'] = 'Warning';
$lang['customer_merge_warning'] = 'This action will merge the source customer into the target customer. All data from the source customer will be transferred to the target customer, and the source customer will be deleted. This action cannot be undone.';
$lang['confirm_merge'] = 'I understand that this action cannot be undone and I want to proceed with the merge.';
$lang['confirm_merge_prompt'] = 'Are you sure you want to merge these customers? This action cannot be undone.';
$lang['wait_text'] = 'Please wait...';

// Primary contact selection
$lang['primary_contact_selection'] = 'Primary Contact Selection';
$lang['primary_contact_selection_info'] = 'Choose which contact should be the primary contact for the merged customer.';
$lang['select_primary_contact_option'] = 'Select Primary Contact Option';
$lang['keep_target_primary_contact'] = 'Keep Target Customer\'s Primary Contact';
$lang['keep_source_primary_contact'] = 'Keep Source Customer\'s Primary Contact';
$lang['select_primary_contact_manually'] = 'Select Primary Contact Manually';
$lang['select_primary_contact'] = 'Select Primary Contact';
$lang['select_contact'] = 'Select Contact';
$lang['source'] = 'Source';
$lang['target'] = 'Target';

// Primary contact note
$lang['primary_contact_note_title'] = 'Primary Contact Information';
$lang['primary_contact_note'] = 'When merging customers, the target customer\'s primary contact will be kept as the primary contact. Any primary contacts from the source customer will be transferred but will no longer be marked as primary.';

// Success/error messages
$lang['customer_merge_success'] = 'Customers merged successfully.';
$lang['customer_merge_failed'] = 'Failed to merge customers.';
$lang['customer_merge_db_error'] = 'Database error occurred during merge. Please check the activity log for details.';
$lang['customer_merge_select_both'] = 'Please select both source and target customers.';
$lang['customer_not_found'] = 'Customer not found.';
$lang['access_denied'] = 'Access denied.';

// Merge history
$lang['no_merge_history'] = 'No merge history found.';
$lang['source_customer'] = 'Source Customer';
$lang['target_customer'] = 'Target Customer';
$lang['merged_by'] = 'Merged By';
$lang['merged_data'] = 'Merged Data';
$lang['date'] = 'Date';

$lang['always_merged'] = 'Always merged';
$lang['contacts_merge_info'] = 'All contacts will be transferred. If a contact with the same email exists in the target customer, their permissions and data will be merged.';
$lang['tasks'] = 'Tasks';
$lang['payments'] = 'Payments';
$lang['statement'] = 'Statement';
$lang['profile'] = 'Profile';

// Module information
$lang['module_developed_by'] = 'Developed by';
$lang['module_version'] = 'Version';
$lang['support'] = 'Support';

// Rollback functionality
$lang['rollback_merge'] = 'Rollback Merge';
$lang['confirm_rollback_merge'] = 'Are you sure you want to rollback this merge? This will create a new customer with the original name and move recent data back to it.';
$lang['rollback_successful'] = 'Merge rollback successful. A new customer has been created with the original data.';
$lang['rollback_failed'] = 'Failed to rollback the merge operation.';
$lang['merge_history_not_found'] = 'Merge history record not found.';
$lang['target_customer_not_found'] = 'Target customer not found. It may have been deleted.';
$lang['failed_to_recreate_source_customer'] = 'Failed to recreate the source customer.';
$lang['invalid_merge_history_id'] = 'Invalid merge history ID.';
$lang['merge_already_rolled_back'] = 'This merge has already been rolled back.';
$lang['rolled_back'] = 'Rolled Back';
$lang['active'] = 'Active';
$lang['status'] = 'Status';
$lang['options'] = 'Options'; 