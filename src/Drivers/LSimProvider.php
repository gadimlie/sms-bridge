<?php

namespace Gadimlie\SmsBridge\Drivers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Gadimlie\SmsBridge\Contracts\SmsBridgeProviderInterface;

class LSimProvider implements SmsBridgeProviderInterface
{
    protected string $login;
    protected string $password;
    protected string $sender;
    protected string $endpoint;

    public function __construct(array $config)
    {
        $this->login = $config['login'];
        $this->password = $config['password'];
        $this->sender = $config['sender'];
        $this->endpoint = $config['endpoint'];
    }

    public function send(string $to, string $message): bool
    {
        $key = $this->generateKey($message, $to);

        $payload = [
            'login' => $this->login,
            'key' => $key,
            'msisdn' => $to,
            'text' => $message,
            'sender' => $this->sender,
            'scheduled' => 'NOW',
            'unicode' => false,
        ];

        $response = $this->postRequest($this->endpoint, $payload);

        return isset($response['errorCode']) && in_array($response['errorCode'], [100, 101, 108]); // 108 = Sent
    }

    protected function generateKey(string $message, string $msisdn): string
    {
        $md5Password = md5($this->password);

        return md5($md5Password . $this->login . $message . $msisdn . $this->sender);
    }

    protected function postRequest(string $url, array $data): array
    {
        $client = new \GuzzleHttp\Client();

        try {
            $res = $client->post($url, [
                'json' => $data,
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'timeout' => 10,
            ]);

            return json_decode($res->getBody(), true);
        } catch (\Throwable $e) {
            return ['errorCode' => -500, 'errorMessage' => $e->getMessage()];
        }
    }
}
