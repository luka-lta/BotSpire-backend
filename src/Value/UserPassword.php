<?php
declare(strict_types=1);

namespace BotSpireBackend\Value;

final class UserPassword
{
    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function fromClear(string $value): self
    {
        $hashedPassword = password_hash($value, PASSWORD_BCRYPT);
        return new self($hashedPassword);
    }

    public static function fromHash(string $value): self
    {
        return new self($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }
}