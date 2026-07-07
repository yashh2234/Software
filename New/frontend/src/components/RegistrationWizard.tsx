import { useEffect, useState, useRef, type FormEvent } from 'react'
import { ClipboardList, ArrowLeft, ArrowRight, Save, Plus, X, Building2, FlaskConical, Beaker, Paperclip, MessageSquareText } from 'lucide-react'
import type { RegistrationFormData } from '../lib/types'
import { api, request } from '../lib/api'
import { FormField, DatePicker } from './ui'

const SAMPLE_TYPES = [
  'CC Cube', 'Concrete Core', 'Concrete Beam', 'Bitumen Core',
  'Bitumen Loose', 'Bricks', 'Ferro Cover', 'Interlocking Tiles',
  'Mainhole Cover', 'MES', 'Sand', 'Water',
]

const TABS = [
  { key: 'general', label: 'General', icon: ClipboardList },
  { key: 'client', label: 'Client', icon: Building2 },
  { key: 'sample', label: 'Samples', icon: FlaskConical },
  { key: 'tests', label: 'Tests', icon: Beaker },
  { key: 'attachments', label: 'Attachments', icon: Paperclip },
  { key: 'remarks', label: 'Remarks', icon: MessageSquareText },
]

const emptyForm: RegistrationFormData = {
  uid_no: '', received_date: new Date().toISOString().slice(0, 10),
  agency_name: '', reporting_address: '', mobile_no: '',
  name_of_work: '', sample_details: '', sample_details_1: '', sample_details_2: '', sample_details_3: '', sample_details_4: '',
  total_payment: '0', advance_payment: '0', balance_dues: '0', payment_followup: '',
  remark: '', qty: '', qty_1: '', qty_2: '', qty_3: '', qty_4: '', assign_to: 'lab',
}

const DRAFT_KEY = 'reg_draft'

function loadDraft(): Partial<RegistrationFormData> {
  try { return JSON.parse(localStorage.getItem(DRAFT_KEY) ?? '{}') }
  catch { return {} }
}
function saveDraft(data: Partial<RegistrationFormData>) { localStorage.setItem(DRAFT_KEY, JSON.stringify(data)) }
function clearDraft() { localStorage.removeItem(DRAFT_KEY) }

interface Props {
  editingId: number | null
  initial: RegistrationFormData
  onSaved: () => void
  onCancel: () => void
  onGenerateUid: () => Promise<string>
  generatingUid: boolean
}

