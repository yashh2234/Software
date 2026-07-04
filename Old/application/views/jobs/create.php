<div class="content-wrapper">
  <section class="content-header">
    <h1>Create UID Job <small>workflow selection required</small></h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url('jobs') ?>">UID Jobs</a></li>
      <li class="active">Create</li>
    </ol>
  </section>

  <section class="content">
    <?php if(isset($error)): ?>
      <div class="alert alert-danger"><?php echo html_escape($error); ?></div>
    <?php endif; ?>

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">UID Master</h3>
      </div>
      <form method="post" action="<?php echo base_url('jobs/create') ?>">
        <div class="box-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>UID No. <span class="text-danger">*</span></label>
                <input type="text" name="uid_no" class="form-control" value="<?php echo set_value('uid_no'); ?>" autocomplete="off">
                <?php echo form_error('uid_no'); ?>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Workflow <span class="text-danger">*</span></label>
                <select name="workflow_template_id" class="form-control">
                  <option value="">Select Workflow</option>
                  <?php foreach($workflows as $workflow): ?>
                    <option value="<?php echo $workflow['id']; ?>" <?php echo set_select('workflow_template_id', $workflow['id']); ?>><?php echo html_escape($workflow['name']); ?></option>
                  <?php endforeach; ?>
                </select>
                <?php echo form_error('workflow_template_id'); ?>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Priority <span class="text-danger">*</span></label>
                <select name="priority" class="form-control">
                  <option value="normal" <?php echo set_select('priority', 'normal', true); ?>>Normal</option>
                  <option value="high" <?php echo set_select('priority', 'high'); ?>>High</option>
                  <option value="urgent" <?php echo set_select('priority', 'urgent'); ?>>Urgent</option>
                  <option value="low" <?php echo set_select('priority', 'low'); ?>>Low</option>
                </select>
                <?php echo form_error('priority'); ?>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Job Title <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" value="<?php echo set_value('title'); ?>" autocomplete="off">
                <?php echo form_error('title'); ?>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Project Type</label>
                <input type="text" name="project_type" class="form-control" value="<?php echo set_value('project_type', 'laboratory'); ?>" autocomplete="off">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Expected Completion</label>
                <input type="date" name="expected_completion_date" class="form-control" value="<?php echo set_value('expected_completion_date'); ?>">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Initial Owner</label>
                <select name="assigned_user_id" class="form-control">
                  <option value="">Unassigned</option>
                  <?php foreach($users as $user): ?>
                    <?php $label = trim($user['firstname'].' '.$user['lastname']); ?>
                    <option value="<?php echo $user['id']; ?>" <?php echo set_select('assigned_user_id', $user['id']); ?>><?php echo html_escape($label ? $label : $user['username']); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="box-footer">
          <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Create UID Job</button>
          <a href="<?php echo base_url('jobs') ?>" class="btn btn-default">Cancel</a>
        </div>
      </form>
    </div>
  </section>
</div>
