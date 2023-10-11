<?php
declare(strict_types=1);

namespace BotSpireBackend\Value;

use InvalidArgumentException;

final class Email
{
    private string $value;

    private function __construct(string $value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            throw new InvalidArgumentException('Invalid Email');
        }

        $this->value = $value;
    }

    public static function from(string $value): self
    {
        return new self($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }
}