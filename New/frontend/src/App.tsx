import { AuthProvider, useAuth } from './lib/auth'
import { LoginPage } from './pages/LoginPage'
import { DashboardPage } from './pages/DashboardPage'
import { UsersPage } from './pages/UsersPage'
import { RegistrationsPage } from './pages/RegistrationsPage'
import { BillingPage } from './pages/BillingPage'
import { ReportsPage } from './pages/ReportsPage'
import { RolesPage } from './pages/RolesPage'
import { SettingsPage } from './pages/SettingsPage'
import { ExpensesPage } from './pages/ExpensesPage'
import { PurchaseOrdersPage } from './pages/PurchaseOrdersPage'
import { LabPage } from './pages/LabPage'
import { UserTrackingPage } from './pages/UserTrackingPage'
import { InvoicePage } from './pages/InvoicePage'
import { DueReportsPage } from './pages/DueReportsPage'
import { FinalReportsPage } from './pages/FinalReportsPage'
import { UlrLinkPage } from './pages/UlrLinkPage'
import { WorkflowTemplatesPage } from './pages/WorkflowTemplatesPage'
import { JobsPage } from './pages/JobsPage'
import { PermissionsPage } from './pages/PermissionsPage'
import { DocumentLibraryPage } from './pages/DocumentLibraryPage'
import { ClientsPage } from './pages/ClientsPage'
import { AnalyticsPage } from './pages/AnalyticsPage'
import InquiriesPage from './pages/InquiriesPage'
import QuotationsPage from './pages/QuotationsPage'
import WorkOrdersPage from './pages/WorkOrdersPage'
import OutsourcePage from './pages/OutsourcePage'
import { AppShell } from './components/AppShell'
import { useState } from 'react'
import type { ModuleKey } from './lib/types'
import { Briefcase, ClipboardList, FlaskConical, Users, ReceiptText, IndianRupee, Settings, ClipboardCheck, type LucideIcon } from 'lucide-react'

interface NavItem {
  key: string
  label: string
}

interface NavGroup {
  label: string
  icon: LucideIcon
  items: NavItem[]
}

