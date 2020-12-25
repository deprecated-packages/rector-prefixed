<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\AnnotationReader;

use _PhpScoperbf340cb0be9d\Doctrine\Common\Annotations\AnnotationReader;
use _PhpScoperbf340cb0be9d\Doctrine\Common\Annotations\AnnotationRegistry;
use _PhpScoperbf340cb0be9d\Doctrine\Common\Annotations\DocParser;
use _PhpScoperbf340cb0be9d\Doctrine\Common\Annotations\Reader;
use Rector\DoctrineAnnotationGenerated\ConstantPreservingAnnotationReader;
use Rector\DoctrineAnnotationGenerated\ConstantPreservingDocParser;
final class AnnotationReaderFactory
{
    /**
     * @var string[]
     */
    private const IGNORED_NAMES = [
        '_PhpScoperbf340cb0be9d\\ORM\\GeneratedValue',
        'GeneratedValue',
        '_PhpScoperbf340cb0be9d\\ORM\\InheritanceType',
        'InheritanceType',
        '_PhpScoperbf340cb0be9d\\ORM\\OrderBy',
        'OrderBy',
        '_PhpScoperbf340cb0be9d\\ORM\\DiscriminatorMap',
        'DiscriminatorMap',
        '_PhpScoperbf340cb0be9d\\ORM\\UniqueEntity',
        'UniqueEntity',
        '_PhpScoperbf340cb0be9d\\Gedmo\\SoftDeleteable',
        'SoftDeleteable',
        '_PhpScoperbf340cb0be9d\\Gedmo\\Slug',
        'Slug',
        '_PhpScoperbf340cb0be9d\\Gedmo\\SoftDeleteable',
        'SoftDeleteable',
        '_PhpScoperbf340cb0be9d\\Gedmo\\Blameable',
        'Blameable',
        '_PhpScoperbf340cb0be9d\\Gedmo\\Versioned',
        'Versioned',
        // nette @inject dummy annotation
        'inject',
    ];
    public function create() : \_PhpScoperbf340cb0be9d\Doctrine\Common\Annotations\Reader
    {
        \_PhpScoperbf340cb0be9d\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');
        // generated
        $annotationReader = $this->createAnnotationReader();
        // without this the reader will try to resolve them and fails with an exception
        // don't forget to add it to "stubs/Doctrine/Empty" directory, because the class needs to exists
        // and run "composer dump-autoload", because the directory is loaded by classmap
        foreach (self::IGNORED_NAMES as $ignoredName) {
            $annotationReader::addGlobalIgnoredName($ignoredName);
        }
        // warning: nested tags must be parse-able, e.g. @ORM\Table must include @ORM\UniqueConstraint!
        return $annotationReader;
    }
    /**
     * @return AnnotationReader|ConstantPreservingAnnotationReader
     */
    private function createAnnotationReader() : \_PhpScoperbf340cb0be9d\Doctrine\Common\Annotations\Reader
    {
        // these 2 classes are generated by "bin/rector sync-annotation-parser" command
        if (\class_exists(\Rector\DoctrineAnnotationGenerated\ConstantPreservingAnnotationReader::class) && \class_exists(\Rector\DoctrineAnnotationGenerated\ConstantPreservingDocParser::class)) {
            $constantPreservingDocParser = new \Rector\DoctrineAnnotationGenerated\ConstantPreservingDocParser();
            return new \Rector\DoctrineAnnotationGenerated\ConstantPreservingAnnotationReader($constantPreservingDocParser);
        }
        // fallback for testing incompatibilities
        return new \_PhpScoperbf340cb0be9d\Doctrine\Common\Annotations\AnnotationReader(new \_PhpScoperbf340cb0be9d\Doctrine\Common\Annotations\DocParser());
    }
}
