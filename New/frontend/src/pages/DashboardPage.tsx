import { useCallback, useEffect, useState } from 'react'
import { ClipboardList, UserCheck, AlertTriangle, Briefcase, Eye, ThumbsUp, CreditCard, Truck, Sparkles } from 'lucide-react'
import { useAuth } from '../lib/auth'
import { MetricCard } from '../components/MetricCard'
import { DashboardAnalyticsWidget } from '../components/DashboardAnalyticsWidget'
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
  const { user, dashboard } = useAuth()
  useTracking('dashboard')

  // Period / Date range state for Analytics
  const [period, setPeriod] = useState<string>('monthly')
  const [fromDate, setFromDate] = useState<string>(() => {
    const d = new Date()
    d.setDate(1)
    return d.toISOString().substring(0, 10)
  })
  const [toDate, setToDate] = useState<string>(() => new Date().toISOString().substring(0, 10))

  const [trends, setTrends] = useState<TrendsData | null>(null)
  const [assignedCount, setAssignedCount] = useState(0)
  const [monthExpenses, setMonthExpenses] = useState<Array<{ category: string; total: number }>>([])
  const [trackingSummary, setTrackingSummary] = useState<any>(null)
  const [recentActivities, setRecentActivities] = useState<any[]>([])

  const role = detectRole(user?.permissions ?? [], user?.groups ?? [])
  const metrics = dashboard?.metrics ?? {}

  const loadTrends = useCallback(async (p: string, fDate?: string, tDate?: string) => {
    try {
      const params = new URLSearchParams()
      params.set('period', p)
      if (p === 'custom' && fDate && tDate) {
        params.set('from_date', fDate)
        params.set('to_date', tDate)
      }
      const data = await request<TrendsData>(`/dashboard/trends?${params.toString()}`)
      setTrends(data)
    } catch {}
  }, [])

  const handlePeriodChange = (newPeriod: string, fDate?: string, tDate?: string) => {
    setPeriod(newPeriod)
    if (fDate) setFromDate(fDate)
    if (tDate) setToDate(tDate)
    void loadTrends(newPeriod, fDate || fromDate, tDate || toDate)
  }

  const loadAssigned = useCallback(async () => {
    try {
      const data = await api.myAssigned()
      setAssignedCount(data.count)
    } catch {}
  }, [])

  const loadExpenses = useCallback(async () => {
    try {
      const data = await api.monthlyExpenses()
      setMonthExpenses(data.data)
    } catch {}
  }, [])

  const loadTracking = useCallback(async () => {
    try {
      const summaryData = await api.trackSummary()
      setTrackingSummary(summaryData)
      const actData = await api.userActivity()
      setRecentActivities((actData.activities || []).filter((a: any) => a.action !== 'page_visit'))
    } catch {}
  }, [])

  useEffect(() => {
    void loadTrends(period, fromDate, toDate)
    void loadAssigned()
    void loadExpenses()
    void loadTracking()
  }, [period, fromDate, toDate, loadTrends, loadAssigned, loadExpenses, loadTracking])

  // Job-based metric cards
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
    },
    {
      label: 'Pending Approval',
      value: metrics.jobs_pending_approval ?? 0,
      detail: 'Waiting for final approval',
      icon: ThumbsUp,
    },
    {
      label: 'Pending Billing',
      value: metrics.jobs_pending_billing ?? 0,
      detail: 'Awaiting invoice generation',
      icon: CreditCard,
    },
    {
      label: 'Pending Dispatch',
      value: metrics.jobs_pending_dispatch ?? 0,
      detail: 'Awaiting dispatch',
      icon: Truck,
    },
    {
      label: 'Overdue SLA',
      value: metrics.jobs_overdue ?? 0,
      detail: 'SLA breached',
      icon: AlertTriangle,
    },
  ]

  // My Tasks card
  const myTasksCard = () => {
    const myPending = metrics.my_pending_jobs ?? 0
    const myReviews = metrics.my_pending_reviews ?? 0
    const total = myPending + myReviews

    if (total === 0 && assignedCount === 0) return null

    return (
      <section className="surface p-5 rounded-xl border border-default-200 bg-content1 shadow-sm mb-6">
        <div className="surface-heading flex items-center justify-between mb-4">
          <div>
            <p className="text-xs font-semibold text-primary uppercase tracking-wider">My Tasks</p>
            <h2 className="text-lg font-bold text-default-900">Assigned Work Items</h2>
          </div>
          <UserCheck size={20} className="text-primary" />
        </div>
        <div className="grid grid-cols-1 sm:grid-cols-3 gap-4">
          {myPending > 0 ? (
            <div className="p-4 rounded-lg bg-primary-50/60 border border-primary-200 text-center">
              <strong className="text-2xl font-bold text-primary-700">{myPending}</strong>
              <p className="text-xs text-primary-800 font-medium mt-1">Pending Jobs</p>
            </div>
          ) : null}
          {myReviews > 0 ? (
            <div className="p-4 rounded-lg bg-warning-50/60 border border-warning-200 text-center">
              <strong className="text-2xl font-bold text-warning-700">{myReviews}</strong>
              <p className="text-xs text-warning-800 font-medium mt-1">Pending Reviews</p>
            </div>
          ) : null}
          {assignedCount > 0 ? (
            <div className="p-4 rounded-lg bg-success-50/60 border border-success-200 text-center">
              <strong className="text-2xl font-bold text-success-700">{assignedCount}</strong>
              <p className="text-xs text-success-800 font-medium mt-1">Assigned Testing Samples</p>
            </div>
          ) : null}
        </div>
      </section>
    )
  }

  return (
    <div className="space-y-6 pb-12">
      {/* Welcome & Command Header */}
      <section className="surface p-6 rounded-xl border border-default-200 bg-gradient-to-r from-default-100 to-content1 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
          <div className="flex items-center gap-2 mb-1">
            <Sparkles size={16} className="text-primary" />
            <span className="text-xs font-semibold text-primary uppercase tracking-wider">Laboratory Command Center</span>
          </div>
          <h1 className="text-2xl font-extrabold text-default-900">
            Welcome back, {user?.name || 'User'}!
          </h1>
          <p className="text-xs text-default-500 mt-1">
            Role: <span className="font-semibold text-default-700 uppercase">{role}</span> | Operations, test workflows & real-time analytics.
          </p>
        </div>

        {/* Quick summary tags */}
        <div className="flex items-center gap-3 flex-wrap">
          <div className="px-3 py-1.5 rounded-lg bg-content1 border border-default-200 text-xs">
            <span className="text-default-500">Today Registrations: </span>
            <strong className="text-default-900">{metrics.today_registration ?? 0}</strong>
          </div>
          <div className="px-3 py-1.5 rounded-lg bg-content1 border border-default-200 text-xs">
            <span className="text-default-500">Today Revenue: </span>
            <strong className="text-success font-bold">₹{money(metrics.today_balance_amount ?? 0)}</strong>
          </div>
        </div>
      </section>

      {/* My Tasks Section */}
      {myTasksCard()}

      {/* KPI Job Metrics Strip */}
      <section className="metric-strip grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-7 gap-3">
        {jobMetrics.map((m) => (
          <MetricCard key={m.label} label={m.label} value={m.value} detail={m.detail} icon={m.icon} />
        ))}
      </section>

      {/* Dashboard Analytics & User Operational Activity with Timeframe Selector */}
      <DashboardAnalyticsWidget
        trends={trends}
        monthExpenses={monthExpenses}
        trackingSummary={trackingSummary}
        recentActivities={recentActivities}
        period={period}
        fromDate={fromDate}
        toDate={toDate}
        onPeriodChange={handlePeriodChange}
      />
    </div>
  )
}
