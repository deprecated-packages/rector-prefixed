<?php

namespace Doctrine\ORM\Mapping;

if (\class_exists('Doctrine\\ORM\\Mapping\\OneToMany')) {
    return;
}
/**
 * @Annotation
 * @Target("PROPERTY")
 */
class OneToMany implements \Doctrine\ORM\Mapping\Annotation
{
    /**
     * @var string
     */
    public $mappedBy;
    /**
     * @var string
     */
    public $targetEntity;
    /**
     * @var array<string>
     */
    public $cascade;
    /**
     * The fetching strategy to use for the association.
     *
     * @var string
     *
     * @Enum({"LAZY", "EAGER", "EXTRA_LAZY"})
     */
    public $fetch = 'LAZY';
    /**
     * @var boolean
     */
    public $orphanRemoval = \false;
    /**
     * @var string
     */
    public $indexBy;
}
