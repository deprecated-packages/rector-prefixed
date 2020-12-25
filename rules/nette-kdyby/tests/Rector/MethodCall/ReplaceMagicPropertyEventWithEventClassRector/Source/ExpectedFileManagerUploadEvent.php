<?php

namespace Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector\Fixture\Event;

final class FileManagerUploadEvent extends \_PhpScoper17db12703726\Symfony\Contracts\EventDispatcher\Event
{
    /**
     * @var \Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector\Source\SomeUser
     */
    private $user;
    public function __construct(\Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector\Source\SomeUser $user)
    {
        $this->user = $user;
    }
    public function getUser() : \Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector\Source\SomeUser
    {
        return $this->user;
    }
}
