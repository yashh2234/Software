import { useCallback, useEffect, useState, type FormEvent } from 'react'
import { Plus, Printer, Pencil, Trash2, X } from 'lucide-react'
import { api } from '../lib/api'
import { DataTable } from '../components/DataTable'
import type { PurchaseOrder, PurchaseOrderListItem } from '../lib/types'

interface POForm {
  date: string
  purchase_order: string
  agency_name: string
  reporting_address: string
  vendor_ref_no: string
  vendor_ref_date: string
  total_amount: string
  total_discount: string
  transportation: string
  gst_amount: string
  advance_amount: string
  net_amount: string
  remark: string
  items: POItemForm[]
}

interface POItemForm {
  description: string
  unit: string
  rate: string
  discount: string
  amount: string
}

const emptyForm: POForm = {
  date: new Date().toISOString().slice(0, 10),
  purchase_order: '',
  agency_name: '',
  reporting_address: '',
  vendor_ref_no: '',
  vendor_ref_date: '',
  total_amount: '0',
  total_discount: '0',
  transportation: '0',
  gst_amount: '0',
  advance_amount: '0',
  net_amount: '0',
  remark: '',
  items: [{ description: '', unit: '', rate: '0', discount: '0', amount: '0' }],
}

function money(v: number) {
  return new Intl.NumberFormat('en-IN', { maximumFractionDigits: 2 }).format(v)
}

