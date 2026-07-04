import { useEffect, useState, useRef, type FormEvent } from 'react'
import { ClipboardList, ArrowLeft, ArrowRight, Save, Check, Plus, X } from 'lucide-react'
import type { RegistrationFormData } from '../lib/types'
import { api, request } from '../lib/api'

const SAMPLE_TYPES = [
  'CC Cube', 'Concrete Core', 'Concrete Beam', 'Bitumen Core',
  'Bitumen Loose', 'Bricks', 'Ferro Cover', 'Interlocking Tiles',
  'Mainhole Cover', 'MES', 'Sand', 'Water',
]

const STEPS = ['Customer Info', 'Work Details', 'Payment', 'Review']

const emptyForm: RegistrationFormData = {
  uid_no: '', received_date: new Date().toISOString().slice(0, 10),
  agency_name: '', reporting_address: '', mobile_no: '',
  name_of_work: '', sample_details: '', sample_details_1: '', sample_details_2: '', sample_details_3: '', sample_details_4: '',
  total_payment: '0', advance_payment: '0', balance_dues: '0', payment_followup: '',
  remark: '', qty: '', qty_1: '', qty_2: '', qty_3: '', qty_4: '', assign_to: 'lab',
}

const DRAFT_KEY = 'reg_draft'

function loadDraft(): Partial<RegistrationFormData> {
  try {
    return JSON.parse(localStorage.getItem(DRAFT_KEY) ?? '{}')
  } catch { return {} }
}

function saveDraft(data: Partial<RegistrationFormData>) {
  localStorage.setItem(DRAFT_KEY, JSON.stringify(data))
}

function clearDraft() {
  localStorage.removeItem(DRAFT_KEY)
}

interface Props {
  editingId: number | null
  initial: RegistrationFormData
  onSaved: () => void
  onCancel: () => void
  onGenerateUid: () => Promise<string>
  generatingUid: boolean
}

