<?php
declare(strict_types=1);

namespace App\Controllers;

class NetworkAnalysisController
{
    public function index(): string
    {
        ob_start();
        include __DIR__ . '/../views/network-analysis.php';
        return ob_get_clean();
    }
}