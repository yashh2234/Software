import { useCallback, useEffect, useRef, useState } from 'react'
import { Bell, FlaskConical, RefreshCcw, LogOut, LayoutDashboard, Users, ClipboardList, ReceiptText, BarChart3, ShieldCheck, IndianRupee, FileText, Settings, History, Search, Check, Receipt, AlertTriangle, ClipboardCheck, Briefcase, Building2, ChevronDown, ChevronRight, Store, Activity, Filter, X } from 'lucide-react'
import type { LucideIcon } from 'lucide-react'
import { useAuth } from '../lib/auth'
import { api } from '../lib/api'
import { useTracking } from '../lib/useTracking'
import { DepartmentSelector } from './ui'

const iconMap: Record<string, LucideIcon> = {
  dashboard: LayoutDashboard,
  lab: FlaskConical,
  users: Users,
  roles: ShieldCheck,
  clients: Building2,
  registrations: ClipboardList,
  billing: ReceiptText,
  reports: BarChart3,
  expenses: IndianRupee,
  purchase_orders: FileText,
  invoices: Receipt,
  due_reports: AlertTriangle,
  final_reports: ClipboardCheck,
  ulr_links: FileText,
  stores: Store,
  workflow_templates: Settings,
  jobs: Briefcase,
  permissions: ShieldCheck,
  documents: FileText,
  audit: History,
  user_tracking: Activity,
  settings: Settings,
  inquiries: ClipboardList,
  quotations: ReceiptText,
  work_orders: FileText,
  dispatches: FileText,
  outsource: FlaskConical,
  departments: Building2,
  vendors: Building2,
  tests: FlaskConical,
  test_categories: FileText,
  test_standards: FileText,
  test_methods: FlaskConical,
  designations: Users,
}

interface NavItem {
  key: string
  label: string
}

interface NavGroup {
  label: string
  icon: LucideIcon
  items: NavItem[]
}

interface AppShellProps {
  groups: NavGroup[]
  activeModule: string
  onModuleChange: (key: string) => void
  children: React.ReactNode
}

interface NotificationItem {
  id: number
  type: string
  title: string
  message: string | null
  data: Record<string, unknown> | null
  read: boolean
  created_at: string | null
  time_ago: string | null
}

