import { useState } from 'react'
import { Search, UserPlus, UserCog, History, Download, Calendar, X } from 'lucide-react'
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

  const applyDateFilter = () => { setActiveFilter(true) }
  const clearDateFilter = () => { setStartDate(''); setEndDate(''); setActiveFilter(false) }

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
    <>
      <div className="page-header">
        <div>
          <p className="section-label">Intake</p>
          <h1>Client Registrations</h1>
        </div>
        <div className="page-actions">
          <button className="btn btn-primary" onClick={beginCreate} type="button">
            <UserPlus size={16} /> New Registration
          </button>
          <button className="btn btn-outline" onClick={handleExport} type="button">
            <Download size={16} /> Export
          </button>
        </div>
      </div>

      <div className="filter-bar">
        <div className="search-field">
          <Search size={16} />
          <input value={query} onChange={(e) => setQuery(e.target.value)} placeholder="Search UID, agency, mobile..." />
        </div>
        <div className="date-filter">
          <Calendar size={14} />
          <input type="date" value={startDate} onChange={(e) => setStartDate(e.target.value)} />
          <span>to</span>
          <input type="date" value={endDate} onChange={(e) => setEndDate(e.target.value)} />
          <button className="btn btn-sm" onClick={applyDateFilter}>Go</button>
          {activeFilter && <button className="btn btn-sm btn-danger" onClick={clearDateFilter}>Clear</button>}
        </div>
        <span className="record-count">{filtered.length} records</span>
      </div>

      <div className="table-card">
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
            { key: 'actions', label: '', sortable: false },
          ]}
          rows={filtered.map((registration) => ({
            uid: <span className="uid-cell">{registration.uid_no}</span>,
            date: <span className="mono">{normalizeDate(registration.received_date)}</span>,
            agency: registration.agency_name,
            address: <span className="text-muted">{registration.reporting_address}</span>,
            mobile: <span className="mono">{registration.mobile_no}</span>,
            work: registration.name_of_work,
            samples: <span className="text-muted">{registration.sample_details}</span>,
            amount: <span className="mono">{money(registration.total_payment)}</span>,
            advance: <span className="mono">{money(registration.advance_payment)}</span>,
            balance: <span className={`mono ${registration.balance_dues > 0 ? 'text-danger' : 'text-success'}`}>{money(registration.balance_dues)}</span>,
            status: registration.balance_dues > 0
              ? <span className="badge badge-warning">Pending</span>
              : <span className="badge badge-success">Complete</span>,
            actions: <div className="row-actions-inline">
              <button className="icon-btn" onClick={() => void showHistory(registration)} type="button" title="History">
                <History size={15} />
              </button>
              <button className="icon-btn" onClick={() => beginEdit(registration)} type="button" title="Edit">
                <UserCog size={15} />
              </button>
            </div>,
          }))}
        />
      </div>

      {formVisible && (
        <div className="modal-overlay" onClick={() => { setEditingId(null); setFormVisible(false) }}>
          <div className="modal-content modal-lg" onClick={(e) => e.stopPropagation()}>
            <button className="modal-close" onClick={() => { setEditingId(null); setFormVisible(false) }} type="button">
              <X size={20} />
            </button>
            <RegistrationWizard
              key={editingId ?? 'new'}
              editingId={editingId}
              initial={wizardInitial()}
              onSaved={handleSaved}
              onCancel={() => { setEditingId(null); setFormVisible(false) }}
              onGenerateUid={async () => { const d = await request<{ uid_no: string }>('/registrations/generate-uid'); return d.uid_no }}
              generatingUid={false}
            />
          </div>
        </div>
      )}

      {timelineData.length > 0 && (
        <Timeline entries={timelineData} onClose={() => { setTimelineData([]) }} />
      )}
    </>
  )
}
