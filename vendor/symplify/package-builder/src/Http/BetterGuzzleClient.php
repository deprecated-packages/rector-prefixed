<?php

declare (strict_types=1);
namespace Symplify\PackageBuilder\Http;

use _PhpScoperabd03f0baf05\GuzzleHttp\ClientInterface;
use _PhpScoperabd03f0baf05\GuzzleHttp\Exception\BadResponseException;
use _PhpScoperabd03f0baf05\GuzzleHttp\Psr7\Request;
use _PhpScoperabd03f0baf05\Nette\Utils\Json;
use _PhpScoperabd03f0baf05\Nette\Utils\JsonException;
use _PhpScoperabd03f0baf05\Psr\Http\Message\ResponseInterface;
final class BetterGuzzleClient
{
    /**
     * @var ClientInterface
     */
    private $client;
    public function __construct(\_PhpScoperabd03f0baf05\GuzzleHttp\ClientInterface $client)
    {
        $this->client = $client;
    }
    /**
     * @api
     * @return mixed[]|mixed|void
     */
    public function requestToJson(string $url) : array
    {
        $request = new \_PhpScoperabd03f0baf05\GuzzleHttp\Psr7\Request('GET', $url);
        $response = $this->client->send($request);
        if (!$this->isSuccessCode($response)) {
            throw \_PhpScoperabd03f0baf05\GuzzleHttp\Exception\BadResponseException::create($request, $response);
        }
        $content = (string) $response->getBody();
        if ($content === '') {
            return [];
        }
        try {
            return \_PhpScoperabd03f0baf05\Nette\Utils\Json::decode($content, \_PhpScoperabd03f0baf05\Nette\Utils\Json::FORCE_ARRAY);
        } catch (\_PhpScoperabd03f0baf05\Nette\Utils\JsonException $jsonException) {
            throw new \_PhpScoperabd03f0baf05\Nette\Utils\JsonException('Syntax error while decoding:' . $content, $jsonException->getLine(), $jsonException);
        }
    }
    private function isSuccessCode(\_PhpScoperabd03f0baf05\Psr\Http\Message\ResponseInterface $response) : bool
    {
        return $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;
    }
}
