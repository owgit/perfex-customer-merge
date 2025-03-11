<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="customer-merge-header">
                            <?php if(isset($icon)): ?>
                            <img src="<?php echo $icon; ?>" alt="<?php echo _l('customer_merge'); ?>">
                            <?php endif; ?>
                            <h4><?php echo _l('customer_merge'); ?></h4>
                        </div>
                        
                        <div class="_buttons">
                            <a href="<?php echo admin_url('customer_merge/merge'); ?>" class="btn btn-info pull-left display-block">
                                <?php echo _l('merge_new_customers'); ?>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />
                        
                        <?php if (!has_permission('customer_merge', '', 'create')) { ?>
                            <div class="alert alert-warning">
                                <?php echo _l('customer_merge_permission_notice'); ?>
                            </div>
                        <?php } ?>
                        
                        <div class="clearfix"></div>
                        
                        <?php if (count($merge_history) > 0) { ?>
                            <table class="table dt-table" data-order-col="4" data-order-type="desc">
                                <thead>
                                    <tr>
                                        <th><?php echo _l('source_customer'); ?></th>
                                        <th><?php echo _l('target_customer'); ?></th>
                                        <th><?php echo _l('merged_by'); ?></th>
                                        <th><?php echo _l('merged_data'); ?></th>
                                        <th><?php echo _l('date'); ?></th>
                                        <th><?php echo _l('status'); ?></th>
                                        <th><?php echo _l('options'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($merge_history as $history) { ?>
                                        <tr>
                                            <td>
                                                <?php echo $history['source_customer_name']; ?> 
                                                <span class="text-muted">[ID: <?php echo $history['source_customer_id']; ?>]</span>
                                            </td>
                                            <td>
                                                <a href="<?php echo admin_url('clients/client/' . $history['target_customer_id']); ?>" target="_blank">
                                                    <?php echo $history['target_customer_name']; ?>
                                                </a>
                                                <span class="text-muted">[ID: <?php echo $history['target_customer_id']; ?>]</span>
                                            </td>
                                            <td>
                                                <?php echo get_staff_full_name($history['staff_id']); ?>
                                            </td>
                                            <td>
                                                <?php 
                                                $merged_data = unserialize($history['merged_data']);
                                                if (is_array($merged_data)) {
                                                    echo implode(', ', $merged_data);
                                                }
                                                ?>
                                            </td>
                                            <td data-order="<?php echo strtotime($history['date']); ?>">
                                                <?php echo _dt($history['date']); ?>
                                            </td>
                                            <td>
                                                <?php if (isset($history['rolled_back']) && $history['rolled_back'] == 1): ?>
                                                    <span class="label label-info"><?php echo _l('rolled_back'); ?></span>
                                                    <?php if (isset($history['rollback_date']) && !empty($history['rollback_date'])): ?>
                                                        <br><small><?php echo _dt($history['rollback_date']); ?></small>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="label label-success"><?php echo _l('active'); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (has_permission('customer_merge', '', 'create') && (!isset($history['rolled_back']) || $history['rolled_back'] == 0)): ?>
                                                    <a href="<?php echo admin_url('customer_merge/rollback/' . $history['id']); ?>" 
                                                       class="btn btn-danger btn-icon" 
                                                       onclick="return confirm('<?php echo _l('confirm_rollback_merge'); ?>');" 
                                                       data-toggle="tooltip" 
                                                       title="<?php echo _l('rollback_merge'); ?>">
                                                        <i class="fa fa-undo"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } else { ?>
                            <p class="no-margin"><?php echo _l('no_merge_history'); ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?> 