<?php

namespace RectorPrefix20210504;

use RectorPrefix20210504\App\Kernel;
use RectorPrefix20210504\Symfony\Component\ErrorHandler\Debug;
use RectorPrefix20210504\Symfony\Component\HttpFoundation\Request;
require \dirname(__DIR__) . '/config/bootstrap.php';
if ($_SERVER['APP_DEBUG']) {
    \umask(00);
    \RectorPrefix20210504\Symfony\Component\ErrorHandler\Debug::enable();
}
if ($trustedProxies = $_SERVER['TRUSTED_PROXIES'] ?? \false) {
    \RectorPrefix20210504\Symfony\Component\HttpFoundation\Request::setTrustedProxies(\explode(',', $trustedProxies), \RectorPrefix20210504\Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_ALL ^ \RectorPrefix20210504\Symfony\Component\HttpFoundation\Request::HEADER_X_FORWARDED_HOST);
}
if ($trustedHosts = $_SERVER['TRUSTED_HOSTS'] ?? \false) {
    \RectorPrefix20210504\Symfony\Component\HttpFoundation\Request::setTrustedHosts([$trustedHosts]);
}
$kernel = new \RectorPrefix20210504\App\Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);
$request = \RectorPrefix20210504\Symfony\Component\HttpFoundation\Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
