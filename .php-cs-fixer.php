<?php

$finder = (new PhpCsFixer\Finder())
    ->ignoreDotFiles(false)
    ->ignoreVCSIgnored(true)
    ->in(__DIR__);

return (new PhpCsFixer\Config())
    ->setFinder($finder);
