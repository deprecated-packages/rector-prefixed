<?php

declare (strict_types=1);
namespace Rector\Php80\ValueObject;

final class AnnotationToAttribute
{
    /**
     * @var string
     */
    private $tag;
    /**
     * @var string
     */
    private $attributeClass;
    public function __construct(string $tag, string $attributeClass)
    {
        $this->tag = $tag;
        $this->attributeClass = $attributeClass;
    }
    /**
     * @return class-string|string
     */
    public function getTag() : string
    {
        return $this->tag;
    }
    /**
     * @return class-string
     */
    public function getAttributeClass() : string
    {
        return $this->attributeClass;
    }
}
