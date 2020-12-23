<?php

namespace _PhpScoper0a2ac50786fa\Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector\Fixture\Event;

final class FileManagerUploadEvent extends \_PhpScoper0a2ac50786fa\Symfony\Contracts\EventDispatcher\Event
{
    /**
     * @var \Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector\Source\SomeUser
     */
    private $user;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector\Source\SomeUser $user)
    {
        $this->user = $user;
    }
    public function getUser() : \_PhpScoper0a2ac50786fa\Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector\Source\SomeUser
    {
        return $this->user;
    }
}
