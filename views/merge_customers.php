<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin"><?php echo _l('merge_customers'); ?></h4>
                        <hr class="hr-panel-heading" />
                        
                        <?php echo form_open(admin_url('customer_merge/merge'), ['id' => 'merge-customers-form']); ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel_s">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"><?php echo _l('source_customer'); ?> <small class="text-danger"><?php echo _l('will_be_deleted'); ?></small></h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="source_customer"><?php echo _l('select_customer'); ?></label>
                                            <select name="source_customer" id="source_customer" class="selectpicker" data-live-search="true" data-width="100%">
                                                <option value=""><?php echo _l('select_customer'); ?></option>
                                                <?php if (isset($customer)) { ?>
                                                <option value="<?php echo $customer->userid; ?>" selected>[ID: <?php echo $customer->userid; ?>] <?php echo $customer->company; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        
                                        <div id="source-customer-details" class="hide">
                                            <hr />
                                            <div class="customer-details"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="panel_s">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"><?php echo _l('target_customer'); ?> <small class="text-success"><?php echo _l('will_be_kept'); ?></small></h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="target_customer"><?php echo _l('select_customer'); ?></label>
                                            <select name="target_customer" id="target_customer" class="selectpicker" data-live-search="true" data-width="100%">
                                                <option value=""><?php echo _l('select_customer'); ?></option>
                                            </select>
                                        </div>
                                        
                                        <div id="target-customer-details" class="hide">
                                            <hr />
                                            <div class="customer-details"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mtop20">
                            <div class="col-md-12">
                                <div class="panel_s">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"><?php echo _l('merge_options'); ?></h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5 class="bold"><?php echo _l('data_to_merge'); ?></h5>
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input type="checkbox" name="merge_options[contacts]" id="merge_contacts" value="1" checked disabled>
                                                        <label for="merge_contacts"><?php echo _l('contacts'); ?> <span class="text-info">(<?php echo _l('always_merged'); ?>)</span></label>
                                                        <p class="text-muted small mtop5"><?php echo _l('contacts_merge_info'); ?></p>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input type="checkbox" name="merge_options[invoices]" id="merge_invoices" value="1" checked>
                                                        <label for="merge_invoices"><?php echo _l('invoices'); ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input type="checkbox" name="merge_options[estimates]" id="merge_estimates" value="1" checked>
                                                        <label for="merge_estimates"><?php echo _l('estimates'); ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input type="checkbox" name="merge_options[credit_notes]" id="merge_credit_notes" value="1" checked>
                                                        <label for="merge_credit_notes"><?php echo _l('credit_notes'); ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input type="checkbox" name="merge_options[projects]" id="merge_projects" value="1" checked>
                                                        <label for="merge_projects"><?php echo _l('projects'); ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input type="checkbox" name="merge_options[expenses]" id="merge_expenses" value="1" checked>
                                                        <label for="merge_expenses"><?php echo _l('expenses'); ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input type="checkbox" name="merge_options[proposals]" id="merge_proposals" value="1" checked>
                                                        <label for="merge_proposals"><?php echo _l('proposals'); ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input type="checkbox" name="merge_options[tickets]" id="merge_tickets" value="1" checked>
                                                        <label for="merge_tickets"><?php echo _l('tickets'); ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input type="checkbox" name="merge_options[contracts]" id="merge_contracts" value="1" checked>
                                                        <label for="merge_contracts"><?php echo _l('contracts'); ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input type="checkbox" name="merge_options[files]" id="merge_files" value="1" checked>
                                                        <label for="merge_files"><?php echo _l('customer_files'); ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input type="checkbox" name="merge_options[notes]" id="merge_notes" value="1" checked>
                                                        <label for="merge_notes"><?php echo _l('notes'); ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input type="checkbox" name="merge_options[reminders]" id="merge_reminders" value="1" checked>
                                                        <label for="merge_reminders"><?php echo _l('reminders'); ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input type="checkbox" name="merge_options[vault]" id="merge_vault" value="1" checked>
                                                        <label for="merge_vault"><?php echo _l('vault_entries'); ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input type="checkbox" name="merge_options[tasks]" id="merge_tasks" value="1" checked>
                                                        <label for="merge_tasks"><?php echo _l('tasks'); ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input type="checkbox" name="merge_options[customer_groups]" id="merge_customer_groups" value="1" checked>
                                                        <label for="merge_customer_groups"><?php echo _l('customer_groups'); ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input type="checkbox" name="merge_options[custom_fields]" id="merge_custom_fields" value="1" checked>
                                                        <label for="merge_custom_fields"><?php echo _l('custom_fields'); ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input type="checkbox" name="merge_options[customer_admins]" id="merge_customer_admins" value="1" checked>
                                                        <label for="merge_customer_admins"><?php echo _l('customer_admins'); ?></label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="checkbox checkbox-primary">
                                                        <input type="checkbox" name="merge_options[payments]" id="merge_payments" value="1" checked>
                                                        <label for="merge_payments"><?php echo _l('payments'); ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <hr />
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h5 class="bold"><?php echo _l('customer_data_to_transfer'); ?></h5>
                                                <p class="text-muted"><?php echo _l('customer_data_transfer_info'); ?></p>
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div class="checkbox checkbox-primary">
                                                                <input type="checkbox" name="customer_data[]" id="transfer_phonenumber" value="phonenumber">
                                                                <label for="transfer_phonenumber"><?php echo _l('client_phonenumber'); ?></label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="checkbox checkbox-primary">
                                                                <input type="checkbox" name="customer_data[]" id="transfer_website" value="website">
                                                                <label for="transfer_website"><?php echo _l('client_website'); ?></label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="checkbox checkbox-primary">
                                                                <input type="checkbox" name="customer_data[]" id="transfer_address" value="address">
                                                                <label for="transfer_address"><?php echo _l('client_address'); ?></label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="checkbox checkbox-primary">
                                                                <input type="checkbox" name="customer_data[]" id="transfer_city" value="city">
                                                                <label for="transfer_city"><?php echo _l('client_city'); ?></label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="checkbox checkbox-primary">
                                                                <input type="checkbox" name="customer_data[]" id="transfer_state" value="state">
                                                                <label for="transfer_state"><?php echo _l('client_state'); ?></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div class="checkbox checkbox-primary">
                                                                <input type="checkbox" name="customer_data[]" id="transfer_zip" value="zip">
                                                                <label for="transfer_zip"><?php echo _l('client_zip'); ?></label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="checkbox checkbox-primary">
                                                                <input type="checkbox" name="customer_data[]" id="transfer_country" value="country">
                                                                <label for="transfer_country"><?php echo _l('client_country'); ?></label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="checkbox checkbox-primary">
                                                                <input type="checkbox" name="customer_data[]" id="transfer_billing_details" value="billing_street,billing_city,billing_state,billing_zip,billing_country">
                                                                <label for="transfer_billing_details"><?php echo _l('billing_details'); ?></label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="checkbox checkbox-primary">
                                                                <input type="checkbox" name="customer_data[]" id="transfer_shipping_details" value="shipping_street,shipping_city,shipping_state,shipping_zip,shipping_country">
                                                                <label for="transfer_shipping_details"><?php echo _l('shipping_details'); ?></label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="checkbox checkbox-primary">
                                                                <input type="checkbox" name="customer_data[]" id="transfer_default_currency" value="default_currency">
                                                                <label for="transfer_default_currency"><?php echo _l('customer_default_currency'); ?></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Note about primary contacts -->
                                        <div class="alert alert-info mtop15">
                                            <p><strong><?php echo _l('primary_contact_note_title'); ?></strong></p>
                                            <p><?php echo _l('primary_contact_note'); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-warning">
                                    <h4 class="bold"><?php echo _l('warning'); ?></h4>
                                    <p><?php echo _l('customer_merge_warning'); ?></p>
                                </div>
                                
                                <div class="form-group">
                                    <div class="checkbox checkbox-danger">
                                        <input type="checkbox" name="confirm_merge" id="confirm_merge" required>
                                        <label for="confirm_merge"><?php echo _l('confirm_merge'); ?></label>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-danger" id="merge-customers-btn" disabled>
                                    <?php echo _l('merge_customers'); ?>
                                </button>
                                <a href="<?php echo admin_url('customer_merge'); ?>" class="btn btn-default">
                                    <?php echo _l('cancel'); ?>
                                </a>
                            </div>
                        </div>
                        
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>

<script>
$(function() {
    // Initialize select2 for customer search
    var sourceCustomerSelect = $('#source_customer');
    var targetCustomerSelect = $('#target_customer');
    
    // Source customer select
    sourceCustomerSelect.on('change', function() {
        var customerId = $(this).val();
        if (customerId) {
            loadCustomerDetails(customerId, 'source');
            
            // Update target customer select to exclude the selected source customer
            initTargetCustomerSelect(customerId);
        } else {
            $('#source-customer-details').addClass('hide');
        }
        
        checkMergeButtonState();
    });
    
    // Target customer select
    targetCustomerSelect.on('change', function() {
        var customerId = $(this).val();
        if (customerId) {
            loadCustomerDetails(customerId, 'target');
        } else {
            $('#target-customer-details').addClass('hide');
        }
        
        checkMergeButtonState();
    });
    
    // Initialize target customer select
    function initTargetCustomerSelect(excludeId) {
        targetCustomerSelect.html('<option value=""><?php echo _l('select_customer'); ?></option>');
        targetCustomerSelect.selectpicker('refresh');
        
        // Enable AJAX search for target customer
        targetCustomerSelect.selectpicker({
            liveSearch: true,
            liveSearchPlaceholder: '<?php echo _l('search_customers'); ?>',
            title: '<?php echo _l('select_customer'); ?>',
            width: '100%'
        }).ajaxSelectPicker({
            ajax: {
                url: admin_url + 'customer_merge/search_customers',
                type: 'POST',
                dataType: 'json',
                data: function() {
                    return {
                        q: '{{{q}}}',
                        exclude_id: excludeId
                    };
                }
            },
            locale: {
                emptyTitle: '<?php echo _l('search_customers'); ?>'
            },
            preserveSelected: false,
            minLength: 2,
            preprocessData: function(data) {
                return data.map(function(item) {
                    return {
                        value: item.id,
                        text: item.text
                    };
                });
            }
        });
    }
    
    // Load customer details
    function loadCustomerDetails(customerId, type) {
        $.ajax({
            url: admin_url + 'customer_merge/get_customer_data',
            type: 'POST',
            data: {
                customer_id: customerId
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    var customer = response.customer;
                    var html = '<table class="table">';
                    
                    html += '<tr><td><strong><?php echo _l('client_company'); ?></strong></td><td>' + customer.company + ' <span class="text-muted">[ID: ' + customer.id + ']</span></td></tr>';
                    html += '<tr><td><strong><?php echo _l('customer_id'); ?></strong></td><td>' + customer.id + '</td></tr>';
                    
                    if (customer.vat) {
                        html += '<tr><td><strong><?php echo _l('client_vat_number'); ?></strong></td><td>' + customer.vat + '</td></tr>';
                    }
                    
                    if (customer.phonenumber) {
                        html += '<tr><td><strong><?php echo _l('client_phonenumber'); ?></strong></td><td>' + customer.phonenumber + '</td></tr>';
                    }
                    
                    if (customer.website) {
                        html += '<tr><td><strong><?php echo _l('client_website'); ?></strong></td><td>' + customer.website + '</td></tr>';
                    }
                    
                    if (customer.address) {
                        html += '<tr><td><strong><?php echo _l('client_address'); ?></strong></td><td>' + customer.address + '</td></tr>';
                    }
                    
                    if (customer.city) {
                        html += '<tr><td><strong><?php echo _l('client_city'); ?></strong></td><td>' + customer.city + '</td></tr>';
                    }
                    
                    if (customer.state) {
                        html += '<tr><td><strong><?php echo _l('client_state'); ?></strong></td><td>' + customer.state + '</td></tr>';
                    }
                    
                    if (customer.zip) {
                        html += '<tr><td><strong><?php echo _l('client_zip'); ?></strong></td><td>' + customer.zip + '</td></tr>';
                    }
                    
                    if (customer.country) {
                        html += '<tr><td><strong><?php echo _l('client_country'); ?></strong></td><td>' + customer.country + '</td></tr>';
                    }
                    
                    if (customer.primary_contact) {
                        html += '<tr><td><strong><?php echo _l('primary_contact'); ?></strong></td><td>' + customer.primary_contact + '</td></tr>';
                    }
                    
                    if (customer.primary_email) {
                        html += '<tr><td><strong><?php echo _l('client_email'); ?></strong></td><td>' + customer.primary_email + '</td></tr>';
                    }
                    
                    html += '<tr><td><strong><?php echo _l('contacts'); ?></strong></td><td>' + customer.contacts_count + '</td></tr>';
                    html += '<tr><td><strong><?php echo _l('invoices'); ?></strong></td><td>' + customer.invoices_count + '</td></tr>';
                    html += '<tr><td><strong><?php echo _l('estimates'); ?></strong></td><td>' + customer.estimates_count + '</td></tr>';
                    html += '<tr><td><strong><?php echo _l('projects'); ?></strong></td><td>' + customer.projects_count + '</td></tr>';
                    html += '<tr><td><strong><?php echo _l('tickets'); ?></strong></td><td>' + customer.tickets_count + '</td></tr>';
                    html += '<tr><td><strong><?php echo _l('notes'); ?></strong></td><td>' + customer.notes_count + '</td></tr>';
                    html += '<tr><td><strong><?php echo _l('tasks'); ?></strong></td><td>' + customer.tasks_count + '</td></tr>';
                    html += '<tr><td><strong><?php echo _l('payments'); ?></strong></td><td>' + customer.payments_count + '</td></tr>';
                    html += '<tr><td><strong><?php echo _l('files'); ?></strong></td><td>' + customer.files_count + '</td></tr>';
                    
                    if (customer.groups.length > 0) {
                        html += '<tr><td><strong><?php echo _l('customer_groups'); ?></strong></td><td>' + customer.groups.join(', ') + '</td></tr>';
                    }
                    
                    html += '</table>';
                    
                    $('#' + type + '-customer-details .customer-details').html(html);
                    $('#' + type + '-customer-details').removeClass('hide');
                } else {
                    alert_float('danger', response.message);
                }
            }
        });
    }
    
    // Confirm merge checkbox
    $('#confirm_merge').on('change', function() {
        checkMergeButtonState();
    });
    
    // Check if merge button should be enabled
    function checkMergeButtonState() {
        var sourceCustomer = sourceCustomerSelect.val();
        var targetCustomer = targetCustomerSelect.val();
        var confirmMerge = $('#confirm_merge').prop('checked');
        
        if (sourceCustomer && targetCustomer && sourceCustomer !== targetCustomer && confirmMerge) {
            $('#merge-customers-btn').prop('disabled', false);
        } else {
            $('#merge-customers-btn').prop('disabled', true);
        }
    }
    
    // Form submission
    $('#merge-customers-form').on('submit', function() {
        if (!confirm('<?php echo _l('confirm_merge_prompt'); ?>')) {
            return false;
        }
        
        $('#merge-customers-btn').prop('disabled', true).html('<?php echo _l('wait_text'); ?>');
    });
    
    // Initialize if customer is pre-selected
    <?php if (isset($customer)) { ?>
    loadCustomerDetails(<?php echo $customer->userid; ?>, 'source');
    initTargetCustomerSelect(<?php echo $customer->userid; ?>);
    <?php } else { ?>
    // Initialize source customer select with AJAX search
    sourceCustomerSelect.selectpicker({
        liveSearch: true,
        liveSearchPlaceholder: '<?php echo _l('search_customers'); ?>',
        title: '<?php echo _l('select_customer'); ?>',
        width: '100%'
    }).ajaxSelectPicker({
        ajax: {
            url: admin_url + 'customer_merge/search_customers',
            type: 'POST',
            dataType: 'json',
            data: function() {
                return {
                    q: '{{{q}}}'
                };
            }
        },
        locale: {
            emptyTitle: '<?php echo _l('search_customers'); ?>'
        },
        preserveSelected: false,
        minLength: 2,
        preprocessData: function(data) {
            return data.map(function(item) {
                return {
                    value: item.id,
                    text: item.text
                };
            });
        }
    });
    <?php } ?>
});
</script> 