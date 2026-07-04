import { useState } from 'react'
import { Search, UserPlus, UserCog, History } from 'lucide-react'
import { useAuth } from '../lib/auth'
import { api, request } from '../lib/api'
import { DataTable } from '../components/DataTable'
import { RegistrationWizard } from '../components/RegistrationWizard'
import { Timeline } from '../components/Timeline'
import type { Registration, RegistrationFormData } from '../lib/types'

function normalizeDate(value: string | null) {
  if (!value) return ''
  if (value.includes('-')) return value
  const parts = value.split('/')
  if (parts.length === 3) {
    const [day, month, year] = parts
    return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
  }
  return value
}

function money(value: number) {
  return new Intl.NumberFormat('en-IN', { maximumFractionDigits: 0 }).format(value)
}

export function RegistrationsPage() {
  const { registrations, refresh, clearError, setStatus } = useAuth()
  const [query, setQuery] = useState('')
  const [editingId, setEditingId] = useState<number | null>(null)
  const [formVisible, setFormVisible] = useState(false)
  const [, setLocalError] = useState('')
  const [timelineData, setTimelineData] = useState<Array<{ event: string; timestamp: string | null; icon: string; user?: string }>>([])

  const filtered = query.trim()
    ? registrations.filter((r) =>
        [r.uid_no, r.agency_name, r.reporting_address, r.mobile_no, r.name_of_work]
          .join(' ').toLowerCase().includes(query.trim().toLowerCase()),
      )
    : registrations

  const beginCreate = () => {
    setEditingId(null)
    setFormVisible(true)
    clearError()
    setLocalError('')
    setStatus('Creating registration')
  }

  const beginEdit = (registration: Registration) => {
    setEditingId(registration.id)
    setFormVisible(true)
    clearError()
    setLocalError('')
    setStatus('Editing registration')
  }

  const handleSaved = async () => {
    setEditingId(null)
    setFormVisible(false)
    await refresh()
    setStatus('Registration saved')
  }

  const showHistory = async (registration: Registration) => {
    try {
      const data = await api.registrationHistory(registration.id)
      setTimelineData(data.data)
    } catch {
      setLocalError('Failed to load history')
    }
  }

  const wizardInitial = (): RegistrationFormData => {
    if (!editingId) return {
      uid_no: '', received_date: new Date().toISOString().slice(0, 10),
      agency_name: '', reporting_address: '', mobile_no: '',
      name_of_work: '', sample_details: '', total_payment: '0',
      advance_payment: '0', balance_dues: '0', payment_followup: '',
      remark: '', qty: '', assign_to: 'lab',
    }
    const reg = registrations.find((r) => r.id === editingId)
    if (!reg) return {
      uid_no: '', received_date: new Date().toISOString().slice(0, 10),
      agency_name: '', reporting_address: '', mobile_no: '',
      name_of_work: '', sample_details: '', total_payment: '0',
      advance_payment: '0', balance_dues: '0', payment_followup: '',
      remark: '', qty: '', assign_to: 'lab',
    }
    return {
      uid_no: reg.uid_no,
      received_date: normalizeDate(reg.received_date),
      agency_name: reg.agency_name,
      reporting_address: reg.reporting_address,
      mobile_no: reg.mobile_no,
      name_of_work: reg.name_of_work,
      sample_details: reg.sample_details,
      sample_details_1: reg.sample_details_1 ?? '',
      sample_details_2: reg.sample_details_2 ?? '',
      sample_details_3: reg.sample_details_3 ?? '',
      sample_details_4: reg.sample_details_4 ?? '',
      total_payment: String(reg.total_payment ?? 0),
      advance_payment: String(reg.advance_payment ?? 0),
      balance_dues: String(reg.balance_dues ?? 0),
      payment_followup: reg.payment_followup ?? '',
      remark: reg.remark ?? '',
      qty: reg.qty ?? '',
      qty_1: reg.qty_1 ?? '',
      qty_2: reg.qty_2 ?? '',
      qty_3: reg.qty_3 ?? '',
      qty_4: reg.qty_4 ?? '',
      assign_to: reg.assign_to ?? 'lab',
    }
  }

  return (
    <div className="two-column users-layout">
      <section className="surface">
        <div className="surface-heading">
          <div>
            <p className="section-label">Intake</p>
            <h2>Client registrations</h2>
          </div>
          <label className="search-field">
            <Search size={16} />
            <input value={query} onChange={(e) => setQuery(e.target.value)} placeholder="Search UID, agency, mobile" />
          </label>
        </div>

        <div className="user-toolbar">
          <button className="ghost-button" onClick={beginCreate} type="button">
            <UserPlus size={18} />
            New registration
          </button>
          <span className="sync-pill">{filtered.length} records</span>
        </div>

        <DataTable
          columns={[
            { key: 'uid', label: 'UID' },
            { key: 'agency', label: 'Agency' },
            { key: 'work', label: 'Work' },
            { key: 'mobile', label: 'Mobile' },
            { key: 'amount', label: 'Amount' },
            { key: 'status', label: 'Status' },
            { key: 'actions', label: 'Actions', sortable: false },
          ]}
          rows={filtered.map((registration) => ({
            uid: registration.uid_no,
            agency: registration.agency_name,
            work: registration.name_of_work,
            mobile: registration.mobile_no,
            amount: money(registration.total_payment),
            status: registration.status,
            actions: <div style={{ display: 'flex', gap: 4 }}>
              <button className="icon-button" onClick={() => void showHistory(registration)} type="button" title="View history">
                <History size={17} />
              </button>
              <button className="icon-button" onClick={() => beginEdit(registration)} type="button" title="Edit registration">
                <UserCog size={17} />
              </button>
            </div>,
          }))}
        />
      </section>

      {(editingId !== null || formVisible) ? (
        <RegistrationWizard
          key={editingId ?? 'new'}
          editingId={editingId}
          initial={wizardInitial()}
          onSaved={handleSaved}
          onCancel={() => { setEditingId(null); setFormVisible(false) }}
          onGenerateUid={async () => { const d = await request<{ uid_no: string }>('/registrations/generate-uid'); return d.uid_no }}
          generatingUid={false}
        />
      ) : null}

      {timelineData.length > 0 ? (
        <Timeline entries={timelineData} onClose={() => { setTimelineData([]) }} />
      ) : null}
    </div>
  )
}
