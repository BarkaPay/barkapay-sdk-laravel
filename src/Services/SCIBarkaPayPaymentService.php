<?php

namespace BarkapayLaravel\Services;

use InvalidArgumentException;

class SCIBarkaPayPaymentService extends BaseBarkaPayPaymentService
{
    public function createPaymentLink(array $paymentData, string $language = 'fr')
    {
        if (empty($paymentData['amount']) || empty($paymentData['order_id']) || empty($paymentData['callback_url'])) {
            throw new InvalidArgumentException("Missing required fields: amount, order_id or callback_url.");
        }

        $url = $this->baseUrl .  'payment/mobile/web/create';
        $paymentData['set_amount'] = 'fixed';

        return $this->sendSCIHttpRequest(self::METHOD_POST, $url, ['Accept-Language' => $language], $paymentData);
    }
}
