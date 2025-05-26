<?php
namespace Gadimlie\SmsBridge\Contracts;

interface SmsBridgeProviderInterface
{
    public function send(string $to, string $message);
}