function AuthenticatedApp() {
  const [activeModule, setActiveModule] = useState<ModuleKey>('dashboard')

  const groups: NavGroup[] = [
    {
      label: 'Users',
      icon: Users,
      items: [
        { key: 'users', label: 'Manage Users' },
      ],
    },
    {
      label: 'Groups',
      icon: Users,
      items: [
        { key: 'roles', label: 'Manage Groups' },
        { key: 'permissions', label: 'Permissions' },
      ],
    },
    {
      label: 'Client Registration',
      icon: ClipboardList,
      items: [
        { key: 'registrations', label: 'Manage Registration' },
      ],
    },
    {
      label: 'Lab Reports',
      icon: FlaskConical,
      items: [
        { key: 'reports', label: 'All Lab Reports' },
      ],
    },
    {
      label: 'Manage ULR',
      icon: ClipboardList,
      items: [
        { key: 'ulr_links', label: 'Manage ULR Register' },
      ],
    },
    {
      label: 'Final Reports',
      icon: ClipboardCheck,
      items: [
        { key: 'final_reports', label: 'Final Reports' },
      ],
    },
    {
      label: 'Billing',
      icon: ReceiptText,
      items: [
        { key: 'billing', label: 'All Bills' },
      ],
    },
    {
      label: 'Uid w/o Report',
      icon: ClipboardList,
      items: [
        { key: 'due_reports', label: 'Uid w/o Report' },
      ],
    },
    {
      label: 'Daily Expenses',
      icon: IndianRupee,
      items: [
        { key: 'expenses', label: 'Daily Expenses' },
      ],
    },
    {
      label: 'Purchase Order',
      icon: IndianRupee,
      items: [
        { key: 'purchase_orders', label: 'Purchase Order' },
      ],
    },
    {
      label: 'Invoice',
      icon: ReceiptText,
      items: [
        { key: 'invoices', label: 'Invoice' },
      ],
    },
    {
      label: 'Company',
      icon: Settings,
      items: [
        { key: 'settings', label: 'Company Settings' },
      ],
    },
    {
      label: 'Workflow & System',
      icon: Briefcase,
      items: [
        { key: 'jobs', label: 'UID Register' },
        { key: 'inquiries', label: 'Inquiries' },
        { key: 'quotations', label: 'Quotations' },
        { key: 'work_orders', label: 'Work Orders' },
        { key: 'lab', label: 'Testing' },
        { key: 'outsource', label: 'Outsource' },
        { key: 'user_tracking', label: 'User Tracking' },
        { key: 'documents', label: 'Documents' },
      ],
    },
  ]

  return (
    <AppShell
      groups={groups}
      activeModule={activeModule}
      onModuleChange={(key) => { setActiveModule(key as ModuleKey) }}
    >
      <div className={`view ${activeModule === 'dashboard' ? 'visible' : ''}`}>
        {activeModule === 'dashboard' && <DashboardPage />}
      </div>
      <div className={`view ${activeModule === 'users' ? 'visible' : ''}`}>
        {activeModule === 'users' && <UsersPage />}
      </div>
      <div className={`view ${activeModule === 'roles' ? 'visible' : ''}`}>
        {activeModule === 'roles' && <RolesPage />}
      </div>
      <div className={`view ${activeModule === 'clients' ? 'visible' : ''}`}>
        {activeModule === 'clients' && <ClientsPage />}
      </div>
      <div className={`view ${activeModule === 'inquiries' ? 'visible' : ''}`}>
        {activeModule === 'inquiries' && <InquiriesPage />}
      </div>
      <div className={`view ${activeModule === 'quotations' ? 'visible' : ''}`}>
        {activeModule === 'quotations' && <QuotationsPage />}
      </div>
      <div className={`view ${activeModule === 'work_orders' ? 'visible' : ''}`}>
        {activeModule === 'work_orders' && <WorkOrdersPage />}
      </div>
      <div className={`view ${activeModule === 'registrations' ? 'visible' : ''}`}>
        {activeModule === 'registrations' && <RegistrationsPage />}
      </div>
      <div className={`view ${activeModule === 'billing' ? 'visible' : ''}`}>
        {activeModule === 'billing' && <BillingPage />}
      </div>
      <div className={`view ${activeModule === 'lab' ? 'visible' : ''}`}>
        {activeModule === 'lab' && <LabPage />}
      </div>
      <div className={`view ${activeModule.startsWith('report') ? 'visible' : ''}`}>
        {activeModule.startsWith('report') && <ReportsPage defaultType={activeModule.startsWith('report_') ? activeModule.replace('report_', '') : undefined} />}
      </div>
      <div className={`view ${activeModule === 'expenses' ? 'visible' : ''}`}>
        {activeModule === 'expenses' && <ExpensesPage />}
      </div>
      <div className={`view ${activeModule === 'purchase_orders' ? 'visible' : ''}`}>
        {activeModule === 'purchase_orders' && <PurchaseOrdersPage />}
      </div>
      <div className={`view ${activeModule === 'due_reports' ? 'visible' : ''}`}>
        {activeModule === 'due_reports' && <DueReportsPage />}
      </div>
      <div className={`view ${activeModule === 'final_reports' ? 'visible' : ''}`}>
        {activeModule === 'final_reports' && <FinalReportsPage />}
      </div>
      <div className={`view ${activeModule === 'outsource' ? 'visible' : ''}`}>
        {activeModule === 'outsource' && <OutsourcePage />}
      </div>
      <div className={`view ${activeModule === 'ulr_links' ? 'visible' : ''}`}>
        {activeModule === 'ulr_links' && <UlrLinkPage />}
      </div>
      <div className={`view ${activeModule === 'analytics' ? 'visible' : ''}`}>
        {activeModule === 'analytics' && <AnalyticsPage />}
      </div>
      <div className={`view ${activeModule === 'workflow_templates' ? 'visible' : ''}`}>
        {activeModule === 'workflow_templates' && <WorkflowTemplatesPage />}
      </div>
      <div className={`view ${activeModule === 'jobs' ? 'visible' : ''}`}>
        {activeModule === 'jobs' && <JobsPage />}
      </div>
      <div className={`view ${activeModule === 'user_tracking' ? 'visible' : ''}`}>
        {activeModule === 'user_tracking' && <UserTrackingPage />}
      </div>
      <div className={`view ${activeModule === 'invoices' ? 'visible' : ''}`}>
        {activeModule === 'invoices' && <InvoicePage />}
      </div>
      <div className={`view ${activeModule === 'documents' ? 'visible' : ''}`}>
        {activeModule === 'documents' && <DocumentLibraryPage />}
      </div>
      <div className={`view ${activeModule === 'permissions' ? 'visible' : ''}`}>
        {activeModule === 'permissions' && <PermissionsPage />}
      </div>
      <div className={`view ${activeModule === 'settings' ? 'visible' : ''}`}>
        {activeModule === 'settings' && <SettingsPage />}
      </div>
    </AppShell>
  )
}

export default function App() {
  return (
    <AuthProvider>
      <AppInner />
    </AuthProvider>
  )
}

function AppInner() {
  const { token, loading } = useAuth()

  if (loading) {
    return (
      <div className="loading-screen">
        <p>Loading workspace...</p>
      </div>
    )
  }

  if (!token) {
    return <LoginPage />
  }

  return <AuthenticatedApp />
}
