<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SteadfastCourier
{
    protected $baseUrl;
    protected $apiKey;
    protected $secretKey;

    public function __construct()
    {
        $this->baseUrl = 'https://portal.steadfast.com.bd/api/v1';
        $this->apiKey = config('services.steadfast.api_key');
        $this->secretKey = config('services.steadfast.secret_key');
    }

    /**
     * Create an order in Steadfast system.
     */
    public function createOrder($order)
    {
        try {
            $response = Http::withHeaders([
                'Api-Key' => $this->apiKey,
                'Secret-Key' => $this->secretKey,
                'Content-Type' => 'application/json'
            ])->post($this->baseUrl . '/create_order', [
                'invoice' => $order->id,
                'recipient_name' => $order->receiver_name,
                'recipient_phone' => $order->receiver_mobile,
                'recipient_address' => $order->receiver_address,
                'cod_amount' => $order->payment_status ? 0 : $order->total,
                'note' => 'Order from E-Commerce Site'
            ]);

            $result = $response->json();

            if ($response->successful() && isset($result['status']) && $result['status'] === 200) {
                return [
                    'success' => true,
                    'tracking_id' => $result['consignment']['consignment_id'],
                    'status' => $result['consignment']['status']
                ];
            }

            Log::error('Steadfast API Error: ' . json_encode($result));
            return ['success' => false, 'message' => $result['errors'] ?? 'Unknown error'];

        } catch (\Exception $e) {
            Log::error('Steadfast Connection Error: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Track an order by tracking ID.
     */
    public function trackOrder($trackingId)
    {
        try {
            $response = Http::withHeaders([
                'Api-Key' => $this->apiKey,
                'Secret-Key' => $this->secretKey,
            ])->get($this->baseUrl . '/track_order/' . $trackingId);

            return $response->json();
        } catch (\Exception $e) {
            return null;
        }
    }
}