export function RegistrationWizard({ editingId, initial, onSaved, onCancel, onGenerateUid, generatingUid }: Props) {
  const [tab, setTab] = useState(0)
  const [form, setForm] = useState<RegistrationFormData>(() => {
    if (editingId) return initial
    const draft = loadDraft()
    return { ...emptyForm, ...draft, received_date: new Date().toISOString().slice(0, 10) }
  })
  const [saving, setSaving] = useState(false)
  const [localError, setLocalError] = useState('')
  const [searchQuery, setSearchQuery] = useState('')
  const [searchResults, setSearchResults] = useState<Array<{ iClientId: number; uid_no: string; agency_name: string; reporting_address: string; mobile_no: string; name_of_work: string }>>([])
  const searchTimer = useRef<ReturnType<typeof setTimeout> | null>(null)

  interface SampleRow { sampleType: string; qty: string }
  const makeSampleRows = (f: RegistrationFormData): SampleRow[] => {
    const rows: SampleRow[] = []
    if (f.sample_details || f.qty) rows.push({ sampleType: f.sample_details, qty: f.qty })
    if (f.sample_details_1 || f.qty_1) rows.push({ sampleType: f.sample_details_1 ?? '', qty: f.qty_1 ?? '' })
    if (f.sample_details_2 || f.qty_2) rows.push({ sampleType: f.sample_details_2 ?? '', qty: f.qty_2 ?? '' })
    if (f.sample_details_3 || f.qty_3) rows.push({ sampleType: f.sample_details_3 ?? '', qty: f.qty_3 ?? '' })
    if (f.sample_details_4 || f.qty_4) rows.push({ sampleType: f.sample_details_4 ?? '', qty: f.qty_4 ?? '' })
    if (rows.length === 0) rows.push({ sampleType: '', qty: '' })
    return rows
  }
  const [sampleRows, setSampleRows] = useState<SampleRow[]>(() => makeSampleRows(form))

  const syncSampleRows = (rows: SampleRow[]) => {
    update({
      sample_details: rows[0]?.sampleType ?? '', qty: rows[0]?.qty ?? '',
      sample_details_1: rows[1]?.sampleType ?? '', qty_1: rows[1]?.qty ?? '',
      sample_details_2: rows[2]?.sampleType ?? '', qty_2: rows[2]?.qty ?? '',
      sample_details_3: rows[3]?.sampleType ?? '', qty_3: rows[3]?.qty ?? '',
      sample_details_4: rows[4]?.sampleType ?? '', qty_4: rows[4]?.qty ?? '',
    })
  }
  const updateSampleRow = (index: number, field: keyof SampleRow, value: string) => {
    const next = sampleRows.map((r, i) => (i === index ? { ...r, [field]: value } : r))
    setSampleRows(next); syncSampleRows(next)
  }
  const addSampleRow = () => { if (sampleRows.length >= 5) return; const next = [...sampleRows, { sampleType: '', qty: '' }]; setSampleRows(next); syncSampleRows(next) }
  const removeSampleRow = (index: number) => { if (sampleRows.length <= 1) return; const next = sampleRows.filter((_, i) => i !== index); setSampleRows(next); syncSampleRows(next) }

  useEffect(() => {
    if (!editingId && !form.uid_no) {
      onGenerateUid().then((uid) => setForm((c) => ({ ...c, uid_no: uid }))).catch(() => {})
    }
  }, [editingId, form.uid_no, onGenerateUid])

  useEffect(() => {
    if (!editingId) { const timer = setTimeout(() => saveDraft(form), 500); return () => clearTimeout(timer) }
  }, [form, editingId])

  const update = (patch: Partial<RegistrationFormData>) => setForm((c) => ({ ...c, ...patch }))
  const balanceDuePreview = Math.max(0, Number(form.total_payment || 0) - Number(form.advance_payment || 0))

  const handleSubmit = async (event: FormEvent<HTMLFormElement>) => {
    event.preventDefault()
    setSaving(true); setLocalError('')
    try {
      const payload = { ...form, total_payment: Number(form.total_payment || 0), advance_payment: Number(form.advance_payment || 0), balance_dues: Number(form.balance_dues || 0) }
      if (editingId) { await request(`/registrations/${editingId}`, { method: 'PUT', body: JSON.stringify(payload) }) }
      else { await request('/registrations', { method: 'POST', body: JSON.stringify(payload) }); clearDraft() }
      setForm(emptyForm); setTab(0); onSaved()
    } catch (e) { setLocalError(e instanceof Error ? e.message : 'Save failed') }
    finally { setSaving(false) }
  }

  return (
    <form className="surface user-form" onSubmit={handleSubmit} style={{ minWidth: 520 }}>
      <div className="surface-heading">
        <div>
          <p className="section-label">{editingId ? 'Update' : 'Create'}</p>
          <h2>{editingId ? 'Edit registration' : 'New registration'}</h2>
        </div>
        <ClipboardList size={20} />
      </div>

      {/* Tab bar */}
      <div style={{ display: 'flex', gap: 2, marginBottom: 20, borderBottom: '2px solid #e8eef1' }}>
        {TABS.map((t, i) => {
          const Icon = t.icon
          return (
            <button key={t.key} type="button" onClick={() => setTab(i)} style={{
              flex: 1, padding: '10px 8px', textAlign: 'center', fontSize: '0.76rem', fontWeight: 700,
              color: i === tab ? '#195340' : '#65737d',
              borderBottom: i === tab ? '2px solid #195340' : '2px solid transparent',
              marginBottom: -2, background: 'transparent', cursor: 'pointer', display: 'flex', alignItems: 'center', justifyContent: 'center', gap: 4,
            }}>
              <Icon size={14} /> {t.label}
            </button>
          )
        })}
      </div>

      {localError ? <div className="error-banner">{localError}</div> : null}

      {/* General Tab */}
      {tab === 0 ? (
        <div>
          <FormField label="UID No" required>
            <div style={{ display: 'flex', gap: 8 }}>
              <input value={form.uid_no} onChange={(e) => update({ uid_no: e.target.value })} readOnly={!editingId} />
              {!editingId ? <button type="button" className="icon-button" onClick={() => { onGenerateUid().then((uid) => update({ uid_no: uid })).catch(() => {}) }} disabled={generatingUid}><ClipboardList size={16} /></button> : null}
            </div>
          </FormField>
          <div className="field-row">
            <DatePicker value={form.received_date} onChange={(v) => update({ received_date: v })} label="Received date" />
            <FormField label="Mobile no" required>
              <input value={form.mobile_no} onChange={(e) => update({ mobile_no: e.target.value })} />
            </FormField>
          </div>
          <FormField label="Name of work" required>
            <input value={form.name_of_work} onChange={(e) => update({ name_of_work: e.target.value })} />
          </FormField>
          <FormField label="Assign to">
            <input value={form.assign_to} onChange={(e) => update({ assign_to: e.target.value })} />
          </FormField>
        </div>
      ) : null}

      {/* Client Tab */}
      {tab === 1 ? (
        <div>
          <FormField label="Search existing">
            <div style={{ position: 'relative' }}>
              <input value={searchQuery} onChange={(e) => {
                setSearchQuery(e.target.value)
                if (searchTimer.current) clearTimeout(searchTimer.current)
                const q = e.target.value
                if (q.length < 2) { setSearchResults([]); return }
                searchTimer.current = setTimeout(async () => {
                  try { const res = await api.searchCustomers(q); setSearchResults(res.data) } catch {}
                }, 300)
              }} placeholder="Search by agency name, mobile or UID..." />
              {searchResults.length > 0 ? (
                <div style={{ position: 'absolute', top: '100%', left: 0, right: 0, zIndex: 10, background: '#fff', border: '1px solid #ddd', borderRadius: 8, maxHeight: 200, overflowY: 'auto' }}>
                  {searchResults.map((r) => (
                    <div key={r.iClientId} style={{ padding: '8px 12px', cursor: 'pointer', borderBottom: '1px solid #eee', fontSize: '0.85rem' }}
                      onClick={() => { update({ agency_name: r.agency_name, reporting_address: r.reporting_address, mobile_no: r.mobile_no, name_of_work: r.name_of_work }); setSearchQuery(''); setSearchResults([]) }}>
                      <strong>{r.agency_name}</strong> &mdash; {r.mobile_no}<br />
                      <span style={{ color: '#65737d' }}>{r.uid_no} &middot; {r.name_of_work}</span>
                    </div>
                  ))}
                </div>
              ) : null}
            </div>
          </FormField>
          <FormField label="Agency name" required>
            <input value={form.agency_name} onChange={(e) => update({ agency_name: e.target.value })} />
          </FormField>
          <FormField label="Reporting address">
            <input value={form.reporting_address} onChange={(e) => update({ reporting_address: e.target.value })} />
          </FormField>
        </div>
      ) : null}

      {/* Samples Tab */}
      {tab === 2 ? (
        <div>
          <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 8 }}>
            <strong style={{ fontSize: '0.85rem', color: '#195340' }}>Sample entries</strong>
            {sampleRows.length < 5 ? <button type="button" className="icon-button" onClick={addSampleRow} title="Add sample"><Plus size={16} /></button> : null}
          </div>
          {sampleRows.map((row, i) => (
            <div key={i} style={{ border: '1px solid #e0e6ea', borderRadius: 8, padding: 10, marginBottom: 8, position: 'relative' }}>
              <div className="field-row" style={{ marginBottom: 6 }}>
                <FormField label={`Type ${i + 1}`}>
                  <select value={SAMPLE_TYPES.includes(row.sampleType) ? row.sampleType : ''} onChange={(e) => updateSampleRow(i, 'sampleType', e.target.value)}>
                    <option value="">-- Select --</option>
                    {SAMPLE_TYPES.map((t) => <option key={t} value={t}>{t}</option>)}
                  </select>
                </FormField>
                <FormField label="Qty">
                  <input value={row.qty} onChange={(e) => updateSampleRow(i, 'qty', e.target.value)} />
                </FormField>
              </div>
              <div style={{ display: 'flex', gap: 8, alignItems: 'flex-end' }}>
                <FormField label="Custom type" style={{ flex: 1 }}>
                  <input value={row.sampleType} onChange={(e) => updateSampleRow(i, 'sampleType', e.target.value)} placeholder="Or type a custom name" />
                </FormField>
                {sampleRows.length > 1 ? <button type="button" className="icon-button" onClick={() => removeSampleRow(i)} title="Remove"><X size={16} /></button> : null}
              </div>
            </div>
          ))}
        </div>
      ) : null}

      {/* Tests Tab */}
      {tab === 3 ? (
        <div>
          <FormField label="Tests required">
            <textarea rows={3} value={form.sample_details} onChange={(e) => update({ sample_details: e.target.value })} placeholder="Describe the tests to be performed..." />
          </FormField>
        </div>
      ) : null}

      {/* Attachments Tab */}
      {tab === 4 ? (
        <div>
          <p style={{ color: '#65737d', fontSize: '0.85rem', marginBottom: 12 }}>
            Attachments can be added after saving the registration from the Job Detail page.
          </p>
          <div style={{ padding: 24, border: '2px dashed #dfe6ea', borderRadius: 8, textAlign: 'center' }}>
            <Paperclip size={32} style={{ color: '#65737d', marginBottom: 8 }} />
            <p style={{ color: '#65737d', fontSize: '0.85rem' }}>File upload will be available on the Job page.</p>
          </div>
        </div>
      ) : null}

      {/* Remarks Tab */}
      {tab === 5 ? (
        <div>
          <div className="field-row">
            <FormField label="Total payment">
              <input type="number" value={form.total_payment} onChange={(e) => update({ total_payment: e.target.value })} />
            </FormField>
            <FormField label="Advance payment">
              <input type="number" value={form.advance_payment} onChange={(e) => update({ advance_payment: e.target.value })} />
            </FormField>
          </div>
          <div className="field-row">
            <FormField label="Balance due">
              <input type="number" value={form.balance_dues} onChange={(e) => update({ balance_dues: e.target.value })} />
            </FormField>
            <FormField label="Auto balance">
              <input value={String(balanceDuePreview)} readOnly />
            </FormField>
          </div>
          <FormField label="Payment followup">
            <input value={form.payment_followup} onChange={(e) => update({ payment_followup: e.target.value })} />
          </FormField>
          <FormField label="Remarks">
            <textarea rows={3} value={form.remark} onChange={(e) => update({ remark: e.target.value })} />
          </FormField>
        </div>
      ) : null}

      <div className="form-actions" style={{ justifyContent: 'space-between' }}>
        <div>
          {tab > 0 ? <button className="ghost-button" onClick={() => setTab((s) => s - 1)} type="button"><ArrowLeft size={16} /> Back</button> : null}
          {editingId && tab === 0 ? <button className="ghost-button" onClick={onCancel} type="button" style={{ marginLeft: 8 }}>Cancel</button> : null}
        </div>
        <div style={{ display: 'flex', gap: 8 }}>
          {!editingId ? <button type="button" className="ghost-button" onClick={() => { saveDraft(form); setLocalError('Draft saved') }}><Save size={16} /> Draft</button> : null}
          {tab < 5 ? (
            <button type="button" onClick={() => setTab((s) => s + 1)}>Next <ArrowRight size={16} /></button>
          ) : (
            <button type="submit" disabled={saving}><Save size={16} /> {saving ? 'Saving...' : editingId ? 'Update' : 'Create'}</button>
          )}
        </div>
      </div>
    </form>
  )
}
