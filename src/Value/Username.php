<?php
declare(strict_types=1);

namespace BotSpireBackend\Value;

use InvalidArgumentException;

final class Username
{
    private string $value;

    private function __construct(string $value)
    {
        $nameRegex = '/^[a-zA-Z0-9_ÄÖÜäöüß-]{3,20}$/u';
        if (!preg_match($nameRegex, $value)) {
            throw new InvalidArgumentException('Username does not match pattern!');
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