<?php

namespace _PhpScopere8e811afab72\Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceEventManagerWithEventSubscriberRector\Fixture\Event;

final class SomeClassCopyEvent extends \_PhpScopere8e811afab72\Symfony\Contracts\EventDispatcher\Event
{
    /**
     * @var \Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceEventManagerWithEventSubscriberRector\Fixture\SomeClass
     */
    private $someClass;
    /**
     * @var string
     */
    private $key;
    public function __construct(\_PhpScopere8e811afab72\Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceEventManagerWithEventSubscriberRector\Fixture\SomeClass $someClass, string $key)
    {
        $this->someClass = $someClass;
        $this->key = $key;
    }
    public function getSomeClass() : \_PhpScopere8e811afab72\Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceEventManagerWithEventSubscriberRector\Fixture\SomeClass
    {
        return $this->someClass;
    }
    public function getKey() : string
    {
        return $this->key;
    }
}
