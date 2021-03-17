<?php

declare (strict_types=1);
namespace Rector\Symfony\ValueObject;

use Rector\Symfony\Contract\Tag\TagInterface;
final class Tag implements \Rector\Symfony\Contract\Tag\TagInterface
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var array<string, mixed>
     */
    private $data = [];
    /**
     * @param array<string, mixed> $data
     * @param string $name
     */
    public function __construct($name, $data = [])
    {
        $this->name = $name;
        $this->data = $data;
    }
    public function getName() : string
    {
        return $this->name;
    }
    /**
     * @return array<string, mixed>
     */
    public function getData() : array
    {
        return $this->data;
    }
}
