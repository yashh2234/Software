import { useMemo, useState, type ReactNode } from 'react'
import { ArrowUpDown, ArrowUp, ArrowDown, Download, Search, ChevronLeft, ChevronRight } from 'lucide-react'
import { Table, Button, Chip } from '@heroui/react'

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
  onRowClick?: (row: Record<string, ReactNode>) => void
}

export function DataTable({ columns, rows, pageSize = 15, exportable = true, filename = 'export', onRowClick }: DataTableProps) {
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
    if (sortKey !== columnKey) return <ArrowUpDown size={13} className="text-default-400" />
    return sortDir === 'asc' ? <ArrowUp size={13} className="text-primary" /> : <ArrowDown size={13} className="text-primary" />
  }

  return (
    <div className="space-y-3">
      {/* Top Filter & Export Bar */}
      <div className="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 bg-content1 p-3 rounded-xl border border-default-200 shadow-xs">
        <div className="relative w-full sm:w-72">
          <Search size={15} className="absolute left-3 top-1/2 -translate-y-1/2 text-default-400" />
          <input
            type="text"
            placeholder="Search records..."
            value={search}
            onChange={(e) => { setSearch(e.target.value); setPage(1) }}
            className="w-full bg-default-100 hover:bg-default-200/80 transition-colors rounded-lg pl-9 pr-3 py-1.5 text-xs outline-none focus:ring-2 focus:ring-primary/40 border border-default-200"
          />
        </div>

        <div className="flex items-center gap-2">
          <Chip size="sm" color="accent" variant="soft" className="font-semibold text-xs">
            {sorted.length} {sorted.length === 1 ? 'record' : 'records'}
          </Chip>

          {exportable ? (
            <Button
              size="sm"
              variant="outline"
              onClick={exportCsv}
              className="font-semibold text-xs"
            >
              <Download size={14} className="mr-1 inline" /> Export CSV
            </Button>
          ) : null}
        </div>
      </div>

      {/* Modern Data Table */}
      <div className="rounded-xl border border-default-200 overflow-x-auto bg-content1 shadow-xs">
        <Table className="w-full text-left text-xs border-collapse">
          <Table.Header>
            <Table.Row className="bg-default-100/70 border-b border-default-200">
              {columns.map((col) => (
                <Table.Column key={col.key} className="py-3 px-3.5 font-bold text-default-700 uppercase tracking-wider text-[11px]">
                  {col.sortable !== false ? (
                    <button
                      type="button"
                      onClick={() => handleSort(col.key)}
                      className="flex items-center gap-1.5 hover:text-primary transition-colors font-bold"
                    >
                      <span>{col.label}</span>
                      <SortIcon columnKey={col.key} />
                    </button>
                  ) : (
                    <span>{col.label}</span>
                  )}
                </Table.Column>
              ))}
            </Table.Row>
          </Table.Header>
          <Table.Body>
            {pageRows.length === 0 ? (
              <Table.Row>
                <Table.Cell colSpan={columns.length} className="py-8 text-center text-default-400 font-medium">
                  No records found.
                </Table.Cell>
              </Table.Row>
            ) : (
              pageRows.map((row, idx) => (
                <Table.Row
                  key={row.id ? String(row.id) : idx}
                  onClick={() => onRowClick?.(row)}
                  className={`border-b border-default-100 ${onRowClick ? 'cursor-pointer hover:bg-default-100/60' : 'hover:bg-default-50'} transition-colors`}
                >
                  {columns.map((col) => (
                    <Table.Cell key={col.key} className="py-2.5 px-3.5 text-default-800">
                      {row[col.key]}
                    </Table.Cell>
                  ))}
                </Table.Row>
              ))
            )}
          </Table.Body>
        </Table>

        {/* Footer Pagination */}
        {totalPages > 1 ? (
          <div className="flex items-center justify-between p-3 border-t border-default-200 bg-default-50/50 text-xs">
            <span className="text-default-500 font-medium">
              Page {safePage} of {totalPages} ({sorted.length} total records)
            </span>

            <div className="flex items-center gap-1">
              <Button
                size="sm"
                variant="outline"
                isDisabled={safePage <= 1}
                onClick={() => setPage((p) => Math.max(1, p - 1))}
              >
                <ChevronLeft size={14} /> Previous
              </Button>

              <Button
                size="sm"
                variant="outline"
                isDisabled={safePage >= totalPages}
                onClick={() => setPage((p) => Math.min(totalPages, p + 1))}
              >
                Next <ChevronRight size={14} />
              </Button>
            </div>
          </div>
        ) : null}
      </div>
    </div>
  )
}
