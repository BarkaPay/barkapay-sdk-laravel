<?php

namespace BarkapayLaravel\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
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
    protected $baseUrl;
    private $currency;

    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';

    public function __construct()
    {
        $this->apiKey = config('barkapay.api_key');
        $this->apiSecret = config('barkapay.api_secret');
        $this->sciKey = config('barkapay.sci_key');
        $this->sciSecret = config('barkapay.sci_secret');
        $this->baseUrl = config('barkapay.base_url');
        $this->currency = config('barkapay.currency');

        if (empty($this->apiKey) || empty($this->apiSecret) || empty($this->sciKey) || empty($this->sciSecret)) {
            logError("API or SCI keys are missing", "Configuration");
            throw new InvalidArgumentException("API keys and SCI keys are required.");
        }

        if (empty($this->baseUrl)) {
            logError("Base URL is missing", "Configuration");
            throw new InvalidArgumentException("The API base URL is required.");
        }
    }

    /**
     * Sends HTTP requests using Guzzle.
     */
    protected function sendAPIHttpRequest(string $method, string $url, array $headers = [], array $body = [])
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
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            logError("HTTP Request with payload: " . json_encode($body) . " failed: " . $e->getMessage(), "API");
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
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            logError("SCI HTTP Request with payload: " . json_encode($body) . " failed: " . $e->getMessage(), "API");

            throw new RuntimeException("SCI Request failed: " . $e->getMessage());
        }
    }

    public function verifyCredentials()
    {
        return $this->sendAPIHttpRequest(self::METHOD_GET, $this->baseUrl . 'ping');
    }

    public function getAvailableServices()
    {
        return $this->sendAPIHttpRequest(self::METHOD_GET, $this->baseUrl . 'status');
    }

    public function getUserInfos()
    {
        return $this->sendAPIHttpRequest(self::METHOD_GET, $this->baseUrl . 'user');
    }

    public function getAccountsBalances()
    {
        return $this->sendAPIHttpRequest(self::METHOD_GET, $this->baseUrl . 'accounts');
    }

    public function getOperatorsInfos()
    {
        return $this->sendAPIHttpRequest(self::METHOD_GET, $this->baseUrl . 'operators-infos');
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
            $url = "{$this->baseUrl}payment/{$publicId}";
            $headers = ['Accept-Language' => $language];

            $response = $this->sendAPIHttpRequest(self::METHOD_GET, $url, $headers);

            if (!isset($response['status']) || $response['status'] !== 'success') {
                $errorMessage = $response['message'] ?? "Unknown error";
                logError("Error retrieving payment details: $errorMessage", "API");
                throw new RuntimeException("Error retrieving payment details: $errorMessage");
            }

            return $response;
        } catch (Exception $e) {
            logError("Exception occurred while retrieving payment details: " . $e->getMessage(), "API");
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
            $url = "{$this->baseUrl}transfer/{$publicId}";
            $headers = ['Accept-Language' => $language];

            $response = $this->sendAPIHttpRequest(self::METHOD_GET, $url, $headers);

            if (!isset($response['status']) || $response['status'] !== 'success') {
                $errorMessage = $response['message'] ?? "Unknown error";
                logError("Error retrieving transfer details: $errorMessage", "API");
                throw new RuntimeException("Error retrieving transfer details: $errorMessage");
            }

            return $response;
        } catch (Exception $e) {
            logError("Exception occurred while retrieving transfer details: " . $e->getMessage(), "API");
            throw new RuntimeException("Error retrieving transfer details: " . $e->getMessage());
        }
    }
}
