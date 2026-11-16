<?php
declare(strict_types=1);

namespace App\Controllers;

class TransactionsController
{
    public function index(): string
    {
        ob_start();
        include __DIR__ . '/../views/transactions.php';
        return ob_get_clean();
    }
}