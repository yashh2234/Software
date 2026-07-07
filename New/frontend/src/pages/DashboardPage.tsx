import { useCallback, useEffect, useState } from 'react'
import { ClipboardList, Check, UserCheck, FileText, AlertTriangle, Briefcase, Eye, ThumbsUp, CreditCard, Truck } from 'lucide-react'
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
  const { user, dashboard, sessions } = useAuth()
  useTracking('dashboard')
  const [trends, setTrends] = useState<TrendsData | null>(null)
  const [trendsLoading, setTrendsLoading] = useState(true)
  const [assignedCount, setAssignedCount] = useState(0)

  const role = detectRole(user?.permissions ?? [], user?.groups ?? [])
  const metrics = dashboard?.metrics ?? {}

  const loadTrends = useCallback(async () => {
    setTrendsLoading(true)
    try {
      const data = await request<TrendsData>('/dashboard/trends')
      setTrends(data)
    } catch {
    } finally {
      setTrendsLoading(false)
    }
  }, [])

  const loadAssigned = useCallback(async () => {
    try {
      const data = await api.myAssigned()
      setAssignedCount(data.count)
    } catch {}
  }, [])

  useEffect(() => {
    void loadTrends()
    void loadAssigned()
  }, [loadTrends, loadAssigned])

  // Job-based metric cards (always visible)
  const jobMetrics = [
    {
      label: 'Jobs Today',
      value: metrics.jobs_today ?? 0,
      detail: `${metrics.jobs_completed_today ?? 0} completed today`,
      icon: ClipboardList,
    },
    {
      label: 'Active Jobs',
      value: metrics.jobs_active ?? 0,
      detail: `${metrics.jobs_completed ?? 0} total completed`,
      icon: Briefcase,
    },
    {
      label: 'Pending Review',
      value: metrics.jobs_pending_review ?? 0,
      detail: 'Waiting for technical review',
      icon: Eye,
      accent: true,
    },
    {
      label: 'Pending Approval',
      value: metrics.jobs_pending_approval ?? 0,
      detail: 'Waiting for final approval',
      icon: ThumbsUp,
      accent: true,
    },
    {
      label: 'Pending Billing',
      value: metrics.jobs_pending_billing ?? 0,
      detail: 'Awaiting invoice generation',
      icon: CreditCard,
      accent: true,
    },
    {
      label: 'Pending Dispatch',
      value: metrics.jobs_pending_dispatch ?? 0,
      detail: 'Awaiting dispatch',
      icon: Truck,
      accent: true,
    },
    {
      label: 'Overdue',
      value: metrics.jobs_overdue ?? 0,
      detail: 'SLA breached',
      icon: AlertTriangle,
      danger: true,
    },
  ]

  // My Tasks (role-based)
  const myTasksCard = () => {
    const myPending = metrics.my_pending_jobs ?? 0
    const myReviews = metrics.my_pending_reviews ?? 0
    const total = myPending + myReviews

    if (total === 0) return null

    return (
      <section className="surface" style={{ marginBottom: '1.25rem' }}>
        <div className="surface-heading">
          <div>
            <p className="section-label">My Tasks</p>
            <h2>Assigned to me</h2>
          </div>
          <UserCheck size={20} />
        </div>
        <div style={{ display: 'flex', gap: 16, padding: '0 20px 20px' }}>
          {myPending > 0 ? (
            <div style={{ flex: 1, padding: 16, background: '#edf6f4', borderRadius: 8, textAlign: 'center' }}>
              <strong style={{ fontSize: '1.5rem', color: '#195340' }}>{myPending}</strong>
              <p style={{ fontSize: '0.82rem', color: '#327268', margin: '4px 0 0' }}>Pending Jobs</p>
            </div>
          ) : null}
          {myReviews > 0 ? (
            <div style={{ flex: 1, padding: 16, background: '#fef3c7', borderRadius: 8, textAlign: 'center' }}>
              <strong style={{ fontSize: '1.5rem', color: '#92400e' }}>{myReviews}</strong>
              <p style={{ fontSize: '0.82rem', color: '#92400e', margin: '4px 0 0' }}>Pending Reviews</p>
            </div>
          ) : null}
        </div>
      </section>
    )
  }

  return (
    <>
      {/* My Tasks section */}
      {myTasksCard()}

      {/* Job-based metrics strip */}
      <section className="metric-strip">
        {jobMetrics.map((m) => (
          <MetricCard key={m.label} label={m.label} value={m.value} detail={m.detail} icon={m.icon} />
        ))}
      </section>

      {/* Legacy metrics for reception */}
      {(role === 'admin' || role === 'reception') ? (
        <>
          <div className="two-column" style={{ marginTop: '1.25rem' }}>
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

          {/* Legacy summary */}
          <div className="two-column" style={{ marginTop: '1.25rem' }}>
            <section className="surface">
              <div className="surface-heading">
                <div>
                  <p className="section-label">Today</p>
                  <h2>Work summary</h2>
                </div>
              </div>
              <div className="summary-list">
                <span>{metrics.today_registration ?? 0} registrations received</span>
                <span>{metrics.today_reports ?? 0} reports created</span>
                <span>{money(metrics.today_balance_amount ?? 0)} balance raised</span>
              </div>
            </section>
          </div>
        </>
      ) : null}

      {/* Lab tech view */}
      {role === 'lab_tech' && assignedCount > 0 ? (
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

      {/* Session info for admin */}
      {role === 'admin' ? (
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
      ) : null}
    </>
  )
}
