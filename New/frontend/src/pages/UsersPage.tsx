import { useState, type FormEvent } from 'react'
import { Search, UserPlus, UserCog, Trash2 } from 'lucide-react'
import { useAuth } from '../lib/auth'
import { DataTable } from '../components/DataTable'
import type { UserFormData, UserRecord } from '../lib/types'
import { api } from '../lib/api'

const emptyUserForm: UserFormData = {
  username: '',
  email: '',
  password: '',
  password_confirmation: '',
  firstname: '',
  lastname: '',
  phone: '',
  gender: '1',
  group_id: '1',
  is_active: '1',
}

export function UsersPage() {
  const { users: userRecords, roles, refresh, setStatus, error, clearError } = useAuth()
  const [query, setQuery] = useState('')
  const [form, setForm] = useState<UserFormData>(emptyUserForm)
  const [editingId, setEditingId] = useState<number | null>(null)
  const [localError, setLocalError] = useState('')

  const displayError = error || localError

  const filtered = query.trim()
    ? userRecords.filter((r) =>
        [r.name, r.username, r.email, r.group?.group_name ?? '', r.phone]
          .join(' ').toLowerCase().includes(query.trim().toLowerCase()),
      )
    : userRecords

  const beginCreate = () => {
    setEditingId(null)
    setForm({ ...emptyUserForm, group_id: roles[0]?.id ? String(roles[0].id) : '1', is_active: '1' })
    clearError()
    setLocalError('')
    setStatus('Creating user')
  }

  const beginEdit = (record: UserRecord) => {
    setEditingId(record.id)
    setForm({
      username: record.username,
      email: record.email,
      password: '',
      password_confirmation: '',
      firstname: record.firstname,
      lastname: record.lastname ?? '',
      phone: record.phone ?? '',
      gender: String(record.gender ?? 1),
      group_id: String(record.group?.id ?? roles[0]?.id ?? 1),
      is_active: record.is_active ? '1' : '0',
    })
    clearError()
    setLocalError('')
    setStatus('Editing user')
  }

  const handleSubmit = async (event: FormEvent<HTMLFormElement>) => {
    event.preventDefault()
    setLocalError('')
    setStatus(editingId ? 'Updating user' : 'Creating user')

    try {
      const payload = {
        ...form,
        gender: Number(form.gender),
        group_id: Number(form.group_id),
        is_active: form.is_active === '1',
      }

      if (editingId) {
        await api.updateUser(editingId, payload)
      } else {
        await api.createUser(payload)
      }

      setForm({ ...emptyUserForm, group_id: roles[0]?.id ? String(roles[0].id) : '1' })
      setEditingId(null)
      await refresh()
      setStatus(editingId ? 'User updated' : 'User created')
    } catch (formError) {
      setLocalError(formError instanceof Error ? formError.message : 'Unable to save user')
      setStatus('Needs attention')
    }
  }

  const handleDelete = async (record: UserRecord) => {
    if (!window.confirm(`Delete ${record.name || record.username}?`)) return
    setLocalError('')
    setStatus('Removing user')
    try {
      await api.deleteUser(record.id)
      if (editingId === record.id) {
        setForm({ ...emptyUserForm, group_id: roles[0]?.id ? String(roles[0].id) : '1' })
        setEditingId(null)
      }
      await refresh()
      setStatus('User removed')
    } catch (deleteError) {
      setLocalError(deleteError instanceof Error ? deleteError.message : 'Unable to delete user')
      setStatus('Needs attention')
    }
  }

  return (
    <div className="two-column users-layout">
      <section className="surface">
        <div className="surface-heading">
          <div>
            <p className="section-label">Administration</p>
            <h2>User directory</h2>
          </div>
          <label className="search-field">
            <Search size={16} />
            <input value={query} onChange={(e) => setQuery(e.target.value)} placeholder="Search users, email, group" />
          </label>
        </div>

        <div className="user-toolbar">
          <button className="ghost-button" onClick={beginCreate} type="button">
            <UserPlus size={18} />
            New user
          </button>
          <span className="sync-pill">{filtered.length} users</span>
        </div>

        <DataTable
          columns={[
            { key: 'name', label: 'Name' },
            { key: 'username', label: 'Username' },
            { key: 'email', label: 'Email' },
            { key: 'group', label: 'Group' },
            { key: 'is_active', label: 'Active' },
            { key: 'last_login', label: 'Last login' },
            { key: 'actions', label: 'Actions', sortable: false },
          ]}
          rows={filtered.map((record) => ({
            name: <strong>{record.name}</strong>,
            username: record.username,
            email: record.email,
            group: record.group?.group_name ?? 'Unassigned',
            is_active: record.is_active !== false
              ? <span className="badge badge-active">Active</span>
              : <span className="badge badge-inactive">Inactive</span>,
            last_login: record.last_login_at ?? '-',
            actions: <div className="row-actions user-actions">
              <button className="icon-button" onClick={() => beginEdit(record)} type="button" title="Edit user">
                <UserCog size={17} />
              </button>
              <button className="icon-button" onClick={() => void handleDelete(record)} type="button" title="Delete user">
                <Trash2 size={17} />
              </button>
            </div>,
          }))}
        />
      </section>

      <form className="surface user-form" onSubmit={handleSubmit}>
        <div className="surface-heading">
          <div>
            <p className="section-label">{editingId ? 'Update' : 'Create'}</p>
            <h2>{editingId ? 'Edit user' : 'New user'}</h2>
          </div>
          <UserPlus size={20} />
        </div>

        <div className="field-row">
          <label>
            Username
            <input value={form.username} onChange={(e) => setForm((c) => ({ ...c, username: e.target.value }))} />
          </label>
          <label>
            Email
            <input type="email" value={form.email} onChange={(e) => setForm((c) => ({ ...c, email: e.target.value }))} />
          </label>
        </div>

        <div className="field-row">
          <label>
            First name
            <input value={form.firstname} onChange={(e) => setForm((c) => ({ ...c, firstname: e.target.value }))} />
          </label>
          <label>
            Last name
            <input value={form.lastname} onChange={(e) => setForm((c) => ({ ...c, lastname: e.target.value }))} />
          </label>
        </div>

        <div className="field-row">
          <label>
            Phone
            <input value={form.phone} onChange={(e) => setForm((c) => ({ ...c, phone: e.target.value }))} />
          </label>
          <label>
            Gender
            <select value={form.gender} onChange={(e) => setForm((c) => ({ ...c, gender: e.target.value }))}>
              <option value="1">Male</option>
              <option value="2">Female</option>
            </select>
          </label>
        </div>

        <label>
          Role
          <select value={form.group_id} onChange={(e) => setForm((c) => ({ ...c, group_id: e.target.value }))}>
            {roles.length === 0 ? <option value="1">Administrator</option> : null}
            {roles.map((role) => (
              <option key={role.id} value={role.id}>{role.name}</option>
            ))}
          </select>
        </label>

        <label className="checkbox-label">
          <input
            type="checkbox"
            checked={form.is_active === '1'}
            onChange={(e) => setForm((c) => ({ ...c, is_active: e.target.checked ? '1' : '0' }))}
          />
          Active
        </label>

        <div className="field-row">
          <label>
            Password
            <input
              type="password"
              value={form.password}
              onChange={(e) => setForm((c) => ({ ...c, password: e.target.value }))}
              placeholder={editingId ? 'Leave blank to keep existing password' : 'Enter password'}
            />
          </label>
          <label>
            Confirm password
            <input
              type="password"
              value={form.password_confirmation}
              onChange={(e) => setForm((c) => ({ ...c, password_confirmation: e.target.value }))}
            />
          </label>
        </div>

        {displayError ? <div className="error-banner">{displayError}</div> : null}

        <div className="form-actions">
          {editingId ? (
            <button
              className="ghost-button"
              onClick={() => { setEditingId(null); setForm({ ...emptyUserForm, group_id: roles[0]?.id ? String(roles[0].id) : '1' }) }}
              type="button"
            >
              Cancel
            </button>
          ) : null}
          <button type="submit">{editingId ? 'Update user' : 'Create user'}</button>
        </div>
      </form>
    </div>
  )
}
