<?php
declare(strict_types=1);

namespace App\Controllers;

class InvestigationsController
{
    public function index(): string
    {
        ob_start();
        include __DIR__ . '/../views/investigations.php';
        return ob_get_clean();
    }
}