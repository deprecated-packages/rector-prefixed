<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Symfony\ValueObject;

use _PhpScopere8e811afab72\Rector\Symfony\Contract\Tag\TagInterface;
final class Tag implements \_PhpScopere8e811afab72\Rector\Symfony\Contract\Tag\TagInterface
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
     */
    public function __construct(string $name, array $data = [])
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
