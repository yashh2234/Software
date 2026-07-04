# UID-Centric Laboratory Workflow ERP Blueprint

Version: 1.0  
System: Existing CodeIgniter Laboratory, Testing, Inspection and Consultancy Software  
Modernization approach: Incremental extension, not a rebuild

## 1. Executive Summary

The current application already contains the operational foundation: authentication, user and group permissions, client registration, ULR/UID handling, multiple lab report modules, billing, invoice, purchase order, daily expenses, dashboard, report upload and final reports.

The target product is a UID-centric enterprise workflow ERP. One UID becomes the master record for every inquiry, quotation, letter, work order, sample, test, report, approval, invoice, dispatch record, document, assignment, alert and audit event.

The recommended architecture keeps the existing CodeIgniter application running while adding a workflow layer, UID 360 view, activity/audit logging, document versioning, role dashboards, analytics and client/vendor portals.

## 2. Product Vision

Eliminate manual tracking and give complete visibility from inquiry to completion.

Core outcomes:

- Every job has one UID and one visible lifecycle.
- Every stage is configurable by admins.
- Every task has an owner, due date, priority and status.
- Every document is versioned and linked to UID.
- Every user action is auditable.
- Every department has a workload dashboard.
- Management sees delays, revenue, outstanding, bottlenecks and productivity without Excel follow-up.

## 3. Existing System Baseline

Observed modules in `Old/application`:

- `Auth`, `Users`, `Groups`: login and group permissions.
- `Registration`: client/job registration.
- `Ulrlink`: ULR register and linking.
- Lab report modules: `Cubereport`, `Bitumencore`, `Bitumenloose`, `Interlockingtiles`, `Concretecore`, `Water`, `Mainholecover`, `Ferrocover`, `Concretebeam`, `Bricks`, `Mes`, `Sand`.
- `Finallabreports`, `Reports`, `Duereports`: report management and missing-report views.
- `Billing`, `Invoice`, `Purchaseorder`, `Dailyexpenses`: finance operations.
- `Dashboard`, `Company`: management view and company settings.

Current limitations:

- Workflow stage and SLA are not modeled as configurable data.
- UID is present operationally, but not yet the single relational backbone for every module.
- Reporting modules are separated by test type and need a common job/report layer.
- Documents lack universal versioning and permission-aware UID vault behavior.
- Audit trails are not complete enough for management and compliance.
- Dashboards are not role-specific enough for registration, lab, technical review, billing, dispatch and management.

## 4. Enterprise Software Architecture

Recommended logical architecture:

```
Presentation Layer
  CodeIgniter views, AdminLTE UI, role dashboards, UID 360, client portal

Application Layer
  Controllers for Jobs, CRM, Workflow, Assignments, Documents, Reports,
  Billing, Vendors, Notifications, Analytics, Client Portal

Domain Services
  UID service, Workflow engine, Assignment service, Document service,
  Audit logger, Notification service, SLA/escalation service, Analytics service

Data Layer
  Existing legacy tables plus additive ERP extension tables

Integration Layer
  Email, SMS/WhatsApp-ready adapters, QR/barcode, digital signature,
  accounting export, OCR/AI adapters in later phases
```

Modernization principles:

- Keep existing routes and screens working.
- Add new ERP tables with `legacy_*_id` columns for gradual migration.
- Wrap workflow transitions in database transactions.
- Write timeline, activity log, assignment and alert records from the same business event.
- Centralize UID lookup so all modules can attach data to a job.

## 5. Information Architecture

Primary modules:

- Dashboard
- CRM & Inquiries
- UID Jobs
- Workflow
- Assignments
- Clients
- Samples
- Lab Testing
- Reports & Reviews
- Vendor / Outsource
- Billing & Finance
- Documents
- Dispatch
- Alerts
- Analytics
- Administration
- Client Portal

UID 360 sections:

- Summary
- Client
- Inquiry and quotation
- Letter and work order
- Workflow progress
- Current stage and assignment
- Samples
- Testing
- Reports, reviews and approvals
- Vendor work, when applicable
- Billing and payment
- Dispatch
- Documents and versions
- Alerts
- Activity and audit log

## 6. Module Hierarchy

