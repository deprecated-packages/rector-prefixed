<?php

namespace Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceEventManagerWithEventSubscriberRector\Fixture\Event;

final class SomeClassCopyEvent extends \_PhpScoper5b8c9e9ebd21\Symfony\Contracts\EventDispatcher\Event
{
    /**
     * @var \Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceEventManagerWithEventSubscriberRector\Fixture\SomeClass
     */
    private $someClass;
    /**
     * @var string
     */
    private $key;
    public function __construct(\Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceEventManagerWithEventSubscriberRector\Fixture\SomeClass $someClass, string $key)
    {
        $this->someClass = $someClass;
        $this->key = $key;
    }
    public function getSomeClass() : \Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceEventManagerWithEventSubscriberRector\Fixture\SomeClass
    {
        return $this->someClass;
    }
    public function getKey() : string
    {
        return $this->key;
    }
}
