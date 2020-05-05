<?php

namespace Kontrolio\Rules;

use UnexpectedValueException;

final class ArrayNormalizer
{
    private $parser;

    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Normalizes "raw" array of rules.
     *
     * This method turns the following array structure
     *
     * [
     *     'foo' => 'equal_to:foo|not_equal_to:bar',
     *     'bar' => new EqualTo('foo'),
     *     'qux' => static function ($value) {
     *         return $value === 'qux';
     *     }
     * ]
     *
     * to this one
     *
     * [
     *    'foo' => [
     *        new EqualTo('foo'),
     *        new NotEqualTo('bar')
     *    ],
     *    'bar' => [
     *        new EqualTo('foo'),
     *    ],
     *    'qux' => [
     *        static function ($value) {
     *            return $value === 'qux';
     *        }
     *    ]
     * ]
     *
     * @param array $raw
     *
     * @return RuleInterface[][]|callable[][]
     * @throws UnexpectedValueException
     */
    public function normalize(array $raw)
    {
        $attributes = array_keys($raw);

        $rules = array_map(function ($attribute) use ($raw) {
            return $this->resolveRules($raw[$attribute]);
        }, $attributes);

        return array_combine($attributes, $rules);
    }

    /**
     * Resolves rules from different formats.
     *
     * @param RuleInterface[]|callable[]|RuleInterface|callable|string $rules
     *
     * @return RuleInterface[]
     * @throws UnexpectedValueException
     */
    private function resolveRules($rules)
    {
        if (is_array($rules)) {
            foreach ($rules as $rule) {
                static::ensureType($rule);
            }

            return $rules;
        }

        if (is_string($rules)) {
            return $this->parser->parse($rules);
        }

        static::ensureType($rules);

        return [$rules];
    }

    /**
     * Checks rule for the proper type.
     *
     * @param mixed $rule
     * @throws UnexpectedValueException
     */
    private static function ensureType($rule)
    {
        if (!$rule instanceof RuleInterface && !is_callable($rule)) {
            throw new UnexpectedValueException(
                sprintf('Rule must implement `%s` or be callable.', RuleInterface::class)
            );
        }
    }
}
