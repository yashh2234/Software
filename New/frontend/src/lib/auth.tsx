import { createContext, useCallback, useContext, useEffect, useState } from 'react'
import type { ReactNode } from 'react'
import type { LoginSession, User } from './types'
import { api, getToken, setToken } from './api'
import type { BillingItem, DashboardResponse, Registration, RoleSummary, UserRecord } from './types'

interface AuthState {
  token: string | null
  user: User | null
  loading: boolean
  error: string
  status: string
  dashboard: DashboardResponse | null
  roles: RoleSummary[]
  users: UserRecord[]
  registrations: Registration[]
  billingDue: BillingItem[]
  sessions: LoginSession[]
  login: (email: string, password: string) => Promise<void>
  logout: () => Promise<void>
  refresh: () => Promise<void>
  clearError: () => void
  setStatus: (status: string) => void
}

const AuthContext = createContext<AuthState | null>(null)

export function AuthProvider({ children }: { children: ReactNode }) {
  const [token, setTokenState] = useState<string | null>(getToken())
  const [user, setUser] = useState<User | null>(null)
  const [loading, setLoading] = useState(true)
  const [error, setError] = useState('')
  const [status, setStatus] = useState('Ready')
  const [dashboard, setDashboard] = useState<DashboardResponse | null>(null)
  const [roles, setRoles] = useState<RoleSummary[]>([])
  const [users, setUsers] = useState<UserRecord[]>([])
  const [registrations, setRegistrations] = useState<Registration[]>([])
  const [billingDue, setBillingDue] = useState<BillingItem[]>([])
  const [sessions, setSessions] = useState<LoginSession[]>([])

  const loadWorkspace = useCallback(async () => {
    if (!token) {
      setLoading(false)
      return
    }

    setStatus('Syncing')
    try {
      const [me, summary, rolePayload, userPayload, registrationPayload, billingPayload, sessionPayload] =
        await Promise.all([
          api.me(),
          api.dashboardSummary(),
          api.roles(),
          api.users(),
          api.registrations(),
          api.billingDue(),
          api.sessions(),
        ])

      setUser(me.user)
      setDashboard(summary)
      setRoles(rolePayload.data ?? [])
      setUsers(userPayload.data ?? [])
      setRegistrations(registrationPayload.data ?? [])
      setBillingDue(billingPayload.data ?? [])
      setSessions(sessionPayload.data ?? [])
      setStatus('Synced')
      setError('')
    } catch (workspaceError) {
      const message = workspaceError instanceof Error ? workspaceError.message : 'Unable to load workspace'
      setError(message)
      setStatus('Workspace error')
      if (message.toLowerCase().includes('unauthenticated') || message.toLowerCase().includes('unauthorized')) {
        setToken(null)
        setTokenState(null)
        setUser(null)
        setDashboard(null)
        setRoles([])
        setUsers([])
        setRegistrations([])
        setBillingDue([])
        setSessions([])
        setStatus('Signed out')
      }
    } finally {
      setLoading(false)
    }
  }, [token])

  useEffect(() => {
    void loadWorkspace()
  }, [loadWorkspace])

  const login = useCallback(async (email: string, password: string) => {
    setError('')
    setStatus('Signing in')
    try {
      const payload = await api.login(email, password)
      setToken(payload.token)
      setTokenState(payload.token)
      setUser(payload.user)
      setStatus('Signed in')
    } catch (loginError) {
      const message = loginError instanceof Error ? loginError.message : 'Unable to sign in'
      setError(message)
      setStatus('Ready')
      throw loginError
    }
  }, [])

  const logout = useCallback(async () => {
    if (token) {
      await api.logout().catch(() => null)
    }
    setToken(null)
    setTokenState(null)
    setUser(null)
    setDashboard(null)
    setUsers([])
    setRegistrations([])
    setBillingDue([])
    setSessions([])
    setStatus('Signed out')
    setError('')
  }, [token])

  const clearError = useCallback(() => setError(''), [])

  return (
    <AuthContext.Provider
      value={{
        token,
        user,
        loading,
        error,
        status,
        dashboard,
        roles,
        users,
        registrations,
        billingDue,
        sessions,
        login,
        logout,
        refresh: loadWorkspace,
        clearError,
        setStatus,
      }}
    >
      {children}
    </AuthContext.Provider>
  )
}

export function useAuth(): AuthState {
  const ctx = useContext(AuthContext)
  if (!ctx) throw new Error('useAuth must be used within AuthProvider')
  return ctx
}
