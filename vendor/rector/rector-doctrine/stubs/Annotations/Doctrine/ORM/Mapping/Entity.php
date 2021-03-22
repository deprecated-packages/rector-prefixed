<?php

namespace Doctrine\ORM\Mapping;

if (\class_exists('Doctrine\\ORM\\Mapping\\Entity')) {
    return;
}
/**
 * @Annotation
 * @Target("CLASS")
 */
class Entity implements \Doctrine\ORM\Mapping\Annotation
{
    /**
     * @var string
     */
    public $repositoryClass;
    /**
     * @var boolean
     */
    public $readOnly = \false;
}
