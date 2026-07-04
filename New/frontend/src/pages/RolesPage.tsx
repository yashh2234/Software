import { useState, type FormEvent } from 'react'
import { ShieldCheck, Plus, Trash2, Edit3 } from 'lucide-react'
import { useAuth } from '../lib/auth'
import { request } from '../lib/api'
import type { RoleSummary } from '../lib/types'

const AVAILABLE_PERMISSIONS = [
  'createUser', 'updateUser', 'viewUser', 'deleteUser',
  'createGroup', 'updateGroup', 'viewGroup', 'deleteGroup',
  'createBilling', 'updateBilling', 'viewBilling', 'deleteBilling',
  'createRegistration', 'updateRegistration', 'viewRegistration', 'deleteRegistration',
  'createOrder', 'updateOrder', 'viewOrder', 'deleteOrder',
  'viewReports', 'updateCompany', 'viewProfile', 'updateSetting',
]

export function RolesPage() {
  const { roles, refresh, setStatus } = useAuth()
  const [editingRole, setEditingRole] = useState<RoleSummary | null>(null)
  const [name, setName] = useState('')
  const [selectedPermissions, setSelectedPermissions] = useState<string[]>([])
  const [localError, setLocalError] = useState('')
  const [showForm, setShowForm] = useState(false)

  const beginCreate = () => {
    setEditingRole(null)
    setName('')
    setSelectedPermissions([])
    setLocalError('')
    setShowForm(true)
    setStatus('Creating role')
  }

  const beginEdit = (role: RoleSummary) => {
    setEditingRole(role)
    setName(role.name)
    setSelectedPermissions([...role.permissions])
    setLocalError('')
    setShowForm(true)
    setStatus('Editing role')
  }

  const togglePermission = (perm: string) => {
    setSelectedPermissions((prev) =>
      prev.includes(perm) ? prev.filter((p) => p !== perm) : [...prev, perm],
    )
  }

  const handleSubmit = async (event: FormEvent<HTMLFormElement>) => {
    event.preventDefault()
    setLocalError('')
    setStatus(editingRole ? 'Updating role' : 'Creating role')

    try {
      const payload = { group_name: name, permissions: selectedPermissions }

      if (editingRole) {
        await request(`/roles/${editingRole.id}`, {
          method: 'PUT',
          body: JSON.stringify(payload),
        })
      } else {
        await request('/roles', {
          method: 'POST',
          body: JSON.stringify(payload),
        })
      }

      setShowForm(false)
      setEditingRole(null)
      await refresh()
      setStatus(editingRole ? 'Role updated' : 'Role created')
    } catch (err) {
      setLocalError(err instanceof Error ? err.message : 'Unable to save role')
      setStatus('Needs attention')
    }
  }

  const handleDelete = async (role: RoleSummary) => {
    if (role.id === 1) {
      setLocalError('Cannot delete the Administrator role.')
      return
    }
    if (!window.confirm(`Delete role "${role.name}"?`)) return
    setLocalError('')
    setStatus('Deleting role')
    try {
      await request(`/roles/${role.id}`, { method: 'DELETE' })
      await refresh()
      setStatus('Role deleted')
    } catch (err) {
      setLocalError(err instanceof Error ? err.message : 'Unable to delete role')
      setStatus('Needs attention')
    }
  }

  return (
    <div className="two-column users-layout">
      <section className="surface">
        <div className="surface-heading">
          <div>
            <p className="section-label">Access control</p>
            <h2>Roles & permissions</h2>
          </div>
        </div>

        <div className="user-toolbar">
          <button className="ghost-button" onClick={beginCreate} type="button">
            <Plus size={18} />
            New role
          </button>
          <span className="sync-pill">{roles.length} roles</span>
        </div>

        {localError ? <div className="error-banner">{localError}</div> : null}

        <div className="role-grid">
          {roles.map((role) => (
            <article className="role-card" key={role.id}>
              <div className="surface-heading" style={{ marginBottom: 0 }}>
                <strong>{role.name}</strong>
                <div className="row-actions">
                  <button className="icon-button" onClick={() => beginEdit(role)} type="button" title="Edit role">
                    <Edit3 size={16} />
                  </button>
                  {role.id !== 1 ? (
                    <button className="icon-button" onClick={() => void handleDelete(role)} type="button" title="Delete role">
                      <Trash2 size={16} />
                    </button>
                  ) : null}
                </div>
              </div>
              <span>{role.users_count} users</span>
              <small>{role.permissions_count} permissions</small>
              <div style={{ display: 'flex', flexWrap: 'wrap', gap: 4, marginTop: 8 }}>
                {role.permissions.slice(0, 6).map((perm) => (
                  <span key={perm} className="sync-pill" style={{ fontSize: '0.7rem', minHeight: 24, padding: '0 8px' }}>
                    {perm}
                  </span>
                ))}
                {role.permissions.length > 6 ? <span className="sync-pill" style={{ fontSize: '0.7rem', minHeight: 24, padding: '0 8px' }}>+{role.permissions.length - 6}</span> : null}
              </div>
            </article>
          ))}
        </div>
      </section>

      {showForm ? (
        <form className="surface user-form" onSubmit={handleSubmit}>
          <div className="surface-heading">
            <div>
              <p className="section-label">{editingRole ? 'Update' : 'Create'}</p>
              <h2>{editingRole ? 'Edit role' : 'New role'}</h2>
            </div>
            <ShieldCheck size={20} />
          </div>

          <label>
            Role name
            <input value={name} onChange={(e) => setName(e.target.value)} placeholder="e.g. Lab Technician" />
          </label>

          <div>
            <p style={{ color: '#4a5b66', fontSize: '0.9rem', fontWeight: 700, marginBottom: 8 }}>Permissions</p>
            <div style={{ display: 'grid', gridTemplateColumns: 'repeat(2, 1fr)', gap: 6 }}>
              {AVAILABLE_PERMISSIONS.map((perm) => (
                <label key={perm} style={{
                  display: 'flex', alignItems: 'center', gap: 8, fontSize: '0.82rem',
                  fontWeight: 500, cursor: 'pointer', padding: '6px 8px', borderRadius: 6,
                  border: '1px solid #e8eef1', background: selectedPermissions.includes(perm) ? '#edf6f4' : '#fbfcfd',
                }}>
                  <input
                    type="checkbox"
                    checked={selectedPermissions.includes(perm)}
                    onChange={() => togglePermission(perm)}
                    style={{ width: 'auto', minHeight: 'auto' }}
                  />
                  {perm.replace(/([a-z])([A-Z])/g, '$1 $2')}
                </label>
              ))}
            </div>
          </div>

          <div className="form-actions">
            <button className="ghost-button" onClick={() => { setShowForm(false); setEditingRole(null) }} type="button">
              Cancel
            </button>
            <button type="submit">{editingRole ? 'Update role' : 'Create role'}</button>
          </div>
        </form>
      ) : null}
    </div>
  )
}
