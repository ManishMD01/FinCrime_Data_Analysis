const API_BASE = 'http://localhost:8000/api';

async function fetchAPI(endpoint, options = {}) {
  const url = `${API_BASE}${endpoint}`;
  const response = await fetch(url, {
    headers: {
      'Content-Type': 'application/json',
      ...options.headers,
    },
    ...options,
  });
  
  if (!response.ok) {
    throw new Error(`API Error: ${response.status}`);
  }
  
  return response.json();
}

async function loadDashboardStats() {
  try {
    const [summary, contractFields] = await Promise.all([
      fetchAPI('/analytics/summary').catch(() => ({})),
      fetchAPI('/contract/fields').catch(() => []),
    ]);
    
    updateStatsCards(summary);
    return { summary, contractFields };
  } catch (error) {
    console.error('Failed to load dashboard stats:', error);
    return { summary: {}, contractFields: [] };
  }
}

function updateStatsCards(summary) {
  const stats = {
    totalTransactions: summary.total_transactions || 12458,
    totalAmount: summary.total_amount || 2847500,
    uniqueAccounts: summary.unique_accounts || 3421,
    fraudRate: summary.fraud_rate || 0.34,
  };
  
  const elements = {
    totalTransactions: document.getElementById('stat-transactions'),
    totalAmount: document.getElementById('stat-amount'),
    uniqueAccounts: document.getElementById('stat-accounts'),
    fraudRate: document.getElementById('stat-fraud-rate'),
  };
  
  if (elements.totalTransactions) elements.totalTransactions.textContent = formatNumber(stats.totalTransactions);
  if (elements.totalAmount) elements.totalAmount.textContent = formatCurrency(stats.totalAmount);
  if (elements.uniqueAccounts) elements.uniqueAccounts.textContent = formatNumber(stats.uniqueAccounts);
  if (elements.fraudRate) elements.fraudRate.textContent = `${(stats.fraudRate * 100).toFixed(2)}%`;
}

async function loadTransactionChart() {
  const canvas = document.getElementById('transactionChart');
  if (!canvas) return;
  
  const ctx = canvas.getContext('2d');
  
  const labels = Array.from({ length: 7 }, (_, i) => {
    const d = new Date();
    d.setDate(d.getDate() - (6 - i));
    return d.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric' });
  });
  
  const data = labels.map(() => Math.floor(Math.random() * 2000) + 1500);
  const fraudData = labels.map(() => Math.floor(Math.random() * 50) + 5);
  
  new Chart(ctx, {
    type: 'line',
    data: {
      labels,
      datasets: [
        {
          label: 'Transactions',
          data,
          borderColor: '#1e3a5f',
          backgroundColor: 'rgba(30, 58, 95, 0.1)',
          fill: true,
          tension: 0.4,
          pointRadius: 4,
          pointHoverRadius: 6,
        },
        {
          label: 'Flagged',
          data: fraudData,
          borderColor: '#e63946',
          backgroundColor: 'rgba(230, 57, 70, 0.1)',
          fill: true,
          tension: 0.4,
          pointRadius: 4,
          pointHoverRadius: 6,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'top',
          labels: { usePointStyle: true, padding: 20, font: { size: 12 } },
        },
      },
      scales: {
        x: { grid: { display: false }, ticks: { color: '#6c757d' } },
        y: { grid: { color: '#e1e5eb' }, ticks: { color: '#6c757d' }, beginAtZero: true },
      },
      interaction: { intersect: false, mode: 'index' },
    },
  });
}

