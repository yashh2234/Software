import { useCallback, useEffect, useState, type FormEvent } from 'react'
import { Plus, IndianRupee, Pencil, Trash2, Calendar, Download } from 'lucide-react'
import { request } from '../lib/api'
import { DataTable } from '../components/DataTable'

interface ExpenseItem {
  id: number
  date: string
  opening_balance: number
  total_income: number
  total_expenses: number
  closing_balance: number
  category: string
  remark: string
  payment_mode: string
  person_name: string
}

interface ExpenseSummary {
  total_income: number
  total_expenses: number
}

const EXPENSE_CATEGORIES = [
  'Site Exp', 'Corier and Speed Post', 'Convence and Transportation',
  'Survey Exp', 'DD and tendor Exp', 'Omendra Gupta Current ac',
  'Office Maintenance', 'Refreshment', 'stationary',
  'Machine and Car Repairing', 'Lab Testing Exp', 'Audit Expenses',
  'Telephone/Water/Electricity Exp', 'Printor and Computer Repairing exp',
  'Printing Exp', 'Cash advance', 'Salary', 'Other Exp',
]

const PAYMENT_MODES = ['', 'Cash', 'UPI', 'Bank Transfer', 'Card', 'Cheque']

export function ExpensesPage() {
  const [items, setItems] = useState<ExpenseItem[]>([])
  const [summary, setSummary] = useState<ExpenseSummary>({ total_income: 0, total_expenses: 0 })
  const [loading, setLoading] = useState(true)
  const [showForm, setShowForm] = useState(false)
  const [editingId, setEditingId] = useState<number | null>(null)
  const [date, setDate] = useState(new Date().toISOString().slice(0, 10))
  const [category, setCategory] = useState('')
  const [totalIncome, setTotalIncome] = useState('')
  const [totalExpenses, setTotalExpenses] = useState('')
  const [paymentMode, setPaymentMode] = useState('')
  const [remark, setRemark] = useState('')
  const [personName, setPersonName] = useState('')
  const [localError, setLocalError] = useState('')
  const [startDate, setStartDate] = useState('')
  const [endDate, setEndDate] = useState('')
  const [categoryFilter, setCategoryFilter] = useState('')

  const load = useCallback(async () => {
    setLoading(true)
    try {
      const params: Record<string, string> = {}
      if (startDate) params.start_date = startDate
      if (endDate) params.end_date = endDate
      if (categoryFilter) params.category = categoryFilter
      const qs = new URLSearchParams(params).toString()
      const data = await request<{ data: ExpenseItem[]; summary: ExpenseSummary }>(`/expenses${qs ? '?' + qs : ''}`)
      setItems(data.data)
      setSummary(data.summary)
    } catch {
      setLocalError('Unable to load expenses')
    } finally {
      setLoading(false)
    }
  }, [startDate, endDate, categoryFilter])

  useEffect(() => { void load() }, [load])

  const resetForm = () => {
    setDate(new Date().toISOString().slice(0, 10))
    setCategory('')
    setTotalIncome('')
    setTotalExpenses('')
    setPaymentMode('')
    setRemark('')
    setPersonName('')
    setEditingId(null)
  }

  const beginEdit = (item: ExpenseItem) => {
    setEditingId(item.id)
    setDate(item.date)
    setCategory(item.category)
    setTotalIncome(String(item.total_income || ''))
    setTotalExpenses(String(item.total_expenses || ''))
    setPaymentMode(item.payment_mode)
    setRemark(item.remark)
    setPersonName(item.person_name)
    setShowForm(true)
  }

  const handleSubmit = async (event: FormEvent<HTMLFormElement>) => {
    event.preventDefault()
    try {
      const payload = {
        date, category,
        total_income: totalIncome || '0',
        total_expenses: totalExpenses || '0',
        payment_mode: paymentMode,
        remark, person_name: personName,
      }
      if (editingId) {
        await request(`/expenses/${editingId}`, { method: 'PUT', body: JSON.stringify(payload) })
      } else {
        await request('/expenses', { method: 'POST', body: JSON.stringify(payload) })
      }
      setShowForm(false)
      resetForm()
      await load()
    } catch {
      setLocalError(editingId ? 'Failed to update expense' : 'Failed to save expense')
    }
  }

  const handleDelete = async (id: number) => {
    if (!confirm('Delete this expense entry?')) return
    try {
      await request(`/expenses/${id}`, { method: 'DELETE' })
      await load()
    } catch {
      setLocalError('Failed to delete expense')
    }
  }

  const handleExport = () => {
    const headers = ['Date', 'Category', 'Income', 'Expenses', 'Payment Mode', 'Person', 'Remark']
    const rows = items.map((item) => [item.date, item.category, item.total_income, item.total_expenses, item.payment_mode, item.person_name, item.remark])
    const csv = [headers.join(','), ...rows.map(r => r.map(v => `"${String(v ?? '').replace(/"/g, '""')}"`).join(','))].join('\n')
    const blob = new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8;' })
    const link = document.createElement('a')
    link.href = URL.createObjectURL(blob)
    link.download = `expenses_${new Date().toISOString().slice(0, 10)}.csv`
    link.click()
  }

  function money(v: number) {
    return new Intl.NumberFormat('en-IN', { maximumFractionDigits: 0 }).format(v)
  }

  return (
    <div className="two-column users-layout">
      <section className="surface">
        <div className="surface-heading">
          <div>
            <p className="section-label">Finance</p>
            <h2>Daily expenses</h2>
          </div>
          <div style={{ display: 'flex', gap: 12, alignItems: 'center' }}>
            <span className="sync-pill">Income: {money(summary.total_income)}</span>
            <span className="sync-pill">Expenses: {money(summary.total_expenses)}</span>
            <IndianRupee size={18} />
          </div>
        </div>

        <div className="user-toolbar" style={{ flexWrap: 'wrap', gap: 8 }}>
          <button className="ghost-button" onClick={() => { resetForm(); setShowForm(true) }} type="button">
            <Plus size={18} /> Add entry
          </button>
          <button className="ghost-button" onClick={handleExport} type="button">
            <Download size={18} /> Export
          </button>
          <div style={{ display: 'flex', alignItems: 'center', gap: 6, marginLeft: 'auto' }}>
            <Calendar size={14} style={{ color: '#65737d' }} />
            <input type="date" value={startDate} onChange={(e) => setStartDate(e.target.value)} style={{ fontSize: '0.8rem', padding: '4px 8px', borderRadius: 4, border: '1px solid #dfe6ea' }} />
            <span style={{ color: '#65737d', fontSize: '0.8rem' }}>to</span>
            <input type="date" value={endDate} onChange={(e) => setEndDate(e.target.value)} style={{ fontSize: '0.8rem', padding: '4px 8px', borderRadius: 4, border: '1px solid #dfe6ea' }} />
            <select value={categoryFilter} onChange={(e) => setCategoryFilter(e.target.value)} style={{ fontSize: '0.8rem', padding: '4px 8px', borderRadius: 4, border: '1px solid #dfe6ea' }}>
              <option value="">All Categories</option>
              {EXPENSE_CATEGORIES.map((c) => <option key={c} value={c}>{c}</option>)}
            </select>
          </div>
          <span className="sync-pill">{items.length} entries</span>
        </div>

        {localError ? <div className="error-banner">{localError}</div> : null}

        {loading ? (
          <p className="empty-state">Loading...</p>
        ) : (
          <DataTable
            columns={[
              { key: 'date', label: 'Date' },
              { key: 'category', label: 'Category' },
              { key: 'income', label: 'Income' },
              { key: 'expenses', label: 'Expenses' },
              { key: 'closing', label: 'Closing Bal' },
              { key: 'payment', label: 'Payment' },
              { key: 'person', label: 'Person' },
              { key: 'remark', label: 'Remark' },
              { key: 'actions', label: 'Actions', sortable: false },
            ]}
            rows={items.map((item) => ({
              date: item.date,
              category: item.category,
              income: money(item.total_income),
              expenses: money(item.total_expenses),
              closing: money(item.closing_balance),
              payment: item.payment_mode,
              person: item.person_name,
              remark: item.remark,
              actions: <div style={{ display: 'flex', gap: 4 }}>
                <button className="icon-button" onClick={() => beginEdit(item)} type="button" title="Edit"><Pencil size={15} /></button>
                <button className="icon-button" onClick={() => void handleDelete(item.id)} type="button" title="Delete"><Trash2 size={15} /></button>
              </div>,
            }))}
          />
        )}
      </section>

      {showForm ? (
        <form className="surface user-form" onSubmit={handleSubmit}>
          <div className="surface-heading">
            <div>
              <p className="section-label">Record</p>
              <h2>{editingId ? 'Edit expense' : 'New expense entry'}</h2>
            </div>
            <Plus size={20} />
          </div>

          <label>
            Date <span style={{ color: '#ef4444' }}>*</span>
            <input type="date" value={date} onChange={(e) => setDate(e.target.value)} required />
          </label>

          <label>
            Category <span style={{ color: '#ef4444' }}>*</span>
            <input list="expense-categories" value={category} onChange={(e) => setCategory(e.target.value)} required placeholder="Select or type category" />
            <datalist id="expense-categories">
              {EXPENSE_CATEGORIES.map((c) => <option key={c} value={c}>{c}</option>)}
            </datalist>
          </label>

          <div className="field-row">
            <label>
              Income (if any)
              <input type="number" value={totalIncome} onChange={(e) => setTotalIncome(e.target.value)} />
            </label>
            <label>
              Expense amount
              <input type="number" value={totalExpenses} onChange={(e) => setTotalExpenses(e.target.value)} />
            </label>
          </div>

          <label>
            Payment mode
            <select value={paymentMode} onChange={(e) => setPaymentMode(e.target.value)}>
              {PAYMENT_MODES.map((m) => <option key={m} value={m}>{m || 'Select Mode'}</option>)}
            </select>
          </label>

          <label>
            Person name
            <input value={personName} onChange={(e) => setPersonName(e.target.value)} />
          </label>

          <label>
            Remark
            <input value={remark} onChange={(e) => setRemark(e.target.value)} />
          </label>

          <div className="form-actions">
            <button className="ghost-button" onClick={() => { setShowForm(false); resetForm() }} type="button">Cancel</button>
            <button type="submit">{editingId ? 'Update' : 'Save'}</button>
          </div>
        </form>
      ) : null}
    </div>
  )
}
