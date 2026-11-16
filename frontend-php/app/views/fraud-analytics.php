<?php
declare(strict_types=1);

$title = 'Fraud Analytics - Fincrime Intelligence';
$current_page = 'fraud-analytics';

$content = '
<div class="section">
  <h1 class="page-title">Fraud Analytics</h1>
  <p class="page-subtitle">Deep dive into fraud patterns, trends, and detection metrics</p>
</div>

<div class="grid grid-4">
  <div class="card stat-card">
    <div class="card-body">
      <div class="stat-label">Total Fraud Cases</div>
      <div class="stat-value">1,247</div>
      <div class="stat-change positive">+23 this week</div>
    </div>
  </div>
  <div class="card stat-card">
    <div class="card-body">
      <div class="stat-label">Fraud Amount</div>
      <div class="stat-value">$487K</div>
      <div class="stat-change positive">+15.2% vs last month</div>
    </div>
  </div>
  <div class="card stat-card">
    <div class="card-body">
      <div class="stat-label">Detection Rate</div>
      <div class="stat-value">94.2%</div>
      <div class="stat-change positive">+1.8%</div>
    </div>
  </div>
  <div class="card stat-card">
    <div class="card-body">
      <div class="stat-label">False Positive Rate</div>
      <div class="stat-value">3.1%</div>
      <div class="stat-change negative">-0.4%</div>
    </div>
  </div>
</div>

<div class="grid grid-2">
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">Fraud Rate Trend (30 Days)</h2>
    </div>
    <div class="card-body">
      <div class="chart-container">
        <canvas id="fraudTrendChart"></canvas>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">Fraud by Type</h2>
    </div>
    <div class="card-body">
      <div class="chart-container" style="height: 280px;">
        <canvas id="fraudTypeChart"></canvas>
      </div>
    </div>
  </div>
</div>

<div class="grid grid-2">
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">Top Risk Indicators</h2>
    </div>
    <div class="card-body">
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Indicator</th>
              <th>Triggered</th>
              <th>Precision</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>High Velocity Transactions</td>
              <td>342</td>
              <td><span class="badge badge-success">89%</span></td>
              <td><button class="btn btn-secondary btn-sm">Review</button></td>
            </tr>
            <tr>
              <td>Round Amount Patterns</td>
              <td>187</td>
              <td><span class="badge badge-info">76%</span></td>
              <td><button class="btn btn-secondary btn-sm">Review</button></td>
            </tr>
            <tr>
              <td>New Device Login</td>
              <td>523</td>
              <td><span class="badge badge-warning">62%</span></td>
              <td><button class="btn btn-secondary btn-sm">Review</button></td>
            </tr>
            <tr>
              <td>Geographic Anomaly</td>
              <td>94</td>
              <td><span class="badge badge-success">91%</span></td>
              <td><button class="btn btn-secondary btn-sm">Review</button></td>
            </tr>
            <tr>
              <td>Structuring Detection</td>
              <td>67</td>
              <td><span class="badge badge-success">95%</span></td>
              <td><button class="btn btn-secondary btn-sm">Review</button></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header">
      <h2 class="card-title">Model Performance</h2>
    </div>
    <div class="card-body">
      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Model</th>
              <th>Version</th>
              <th>Accuracy</th>
              <th>Precision</th>
              <th>Recall</th>
              <th>F1 Score</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>XGBoost Ensemble</td>
              <td>v3.2.1</td>
              <td>96.4%</td>
              <td>94.2%</td>
              <td>91.8%</td>
              <td>93.0%</td>
              <td><span class="badge badge-success">Production</span></td>
            </tr>
            <tr>
              <td>Random Forest</td>
              <td>v2.1.0</td>
              <td>94.1%</td>
              <td>91.5%</td>
              <td>89.2%</td>
              <td>90.3%</td>
              <td><span class="badge badge-info">Staging</span></td>
            </tr>
            <tr>
              <td>Neural Network</td>
              <td>v1.0.3</td>
              <td>95.8%</td>
              <td>93.7%</td>
              <td>90.1%</td>
              <td>91.9%</td>
              <td><span class="badge badge-warning">Testing</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
';

include __DIR__ . '/layouts/main.php';