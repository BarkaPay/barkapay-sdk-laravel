<?php

namespace BarkapayLaravel\Services;

use InvalidArgumentException;

class APIBarkaPayPaymentService extends BaseBarkaPayPaymentService
{
    public function createMobilePayment(array $paymentDetails, string $language = 'fr')
    {
        $url = self::BASE_URL . 'payment/mobile/api';
        $requiredFields = ['sender_country', 'sender_phonenumber', 'operator', 'amount', 'order_id'];
        
        foreach ($requiredFields as $field) {
            if (empty($paymentDetails[$field])) {
                throw new InvalidArgumentException("Missing required field: $field.");
            }
        }

        $payload = [
            'sender_country' => $paymentDetails['sender_country'],
            'operator' => $paymentDetails['operator'],
            'sender_phonenumber' => $paymentDetails['sender_phonenumber'],
            'otp' => $paymentDetails['otp'] ?? null, // OTP if required
            'set_amount' => 'fixed',
            'amount' => $paymentDetails['amount'],
            'order_id' => $paymentDetails['order_id'],
            'callback_url' => $paymentDetails['callback_url'] ?? 'N/A',  
        ];

        return $this->sendHttpRequest(self::METHOD_POST, $url, ['Accept-Language' => $language], $payload);
    }
}