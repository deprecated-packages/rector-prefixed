<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Http;

use _PhpScoperb75b35f52b74\GuzzleHttp\ClientInterface;
use _PhpScoperb75b35f52b74\GuzzleHttp\Exception\BadResponseException;
use _PhpScoperb75b35f52b74\GuzzleHttp\Psr7\Request;
use _PhpScoperb75b35f52b74\Nette\Utils\Json;
use _PhpScoperb75b35f52b74\Nette\Utils\JsonException;
use _PhpScoperb75b35f52b74\Psr\Http\Message\ResponseInterface;
final class BetterGuzzleClient
{
    /**
     * @var ClientInterface
     */
    private $client;
    public function __construct(\_PhpScoperb75b35f52b74\GuzzleHttp\ClientInterface $client)
    {
        $this->client = $client;
    }
    /**
     * @api
     * @return mixed[]|mixed|void
     */
    public function requestToJson(string $url) : array
    {
        $request = new \_PhpScoperb75b35f52b74\GuzzleHttp\Psr7\Request('GET', $url);
        $response = $this->client->send($request);
        if (!$this->isSuccessCode($response)) {
            throw \_PhpScoperb75b35f52b74\GuzzleHttp\Exception\BadResponseException::create($request, $response);
        }
        $content = (string) $response->getBody();
        if ($content === '') {
            return [];
        }
        try {
            return \_PhpScoperb75b35f52b74\Nette\Utils\Json::decode($content, \_PhpScoperb75b35f52b74\Nette\Utils\Json::FORCE_ARRAY);
        } catch (\_PhpScoperb75b35f52b74\Nette\Utils\JsonException $jsonException) {
            throw new \_PhpScoperb75b35f52b74\Nette\Utils\JsonException('Syntax error while decoding:' . $content, $jsonException->getLine(), $jsonException);
        }
    }
    private function isSuccessCode(\_PhpScoperb75b35f52b74\Psr\Http\Message\ResponseInterface $response) : bool
    {
        return $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;
    }
}
