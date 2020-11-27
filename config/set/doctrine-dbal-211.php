<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecations-in-the-wrapper-connection-class
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Connection', 'executeUpdate', 'executeStatement'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Connection', 'exec', 'executeStatement'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Connection', 'query', 'executeQuery'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#driverexceptiongeterrorcode-is-deprecated
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\DriverException', 'getErrorCode', 'getSQLState'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-expressionbuilder-methods
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Query\\Expression\\ExpressionBuilder', 'andX', 'and'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Query\\Expression\\ExpressionBuilder', 'orX', 'or'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-compositeexpression-methods
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Query\\Expression\\CompositeExpression', 'add', 'with'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Query\\Expression\\CompositeExpression', 'addMultiple', 'with'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-fetchmode-and-the-corresponding-methods
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Connection', 'fetchAssoc', 'fetchAssociative'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Connection', 'fetchArray', 'fetchNumeric'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Connection', 'fetchColumn', 'fetchOne'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Connection', 'fetchAll', 'fetchAllAssociative'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Statement', 'fetchAssoc', 'fetchAssociative'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Statement', 'fetchColumn', 'fetchOne'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Statement', 'fetchAll', 'fetchAllAssociative'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#pdo-related-classes-outside-of-the-pdo-namespace-are-deprecated
        '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\PDOMySql\\Driver' => '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\PDO\\MySQL\\Driver',
        '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\PDOOracle\\Driver' => '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\PDO\\OCI\\Driver',
        '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\PDOPgSql\\Driver' => '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\PDO\\PgSQL\\Driver',
        '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\PDOSqlite\\Driver' => '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\PDO\\SQLite\\Driver',
        '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Driver' => '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Driver',
        '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Connection' => '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Connection',
        '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Statement' => '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Statement',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-dbalexception
        '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\DBALException' => '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Exception',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#inconsistently-and-ambiguously-named-driver-level-classes-are-deprecated
        '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\DriverException' => '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\Exception',
        '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\AbstractDriverException' => '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\AbstractException',
        '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Driver' => '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\IBMDB2\\Driver',
        '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Connection' => '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\IBMDB2\\Connection',
        '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Statement' => '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\IBMDB2\\Statement',
        '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\Mysqli\\MysqliConnection' => '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\Mysqli\\Connection',
        '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\Mysqli\\MysqliStatement' => '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\Mysqli\\Statement',
        '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\OCI8\\OCI8Connection' => '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\OCI8\\Connection',
        '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\OCI8\\OCI8Statement' => '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\OCI8\\Statement',
        '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\SQLSrv\\SQLSrvConnection' => '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\SQLSrv\\Connection',
        '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\SQLSrv\\SQLSrvStatement' => '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\SQLSrv\\Statement',
        '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\PDOConnection' => '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\PDO\\Connection',
        '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\PDOStatement' => '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Driver\\PDO\\Statement',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-masterslaveconnection-use-primaryreadreplicaconnection
        '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Connections\\MasterSlaveConnection' => '_PhpScopera143bcca66cb\\Doctrine\\DBAL\\Connections\\PrimaryReadReplicaConnection',
    ]]]);
};