```
ERP
  Dashboard
    Admin
    Managing Director
    Manager
    Registration
    Lab
    Technical
    Billing
    Dispatch
    Vendor Coordinator
  CRM
    Inquiry Register
    Leads
    Quotations
    Follow-ups
    Inquiry Conversion
  Jobs
    Create UID
    UID Register
    UID 360
    Timeline
    Stage History
  Workflow
    Templates
    Stages
    Transitions
    SLAs
    Escalation Rules
  Samples
    Collection
    Receipt
    Barcode/QR
    Sample Tracking
    Testing Assignment
  Technical
    Test Queues
    Result Entry
    Report Preparation
    Review
    Approval
    Version Control
  Vendors
    Vendor Master
    Assignment
    Scope of Work
    Vendor Documents
    Vendor Completion
    Vendor Payment
    Performance
  Finance
    Invoice
    GST
    Payments
    Outstanding
    Reminders
  Documents
    UID Vault
    Types
    Versions
    Preview
    Permissions
  Analytics
    TAT
    Bottlenecks
    Revenue
    Outstanding
    Productivity
    Vendor Performance
  Administration
    Users
    Roles
    Permissions
    Departments
    Masters
    Company Settings
```

## 7. Complete Sitemap

```
/dashboard
/dashboard/admin
/dashboard/md
/dashboard/manager
/dashboard/registration
/dashboard/lab
/dashboard/technical
/dashboard/billing
/dashboard/dispatch
/dashboard/vendor

/crm/inquiries
/crm/inquiries/create
/crm/inquiries/{id}
/crm/leads
/crm/quotations
/crm/followups
/crm/converted

/jobs
/jobs/create
/jobs/{uid}
/jobs/{uid}/timeline
/jobs/{uid}/assignments
/jobs/{uid}/samples
/jobs/{uid}/reports
/jobs/{uid}/billing
/jobs/{uid}/documents
/jobs/{uid}/activity

/workflow/templates
/workflow/templates/create
/workflow/templates/{id}/builder
/workflow/stages
/workflow/escalations

/assignments
/assignments/my
/assignments/department
/assignments/overdue

/clients
/clients/create
/clients/{id}

/samples
/samples/receive
/samples/{id}
/samples/barcode

/testing/queue
/testing/assigned
/testing/completed

/reports/drafts
/reports/review
/reports/corrections
/reports/approved
/reports/dispatched

/vendors
/vendors/create
/vendors/{id}
/vendors/assignments
/vendors/payments
/vendors/performance

/billing/invoices
/billing/invoices/create
/billing/payments
/billing/outstanding
/billing/reminders

/documents
/documents/{uid}
/documents/types

/dispatch/pending
/dispatch/completed

/alerts
/alerts/rules
/alerts/escalations

/analytics/jobs
/analytics/departments
/analytics/employees
/analytics/vendors
/analytics/revenue
/analytics/ageing

/admin/users
/admin/roles
/admin/permissions
/admin/departments
/admin/masters
/admin/company

/client/login
/client/dashboard
/client/jobs
/client/jobs/{uid}
/client/invoices
/client/queries
```

## 8. Navigation Structure

Recommended left navigation:

- Dashboard
- CRM
- UID Jobs
- My Assignments
- Samples
- Testing
- Reports
- Vendors
- Billing
- Documents
- Dispatch
- Alerts
- Analytics
- Administration

Header actions:

- Global UID/client/work order/invoice search
- Create inquiry
- Create UID
- Notifications
- User profile

Context actions on UID:

- Move stage
- Assign
- Upload document
- Add note
- Create invoice
- Dispatch report
- Hold/reopen/cancel

## 9. User Roles and Permissions Matrix

Legend: C = create, R = read, U = update, A = approve, X = export/admin.

| Module | Admin | MD | Manager | Registration | Lab Tech | Reviewer | Billing | Dispatch | Vendor Coord | Client |
|---|---|---|---|---|---|---|---|---|---|---|
| Users/Roles | CRUX | R | R | - | - | - | - | - | - | - |
| Workflow Setup | CRUX | R | RU | - | - | - | - | - | - | - |
| CRM Inquiry | CRUX | R | RU | CRU | R | R | R | - | R | - |
| UID Job | CRUX | R | RUA | CRU | R | R | R | R | R | R own |
| Assignments | CRUX | R | CRU | CRU | RU own | RU own | RU own | RU own | RU own | - |
| Samples | CRUX | R | R | CRU | CRU | R | - | - | - | R limited |
| Testing | CRUX | R | R | R | CRU | RUA | - | - | R vendor | - |
| Reports | CRUX | R | RUA | R | RU | CRUA | R | R | R vendor | R approved |
| Documents | CRUX | R | RU | CRU | CRU | CRU | CRU | CRU | CRU vendor | R allowed |
| Vendors | CRUX | R | RU | - | R | R | R | - | CRU | - |
| Billing | CRUX | RX | RX | R | - | - | CRU | R | R vendor | R own |
| Payments | CRUX | RX | RX | - | - | - | CRU | - | R vendor | R own |
| Dispatch | CRUX | R | RU | R | - | R | R | CRU | - | R own |
| Activity Logs | RX | RX | RX | R own | R own | R own | R own | R own | R own | - |
| Analytics | RX | RX | RX | R limited | R limited | R limited | R finance | R dispatch | R vendor | - |

