<?php

declare (strict_types=1);
namespace RectorPrefix20210504\App\Playground;

use RectorPrefix20210504\GuzzleHttp\Promise\PromiseInterface;
class PlaygroundExample
{
    private string $url;
    private string $hash;
    /** @var string[] */
    private array $users;
    private \RectorPrefix20210504\GuzzleHttp\Promise\PromiseInterface $resultPromise;
    public function __construct(string $url, string $hash, string $user, \RectorPrefix20210504\GuzzleHttp\Promise\PromiseInterface $resultPromise)
    {
        $this->url = $url;
        $this->hash = $hash;
        $this->users = [$user];
        $this->resultPromise = $resultPromise;
    }
    public function getUrl() : string
    {
        return $this->url;
    }
    public function getHash() : string
    {
        return $this->hash;
    }
    /**
     * @return string[]
     */
    public function getUsers() : array
    {
        return $this->users;
    }
    public function addUser(string $user) : void
    {
        $users = $this->users;
        $users[] = $user;
        $this->users = \array_values(\array_unique($users));
    }
    public function getResultPromise() : \RectorPrefix20210504\GuzzleHttp\Promise\PromiseInterface
    {
        return $this->resultPromise;
    }
}
