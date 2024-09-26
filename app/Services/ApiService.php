<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Log;

class ApiService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.api.base_url');
        $this->apiKey = config('services.api.api_key');
    }

    public function get($endpoint, $params = [])
    {
        $params = $this->addApiKeyToParams($params);

        $url = $this->baseUrl . $endpoint;

        $response = Http::retry(3, 5000)
            ->timeout(120)
            ->withHeaders([
                'Accept' => 'application/json'
            ])->get($url, $params);

        return $response->json();
    }

    public function put($endpoint, $data = [])
    {
        $params = $this->addApiKeyToParams($data);

        $url = $this->baseUrl . $endpoint;

        try {
            $response = Http::retry(3, 5000)
                ->timeout(120)
                ->withHeaders([
                    'Accept' => 'application/json'
                ])->put($url, $params);

            $response = $response->getBody();
            return json_decode($response, true);

        } catch (\Exception $e) {
            $message = $e->getMessage();

            return [
                'status' => 500,
                'message' => $message
            ];
        }
    }


    private function addApiKeyToParams($params)
    {
        $apiKey = config('services.api.api_key');
        $params['key'] = $apiKey;

        return $params;
    }
}
