<?php
declare(strict_types=1);

namespace App\Controllers;

class DashboardController
{
    public function index(): string
    {
        $_SERVER['REQUEST_URI'] = '/dashboard';
        ob_start();
        include __DIR__ . '/../views/dashboard.php';
        return ob_get_clean();
    }
}