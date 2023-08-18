<?php 

namespace App\Controller;

use App\App;
use App\Service\InvoiceService;
use App\View;

class HomeController {
    public function __construct(private InvoiceService $invoiceService) {
    }

    public function index()
    {
        $this->invoiceService->process(21100, "peter wambua");

        var_dump($_ENV['DB_HOST']);

        return View::render('index', ['name' => 'peter']);
    }
}