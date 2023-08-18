<?php

namespace App\Service;

use App\Interfaces\PaymentGatewayServiceInterface;

class InvoiceService {
    
    public function __construct(
        public EmailService $emailService,
        public PaymentGatewayServiceInterface $paymentgateway,
        public SalesTaxService $salestax,
        
    ) {
        
       
    }

    

    public function process($amount, $customer)
    {
        $tax = $this->salestax->calcTax($amount);

        if (! $this->paymentgateway->charge($tax)) {
            return false;
        }

        $this->emailService->send($customer, $tax);

        echo "Invoice has been processed";

        return true;
    }
}