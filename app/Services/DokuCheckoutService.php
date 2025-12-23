<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DokuCheckoutService
{
    protected $clientId;
    protected $secretKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->clientId = config('services.doku.client_id');
        $this->secretKey = config('services.doku.secret_key');
        $this->baseUrl = 'https://api-sandbox.doku.com'; 
    }

    public function createCheckout($orderId, $amount, $customer)
    {
        $path = '/checkout/v1/payment';
        $url = $this->baseUrl . $path;

        $body = [
            "order" => [
                "amount" => $amount,
                "invoice_number" => $orderId,
                "callback_url" => "http://127.0.0.1:8000/tagihan-spp",
                "callback_url_result" => "http://127.0.0.1:8000/tagihan-spp",
            ],
            "customer" => [
                "name" => $customer['name'],
                "email" => $customer['email'],
                "phone" => $customer['phone'],
            ],
            "payment" => new \stdClass(),
        ];

        $bodyJson = json_encode($body, JSON_UNESCAPED_SLASHES);

        $clientId = $this->clientId;
        $secretKey = $this->secretKey;
        $requestId = (string) Str::uuid();
        $timestamp = gmdate('Y-m-d\TH:i:s\Z'); // MUST UTC

        // Signature formula by DOKU
        $componentSignature = "Client-Id:$clientId\n".
                            "Request-Id:$requestId\n".
                            "Request-Timestamp:$timestamp\n".
                            "Request-Target:$path\n".
                            "Digest:" . base64_encode(hash('sha256', $bodyJson, true));

        $signature = base64_encode(hash_hmac('sha256', $componentSignature, $secretKey, true));

        $response = Http::withHeaders([
            "Client-Id" => $clientId,
            "Request-Id" => $requestId,
            "Request-Timestamp" => $timestamp,
            "Signature" => "HMACSHA256=$signature",
            "Digest" => base64_encode(hash('sha256', $bodyJson, true)),
            "Content-Type" => "application/json",
        ])->withBody($bodyJson, 'application/json')
        ->post($url);

        return $response->json();
    }

}
