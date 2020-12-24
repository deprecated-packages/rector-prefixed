<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74;

use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use _PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner;
return static function (\_PhpScoperb75b35f52b74\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\MethodCall\RenameMethodRector::METHOD_CALL_RENAMES => \_PhpScoperb75b35f52b74\Symplify\SymfonyPhpConfig\ValueObjectInliner::inline([
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecations-in-the-wrapper-connection-class
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Connection', 'executeUpdate', 'executeStatement'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Connection', 'exec', 'executeStatement'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Connection', 'query', 'executeQuery'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#driverexceptiongeterrorcode-is-deprecated
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\DriverException', 'getErrorCode', 'getSQLState'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-expressionbuilder-methods
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Query\\Expression\\ExpressionBuilder', 'andX', 'and'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Query\\Expression\\ExpressionBuilder', 'orX', 'or'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-compositeexpression-methods
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Query\\Expression\\CompositeExpression', 'add', 'with'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Query\\Expression\\CompositeExpression', 'addMultiple', 'with'),
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-fetchmode-and-the-corresponding-methods
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Connection', 'fetchAssoc', 'fetchAssociative'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Connection', 'fetchArray', 'fetchNumeric'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Connection', 'fetchColumn', 'fetchOne'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Connection', 'fetchAll', 'fetchAllAssociative'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Statement', 'fetchAssoc', 'fetchAssociative'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Statement', 'fetchColumn', 'fetchOne'),
        new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\MethodCallRename('_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Statement', 'fetchAll', 'fetchAllAssociative'),
    ])]]);
    $services->set(\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::class)->call('configure', [[\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#pdo-related-classes-outside-of-the-pdo-namespace-are-deprecated
        '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\PDOMySql\\Driver' => '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\PDO\\MySQL\\Driver',
        '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\PDOOracle\\Driver' => '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\PDO\\OCI\\Driver',
        '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\PDOPgSql\\Driver' => '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\PDO\\PgSQL\\Driver',
        '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\PDOSqlite\\Driver' => '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\PDO\\SQLite\\Driver',
        '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Driver' => '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Driver',
        '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Connection' => '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Connection',
        '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\PDOSqlsrv\\Statement' => '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\PDO\\SQLSrv\\Statement',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-dbalexception
        '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\DBALException' => '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Exception',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#inconsistently-and-ambiguously-named-driver-level-classes-are-deprecated
        '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\DriverException' => '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\Exception',
        '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\AbstractDriverException' => '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\AbstractException',
        '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Driver' => '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\IBMDB2\\Driver',
        '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Connection' => '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\IBMDB2\\Connection',
        '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\IBMDB2\\DB2Statement' => '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\IBMDB2\\Statement',
        '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\Mysqli\\MysqliConnection' => '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\Mysqli\\Connection',
        '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\Mysqli\\MysqliStatement' => '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\Mysqli\\Statement',
        '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\OCI8\\OCI8Connection' => '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\OCI8\\Connection',
        '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\OCI8\\OCI8Statement' => '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\OCI8\\Statement',
        '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\SQLSrv\\SQLSrvConnection' => '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\SQLSrv\\Connection',
        '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\SQLSrv\\SQLSrvStatement' => '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\SQLSrv\\Statement',
        '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\PDOConnection' => '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\PDO\\Connection',
        '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\PDOStatement' => '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Driver\\PDO\\Statement',
        // https://github.com/doctrine/dbal/blob/master/UPGRADE.md#deprecated-masterslaveconnection-use-primaryreadreplicaconnection
        '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Connections\\MasterSlaveConnection' => '_PhpScoperb75b35f52b74\\Doctrine\\DBAL\\Connections\\PrimaryReadReplicaConnection',
    ]]]);
};
