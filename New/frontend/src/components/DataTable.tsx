import { useMemo, useState, type ReactNode } from 'react'
import { ArrowUpDown, ArrowUp, ArrowDown, Download } from 'lucide-react'

interface DataTableColumn {
  key: string
  label: string
  sortable?: boolean
}

interface DataTableProps {
  columns: DataTableColumn[]
  rows: Array<Record<string, ReactNode>>
  pageSize?: number
  exportable?: boolean
  filename?: string
}

export function DataTable({ columns, rows, pageSize = 20, exportable = true, filename = 'export' }: DataTableProps) {
  const [sortKey, setSortKey] = useState<string | null>(null)
  const [sortDir, setSortDir] = useState<'asc' | 'desc'>('asc')
  const [page, setPage] = useState(1)
  const [search, setSearch] = useState('')

  const handleSort = (key: string) => {
    if (sortKey === key) {
      setSortDir((d) => (d === 'asc' ? 'desc' : 'asc'))
    } else {
      setSortKey(key)
      setSortDir('asc')
    }
    setPage(1)
  }

  const filtered = useMemo(() => {
    if (!search.trim()) return rows
    const q = search.toLowerCase()
    return rows.filter((row) =>
      columns.some((col) => {
        const val = row[col.key]
        return val != null && String(val).toLowerCase().includes(q)
      }),
    )
  }, [rows, search, columns])

  const sorted = useMemo(() => {
    if (!sortKey) return filtered
    return [...filtered].sort((a, b) => {
      const aVal = a[sortKey]
      const bVal = b[sortKey]
      if (aVal == null) return 1
      if (bVal == null) return -1

      let cmp = 0
      if (typeof aVal === 'number' && typeof bVal === 'number') {
        cmp = aVal - bVal
      } else {
        cmp = String(aVal).localeCompare(String(bVal), undefined, { numeric: true })
      }
      return sortDir === 'asc' ? cmp : -cmp
    })
  }, [filtered, sortKey, sortDir])

  const totalPages = Math.max(1, Math.ceil(sorted.length / pageSize))
  const safePage = Math.min(page, totalPages)
  const pageRows = sorted.slice((safePage - 1) * pageSize, safePage * pageSize)

  const exportCsv = () => {
    const header = columns.map((c) => c.label).join(',')
    const body = sorted
      .map((row) => columns.map((col) => `"${String(row[col.key] ?? '').replaceAll('"', '""')}"`).join(','))
      .join('\n')
    const blob = new Blob([`${header}\n${body}`], { type: 'text/csv' })
    const url = URL.createObjectURL(blob)
    const a = document.createElement('a')
    a.href = url
    a.download = `${filename}.csv`
    a.click()
    URL.revokeObjectURL(url)
  }

  const SortIcon = ({ columnKey }: { columnKey: string }) => {
    if (sortKey !== columnKey) return <ArrowUpDown size={13} style={{ opacity: 0.3 }} />
    return sortDir === 'asc' ? <ArrowUp size={13} /> : <ArrowDown size={13} />
  }

  return (
    <div>
      <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 12, gap: 8 }}>
        <div className="search-field" style={{ width: 260 }}>
          <input
            placeholder="Filter records..."
            value={search}
            onChange={(e) => { setSearch(e.target.value); setPage(1) }}
            style={{ border: '1px solid var(--color-input-border)', borderRadius: 'var(--radius-sm)', padding: '8px 12px', width: '100%' }}
          />
        </div>
        <div style={{ display: 'flex', gap: 8, alignItems: 'center' }}>
          <span className="sync-pill">{sorted.length} records</span>
          {exportable ? (
            <button className="icon-button" onClick={exportCsv} type="button" title="Export CSV">
              <Download size={17} />
            </button>
          ) : null}
        </div>
      </div>

      <div className="table-wrap">
        <table>
          <thead>
            <tr>
              {columns.map((col) => (
                <th
                  key={col.key}
                  onClick={() => col.sortable !== false ? handleSort(col.key) : undefined}
                  style={{ cursor: col.sortable !== false ? 'pointer' : 'default', userSelect: 'none' }}
                >
                  <span style={{ display: 'inline-flex', alignItems: 'center', gap: 4 }}>
                    {col.label}
                    {col.sortable !== false ? <SortIcon columnKey={col.key} /> : null}
                  </span>
                </th>
              ))}
            </tr>
          </thead>
          <tbody>
            {pageRows.length === 0 ? (
              <tr>
                <td colSpan={columns.length} style={{ textAlign: 'center', padding: 32, color: '#65737d' }}>
                  No records found.
                </td>
              </tr>
            ) : (
              pageRows.map((row, index) => (
                <tr key={index}>
                  {columns.map((col) => (
                    <td key={col.key}>{row[col.key] ?? ''}</td>
                  ))}
                </tr>
              ))
            )}
          </tbody>
        </table>
      </div>

      {totalPages > 1 ? (
        <div style={{ display: 'flex', justifyContent: 'center', alignItems: 'center', gap: 8, marginTop: 16 }}>
          <button
            className="ghost-button"
            onClick={() => setPage((p) => Math.max(1, p - 1))}
            disabled={safePage <= 1}
            type="button"
          >
            Previous
          </button>
          <span style={{ fontSize: '0.82rem', color: '#4a5b66' }}>
            Page {safePage} of {totalPages}
          </span>
          <button
            className="ghost-button"
            onClick={() => setPage((p) => Math.min(totalPages, p + 1))}
            disabled={safePage >= totalPages}
            type="button"
          >
            Next
          </button>
        </div>
      ) : null}
    </div>
  )
}
