<?php
declare(strict_types=1);

namespace Kontrolio\Error;

use Countable;
use Kontrolio\Data\Attribute;
use Kontrolio\Rules\RuleInterface;

/**
 * Validation errors.
 */
final class Errors implements Countable
{
    private array $messages;
    private array $errors = [];

    public function __construct(array $messages)
    {
        $this->messages = $messages;
    }

    public function raw()
    {
        return $this->errors;
    }

    /**
     * Returns a flattened list of validation errors.
     *
     * @return array
     */
    public function flatten(): array
    {
        $list = [];

        foreach ($this->errors as $messages) {
            foreach ($messages as $message) {
                $list[] = $message;
            }
        }

        return $list;
    }

    public function has(Attribute|string $attribute): bool
    {
        $attribute = $attribute instanceof Attribute ? $attribute->name : $attribute;

        return array_key_exists($attribute, $this->errors);
    }

    public function count(): int
    {
        return count($this->errors);
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    /**
     * Adds a new validation error for the given attribute and rule.
     *
     * @param Attribute $attribute
     * @param RuleInterface $rule
     */
    public function add(Attribute $attribute, RuleInterface $rule): void
    {
        $errors = $this->prepareErrors($attribute->name, $this->prepareRuleKey($attribute->name, $rule), $rule);

        if ($this->has($attribute->name)) {
            $this->errors[$attribute->name] = array_merge($this->errors[$attribute->name], $errors);
        } else {
            $this->errors[$attribute->name] = $errors;
        }
    }

    /**
     * Prepares rule key for the validation error messages array.
     *
     * @param string $attribute
     * @param RuleInterface $rule
     *
     * @return string|int
     */
    private function prepareRuleKey(string $attribute, RuleInterface $rule): string|int
    {
        $name = $rule->getName();

        if ($name) {
            return $name;
        }

        if ($this->has($attribute)) {
            return $this->count();
        }

        return 0;
    }

    /**
     * Prepares validation error messages to proper format.
     *
     * @param string $attribute
     * @param string $ruleName
     * @param RuleInterface $rule
     *
     * @return array
     */
    private function prepareErrors(string $attribute, string $ruleName, RuleInterface $rule): array
    {
        $messages = $this->getMessagesByAttributeAndRuleName($attribute, $ruleName);
        $violations = $rule->getViolations();

        if (!count($violations)) {
            return [reset($messages)];
        }

        return $this->getMessagesForViolations($messages, $violations, $attribute . '.' . $ruleName);
    }

    /**
     * Filter all given messages by the attribute and the rule name.
     *
     * @param string $attribute
     * @param string $ruleName
     *
     * @return array
     */
    private function getMessagesByAttributeAndRuleName(string $attribute, string $ruleName): array
    {
        $prefix = $attribute . '.' . $ruleName;

        $filter = static fn ($key) => $key === $attribute || str_starts_with($key, $prefix);
        $messages = array_filter($this->messages, $filter, ARRAY_FILTER_USE_KEY);

        if (empty($messages)) {
            $messages = [$prefix];
        }

        return $messages;
    }

    /**
     * Returns messages for all validation rule violations.
     *
     * @param array $messages
     * @param array $violations
     * @param string $prefix
     *
     * @return array
     */
    private function getMessagesForViolations(array $messages, array $violations, string $prefix): array
    {
        $result = [];

        foreach ($violations as $violation) {
            $keys = [
                $prefix,
                $prefix . '.' . $violation
            ];

            foreach ($keys as $key) {
                if (array_key_exists($key, $messages)) {
                    $result[] = $messages[$key];
                }
            }
        }

        return $result;
    }
}
