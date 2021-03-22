<?php

namespace Rector\Doctrine\Tests\Rector\Class_\TranslationBehaviorRector\Fixture;

/**
 * @ORM\Entity
 */
class SomeClassTranslation implements \RectorPrefix20210322\Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface
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
