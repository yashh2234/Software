import { useCallback, useEffect, useState, type FormEvent } from 'react'
import { Plus, IndianRupee } from 'lucide-react'
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

export function ExpensesPage() {
  const [items, setItems] = useState<ExpenseItem[]>([])
  const [summary, setSummary] = useState<ExpenseSummary>({ total_income: 0, total_expenses: 0 })
  const [loading, setLoading] = useState(true)
  const [showForm, setShowForm] = useState(false)
  const [date, setDate] = useState(new Date().toISOString().slice(0, 10))
  const [category, setCategory] = useState('')
  const [totalIncome, setTotalIncome] = useState('')
  const [totalExpenses, setTotalExpenses] = useState('')
  const [paymentMode, setPaymentMode] = useState('')
  const [remark, setRemark] = useState('')
  const [personName, setPersonName] = useState('')
  const [localError, setLocalError] = useState('')

  const load = useCallback(async () => {
    setLoading(true)
    try {
      const data = await request<{ data: ExpenseItem[]; summary: ExpenseSummary }>('/expenses')
      setItems(data.data)
      setSummary(data.summary)
    } catch {
      setLocalError('Unable to load expenses')
    } finally {
      setLoading(false)
    }
  }, [])

  useEffect(() => { void load() }, [load])

  const handleSubmit = async (event: FormEvent<HTMLFormElement>) => {
    event.preventDefault()
    try {
      await request('/expenses', {
        method: 'POST',
        body: JSON.stringify({
          date,
          category,
          total_income: totalIncome || '0',
          total_expenses: totalExpenses || '0',
          payment_mode: paymentMode,
          remark,
          person_name: personName,
        }),
      })
      setShowForm(false)
      setCategory('')
      setTotalIncome('')
      setTotalExpenses('')
      setPaymentMode('')
      setRemark('')
      setPersonName('')
      await load()
    } catch {
      setLocalError('Failed to save expense')
    }
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

        <div className="user-toolbar">
          <button className="ghost-button" onClick={() => setShowForm(true)} type="button">
            <Plus size={18} />
            Add entry
          </button>
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
              { key: 'payment', label: 'Payment' },
              { key: 'person', label: 'Person' },
              { key: 'remark', label: 'Remark' },
            ]}
            rows={items.map((item) => ({
              date: item.date,
              category: item.category,
              income: money(item.total_income),
              expenses: money(item.total_expenses),
              payment: item.payment_mode,
              person: item.person_name,
              remark: item.remark,
            }))}
          />
        )}
      </section>

      {showForm ? (
        <form className="surface user-form" onSubmit={handleSubmit}>
          <div className="surface-heading">
            <div>
              <p className="section-label">Record</p>
              <h2>New expense entry</h2>
            </div>
            <Plus size={20} />
          </div>

          <div className="field-row">
            <label>
              Date
              <input type="date" value={date} onChange={(e) => setDate(e.target.value)} />
            </label>
            <label>
              Category
              <input value={category} onChange={(e) => setCategory(e.target.value)} placeholder="e.g. Office Supplies" />
            </label>
          </div>

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
              <option value="">Select</option>
              <option value="Cash">Cash</option>
              <option value="UPI">UPI</option>
              <option value="Bank Transfer">Bank Transfer</option>
              <option value="Card">Card</option>
              <option value="Cheque">Cheque</option>
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
            <button className="ghost-button" onClick={() => setShowForm(false)} type="button">Cancel</button>
            <button type="submit">Save entry</button>
          </div>
        </form>
      ) : null}
    </div>
  )
}
