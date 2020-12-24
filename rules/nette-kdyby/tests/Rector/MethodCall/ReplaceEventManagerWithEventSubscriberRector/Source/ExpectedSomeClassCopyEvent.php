<?php

namespace _PhpScoper0a6b37af0871\Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceEventManagerWithEventSubscriberRector\Fixture\Event;

final class SomeClassCopyEvent extends \_PhpScoper0a6b37af0871\Symfony\Contracts\EventDispatcher\Event
{
    /**
     * @var \Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceEventManagerWithEventSubscriberRector\Fixture\SomeClass
     */
    private $someClass;
    /**
     * @var string
     */
    private $key;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceEventManagerWithEventSubscriberRector\Fixture\SomeClass $someClass, string $key)
    {
        $this->someClass = $someClass;
        $this->key = $key;
    }
    public function getSomeClass() : \_PhpScoper0a6b37af0871\Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceEventManagerWithEventSubscriberRector\Fixture\SomeClass
    {
        return $this->someClass;
    }
    public function getKey() : string
    {
        return $this->key;
    }
}
