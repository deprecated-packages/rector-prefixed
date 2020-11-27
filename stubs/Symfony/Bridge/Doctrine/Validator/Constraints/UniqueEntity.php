<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Symfony\Bridge\Doctrine\Validator\Constraints;

use _PhpScoper006a73f0e455\Symfony\Component\Validator\Constraint;
if (\class_exists('_PhpScoper006a73f0e455\\Symfony\\Bridge\\Doctrine\\Validator\\Constraints\\UniqueEntity')) {
    return;
}
/**
 * @Annotation
 * @Target({"CLASS", "ANNOTATION"})
 */
class UniqueEntity extends \_PhpScoper006a73f0e455\Symfony\Component\Validator\Constraint
{
    const NOT_UNIQUE_ERROR = '23bd9dbf-6b9b-41cd-a99e-4844bcf3077f';
    public $message = 'This value is already used.';
    public $service = 'doctrine.orm.validator.unique';
    public $em = null;
    public $entityClass = null;
    public $repositoryMethod = 'findBy';
    public $fields = [];
    public $errorPath = null;
    public $ignoreNull = \true;
    protected static $errorNames = [self::NOT_UNIQUE_ERROR => 'NOT_UNIQUE_ERROR'];
    public function getRequiredOptions()
    {
        return ['fields'];
    }
    /**
     * The validator must be defined as a service with this name.
     *
     * @return string
     */
    public function validatedBy()
    {
        return $this->service;
    }
    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
    public function getDefaultOption()
    {
        return 'fields';
    }
}
