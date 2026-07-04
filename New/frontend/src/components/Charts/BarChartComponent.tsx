import { BarChart, Bar, XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer } from 'recharts'

interface Props {
  data: Array<{ month: string; count: number }>
  color: string
}

export function BarChartComponent({ data, color }: Props) {
  return (
    <ResponsiveContainer width="100%" height={240}>
      <BarChart data={data} margin={{ top: 8, right: 8, left: -16, bottom: 0 }}>
        <CartesianGrid strokeDasharray="3 3" stroke="#e8eef1" />
        <XAxis dataKey="month" tick={{ fontSize: 11, fill: '#65737d' }} />
        <YAxis tick={{ fontSize: 11, fill: '#65737d' }} allowDecimals={false} />
        <Tooltip contentStyle={{ borderRadius: 8, border: '1px solid #dfe6ea', fontSize: 13 }} labelStyle={{ fontWeight: 700 }} />
        <Bar dataKey="count" fill={color} radius={[4, 4, 0, 0]} maxBarSize={48} />
      </BarChart>
    </ResponsiveContainer>
  )
}
