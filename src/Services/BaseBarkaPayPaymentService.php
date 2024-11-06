<?php

namespace BarkapayLaravel\Services;

use GuzzleHttp\Client;
use InvalidArgumentException;
use RuntimeException;
use Exception;

/**
 * Handles payment transactions with the BarkaPay payment service.
 */
class BaseBarkaPayPaymentService
{
    private $apiKey;
    private $apiSecret;
    private $sciKey;
    private $sciSecret;
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';

    public const BASE_URL = config('barkapay.base_url');
    const CURRENCY = config('barkapay.currency');

    public function __construct()
    {
        $this->apiKey = config('barkapay.api_key');
        $this->apiSecret = config('barkapay.api_secret');
        $this->sciKey = config('barkapay.sci_key');
        $this->sciSecret = config('barkapay.sci_secret');

        if (empty($this->apiKey) || empty($this->apiSecret) || empty($this->sciKey) || empty($this->sciSecret)) {
            throw new InvalidArgumentException("API keys and SCI keys are required.");
        }
    }

    /**
     * Sends HTTP requests using Guzzle.
     */
    protected function sendHttpRequest(string $method, string $url, array $headers = [], array $body = [])
    {
        $client = new Client();
        $headers = array_merge([
            'X-Api-Key' => $this->apiKey,
            'X-Api-Secret' => $this->apiSecret,
            'Accept' => 'application/json',
        ], $headers);

        $options = ['headers' => $headers];
        if (!empty($body)) {
            $options['json'] = $body;
        }

        try {
            $response = $client->request($method, $url, $options);
            return json_decode($response->getBody(), true);
        } catch (Exception $e) {
            throw new RuntimeException("HTTP Request failed: " . $e->getMessage());
        }
    }

    protected function sendSCIHttpRequest(string $method, string $url, array $headers = [], array $body = [])
    {
        $client = new Client();
        $headers = array_merge([
            'X-Api-Key' => $this->sciKey,
            'X-Api-Secret' => $this->sciSecret,
            'Accept' => 'application/json',
        ], $headers);

        $options = ['headers' => $headers];
        if (!empty($body)) {
            $options['json'] = $body;
        }

        try {
            $response = $client->request($method, $url, $options);
            return json_decode($response->getBody(), true);
        } catch (Exception $e) {
            throw new RuntimeException("SCI Request failed: " . $e->getMessage());
        }
    }

    public function verifyCredentials()
    {
        return $this->sendHttpRequest(self::METHOD_GET, self::BASE_URL . 'ping');
    }

    public function getAvailableServices()
    {
        return $this->sendHttpRequest(self::METHOD_GET, self::BASE_URL . 'status');
    }

    public function getUserInfos()
    {
        return $this->sendHttpRequest(self::METHOD_GET, self::BASE_URL . 'user');
    }

    public function getAccountsBalances()
    {
        return $this->sendHttpRequest(self::METHOD_GET, self::BASE_URL . 'accounts');
    }

    public function getOperatorsInfos()
    {
        return $this->sendHttpRequest(self::METHOD_GET, self::BASE_URL . 'operators-infos');
    }

    /**
     * Retrieves detailed information about a specific payment using its public ID.
     *
     * @param string $publicId The public identifier of the payment to retrieve.
     * @param string $language Preferred language for the API response ('fr', 'en').
     * @return array The details of the payment.
     * @throws InvalidArgumentException If the public ID is not provided.
     * @throws RuntimeException If the HTTP request fails.
     */
    public function getPaymentDetails(string $publicId, string $language = 'fr')
    {
        if (empty($publicId)) {
            throw new InvalidArgumentException("The public ID must be provided.");
        }

        try {
            $url = self::BASE_URL . "payment/$publicId";
            $headers = ['Accept-Language' => $language];

            $response = $this->sendHttpRequest(self::METHOD_GET, $url, $headers);

            if (!$response->successful()) {
                $errorMessage = $response->json('message') ?? "Unknown error";
                throw new RuntimeException("Error retrieving payment details: HTTP status {$response->status()} - $errorMessage");
            }

            return $response->json();
        } catch (Exception $e) {
            throw new RuntimeException("Error retrieving payment details: " . $e->getMessage());
        }
    }

    /**
     * Retrieves detailed information about a specific transfer using its public ID.
     *
     * @param string $publicId The public identifier of the transfer to retrieve.
     * @param string $language Optional. The preferred language for the API response. Defaults to 'fr' (French).
     * @return array The details of the transfer.
     * @throws InvalidArgumentException If the public ID is not provided.
     * @throws RuntimeException If the HTTP request fails.
     */
    public function getTransferDetails(string $publicId, string $language = 'fr')
    {
        if (empty($publicId)) {
            throw new InvalidArgumentException("The public ID must be provided.");
        }

        try {
            $url = self::BASE_URL . "transfer/$publicId";
            $headers = ['Accept-Language' => $language];

            $response = $this->sendHttpRequest(self::METHOD_GET, $url, $headers);

            if (!$response->successful()) {
                $errorMessage = $response->json('message') ?? "Unknown error";
                throw new RuntimeException("Error retrieving transfer details: HTTP status {$response->status()} - $errorMessage");
            }

            return $response->json();
        } catch (Exception $e) {
            throw new RuntimeException("Error retrieving transfer details: " . $e->getMessage());
        }
    }
}