async function loadRecentTransactions() {
  const tbody = document.getElementById('recent-transactions');
  if (!tbody) return;
  
  try {
    const transactions = await fetchAPI('/transactions?limit=10').catch(() => []);
    
    if (!transactions.length) {
      tbody.innerHTML = `
        <tr>
          <td colspan="7" class="empty-state" style="padding: 40px;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
              <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p>No recent transactions</p>
          </td>
        </tr>
      `;
      return;
    }
    
    tbody.innerHTML = transactions.map(tx => `
      <tr>
        <td>${tx.transaction_id || 'TXN-' + Math.random().toString(36).substr(2, 8).toUpperCase()}</td>
        <td>${tx.account_id || 'ACC-' + Math.random().toString(36).substr(2, 6).toUpperCase()}</td>
        <td>${formatCurrency(tx.amount || Math.random() * 10000)}</td>
        <td>${tx.currency || 'USD'}</td>
        <td><span class="badge badge-${getTypeClass(tx.transaction_type)}">${tx.transaction_type || 'Transfer'}</span></td>
        <td>${tx.channel || 'Web'}</td>
        <td><span class="badge ${tx.fraud_label ? 'badge-danger' : 'badge-success'}">${tx.fraud_label ? 'Flagged' : 'Clean'}</span></td>
      </tr>
    `).join('');
  } catch (error) {
    console.error('Failed to load transactions:', error);
    tbody.innerHTML = '<tr><td colspan="7" class="empty-state">Failed to load transactions</td></tr>';
  }
}

function getTypeClass(type) {
  const types = {
    'transfer': 'info',
    'deposit': 'success',
    'withdrawal': 'warning',
    'payment': 'info',
  };
  return types[(type || '').toLowerCase()] || 'neutral';
}

async function loadFraudAnalytics() {
  const container = document.getElementById('fraud-analytics-charts');
  if (!container) return;
  
  const canvas1 = document.getElementById('fraudTrendChart');
  const canvas2 = document.getElementById('fraudTypeChart');
  
  if (canvas1) {
    const ctx = canvas1.getContext('2d');
    const labels = Array.from({ length: 30 }, (_, i) => {
      const d = new Date();
      d.setDate(d.getDate() - (29 - i));
      return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
    });
    const data = labels.map(() => (Math.random() * 0.5 + 0.1).toFixed(2));
    
    new Chart(ctx, {
      type: 'line',
      data: {
        labels,
        datasets: [{
          label: 'Fraud Rate %',
          data,
          borderColor: '#e63946',
          backgroundColor: 'rgba(230, 57, 70, 0.1)',
          fill: true,
          tension: 0.3,
          pointRadius: 0,
          pointHoverRadius: 5,
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          x: { grid: { display: false }, ticks: { color: '#6c757d', maxTicksLimit: 10 } },
          y: { grid: { color: '#e1e5eb' }, ticks: { color: '#6c757d' } },
        },
      },
    });
  }
  
  if (canvas2) {
    const ctx = canvas2.getContext('2d');
    new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Card Not Present', 'Account Takeover', 'Synthetic Identity', 'Friendly Fraud', 'Other'],
        datasets: [{
          data: [35, 25, 18, 12, 10],
          backgroundColor: ['#e63946', '#f77f00', '#00b4d8', '#2a9d8f', '#6c757d'],
          borderWidth: 0,
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom', labels: { padding: 15, font: { size: 12 } } } },
        cutout: '60%',
      },
    });
  }
}

async function loadInvestigations() {
  const tbody = document.getElementById('investigations-table');
  if (!tbody) return;
  
  const investigations = [
    { id: 'INV-2024-001', case: 'Card Not Present Fraud', status: 'Open', assignee: 'J. Smith', created: '2024-01-15', priority: 'High' },
    { id: 'INV-2024-002', case: 'Account Takeover', status: 'In Progress', assignee: 'M. Chen', created: '2024-01-14', priority: 'High' },
    { id: 'INV-2024-003', case: 'Synthetic Identity', status: 'Under Review', assignee: 'A. Patel', created: '2024-01-13', priority: 'Medium' },
    { id: 'INV-2024-004', case: 'Money Laundering Ring', status: 'Open', assignee: 'R. Johnson', created: '2024-01-12', priority: 'Critical' },
    { id: 'INV-2024-005', case: 'Friendly Fraud Cluster', status: 'Closed', assignee: 'S. Williams', created: '2024-01-10', priority: 'Low' },
  ];
  
  tbody.innerHTML = investigations.map(inv => `
    <tr>
      <td><strong>${inv.id}</strong></td>
      <td>${inv.case}</td>
      <td><span class="badge badge-${getStatusClass(inv.status)}">${inv.status}</span></td>
      <td>${inv.assignee}</td>
      <td>${inv.created}</td>
      <td><span class="badge badge-${getPriorityClass(inv.priority)}">${inv.priority}</span></td>
      <td><button class="btn btn-secondary btn-sm">View</button></td>
    </tr>
  `).join('');
}

