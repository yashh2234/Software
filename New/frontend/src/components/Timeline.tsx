import { FileText, User, Play, Check, X, Clock, History } from 'lucide-react'

interface TimelineEntry {
  event: string
  timestamp: string | null
  icon: string
  user?: string
}

interface TimelineProps {
  entries: TimelineEntry[]
  onClose: () => void
}

const iconMap: Record<string, React.ReactNode> = {
  file: <FileText size={16} />,
  file_text: <FileText size={16} />,
  user: <User size={16} />,
  play: <Play size={16} />,
  check: <Check size={16} />,
  x: <X size={16} />,
  audit: <History size={16} />,
}

export function Timeline({ entries, onClose }: TimelineProps) {
  return (
    <div
      style={{
        position: 'fixed', inset: 0, background: 'rgba(0,0,0,0.35)',
        display: 'flex', alignItems: 'center', justifyContent: 'center', zIndex: 200,
      }}
      onClick={onClose}
    >
      <div
        style={{
          background: '#fff', borderRadius: 12, padding: 24, minWidth: 420, maxWidth: 520,
          maxHeight: '70vh', overflowY: 'auto', boxShadow: '0 16px 48px rgba(0,0,0,0.15)',
        }}
        onClick={(e) => e.stopPropagation()}
      >
        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 20 }}>
          <h3 style={{ fontSize: '1.05rem', fontWeight: 700 }}>Activity Timeline</h3>
          <button className="icon-button" onClick={onClose} type="button"><X size={18} /></button>
        </div>

        {entries.length === 0 ? (
          <p style={{ color: '#65737d', textAlign: 'center', padding: 24 }}>No timeline entries available.</p>
        ) : (
          <div style={{ position: 'relative', paddingLeft: 28 }}>
            <div style={{ position: 'absolute', left: 12, top: 8, bottom: 8, width: 2, background: '#dfe6ea' }} />
            {entries.map((entry, i) => (
              <div key={i} style={{ position: 'relative', paddingBottom: 20, paddingLeft: 20 }}>
                <div
                  style={{
                    position: 'absolute', left: -22, top: 2,
                    width: 28, height: 28, borderRadius: '50%',
                    background: '#edf6f4', border: '2px solid #cfe2dd',
                    display: 'flex', alignItems: 'center', justifyContent: 'center',
                    color: '#327268',
                  }}
                >
                  {iconMap[entry.icon] ?? <Clock size={14} />}
                </div>
                <div>
                  <strong style={{ fontSize: '0.88rem', display: 'block' }}>{entry.event}</strong>
                  <span style={{ fontSize: '0.76rem', color: '#65737d' }}>
                    {entry.timestamp ? new Date(entry.timestamp).toLocaleString('en-IN', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : ''}
                    {entry.user ? ` by ${entry.user}` : ''}
                  </span>
                </div>
              </div>
            ))}
          </div>
        )}
      </div>
    </div>
  )
}
