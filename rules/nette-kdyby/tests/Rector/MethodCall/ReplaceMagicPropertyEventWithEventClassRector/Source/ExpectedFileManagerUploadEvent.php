<?php

namespace _PhpScoperb75b35f52b74\Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector\Fixture\Event;

final class FileManagerUploadEvent extends \_PhpScoperb75b35f52b74\Symfony\Contracts\EventDispatcher\Event
{
    /**
     * @var \Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector\Source\SomeUser
     */
    private $user;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector\Source\SomeUser $user)
    {
        $this->user = $user;
    }
    public function getUser() : \_PhpScoperb75b35f52b74\Rector\NetteKdyby\Tests\Rector\MethodCall\ReplaceMagicPropertyEventWithEventClassRector\Source\SomeUser
    {
        return $this->user;
    }
}
