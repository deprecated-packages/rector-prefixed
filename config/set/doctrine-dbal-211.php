<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d;

use Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use Rector\Renaming\Rector\Name\RenameClassRector;
use Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperbf340cb0be9d\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecations-in-the-wrapper-connection-class
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Connection', 'executeUpdate', 'executeStatement'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Connection', 'exec', 'executeStatement'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Connection', 'query', 'executeQuery'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#driverexceptiongeterrorcode-is-deprecated
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\DriverException', 'getErrorCode', 'getSQLState'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-expressionbuilder-methods
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Query\\Expression\\ExpressionBuilder', 'andX', 'and'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Query\\Expression\\ExpressionBuilder', 'orX', 'or'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-compositeexpression-methods
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Query\\Expression\\CompositeExpression', 'add', 'with'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Query\\Expression\\CompositeExpression', 'addMultiple', 'with'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-fetchmode-and-the-corresponding-methods
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Connection', 'fetchAssoc', 'fetchAssociative'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Connection', 'fetchArray', 'fetchNumeric'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Connection', 'fetchColumn', 'fetchOne'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Connection', 'fetchAll', 'fetchAllAssociative'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Statement', 'fetchAssoc', 'fetchAssociative'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Statement', 'fetchColumn', 'fetchOne'),
        new \Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Statement', 'fetchAll', 'fetchAllAssociative'),
    ])]]);
    $services->set(\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#pdo-related-classes-outside-of-the-pdo-namespace-are-deprecated
        '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\PDOMySql\\Driver' => '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\PDO\\MySQL\\Driver',
        '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\PDOOracle\\Driver' => '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\PDO\\OCI\\Driver',
        '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\PDOPgSql\\Driver' => '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\PDO\\PgSQL\\Driver',
        '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\PDOSqlite\\Driver' => '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\PDO\\SQLite\\Driver',
        '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Driver' => '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Driver',
        '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Connection' => '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Connection',
        '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Statement' => '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Statement',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-dbalexception
        '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\DBALException' => '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Exception',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#inconsistently-and-ambiguously-named-driver-level-classes-are-deprecated
        '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\DriverException' => '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\Exception',
        '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\AbstractDriverException' => '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\AbstractException',
        '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Driver' => '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\IBMDB2\\Driver',
        '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Connection' => '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\IBMDB2\\Connection',
        '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Statement' => '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\IBMDB2\\Statement',
        '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\Mysqli\\MysqliConnection' => '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\Mysqli\\Connection',
        '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\Mysqli\\MysqliStatement' => '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\Mysqli\\Statement',
        '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\OCI8\\OCI8Connection' => '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\OCI8\\Connection',
        '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\OCI8\\OCI8Statement' => '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\OCI8\\Statement',
        '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\SQLSrv\\SQLSrvConnection' => '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\SQLSrv\\Connection',
        '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\SQLSrv\\SQLSrvStatement' => '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\SQLSrv\\Statement',
        '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\PDOConnection' => '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\PDO\\Connection',
        '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\PDOStatement' => '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Driver\\PDO\\Statement',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-masterslaveconnection-use-primaryreadreplicaconnection
        '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Connections\\MasterSlaveConnection' => '_PhpScoperbf340cb0be9d\\Doctrine\\DBAL\\Connections\\PrimaryReadReplicaConnection',
    ]]]);
};
