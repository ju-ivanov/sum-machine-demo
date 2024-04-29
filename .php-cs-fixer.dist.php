<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$rules = [
    '@PSR1'                                            => true,
    '@PSR2'                                            => true,
    '@PSR12'                                           => true,
    '@PER'                                             => true,
    'array_indentation'                                => true,
    'array_syntax'                                     => [
        'syntax' => 'short'
    ],
    'binary_operator_spaces'                           => [
        'default'   => 'single_space',
        'operators' => ['=>' => null],
    ],
    'blank_line_after_namespace'                       => true,
    'blank_line_after_opening_tag'                     => true,
    'blank_line_before_statement'                      => [
        'statements' => [
            'if',
            'break',
            'continue',
            'declare',
            'return',
            'throw',
            'try',
        ]
    ],
    'declare_parentheses'                              => true,
    'single_space_around_construct'                    => true,
    'cast_spaces'                                      => true,
    'class_attributes_separation'                      => [
        'elements' => [
            'method'       => 'one',
            'trait_import' => 'none',
        ],
    ],
    'class_definition'                                 => [
        'multi_line_extends_each_single_line' => true,
        'single_item_single_line'             => true,
        'single_line'                         => true,
    ],
    'concat_space'                                     => [
        'spacing' => 'one',
    ],
    'declare_equal_normalize'                          => true,
    'elseif'                                           => true,
    'encoding'                                         => true,
    'full_opening_tag'                                 => true,
    'fully_qualified_strict_types'                     => true, // added by Shift
    'function_declaration'                             => true,
    'type_declaration_spaces'                          => false,
    'general_phpdoc_tag_rename'                        => true,
    'heredoc_to_nowdoc'                                => true,
    'include'                                          => true,
    'increment_style'                                  => [
        'style' => 'post'
    ],
    'indentation_type'                                 => true,
    'single_trait_insert_per_statement'                => true,
    'linebreak_after_opening_tag'                      => true,
    'line_ending'                                      => true,
    'lowercase_cast'                                   => true,
    'lowercase_keywords'                               => true,
    'lowercase_static_reference'                       => true, // added from Symfony
    'magic_method_casing'                              => true, // added from Symfony
    'magic_constant_casing'                            => true,
    'method_argument_space'                            => [
        'on_multiline' => 'ignore',
    ],
    'multiline_whitespace_before_semicolons'           => [
        'strategy' => 'no_multi_line',
    ],
    'native_function_casing'                           => true,
    'no_alias_functions'                               => true,
    'no_extra_blank_lines'                             => [
        'tokens' => [
            'attribute',
            'break',
            'case',
            'continue',
            'curly_brace_block',
            'default',
            'extra',
            'parenthesis_brace_block',
            'return',
            'square_brace_block',
            'switch',
            'throw',
            'use',
        ]
    ],
    'no_blank_lines_after_class_opening'               => true,
    'no_blank_lines_after_phpdoc'                      => true,
    'no_closing_tag'                                   => true,
    'no_empty_phpdoc'                                  => true,
    'no_superfluous_phpdoc_tags'                       => true,
    'no_empty_statement'                               => true,
    'no_leading_import_slash'                          => true,
    'no_leading_namespace_whitespace'                  => true,
    'no_mixed_echo_print'                              => [
        'use' => 'echo',
    ],
    'no_multiline_whitespace_around_double_arrow'      => true,
    'no_short_bool_cast'                               => true,
    'no_singleline_whitespace_before_semicolons'       => true,
    'no_spaces_after_function_name'                    => true,
    'no_spaces_around_offset'                          => [
        'positions' => [
            'inside',
            'outside',
        ],
    ],
    'spaces_inside_parentheses'                        => false,
    'no_trailing_comma_in_singleline'                  => true,
    'no_trailing_whitespace'                           => true,
    'no_trailing_whitespace_in_comment'                => true,
    'no_unneeded_control_parentheses'                  => [
        'statements' => [
            'break',
            'clone',
            'continue',
            'echo_print',
            'return',
            'switch_case',
            'yield',
        ],
    ],
    'no_unreachable_default_argument_value'            => true,
    'no_useless_return'                                => true,
    'no_whitespace_before_comma_in_array'              => true,
    'no_whitespace_in_blank_line'                      => true,
    'normalize_index_brace'                            => true,
    'not_operator_with_successor_space'                => true,
    'object_operator_without_whitespace'               => true,
    'ordered_imports'                                  => [
        'sort_algorithm' => 'alpha',
    ],
    'psr_autoloading'                                  => true,
    'phpdoc_indent'                                    => true,
    'phpdoc_inline_tag_normalizer'                     => true,
    'phpdoc_no_access'                                 => true,
    'phpdoc_no_package'                                => true,
    'phpdoc_no_useless_inheritdoc'                     => true,
    'phpdoc_scalar'                                    => true,
    'phpdoc_single_line_var_spacing'                   => true,
    'phpdoc_summary'                                   => false,
    'phpdoc_to_comment'                                => false, // override to preserve user preference
    'phpdoc_tag_type'                                  => true,
    'phpdoc_trim'                                      => true,
    'phpdoc_types'                                     => true,
    'phpdoc_var_without_name'                          => true,
    'phpdoc_var_annotation_correct_order'              => true,
    'phpdoc_trim_consecutive_blank_line_separation'    => true,
    'self_accessor'                                    => true,
    'short_scalar_cast'                                => true,
    'simplified_null_return'                           => false, // disabled as "risky"
    'single_blank_line_at_eof'                         => true,
    'single_class_element_per_statement'               => [
        'elements' => [
            'const',
            'property',
        ],
    ],
    'single_import_per_statement'                      => true,
    'single_line_after_imports'                        => true,
    'single_line_comment_style'                        => [
        'comment_types' => [
            'asterisk',
        ],
    ],
    'single_quote'                                     => true,
    'space_after_semicolon'                            => true,
    'standardize_not_equals'                           => true,
    'switch_case_semicolon_to_colon'                   => true,
    'switch_case_space'                                => true,
    'ternary_operator_spaces'                          => true,
    'trailing_comma_in_multiline'                      => [
        'elements' => [
            'arrays',
        ]
    ],
    'trim_array_spaces'                                => true,
    'unary_operator_spaces'                            => true,
    'visibility_required'                              => true,
    'whitespace_after_comma_in_array'                  => true,
    'no_unused_imports'                                => true,
    'protected_to_private'                       => true,
    'no_useless_concat_operator'                       => true,
    'explicit_string_variable'                         => true,
    'global_namespace_import'                          => true,
    'nullable_type_declaration_for_default_null_value' => true,
    'strict_comparison'                                => true,
    'void_return'                                      => true,
    'ordered_class_elements'                           => [
        'order'          => [
            'use_trait',
            'case',
            'constant_public',
            'constant_protected',
            'constant_private',
            'property_static',
            'property_public',
            'property_public_readonly',
            'property_public_static',
            'property_protected',
            'property_protected_readonly',
            'property_protected_static',
            'property_private',
            'property_private_readonly',
            'property_private_static',
            'method_abstract',
            'method_public_abstract',
            'method_protected_abstract',
            'method_private_abstract',
            'method_public_abstract_static',
            'method_protected_abstract_static',
            'method_private_abstract_static',
            'method_public',
            'method_protected',
            'method_private',
            'method_static',
            'method_public_static',
            'method_protected_static',
            'method_private_static'
        ],
    ],
    'new_with_braces' => [
        'anonymous_class' => false,
    ]
];

$finder = Finder::create()
    ->in(__DIR__)
    ->exclude(
        [
            'vendor',
            'deploy',
            'docker',
            'resources',
            'storage',
            'public',
        ]
    )
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
    ->ignoreVCSIgnored(true);

return (new Config())
    ->setFinder($finder)
    ->setRules($rules)
    ->setLineEnding(PHP_EOL)
    ->setRiskyAllowed(true)
    ->setUsingCache(true)
    ->setCacheFile(__DIR__.'/storage/framework/cache/CI/.php-cs-fixer.cache');
