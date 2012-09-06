<?php

use Symfony\CS\FixerInterface;

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->notName('LICENSE')
    ->notName('readme.md')
    ->notName('.php_cs')
    ->notName('.travis.yml')
    ->notName('build.xml')
    ->notName('pom.xml')
    ->notName('composer.*')
    ->notName('phpunit.xml*')
    ->notName('*.phar')
    ->exclude('Resources')
    ->exclude('vendor')
    ->exclude('Tests')
    ->in(__DIR__)
;

return Symfony\CS\Config\Config::create()
    ->finder($finder)
;