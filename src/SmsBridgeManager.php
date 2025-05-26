<?php

namespace Gadimlie\SmsBridge;

use Gadimlie\SmsBridge\Contracts\SmsProviderInterface;
use Gadimlie\SmsBridge\Helpers\PhoneValidator;
use Gadimlie\SmsBridge\Contracts\SmsBridgeProviderInterface;
use InvalidArgumentException;

class SmsBridgeManager
{
    protected array $providers = [];
    protected string $defaultProvider;

    public function __construct()
    {
        $configs = config('sms-bridge.providers', []);
        $this->defaultProvider = config('sms-bridge.default');

        foreach ($configs as $name => $provider) {
            if (!isset($provider['driver']) || !class_exists($provider['driver'])) {
                continue;
            }

            $this->providers[$name] = new $provider['driver']($provider['config'] ?? []);
        }
    }

    public function driver(string $name): SmsBridgeProviderInterface
    {
        if (!isset($this->providers[$name])) {
            throw new InvalidArgumentException("SMS provider [$name] is not defined.");
        }

        return $this->providers[$name];
    }

    public function send(string $to, string $message)
    {
        $formatted = PhoneValidator::formatLocalNumber($to);

        if (!$formatted) {
            return false; // or throw exception if stricter behavior needed
        }

        $provider = $providerName ?? $this->defaultProvider;

        return $this->driver($provider)->send($formatted, $message);
    }
}
