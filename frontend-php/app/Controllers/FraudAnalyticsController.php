<?php
declare(strict_types=1);

namespace App\Controllers;

class FraudAnalyticsController
{
    public function index(): string
    {
        ob_start();
        include __DIR__ . '/../views/fraud-analytics.php';
        return ob_get_clean();
    }
}