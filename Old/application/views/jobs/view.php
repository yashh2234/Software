<div class="content-wrapper">
  <section class="content-header">
    <h1><?php echo html_escape($job['uid_no']); ?> <small>UID 360</small></h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo base_url('jobs') ?>">UID Jobs</a></li>
      <li class="active"><?php echo html_escape($job['uid_no']); ?></li>
    </ol>
  </section>

  <section class="content">
    <?php if($this->session->flashdata('success')): ?>
      <div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $this->session->flashdata('success'); ?></div>
    <?php endif; ?>

    <div class="row">
      <div class="col-md-3 col-sm-6">
        <div class="small-box bg-aqua">
          <div class="inner"><h4><?php echo html_escape($job['workflow_name']); ?></h4><p>Workflow</p></div>
          <div class="icon"><i class="fa fa-sitemap"></i></div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="small-box bg-green">
          <div class="inner"><h4><?php echo html_escape($job['stage_name']); ?></h4><p>Current Stage</p></div>
          <div class="icon"><i class="fa fa-location-arrow"></i></div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="small-box bg-yellow">
          <div class="inner"><h4><?php echo html_escape($job['priority']); ?></h4><p>Priority</p></div>
          <div class="icon"><i class="fa fa-flag"></i></div>
        </div>
      </div>
      <div class="col-md-3 col-sm-6">
        <div class="small-box bg-red">
          <div class="inner"><h4><?php echo html_escape(str_replace('_', ' ', $job['current_status'])); ?></h4><p>Status</p></div>
          <div class="icon"><i class="fa fa-clock-o"></i></div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4">
        <div class="box">
          <div class="box-header with-border"><h3 class="box-title">Summary</h3></div>
          <div class="box-body">
            <dl>
              <dt>Title</dt><dd><?php echo html_escape($job['title']); ?></dd>
              <dt>Owner</dt><dd><?php echo trim(html_escape($job['firstname'].' '.$job['lastname'])); ?></dd>
              <dt>Project Type</dt><dd><?php echo html_escape($job['project_type']); ?></dd>
              <dt>Expected Completion</dt><dd><?php echo html_escape($job['expected_completion_date']); ?></dd>
              <dt>Created</dt><dd><?php echo html_escape($job['created_at']); ?></dd>
            </dl>
          </div>
        </div>

        <div class="box">
          <div class="box-header with-border"><h3 class="box-title">Legacy Registration</h3></div>
          <div class="box-body">
            <?php if($legacy_registration): ?>
              <dl>
                <dt>Agency</dt><dd><?php echo html_escape($legacy_registration['agency_name']); ?></dd>
                <dt>Mobile</dt><dd><?php echo html_escape($legacy_registration['mobile_no']); ?></dd>
                <dt>Work Order</dt><dd><?php echo html_escape($legacy_registration['work_order_no']); ?></dd>
                <dt>Balance Dues</dt><dd><?php echo html_escape($legacy_registration['balance_dues']); ?></dd>
              </dl>
            <?php else: ?>
              <p class="text-muted">No legacy registration is linked by UID yet.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <div class="col-md-5">
        <div class="box">
          <div class="box-header with-border"><h3 class="box-title">Timeline</h3></div>
          <div class="box-body">
            <?php if(empty($timeline)): ?>
              <p class="text-muted">No timeline events yet.</p>
            <?php endif; ?>
            <ul class="timeline timeline-inverse">
              <?php foreach($timeline as $event): ?>
                <li>
                  <i class="fa fa-history bg-blue"></i>
                  <div class="timeline-item">
                    <span class="time"><i class="fa fa-clock-o"></i> <?php echo html_escape($event['created_at']); ?></span>
                    <h3 class="timeline-header"><?php echo html_escape($event['title']); ?></h3>
                    <div class="timeline-body">
                      <?php echo html_escape($event['description']); ?><br>
                      <small><?php echo trim(html_escape($event['firstname'].' '.$event['lastname'])); ?></small>
                    </div>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="box">
          <div class="box-header with-border"><h3 class="box-title">Assignments</h3></div>
          <div class="box-body">
            <?php if(empty($assignments)): ?>
              <p class="text-muted">No active assignment.</p>
            <?php endif; ?>
            <?php foreach($assignments as $assignment): ?>
              <p>
                <strong><?php echo html_escape($assignment['stage_name']); ?></strong><br>
                <?php echo trim(html_escape($assignment['firstname'].' '.$assignment['lastname'])); ?><br>
                <span class="label label-default"><?php echo html_escape($assignment['status']); ?></span>
                <small class="text-muted"><?php echo html_escape($assignment['due_date']); ?></small>
              </p>
              <hr>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="box">
          <div class="box-header with-border"><h3 class="box-title">Next ERP Areas</h3></div>
          <div class="box-body">
            <p class="text-muted">Documents, samples, reports, billing and dispatch panels will attach here as each phase is implemented.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
