import { useCallback, useEffect, useState } from 'react'
import { ClipboardList, FlaskConical, IndianRupee, ReceiptText, ShieldCheck, Check, UserCheck, FileText, Play, Users, Clock, AlertTriangle } from 'lucide-react'
import { useAuth } from '../lib/auth'
import { MetricCard } from '../components/MetricCard'
import { RegistrationTrendChart, MonthlyRevenueChart, ReportStatusChart } from '../components/Charts'
import { api, request } from '../lib/api'
import { useTracking } from '../lib/useTracking'

interface TrendsData {
  monthly_registrations: Array<{
    month: string
    total: number
    total_amount: number
    received_amount: number
    balance_amount: number
  }>
  report_statuses: {
    total: number
    pending: number
    complete: number
    cancel: number
  }
  today_reports: number
}

function money(value: number) {
  return new Intl.NumberFormat('en-IN', { maximumFractionDigits: 0 }).format(value)
}

type RoleType = 'admin' | 'reception' | 'lab_tech' | 'approver' | 'staff'

function detectRole(permissions: string[], groups: Array<{ id: number; group_name: string }>): RoleType {
  if (groups.some((g) => g.id === 1 || g.group_name.toLowerCase() === 'administrator')) return 'admin'
  if (permissions.some((p) => p.toLowerCase().includes('approve'))) return 'approver'
  if (permissions.some((p) => p.toLowerCase().includes('lab') || p.toLowerCase().includes('test'))) return 'lab_tech'
  if (permissions.some((p) => p.toLowerCase().includes('registration') || p.toLowerCase().includes('reception'))) return 'reception'
  return 'staff'
}

