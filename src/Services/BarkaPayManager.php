<?php

namespace BarkapayLaravel\Services;

class BarkaPayManager
{
    protected $baseService;
    protected $apiService;
    protected $sciService;

    public function __construct(
        BaseBarkaPayPaymentService $baseService,
        APIBarkaPayPaymentService $apiService,
        SCIBarkaPayPaymentService $sciService
    ) {
        $this->baseService = $baseService;
        $this->apiService = $apiService;
        $this->sciService = $sciService;
    }

    /**
     * Accéder au service de base
     */
    public function base()
    {
        return $this->baseService;
    }

    /**
     * Accéder au service API
     */
    public function api()
    {
        return $this->apiService;
    }

    /**
     * Accéder au service SCI
     */
    public function sci()
    {
        return $this->sciService;
    }
}
