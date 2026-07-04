import { useCallback, useEffect, useState } from 'react'
import { AlertTriangle } from 'lucide-react'
import { api } from '../lib/api'
import { DataTable } from '../components/DataTable'

interface DueReport {
  iClientId: number
  uid_no: string
  received_date: string | null
  agency_name: string
  mobile_no: string
  name_of_work: string
  sample_details: string
}

export function DueReportsPage() {
  const [data, setData] = useState<DueReport[]>([])
  const [loading, setLoading] = useState(true)
  const [error, setError] = useState('')

  const load = useCallback(async () => {
    setLoading(true)
    setError('')
    try {
      const res = await api.dueReports()
      setData(res.data)
    } catch {
      setError('Failed to load due reports')
    } finally {
      setLoading(false)
    }
  }, [])

  useEffect(() => { void load() }, [load])

  const columns = [
    { key: 'uid_no', label: 'UID No' },
    { key: 'received_date', label: 'Received Date' },
    { key: 'agency_name', label: 'Agency' },
    { key: 'mobile_no', label: 'Mobile' },
    { key: 'name_of_work', label: 'Name of Work' },
    { key: 'sample_details', label: 'Sample Details' },
  ]

  const rows = data.map((r) => ({
    uid_no: r.uid_no,
    received_date: r.received_date ?? '-',
    agency_name: r.agency_name ?? '-',
    mobile_no: r.mobile_no ?? '-',
    name_of_work: r.name_of_work ?? '-',
    sample_details: r.sample_details ?? '-',
  }))

  return (
    <section className="surface">
      <div className="surface-heading">
        <div>
          <p className="section-label">Overdue</p>
          <h2 style={{ display: 'flex', alignItems: 'center', gap: 8 }}>
            <AlertTriangle size={20} color="#e8a838" />
            Due Reports
          </h2>
        </div>
      </div>

      {error ? <div className="error-banner">{error}</div> : null}

      {loading ? (
        <p className="empty-state">Loading due reports...</p>
      ) : data.length === 0 ? (
        <p className="empty-state">No overdue reports found. All samples have reports assigned.</p>
      ) : (
        <DataTable columns={columns} rows={rows} filename="due-reports" />
      )}
    </section>
  )
}
