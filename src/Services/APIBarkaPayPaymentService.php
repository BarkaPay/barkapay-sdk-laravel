<?php

namespace BarkapayLaravel\Services;

use InvalidArgumentException;
use RuntimeException;

class APIBarkaPayPaymentService extends BaseBarkaPayPaymentService
{
    /**
     * Creates a mobile payment transaction.
     *
     * @param array $paymentDetails Payment details including sender info, amount, and order ID.
     * @param string $language Language for API response ('fr' by default).
     * @return array Response from the API.
     * @throws InvalidArgumentException If required fields are missing.
     * @throws RuntimeException If the request fails.
     */
    public function createMobilePayment(array $paymentDetails, string $language = 'fr')
    {
        $url = $this->baseUrl . 'payment/mobile/api';

        // Champs obligatoires pour effectuer le paiement
        $requiredFields = ['sender_country', 'sender_phonenumber', 'operator', 'amount', 'order_id'];
        foreach ($requiredFields as $field) {
            if (empty($paymentDetails[$field])) {
                throw new InvalidArgumentException("Missing required field: $field.");
            }
        }

        // Vérification de callback_url si fourni
        if (!empty($paymentDetails['callback_url']) && !filter_var($paymentDetails['callback_url'], FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException("Invalid callback URL provided.");
        }

        // Préparation du payload pour la requête API
        $payload = [
            'sender_country' => $paymentDetails['sender_country'],
            'operator' => $paymentDetails['operator'],
            'sender_phonenumber' => $paymentDetails['sender_phonenumber'],
            'otp' => $paymentDetails['otp'] ?? null, // OTP si requis
            'set_amount' => 'fixed',
            'amount' => $paymentDetails['amount'],
            'order_id' => $paymentDetails['order_id'],
            'callback_url' => $paymentDetails['callback_url'] ?? 'N/A',
        ];

        // Envoi de la requête et gestion des erreurs
        try {
            return $this->sendAPIHttpRequest(static::METHOD_POST, $url, ['Accept-Language' => $language], $payload);
        } catch (RuntimeException $e) {
            logError("Failed to create mobile payment with payload: " . json_encode($payload) . " and error " . $e->getMessage(), "Payment");
            throw new RuntimeException("Failed to create mobile payment: " . $e->getMessage());
        }
    }
}
