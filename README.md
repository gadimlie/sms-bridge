# SmsBridge

A Laravel package for managing and sending SMS messages based on Azerbaijan providers with a unified interface.

---

## Features

- Simple, extensible SMS sending interface
- Multiple provider support (e.g., Figensoft, LSim)
- Easy configuration and integration with Laravel
- PSR-4 autoloading and service provider

---

## Installation

**Via Composer (local path):**

```bash
composer require gadimlie/sms-bridge
```
Or, if developing locally, add to your Laravel app's `composer.json`:
```json
"autoload": {
    "psr-4": {
        "Gadimlie\\SmsBridge\\": "devpack/gadimlie/sms-bridge/src/"
    }
}
```
Then run:
```bash
composer dump-autoload
```

---

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --tag=config
```

This will create `config/sms-bridge.php`.  
Edit this file to set your default provider and provider credentials:

```php
return [
    'default' => 'figensoft',
    'providers' => [
        'figensoft' => [
            'driver' => \Gadimlie\SmsBridge\Drivers\FigensoftProvider::class,
            'config' => [
                'endpoint' => env('SMS_BRIDGE_ENDPOINT'),
                'username' => env('SMS_BRIDGE_USERNAME'),
                'password' => env('SMS_BRIDGE_PASSWORD'),
            ],
        ],
        // Add more providers as needed...
    ],
];
```

---

## Usage

You can resolve the manager from the service container:

```php
use Gadimlie\SmsBridge\SmsBridgeManager;

$sms = app(SmsBridgeManager::class);
$sms->send('+994501234567', 'Test message');
```

To use a specific provider:

```php
$sms->send('+994501234567', 'Test message', 'lsim');
```

---

## Adding Providers

To add a new provider, create a class that implements `Gadimlie\SmsBridge\Contracts\SmsBridgeProviderInterface` and add it to your config.


## Contributing

Pull requests and issues are welcome!

---

## License

MIT
