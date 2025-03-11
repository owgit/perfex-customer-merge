<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer_merge extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer_merge_model');
        $this->load->model('clients_model');
    }

    /**
     * Index page - list of merge history
     */
    public function index()
    {
        if (!has_permission('customer_merge', '', 'view')) {
            access_denied('customer_merge');
        }

        $data['title'] = _l('customer_merge');
        $data['merge_history'] = $this->customer_merge_model->get_merge_history();

        $this->load->view('customer_merge/merge_history', $data);
    }

    /**
     * Merge page - select customers to merge
     * @param int $customer_id Optional customer ID to pre-select
     */
    public function merge($customer_id = null)
    {
        if (!has_permission('customer_merge', '', 'create')) {
            access_denied('customer_merge');
        }

        if ($this->input->post()) {
            $source_customer_id = $this->input->post('source_customer');
            $target_customer_id = $this->input->post('target_customer');
            $merge_options = $this->input->post('merge_options');
            $customer_data = $this->input->post('customer_data');

            if ($source_customer_id && $target_customer_id) {
                // Add customer data to merge options if selected
                if ($customer_data) {
                    $merge_options['customer_data'] = $customer_data;
                }

                try {
                    $success = $this->customer_merge_model->merge_customers($source_customer_id, $target_customer_id, $merge_options);

                    if ($success) {
                        set_alert('success', _l('customer_merge_success'));
                        redirect(admin_url('clients/client/' . $target_customer_id));
                    } else {
                        set_alert('danger', _l('customer_merge_failed'));
                    }
                } catch (Exception $e) {
                    log_activity('Customer Merge Exception: ' . $e->getMessage());
                    set_alert('danger', _l('customer_merge_failed') . ' - ' . $e->getMessage());
                }
            } else {
                set_alert('danger', _l('customer_merge_select_both'));
            }
        }

        $data['title'] = _l('merge_customers');
        $data['customer_id'] = $customer_id;

        if ($customer_id) {
            $data['customer'] = $this->clients_model->get($customer_id);
        }

        $this->load->view('customer_merge/merge_customers', $data);
    }

    /**
     * Get customer data for preview
     * @return JSON
     */
    public function get_customer_data()
    {
        if (!has_permission('customer_merge', '', 'view')) {
            echo json_encode(['success' => false, 'message' => _l('access_denied')]);
            die;
        }

        $customer_id = $this->input->post('customer_id');
        
        if (!$customer_id) {
            echo json_encode(['success' => false, 'message' => _l('customer_not_found')]);
            die;
        }

        $customer = $this->clients_model->get($customer_id);
        
        if (!$customer) {
            echo json_encode(['success' => false, 'message' => _l('customer_not_found')]);
            die;
        }

        // Get primary contact
        $this->db->where('userid', $customer_id);
        $this->db->where('is_primary', 1);
        $primary_contact = $this->db->get(db_prefix() . 'contacts')->row();

        // Get number of contacts
        $this->db->where('userid', $customer_id);
        $contacts_count = $this->db->count_all_results(db_prefix() . 'contacts');

        // Get number of invoices
        $this->db->where('clientid', $customer_id);
        $invoices_count = $this->db->count_all_results(db_prefix() . 'invoices');

        // Get number of estimates
        $this->db->where('clientid', $customer_id);
        $estimates_count = $this->db->count_all_results(db_prefix() . 'estimates');

        // Get number of projects
        $this->db->where('clientid', $customer_id);
        $projects_count = $this->db->count_all_results(db_prefix() . 'projects');

        // Get number of tickets
        $this->db->where('userid', $customer_id);
        $tickets_count = $this->db->count_all_results(db_prefix() . 'tickets');
        
        // Get number of notes
        $this->db->where('rel_id', $customer_id);
        $this->db->where('rel_type', 'customer');
        $notes_count = $this->db->count_all_results(db_prefix() . 'notes');
        
        // Get number of tasks
        $this->db->where('rel_id', $customer_id);
        $this->db->where('rel_type', 'customer');
        $tasks_count = $this->db->count_all_results(db_prefix() . 'tasks');
        
        // Get number of payments
        $this->db->where('clientid', $customer_id);
        $payments_count = $this->db->count_all_results(db_prefix() . 'invoices');
        $this->db->select('COUNT(*) as count');
        $this->db->join(db_prefix() . 'invoices', db_prefix() . 'invoices.id = ' . db_prefix() . 'invoicepaymentrecords.invoiceid');
        $this->db->where(db_prefix() . 'invoices.clientid', $customer_id);
        $payments_result = $this->db->get(db_prefix() . 'invoicepaymentrecords')->row();
        $payments_count = $payments_result ? $payments_result->count : 0;
        
        // Get number of files
        $this->db->where('rel_id', $customer_id);
        $this->db->where('rel_type', 'customer');
        $files_count = $this->db->count_all_results(db_prefix() . 'files');

        // Get customer groups
        $customer_groups = $this->clients_model->get_customer_groups($customer_id);
        $groups = [];
        
        foreach ($customer_groups as $group) {
            $this->db->where('id', $group['groupid']);
            $group_info = $this->db->get(db_prefix() . 'customers_groups')->row();
            if ($group_info) {
                $groups[] = $group_info->name;
            }
        }

        $data = [
            'success' => true,
            'customer' => [
                'id' => $customer->userid,
                'company' => $customer->company,
                'vat' => $customer->vat,
                'phonenumber' => $customer->phonenumber,
                'website' => $customer->website,
                'address' => $customer->address,
                'city' => $customer->city,
                'state' => $customer->state,
                'zip' => $customer->zip,
                'country' => get_country_name($customer->country),
                'primary_contact' => $primary_contact ? $primary_contact->firstname . ' ' . $primary_contact->lastname : '',
                'primary_email' => $primary_contact ? $primary_contact->email : '',
                'contacts_count' => $contacts_count,
                'invoices_count' => $invoices_count,
                'estimates_count' => $estimates_count,
                'projects_count' => $projects_count,
                'tickets_count' => $tickets_count,
                'notes_count' => $notes_count,
                'tasks_count' => $tasks_count,
                'payments_count' => $payments_count,
                'files_count' => $files_count,
                'groups' => $groups
            ]
        ];

        echo json_encode($data);
    }

    /**
     * Search customers for merge
     * @return JSON
     */
    public function search_customers()
    {
        if (!has_permission('customer_merge', '', 'view')) {
            echo json_encode([]);
            die;
        }

        $search = $this->input->post('q');
        $exclude_id = $this->input->post('exclude_id');
        
        $customers = $this->customer_merge_model->get_customers_for_merge($search, $exclude_id);
        
        $result = [];
        foreach ($customers as $customer) {
            $result[] = [
                'id' => $customer['userid'],
                'text' => '[ID: ' . $customer['userid'] . '] ' . $customer['company']
            ];
        }
        
        echo json_encode($result);
    }

    /**
     * Get customer contacts
     * @return JSON
     */
    public function get_customer_contacts()
    {
        if (!has_permission('customer_merge', '', 'view')) {
            echo json_encode(['success' => false, 'message' => _l('access_denied')]);
            die;
        }

        $customer_id = $this->input->post('customer_id');
        
        if (!$customer_id) {
            echo json_encode(['success' => false, 'message' => _l('customer_not_found')]);
            die;
        }

        $this->db->where('userid', $customer_id);
        $contacts = $this->db->get(db_prefix() . 'contacts')->result_array();
        
        echo json_encode(['success' => true, 'contacts' => $contacts]);
    }
} 