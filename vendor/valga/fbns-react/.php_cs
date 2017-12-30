<?php

return \PhpCsFixer\Config::create()
    ->setFinder(
        \PhpCsFixer\Finder::create()
            ->in('src')
    )
    ->setRules([
        '@Symfony'                            => true,
        // Override @Symfony rules
        'pre_increment'                       => false,
        'blank_line_before_statement'         => ['statements' => ['return']],
        'phpdoc_align'                        => ['tags' => ['param', 'throws']],
        'phpdoc_annotation_without_dot'       => false,
        // Custom rules
        'phpdoc_add_missing_param_annotation' => ['only_untyped' => false],
        'ordered_imports'                     => true,
        'phpdoc_order'                        => true,
        'array_syntax'                        => ['syntax' => 'short'],
    ]);
