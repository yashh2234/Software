import { useState, useEffect, type FormEvent } from 'react'
import { ShieldCheck, Check, X, Users, Loader } from 'lucide-react'
import { request } from '../lib/api'
import type { RoleSummary } from '../lib/types'

interface PermissionGroup {
  module: string
  permissions: Array<{ id: number; name: string; action: string; description: string }>
}

export function PermissionsPage() {
  const [groups, setGroups] = useState<PermissionGroup[]>([])
  const [roles, setRoles] = useState<RoleSummary[]>([])
  const [selectedRole, setSelectedRole] = useState<RoleSummary | null>(null)
  const [rolePerms, setRolePerms] = useState<Record<number, boolean>>({})
  const [loading, setLoading] = useState(true)
  const [saving, setSaving] = useState(false)
  const [error, setError] = useState('')
  const [success, setSuccess] = useState('')
  const [showUserAssign, setShowUserAssign] = useState(false)
  const [users, setUsers] = useState<Array<{ id: number; name: string }>>([])
  const [selectedUserId, setSelectedUserId] = useState<number | null>(null)

  useEffect(() => { loadData() }, [])

  const loadData = async () => {
    setLoading(true)
    try {
      const [permsData, rolesData, usersData] = await Promise.all([
        request<PermissionGroup[]>('/permissions'),
        request<{ data: RoleSummary[] }>('/roles'),
        request<{ data: Array<{ id: number; name: string }> }>('/users'),
      ])
      setGroups(permsData)
      setRoles(rolesData.data)
      setUsers(usersData.data)
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Failed to load data')
    } finally { setLoading(false) }
  }

  const loadRolePermissions = async (role: RoleSummary) => {
    setSelectedRole(role)
    setError('')
    try {
      const data = await request<{ role: RoleSummary; permissions: Array<{ id: number; name: string; assigned: boolean }> }>(`/permissions/roles/${role.id}`)
      const permMap: Record<number, boolean> = {}
      data.permissions.forEach((p) => { permMap[p.id] = p.assigned })
      setRolePerms(permMap)
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Failed to load role permissions')
    }
  }

  const togglePermission = (permId: number) => {
    setRolePerms((prev) => ({ ...prev, [permId]: !prev[permId] }))
  }

  const selectAllInModule = (modulePerms: Array<{ id: number }>, value: boolean) => {
    const newPerms = { ...rolePerms }
    modulePerms.forEach((p) => { newPerms[p.id] = value })
    setRolePerms(newPerms)
  }

  const handleSave = async (e: FormEvent) => {
    e.preventDefault()
    if (!selectedRole) return
    setSaving(true)
    setError('')
    setSuccess('')
    try {
      const permNames = groups.flatMap((g) =>
        g.permissions.filter((p) => rolePerms[p.id]).map((p) => p.name)
      )
      await request(`/permissions/roles/${selectedRole.id}/sync`, {
        method: 'POST',
        body: JSON.stringify({ permissions: permNames }),
      })
      setSuccess(`Permissions saved for "${selectedRole.name}"`)
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Failed to save permissions')
    } finally { setSaving(false) }
  }

  const handleSeed = async () => {
    try {
      await request('/permissions/seed', { method: 'POST' })
      await loadData()
      setSuccess('Default permissions seeded')
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Failed to seed')
    }
  }

  const handleUserAssign = async () => {
    if (!selectedUserId) return
    try {
      const permNames = groups.flatMap((g) =>
        g.permissions.filter((p) => rolePerms[p.id]).map((p) => p.name)
      )
      await request('/permissions/users/assign', {
        method: 'POST',
        body: JSON.stringify({ user_id: selectedUserId, permissions: permNames }),
      })
      setSuccess('Direct permissions assigned to user')
      setShowUserAssign(false)
    } catch (err) {
      setError(err instanceof Error ? err.message : 'Failed to assign')
    }
  }

  const assignedCount = Object.values(rolePerms).filter(Boolean).length

  return (
    <div className="two-column" style={{ height: 'calc(100vh - 64px)' }}>
      {/* Left: Role list */}
      <section className="surface" style={{ overflow: 'auto' }}>
        <div className="surface-heading">
          <div>
            <p className="section-label">Access Control</p>
            <h2>Roles</h2>
          </div>
          <ShieldCheck size={20} />
        </div>

        <div className="user-toolbar">
          <button className="ghost-button" onClick={() => void handleSeed()} type="button">Seed Defaults</button>
          <span className="sync-pill">{roles.length} roles</span>
        </div>

        {error ? <div className="error-banner">{error}</div> : null}
        {success ? <div className="success-banner">{success}</div> : null}

        {loading ? <p style={{ padding: 24, textAlign: 'center', color: '#65737d' }}>Loading...</p> : (
          <div style={{ display: 'flex', flexDirection: 'column', gap: 6 }}>
            {roles.map((role) => {
              const isSelected = selectedRole?.id === role.id
              return (
                <div
                  key={role.id}
                  onClick={() => void loadRolePermissions(role)}
                  className="role-card"
                  style={{ cursor: 'pointer', border: isSelected ? '2px solid #138a6b' : '1px solid #e8eef1' }}
                >
                  <div className="surface-heading" style={{ marginBottom: 0 }}>
                    <strong>{role.name}</strong>
                  </div>
                  <small style={{ color: '#65737d' }}>{role.users_count} users | {role.permissions_count} perms</small>
                </div>
              )
            })}
          </div>
        )}

        <div style={{ marginTop: 16 }}>
          <button className="ghost-button" onClick={() => { setShowUserAssign(true) }} type="button" style={{ width: '100%' }}>
            <Users size={16} /> Assign to User
          </button>
        </div>
      </section>

      {/* Right: Permission matrix */}
      <section className="surface" style={{ overflow: 'auto' }}>
        {!selectedRole ? (
          <div style={{ padding: 48, textAlign: 'center', color: '#65737d' }}>
            <ShieldCheck size={48} style={{ opacity: 0.3, marginBottom: 12 }} />
            <p>Select a role to manage its permissions</p>
          </div>
        ) : (
          <form onSubmit={handleSave}>
            <div className="surface-heading">
              <div>
                <p className="section-label">{selectedRole.name}</p>
                <h2>Permissions ({assignedCount})</h2>
              </div>
              <div className="row-actions">
                <button type="submit" className="ghost-button" disabled={saving}>
                  {saving ? <Loader size={14} /> : <Check size={14} />}
                  {saving ? 'Saving...' : 'Save'}
                </button>
              </div>
            </div>

            {groups.length === 0 ? (
              <p style={{ padding: 24, color: '#65737d', textAlign: 'center' }}>
                No permissions defined. Click "Seed Defaults" to populate.
              </p>
            ) : (
              <div style={{ display: 'flex', flexDirection: 'column', gap: 16 }}>
                {groups.map((group) => {
                  const groupAssigned = group.permissions.filter((p) => rolePerms[p.id]).length
                  const total = group.permissions.length
                  return (
                    <div key={group.module} style={{ border: '1px solid #e8eef1', borderRadius: 8, overflow: 'hidden' }}>
                      <div className="surface-heading" style={{ background: '#f9fafb', margin: 0, padding: '8px 14px' }}>
                        <strong style={{ fontSize: '0.85rem' }}>{group.module}</strong>
                        <div style={{ display: 'flex', gap: 4 }}>
                          <button type="button" className="icon-button" onClick={() => selectAllInModule(group.permissions, true)} title="Select all" style={{ width: 30, minWidth: 30, minHeight: 30, fontSize: '0.7rem' }}>
                            All
                          </button>
                          <button type="button" className="icon-button" onClick={() => selectAllInModule(group.permissions, false)} title="Deselect all" style={{ width: 30, minWidth: 30, minHeight: 30, fontSize: '0.7rem' }}>
                            None
                          </button>
                          <span className="sync-pill" style={{ fontSize: '0.72rem' }}>{groupAssigned}/{total}</span>
                        </div>
                      </div>
                      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(200px, 1fr))', gap: 4, padding: '8px 14px' }}>
                        {group.permissions.map((perm) => (
                          <label
                            key={perm.id}
                            style={{
                              display: 'flex', alignItems: 'center', gap: 6, cursor: 'pointer',
                              padding: '4px 8px', borderRadius: 6, fontSize: '0.80rem',
                              background: rolePerms[perm.id] ? '#edf6f4' : 'transparent',
                              border: '1px solid', borderColor: rolePerms[perm.id] ? '#c3e4d8' : 'transparent',
                            }}
                            title={perm.description}
                          >
                            <input
                              type="checkbox"
                              checked={!!rolePerms[perm.id]}
                              onChange={() => togglePermission(perm.id)}
                              style={{ width: 'auto', minHeight: 'auto' }}
                            />
                            <span>{perm.action ? perm.action.replace(/_/g, ' ') : perm.name}</span>
                          </label>
                        ))}
                      </div>
                    </div>
                  )
                })}
              </div>
            )}

            <div className="form-actions" style={{ marginTop: 16 }}>
              <button type="submit" className="ghost-button" disabled={saving}>
                {saving ? 'Saving...' : 'Save Permissions'}
              </button>
            </div>
          </form>
        )}
      </section>

      {/* User assign modal */}
      {showUserAssign ? (
        <div className="modal-overlay" onClick={() => setShowUserAssign(false)}>
          <div className="surface" style={{ width: 400 }} onClick={(e) => e.stopPropagation()}>
            <div className="surface-heading">
              <h2>Assign Direct Permissions</h2>
              <button className="icon-button" onClick={() => setShowUserAssign(false)} type="button"><X size={18} /></button>
            </div>
            <label>
              Select User
              <select value={selectedUserId ?? ''} onChange={(e) => setSelectedUserId(e.target.value ? Number(e.target.value) : null)} style={{ width: '100%' }}>
                <option value="">Choose user...</option>
                {users.map((u) => <option key={u.id} value={u.id}>{u.name}</option>)}
              </select>
            </label>
            <p style={{ fontSize: '0.78rem', color: '#65737d', margin: '8px 0' }}>
              This will assign the currently selected permission set directly to the user.
            </p>
            <div className="form-actions">
              <button className="ghost-button" onClick={() => setShowUserAssign(false)} type="button">Cancel</button>
              <button onClick={() => void handleUserAssign()} type="button" disabled={!selectedUserId}>Assign</button>
            </div>
          </div>
        </div>
      ) : null}
    </div>
  )
}
