import { useState, useEffect, type FormEvent } from 'react'
import { X, Circle, ArrowRight, Clock, AlertTriangle, User, Check, RotateCcw, Send, Activity, FileText, Play, Ban } from 'lucide-react'
import { request } from '../lib/api'
import type { Job, WorkflowTransition, WorkflowStage } from '../lib/types'

interface JobDetailPageProps {
  jobId: number
  onClose: () => void
}

const STATUS_COLORS: Record<string, string> = { active: '#10b981', pending: '#6b7280', completed: '#3b82f6', cancelled: '#ef4444', on_hold: '#f59e0b' }
const PRIORITY_COLORS: Record<string, string> = { low: '#6b7280', normal: '#3b82f6', high: '#f59e0b', urgent: '#ef4444' }

export function JobDetailPage({ jobId, onClose }: JobDetailPageProps) {
  const [job, setJob] = useState<Job | null>(null)
  const [allowedTransitions, setAllowedTransitions] = useState<WorkflowTransition[]>([])
  const [loading, setLoading] = useState(true)
  const [transitioning, setTransitioning] = useState(false)
  const [notes, setNotes] = useState('')
  const [error, setError] = useState('')
  const [assignUserId, setAssignUserId] = useState<number | null>(null)
  const [users, setUsers] = useState<Array<{ id: number; name: string }>>([])
  const [activeTab, setActiveTab] = useState<'timeline' | 'details' | 'transitions'>('details')

  useEffect(() => { loadJob() }, [jobId])

  const loadJob = async () => {
    setLoading(true)
    try {
      const [jobData, transitionsData] = await Promise.all([
        request<Job>(`/jobs/${jobId}`),
        request<WorkflowTransition[]>(`/jobs/${jobId}/allowed-transitions`),
      ])
      setJob(jobData)
      setAllowedTransitions(transitionsData)
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Failed to load job')
    } finally { setLoading(false) }
  }

  const handleTransition = async (transitionId: number) => {
    setTransitioning(true)
    setError('')
    try {
      const result = await request<{ message: string; job: Job }>(`/jobs/${jobId}/transition`, {
        method: 'POST',
        body: JSON.stringify({ transition_id: transitionId, notes }),
      })
      setJob(result.job)
      setNotes('')
      await loadAllowedTransitions()
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Transition failed')
    } finally { setTransitioning(false) }
  }

  const loadAllowedTransitions = async () => {
    try {
      const data = await request<WorkflowTransition[]>(`/jobs/${jobId}/allowed-transitions`)
      setAllowedTransitions(data)
    } catch {}
  }

  const handleAssign = async () => {
    if (!assignUserId) return
    try {
      await request(`/jobs/${jobId}/assign`, { method: 'POST', body: JSON.stringify({ user_id: assignUserId }) })
      setAssignUserId(null)
      await loadJob()
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Assignment failed')
    }
  }

  const handleReturnToStage = async (stageId: number) => {
    setError('')
    try {
      const result = await request<{ message: string; job: Job }>(`/jobs/${jobId}/return-to-stage`, {
        method: 'POST',
        body: JSON.stringify({ stage_id: stageId, notes }),
      })
      setJob(result.job)
      setNotes('')
      await loadAllowedTransitions()
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Return failed')
    }
  }

  const handleCancel = async () => {
    const reason = window.prompt('Reason for cancellation:')
    if (reason === null) return
    try {
      await request(`/jobs/${jobId}/cancel`, { method: 'POST', body: JSON.stringify({ reason }) })
      await loadJob()
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Cancellation failed')
    }
  }

  if (loading) {
    return (
      <div className="modal-overlay" onClick={onClose}>
        <div className="surface" style={{ width: 700, maxHeight: '85vh', overflow: 'auto', padding: 32 }} onClick={(e) => e.stopPropagation()}>
          <p style={{ textAlign: 'center', color: '#65737d' }}>Loading job details...</p>
        </div>
      </div>
    )
  }

  if (!job) {
    return (
      <div className="modal-overlay" onClick={onClose}>
        <div className="surface" style={{ width: 700, maxHeight: '85vh', overflow: 'auto', padding: 32 }} onClick={(e) => e.stopPropagation()}>
          <p style={{ textAlign: 'center', color: '#ef4444' }}>Job not found</p>
          <button className="ghost-button" onClick={onClose} type="button">Close</button>
        </div>
      </div>
    )
  }

  const timeline = job.timeline ?? []
  const stageTracking = job.stage_tracking ?? []
  const workflowStages = job.workflow_template?.stages ?? []
  const currentStageId = job.current_stage_id

  return (
    <div className="modal-overlay" onClick={onClose}>
      <div className="surface" style={{ width: 780, maxHeight: '90vh', overflow: 'auto' }} onClick={(e) => e.stopPropagation()}>
        {/* Header */}
        <div className="surface-heading">
          <div>
            <p className="section-label">Job #{job.uid_no}</p>
            <h2>{job.title ?? 'Untitled Job'}</h2>
          </div>
          <div style={{ display: 'flex', alignItems: 'center', gap: 8 }}>
            <span className="sync-pill" style={{ background: `${PRIORITY_COLORS[job.priority] || '#6b7280'}20`, color: PRIORITY_COLORS[job.priority] || '#6b7280' }}>{job.priority}</span>
            <span className="sync-pill" style={{ background: `${STATUS_COLORS[job.status] || '#6b7280'}20`, color: STATUS_COLORS[job.status] || '#6b7280' }}>{job.status}</span>
            <button className="icon-button" onClick={onClose} type="button"><X size={18} /></button>
          </div>
        </div>

        {error ? <div className="error-banner">{error}</div> : null}

        {/* Workflow progress bar */}
        {workflowStages.length > 0 ? (
          <div style={{ display: 'flex', alignItems: 'center', gap: 0, marginBottom: 20, overflow: 'auto', padding: '4px 0' }}>
            {workflowStages.map((stage, idx) => {
              const isCurrent = stage.id === currentStageId
              const isPast = stageTracking.some((st) => st.stage_id === stage.id && st.exited_at)
              const isCompleted = stageTracking.some((st) => st.stage_id === stage.id && st.exited_at)
              return (
                <div key={stage.id} style={{ display: 'flex', alignItems: 'center', flexShrink: 0 }}>
                  <div style={{
                    display: 'flex', alignItems: 'center', gap: 6,
                    padding: '6px 12px', borderRadius: 20,
                    background: isCurrent ? `${stage.color}20` : isCompleted ? `${stage.color}15` : '#f3f4f6',
                    border: `2px solid ${isCurrent ? stage.color : isCompleted ? stage.color : '#e5e7eb'}`,
                    fontWeight: isCurrent ? 700 : 500,
                    fontSize: '0.8rem', color: isCurrent || isCompleted ? stage.color : '#9ca3af',
                    whiteSpace: 'nowrap',
                  }}>
                    <Circle size={10} fill={isCurrent || isCompleted ? stage.color : '#d1d5db'} stroke={stage.color} />
                    {stage.name}
                  </div>
                  {idx < workflowStages.length - 1 ? (
                    <ArrowRight size={14} style={{ margin: '0 4px', color: '#d1d5db', flexShrink: 0 }} />
                  ) : null}
                </div>
              )
            })}
          </div>
        ) : null}

        {/* Tab navigation */}
        <div style={{ display: 'flex', gap: 4, marginBottom: 16, borderBottom: '1px solid #e8eef1' }}>
          {(['details', 'transitions', 'timeline'] as const).map((tab) => (
            <button
              key={tab}
              className={`ghost-button ${activeTab === tab ? 'active' : ''}`}
              onClick={() => setActiveTab(tab)}
              type="button"
              style={{ borderBottom: activeTab === tab ? '2px solid #138a6b' : '2px solid transparent', borderRadius: 0, paddingBottom: 8 }}
            >
              {tab === 'details' ? <><FileText size={14} /> Details</> : null}
              {tab === 'transitions' ? <><Send size={14} /> Transitions</> : null}
              {tab === 'timeline' ? <><Activity size={14} /> Timeline</> : null}
            </button>
          ))}
        </div>

        {/* Details tab */}
        {activeTab === 'details' ? (
          <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 16 }}>
            <div>
              <label style={{ fontSize: '0.76rem', color: '#65737d', margin: 0 }}>UID</label>
              <p style={{ fontWeight: 600, margin: '2px 0' }}>{job.uid_no}</p>
            </div>
            <div>
              <label style={{ fontSize: '0.76rem', color: '#65737d', margin: 0 }}>Workflow Template</label>
              <p style={{ fontWeight: 600, margin: '2px 0' }}>{job.workflow_template?.name ?? '-'}</p>
            </div>
            <div>
              <label style={{ fontSize: '0.76rem', color: '#65737d', margin: 0 }}>Current Stage</label>
              <p style={{ fontWeight: 600, margin: '2px 0' }}>{job.current_stage?.name ?? 'Not started'}</p>
            </div>
            <div>
              <label style={{ fontSize: '0.76rem', color: '#65737d', margin: 0 }}>Assigned To</label>
              <p style={{ fontWeight: 600, margin: '2px 0', display: 'flex', alignItems: 'center', gap: 4 }}>
                {job.assigned_user ? <><User size={14} /> {job.assigned_user.name}</> : 'Unassigned'}
              </p>
            </div>
            <div>
              <label style={{ fontSize: '0.76rem', color: '#65737d', margin: 0 }}>Created</label>
              <p style={{ fontWeight: 600, margin: '2px 0' }}>{job.created_at ? new Date(job.created_at).toLocaleString() : '-'}</p>
            </div>
            <div>
              <label style={{ fontSize: '0.76rem', color: '#65737d', margin: 0 }}>Due Date</label>
              <p style={{ fontWeight: 600, margin: '2px 0' }}>{job.due_at ? new Date(job.due_at).toLocaleString() : 'Not set'}</p>
            </div>
            {job.started_at ? (
              <div>
                <label style={{ fontSize: '0.76rem', color: '#65737d', margin: 0 }}>Started</label>
                <p style={{ fontWeight: 600, margin: '2px 0' }}>{new Date(job.started_at).toLocaleString()}</p>
              </div>
            ) : null}
            {job.completed_at ? (
              <div>
                <label style={{ fontSize: '0.76rem', color: '#65737d', margin: 0 }}>Completed</label>
                <p style={{ fontWeight: 600, margin: '2px 0' }}>{new Date(job.completed_at).toLocaleString()}</p>
              </div>
            ) : null}
            {job.description ? (
              <div style={{ gridColumn: '1 / -1' }}>
                <label style={{ fontSize: '0.76rem', color: '#65737d', margin: 0 }}>Description</label>
                <p style={{ margin: '2px 0' }}>{job.description}</p>
              </div>
            ) : null}
          </div>
        ) : null}

        {/* Transitions tab */}
        {activeTab === 'transitions' ? (
          <div>
            {/* Assign user */}
            <div style={{ display: 'flex', alignItems: 'center', gap: 8, marginBottom: 16, padding: 12, background: '#f9fafb', borderRadius: 8 }}>
              <User size={16} />
              <strong style={{ fontSize: '0.85rem', whiteSpace: 'nowrap' }}>Assign to:</strong>
              <input
                type="number"
                value={assignUserId ?? ''}
                onChange={(e) => setAssignUserId(e.target.value ? Number(e.target.value) : null)}
                placeholder="User ID"
                style={{ width: 100, padding: '6px 10px', borderRadius: 6, border: '1px solid #dfe6ea' }}
              />
              <button className="ghost-button" onClick={() => void handleAssign()} type="button" disabled={!assignUserId}><Check size={14} /> Assign</button>
              <div style={{ flex: 1 }} />
              {job.status !== 'cancelled' ? (
                <button className="ghost-button" onClick={() => void handleCancel()} type="button" style={{ color: '#ef4444' }}><Ban size={14} /> Cancel Job</button>
              ) : null}
            </div>

            {/* SLA info */}
            {job.active_stage_tracking?.sla_deadline ? (
              <div style={{ display: 'flex', alignItems: 'center', gap: 8, padding: '10px 14px', borderRadius: 8, marginBottom: 12, background: job.active_stage_tracking.is_overdue ? '#fef2f2' : '#f0fdf4' }}>
                <Clock size={16} style={{ color: job.active_stage_tracking.is_overdue ? '#ef4444' : '#10b981' }} />
                <span style={{ fontSize: '0.85rem', fontWeight: 600, color: job.active_stage_tracking.is_overdue ? '#ef4444' : '#10b981' }}>
                  SLA Deadline: {new Date(job.active_stage_tracking.sla_deadline).toLocaleString()}
                  {job.active_stage_tracking.is_overdue ? ` — OVERDUE by ${Math.floor(job.active_stage_tracking.overdue_minutes / 60)}h ${job.active_stage_tracking.overdue_minutes % 60}m` : ''}
                </span>
              </div>
            ) : null}

            {/* Action buttons */}
            {allowedTransitions.length > 0 ? (
              <div>
                <strong style={{ fontSize: '0.88rem', display: 'block', marginBottom: 8 }}>Available Actions</strong>
                <div style={{ display: 'flex', flexDirection: 'column', gap: 8 }}>
                  {allowedTransitions.map((t) => (
                    <div key={t.id} style={{ display: 'flex', alignItems: 'center', gap: 8, padding: '10px 14px', border: '1px solid #e8eef1', borderRadius: 8, background: '#fbfcfd' }}>
                      <span className="sync-pill" style={{ background: t.from_stage?.color ?? '#6b7280', color: '#fff' }}>{t.from_stage?.name ?? '?'}</span>
                      <ArrowRight size={14} />
                      <span className="sync-pill" style={{ background: t.to_stage?.color ?? '#6b7280', color: '#fff' }}>{t.to_stage?.name ?? '?'}</span>
                      <strong style={{ flex: 1, fontSize: '0.85rem' }}>{t.name}</strong>
                      {t.requires_approval ? <span className="sync-pill" style={{ background: '#fef3c7', color: '#92400e' }}>Needs Approval</span> : null}
                      <div style={{ display: 'flex', gap: 4 }}>
                        <button
                          className="ghost-button"
                          onClick={() => void handleTransition(t.id)}
                          type="button"
                          disabled={transitioning}
                        >
                          <Send size={14} /> {transitioning ? 'Processing...' : 'Execute'}
                        </button>
                      </div>
                    </div>
                  ))}
                </div>
                <label style={{ marginTop: 12 }}>
                  Notes (optional)
                  <textarea value={notes} onChange={(e) => setNotes(e.target.value)} placeholder="Add notes for this transition..." rows={2} />
                </label>
              </div>
            ) : (
              <div style={{ padding: 24, textAlign: 'center', color: '#65737d', background: '#f9fafb', borderRadius: 8 }}>
                {job.status === 'completed' ? 'This job is completed.' : job.status === 'cancelled' ? 'This job has been cancelled.' : 'No transitions available from the current stage.'}
              </div>
            )}
          </div>
        ) : null}

        {/* Timeline tab */}
        {activeTab === 'timeline' ? (
          <div>
            {timeline.length === 0 ? (
              <p style={{ color: '#65737d', padding: 16 }}>No timeline entries yet.</p>
            ) : (
              <div style={{ position: 'relative', paddingLeft: 24 }}>
                <div style={{ position: 'absolute', left: 11, top: 0, bottom: 0, width: 2, background: '#e8eef1' }} />
                {timeline.map((entry) => (
                  <div key={entry.id} style={{ position: 'relative', paddingBottom: 16 }}>
                    <div style={{
                      position: 'absolute', left: -19, top: 4, width: 14, height: 14, borderRadius: '50%',
                      background: entry.to_stage?.color ?? '#6b7280', border: '2px solid #fff',
                    }} />
                    <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start' }}>
                      <div>
                        <strong style={{ fontSize: '0.88rem' }}>{entry.action}</strong>
                        {entry.user ? <span style={{ fontSize: '0.78rem', color: '#65737d', marginLeft: 8 }}>by {entry.user.name}</span> : null}
                        {entry.from_stage && entry.to_stage ? (
                          <div style={{ display: 'flex', alignItems: 'center', gap: 4, marginTop: 2 }}>
                            <span className="sync-pill" style={{ fontSize: '0.72rem', background: '#f3f4f6' }}>{entry.from_stage.name}</span>
                            <ArrowRight size={12} />
                            <span className="sync-pill" style={{ fontSize: '0.72rem', background: '#f3f4f6' }}>{entry.to_stage.name}</span>
                          </div>
                        ) : null}
                        {entry.notes ? <p style={{ fontSize: '0.8rem', color: '#4a5b66', marginTop: 2 }}>{entry.notes}</p> : null}
                      </div>
                      <span style={{ fontSize: '0.72rem', color: '#65737d', whiteSpace: 'nowrap' }}>
                        {entry.created_at ? new Date(entry.created_at).toLocaleString() : ''}
                      </span>
                    </div>
                  </div>
                ))}
              </div>
            )}
          </div>
        ) : null}

        <div className="form-actions" style={{ marginTop: 16 }}>
          <button className="ghost-button" onClick={onClose} type="button">Close</button>
          <button className="ghost-button" onClick={() => void loadJob()} type="button"><RotateCcw size={14} /> Refresh</button>
        </div>
      </div>
    </div>
  )
}