function getStatusClass(status) {
  const map = { 'Open': 'danger', 'In Progress': 'warning', 'Under Review': 'info', 'Closed': 'success' };
  return map[status] || 'neutral';
}

function getPriorityClass(priority) {
  const map = { 'Critical': 'danger', 'High': 'warning', 'Medium': 'info', 'Low': 'success' };
  return map[priority] || 'neutral';
}

async function loadNetworkAnalysis() {
  const canvas = document.getElementById('networkChart');
  if (!canvas) return;
  
  const ctx = canvas.getContext('2d');
  
  const data = {
    nodes: [
      { id: 'A1', label: 'Account A1', x: 200, y: 150, size: 30, color: '#1e3a5f' },
      { id: 'B2', label: 'Account B2', x: 400, y: 100, size: 25, color: '#00b4d8' },
      { id: 'C3', label: 'Account C3', x: 350, y: 280, size: 22, color: '#2a9d8f' },
      { id: 'D4', label: 'Account D4', x: 150, y: 250, size: 20, color: '#f77f00' },
      { id: 'E5', label: 'Account E5', x: 450, y: 220, size: 18, color: '#6c757d' },
      { id: 'F6', label: 'Account F6', x: 100, y: 180, size: 15, color: '#6c757d' },
    ],
    edges: [
      { from: 'A1', to: 'B2', weight: 5 },
      { from: 'A1', to: 'C3', weight: 3 },
      { from: 'A1', to: 'D4', weight: 2 },
      { from: 'B2', to: 'E5', weight: 4 },
      { from: 'C3', to: 'D4', weight: 2 },
      { from: 'D4', to: 'F6', weight: 1 },
      { from: 'E5', to: 'F6', weight: 2 },
    ],
  };
  
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  
  data.edges.forEach(edge => {
    const from = data.nodes.find(n => n.id === edge.from);
    const to = data.nodes.find(n => n.id === edge.to);
    if (from && to) {
      ctx.beginPath();
      ctx.moveTo(from.x, from.y);
      ctx.lineTo(to.x, to.y);
      ctx.strokeStyle = `rgba(30, 58, 95, ${0.2 + edge.weight * 0.1})`;
      ctx.lineWidth = 1 + edge.weight;
      ctx.stroke();
    }
  });
  
  data.nodes.forEach(node => {
    ctx.beginPath();
    ctx.arc(node.x, node.y, node.size, 0, Math.PI * 2);
    ctx.fillStyle = node.color;
    ctx.fill();
    ctx.strokeStyle = 'white';
    ctx.lineWidth = 3;
    ctx.stroke();
    
    ctx.font = '11px system-ui';
    ctx.fillStyle = 'white';
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.fillText(node.label.split(' ')[1], node.x, node.y);
    
    ctx.fillStyle = '#1e3a5f';
    ctx.textAlign = 'center';
    ctx.textBaseline = 'top';
    ctx.fillText(node.label, node.x, node.y + node.size + 5);
  });
}

function formatNumber(num) {
  if (num >= 1e9) return (num / 1e9).toFixed(1) + 'B';
  if (num >= 1e6) return (num / 1e6).toFixed(1) + 'M';
  if (num >= 1e3) return (num / 1e3).toFixed(1) + 'K';
  return num.toLocaleString();
}

function formatCurrency(num) {
  return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(num);
}

document.addEventListener('DOMContentLoaded', async () => {
  const page = document.body.dataset.page || 'dashboard';
  
  await loadDashboardStats();
  
  switch (page) {
    case 'dashboard':
      await loadTransactionChart();
      await loadRecentTransactions();
      break;
    case 'fraud-analytics':
      await loadFraudAnalytics();
      break;
    case 'investigations':
      await loadInvestigations();
      break;
    case 'network-analysis':
      await loadNetworkAnalysis();
      break;
  }
  
  window.addEventListener('resize', () => {
    if (page === 'dashboard') loadTransactionChart();
    if (page === 'fraud-analytics') loadFraudAnalytics();
    if (page === 'network-analysis') loadNetworkAnalysis();
  });
});