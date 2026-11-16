<?php
declare(strict_types=1);

$title = 'Transactions - Fincrime Intelligence';
$current_page = 'transactions';

$content = '
<div class="section">
  <h1 class="page-title">Transactions</h1>
  <p class="page-subtitle">Browse and search all transactions</p>
</div>

<div class="card">
  <div class="card-header">
    <h2 class="card-title">Transaction Filters</h2>
  </div>
  <div class="card-body">
    <div class="grid grid-4" style="gap: 16px;">
      <div class="form-group">
        <label class="form-label">Date Range</label>
        <input type="date" class="form-input" id="filter-date-from">
      </div>
      <div class="form-group">
        <label class="form-label">To</label>
        <input type="date" class="form-input" id="filter-date-to">
      </div>
      <div class="form-group">
        <label class="form-label">Transaction Type</label>
        <select class="form-input form-select" id="filter-type">
          <option value="">All Types</option>
          <option value="transfer">Transfer</option>
          <option value="deposit">Deposit</option>
          <option value="withdrawal">Withdrawal</option>
          <option value="payment">Payment</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Status</label>
        <select class="form-input form-select" id="filter-status">
          <option value="">All Status</option>
          <option value="clean">Clean</option>
          <option value="flagged">Flagged</option>
        </select>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body" style="padding: 0;">
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Transaction ID</th>
            <th>Timestamp</th>
            <th>Account</th>
            <th>Counterparty</th>
            <th>Amount</th>
            <th>Currency</th>
            <th>Type</th>
            <th>Channel</th>
            <th>Country</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody id="transactions-table">
          <tr><td colspan="10" class="empty-state">Loading transactions...</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
';

include __DIR__ . '/layouts/main.php';