<?php

declare (strict_types=1);
namespace Symplify\PackageBuilder\Http;

use RectorPrefix20201226\GuzzleHttp\ClientInterface;
use RectorPrefix20201226\GuzzleHttp\Exception\BadResponseException;
use RectorPrefix20201226\GuzzleHttp\Psr7\Request;
use RectorPrefix20201226\Nette\Utils\Json;
use RectorPrefix20201226\Nette\Utils\JsonException;
use RectorPrefix20201226\Psr\Http\Message\ResponseInterface;
final class BetterGuzzleClient
{
    /**
     * @var ClientInterface
     */
    private $client;
    public function __construct(\RectorPrefix20201226\GuzzleHttp\ClientInterface $client)
    {
        $this->client = $client;
    }
    /**
     * @api
     * @return mixed[]|mixed|void
     */
    public function requestToJson(string $url) : array
    {
        $request = new \RectorPrefix20201226\GuzzleHttp\Psr7\Request('GET', $url);
        $response = $this->client->send($request);
        if (!$this->isSuccessCode($response)) {
            throw \RectorPrefix20201226\GuzzleHttp\Exception\BadResponseException::create($request, $response);
        }
        $content = (string) $response->getBody();
        if ($content === '') {
            return [];
        }
        try {
            return \RectorPrefix20201226\Nette\Utils\Json::decode($content, \RectorPrefix20201226\Nette\Utils\Json::FORCE_ARRAY);
        } catch (\RectorPrefix20201226\Nette\Utils\JsonException $jsonException) {
            throw new \RectorPrefix20201226\Nette\Utils\JsonException('Syntax error while decoding:' . $content, $jsonException->getLine(), $jsonException);
        }
    }
    private function isSuccessCode(\RectorPrefix20201226\Psr\Http\Message\ResponseInterface $response) : bool
    {
        return $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;
    }
}
