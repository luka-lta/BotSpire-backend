<?php
declare(strict_types=1);

namespace BotSpireBackend\Value;

use DateTime;

final class LastLogin
{
    private ?DateTime $value;

    private function __construct(?DateTime $value)
    {
        $this->value = $value;
    }

    public static function fromString(?string $value): self
    {
        $formattedDateTime = DateTime::createFromFormat('Y-m-d H:m:s', $value);
        return new self($formattedDateTime);
    }

    public function getValue(): ?DateTime
    {
        return $this->value;
    }
}