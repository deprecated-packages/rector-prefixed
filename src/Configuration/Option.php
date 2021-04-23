<?php

declare (strict_types=1);
namespace Rector\Core\Configuration;

use RectorPrefix20210423\Symplify\Skipper\ValueObject\Option as SkipperOption;
final class Option
{
    /**
     * @var string
     */
    const SOURCE = 'source';
    /**
     * @var string
     */
    const OPTION_AUTOLOAD_FILE = 'autoload-file';
    /**
     * @var string
     */
    const BOOTSTRAP_FILES = 'bootstrap_files';
    /**
     * @var string
     */
    const OPTION_DRY_RUN = 'dry-run';
    /**
     * @var string
     */
    const OPTION_OUTPUT_FORMAT = 'output-format';
    /**
     * @var string
     */
    const OPTION_NO_PROGRESS_BAR = 'no-progress-bar';
    /**
     * @var string
     */
    const PHP_VERSION_FEATURES = 'php_version_features';
    /**
     * @var string
     */
    const AUTO_IMPORT_NAMES = 'auto_import_names';
    /**
     * @var string
     */
    const IMPORT_SHORT_CLASSES = 'import_short_classes';
    /**
     * @var string
     */
    const IMPORT_DOC_BLOCKS = 'import_doc_blocks';
    /**
     * @var string
     */
    const SYMFONY_CONTAINER_XML_PATH_PARAMETER = 'symfony_container_xml_path';
    /**
     * @var string
     */
    const OPTION_OUTPUT_FILE = 'output-file';
    /**
     * @var string
     */
    const OPTION_CLEAR_CACHE = 'clear-cache';
    /**
     * @var string
     */
    const ENABLE_CACHE = 'enable_cache';
    /**
     * @var string
     */
    const CACHE_DEBUG = 'cache-debug';
    /**
     * @var string
     */
    const PROJECT_TYPE = 'project_type';
    /**
     * @var string
     */
    const PATHS = 'paths';
    /**
     * @var string
     */
    const AUTOLOAD_PATHS = 'autoload_paths';
    /**
     * @var string
     */
    const SETS = 'sets';
    /**
     * @var string
     */
    const SKIP = \RectorPrefix20210423\Symplify\Skipper\ValueObject\Option::SKIP;
    /**
     * @var string
     */
    const FILE_EXTENSIONS = 'file_extensions';
    /**
     * @var string
     */
    const NESTED_CHAIN_METHOD_CALL_LIMIT = 'nested_chain_method_call_limit';
    /**
     * @var string
     */
    const CACHE_DIR = 'cache_dir';
    /**
     * @var string
     */
    const OPTION_DEBUG = 'debug';
    /**
     * @var string
     */
    const XDEBUG = 'xdebug';
    /**
     * @var string
     */
    const OPTION_CONFIG = 'config';
    /**
     * @var string
     */
    const FIX = 'fix';
    /**
     * @var string
     */
    const PHPSTAN_FOR_RECTOR_PATH = 'phpstan_for_rector_path';
    /**
     * @var string
     */
    const TYPES_TO_REMOVE_STATIC_FROM = 'types_to_remove_static_from';
    /**
     * @var string
     */
    const OPTION_NO_DIFFS = 'no-diffs';
}
