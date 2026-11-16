<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?? 'Fincrime Intelligence' ?></title>
  <link rel="stylesheet" href="/assets/css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <header class="header">
    <div class="header-brand">
      <svg class="logo" viewBox="0 0 32 32" fill="none" width="32" height="32">
        <rect width="32" height="32" rx="6" fill="#1e3a5f"/>
        <path d="M8 16L14 22L24 10" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      <span class="brand-name">Fincrime Intelligence</span>
    </div>
    <nav class="header-nav">
      <a href="/dashboard" class="<?= $current_page === 'dashboard' ? 'active' : '' ?>">Dashboard</a>
      <a href="/transactions" class="<?= $current_page === 'transactions' ? 'active' : '' ?>">Transactions</a>
      <a href="/fraud-analytics" class="<?= $current_page === 'fraud-analytics' ? 'active' : '' ?>">Fraud Analytics</a>
      <a href="/investigations" class="<?= $current_page === 'investigations' ? 'active' : '' ?>">Investigations</a>
      <a href="/network-analysis" class="<?= $current_page === 'network-analysis' ? 'active' : '' ?>">Network</a>
    </nav>
    <div class="header-status">
      <span class="status-indicator online"></span>
      <span>API Connected</span>
    </div>
  </header>

  <main class="main-content">
    <div class="container">
      <?= $content ?>
    </div>
  </main>

  <footer class="footer">
    <p>Fincrime Intelligence &copy; 2024</p>
  </footer>

  <script src="/assets/js/app.js"></script>
</body>
</html>