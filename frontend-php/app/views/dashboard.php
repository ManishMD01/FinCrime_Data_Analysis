<?php
declare(strict_types=1);

$title = 'Dashboard - Fincrime Intelligence';
$current_page = 'dashboard';

$content = '
<div class="section">
  <h1 class="page-title">Dashboard</h1>
  <p class="page-subtitle">Real-time overview of transaction monitoring and fraud detection</p>
</div>

<div class="grid grid-4">
  <div class="card stat-card">
    <div class="card-body">
      <div class="stat-label">Total Transactions</div>
      <div class="stat-value" id="stat-transactions">--</div>
      <div class="stat-change positive">+12.5% vs last week</div>
    </div>
  </div>
  <div class="card stat-card">
    <div class="card-body">
      <div class="stat-label">Total Volume</div>
      <div class="stat-value" id="stat-amount">--</div>
      <div class="stat-change positive">+8.2% vs last week</div>
    </div>
  </div>
  <div class="card stat-card">
    <div class="card-body">
      <div class="stat-label">Unique Accounts</div>
      <div class="stat-value" id="stat-accounts">--</div>
      <div class="stat-change positive">+3.1% vs last week</div>
    </div>
  </div>
  <div class="card stat-card">
    <div class="card-body">
      <div class="stat-label">Fraud Rate</div>
      <div class="stat-value" id="stat-fraud-rate">--</div>
      <div class="stat-change negative">+0.05% vs last week</div>
    </div>
  </div>
</div>

<div class="grid grid-2">
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">Transaction Volume (7 Days)</h2>
    </div>
    <div class="card-body">
      <div class="chart-container">
        <canvas id="transactionChart"></canvas>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">Recent Transactions</h2>
    </div>
    <div class="card-body" style="padding: 0;">
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Transaction ID</th>
              <th>Account</th>
              <th>Amount</th>
              <th>Currency</th>
              <th>Type</th>
              <th>Channel</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody id="recent-transactions">
            <tr><td colspan="7" class="empty-state">Loading...</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
';

include __DIR__ . '/layouts/main.php';