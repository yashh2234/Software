-- UID-centric Laboratory Workflow ERP additive schema
-- Designed for the existing CodeIgniter application.
-- Review legacy table names and add foreign keys only after confirming production data quality.

CREATE TABLE IF NOT EXISTS departments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  code VARCHAR(50) NOT NULL UNIQUE,
  active TINYINT(1) NOT NULL DEFAULT 1,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS erp_roles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  code VARCHAR(80) NOT NULL UNIQUE,
  description TEXT NULL,
  active TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS erp_permissions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  permission_key VARCHAR(150) NOT NULL UNIQUE,
  module VARCHAR(100) NOT NULL,
  action VARCHAR(80) NOT NULL,
  description TEXT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS erp_role_permissions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  role_id INT NOT NULL,
  permission_id INT NOT NULL,
  UNIQUE KEY uq_role_permission (role_id, permission_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS user_departments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  department_id INT NOT NULL,
  is_primary TINYINT(1) NOT NULL DEFAULT 0,
  UNIQUE KEY uq_user_department (user_id, department_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS crm_inquiries (
  id INT AUTO_INCREMENT PRIMARY KEY,
  inquiry_no VARCHAR(100) NOT NULL UNIQUE,
  client_id INT NULL,
  contact_name VARCHAR(150) NULL,
  contact_phone VARCHAR(50) NULL,
  contact_email VARCHAR(150) NULL,
  source VARCHAR(100) NULL,
  project_type VARCHAR(100) NULL,
  subject VARCHAR(255) NOT NULL,
  description TEXT NULL,
  status ENUM('new','contacted','quotation_sent','negotiation','approved','rejected','converted_to_job') NOT NULL DEFAULT 'new',
  expected_value DECIMAL(14,2) NULL,
  owner_user_id INT NULL,
  next_followup_at DATETIME NULL,
  converted_job_id INT NULL,
  created_by INT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL,
  INDEX idx_crm_status (status),
  INDEX idx_crm_owner_followup (owner_user_id, next_followup_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS crm_followups (
  id INT AUTO_INCREMENT PRIMARY KEY,
  inquiry_id INT NOT NULL,
  followup_at DATETIME NOT NULL,
  mode ENUM('call','email','meeting','whatsapp','sms','other') NOT NULL DEFAULT 'call',
  remarks TEXT NULL,
  next_followup_at DATETIME NULL,
  created_by INT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_followups_inquiry (inquiry_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS quotations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  inquiry_id INT NULL,
  quotation_no VARCHAR(100) NOT NULL UNIQUE,
  client_id INT NULL,
  status ENUM('draft','sent','negotiation','approved','rejected','expired') NOT NULL DEFAULT 'draft',
  subtotal DECIMAL(14,2) NOT NULL DEFAULT 0,
  tax_amount DECIMAL(14,2) NOT NULL DEFAULT 0,
  total_amount DECIMAL(14,2) NOT NULL DEFAULT 0,
  valid_until DATE NULL,
  approved_at DATETIME NULL,
  created_by INT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL,
  INDEX idx_quotations_inquiry (inquiry_id),
  INDEX idx_quotations_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS quotation_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  quotation_id INT NOT NULL,
  description VARCHAR(255) NOT NULL,
  quantity DECIMAL(12,2) NOT NULL DEFAULT 1,
  rate DECIMAL(14,2) NOT NULL DEFAULT 0,
  amount DECIMAL(14,2) NOT NULL DEFAULT 0,
  INDEX idx_quotation_items_quote (quotation_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS workflow_templates (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  code VARCHAR(80) NOT NULL UNIQUE,
  description TEXT NULL,
  project_type VARCHAR(100) NULL,
  is_default TINYINT(1) NOT NULL DEFAULT 0,
  active TINYINT(1) NOT NULL DEFAULT 1,
  created_by INT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS workflow_stages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  workflow_template_id INT NOT NULL,
  name VARCHAR(150) NOT NULL,
  code VARCHAR(80) NOT NULL,
  sequence_no INT NOT NULL,
  department_id INT NULL,
  responsible_role_code VARCHAR(80) NULL,
  sla_hours INT NULL,
  requires_approval TINYINT(1) NOT NULL DEFAULT 0,
  required_document_codes TEXT NULL,
  is_start TINYINT(1) NOT NULL DEFAULT 0,
  is_end TINYINT(1) NOT NULL DEFAULT 0,
  active TINYINT(1) NOT NULL DEFAULT 1,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_workflow_stage_code (workflow_template_id, code),
  INDEX idx_workflow_stage_sequence (workflow_template_id, sequence_no)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS workflow_transitions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  workflow_template_id INT NOT NULL,
  from_stage_id INT NOT NULL,
  to_stage_id INT NOT NULL,
  action_label VARCHAR(150) NOT NULL,
  permission_key VARCHAR(150) NULL,
  validation_rule TEXT NULL,
  active TINYINT(1) NOT NULL DEFAULT 1,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_transition_from (from_stage_id),
  INDEX idx_transition_to (to_stage_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS jobs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  uid_no VARCHAR(100) NOT NULL UNIQUE,
  inquiry_id INT NULL,
  quotation_id INT NULL,
  client_id INT NULL,
  legacy_registration_id INT NULL,
  legacy_ulr_id INT NULL,
  workflow_template_id INT NOT NULL,
  current_stage_id INT NULL,
  title VARCHAR(255) NULL,
  project_type VARCHAR(100) NULL,
  department_id INT NULL,
  priority ENUM('low','normal','high','urgent') NOT NULL DEFAULT 'normal',
  current_status ENUM('draft','active','in_progress','on_hold','delayed','returned','billing_pending','payment_pending','dispatched','completed','cancelled','reopened') NOT NULL DEFAULT 'active',
  assigned_user_id INT NULL,
  expected_completion_date DATE NULL,
  actual_completion_date DATE NULL,
  created_by INT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL,
  INDEX idx_jobs_uid (uid_no),
  INDEX idx_jobs_current (current_status, current_stage_id),
  INDEX idx_jobs_department_owner (department_id, assigned_user_id),
  INDEX idx_jobs_client (client_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS job_workflow_instances (
  id INT AUTO_INCREMENT PRIMARY KEY,
  job_id INT NOT NULL,
  workflow_template_id INT NOT NULL,
  started_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  completed_at DATETIME NULL,
  status ENUM('active','completed','cancelled','paused') NOT NULL DEFAULT 'active',
  INDEX idx_job_workflow_job (job_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS job_stage_history (
  id INT AUTO_INCREMENT PRIMARY KEY,
  job_id INT NOT NULL,
  from_stage_id INT NULL,
  to_stage_id INT NOT NULL,
  status VARCHAR(80) NOT NULL,
  notes TEXT NULL,
  changed_by INT NULL,
  changed_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_stage_history_job (job_id),
  INDEX idx_stage_history_date (changed_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS job_timeline (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  job_id INT NOT NULL,
  event_type VARCHAR(100) NOT NULL,
  title VARCHAR(255) NOT NULL,
  description TEXT NULL,
  actor_user_id INT NULL,
  related_entity_type VARCHAR(100) NULL,
  related_entity_id INT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_timeline_job_date (job_id, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS job_assignments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  job_id INT NOT NULL,
  stage_id INT NULL,
  assigned_by INT NULL,
  assigned_to INT NOT NULL,
  assigned_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  due_date DATETIME NULL,
  priority ENUM('low','normal','high','urgent') NOT NULL DEFAULT 'normal',
  status ENUM('assigned','in_progress','completed','cancelled','overdue') NOT NULL DEFAULT 'assigned',
  remarks TEXT NULL,
  completed_at DATETIME NULL,
  INDEX idx_assignments_job (job_id),
  INDEX idx_assignments_user_status (assigned_to, status),
  INDEX idx_assignments_due (due_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS assignment_comments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  assignment_id INT NOT NULL,
  comment TEXT NOT NULL,
  created_by INT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_assignment_comments (assignment_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS samples (
  id INT AUTO_INCREMENT PRIMARY KEY,
  job_id INT NOT NULL,
  sample_no VARCHAR(100) NOT NULL,
  sample_type VARCHAR(150) NULL,
  description TEXT NULL,
  quantity VARCHAR(80) NULL,
  received_at DATETIME NULL,
  received_by INT NULL,
  barcode_value VARCHAR(150) NULL,
  status ENUM('expected','received','assigned','testing','completed','rejected','disposed') NOT NULL DEFAULT 'expected',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_job_sample_no (job_id, sample_no),
  INDEX idx_samples_job (job_id),
  INDEX idx_samples_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS sample_events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sample_id INT NOT NULL,
  job_id INT NOT NULL,
  event_type VARCHAR(100) NOT NULL,
  notes TEXT NULL,
  created_by INT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_sample_events_sample (sample_id),
  INDEX idx_sample_events_job (job_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS test_assignments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  job_id INT NOT NULL,
  sample_id INT NULL,
  test_type VARCHAR(150) NOT NULL,
  assigned_to INT NOT NULL,
  due_at DATETIME NULL,
  status ENUM('assigned','in_progress','completed','cancelled') NOT NULL DEFAULT 'assigned',
  completed_at DATETIME NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_test_assignments_job (job_id),
  INDEX idx_test_assignments_user (assigned_to, status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS test_results (
  id INT AUTO_INCREMENT PRIMARY KEY,
  test_assignment_id INT NOT NULL,
  job_id INT NOT NULL,
  result_summary TEXT NULL,
  result_data JSON NULL,
  entered_by INT NULL,
  entered_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_test_results_job (job_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS erp_reports (
  id INT AUTO_INCREMENT PRIMARY KEY,
  job_id INT NOT NULL,
  report_no VARCHAR(100) NULL,
  report_type VARCHAR(150) NULL,
  legacy_report_module VARCHAR(100) NULL,
  legacy_report_id INT NULL,
  status ENUM('draft','submitted','returned','approved','dispatched','cancelled') NOT NULL DEFAULT 'draft',
  prepared_by INT NULL,
  approved_by INT NULL,
  approved_at DATETIME NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL,
  INDEX idx_erp_reports_job (job_id),
  INDEX idx_erp_reports_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS report_versions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  report_id INT NOT NULL,
  version_no INT NOT NULL,
  file_path VARCHAR(500) NULL,
  content_snapshot MEDIUMTEXT NULL,
  notes TEXT NULL,
  created_by INT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_report_version (report_id, version_no)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS report_reviews (
  id INT AUTO_INCREMENT PRIMARY KEY,
  report_id INT NOT NULL,
  reviewer_id INT NOT NULL,
  decision ENUM('approved','returned','rejected') NOT NULL,
  remarks TEXT NULL,
  reviewed_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_report_reviews_report (report_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS vendors (
  id INT AUTO_INCREMENT PRIMARY KEY,
  vendor_name VARCHAR(200) NOT NULL,
  contact_name VARCHAR(150) NULL,
  phone VARCHAR(50) NULL,
  email VARCHAR(150) NULL,
  address TEXT NULL,
  gst_no VARCHAR(80) NULL,
  active TINYINT(1) NOT NULL DEFAULT 1,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS vendor_assignments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  job_id INT NOT NULL,
  vendor_id INT NOT NULL,
  scope_of_work TEXT NOT NULL,
  assigned_by INT NULL,
  assigned_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  due_at DATETIME NULL,
  completed_at DATETIME NULL,
  status ENUM('assigned','in_progress','completed','cancelled','overdue') NOT NULL DEFAULT 'assigned',
  INDEX idx_vendor_assignments_job (job_id),
  INDEX idx_vendor_assignments_vendor (vendor_id, status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS vendor_payments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  vendor_assignment_id INT NOT NULL,
  amount DECIMAL(14,2) NOT NULL DEFAULT 0,
  status ENUM('pending','approved','paid','cancelled') NOT NULL DEFAULT 'pending',
  paid_at DATETIME NULL,
  remarks TEXT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_vendor_payments_assignment (vendor_assignment_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS document_types (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  code VARCHAR(80) NOT NULL UNIQUE,
  active TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS job_documents (
  id INT AUTO_INCREMENT PRIMARY KEY,
  job_id INT NOT NULL,
  document_type_id INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  entity_type VARCHAR(100) NULL,
  entity_id INT NULL,
  current_version_id INT NULL,
  status ENUM('draft','submitted','approved','rejected','superseded') NOT NULL DEFAULT 'submitted',
  uploaded_by INT NULL,
  uploaded_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_job_documents_job (job_id),
  INDEX idx_job_documents_entity (entity_type, entity_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS document_versions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  job_document_id INT NOT NULL,
  version_no INT NOT NULL,
  file_name VARCHAR(255) NOT NULL,
  file_path VARCHAR(500) NOT NULL,
  mime_type VARCHAR(150) NULL,
  file_size BIGINT NULL,
  notes TEXT NULL,
  uploaded_by INT NULL,
  uploaded_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_document_version (job_document_id, version_no)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS erp_invoices (
  id INT AUTO_INCREMENT PRIMARY KEY,
  job_id INT NOT NULL,
  invoice_no VARCHAR(100) NOT NULL UNIQUE,
  legacy_invoice_id INT NULL,
  status ENUM('draft','generated','sent','partially_paid','paid','cancelled') NOT NULL DEFAULT 'draft',
  subtotal DECIMAL(14,2) NOT NULL DEFAULT 0,
  gst_amount DECIMAL(14,2) NOT NULL DEFAULT 0,
  total_amount DECIMAL(14,2) NOT NULL DEFAULT 0,
  paid_amount DECIMAL(14,2) NOT NULL DEFAULT 0,
  due_date DATE NULL,
  created_by INT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL,
  INDEX idx_erp_invoices_job (job_id),
  INDEX idx_erp_invoices_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS erp_invoice_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  invoice_id INT NOT NULL,
  description VARCHAR(255) NOT NULL,
  hsn_sac VARCHAR(80) NULL,
  quantity DECIMAL(12,2) NOT NULL DEFAULT 1,
  rate DECIMAL(14,2) NOT NULL DEFAULT 0,
  gst_rate DECIMAL(5,2) NOT NULL DEFAULT 0,
  amount DECIMAL(14,2) NOT NULL DEFAULT 0,
  INDEX idx_erp_invoice_items_invoice (invoice_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS erp_payments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  invoice_id INT NOT NULL,
  job_id INT NOT NULL,
  amount DECIMAL(14,2) NOT NULL,
  payment_mode VARCHAR(80) NULL,
  reference_no VARCHAR(150) NULL,
  paid_at DATETIME NOT NULL,
  received_by INT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_erp_payments_invoice (invoice_id),
  INDEX idx_erp_payments_job (job_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS dispatches (
  id INT AUTO_INCREMENT PRIMARY KEY,
  job_id INT NOT NULL,
  report_id INT NULL,
  dispatch_mode ENUM('email','courier','portal','hand_delivery','other') NOT NULL DEFAULT 'email',
  recipient VARCHAR(255) NULL,
  tracking_no VARCHAR(150) NULL,
  proof_document_id INT NULL,
  dispatched_by INT NULL,
  dispatched_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  status ENUM('pending','dispatched','delivered','failed') NOT NULL DEFAULT 'dispatched',
  INDEX idx_dispatches_job (job_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS alert_rules (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  trigger_type VARCHAR(100) NOT NULL,
  workflow_stage_id INT NULL,
  threshold_hours INT NULL,
  notify_user TINYINT(1) NOT NULL DEFAULT 1,
  notify_manager TINYINT(1) NOT NULL DEFAULT 0,
  notify_admin TINYINT(1) NOT NULL DEFAULT 0,
  channel_in_app TINYINT(1) NOT NULL DEFAULT 1,
  channel_email TINYINT(1) NOT NULL DEFAULT 0,
  channel_sms TINYINT(1) NOT NULL DEFAULT 0,
  channel_whatsapp TINYINT(1) NOT NULL DEFAULT 0,
  active TINYINT(1) NOT NULL DEFAULT 1,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS notifications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  job_id INT NULL,
  user_id INT NOT NULL,
  alert_rule_id INT NULL,
  title VARCHAR(255) NOT NULL,
  message TEXT NULL,
  severity ENUM('info','warning','critical') NOT NULL DEFAULT 'info',
  status ENUM('unread','read','acknowledged','resolved') NOT NULL DEFAULT 'unread',
  due_at DATETIME NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  read_at DATETIME NULL,
  INDEX idx_notifications_user_status (user_id, status),
  INDEX idx_notifications_job (job_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS alert_escalations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  notification_id INT NOT NULL,
  escalated_to_user_id INT NULL,
  escalated_to_role_code VARCHAR(80) NULL,
  escalated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  remarks TEXT NULL,
  INDEX idx_alert_escalations_notification (notification_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS activity_logs (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  job_id INT NULL,
  user_id INT NULL,
  action VARCHAR(100) NOT NULL,
  entity_type VARCHAR(100) NULL,
  entity_id INT NULL,
  previous_value JSON NULL,
  new_value JSON NULL,
  ip_address VARCHAR(45) NULL,
  user_agent VARCHAR(255) NULL,
  device VARCHAR(150) NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_activity_job (job_id),
  INDEX idx_activity_user_date (user_id, created_at),
  INDEX idx_activity_action (action)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS client_users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  client_id INT NOT NULL,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  phone VARCHAR(50) NULL,
  password VARCHAR(255) NOT NULL,
  active TINYINT(1) NOT NULL DEFAULT 1,
  last_login_at DATETIME NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS client_queries (
  id INT AUTO_INCREMENT PRIMARY KEY,
  job_id INT NOT NULL,
  client_user_id INT NOT NULL,
  subject VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  status ENUM('open','in_progress','closed') NOT NULL DEFAULT 'open',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  closed_at DATETIME NULL,
  INDEX idx_client_queries_job (job_id),
  INDEX idx_client_queries_user (client_user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO document_types (name, code) VALUES
('Letter', 'letter'),
('Quotation', 'quotation'),
('Work Order', 'work_order'),
('Sample Image', 'sample_image'),
('Lab Result', 'lab_result'),
('Lab Report', 'lab_report'),
('Final Report', 'final_report'),
('Certificate', 'certificate'),
('Invoice', 'invoice'),
('Dispatch Proof', 'dispatch_proof'),
('Vendor Document', 'vendor_document');

INSERT IGNORE INTO workflow_templates (name, code, description, project_type, is_default, active) VALUES
('Laboratory Testing', 'laboratory_testing', 'Letter to work order, UID, sample, testing, report, approval, billing and dispatch.', 'laboratory', 1, 1),
('Inquiry Based Consultancy', 'consultancy', 'Inquiry, quotation, work order confirmation, UID, technical assignment, review, billing and dispatch.', 'consultancy', 0, 1),
('Outsourced Work', 'outsourced_work', 'Inquiry, quotation, work order, UID, vendor assignment, vendor completion, billing and dispatch.', 'outsourced', 0, 1);
