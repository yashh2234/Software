import { useCallback, useEffect, useState } from 'react'
import { X, FileText, Image as ImageIcon, History, Download, Folder, ShieldCheck } from 'lucide-react'
import { Button, Chip, Card } from '@heroui/react'
import { request } from '../lib/api'

interface UIDDocumentDrawerProps {
  uidNo: string
  isOpen: boolean
  onClose: () => void
}

interface DocumentItem {
  id: number
  title: string
  file_name: string
  file_path: string
  file_type: string
  file_size: number
  tags: string
  created_at: string
  category?: { name: string }
  latest_version?: { version_number: number }
  versions?: Array<{ id: number; version_number: number; change_notes: string; created_at: string }>
}

export function UIDDocumentDrawer({ uidNo, isOpen, onClose }: UIDDocumentDrawerProps) {
  const [documents, setDocuments] = useState<DocumentItem[]>([])
  const [reportVersions, setReportVersions] = useState<any[]>([])
  const [loading, setLoading] = useState(true)
  const [activeTab, setActiveTab] = useState<'all' | 'photos'>('all')

  const loadUidDocuments = useCallback(async () => {
    if (!uidNo) return
    setLoading(true)
    try {
      const res = await request<{ data: DocumentItem[] }>(`/documents?search=${encodeURIComponent(uidNo)}`)
      setDocuments(res.data ?? [])

      try {
        const vRes = await request<{ data: any[] }>(`/reports/cc_cube/1/versions`)
        setReportVersions(vRes.data ?? [])
      } catch {}
    } catch {
    } finally {
      setLoading(false)
    }
  }, [uidNo])

  useEffect(() => {
    if (isOpen && uidNo) {
      void loadUidDocuments()
    }
  }, [isOpen, uidNo, loadUidDocuments])

  if (!isOpen) return null

  const photos = documents.filter((d) => d.file_type?.startsWith('image/') || d.tags?.includes('sample_photo'))
  const displayedDocuments = activeTab === 'photos' ? photos : documents

  return (
    <div className="fixed inset-0 z-50 flex justify-end bg-black/40 backdrop-blur-xs transition-opacity">
      <div className="w-full max-w-xl bg-content1 h-full shadow-2xl flex flex-col border-l border-default-200 overflow-hidden">
        {/* Header */}
        <div className="p-4 border-b border-default-200 flex items-center justify-between bg-default-50">
          <div className="flex items-center gap-2.5">
            <div className="p-2 rounded-lg bg-primary/10 text-primary">
              <Folder size={20} />
            </div>
            <div>
              <h3 className="text-base font-bold text-default-900">UID Document Repository</h3>
              <div className="flex items-center gap-1.5 mt-0.5">
                <span className="text-xs text-default-500">UID:</span>
                <Chip size="sm" color="accent" variant="soft" className="font-mono font-bold">
                  {uidNo}
                </Chip>
              </div>
            </div>
          </div>
          <Button isIconOnly size="sm" variant="ghost" onClick={onClose}>
            <X size={18} />
          </Button>
        </div>

        {/* Category Tabs */}
        <div className="p-3 border-b border-default-200 flex items-center gap-2 bg-default-100/50">
          <Button
            size="sm"
            variant={activeTab === 'all' ? 'primary' : 'outline'}
            onClick={() => setActiveTab('all')}
            className="font-semibold text-xs"
          >
            All Files ({documents.length})
          </Button>
          <Button
            size="sm"
            variant={activeTab === 'photos' ? 'primary' : 'outline'}
            onClick={() => setActiveTab('photos')}
            className="font-semibold text-xs"
          >
            <ImageIcon size={14} className="mr-1 inline" /> Sample Photos ({photos.length})
          </Button>
        </div>

        {/* Content Body */}
        <div className="p-4 flex-1 overflow-y-auto space-y-4">
          {loading ? (
            <p className="text-xs text-default-500 text-center py-8">Loading UID repository files...</p>
          ) : documents.length === 0 && reportVersions.length === 0 ? (
            <div className="text-center py-12 border border-dashed border-default-300 rounded-2xl p-6 bg-default-50/50">
              <Folder size={36} className="mx-auto text-default-400 mb-2" />
              <p className="text-sm font-bold text-default-700">No documents stored for this UID yet.</p>
              <p className="text-xs text-default-400 mt-1">Upload work orders, sample intake photos, or test reports.</p>
            </div>
          ) : (
            <div className="space-y-3">
              {/* Report Version History Section */}
              {reportVersions.length > 0 ? (
                <Card className="border border-primary/20 bg-primary/5 shadow-none p-3">
                  <div className="flex items-center gap-1.5 mb-2">
                    <History size={15} className="text-primary" />
                    <h4 className="text-xs font-bold text-primary uppercase tracking-wider">
                      Report Revision History (Version Control)
                    </h4>
                  </div>
                  <div className="space-y-2">
                    {reportVersions.map((v) => (
                      <div key={v.id} className="flex items-center justify-between p-2.5 rounded-lg bg-content1 border border-default-200 text-xs">
                        <div>
                          <strong className="font-bold text-default-900">Version {v.version_number}</strong>
                          <span className="text-default-500 ml-2">({v.change_notes || 'Revision snapshot'})</span>
                          <small className="text-default-400 block mt-0.5">{v.created_at}</small>
                        </div>
                        <Chip size="sm" color="success" variant="soft" className="font-bold">
                          V{v.version_number} Saved
                        </Chip>
                      </div>
                    ))}
                  </div>
                </Card>
              ) : null}

              {/* General Documents List */}
              <h4 className="text-xs font-bold text-default-600 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                <FileText size={14} /> Attached UID Files
              </h4>
              {displayedDocuments.map((doc) => (
                <Card key={doc.id} className="border border-default-200 shadow-none hover:border-primary/40 transition-colors p-3 flex flex-row items-center justify-between gap-3">
                  <div className="flex items-center gap-3 truncate">
                    <div className="p-2 rounded-lg bg-default-100 shrink-0">
                      {doc.file_type?.startsWith('image/') ? (
                        <ImageIcon size={18} className="text-success" />
                      ) : (
                        <FileText size={18} className="text-primary" />
                      )}
                    </div>
                    <div className="truncate">
                      <strong className="text-xs font-bold text-default-900 truncate block">{doc.file_name}</strong>
                      <small className="text-[11px] text-default-500">{doc.category?.name || 'Document'} | {doc.created_at}</small>
                    </div>
                  </div>

                  <a
                    href={`http://localhost:8000/storage/${doc.file_path}`}
                    target="_blank"
                    rel="noreferrer"
                    className="shrink-0"
                  >
                    <Button size="sm" variant="outline" isIconOnly>
                      <Download size={14} />
                    </Button>
                  </a>
                </Card>
              ))}
            </div>
          )}
        </div>

        {/* Footer info */}
        <div className="p-3 border-t border-default-200 bg-default-50 text-[11px] text-default-400 flex items-center justify-between">
          <span className="flex items-center gap-1"><ShieldCheck size={12} className="text-success" /> Immutable Version Control Enabled</span>
          <Chip size="sm" color="success" variant="soft" className="text-[10px]">Zero Overwriting</Chip>
        </div>
      </div>
    </div>
  )
}
