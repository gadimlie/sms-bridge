<?php

namespace Gadimlie\SmsBridge\Drivers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Gadimlie\SmsBridge\Contracts\SmsBridgeProviderInterface;

class FigensoftProvider implements SmsBridgeProviderInterface
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function send(string $to, string $message)
    {
        // dd('FigensoftProvider send called with:', $to, $message);
        try {
            $client = new Client();
            $response = $client->request('GET', $this->config['endpoint'], [
                'query' => [
                    'user'     => $this->config['username'],
                    'password' => $this->config['password'],
                    'gsm'      => $to,
                    'text'     => $message,
                ],
            ]);

            return [
                'code'     => $response->getStatusCode(),
                'response' => $response->getBody()->getContents(),
            ];
        } catch (\Exception $e) {
            Log::error('Figensoft SMS send failed: ' . $e->getMessage());
            return false;
        }
    }
}
