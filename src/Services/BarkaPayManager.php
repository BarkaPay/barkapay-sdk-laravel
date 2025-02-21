<?php

namespace BarkapayLaravel\Services;

class BarkaPayManager
{
    protected $baseService;
    protected $apiService;
    protected $sciService;
    protected $orangeMoneyService;
    protected $moovMoneyService;

    public function __construct(
        BaseBarkaPayPaymentService $baseService,
        APIBarkaPayPaymentService $apiService,
        SCIBarkaPayPaymentService $sciService,
        OrangeMoneyBFBarkaPayPaymentService $orangeMoneyService,
        MoovMoneyBFBarkaPayPaymentService $moovMoneyService
    ) {
        $this->baseService = $baseService;
        $this->apiService = $apiService;
        $this->sciService = $sciService;
        $this->orangeMoneyService = $orangeMoneyService;
        $this->moovMoneyService = $moovMoneyService;
    }

    /**
     * Access the base service
     */
    public function base()
    {
        return $this->baseService;
    }

    /**
     * Access the API service
     */
    public function api()
    {
        return $this->apiService;
    }

    /**
     * Access the SCI service
     */
    public function sci()
    {
        return $this->sciService;
    }

    /**
     * Access the Orange Money payment service
     */
    public function orangeMoneyBF()
    {
        return $this->orangeMoneyService;
    }

    /**
     * Access the Moov Money payment service
     */
    public function moovMoneyBF()
    {
        return $this->moovMoneyService;
    }
}
