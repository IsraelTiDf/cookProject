<?php

// app/Services/PedidoService.php

namespace App\Services;

class PaymentDataBuilder
{
    public static function build(array $customerData, array $creditCardData, $amount): array
    {
        return [
            'MerchantOrderId' => '2014111701',
            'Customer' => $customerData,
            'Payment' => self::buildPaymentData($creditCardData, $amount),
        ];
    }

    private static function buildPaymentData(array $creditCardData, $amount): array
    {
        return [
            'Currency' => 'BRL',
            'Country' => 'BRA',
            'ServiceTaxAmount' => 0,
            'Installments' => 1,
            'Interest' => 'ByMerchant',
            'Capture' => true,
            'Authenticate' => 'false',
            'Recurrent' => 'false',
            'SoftDescriptor' => '123456789ABCD',
            'CreditCard' => $creditCardData,
            'InitiatedTransactionIndicator' => [
                'Category' => 'C1',
                'Subcategory' => 'Standingorder',
            ],
            'IsCryptoCurrencyNegotiation' => true,
            'Type' => 'CreditCard',
            'Amount' => $amount,
            'AirlineData' => [
                'TicketNumber' => 'AR988983',
            ],
        ];
    }
}