export function PurchaseOrdersPage() {
  const [orders, setOrders] = useState<PurchaseOrder[]>([])
  const [loading, setLoading] = useState(true)
  const [showForm, setShowForm] = useState(false)
  const [editingId, setEditingId] = useState<number | null>(null)
  const [form, setForm] = useState<POForm>(emptyForm)
  const [localError, setLocalError] = useState('')
  const [startDate, setStartDate] = useState('')
  const [endDate, setEndDate] = useState('')

  const load = useCallback(async () => {
    setLoading(true)
    try {
      const params: Record<string, string> = {}
      if (startDate) params.start_date = startDate
      if (endDate) params.end_date = endDate
      const data = await api.purchaseOrders(params)
      setOrders(data.data)
    } catch {
      setLocalError('Unable to load purchase orders')
    } finally {
      setLoading(false)
    }
  }, [startDate, endDate])

  useEffect(() => { void load() }, [load])

  const recalcTotals = (f: POForm): POForm => {
    let totalAmount = 0
    let totalDiscount = 0

    for (const item of f.items) {
      const rate = parseFloat(item.rate) || 0
      const discount = parseFloat(item.discount) || 0
      const amount = rate - discount
      item.amount = String(Math.max(0, amount))
      totalAmount += amount
      totalDiscount += discount
    }

    const transportation = parseFloat(f.transportation) || 0
    const baseAmount = totalAmount + transportation
    const gst = baseAmount * 0.18
    const advance = parseFloat(f.advance_amount) || 0
    const netAmount = baseAmount + gst - advance

    return {
      ...f,
      total_amount: String(Math.round(totalAmount * 100) / 100),
      total_discount: String(Math.round(totalDiscount * 100) / 100),
      gst_amount: String(Math.round(gst * 100) / 100),
      net_amount: String(Math.round(netAmount * 100) / 100),
    }
  }

  const updateItem = (index: number, field: keyof POItemForm, value: string) => {
    const items = [...form.items]
    items[index] = { ...items[index], [field]: value }
    setForm((prev) => recalcTotals({ ...prev, items }))
  }

  const addItem = () => {
    setForm((prev) => recalcTotals({
      ...prev,
      items: [...prev.items, { description: '', unit: '', rate: '0', discount: '0', amount: '0' }],
    }))
  }

  const removeItem = (index: number) => {
    if (form.items.length <= 1) return
    const items = form.items.filter((_, i) => i !== index)
    setForm((prev) => recalcTotals({ ...prev, items }))
  }

  const beginCreate = () => {
    setEditingId(null)
    setForm(emptyForm)
    setLocalError('')
  }

  const beginEdit = (po: PurchaseOrder) => {
    setEditingId(po.iPurchaseorderId)
    setForm({
      date: po.date ?? new Date().toISOString().slice(0, 10),
      purchase_order: po.purchase_order ?? '',
      agency_name: po.agency_name ?? '',
      reporting_address: po.reporting_address ?? '',
      vendor_ref_no: po.vendor_ref_no ?? '',
      vendor_ref_date: po.vendor_ref_date ?? '',
      total_amount: String(po.total_amount ?? 0),
      total_discount: String(po.total_discount ?? 0),
      transportation: String(po.transportation ?? 0),
      gst_amount: String(po.gst_amount ?? 0),
      advance_amount: String(po.advance_amount ?? 0),
      net_amount: String(po.net_amount ?? 0),
      remark: po.remark ?? '',
      items: (po.items && po.items.length > 0
        ? po.items.map((item: PurchaseOrderListItem) => ({
            description: item.description ?? '',
            unit: item.unit ?? '',
            rate: String(item.rate ?? 0),
            discount: String(item.discount ?? 0),
            amount: String(item.amount ?? 0),
          }))
        : [{ description: '', unit: '', rate: '0', discount: '0', amount: '0' }]),
    })
    setLocalError('')
  }

  const handleSubmit = async (event: FormEvent<HTMLFormElement>) => {
    event.preventDefault()
    setLocalError('')
    try {
      const payload = {
        ...form,
        total_amount: parseFloat(form.total_amount) || 0,
        total_discount: parseFloat(form.total_discount) || 0,
        transportation: parseFloat(form.transportation) || 0,
        gst_amount: parseFloat(form.gst_amount) || 0,
        advance_amount: parseFloat(form.advance_amount) || 0,
        net_amount: parseFloat(form.net_amount) || 0,
        items: form.items.map((item) => ({
          description: item.description,
          unit: item.unit,
          rate: parseFloat(item.rate) || 0,
          discount: parseFloat(item.discount) || 0,
          amount: parseFloat(item.amount) || 0,
        })),
      }

      if (editingId) {
        await api.updatePurchaseOrder(editingId, payload)
      } else {
        await api.createPurchaseOrder(payload)
      }

      setShowForm(false)
      setEditingId(null)
      setForm(emptyForm)
      await load()
    } catch (e) {
      setLocalError(e instanceof Error ? e.message : 'Failed to save purchase order')
    }
  }

  const handleDelete = async (po: PurchaseOrder) => {
    if (!window.confirm(`Delete purchase order ${po.purchase_order}?`)) return
    setLocalError('')
    try {
      await api.deletePurchaseOrder(po.iPurchaseorderId)
      if (editingId === po.iPurchaseorderId) {
        setEditingId(null)
        setShowForm(false)
      }
      await load()
    } catch (e) {
      setLocalError(e instanceof Error ? e.message : 'Failed to delete purchase order')
    }
  }

  const handlePrint = async (id: number) => {
    try {
      const res = await api.printPurchaseOrder(id)
      const w = window.open('', '_blank')
      if (w) {
        w.document.write(res.html)
        w.document.close()
      }
    } catch {
      setLocalError('Failed to load print view')
    }
  }

  const handleField = (field: keyof POForm, value: string) => {
    setForm((prev) => ({ ...prev, [field]: value }))
  }

  return (
    <div className="two-column users-layout" style={{ gridTemplateColumns: showForm ? '1fr 480px' : '1fr' }}>
      <section className="surface">
        <div className="surface-heading">
          <div>
            <p className="section-label">Procurement</p>
            <h2>Purchase orders</h2>
          </div>
          <div style={{ display: 'flex', gap: 8, alignItems: 'center' }}>
            <input type="date" value={startDate} onChange={(e) => setStartDate(e.target.value)} style={{ padding: '6px 8px', border: '1px solid var(--color-input-border)', borderRadius: 'var(--radius-sm)', fontSize: '0.82rem' }} />
            <input type="date" value={endDate} onChange={(e) => setEndDate(e.target.value)} style={{ padding: '6px 8px', border: '1px solid var(--color-input-border)', borderRadius: 'var(--radius-sm)', fontSize: '0.82rem' }} />
          </div>
        </div>

        <div className="user-toolbar">
          <button className="ghost-button" onClick={beginCreate} type="button">
            <Plus size={18} />
            New Purchase Order
          </button>
          <span className="sync-pill">{orders.length} orders</span>
        </div>

        {localError ? <div className="error-banner">{localError}</div> : null}

        {loading ? (
          <p className="empty-state">Loading...</p>
        ) : (
          <DataTable
            columns={[
              { key: 'date', label: 'Date' },
              { key: 'agency_name', label: 'Agency' },
              { key: 'reporting_address', label: 'Address' },
              { key: 'purchase_order', label: 'PO No' },
              { key: 'vendor_ref_no', label: 'Vendor Ref No' },
              { key: 'vendor_ref_date', label: 'Vendor Ref Date' },
              { key: 'total_amount', label: 'Total Amount' },
              { key: 'actions', label: 'Actions', sortable: false },
            ]}
            rows={orders.map((po) => ({
              date: po.date ?? '-',
              agency_name: po.agency_name ?? '-',
              reporting_address: po.reporting_address ?? '-',
              purchase_order: po.purchase_order,
              vendor_ref_no: po.vendor_ref_no ?? '-',
              vendor_ref_date: po.vendor_ref_date ?? '-',
              total_amount: money(po.total_amount),
              actions: <div className="row-actions user-actions">
                <button className="icon-button" onClick={() => { setShowForm(false); setEditingId(null); void handlePrint(po.iPurchaseorderId) }} type="button" title="Print">
                  <Printer size={17} />
                </button>
                <button className="icon-button" onClick={() => { setShowForm(true); beginEdit(po) }} type="button" title="Edit">
                  <Pencil size={17} />
                </button>
                <button className="icon-button" onClick={() => void handleDelete(po)} type="button" title="Delete">
                  <Trash2 size={17} />
                </button>
              </div>,
            }))}
            exportable={true}
            filename="purchase-orders"
          />
        )}
      </section>

      {showForm ? (
        <form className="surface user-form" onSubmit={handleSubmit} style={{ maxHeight: 'calc(100vh - 100px)', overflowY: 'auto' }}>
          <div className="surface-heading">
            <div>
              <p className="section-label">{editingId ? 'Update' : 'Create'}</p>
              <h2>{editingId ? 'Edit Purchase Order' : 'New Purchase Order'}</h2>
            </div>
            <button className="icon-button" onClick={() => { setShowForm(false); setEditingId(null) }} type="button">
              <X size={18} />
            </button>
          </div>

          <div className="field-row">
            <label>
              Date
              <input type="date" value={form.date} onChange={(e) => handleField('date', e.target.value)} required />
            </label>
            <label>
              Purchase Order No
              <input value={form.purchase_order} onChange={(e) => handleField('purchase_order', e.target.value)} required />
            </label>
          </div>

          <label>
            Agency Name
            <input value={form.agency_name} onChange={(e) => handleField('agency_name', e.target.value)} />
          </label>

          <label>
            Reporting Address
            <textarea value={form.reporting_address} onChange={(e) => handleField('reporting_address', e.target.value)} rows={2} />
          </label>

          <div className="field-row">
            <label>
              Vendor Ref No
              <input value={form.vendor_ref_no} onChange={(e) => handleField('vendor_ref_no', e.target.value)} />
            </label>
            <label>
              Vendor Ref Date
              <input type="date" value={form.vendor_ref_date} onChange={(e) => handleField('vendor_ref_date', e.target.value)} />
            </label>
          </div>

          <div style={{ marginTop: 16, marginBottom: 8 }}>
            <strong style={{ fontSize: '0.84rem' }}>Line Items</strong>
          </div>

          <div style={{ border: '1px solid var(--color-input-border)', borderRadius: 'var(--radius-sm)', marginBottom: 12 }}>
            <table style={{ width: '100%', borderCollapse: 'collapse', fontSize: '0.78rem' }}>
              <thead>
                <tr style={{ background: 'var(--color-surface-alt)' }}>
                  <th style={{ padding: '4px 6px', textAlign: 'left' }}>Description</th>
                  <th style={{ padding: '4px 6px', textAlign: 'right', width: 50 }}>Rate</th>
                  <th style={{ padding: '4px 6px', textAlign: 'center', width: 44 }}>Unit</th>
                  <th style={{ padding: '4px 6px', textAlign: 'right', width: 50 }}>Disc</th>
                  <th style={{ padding: '4px 6px', textAlign: 'right', width: 60 }}>Amount</th>
                  <th style={{ padding: '4px 6px', width: 28 }}></th>
                </tr>
              </thead>
              <tbody>
                {form.items.map((item, index) => (
                  <tr key={index}>
                    <td style={{ padding: 2 }}>
                      <input value={item.description} onChange={(e) => updateItem(index, 'description', e.target.value)} placeholder="Description" style={{ width: '100%', border: 'none', padding: '4px 2px', fontSize: '0.78rem' }} />
                    </td>
                    <td style={{ padding: 2 }}>
                      <input type="number" value={item.rate} onChange={(e) => updateItem(index, 'rate', e.target.value)} style={{ width: '100%', border: 'none', padding: '4px 2px', textAlign: 'right', fontSize: '0.78rem' }} />
                    </td>
                    <td style={{ padding: 2 }}>
                      <input value={item.unit} onChange={(e) => updateItem(index, 'unit', e.target.value)} placeholder="Unit" style={{ width: '100%', border: 'none', padding: '4px 2px', textAlign: 'center', fontSize: '0.78rem' }} />
                    </td>
                    <td style={{ padding: 2 }}>
                      <input type="number" value={item.discount} onChange={(e) => updateItem(index, 'discount', e.target.value)} style={{ width: '100%', border: 'none', padding: '4px 2px', textAlign: 'right', fontSize: '0.78rem' }} />
                    </td>
                    <td style={{ padding: 2 }}>
                      <span style={{ display: 'block', padding: '4px 2px', textAlign: 'right' }}>{parseFloat(item.amount || '0').toFixed(2)}</span>
                    </td>
                    <td style={{ padding: 2 }}>
                      <button className="icon-button" onClick={() => removeItem(index)} type="button" title="Remove" style={{ width: 24, height: 24 }}>
                        <X size={14} />
                      </button>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
            <button className="ghost-button" onClick={addItem} type="button" style={{ width: '100%', fontSize: '0.78rem', borderTop: '1px solid var(--color-input-border)', borderRadius: 0 }}>
              + Add Item
            </button>
          </div>

          <div className="field-row">
            <label>
              Transportation
              <input type="number" value={form.transportation} onChange={(e) => setForm((prev) => recalcTotals({ ...prev, transportation: e.target.value }))} />
            </label>
            <label>
              Advance Amount
              <input type="number" value={form.advance_amount} onChange={(e) => setForm((prev) => recalcTotals({ ...prev, advance_amount: e.target.value }))} />
            </label>
          </div>

          <div className="field-row">
            <label>
              GST @ 18%
              <input type="number" value={form.gst_amount} readOnly style={{ background: 'var(--color-surface-alt)' }} />
            </label>
            <label>
              Net Amount
              <input type="number" value={form.net_amount} readOnly style={{ background: 'var(--color-surface-alt)', fontWeight: 700 }} />
            </label>
          </div>

          <label>
            Remark
            <textarea value={form.remark} onChange={(e) => handleField('remark', e.target.value)} rows={2} />
          </label>

          {localError ? <div className="error-banner">{localError}</div> : null}

          <div className="form-actions">
            <button className="ghost-button" onClick={() => { setShowForm(false); setEditingId(null) }} type="button">Cancel</button>
            <button type="submit">{editingId ? 'Update Purchase Order' : 'Create Purchase Order'}</button>
          </div>
        </form>
      ) : null}
    </div>
  )
}
