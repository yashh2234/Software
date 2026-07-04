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
import { AuditLogPage } from './pages/AuditLogPage'
import { UserTrackingPage } from './pages/UserTrackingPage'
import { InvoicePage } from './pages/InvoicePage'
import { DueReportsPage } from './pages/DueReportsPage'
import { FinalReportsPage } from './pages/FinalReportsPage'
import { UlrLinkPage } from './pages/UlrLinkPage'
import { StoresPage } from './pages/StoresPage'
import { AppShell } from './components/AppShell'
import { useState } from 'react'
import type { ModuleKey } from './lib/types'

function AuthenticatedApp() {
  const [activeModule, setActiveModule] = useState<ModuleKey>('dashboard')

  const modules: { key: ModuleKey; label: string }[] = [
    { key: 'dashboard', label: 'Dashboard' },
    { key: 'lab', label: 'Lab' },
    { key: 'users', label: 'Users' },
    { key: 'roles', label: 'Roles' },
    { key: 'registrations', label: 'Registration' },
    { key: 'billing', label: 'Billing' },
    { key: 'invoices', label: 'Invoices' },
    { key: 'reports', label: 'Reports' },
    { key: 'expenses', label: 'Expenses' },
    { key: 'purchase_orders', label: 'Purchase Orders' },
    { key: 'due_reports', label: 'Due Reports' },
    { key: 'final_reports', label: 'Final Reports' },
    { key: 'ulr_links', label: 'ULR Links' },
    { key: 'stores', label: 'Stores' },
    { key: 'audit', label: 'Audit Log' },
    { key: 'user_tracking', label: 'User Tracking' },
    { key: 'settings', label: 'Settings' },
  ]

  return (
    <AppShell
      modules={modules}
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
      <div className={`view ${activeModule === 'ulr_links' ? 'visible' : ''}`}>
        {activeModule === 'ulr_links' && <UlrLinkPage />}
      </div>
      <div className={`view ${activeModule === 'stores' ? 'visible' : ''}`}>
        {activeModule === 'stores' && <StoresPage />}
      </div>
      <div className={`view ${activeModule === 'audit' ? 'visible' : ''}`}>
        {activeModule === 'audit' && <AuditLogPage />}
      </div>
      <div className={`view ${activeModule === 'user_tracking' ? 'visible' : ''}`}>
        {activeModule === 'user_tracking' && <UserTrackingPage />}
      </div>
      <div className={`view ${activeModule === 'invoices' ? 'visible' : ''}`}>
        {activeModule === 'invoices' && <InvoicePage />}
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