## 10. Workflow Engine Design

The workflow engine must be database-configurable.

Workflow template fields:

- Name
- Code
- Description
- Active flag
- Default flag
- Applicable project type
- Created by

Workflow stage fields:

- Template
- Stage name
- Stage code
- Sequence
- Department
- Responsible role
- SLA hours/days
- Required documents
- Required approvals
- Notification rule
- Start/end flags

Transition fields:

- From stage
- To stage
- Action label
- Required permission
- Validation rule
- Auto-assignment rule
- Alert rule

Supported templates:

- Laboratory Testing
- Inquiry Based Consultancy
- Field Inspection
- Outsourced Work
- Custom Workflow

Transition behavior:

1. Validate permission and mandatory documents.
2. Close active assignment if the actor is completing a task.
3. Create next assignment based on stage role/department.
4. Update `jobs.current_stage_id`, status, due date and owner.
5. Insert `job_stage_history`.
6. Insert `job_timeline`.
7. Insert `activity_logs`.
8. Evaluate SLA and notification rules.

## 11. Database Design

Database strategy:

- Keep existing `users`, `groups`, `user_group`, company and legacy report/billing tables.
- Add new ERP tables.
- Link legacy tables through `legacy_registration_id`, `legacy_ulr_id`, `legacy_report_id`, `legacy_billing_id`.
- Use UID as the human-facing unique key and numeric `job_id` as the relational key.

Core entities:

- `jobs`: UID master.
- `crm_inquiries`, `quotations`, `followups`: pre-UID sales pipeline.
- `workflow_templates`, `workflow_stages`, `workflow_transitions`: configurable process.
- `job_workflow_instances`, `job_stage_history`, `job_timeline`: runtime workflow.
- `samples`, `sample_events`: sample register and tracking.
- `job_assignments`: ownership and due dates.
- `job_documents`, `document_versions`: UID document vault.
- `reports`, `report_versions`, `report_reviews`: technical reporting.
- `vendors`, `vendor_assignments`, `vendor_documents`, `vendor_payments`: outsource lifecycle.
- `invoices`, `invoice_items`, `payments`: finance lifecycle.
- `notifications`, `alert_rules`, `alert_escalations`: reminders and escalation.
- `activity_logs`: immutable audit trail.
- `client_users`, `client_queries`: client portal.

Referential principles:

- Most operational tables must include `job_id`.
- Documents may also include `entity_type` and `entity_id` for attachment to sample/report/invoice/vendor assignment.
- Activity logs should allow `job_id` null for login/logout and admin settings.
- Deletions should be logical via `active`, `deleted_at` or status fields.

## 12. Database Tables

Recommended table list:

- `departments`
- `roles`
- `permissions`
- `role_permissions`
- `user_departments`
- `crm_inquiries`
- `crm_followups`
- `quotations`
- `quotation_items`
- `jobs`
- `job_clients`
- `workflow_templates`
- `workflow_stages`
- `workflow_transitions`
- `job_workflow_instances`
- `job_stage_history`
- `job_timeline`
- `job_assignments`
- `assignment_comments`
- `samples`
- `sample_events`
- `test_assignments`
- `test_results`
- `reports`
- `report_versions`
- `report_reviews`
- `report_approvals`
- `vendors`
- `vendor_assignments`
- `vendor_documents`
- `vendor_payments`
- `document_types`
- `job_documents`
- `document_versions`
- `invoices`
- `invoice_items`
- `payments`
- `dispatches`
- `alert_rules`
- `notifications`
- `alert_escalations`
- `activity_logs`
- `client_users`
- `client_queries`

## 13. UID Journey

```
Inquiry
  -> Quotation
  -> Work Order / Letter
  -> UID Created
  -> Workflow Selected
  -> Sample / Technical Assignment
  -> Testing / Execution
  -> Report Preparation
  -> Review
  -> Approval
  -> Billing
  -> Dispatch
  -> Completed
```

UID statuses:

- Draft
- Active
- In Progress
- On Hold
- Delayed
- Returned for Correction
- Billing Pending
- Payment Pending
- Dispatched
- Completed
- Cancelled
- Reopened