export function RegistrationWizard({ editingId, initial, onSaved, onCancel, onGenerateUid, generatingUid }: Props) {
  const [step, setStep] = useState(0)
  const [form, setForm] = useState<RegistrationFormData>(() => {
    if (editingId) return initial
    const draft = loadDraft()
    return { ...emptyForm, ...draft, received_date: new Date().toISOString().slice(0, 10) }
  })
  const [saving, setSaving] = useState(false)
  const [localError, setLocalError] = useState('')
  const [searchQuery, setSearchQuery] = useState('')
  const [searchResults, setSearchResults] = useState<Array<{ iClientId: number; uid_no: string; agency_name: string; reporting_address: string; mobile_no: string; name_of_work: string }>>([])
  const [searching, setSearching] = useState(false)
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
      sample_details: rows[0]?.sampleType ?? '',
      qty: rows[0]?.qty ?? '',
      sample_details_1: rows[1]?.sampleType ?? '',
      qty_1: rows[1]?.qty ?? '',
      sample_details_2: rows[2]?.sampleType ?? '',
      qty_2: rows[2]?.qty ?? '',
      sample_details_3: rows[3]?.sampleType ?? '',
      qty_3: rows[3]?.qty ?? '',
      sample_details_4: rows[4]?.sampleType ?? '',
      qty_4: rows[4]?.qty ?? '',
    })
  }

  const updateSampleRow = (index: number, field: keyof SampleRow, value: string) => {
    const next = sampleRows.map((r, i) => (i === index ? { ...r, [field]: value } : r))
    setSampleRows(next)
    syncSampleRows(next)
  }

  const addSampleRow = () => {
    if (sampleRows.length >= 5) return
    const next = [...sampleRows, { sampleType: '', qty: '' }]
    setSampleRows(next)
    syncSampleRows(next)
  }

  const removeSampleRow = (index: number) => {
    if (sampleRows.length <= 1) return
    const next = sampleRows.filter((_, i) => i !== index)
    setSampleRows(next)
    syncSampleRows(next)
  }

  useEffect(() => {
    if (!editingId && !form.uid_no) {
      onGenerateUid().then((uid) => setForm((c) => ({ ...c, uid_no: uid }))).catch(() => {})
    }
  }, [editingId, form.uid_no, onGenerateUid])

  useEffect(() => {
    if (!editingId) {
      const timer = setTimeout(() => saveDraft(form), 500)
      return () => clearTimeout(timer)
    }
  }, [form, editingId])

  const update = (patch: Partial<RegistrationFormData>) => setForm((c) => ({ ...c, ...patch }))

  const balanceDuePreview = Math.max(0, Number(form.total_payment || 0) - Number(form.advance_payment || 0))

  const handleSubmit = async (event: FormEvent<HTMLFormElement>) => {
    event.preventDefault()
    setSaving(true)
    setLocalError('')
    try {
      const payload = {
        ...form,
        total_payment: Number(form.total_payment || 0),
        advance_payment: Number(form.advance_payment || 0),
        balance_dues: Number(form.balance_dues || 0),
      }
      if (editingId) {
        await request(`/registrations/${editingId}`, { method: 'PUT', body: JSON.stringify(payload) })
      } else {
        await request('/registrations', { method: 'POST', body: JSON.stringify(payload) })
        clearDraft()
      }
      setForm(emptyForm)
      setStep(0)
      onSaved()
    } catch (e) {
      setLocalError(e instanceof Error ? e.message : 'Save failed')
    } finally {
      setSaving(false)
    }
  }

  const canNext = (): boolean => {
    if (step === 0) return !!form.agency_name && !!form.mobile_no
    if (step === 1) return !!form.name_of_work && !!form.sample_details
    if (step === 2) return true
    return true
  }

  return (
    <form className="surface user-form" onSubmit={handleSubmit}>
      <div className="surface-heading">
        <div>
          <p className="section-label">{editingId ? 'Update' : 'Create'}</p>
          <h2>{editingId ? 'Edit registration' : 'New registration'}</h2>
        </div>
        <ClipboardList size={20} />
      </div>

      <div style={{ display: 'flex', gap: 4, marginBottom: 20 }}>
        {STEPS.map((label, i) => (
          <div
            key={label}
            style={{
              flex: 1, padding: '8px 0', textAlign: 'center', borderRadius: 8,
              fontSize: '0.78rem', fontWeight: 700,
              background: i === step ? '#327268' : i < step ? '#edf6f4' : '#f5f7f8',
              color: i === step ? '#fff' : i < step ? '#195340' : '#65737d',
            }}
          >
            {i < step ? <Check size={14} style={{ verticalAlign: 'middle', marginRight: 4 }} /> : null}
            {label}
          </div>
        ))}
      </div>

      {localError ? <div className="error-banner">{localError}</div> : null}

      {/* Step 0: Customer Info */}
      {step === 0 ? (
        <div>
          <label>
            Search existing customer
            <div style={{ position: 'relative' }}>
              <div style={{ display: 'flex', gap: 8 }}>
                <input
                  value={searchQuery}
                  onChange={(e) => {
                    setSearchQuery(e.target.value)
                    if (searchTimer.current) clearTimeout(searchTimer.current)
                    const q = e.target.value
                    if (q.length < 2) { setSearchResults([]); return }
                    searchTimer.current = setTimeout(async () => {
                      setSearching(true)
                      try {
                        const res = await api.searchCustomers(q)
                        setSearchResults(res.data)
                      } catch { /* ignore */ }
                      setSearching(false)
                    }, 300)
                  }}
                  placeholder="Search by agency name, mobile or UID..."
                />
                {searching ? <div style={{ padding: '8px 12px' }}>...</div> : null}
              </div>
              {searchResults.length > 0 ? (
                <div style={{
                  position: 'absolute', top: '100%', left: 0, right: 0, zIndex: 10,
                  background: '#fff', border: '1px solid #ddd', borderRadius: 8, maxHeight: 200, overflowY: 'auto',
                }}>
                  {searchResults.map((r) => (
                    <div
                      key={r.iClientId}
                      style={{ padding: '8px 12px', cursor: 'pointer', borderBottom: '1px solid #eee', fontSize: '0.85rem' }}
                      onClick={() => {
                        update({
                          agency_name: r.agency_name,
                          reporting_address: r.reporting_address,
                          mobile_no: r.mobile_no,
                          name_of_work: r.name_of_work,
                        })
                        setSearchQuery('')
                        setSearchResults([])
                      }}
                      onMouseEnter={(e) => (e.currentTarget.style.background = '#f0f4f8')}
                      onMouseLeave={(e) => (e.currentTarget.style.background = '#fff')}
                    >
                      <strong>{r.agency_name}</strong> &mdash; {r.mobile_no} <br />
                      <span style={{ color: '#65737d' }}>{r.uid_no} &middot; {r.name_of_work}</span>
                    </div>
                  ))}
                </div>
              ) : null}
            </div>
          </label>
          <label>
            UID No
            <div style={{ display: 'flex', gap: 8 }}>
              <input value={form.uid_no} onChange={(e) => update({ uid_no: e.target.value })} readOnly={!editingId} />
              {!editingId ? (
                <button type="button" className="icon-button" onClick={() => { onGenerateUid().then((uid) => update({ uid_no: uid })).catch(() => {}) }} disabled={generatingUid} title="Generate UID">
                  <ClipboardList size={16} />
                </button>
              ) : null}
            </div>
          </label>
          <div className="field-row">
            <label>
              Received date
              <input type="date" value={form.received_date} onChange={(e) => update({ received_date: e.target.value })} />
            </label>
            <label>
              Mobile no
              <input value={form.mobile_no} onChange={(e) => update({ mobile_no: e.target.value })} />
            </label>
          </div>
          <label>
            Agency name
            <input value={form.agency_name} onChange={(e) => update({ agency_name: e.target.value })} />
          </label>
          <label>
            Reporting address
            <input value={form.reporting_address} onChange={(e) => update({ reporting_address: e.target.value })} />
          </label>
        </div>
      ) : null}

      {/* Step 1: Work Details */}
      {step === 1 ? (
        <div>
          <label>
            Name of work
            <input value={form.name_of_work} onChange={(e) => update({ name_of_work: e.target.value })} />
          </label>
          <div style={{ marginBottom: 12 }}>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 8 }}>
              <span style={{ fontWeight: 600, fontSize: '0.85rem', color: '#195340' }}>Samples</span>
              {sampleRows.length < 5 ? (
                <button type="button" className="icon-button" onClick={addSampleRow} title="Add sample">
                  <Plus size={16} />
                </button>
              ) : null}
            </div>
            {sampleRows.map((row, i) => (
              <div key={i} style={{ border: '1px solid #e0e6ea', borderRadius: 8, padding: 10, marginBottom: 8, position: 'relative' }}>
                <div className="field-row" style={{ marginBottom: 6 }}>
                  <label style={{ flex: 1 }}>
                    Sample type
                    <select
                      value={SAMPLE_TYPES.includes(row.sampleType) ? row.sampleType : ''}
                      onChange={(e) => updateSampleRow(i, 'sampleType', e.target.value)}
                    >
                      <option value="">-- Select --</option>
                      {SAMPLE_TYPES.map((t) => <option key={t} value={t}>{t}</option>)}
                    </select>
                  </label>
                  <label style={{ flex: 1 }}>
                    Qty
                    <input value={row.qty} onChange={(e) => updateSampleRow(i, 'qty', e.target.value)} />
                  </label>
                </div>
                <div style={{ display: 'flex', gap: 8, alignItems: 'flex-end' }}>
                  <label style={{ flex: 1 }}>
                    Sample details (custom)
                    <input value={row.sampleType} onChange={(e) => updateSampleRow(i, 'sampleType', e.target.value)} placeholder="Or type a custom test name" />
                  </label>
                  {sampleRows.length > 1 ? (
                    <button type="button" className="icon-button" onClick={() => removeSampleRow(i)} title="Remove sample" style={{ marginBottom: 4 }}>
                      <X size={16} />
                    </button>
                  ) : null}
                </div>
              </div>
            ))}
          </div>
          <label>
            Assign to
            <input value={form.assign_to} onChange={(e) => update({ assign_to: e.target.value })} />
          </label>
        </div>
      ) : null}

      {/* Step 2: Payment */}
      {step === 2 ? (
        <div>
          <div className="field-row">
            <label>
              Total payment
              <input type="number" value={form.total_payment} onChange={(e) => update({ total_payment: e.target.value })} />
            </label>
            <label>
              Advance payment
              <input type="number" value={form.advance_payment} onChange={(e) => update({ advance_payment: e.target.value })} />
            </label>
          </div>
          <div className="field-row">
            <label>
              Balance due
              <input type="number" value={form.balance_dues} onChange={(e) => update({ balance_dues: e.target.value })} />
            </label>
            <label>
              Auto balance
              <input value={String(balanceDuePreview)} readOnly />
            </label>
          </div>
          <label>
            Payment followup
            <input value={form.payment_followup} onChange={(e) => update({ payment_followup: e.target.value })} />
          </label>
          <label>
            Remark
            <input value={form.remark} onChange={(e) => update({ remark: e.target.value })} />
          </label>
        </div>
      ) : null}

      {/* Step 3: Review */}
      {step === 3 ? (
        <div>
          <div className="settings-section">
            {([
              ['UID No', form.uid_no],
              ['Agency', form.agency_name],
              ['Mobile', form.mobile_no],
              ['Address', form.reporting_address],
              ['Work', form.name_of_work],
              ...sampleRows.filter((r) => r.sampleType).map((r, i) => [`Sample ${i + 1}`, `${r.sampleType}${r.qty ? ` (qty: ${r.qty})` : ''}`] as const),
              ['Total', form.total_payment],
              ['Advance', form.advance_payment],
              ['Balance', String(balanceDuePreview)],
              ['Remark', form.remark],
            ] as const).map(([label, value]) => (
              <div className="setting-row" key={label}>
                <span className="setting-label">{label}</span>
                <span style={{ color: '#17202a', fontWeight: 600 }}>{value || '-'}</span>
              </div>
            ))}
          </div>
        </div>
      ) : null}

      <div className="form-actions" style={{ justifyContent: 'space-between' }}>
        <div>
          {step > 0 ? (
            <button className="ghost-button" onClick={() => setStep((s) => s - 1)} type="button">
              <ArrowLeft size={16} /> Back
            </button>
          ) : editingId ? (
            <button className="ghost-button" onClick={onCancel} type="button">Cancel</button>
          ) : null}
        </div>
        <div style={{ display: 'flex', gap: 8 }}>
          {!editingId && step < 3 ? (
            <button type="button" className="ghost-button" onClick={() => { saveDraft(form); setLocalError('Draft saved') }}>
              <Save size={16} /> Draft
            </button>
          ) : null}
          {step < 3 ? (
            <button type="button" onClick={() => canNext() && setStep((s) => s + 1)} disabled={!canNext()}>
              Next <ArrowRight size={16} />
            </button>
          ) : (
            <button type="submit" disabled={saving}>
              <Save size={16} />
              {saving ? 'Saving...' : editingId ? 'Update' : 'Create'}
            </button>
          )}
        </div>
      </div>
    </form>
  )
}
