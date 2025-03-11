<?php
defined('BASEPATH') or exit('No direct script access allowed');

// This is a test file to check if Swedish language is loaded correctly
// You can access this file via: https://your-domain.com/admin/customer_merge/test_swedish

class Test_swedish extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        // Set language to Swedish
        $this->session->set_userdata(['language' => 'swedish']);
        
        // Load the language file
        $this->lang->load('customer_merge_lang', 'swedish', false, true, FCPATH . 'modules/customer_merge/language/');
        
        // Output some translated strings
        echo '<h1>' . _l('customer_merge') . '</h1>';
        echo '<p>' . _l('customer_merge_warning') . '</p>';
        echo '<p>' . _l('primary_contact_note') . '</p>';
        
        // Reset language to default
        $this->session->unset_userdata('language');
    }
} 