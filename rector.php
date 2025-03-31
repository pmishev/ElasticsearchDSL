<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\PHPUnit\PHPUnit100\Rector\Class_\StaticDataProviderClassMethodRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\ValueObject\PhpVersion;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    // uncomment to reach your current PHP version
    // ->withPhpSets()
    ->withPHPStanConfigs([__DIR__.'/phpstan.dist.neon'])
    ->withPreparedSets(deadCode: true, codeQuality: true, typeDeclarations: true, instanceOf: true, rectorPreset: true)
    ->withPhpVersion(PhpVersion::PHP_81)
    ->withSets([
        LevelSetList::UP_TO_PHP_81,
    ])
    ->withRules([
        // Make data provider methods static
        StaticDataProviderClassMethodRector::class,
    ])
    ->withImportNames(importShortClasses: false, removeUnusedImports: true)
;
