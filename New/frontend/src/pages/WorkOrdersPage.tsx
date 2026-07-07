import { useEffect, useState } from 'react';

type WorkOrder = {
  id: number;
  work_order_no: string;
  inquiry_id: number | null;
  quotation_id: number | null;
  registration_id: number | null;
  client_name: string;
  agency_name: string | null;
  contact_person: string | null;
  mobile_no: string | null;
  scope_of_work: string | null;
  total_amount: number;
  advance_payment: number;
  balance_dues: number;
  payment_terms: string | null;
  status: string;
  assignment_type: string;
  due_date: string | null;
  notes: string | null;
  created_at: string;
  outsource_assignments?: any[];
};

const STATUS_COLORS: Record<string, string> = {
  draft: '#9e9e9e', active: '#2196f3', in_progress: '#ff9800', completed: '#4caf50', cancelled: '#f44336',
};

export default function WorkOrdersPage() {
  const [workOrders, setWorkOrders] = useState<WorkOrder[]>([]);
  const [loading, setLoading] = useState(true);
  const [showModal, setShowModal] = useState(false);
  const [editing, setEditing] = useState<WorkOrder | null>(null);
  const [statusFilter, setStatusFilter] = useState('');
  const [typeFilter, setTypeFilter] = useState('');
  const [search, setSearch] = useState('');
  const [form, setForm] = useState({
    client_name: '', agency_name: '', contact_person: '', mobile_no: '',
    scope_of_work: '', total_amount: 0, advance_payment: 0, payment_terms: '',
    assignment_type: 'inhouse', due_date: '', notes: '',
    inquiry_id: null as number | null, quotation_id: null as number | null,
    registration_id: null as number | null,
  });

  const fetchWorkOrders = async () => {
    setLoading(true);
    const params = new URLSearchParams();
    if (statusFilter) params.set('status', statusFilter);
    if (typeFilter) params.set('assignment_type', typeFilter);
    if (search) params.set('search', search);
    const res = await fetch(`/api/work-orders?${params}`);
    const data = await res.json();
    setWorkOrders(data.data || []);
    setLoading(false);
  };

  useEffect(() => { fetchWorkOrders(); }, [statusFilter, typeFilter, search]);

  const openCreate = () => {
    setEditing(null);
    setForm({
      client_name: '', agency_name: '', contact_person: '', mobile_no: '',
      scope_of_work: '', total_amount: 0, advance_payment: 0, payment_terms: '',
      assignment_type: 'inhouse', due_date: '', notes: '',
      inquiry_id: null, quotation_id: null, registration_id: null,
    });
    setShowModal(true);
  };

  const openEdit = (wo: WorkOrder) => {
    setEditing(wo);
    setForm({
      client_name: wo.client_name, agency_name: wo.agency_name || '',
      contact_person: wo.contact_person || '', mobile_no: wo.mobile_no || '',
      scope_of_work: wo.scope_of_work || '', total_amount: wo.total_amount,
      advance_payment: wo.advance_payment, payment_terms: wo.payment_terms || '',
      assignment_type: wo.assignment_type, due_date: wo.due_date || '', notes: wo.notes || '',
      inquiry_id: wo.inquiry_id, quotation_id: wo.quotation_id, registration_id: wo.registration_id,
    });
    setShowModal(true);
  };

  const handleSave = async () => {
    const method = editing ? 'PUT' : 'POST';
    const url = editing ? `/api/work-orders/${editing.id}` : '/api/work-orders';
    await fetch(url, {
      method, headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(form),
    });
    setShowModal(false);
    fetchWorkOrders();
  };

  const handleDelete = async (id: number) => {
    if (!confirm('Delete this work order?')) return;
    await fetch(`/api/work-orders/${id}`, { method: 'DELETE' });
    fetchWorkOrders();
  };

  const handleStatusChange = async (id: number, status: string) => {
    await fetch(`/api/work-orders/${id}`, {
      method: 'PUT', headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ status }),
    });
    fetchWorkOrders();
  };

  return (
    <div className="page-container">
      <div className="page-header">
        <h1>Work Orders</h1>
        <button className="btn btn-primary" onClick={openCreate}>+ New Work Order</button>
      </div>

      <div className="filters-bar">
        <input type="text" className="form-input" placeholder="Search work orders..." value={search}
          onChange={(e) => setSearch(e.target.value)} style={{ flex: 1 }} />
        <select className="form-input" value={statusFilter} onChange={(e) => setStatusFilter(e.target.value)}>
          <option value="">All Status</option>
          <option value="draft">Draft</option>
          <option value="active">Active</option>
          <option value="in_progress">In Progress</option>
          <option value="completed">Completed</option>
          <option value="cancelled">Cancelled</option>
        </select>
        <select className="form-input" value={typeFilter} onChange={(e) => setTypeFilter(e.target.value)}>
          <option value="">All Types</option>
          <option value="inhouse">Inhouse</option>
          <option value="outsource">Outsource</option>
        </select>
      </div>

      <div className="table-container">
        <table className="data-table">
          <thead>
            <tr>
              <th>WO No</th>
              <th>Client</th>
              <th>Type</th>
              <th>Amount</th>
              <th>Balance</th>
              <th>Status</th>
              <th>Due Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            {loading ? (
              <tr><td colSpan={8}>Loading...</td></tr>
            ) : workOrders.length === 0 ? (
              <tr><td colSpan={8}>No work orders found</td></tr>
            ) : workOrders.map((wo) => (
              <tr key={wo.id}>
                <td><strong>{wo.work_order_no}</strong></td>
                <td>{wo.client_name}</td>
                <td>
                  <span className="badge" style={{
                    backgroundColor: wo.assignment_type === 'outsource' ? '#ff9800' : '#2196f3',
                    color: '#fff',
                  }}>
                    {wo.assignment_type}
                  </span>
                </td>
                <td>₹{Number(wo.total_amount).toLocaleString()}</td>
                <td>₹{Number(wo.balance_dues).toLocaleString()}</td>
                <td>
                  <span className="badge" style={{ backgroundColor: STATUS_COLORS[wo.status] || '#999', color: '#fff' }}>
                    {wo.status}
                  </span>
                </td>
                <td>{wo.due_date || '-'}</td>
                <td>
                  <button className="btn btn-sm" onClick={() => openEdit(wo)}>Edit</button>
                  <button className="btn btn-sm btn-danger" onClick={() => handleDelete(wo.id)}>Del</button>
                  {wo.status === 'draft' && (
                    <button className="btn btn-sm" style={{ backgroundColor: '#2196f3', color: '#fff' }}
                      onClick={() => handleStatusChange(wo.id, 'active')}>Activate</button>
                  )}
                  {wo.status === 'active' && (
                    <button className="btn btn-sm" style={{ backgroundColor: '#ff9800', color: '#fff' }}
                      onClick={() => handleStatusChange(wo.id, 'in_progress')}>Start</button>
                  )}
                  {wo.status === 'in_progress' && (
                    <button className="btn btn-sm" style={{ backgroundColor: '#4caf50', color: '#fff' }}
                      onClick={() => handleStatusChange(wo.id, 'completed')}>Complete</button>
                  )}
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>

      {showModal && (
        <div className="modal-overlay" onClick={() => setShowModal(false)}>
          <div className="modal-content" onClick={(e) => e.stopPropagation()}>
            <h2>{editing ? 'Edit Work Order' : 'New Work Order'}</h2>
            <div className="form-grid">
              <div className="form-group">
                <label>Client Name *</label>
                <input className="form-input" value={form.client_name}
                  onChange={(e) => setForm({ ...form, client_name: e.target.value })} />
              </div>
              <div className="form-group">
                <label>Agency Name</label>
                <input className="form-input" value={form.agency_name}
                  onChange={(e) => setForm({ ...form, agency_name: e.target.value })} />
              </div>
              <div className="form-group">
                <label>Contact Person</label>
                <input className="form-input" value={form.contact_person}
                  onChange={(e) => setForm({ ...form, contact_person: e.target.value })} />
              </div>
              <div className="form-group">
                <label>Mobile No</label>
                <input className="form-input" value={form.mobile_no}
                  onChange={(e) => setForm({ ...form, mobile_no: e.target.value })} />
              </div>
              <div className="form-group">
                <label>Assignment Type *</label>
                <select className="form-input" value={form.assignment_type}
                  onChange={(e) => setForm({ ...form, assignment_type: e.target.value })}>
                  <option value="inhouse">Inhouse</option>
                  <option value="outsource">Outsource</option>
                </select>
              </div>
              <div className="form-group">
                <label>Due Date</label>
                <input className="form-input" type="date" value={form.due_date}
                  onChange={(e) => setForm({ ...form, due_date: e.target.value })} />
              </div>
              <div className="form-group">
                <label>Total Amount</label>
                <input className="form-input" type="number" value={form.total_amount}
                  onChange={(e) => setForm({ ...form, total_amount: parseFloat(e.target.value) || 0 })} />
              </div>
              <div className="form-group">
                <label>Advance Payment</label>
                <input className="form-input" type="number" value={form.advance_payment}
                  onChange={(e) => setForm({ ...form, advance_payment: parseFloat(e.target.value) || 0 })} />
              </div>
              <div className="form-group">
                <label>Payment Terms</label>
                <input className="form-input" value={form.payment_terms}
                  onChange={(e) => setForm({ ...form, payment_terms: e.target.value })} />
              </div>
              <div className="form-group" style={{ gridColumn: '1 / -1' }}>
                <label>Scope of Work</label>
                <textarea className="form-input" rows={3} value={form.scope_of_work}
                  onChange={(e) => setForm({ ...form, scope_of_work: e.target.value })} />
              </div>
              <div className="form-group" style={{ gridColumn: '1 / -1' }}>
                <label>Notes</label>
                <textarea className="form-input" rows={2} value={form.notes}
                  onChange={(e) => setForm({ ...form, notes: e.target.value })} />
              </div>
            </div>
            <div className="modal-actions">
              <button className="btn" onClick={() => setShowModal(false)}>Cancel</button>
              <button className="btn btn-primary" onClick={handleSave}>
                {editing ? 'Update' : 'Create'}
              </button>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}
