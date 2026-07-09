import { useState } from 'react'
import { Search, UserPlus, UserCog, History, Download, Calendar } from 'lucide-react'
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

function exportToCsv(headers: string[], rows: (string | number)[][], filename: string) {
  const csvContent = [
    headers.map(h => `"${h}"`).join(','),
    ...rows.map(r => r.map(v => `"${String(v ?? '').replace(/"/g, '""')}"`).join(','))
  ].join('\n')
  const blob = new Blob(['\uFEFF' + csvContent], { type: 'text/csv;charset=utf-8;' })
  const link = document.createElement('a')
  link.href = URL.createObjectURL(blob)
  link.download = filename
  link.click()
}

export function RegistrationsPage() {
  const { registrations, refresh, clearError, setStatus } = useAuth()
  const [query, setQuery] = useState('')
  const [editingId, setEditingId] = useState<number | null>(null)
  const [formVisible, setFormVisible] = useState(false)
  const [, setLocalError] = useState('')
  const [timelineData, setTimelineData] = useState<Array<{ event: string; timestamp: string | null; icon: string; user?: string }>>([])
  const [startDate, setStartDate] = useState('')
  const [endDate, setEndDate] = useState('')
  const [activeFilter, setActiveFilter] = useState(false)

  const filtered = (() => {
    let list = registrations
    if (activeFilter && (startDate || endDate)) {
      list = list.filter((r) => {
        const d = normalizeDate(r.received_date)
        if (startDate && d < startDate) return false
        if (endDate && d > endDate) return false
        return true
      })
    }
    if (query.trim()) {
      const q = query.trim().toLowerCase()
      list = list.filter((r) =>
        [r.uid_no, r.agency_name, r.reporting_address, r.mobile_no, r.name_of_work]
          .join(' ').toLowerCase().includes(q)
      )
    }
    return list
  })()

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

  const handleExport = () => {
    const headers = ['UID No', 'Date', 'Agency Name', 'Reporting Address', 'Mobile No', 'Name Of Work', 'Sample Details', 'Total Payment', 'Advance Payment', 'Balance Dues', 'Status']
    const rows = filtered.map((r) => [
      r.uid_no,
      normalizeDate(r.received_date),
      r.agency_name,
      r.reporting_address,
      r.mobile_no,
      r.name_of_work,
      r.sample_details,
      r.total_payment,
      r.advance_payment,
      r.balance_dues,
      r.status,
    ])
    exportToCsv(headers, rows, `registrations_${new Date().toISOString().slice(0, 10)}.csv`)
  }

  const applyDateFilter = () => {
    setActiveFilter(true)
  }

  const clearDateFilter = () => {
    setStartDate('')
    setEndDate('')
    setActiveFilter(false)
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
      work_order_no: reg.work_order_no ?? '',
      reference: reg.reference ?? '',
      work: reg.work ?? '',
      report_status: reg.report_status ?? '',
      sample_details: reg.sample_details,
      sample_details_1: reg.sample_details_1 ?? '',
      sample_details_2: reg.sample_details_2 ?? '',
      sample_details_3: reg.sample_details_3 ?? '',
      sample_details_4: reg.sample_details_4 ?? '',
      new_back: reg.new_back ?? '',
      new_back_1: reg.new_back_1 ?? '',
      new_back_2: reg.new_back_2 ?? '',
      new_back_3: reg.new_back_3 ?? '',
      new_back_4: reg.new_back_4 ?? '',
      total_payment: String(reg.total_payment ?? 0),
      advance_payment: String(reg.advance_payment ?? 0),
      balance_dues: String(reg.balance_dues ?? 0),
      payment_followup: reg.payment_followup ?? '',
      financial_remark: reg.financial_remark ?? '',
      mode_of_payment: reg.mode_of_payment ?? '',
      gst_no: reg.gst_no ?? '',
      sample_nos: reg.sample_nos ?? '',
      remark: reg.remark ?? '',
      qty: reg.qty ?? '',
      qty_1: reg.qty_1 ?? '',
      qty_2: reg.qty_2 ?? '',
      qty_3: reg.qty_3 ?? '',
      qty_4: reg.qty_4 ?? '',
      witness: reg.witness ?? '',
      sample_test: reg.sample_test ?? '',
      sample_remark: reg.sample_remark ?? '',
      report_no: reg.report_no ?? '',
      field_person_name: reg.field_person_name ?? '',
      prepared_date: normalizeDate(reg.prepared_date),
      dispatch_date: normalizeDate(reg.dispatch_date),
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

        <div className="user-toolbar" style={{ flexWrap: 'wrap', gap: 8 }}>
          <button className="ghost-button" onClick={beginCreate} type="button">
            <UserPlus size={18} />
            New registration
          </button>
          <button className="ghost-button" onClick={handleExport} type="button">
            <Download size={18} />
            Export
          </button>
          <div style={{ display: 'flex', alignItems: 'center', gap: 6, marginLeft: 'auto' }}>
            <Calendar size={14} style={{ color: '#65737d' }} />
            <input type="date" value={startDate} onChange={(e) => setStartDate(e.target.value)} style={{ fontSize: '0.8rem', padding: '4px 8px', borderRadius: 4, border: '1px solid #dfe6ea' }} />
            <span style={{ color: '#65737d', fontSize: '0.8rem' }}>to</span>
            <input type="date" value={endDate} onChange={(e) => setEndDate(e.target.value)} style={{ fontSize: '0.8rem', padding: '4px 8px', borderRadius: 4, border: '1px solid #dfe6ea' }} />
            <button className="ghost-button" onClick={applyDateFilter} style={{ fontSize: '0.8rem', padding: '4px 12px' }}>Go</button>
            {activeFilter ? <button className="ghost-button" onClick={clearDateFilter} style={{ fontSize: '0.8rem', padding: '4px 8px', color: '#ef4444' }}>Clear</button> : null}
          </div>
          <span className="sync-pill">{filtered.length} records</span>
        </div>

        <DataTable
          columns={[
            { key: 'uid', label: 'UID' },
            { key: 'date', label: 'Date' },
            { key: 'agency', label: 'Agency' },
            { key: 'address', label: 'Address' },
            { key: 'mobile', label: 'Mobile' },
            { key: 'work', label: 'Work' },
            { key: 'samples', label: 'Samples' },
            { key: 'amount', label: 'Total' },
            { key: 'advance', label: 'Advance' },
            { key: 'balance', label: 'Balance' },
            { key: 'status', label: 'Status' },
            { key: 'actions', label: 'Actions', sortable: false },
          ]}
          rows={filtered.map((registration) => ({
            uid: <span style={{ fontWeight: 600, color: '#195340' }}>{registration.uid_no}</span>,
            date: normalizeDate(registration.received_date),
            agency: registration.agency_name,
            address: registration.reporting_address,
            mobile: registration.mobile_no,
            work: registration.name_of_work,
            samples: registration.sample_details,
            amount: money(registration.total_payment),
            advance: money(registration.advance_payment),
            balance: <span style={{ color: registration.balance_dues > 0 ? '#ef4444' : '#22c55e', fontWeight: 600 }}>{money(registration.balance_dues)}</span>,
            status: registration.balance_dues > 0
              ? <span style={{ color: '#e8a838', fontWeight: 600 }}>Pending</span>
              : <span style={{ color: '#22c55e', fontWeight: 600 }}>Complete</span>,
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
