<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa;

use _PhpScoper0a2ac50786fa\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoper0a2ac50786fa\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoper0a2ac50786fa\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoper0a2ac50786fa\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecations-in-the-wrapper-connection-class
        new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Connection', 'executeUpdate', 'executeStatement'),
        new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Connection', 'exec', 'executeStatement'),
        new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Connection', 'query', 'executeQuery'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#driverexceptiongeterrorcode-is-deprecated
        new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\DriverException', 'getErrorCode', 'getSQLState'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-expressionbuilder-methods
        new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Query\\Expression\\ExpressionBuilder', 'andX', 'and'),
        new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Query\\Expression\\ExpressionBuilder', 'orX', 'or'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-compositeexpression-methods
        new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Query\\Expression\\CompositeExpression', 'add', 'with'),
        new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Query\\Expression\\CompositeExpression', 'addMultiple', 'with'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-fetchmode-and-the-corresponding-methods
        new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Connection', 'fetchAssoc', 'fetchAssociative'),
        new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Connection', 'fetchArray', 'fetchNumeric'),
        new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Connection', 'fetchColumn', 'fetchOne'),
        new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Connection', 'fetchAll', 'fetchAllAssociative'),
        new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Statement', 'fetchAssoc', 'fetchAssociative'),
        new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Statement', 'fetchColumn', 'fetchOne'),
        new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Statement', 'fetchAll', 'fetchAllAssociative'),
    ])]]);
    $services->set(\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#pdo-related-classes-outside-of-the-pdo-namespace-are-deprecated
        '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\PDOMySql\\Driver' => '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\PDO\\MySQL\\Driver',
        '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\PDOOracle\\Driver' => '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\PDO\\OCI\\Driver',
        '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\PDOPgSql\\Driver' => '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\PDO\\PgSQL\\Driver',
        '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\PDOSqlite\\Driver' => '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\PDO\\SQLite\\Driver',
        '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Driver' => '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Driver',
        '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Connection' => '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Connection',
        '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Statement' => '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Statement',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-dbalexception
        '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\DBALException' => '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Exception',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#inconsistently-and-ambiguously-named-driver-level-classes-are-deprecated
        '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\DriverException' => '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\Exception',
        '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\AbstractDriverException' => '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\AbstractException',
        '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Driver' => '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\IBMDB2\\Driver',
        '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Connection' => '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\IBMDB2\\Connection',
        '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Statement' => '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\IBMDB2\\Statement',
        '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\Mysqli\\MysqliConnection' => '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\Mysqli\\Connection',
        '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\Mysqli\\MysqliStatement' => '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\Mysqli\\Statement',
        '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\OCI8\\OCI8Connection' => '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\OCI8\\Connection',
        '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\OCI8\\OCI8Statement' => '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\OCI8\\Statement',
        '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\SQLSrv\\SQLSrvConnection' => '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\SQLSrv\\Connection',
        '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\SQLSrv\\SQLSrvStatement' => '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\SQLSrv\\Statement',
        '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\PDOConnection' => '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\PDO\\Connection',
        '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\PDOStatement' => '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Driver\\PDO\\Statement',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-masterslaveconnection-use-primaryreadreplicaconnection
        '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Connections\\MasterSlaveConnection' => '_PhpScoper0a2ac50786fa\\Doctrine\\DBAL\\Connections\\PrimaryReadReplicaConnection',
    ]]]);
};
