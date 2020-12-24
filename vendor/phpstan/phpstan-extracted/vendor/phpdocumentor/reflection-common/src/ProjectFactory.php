<?php

declare (strict_types=1);
/**
 * phpDocumentor
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @link      http://phpdoc.org
 */
namespace _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection;

/**
 * Interface for project factories. A project factory shall convert a set of files
 * into an object implementing the Project interface.
 */
interface ProjectFactory
{
    /**
     * Creates a project from the set of files.
     *
     * @param File[] $files
     */
    public function create(string $name, array $files) : \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Project;
}
