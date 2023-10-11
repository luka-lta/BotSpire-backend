<?php
declare(strict_types=1);

namespace BotSpireBackend\Value;

class User
{
    private function __construct(
        private ?UserId      $userId,
        private Username     $username,
        private Email        $email,
        private UserPassword $password,
        private ?LastLogin   $lastLogin
    )
    {
    }

    public static function from(Username $username, Email $email, UserPassword $password): self
    {
        return new self(
            null,
            $username,
            $email,
            $password,
            null
        );
    }

    public static function fromDatabaseRow(array $row): self
    {
        $userId = UserId::from($row['user_id']);
        $username = Username::from($row['username']);
        $email = Email::from($row['email']);
        $password = UserPassword::fromHash($row['password']);
        $lastLogin = LastLogin::fromString($row['last_login']);

        return new self($userId, $username, $email, $password, $lastLogin);
    }

    public function getUserId(): ?UserId
    {
        return $this->userId;
    }

    public function getUsername(): Username
    {
        return $this->username;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): UserPassword
    {
        return $this->password;
    }

    public function getLastLogin(): LastLogin
    {
        return $this->lastLogin;
    }

    public function toArray(): array
    {
        return [
            'user_id'    => $this->userId?->getValue(),
            'username'   => $this->username->getValue(),
            'email'      => $this->email->getValue(),
            'password'   => $this->password->getValue(),
            'last_login' => $this->lastLogin?->getValue(),
        ];
    }
}