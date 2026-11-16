<?php
declare(strict_types=1);

$title = 'Investigations - Fincrime Intelligence';
$current_page = 'investigations';

$content = '
<div class="section">
  <div class="section-header">
    <h1 class="page-title">Investigations</h1>
    <div>
      <button class="btn btn-primary">New Investigation</button>
    </div>
  </div>
  <p class="page-subtitle">Manage and track fraud investigation cases</p>
</div>

<div class="card">
  <div class="card-header">
    <h2 class="card-title">Filters</h2>
  </div>
  <div class="card-body">
    <div class="grid grid-4" style="gap: 16px;">
      <div class="form-group">
        <label class="form-label">Status</label>
        <select class="form-input form-select">
          <option value="">All Status</option>
          <option value="open">Open</option>
          <option value="in_progress">In Progress</option>
          <option value="under_review">Under Review</option>
          <option value="closed">Closed</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Priority</label>
        <select class="form-input form-select">
          <option value="">All Priorities</option>
          <option value="critical">Critical</option>
          <option value="high">High</option>
          <option value="medium">Medium</option>
          <option value="low">Low</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Assignee</label>
        <select class="form-input form-select">
          <option value="">All Assignees</option>
          <option value="j_smith">J. Smith</option>
          <option value="m_chen">M. Chen</option>
          <option value="a_patel">A. Patel</option>
          <option value="r_johnson">R. Johnson</option>
          <option value="s_williams">S. Williams</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">Search</label>
        <input type="text" class="form-input" placeholder="Search cases...">
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
            <th>Case ID</th>
            <th>Case Type</th>
            <th>Status</th>
            <th>Assignee</th>
            <th>Created</th>
            <th>Priority</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="investigations-table">
          <tr><td colspan="7" class="empty-state">Loading investigations...</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
';

include __DIR__ . '/layouts/main.php';