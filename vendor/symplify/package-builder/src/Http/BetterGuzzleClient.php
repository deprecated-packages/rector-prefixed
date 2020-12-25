<?php

declare (strict_types=1);
namespace Symplify\PackageBuilder\Http;

use _PhpScoperfce0de0de1ce\GuzzleHttp\ClientInterface;
use _PhpScoperfce0de0de1ce\GuzzleHttp\Exception\BadResponseException;
use _PhpScoperfce0de0de1ce\GuzzleHttp\Psr7\Request;
use _PhpScoperfce0de0de1ce\Nette\Utils\Json;
use _PhpScoperfce0de0de1ce\Nette\Utils\JsonException;
use _PhpScoperfce0de0de1ce\Psr\Http\Message\ResponseInterface;
final class BetterGuzzleClient
{
    /**
     * @var ClientInterface
     */
    private $client;
    public function __construct(\_PhpScoperfce0de0de1ce\GuzzleHttp\ClientInterface $client)
    {
        $this->client = $client;
    }
    /**
     * @api
     * @return mixed[]|mixed|void
     */
    public function requestToJson(string $url) : array
    {
        $request = new \_PhpScoperfce0de0de1ce\GuzzleHttp\Psr7\Request('GET', $url);
        $response = $this->client->send($request);
        if (!$this->isSuccessCode($response)) {
            throw \_PhpScoperfce0de0de1ce\GuzzleHttp\Exception\BadResponseException::create($request, $response);
        }
        $content = (string) $response->getBody();
        if ($content === '') {
            return [];
        }
        try {
            return \_PhpScoperfce0de0de1ce\Nette\Utils\Json::decode($content, \_PhpScoperfce0de0de1ce\Nette\Utils\Json::FORCE_ARRAY);
        } catch (\_PhpScoperfce0de0de1ce\Nette\Utils\JsonException $jsonException) {
            throw new \_PhpScoperfce0de0de1ce\Nette\Utils\JsonException('Syntax error while decoding:' . $content, $jsonException->getLine(), $jsonException);
        }
    }
    private function isSuccessCode(\_PhpScoperfce0de0de1ce\Psr\Http\Message\ResponseInterface $response) : bool
    {
        return $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;
    }
}
