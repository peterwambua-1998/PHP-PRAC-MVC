<?php 

namespace App\Interfaces;

interface PaymentGatewayServiceInterface {
    public function charge($tax_amount): bool;
}