UID 360 must answer:

- Who is the client?
- What work was ordered?
- Which workflow is selected?
- Where is the job now?
- Who owns the current action?
- What is due today or overdue?
- What documents exist?
- What reports and invoices are final?
- What changed, when, and by whom?

## 14. User Journeys

Registration journey:

1. Register inquiry or open approved inquiry.
2. Select/create client.
3. Enter letter/work order data.
4. Select project type, department, priority and workflow.
5. Generate UID.
6. Upload work order and supporting documents.
7. Assign to sample receiving, lab or technical team.

Lab journey:

1. Open lab dashboard.
2. Review assigned UID/sample queue.
3. Receive samples and scan QR/barcode.
4. Enter test results or upload result documents.
5. Mark testing complete.
6. Send to report preparation or technical review.

Technical reviewer journey:

1. Open pending review queue.
2. Review report version and supporting documents.
3. Approve, reject or return with comments.
4. Approved reports move to approval/billing/dispatch based on workflow.

Billing journey:

1. Open jobs ready for billing.
2. Generate invoice with GST.
3. Send invoice and mark status.
4. Record payment and outstanding.
5. Trigger reminders for overdue payment.

Dispatch journey:

1. Open approved reports pending dispatch.
2. Validate billing/payment rule.
3. Dispatch report by email/courier/portal.
4. Upload proof of dispatch.
5. Mark UID completed if no pending stage remains.

## 15. Admin Journey

1. Create departments.
2. Configure roles and permissions.
3. Create workflow templates.
4. Add/reorder stages.
5. Set responsible department, role, SLA and required documents per stage.
6. Configure transitions and escalations.
7. Assign users to departments.
8. Monitor activity logs, delayed jobs, dashboard KPIs and analytics.

## 16. Vendor Journey

1. Vendor coordinator selects UID and chooses outsource workflow/stage.
2. Assigns vendor and defines scope of work.
3. Uploads purchase order, scope document and expected completion date.
4. Vendor completion is recorded with documents/certificates.
5. Technical team reviews vendor output.
6. Vendor payment is tracked.
7. Vendor performance is measured by on-time completion, rework and quality.

## 17. Client Journey

1. Client logs into portal.
2. Views only their own UIDs.
3. Opens UID timeline.
4. Downloads approved final reports, invoices and certificates.
5. Views payment status.
6. Raises query against UID.
7. Receives notification when report or invoice is available.

## 18. Dashboard Wireframes

Admin:

```
[Total Jobs] [Delayed Jobs] [Open Alerts] [Revenue] [Outstanding]
[Workflow Bottlenecks by Stage]   [Department Workload]
[Recent Activity]                 [Escalation Queue]
```

Managing Director:

```
[Monthly Revenue] [Outstanding] [On-Time Completion] [Critical Delays]
[Revenue Trend]                  [Client Trend]
[Department Efficiency]          [Employee/Vendor Performance]
```

Registration:

```
[New Inquiries] [Quotations Sent] [UIDs Created Today] [Missing Documents]
[Inquiry Follow-ups Due]
[UID Creation Queue]
```

Lab:

```
[Assigned Samples] [Due Today] [Overdue Tests] [Completed Tests]
[My Testing Queue]
[Sample Timeline]
```

Technical:

```
[Reports Pending Review] [Returned Reports] [Approved Today] [Avg Review Time]
[Review Queue]
[Corrections Required]
```

Billing:

```
[Invoices Draft] [Invoices Sent] [Partially Paid] [Outstanding]
[Payment Follow-up Queue]
[Client-wise Outstanding]
```

Dispatch:

```
[Approved Reports] [Dispatch Pending] [Dispatched Today] [Proof Pending]
[Dispatch Queue]
```

Vendor coordinator:

```
[Vendor Jobs Active] [Vendor Overdue] [Pending Vendor Docs] [Vendor Payments]
[Vendor Assignment Queue]
[Vendor Performance]
```

## 19. API Suggestions

Internal JSON endpoints:

