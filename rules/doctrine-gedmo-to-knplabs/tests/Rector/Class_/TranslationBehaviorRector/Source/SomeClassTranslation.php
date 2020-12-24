<?php

namespace _PhpScoper0a6b37af0871\Rector\DoctrineGedmoToKnplabs\Tests\Rector\Class_\TranslationBehaviorRector\Fixture;

/**
 * @ORM\Entity
 */
class SomeClassTranslation implements \_PhpScoper0a6b37af0871\Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface
{
    use \Knp\DoctrineBehaviors\Model\Translatable\TranslationTrait;
    /**
     * @ORM\Column(length=128)
     */
    private $title;
    /**
     * @ORM\Column(type="text")
     */
    private $content;
}
