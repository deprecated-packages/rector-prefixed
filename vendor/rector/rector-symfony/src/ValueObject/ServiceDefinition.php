<?php

declare (strict_types=1);
namespace Rector\Symfony\ValueObject;

use Rector\Symfony\Contract\Tag\TagInterface;
final class ServiceDefinition
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var bool
     */
    private $isPublic = \false;
    /**
     * @var bool
     */
    private $isSynthetic = \false;
    /**
     * @var TagInterface[]
     */
    private $tags = [];
    /**
     * @var string|null
     */
    private $class;
    /**
     * @var string|null
     */
    private $alias;
    /**
     * @param TagInterface[] $tags
     * @param string|null $class
     * @param string|null $alias
     */
    public function __construct(string $id, $class, bool $public, bool $synthetic, $alias, array $tags)
    {
        $this->id = $id;
        $this->class = $class;
        $this->isPublic = $public;
        $this->isSynthetic = $synthetic;
        $this->alias = $alias;
        $this->tags = $tags;
    }
    public function getId() : string
    {
        return $this->id;
    }
    /**
     * @return string|null
     */
    public function getClass()
    {
        return $this->class;
    }
    public function isPublic() : bool
    {
        return $this->isPublic;
    }
    public function isSynthetic() : bool
    {
        return $this->isSynthetic;
    }
    /**
     * @return string|null
     */
    public function getAlias()
    {
        return $this->alias;
    }
    /**
     * @return TagInterface[]
     */
    public function getTags() : array
    {
        return $this->tags;
    }
    /**
     * @return \Rector\Symfony\Contract\Tag\TagInterface|null
     */
    public function getTag(string $name)
    {
        foreach ($this->tags as $tag) {
            if ($tag->getName() !== $name) {
                continue;
            }
            return $tag;
        }
        return null;
    }
}
