<?php

namespace App\Service;


class SalesTaxService {
    public function calcTax($amount): float
    {
        return $amount += (12 / 100);
    }
}