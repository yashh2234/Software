import { useCallback, useEffect, useState } from 'react'
import { Check, X, FlaskConical, Play, FileText, UserCheck, History, RotateCcw } from 'lucide-react'
import { api } from '../lib/api'
import { Timeline } from '../components/Timeline'

import type { CubeReport } from '../lib/types'

interface ReportTypeInfo {
  key: string
  label: string
  total: number
  pending: number
  testing: number
  generated: number
  assigned_to_me: number
}

const STATUS_FLOW: Record<string, { label: string; color: string; next: string[] }> = {
  Pending: { label: 'Pending', color: '#e8a838', next: ['Testing'] },
  Testing: { label: 'Testing', color: '#3b82f6', next: ['Report Generated'] },
  'Report Generated': { label: 'Report Generated', color: '#8b5cf6', next: ['Complete'] },
  Complete: { label: 'Complete', color: '#22c55e', next: [] },
  Cancel: { label: 'Cancel', color: '#ef4444', next: [] },
}

export function ReportsPage() {
  const [types, setTypes] = useState<ReportTypeInfo[]>([])
  const [activeType, setActiveType] = useState<string>('')
  const [reports, setReports] = useState<CubeReport[]>([])
  const [users, setUsers] = useState<Array<{ id: number; firstname: string; lastname: string }>>([])
  const [loading, setLoading] = useState(true)
  const [localError, setLocalError] = useState('')
  const [statusFilter, setStatusFilter] = useState<string>('')
  const [assigning, setAssigning] = useState<number | null>(null)
  const [timelineReportId, setTimelineReportId] = useState<number | null>(null)
  const [timelineData, setTimelineData] = useState<Array<{ event: string; timestamp: string | null; icon: string; user?: string }>>([])

  const loadTypes = useCallback(async () => {
    try {
      const data = await api.reportTypes()
      setTypes(data.data)
      if (data.data.length > 0 && !activeType) {
        setActiveType(data.data[0].key)
      }
    } catch {
      setLocalError('Unable to load report types')
    }
  }, [activeType])

  const loadReports = useCallback(async () => {
    if (!activeType) return
    setLoading(true)
    try {
      const params = new URLSearchParams()
      if (statusFilter) params.set('status', statusFilter)
      const data = await api.reports(`${activeType}?${params.toString()}` as any)
      setReports(data.data)
    } catch {
      setLocalError('Unable to load reports')
    } finally {
      setLoading(false)
    }
  }, [activeType, statusFilter])

  const loadUsers = useCallback(async () => {
    try {
      const data = await api.users()
      setUsers(data.data as any)
    } catch {}
  }, [])

  useEffect(() => { void loadTypes() }, [loadTypes])
  useEffect(() => { void loadReports() }, [loadReports])
  useEffect(() => { void loadUsers() }, [loadUsers])

  useEffect(() => {
    if (timelineReportId === null) return
    api.reportTimeline(timelineReportId).then((d) => setTimelineData(d.data)).catch(() => {})
  }, [timelineReportId])

  const handleApprove = async (reportId: number) => {
    try {
      await api.approveReport(reportId)
      await loadReports()
    } catch {
      setLocalError('Approval failed')
    }
  }

  const handleReapprove = async (reportId: number) => {
    try {
      await api.reapproveReport(reportId)
      await loadReports()
    } catch {
      setLocalError('Reapprove failed')
    }
  }

  const handleCancel = async (reportId: number) => {
    try {
      await api.cancelReport(reportId)
      await loadReports()
    } catch {
      setLocalError('Cancel failed')
    }
  }

  const handleStartTesting = async (reportId: number) => {
    try {
      await api.startTesting(reportId)
      await loadReports()
    } catch {
      setLocalError('Start testing failed')
    }
  }

  const handleGenerateReport = async (reportId: number) => {
    try {
      await api.generateReport(reportId)
      await loadReports()
    } catch {
      setLocalError('Generate report failed')
    }
  }

  const handleAssign = async (reportId: number, userId: number) => {
    try {
      await api.assignReport(reportId, userId)
      setAssigning(null)
      await loadReports()
    } catch {
      setLocalError('Assign failed')
    }
  }

  const activeTypeInfo = types.find((t) => t.key === activeType)

  const statusSteps = ['Pending', 'Testing', 'Report Generated', 'Complete']

  const renderActions = (report: CubeReport) => {
    const flow = STATUS_FLOW[report.status ?? '']
    if (!flow) return null

    const actions: React.ReactNode[] = []

    if (report.status === 'Pending') {
      actions.push(
        <button
          key="assign"
          className="icon-button"
          onClick={() => setAssigning(assigning === report.iReportId ? null : report.iReportId)}
          type="button"
          title="Assign to lab tech"
        >
          <UserCheck size={17} />
        </button>,
      )
    }

    if (report.status === 'Testing') {
      actions.push(
        <button key="start" className="icon-button" onClick={() => void handleStartTesting(report.iReportId)} type="button" title="Start testing">
          <Play size={17} />
        </button>,
        <button key="gen" className="icon-button" onClick={() => void handleGenerateReport(report.iReportId)} type="button" title="Generate report">
          <FileText size={17} />
        </button>,
      )
    }

    if (report.status === 'Report Generated') {
      actions.push(
        <button key="appr" className="icon-button" onClick={() => void handleApprove(report.iReportId)} type="button" title="Approve">
          <Check size={17} />
        </button>,
      )
    }

    if (report.status === 'Cancel') {
      actions.push(
        <button key="reappr" className="icon-button" onClick={() => void handleReapprove(report.iReportId)} type="button" title="Reapprove">
          <RotateCcw size={17} />
        </button>,
      )
    }

    actions.push(
      <button key="timeline" className="icon-button" onClick={() => setTimelineReportId(report.iReportId)} type="button" title="View timeline">
        <History size={17} />
      </button>,
    )

    if (!['Complete', 'Cancel'].includes(report.status ?? '')) {
      actions.push(
        <button key="cancel" className="icon-button" onClick={() => void handleCancel(report.iReportId)} type="button" title="Cancel">
          <X size={17} />
        </button>,
      )
    }

    return actions
  }

  return (
    <div className="two-column" style={{ gridTemplateColumns: '220px minmax(0, 1fr)' }}>
      <section className="surface" style={{ alignContent: 'start' }}>
        <div className="surface-heading">
          <div>
            <p className="section-label">Report types</p>
            <h2>All tests</h2>
          </div>
        </div>
        <nav style={{ display: 'grid', gap: 4 }}>
          {types.map((type) => (
            <button
              key={type.key}
              type="button"
              className={activeType === type.key ? 'ghost-button' : ''}
              style={{
                justifyContent: 'flex-start',
                textAlign: 'left',
                padding: '10px 12px',
                background: activeType === type.key ? '#edf6f4' : 'transparent',
                border: activeType === type.key ? '1px solid #cfe2dd' : '1px solid transparent',
                borderRadius: 8,
                cursor: 'pointer',
                fontWeight: activeType === type.key ? 700 : 500,
              }}
              onClick={() => setActiveType(type.key)}
            >
              <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%', alignItems: 'center' }}>
                <span>{type.label}</span>
                <span style={{ fontSize: '0.78rem', color: type.pending > 0 ? '#b65f3c' : '#65737d' }}>
                  {type.assigned_to_me > 0
                    ? `${type.assigned_to_me} mine`
                    : type.pending > 0
                      ? `${type.pending} pend`
                      : type.testing > 0
                        ? `${type.testing} test`
                        : type.total}
                </span>
              </div>
            </button>
          ))}
        </nav>
      </section>

      <section className="surface">
        <div className="surface-heading">
          <div>
            <p className="section-label">{activeTypeInfo?.label ?? 'Reports'}</p>
            <h2>Report queue</h2>
          </div>
          <div style={{ display: 'flex', gap: 8, alignItems: 'center' }}>
            <FlaskConical size={18} />
            <span className="sync-pill">{reports.length} reports</span>
          </div>
        </div>

        <div style={{ display: 'flex', gap: 6, marginBottom: 16, flexWrap: 'wrap' }}>
          {statusSteps.map((step) => {
            const count = step === 'Pending'
              ? activeTypeInfo?.pending
              : step === 'Testing'
                ? activeTypeInfo?.testing
                : step === 'Report Generated'
                  ? activeTypeInfo?.generated
                  : undefined
            return (
              <button
                key={step}
                type="button"
                onClick={() => setStatusFilter(statusFilter === step ? '' : step)}
                style={{
                  padding: '6px 14px',
                  borderRadius: 20,
                  border: `1px solid ${statusFilter === step ? STATUS_FLOW[step]?.color ?? '#ccc' : '#d0d7de'}`,
                  background: statusFilter === step ? `${STATUS_FLOW[step]?.color}15` : 'transparent',
                  fontSize: '0.82rem',
                  cursor: 'pointer',
                  fontWeight: statusFilter === step ? 700 : 500,
                }}
              >
                <span style={{ display: 'flex', alignItems: 'center', gap: 4 }}>
                  {step}
                  {count !== undefined && count > 0 ? <span style={{ opacity: 0.6 }}>({count})</span> : null}
                </span>
              </button>
            )
          })}
          {statusFilter ? (
            <button type="button" onClick={() => setStatusFilter('')} style={{ padding: '6px 14px', borderRadius: 20, border: '1px solid #d0d7de', background: 'transparent', fontSize: '0.82rem', cursor: 'pointer' }}>
              Clear
            </button>
          ) : null}
        </div>

        {localError ? <div className="error-banner">{localError}</div> : null}

        {loading ? (
          <p className="empty-state">Loading reports...</p>
        ) : reports.length === 0 ? (
          <p className="empty-state">No {activeTypeInfo?.label?.toLowerCase() ?? ''} reports found.</p>
        ) : (
          <div className="report-stack">
            {reports.map((report) => {
              const statusInfo = STATUS_FLOW[report.status ?? ''] ?? { label: report.status ?? 'Unknown', color: '#999' }
              return (
                <article className="report-row" key={report.iReportId}>
                  <div>
                    <strong>{report.uid_no}</strong>
                    <span>{report.agency_name}</span>
                    <small>{report.material_details ?? 'N/A'} | {report.create_date ?? '-'}</small>
                  </div>
                  <div className="row-actions">
                    <span
                      className="status-tag"
                      style={{
                        background: `${statusInfo.color}20`,
                        color: statusInfo.color,
                        border: `1px solid ${statusInfo.color}40`,
                      }}
                    >
                      {statusInfo.label}
                    </span>
                    {renderActions(report)}
                  </div>
                  {assigning === report.iReportId ? (
                    <div style={{ gridColumn: '1 / -1', display: 'flex', gap: 6, flexWrap: 'wrap', padding: '8px 0', borderTop: '1px solid #e5eaed' }}>
                      <span style={{ fontSize: '0.82rem', fontWeight: 600, alignSelf: 'center' }}>Assign to:</span>
                      {users.map((u) => (
                        <button
                          key={u.id}
                          type="button"
                          onClick={() => void handleAssign(report.iReportId, u.id)}
                          style={{ padding: '4px 10px', borderRadius: 16, border: '1px solid #d0d7de', background: 'transparent', fontSize: '0.78rem', cursor: 'pointer' }}
                        >
                          {u.firstname} {u.lastname}
                        </button>
                      ))}
                    </div>
                  ) : null}
                </article>
              )
            })}
          </div>
        )}
      </section>

      {timelineReportId !== null ? (
        <Timeline entries={timelineData} onClose={() => { setTimelineReportId(null); setTimelineData([]) }} />
      ) : null}
    </div>
  )
}