<?php

declare (strict_types=1);
namespace RectorPrefix20210504\App\Playground;

use RectorPrefix20210504\GuzzleHttp\Client;
use RectorPrefix20210504\GuzzleHttp\Promise\PromiseInterface;
use RectorPrefix20210504\Nette\Utils\Json;
use RectorPrefix20210504\Psr\Http\Message\ResponseInterface;
class PlaygroundClient
{
    private \RectorPrefix20210504\GuzzleHttp\Client $client;
    public function __construct(\RectorPrefix20210504\GuzzleHttp\Client $client)
    {
        $this->client = $client;
    }
    public function getResultPromise(string $hash, string $user) : \RectorPrefix20210504\GuzzleHttp\Promise\PromiseInterface
    {
        $response = $this->client->getAsync(\sprintf('https://api.phpstan.org/result?id=%s', $hash));
        return $response->then(static function (\RectorPrefix20210504\Psr\Http\Message\ResponseInterface $response) use($hash, $user) : PlaygroundResult {
            $body = (string) $response->getBody();
            $json = \RectorPrefix20210504\Nette\Utils\Json::decode($body, \RectorPrefix20210504\Nette\Utils\Json::FORCE_ARRAY);
            $convert = static function (array $tab) : PlaygroundResultTab {
                return new \RectorPrefix20210504\App\Playground\PlaygroundResultTab($tab['title'], \array_map(static function (array $error) : PlaygroundResultError {
                    return new \RectorPrefix20210504\App\Playground\PlaygroundResultError($error['message'], $error['line'] ?? -1);
                }, $tab['errors']));
            };
            return new \RectorPrefix20210504\App\Playground\PlaygroundResult($hash, [$user], \array_map($convert, $json['tabs'] ?? [['title' => 'PHP 7.4', 'errors' => $json['errors']]]), \array_map($convert, $json['upToDateTabs']));
        });
    }
}
