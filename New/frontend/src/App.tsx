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
import { StoresPage } from './pages/StoresPage'
import { WorkflowTemplatesPage } from './pages/WorkflowTemplatesPage'
import { JobsPage } from './pages/JobsPage'
import { PermissionsPage } from './pages/PermissionsPage'
import { DocumentLibraryPage } from './pages/DocumentLibraryPage'
import { ClientsPage } from './pages/ClientsPage'
import { AnalyticsPage } from './pages/AnalyticsPage'
import InquiriesPage from './pages/InquiriesPage'
import QuotationsPage from './pages/QuotationsPage'
import WorkOrdersPage from './pages/WorkOrdersPage'
import DispatchPage from './pages/DispatchPage'
import OutsourcePage from './pages/OutsourcePage'
import { AppShell } from './components/AppShell'
import { useState } from 'react'
import type { ModuleKey } from './lib/types'
import { Briefcase, ClipboardList, FlaskConical, BarChart3, CreditCard, Building2, ShieldCheck, type LucideIcon } from 'lucide-react'

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
      label: 'Jobs',
      icon: Briefcase,
      items: [
        { key: 'jobs', label: 'All Jobs' },
      ],
    },
    {
      label: 'Sales',
      icon: ClipboardList,
      items: [
        { key: 'inquiries', label: 'Inquiry' },
        { key: 'quotations', label: 'Quotation' },
        { key: 'work_orders', label: 'Work Orders' },
      ],
    },
    {
      label: 'Laboratory',
      icon: FlaskConical,
      items: [
        { key: 'registrations', label: 'Registration' },
        { key: 'lab', label: 'Testing' },
        { key: 'outsource', label: 'Outsource' },
      ],
    },
    {
      label: 'Reports',
      icon: BarChart3,
      items: [
        { key: 'reports', label: 'All Reports' },
        { key: 'due_reports', label: 'Due Reports' },
        { key: 'final_reports', label: 'Final Reports' },
      ],
    },
    {
      label: 'Finance',
      icon: CreditCard,
      items: [
        { key: 'billing', label: 'Billing' },
        { key: 'invoices', label: 'Invoices' },
        { key: 'dispatches', label: 'Dispatch' },
        { key: 'expenses', label: 'Expenses' },
        { key: 'purchase_orders', label: 'Purchase Orders' },
      ],
    },
    {
      label: 'Masters',
      icon: Building2,
      items: [
        { key: 'clients', label: 'Clients' },
        { key: 'users', label: 'Users' },
        { key: 'stores', label: 'Stores' },
        { key: 'ulr_links', label: 'ULR Links' },
      ],
    },
    {
      label: 'Administration',
      icon: ShieldCheck,
      items: [
        { key: 'roles', label: 'Roles' },
        { key: 'permissions', label: 'Permissions' },
        { key: 'workflow_templates', label: 'Workflows' },
        { key: 'documents', label: 'Documents' },
        { key: 'analytics', label: 'Analytics' },
        { key: 'audit', label: 'Audit Log' },
        { key: 'user_tracking', label: 'User Tracking' },
        { key: 'settings', label: 'Settings' },
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
      <div className={`view ${activeModule === 'reports' ? 'visible' : ''}`}>
        {activeModule === 'reports' && <ReportsPage />}
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
      <div className={`view ${activeModule === 'dispatches' ? 'visible' : ''}`}>
        {activeModule === 'dispatches' && <DispatchPage />}
      </div>
      <div className={`view ${activeModule === 'outsource' ? 'visible' : ''}`}>
        {activeModule === 'outsource' && <OutsourcePage />}
      </div>
      <div className={`view ${activeModule === 'ulr_links' ? 'visible' : ''}`}>
        {activeModule === 'ulr_links' && <UlrLinkPage />}
      </div>
      <div className={`view ${activeModule === 'stores' ? 'visible' : ''}`}>
        {activeModule === 'stores' && <StoresPage />}
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
