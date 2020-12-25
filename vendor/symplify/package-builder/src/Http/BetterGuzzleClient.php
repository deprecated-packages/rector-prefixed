<?php

declare (strict_types=1);
namespace Symplify\PackageBuilder\Http;

use _PhpScoperbf340cb0be9d\GuzzleHttp\ClientInterface;
use _PhpScoperbf340cb0be9d\GuzzleHttp\Exception\BadResponseException;
use _PhpScoperbf340cb0be9d\GuzzleHttp\Psr7\Request;
use _PhpScoperbf340cb0be9d\Nette\Utils\Json;
use _PhpScoperbf340cb0be9d\Nette\Utils\JsonException;
use _PhpScoperbf340cb0be9d\Psr\Http\Message\ResponseInterface;
final class BetterGuzzleClient
{
    /**
     * @var ClientInterface
     */
    private $client;
    public function __construct(\_PhpScoperbf340cb0be9d\GuzzleHttp\ClientInterface $client)
    {
        $this->client = $client;
    }
    /**
     * @api
     * @return mixed[]|mixed|void
     */
    public function requestToJson(string $url) : array
    {
        $request = new \_PhpScoperbf340cb0be9d\GuzzleHttp\Psr7\Request('GET', $url);
        $response = $this->client->send($request);
        if (!$this->isSuccessCode($response)) {
            throw \_PhpScoperbf340cb0be9d\GuzzleHttp\Exception\BadResponseException::create($request, $response);
        }
        $content = (string) $response->getBody();
        if ($content === '') {
            return [];
        }
        try {
            return \_PhpScoperbf340cb0be9d\Nette\Utils\Json::decode($content, \_PhpScoperbf340cb0be9d\Nette\Utils\Json::FORCE_ARRAY);
        } catch (\_PhpScoperbf340cb0be9d\Nette\Utils\JsonException $jsonException) {
            throw new \_PhpScoperbf340cb0be9d\Nette\Utils\JsonException('Syntax error while decoding:' . $content, $jsonException->getLine(), $jsonException);
        }
    }
    private function isSuccessCode(\_PhpScoperbf340cb0be9d\Psr\Http\Message\ResponseInterface $response) : bool
    {
        return $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;
    }
}
