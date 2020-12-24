<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72;

use _PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScopere8e811afab72\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScopere8e811afab72\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecations-in-the-wrapper-connection-class
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Doctrine\\DBAL\\Connection', 'executeUpdate', 'executeStatement'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Doctrine\\DBAL\\Connection', 'exec', 'executeStatement'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Doctrine\\DBAL\\Connection', 'query', 'executeQuery'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#driverexceptiongeterrorcode-is-deprecated
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\DriverException', 'getErrorCode', 'getSQLState'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-expressionbuilder-methods
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Doctrine\\DBAL\\Query\\Expression\\ExpressionBuilder', 'andX', 'and'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Doctrine\\DBAL\\Query\\Expression\\ExpressionBuilder', 'orX', 'or'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-compositeexpression-methods
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Doctrine\\DBAL\\Query\\Expression\\CompositeExpression', 'add', 'with'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Doctrine\\DBAL\\Query\\Expression\\CompositeExpression', 'addMultiple', 'with'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-fetchmode-and-the-corresponding-methods
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Doctrine\\DBAL\\Connection', 'fetchAssoc', 'fetchAssociative'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Doctrine\\DBAL\\Connection', 'fetchArray', 'fetchNumeric'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Doctrine\\DBAL\\Connection', 'fetchColumn', 'fetchOne'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Doctrine\\DBAL\\Connection', 'fetchAll', 'fetchAllAssociative'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Doctrine\\DBAL\\Statement', 'fetchAssoc', 'fetchAssociative'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Doctrine\\DBAL\\Statement', 'fetchColumn', 'fetchOne'),
        new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\MethodCallRename('_PhpScopere8e811afab72\\Doctrine\\DBAL\\Statement', 'fetchAll', 'fetchAllAssociative'),
    ])]]);
    $services->set(\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#pdo-related-classes-outside-of-the-pdo-namespace-are-deprecated
        '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\PDOMySql\\Driver' => '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\PDO\\MySQL\\Driver',
        '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\PDOOracle\\Driver' => '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\PDO\\OCI\\Driver',
        '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\PDOPgSql\\Driver' => '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\PDO\\PgSQL\\Driver',
        '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\PDOSqlite\\Driver' => '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\PDO\\SQLite\\Driver',
        '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Driver' => '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Driver',
        '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Connection' => '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Connection',
        '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Statement' => '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Statement',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-dbalexception
        '_PhpScopere8e811afab72\\Doctrine\\DBAL\\DBALException' => '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Exception',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#inconsistently-and-ambiguously-named-driver-level-classes-are-deprecated
        '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\DriverException' => '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\Exception',
        '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\AbstractDriverException' => '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\AbstractException',
        '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Driver' => '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\IBMDB2\\Driver',
        '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Connection' => '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\IBMDB2\\Connection',
        '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Statement' => '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\IBMDB2\\Statement',
        '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\Mysqli\\MysqliConnection' => '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\Mysqli\\Connection',
        '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\Mysqli\\MysqliStatement' => '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\Mysqli\\Statement',
        '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\OCI8\\OCI8Connection' => '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\OCI8\\Connection',
        '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\OCI8\\OCI8Statement' => '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\OCI8\\Statement',
        '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\SQLSrv\\SQLSrvConnection' => '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\SQLSrv\\Connection',
        '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\SQLSrv\\SQLSrvStatement' => '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\SQLSrv\\Statement',
        '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\PDOConnection' => '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\PDO\\Connection',
        '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\PDOStatement' => '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Driver\\PDO\\Statement',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-masterslaveconnection-use-primaryreadreplicaconnection
        '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Connections\\MasterSlaveConnection' => '_PhpScopere8e811afab72\\Doctrine\\DBAL\\Connections\\PrimaryReadReplicaConnection',
    ]]]);
};
