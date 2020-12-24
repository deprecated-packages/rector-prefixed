<?php

namespace _PhpScopere8e811afab72\Rector\DoctrineGedmoToKnplabs\Tests\Rector\Class_\TranslationBehaviorRector\Fixture;

/**
 * @ORM\Entity
 */
class SomeClassTranslation implements \_PhpScopere8e811afab72\Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface
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
