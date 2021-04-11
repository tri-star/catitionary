<?php
$finder = PhpCsFixer\Finder::create()
    ->name('*.php')
    ->notName('_ide_helper.php')
    ->exclude('node_modules')    // ここから除外フォルダー
    ->exclude('vendor')
    ->exclude('storage')
    ->exclude('data')
    ->exclude('bootstrap/cache')
    ->in(__DIR__);
return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,
        'ordered_imports' => true,
        'binary_operator_spaces' =>  [
            'operators' => [
                '=>' => 'align',
                '=' => null,
            ],
        ],
        'single_quote' => true,
        'trailing_comma_in_multiline_array' => true,
    ])
    ->setUsingCache(false)
    ->setFinder($finder);
