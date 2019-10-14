#!/usr/bin/env php
<?php

$rules = [
    '@PSR2' => true,
    '@PhpCsFixer' => true,
    'concat_space' => ['spacing' => 'one'],
    'increment_style' => false,
    'new_with_braces' => false,
    'ordered_class_elements' => [
        'order' => [
            'use_trait',
            'property_public_static',
            'property_protected_static',
            'property_private_static',
            'constant_public',
            'constant_protected',
            'constant_private',
            'property_public',
            'property_protected',
            'property_private',
            'construct',
            'destruct',
            'method_public',
            'method_protected',
            'method_private',
            'magic',
        ]
    ],
    'ordered_imports' => [
        'sort_algorithm' => 'length',
    ],
    'phpdoc_add_missing_param_annotation' => false,
    'phpdoc_align' => false,
    'phpdoc_annotation_without_dot' => false,
    'phpdoc_indent' => false,
    'phpdoc_inline_tag' => false,
    'phpdoc_no_access' => false,
    'phpdoc_no_alias_tag' => false,
    'phpdoc_no_empty_return' => false,
    'phpdoc_no_package' => false,
    'phpdoc_no_useless_inheritdoc' => false,
    'phpdoc_order' => false,
    'phpdoc_return_self_reference' => false,
    'phpdoc_scalar' => false,
    'phpdoc_separation' => false,
    'phpdoc_single_line_var_spacing' => false,
    'phpdoc_summary' => false,
    'phpdoc_to_comment' => false,
    'phpdoc_trim' => false,
    'phpdoc_trim_consecutive_blank_line_separation' => false,
    'phpdoc_types' => false,
    'phpdoc_types_order' => false,
    'phpdoc_var_annotation_correct_order' => false,
    'phpdoc_var_without_name' => false,
    'single_trait_insert_per_statement' => false,
    'unary_operator_spaces' => false,
    'yoda_style' => false,
];

$excludes = [
    'bootstrap/cache',
    'config',
    'node_modules',
    'public',
    'resources',
    'storage',
    'vendor',
];

$finder = PhpCsFixer\Finder::create()
    ->exclude($excludes)
    ->in(__DIR__)
    ->files()
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return PhpCsFixer\Config::create()
    ->setUsingCache(false)
    ->setRiskyAllowed(false)
    ->setLineEnding(PHP_EOL)
    ->setRules($rules)
    ->setFinder($finder);