export function AppShell({ groups, activeModule, onModuleChange, children }: AppShellProps) {
  const { user, status, logout, refresh, error } = useAuth()
  useTracking()
  const [searchQuery, setSearchQuery] = useState('')
  const [searchResults, setSearchResults] = useState<Array<{ type: string; id: number; uid_no: string; title: string; subtitle: string; mobile: string | null }>>([])
  const [searching, setSearching] = useState(false)
  const [showResults, setShowResults] = useState(false)
  const [showFilters, setShowFilters] = useState(false)
  const [filterStage, setFilterStage] = useState('')
  const [filterDept, setFilterDept] = useState<number | null>(null)
  const [filterDateFrom, setFilterDateFrom] = useState('')
  const [filterDateTo, setFilterDateTo] = useState('')
  const [notifications, setNotifications] = useState<NotificationItem[]>([])
  const [unread, setUnread] = useState(0)
  const [showNotifs, setShowNotifs] = useState(false)
  const [expandedGroups, setExpandedGroups] = useState<Set<string>>(() => {
    const saved = localStorage.getItem('nav_expanded')
    return saved ? new Set(JSON.parse(saved)) : new Set(['Client Registration', 'Lab Reports', 'Billing', 'Groups', 'Setting'])
  })
  const searchRef = useRef<HTMLDivElement>(null)
  const notifRef = useRef<HTMLDivElement>(null)
  const debounceRef = useRef<ReturnType<typeof setTimeout> | null>(null)

  const toggleGroup = (label: string) => {
    setExpandedGroups((prev) => {
      const next = new Set(prev)
      if (next.has(label)) next.delete(label)
      else next.add(label)
      localStorage.setItem('nav_expanded', JSON.stringify([...next]))
      return next
    })
  }

  const loadNotifs = useCallback(async () => {
    try {
      const [nData, uData] = await Promise.all([api.notifications(), api.unreadCount()])
      setNotifications(nData.data)
      setUnread(uData.count)
    } catch {}
  }, [])

  useEffect(() => { void loadNotifs() }, [loadNotifs])

  const doSearch = useCallback(async (q: string) => {
    if (q.length < 2) { setSearchResults([]); setShowResults(false); return }
    setSearching(true)
    try {
      const params = new URLSearchParams({ q })
      if (filterStage) params.set('stage', filterStage)
      if (filterDept) params.set('department_id', String(filterDept))
      if (filterDateFrom) params.set('date_from', filterDateFrom)
      if (filterDateTo) params.set('date_to', filterDateTo)
      const data = await api.search(`${q}?${params.toString()}` as any)
      setSearchResults(data.data)
      setShowResults(true)
    } catch {
      setSearchResults([])
    } finally {
      setSearching(false)
    }
  }, [filterStage, filterDept, filterDateFrom, filterDateTo])

  const handleSearchInput = (value: string) => {
    setSearchQuery(value)
    if (debounceRef.current) clearTimeout(debounceRef.current)
    debounceRef.current = setTimeout(() => void doSearch(value), 300)
  }

  useEffect(() => {
    const handleClick = (e: MouseEvent) => {
      if (searchRef.current && !searchRef.current.contains(e.target as Node)) setShowResults(false)
      if (notifRef.current && !notifRef.current.contains(e.target as Node)) setShowNotifs(false)
    }
    document.addEventListener('mousedown', handleClick)
    return () => document.removeEventListener('mousedown', handleClick)
  }, [])

  const handleMarkRead = async (id: number) => {
    try {
      await api.markNotificationRead(id)
      await loadNotifs()
    } catch {}
  }

  const handleMarkAllRead = async () => {
    try {
      await api.markAllNotificationsRead()
      await loadNotifs()
    } catch {}
  }

  return (
    <main className="app-shell">
      <aside className="sidebar">
        <div className="brand-mark">
          <FlaskConical size={24} />
          <span>NCRC</span>
        </div>

        <nav>
          {/* Dashboard is always at top, outside groups */}
          <button
            className={activeModule === 'dashboard' ? 'active' : ''}
            onClick={() => onModuleChange('dashboard')}
            type="button"
          >
            <LayoutDashboard size={18} />
            Dashboard
          </button>

          {groups.map((group) => {
            const isExpanded = expandedGroups.has(group.label)
            const GroupIcon = group.icon
            return (
              <div key={group.label} className="nav-group">
                <button
                  className="nav-group-header"
                  onClick={() => toggleGroup(group.label)}
                  type="button"
                >
                  <GroupIcon size={16} />
                  <span>{group.label}</span>
                  {isExpanded ? <ChevronDown size={14} /> : <ChevronRight size={14} />}
                </button>
                {isExpanded ? group.items.map((item) => {
                  const Icon = iconMap[item.key] || LayoutDashboard
                  return (
                    <button
                      className={activeModule === item.key ? 'active nav-child' : 'nav-child'}
                      key={item.key}
                      onClick={() => onModuleChange(item.key)}
                      type="button"
                    >
                      <Icon size={16} />
                      {item.label}
                    </button>
                  )
                }) : null}
              </div>
            )
          })}
        </nav>

        <div className="user-block">
          <strong>{user?.name}</strong>
          <span>{user?.is_admin ? 'Administrator' : 'Staff'}</span>
        </div>
      </aside>

      <section className="workspace">
        <header className="topbar">
          <div>
            <p className="section-label">Laboratory Management System</p>
            <h1>{activeModule === 'dashboard' ? 'Dashboard' : groups.flatMap((g) => g.items).find((i) => i.key === activeModule)?.label ?? 'Dashboard'}</h1>
          </div>
          <div className="topbar-actions">
            <div ref={searchRef} style={{ position: 'relative' }}>
              <div style={{ display: 'flex', gap: 6, alignItems: 'center' }}>
                <div className="search-field" style={{ width: 200 }}>
                  <Search size={16} />
                  <input placeholder="Search UID, agency, mobile..." value={searchQuery} onChange={(e) => handleSearchInput(e.target.value)} onFocus={() => { if (searchResults.length > 0) setShowResults(true) }} />
                </div>
                <button className="icon-button" onClick={() => setShowFilters(!showFilters)} type="button" title="Filters" style={{ color: showFilters ? '#195340' : '#65737d' }}>
                  <Filter size={16} />
                </button>
              </div>

              {showFilters ? (
                <div style={{ display: 'flex', gap: 8, padding: '8px 0', flexWrap: 'wrap', alignItems: 'center' }}>
                  <input value={filterStage} onChange={e => setFilterStage(e.target.value)} placeholder="Stage (e.g. testing)" style={{ width: 120, fontSize: '0.78rem', padding: '4px 8px', borderRadius: 4, border: '1px solid #dfe6ea' }} />
                  <div style={{ width: 160 }}><DepartmentSelector value={filterDept} onChange={setFilterDept} placeholder="Dept" /></div>
                  <input type="date" value={filterDateFrom} onChange={e => setFilterDateFrom(e.target.value)} style={{ fontSize: '0.78rem', padding: '4px 8px', borderRadius: 4, border: '1px solid #dfe6ea', width: 130 }} />
                  <input type="date" value={filterDateTo} onChange={e => setFilterDateTo(e.target.value)} style={{ fontSize: '0.78rem', padding: '4px 8px', borderRadius: 4, border: '1px solid #dfe6ea', width: 130 }} />
                  <button className="icon-button" onClick={() => { setFilterStage(''); setFilterDept(null); setFilterDateFrom(''); setFilterDateTo('') }} type="button" title="Clear filters"><X size={14} /></button>
                </div>
              ) : null}

              {showResults ? (
                <div style={{ position: 'absolute', top: '100%', right: 0, marginTop: 4, width: 420, maxHeight: 400, overflowY: 'auto', background: '#fff', border: '1px solid #dfe6ea', borderRadius: 8, boxShadow: '0 8px 24px rgba(0,0,0,0.10)', zIndex: 100 }}>
                  {searching ? <p style={{ padding: 16, color: '#65737d', textAlign: 'center' }}>Searching...</p>
                  : searchResults.length === 0 ? <p style={{ padding: 16, color: '#65737d', textAlign: 'center' }}>No results found.</p>
                  : searchResults.map((r) => (
                    <div key={`${r.type}-${r.id}`} style={{ padding: '10px 14px', borderBottom: '1px solid #e8eef1', cursor: 'pointer' }} onClick={() => { setShowResults(false); setSearchQuery('') }}>
                      <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                        <strong style={{ fontSize: '0.88rem' }}>{r.uid_no}</strong>
                        <span style={{ fontSize: '0.72rem', color: '#65737d', background: '#edf6f4', padding: '2px 8px', borderRadius: 12 }}>{r.type}</span>
                      </div>
                      <div style={{ fontSize: '0.82rem', color: '#4a5b66' }}>{r.title}</div>
                      <div style={{ fontSize: '0.76rem', color: '#65737d' }}>{r.subtitle} {r.mobile ? `| ${r.mobile}` : ''}</div>
                    </div>
                  ))}
                </div>
              ) : null}
            </div>

            <div ref={notifRef} style={{ position: 'relative' }}>
              <button className="icon-button" onClick={() => { void loadNotifs(); setShowNotifs((s) => !s) }} type="button" title="Notifications" style={{ position: 'relative' }}>
                <Bell size={18} />
                {unread > 0 ? (
                  <span style={{ position: 'absolute', top: -2, right: -2, background: '#c44a5a', color: '#fff', fontSize: '0.6rem', fontWeight: 800, borderRadius: '50%', width: 16, height: 16, display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                    {unread > 9 ? '9+' : unread}
                  </span>
                ) : null}
              </button>
              {showNotifs ? (
                <div style={{ position: 'absolute', top: '100%', right: 0, marginTop: 4, width: 360, maxHeight: 420, overflowY: 'auto', background: '#fff', border: '1px solid #dfe6ea', borderRadius: 8, boxShadow: '0 8px 24px rgba(0,0,0,0.10)', zIndex: 100 }}>
                  <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', padding: '10px 14px', borderBottom: '1px solid #e8eef1' }}>
                    <strong style={{ fontSize: '0.88rem' }}>Notifications</strong>
                    {unread > 0 ? <button className="ghost-button" onClick={() => void handleMarkAllRead()} type="button" style={{ fontSize: '0.76rem' }}><Check size={14} /> Mark all read</button> : null}
                  </div>
                  {notifications.length === 0 ? (
                    <p style={{ padding: 24, color: '#65737d', textAlign: 'center' }}>No notifications</p>
                  ) : (
                    notifications.map((n) => (
                      <div
                        key={n.id}
                        onClick={() => { if (!n.read) void handleMarkRead(n.id) }}
                        style={{
                          padding: '10px 14px', borderBottom: '1px solid #e8eef1', cursor: 'pointer',
                          background: n.read ? 'transparent' : '#edf6f4',
                        }}
                      >
                        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                          <strong style={{ fontSize: '0.84rem' }}>{n.title}</strong>
                          <span style={{ fontSize: '0.72rem', color: '#65737d' }}>{n.time_ago}</span>
                        </div>
                        <p style={{ fontSize: '0.78rem', color: '#4a5b66', margin: '4px 0 0' }}>{n.message ?? ''}</p>
                      </div>
                    ))
                  )}
                </div>
              ) : null}
            </div>

            <span className="sync-pill">{status}</span>
            <button className="icon-button" onClick={() => void refresh()} type="button" title="Refresh"><RefreshCcw size={18} /></button>
            <button className="icon-button" onClick={() => void logout()} type="button" title="Sign out"><LogOut size={18} /></button>
          </div>
        </header>

        {error ? <div className="error-banner">{error}</div> : null}

        {children}
      </section>
    </main>
  )
}
