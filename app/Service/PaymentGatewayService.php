<?php

namespace App\Service;

use App\Interfaces\PaymentGatewayServiceInterface;

class PaymentGatewayService implements PaymentGatewayServiceInterface {
    public function charge($tax_amount): bool
    {
        if ($tax_amount > 0) {
            return true;
        } else {
            return false;
        }
    }
}