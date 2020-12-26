<?php

declare (strict_types=1);
namespace Symplify\PackageBuilder\Http;

use RectorPrefix2020DecSat\GuzzleHttp\ClientInterface;
use RectorPrefix2020DecSat\GuzzleHttp\Exception\BadResponseException;
use RectorPrefix2020DecSat\GuzzleHttp\Psr7\Request;
use RectorPrefix2020DecSat\Nette\Utils\Json;
use RectorPrefix2020DecSat\Nette\Utils\JsonException;
use RectorPrefix2020DecSat\Psr\Http\Message\ResponseInterface;
final class BetterGuzzleClient
{
    /**
     * @var ClientInterface
     */
    private $client;
    public function __construct(\RectorPrefix2020DecSat\GuzzleHttp\ClientInterface $client)
    {
        $this->client = $client;
    }
    /**
     * @api
     * @return mixed[]|mixed|void
     */
    public function requestToJson(string $url) : array
    {
        $request = new \RectorPrefix2020DecSat\GuzzleHttp\Psr7\Request('GET', $url);
        $response = $this->client->send($request);
        if (!$this->isSuccessCode($response)) {
            throw \RectorPrefix2020DecSat\GuzzleHttp\Exception\BadResponseException::create($request, $response);
        }
        $content = (string) $response->getBody();
        if ($content === '') {
            return [];
        }
        try {
            return \RectorPrefix2020DecSat\Nette\Utils\Json::decode($content, \RectorPrefix2020DecSat\Nette\Utils\Json::FORCE_ARRAY);
        } catch (\RectorPrefix2020DecSat\Nette\Utils\JsonException $jsonException) {
            throw new \RectorPrefix2020DecSat\Nette\Utils\JsonException('Syntax error while decoding:' . $content, $jsonException->getLine(), $jsonException);
        }
    }
    private function isSuccessCode(\RectorPrefix2020DecSat\Psr\Http\Message\ResponseInterface $response) : bool
    {
        return $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;
    }
}
