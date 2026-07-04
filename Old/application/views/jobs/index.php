<div class="content-wrapper">
  <section class="content-header">
    <h1>UID Jobs <small>Workflow ERP foundation</small></h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">UID Jobs</li>
    </ol>
  </section>

  <section class="content">
    <?php if($this->session->flashdata('success')): ?>
      <div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $this->session->flashdata('success'); ?></div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
      <div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $this->session->flashdata('error'); ?></div>
    <?php endif; ?>

    <?php if(!$erp_ready): ?>
      <div class="alert alert-warning">
        ERP tables are not installed yet. Apply <strong>docs/enterprise_erp_extension_schema.sql</strong> to enable UID Jobs.
      </div>
    <?php endif; ?>

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">UID Register</h3>
        <div class="box-tools">
          <a href="<?php echo base_url('jobs/create') ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Create UID Job</a>
        </div>
      </div>
      <div class="box-body table-responsive">
        <table id="jobsTable" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>UID</th>
              <th>Title</th>
              <th>Workflow</th>
              <th>Current Stage</th>
              <th>Status</th>
              <th>Priority</th>
              <th>Owner</th>
              <th>Due Date</th>
              <th>Created</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($jobs as $job): ?>
              <tr>
                <td><a href="<?php echo base_url('jobs/view/'.rawurlencode($job['uid_no'])) ?>"><?php echo html_escape($job['uid_no']); ?></a></td>
                <td><?php echo html_escape($job['title']); ?></td>
                <td><?php echo html_escape($job['workflow_name']); ?></td>
                <td><?php echo html_escape($job['stage_name']); ?></td>
                <td><span class="label label-info"><?php echo html_escape(str_replace('_', ' ', $job['current_status'])); ?></span></td>
                <td><span class="label label-default"><?php echo html_escape($job['priority']); ?></span></td>
                <td><?php echo trim(html_escape($job['firstname'].' '.$job['lastname'])); ?></td>
                <td><?php echo html_escape($job['expected_completion_date']); ?></td>
                <td><?php echo html_escape($job['created_at']); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>

<script>
$(function () {
  $('#jobsTable').DataTable({
    order: [[8, 'desc']]
  });
});
</script>