- `GET /api/jobs?status=&stage=&department=&from=&to=`
- `POST /api/jobs`
- `GET /api/jobs/{uid}`
- `POST /api/jobs/{uid}/transition`
- `POST /api/jobs/{uid}/assignments`
- `GET /api/jobs/{uid}/timeline`
- `GET /api/jobs/{uid}/documents`
- `POST /api/jobs/{uid}/documents`
- `POST /api/documents/{id}/versions`
- `GET /api/workflow/templates`
- `POST /api/workflow/templates`
- `POST /api/workflow/templates/{id}/stages`
- `POST /api/crm/inquiries`
- `POST /api/crm/inquiries/{id}/convert`
- `POST /api/samples`
- `POST /api/reports/{id}/review`
- `POST /api/invoices`
- `POST /api/payments`
- `POST /api/vendors/{id}/assignments`
- `GET /api/analytics/jobs`
- `GET /api/analytics/revenue`
- `GET /api/analytics/productivity`

Future external APIs:

- Client portal API.
- Mobile sample collection API.
- WhatsApp/SMS notification adapter.
- Accounting export/integration.
- Digital signature integration.
- OCR document ingestion.

## 20. UI Components

Core components:

- UID global search
- KPI card
- Workflow progress stepper
- Stage transition button group
- Assignment panel
- Timeline feed
- Document vault table
- Version history drawer
- Status badge
- Priority badge
- SLA countdown
- Alert inbox
- Filterable data table
- Kanban by stage
- Report review panel
- Invoice status panel
- Client query panel
- Audit log table

UID 360 layout:

```
[UID | Client | Workflow | Current Stage | Owner | Due Date | Actions]

[Workflow Progress Stepper]

[Summary] [Timeline] [Documents] [Samples] [Testing] [Reports] [Billing] [Activity]

Left: client, work order, priority, expected completion
Center: timeline, current assignment, stage requirements
Right: alerts, next actions, recent documents
```

## 21. UX Recommendations

- Make UID 360 the primary work screen.
- Keep dashboards dense, operational and filterable.
- Use consistent status colors across all modules.
- Avoid overwriting documents; show latest version by default with history available.
- Keep every action contextual to current stage.
- Add saved filters per role.
- Add empty states that explain next action.
- Add global search in the header.
- Add bulk assignment and bulk reminders for managers.
- Use confirmation dialogs for workflow transitions, approvals, cancellation and reopening.

## 22. Phase-wise Product Roadmap

Phase 1: CRM and UID foundation

- Inquiry register, quotation, follow-up, conversion.
- UID master table.
- Workflow selection at UID creation.
- UID 360 shell.

Phase 2: Workflow engine

- Templates, stages, transitions, SLAs.
- Stage history and timeline.
- Assignment creation during transitions.

Phase 3: Samples and testing

- Sample receiving, sample tracking, QR/barcode readiness.
- Common test assignment and result tables.
- Link existing lab report modules to UID.

Phase 4: Reports and documents

- Document vault.
- Report versions.
- Review, correction and approval.
- No-overwrite version policy.

Phase 5: Billing and dispatch

- Invoice lifecycle with GST/payment/outstanding.
- Dispatch queue and proof of dispatch.
- UID completion rules.

Phase 6: Alerts and dashboards

- Role dashboards.
- SLA alerts.
- Escalation to user, manager and admin.

Phase 7: Vendor/outsource

- Vendor master.
- Vendor assignment, documents, payment and performance.

Phase 8: Analytics and management reporting

- TAT, bottlenecks, productivity, revenue and ageing.
- Exportable management reports.

Phase 9: Client portal

- Client login.
- UID status, report download, invoice download, queries.

Phase 10: Future readiness

- Mobile app.
- GPS, QR/barcode, digital signature, offline mode.
- OCR and AI delay prediction.

## 23. Future Scalability Plan

Short term:

- Add indexes on `job_id`, `uid_no`, `current_stage_id`, `assigned_user_id`, `due_date`, `created_at`.
- Keep dashboards backed by optimized SQL views.
- Store documents in a structured path by UID and document type.

Medium term:

- Introduce background jobs for reminders, overdue checks and report generation.
- Use materialized summary tables for analytics.
- Separate read-heavy dashboard queries from write-heavy operational transactions.

Long term:

- Move file storage to object storage.
- Add API tokens/OAuth for mobile and portal clients.
- Add event-driven notifications.
- Add archival strategy for completed UIDs.
- Add AI services for OCR, delay prediction, next-stage suggestion and smart assignment.

## 24. Acceptance Criteria

- New UID cannot be created without workflow selection.
- Every UID shows current stage, owner, department, priority and due date.
- Every stage change writes history, timeline and activity log.
- Every upload creates a document version.
- Every assignment includes assigned by, assigned to, assigned date, due date, priority and status.
- Every dashboard is permission-filtered.
- Client users can only access their own UID data.
- Management can view delayed jobs, revenue, outstanding, employee performance and bottlenecks.