export function DashboardPage() {
  const { user, dashboard, sessions, billingDue, roles } = useAuth()
  useTracking('dashboard')
  const [trends, setTrends] = useState<TrendsData | null>(null)
  const [trendsLoading, setTrendsLoading] = useState(true)
  const [assignedCount, setAssignedCount] = useState(0)
  const [slaSummary, setSlaSummary] = useState<{ total_active: number; overdue_count: number; on_track: number } | null>(null)
  const [trackingSummary, setTrackingSummary] = useState<{
    online_count: number
    today_active_users: number
    today_activities: number
    today_reports_generated: number
    today_samples_registered: number
  } | null>(null)

  const role = detectRole(user?.permissions ?? [], user?.groups ?? [])
  const isReceptionOrAbove = ['admin', 'reception'].includes(role)
  const isLabOrAbove = ['admin', 'lab_tech'].includes(role)
  const isApproverOrAbove = ['admin', 'approver'].includes(role)

  const loadTrends = useCallback(async () => {
    setTrendsLoading(true)
    try {
      const data = await request<TrendsData>('/dashboard/trends')
      setTrends(data)
    } catch {
      // Trends are non-critical
    } finally {
      setTrendsLoading(false)
    }
  }, [])

  const loadAssigned = useCallback(async () => {
    if (!isLabOrAbove) return
    try {
      const data = await api.myAssigned()
      setAssignedCount(data.count)
    } catch {}
  }, [isLabOrAbove])

  const loadTracking = useCallback(async () => {
    try {
      const data = await api.trackSummary()
      setTrackingSummary(data)
    } catch {}
  }, [])

  const loadSla = useCallback(async () => {
    try {
      const data = await request<{ total_active: number; overdue_count: number; on_track: number }>('/jobs/sla-summary')
      setSlaSummary(data)
    } catch {}
  }, [])

  useEffect(() => {
    void loadTrends()
    void loadAssigned()
    if (role === 'admin') {
      void loadTracking()
      void loadSla()
    }
  }, [loadTrends, loadAssigned, loadTracking, loadSla, role])

  const adminMetrics = role === 'admin' ? [
    {
      label: 'Active sessions',
      value: sessions.filter((s) => s.active).length,
      detail: `${sessions.length} recent logins`,
      icon: ShieldCheck,
    },
    {
      label: 'Roles',
      value: roles.length,
      detail: `${roles.reduce((s, r) => s + r.users_count, 0)} total users`,
      icon: UserCheck,
    },
    ...(slaSummary ? [{
      label: 'SLA Breaches',
      value: slaSummary.overdue_count,
      detail: `${slaSummary.on_track} of ${slaSummary.total_active} on track`,
      icon: AlertTriangle,
    }] : []),
  ] : []

  const receptionMetrics = isReceptionOrAbove ? [
    {
      label: 'Registrations',
      value: dashboard?.metrics.total_registration ?? 0,
      detail: `${dashboard?.metrics.today_registration ?? 0} today`,
      icon: ClipboardList,
    },
    {
      label: 'Total billing',
      value: money(dashboard?.metrics.total_amount ?? 0),
      detail: `${money(dashboard?.metrics.total_received_amount ?? 0)} received`,
      icon: IndianRupee,
    },
    {
      label: 'Balance due',
      value: money(dashboard?.metrics.total_balance_amount ?? 0),
      detail: `${billingDue.length} invoices open`,
      icon: ReceiptText,
    },
  ] : []

  const labMetrics = isLabOrAbove ? [
    {
      label: 'My assigned',
      value: assignedCount,
      detail: 'samples in progress',
      icon: Play,
    },
  ] : []

  const approverMetrics = isApproverOrAbove ? [
    {
      label: 'Reports',
      value: dashboard?.metrics.total_reports ?? 0,
      detail: `${dashboard?.metrics.pending_reports ?? 0} pending`,
      icon: FlaskConical,
    },
  ] : []

  const metrics = [...receptionMetrics, ...labMetrics, ...approverMetrics, ...adminMetrics]

  return (
    <>
      <section className="metric-strip">
        {metrics.map((m) => (
          <MetricCard key={m.label} {...m} />
        ))}
      </section>

      {role === 'admin' || role === 'reception' ? (
        <>
          <div className="two-column">
            <section className="surface">
              <div className="surface-heading">
                <div>
                  <p className="section-label">Module map</p>
                  <h2>System modules</h2>
                </div>
              </div>
              <div className="module-grid">
                {(dashboard?.modules ?? []).map((moduleName) => (
                  <div className="module-item" key={moduleName}>
                    <Check size={18} />
                    <span>{moduleName}</span>
                  </div>
                ))}
              </div>
            </section>

            {trends && !trendsLoading ? (
              <section className="surface">
                <ReportStatusChart data={trends.report_statuses} />
              </section>
            ) : null}
          </div>

          {trends && !trendsLoading && trends.monthly_registrations.length > 0 ? (
            <div className="two-column" style={{ marginTop: '1.25rem' }}>
              <section className="surface">
                <RegistrationTrendChart data={trends.monthly_registrations} />
              </section>
              <section className="surface">
                <MonthlyRevenueChart data={trends.monthly_registrations} />
              </section>
            </div>
          ) : null}

          <div className="two-column" style={{ marginTop: '1.25rem' }}>
            <section className="surface">
              <div className="surface-heading">
                <div>
                  <p className="section-label">Today</p>
                  <h2>Work summary</h2>
                </div>
              </div>
              <div className="summary-list">
                <span>{dashboard?.metrics.today_registration ?? 0} registrations received</span>
                <span>{dashboard?.metrics.today_reports ?? 0} reports created</span>
                <span>{money(dashboard?.metrics.today_balance_amount ?? 0)} balance raised</span>
              </div>
            </section>
          </div>
        </>
      ) : null}

      {isLabOrAbove && assignedCount > 0 ? (
        <section className="surface" style={{ marginTop: '1.25rem' }}>
          <div className="surface-heading">
            <div>
              <p className="section-label">My work</p>
              <h2>Assigned samples</h2>
            </div>
            <FileText size={20} />
          </div>
          <p className="summary-list">
            <span>You have {assignedCount} sample{assignedCount !== 1 ? 's' : ''} assigned for testing.</span>
          </p>
        </section>
      ) : null}

      <section className="surface" style={{ marginTop: '1.25rem' }}>
        <div className="surface-heading">
          <div>
            <p className="section-label">Security</p>
            <h2>Recent sessions</h2>
          </div>
        </div>
        <div className="session-stack">
          {sessions.length === 0 ? (
            <p className="empty-state">No session history available.</p>
          ) : (
            sessions.slice(0, 5).map((session) => (
              <article className="session-row" key={session.id}>
                <div>
                  <strong>{session.ip_address ?? 'Unknown IP'}</strong>
                  <span>{session.logged_in_at ?? '-'}</span>
                  <small>{session.last_seen_at ?? session.logged_out_at ?? 'Active now'}</small>
                </div>
                <span className={`status-tag ${session.active ? 'complete' : 'cancel'}`}>
                  {session.active ? 'Active' : 'Closed'}
                </span>
              </article>
            ))
          )}
        </div>
      </section>

      {role === 'admin' && slaSummary ? (
        <section className="surface" style={{ marginTop: '1.25rem' }}>
          <div className="surface-heading">
            <div>
              <p className="section-label">SLA Monitoring</p>
              <h2>Job status overview</h2>
            </div>
            <Clock size={20} />
          </div>
          <div className="summary-list">
            <span style={{ color: '#10b981' }}>{slaSummary.on_track} jobs on track</span>
            {slaSummary.overdue_count > 0 ? <span style={{ color: '#ef4444' }}><AlertTriangle size={14} /> {slaSummary.overdue_count} overdue</span> : <span>No overdue jobs</span>}
            <span>{slaSummary.total_active} active total</span>
          </div>
        </section>
      ) : null}

      {role === 'admin' && trackingSummary ? (
        <section className="surface" style={{ marginTop: '1.25rem' }}>
          <div className="surface-heading">
            <div>
              <p className="section-label">Live</p>
              <h2>User tracking summary</h2>
            </div>
          </div>
          <div className="summary-list">
            <span><Users size={14} /> {trackingSummary.online_count} online now</span>
            <span>{trackingSummary.today_active_users} active today</span>
            <span>{trackingSummary.today_activities} total actions</span>
            <span>{trackingSummary.today_reports_generated} reports generated</span>
            <span>{trackingSummary.today_samples_registered} samples registered</span>
          </div>
        </section>
      ) : null}

      {role === 'admin' ? (
        <section className="surface" style={{ marginTop: '1.25rem' }}>
          <div className="surface-heading">
            <div>
              <p className="section-label">Roles</p>
              <h2>User groups & permissions</h2>
            </div>
          </div>
          <div className="role-grid">
            {roles.map((role) => (
              <article className="role-card" key={role.id}>
                <strong>{role.name}</strong>
                <span>{role.users_count} users</span>
                <small>{role.permissions_count} permissions</small>
              </article>
            ))}
          </div>
        </section>
      ) : null}
    </>
  )
}