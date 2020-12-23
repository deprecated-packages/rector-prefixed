<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Http;

use _PhpScoper0a2ac50786fa\GuzzleHttp\ClientInterface;
use _PhpScoper0a2ac50786fa\GuzzleHttp\Exception\BadResponseException;
use _PhpScoper0a2ac50786fa\GuzzleHttp\Psr7\Request;
use _PhpScoper0a2ac50786fa\Nette\Utils\Json;
use _PhpScoper0a2ac50786fa\Nette\Utils\JsonException;
use _PhpScoper0a2ac50786fa\Psr\Http\Message\ResponseInterface;
final class BetterGuzzleClient
{
    /**
     * @var ClientInterface
     */
    private $client;
    public function __construct(\_PhpScoper0a2ac50786fa\GuzzleHttp\ClientInterface $client)
    {
        $this->client = $client;
    }
    /**
     * @api
     * @return mixed[]|mixed|void
     */
    public function requestToJson(string $url) : array
    {
        $request = new \_PhpScoper0a2ac50786fa\GuzzleHttp\Psr7\Request('GET', $url);
        $response = $this->client->send($request);
        if (!$this->isSuccessCode($response)) {
            throw \_PhpScoper0a2ac50786fa\GuzzleHttp\Exception\BadResponseException::create($request, $response);
        }
        $content = (string) $response->getBody();
        if ($content === '') {
            return [];
        }
        try {
            return \_PhpScoper0a2ac50786fa\Nette\Utils\Json::decode($content, \_PhpScoper0a2ac50786fa\Nette\Utils\Json::FORCE_ARRAY);
        } catch (\_PhpScoper0a2ac50786fa\Nette\Utils\JsonException $jsonException) {
            throw new \_PhpScoper0a2ac50786fa\Nette\Utils\JsonException('Syntax error while decoding:' . $content, $jsonException->getLine(), $jsonException);
        }
    }
    private function isSuccessCode(\_PhpScoper0a2ac50786fa\Psr\Http\Message\ResponseInterface $response) : bool
    {
        return $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;
    }
}
