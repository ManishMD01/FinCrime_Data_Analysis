<?php
declare(strict_types=1);

$title = 'Network Analysis - Fincrime Intelligence';
$current_page = 'network-analysis';

$content = '
<div class="section">
  <h1 class="page-title">Network Analysis</h1>
  <p class="page-subtitle">Visualize entity relationships and detect money laundering networks</p>
</div>

<div class="grid grid-4">
  <div class="card stat-card">
    <div class="card-body">
      <div class="stat-label">Total Entities</div>
      <div class="stat-value">2,847</div>
    </div>
  </div>
  <div class="card stat-card">
    <div class="card-body">
      <div class="stat-label">Connections</div>
      <div class="stat-value">15,632</div>
    </div>
  </div>
  <div class="card stat-card">
    <div class="card-body">
      <div class="stat-label">Suspicious Clusters</div>
      <div class="stat-value">23</div>
      <div class="stat-change negative">+3 new</div>
    </div>
  </div>
  <div class="card stat-card">
    <div class="card-body">
      <div class="stat-label">Risk Score Avg</div>
      <div class="stat-value">67.4</div>
    </div>
  </div>
</div>

<div class="grid grid-2">
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">Network Graph</h2>
    </div>
    <div class="card-body">
      <div class="chart-container" style="height: 500px;">
        <canvas id="networkChart"></canvas>
      </div>
      <div style="margin-top: 16px; display: flex; gap: 16px; flex-wrap: wrap;">
        <button class="btn btn-secondary btn-sm">Reset View</button>
        <button class="btn btn-secondary btn-sm">Export PNG</button>
        <button class="btn btn-secondary btn-sm">Show Labels</button>
        <button class="btn btn-primary btn-sm">Run Analysis</button>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">Top Risk Clusters</h2>
    </div>
    <div class="card-body">
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Cluster ID</th>
              <th>Entities</th>
              <th>Total Volume</th>
              <th>Risk Score</th>
              <th>Pattern</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>CLU-2024-001</td>
              <td>12</td>
              <td>$2.4M</td>
              <td>94</td>
              <td>Structuring</td>
              <td><span class="badge badge-danger">Active</span></td>
            </tr>
            <tr>
              <td>CLU-2024-002</td>
              <td>8</td>
              <td>$1.1M</td>
              <td>87</td>
              <td>Layering</td>
              <td><span class="badge badge-warning">Monitoring</span></td>
            </tr>
            <tr>
              <td>CLU-2024-003</td>
              <td>15</td>
              <td>$3.8M</td>
              <td>82</td>
              <td>Shell Companies</td>
              <td><span class="badge badge-danger">Active</span></td>
            </tr>
            <tr>
              <td>CLU-2024-004</td>
              <td>6</td>
              <td>$540K</td>
              <td>76</td>
              <td>Circular Flow</td>
              <td><span class="badge badge-info">Review</span></td>
            </tr>
            <tr>
              <td>CLU-2024-005</td>
              <td>9</td>
              <td>$890K</td>
              <td>71</td>
              <td>Smurfing</td>
              <td><span class="badge badge-warning">Monitoring</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="card-header">
      <h2 class="card-title">Entity Search</h2>
    </div>
    <div class="card-body">
      <div class="form-group">
        <input type="text" class="form-input" placeholder="Search by Account ID, Name, or Tax ID..." style="max-width: 400px;">
      </div>
    </div>
  </div>
</div>
';

include __DIR__ . '/layouts/main.php';