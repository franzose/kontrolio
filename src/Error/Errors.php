<?php

namespace Kontrolio\Error;

use Countable;
use Kontrolio\Data\Attribute;
use Kontrolio\Rules\RuleInterface;

/**
 * Validation errors.
 */
final class Errors implements Countable
{
    private $messages;
    private $errors = [];

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
    public function flatten()
    {
        $list = [];

        foreach ($this->errors as $messages) {
            foreach ($messages as $message) {
                $list[] = $message;
            }
        }

        return $list;
    }

    /**
     * @param Attribute|string $attribute
     *
     * @return bool
     */
    public function has($attribute)
    {
        $attribute = $attribute instanceof Attribute ? $attribute->getName() : $attribute;

        return array_key_exists($attribute, $this->errors);
    }

    public function count()
    {
        return count($this->errors);
    }

    public function isEmpty()
    {
        return $this->count() === 0;
    }

    /**
     * Adds a new validation error for the given attribute and rule.
     *
     * @param Attribute $attribute
     * @param RuleInterface $rule
     */
    public function add(Attribute $attribute, RuleInterface $rule)
    {
        $name = $attribute->getName();
        $errors = $this->prepareErrors($name, $this->prepareRuleKey($name, $rule), $rule);

        if ($this->has($name)) {
            $this->errors[$name] = array_merge($this->errors[$name], $errors);
        } else {
            $this->errors[$name] = $errors;
        }
    }

    /**
     * Prepares rule key for the validation error messages array.
     *
     * @param string $attribute
     * @param RuleInterface $rule
     *
     * @return string
     */
    private function prepareRuleKey($attribute, RuleInterface $rule)
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
    private function prepareErrors($attribute, $ruleName, RuleInterface $rule)
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
    private function getMessagesByAttributeAndRuleName($attribute, $ruleName)
    {
        $prefix = $attribute . '.' . $ruleName;

        $messages = array_filter($this->messages, static function ($key) use ($attribute, $prefix) {
            return $key === $attribute || strpos($key, $prefix) === 0;
        }, ARRAY_FILTER_USE_KEY);

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
    private function getMessagesForViolations(array $messages, array $violations, $prefix)
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
