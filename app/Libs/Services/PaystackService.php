<?php

namespace App\Libs\Services;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

/**
 * PaystackService
 */
class PaystackService
{
    /**
     * @var string|Repository|Application|\Illuminate\Foundation\Application|mixed
     */
    private string $key;
    /**
     * @var string|Repository|Application|\Illuminate\Foundation\Application|mixed
     */
    private string $url;

    public function __construct()
    {
        $this->key = config('meremco.paystack.key');
        $this->url = config('meremco.paystack.url');
    }

    /**
     * initialize stripe payment
     * @param $data
     * @return PromiseInterface|Response
     */
    public function initializePaystackPaymentService($data): PromiseInterface|Response
    {
        return Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$this->key,
            'Cache-Control' =>  'no-cache',
        ])->post($this->url.'/transaction/initialize', [
            'email' => $data['email'],
            'amount' => $data['amount'],
            'reference' => $data['ref'],
            'callback_url' => 'www.paystack.com/'.$data['ref']
        ]);
    }

    /**
     * verify paystack unit
     * @param $reference
     * @return PromiseInterface|Response
     */
    public function verifyPaystackPaymentService($reference): PromiseInterface|Response
    {
        return Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer ".$this->key,
            "Cache-Control" =>  "no-cache",
        ])->get($this->url.'/transaction/verify/'. $reference);
    }

    /**
     * @param $data
     * @return PromiseInterface|Response
     */
    public function getAccountNameService($data): PromiseInterface|Response
    {
         return Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer ".$this->key,
        ])->get($this->url.'/bank/resolve?account_number='.$data['accountNumber'].'&bank_code='.$data['bankCode']);
    }

}

