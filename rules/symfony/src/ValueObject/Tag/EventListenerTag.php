<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Symfony\ValueObject\Tag;

use _PhpScoper0a6b37af0871\Rector\Symfony\Contract\Tag\TagInterface;
final class EventListenerTag implements \_PhpScoper0a6b37af0871\Rector\Symfony\Contract\Tag\TagInterface
{
    /**
     * @var string
     */
    private $event;
    /**
     * @var string
     */
    private $method;
    /**
     * @var int
     */
    private $priority;
    public function __construct(string $event, string $method, int $priority)
    {
        $this->event = $event;
        $this->method = $method;
        $this->priority = $priority;
    }
    public function getName() : string
    {
        return 'kernel.event_listener';
    }
    public function getEvent() : string
    {
        return $this->event;
    }
    public function getMethod() : string
    {
        return $this->method;
    }
    public function getPriority() : int
    {
        return $this->priority;
    }
    /**
     * @return array<string, mixed>
     */
    public function getData() : array
    {
        return ['method' => $this->method, 'priority' => $this->priority, 'event' => $this->event];
    }
}
