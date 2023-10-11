<?php
declare(strict_types=1);

namespace BotSpireBackend\Repository;

use BotSpireBackend\Value\Email;
use BotSpireBackend\Value\User;
use BotSpireBackend\Value\UserId;
use BotSpireBackend\Value\Username;
use BotSpireBackend\Value\UserPassword;
use Error;
use Exception;
use PDO;
use PDOException;

class UserDataRepository
{
    public function __construct(private readonly PDO $database)
    {
    }

    public function userExistsWithId(UserId $userId): bool
    {
        $sql = 'SELECT * FROM user_data WHERE user_id = :userId';
        try {
            $stmt = $this->database->prepare($sql);
            $stmt->execute([
                'userId' => $userId->getValue()
            ]);

            return $stmt->rowCount() > 0;
        } catch (PDOException $exception) {
            // todo: Besseres handling
            throw new Error($exception->getMessage());
        }
    }

    public function userExistsWithUsername(Username $username): bool
    {
        $sql = 'SELECT * FROM user_data WHERE username = :username';
        try {
            $stmt = $this->database->prepare($sql);
            $stmt->execute([
                'username' => $username->getValue()
            ]);

            return $stmt->rowCount() > 0;
        } catch (PDOException $exception) {
            // todo: Besseres handling
            throw new Error($exception->getMessage());
        }
    }

    public function userExistsWithEmail(Email $email): bool
    {
        $sql = 'SELECT * FROM user_data WHERE email = :email';
        try {
            $stmt = $this->database->prepare($sql);
            $stmt->execute([
                'email' => $email->getValue()
            ]);

            return $stmt->rowCount() > 0;
        } catch (PDOException $exception) {
            // todo: Besseres handling
            throw new Error($exception->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function passwordMatchesWithEmail(Email $email, string $password): bool
    {
        $sql = 'SELECT password FROM user_data WHERE email = :email';
        try {
            $stmt = $this->database->prepare($sql);
            $stmt->execute([
                'email' => $email->getValue()
            ]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $passwordFromDatabase = $result['password'];

            return password_verify($password, $passwordFromDatabase);
        } catch (PDOException $exception) {
            throw new Exception('Error in passwordMatchesWithEmail');
        }
    }

    public function getUserWithEmail(Email $email): User
    {
        $sql = 'SELECT * FROM user_data WHERE email = :email';
        try {
            $stmt = $this->database->prepare($sql);
            $stmt->execute([
                'email' => $email->getValue()
            ]);
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);
            return User::fromDatabaseRow($rows);
        } catch (PDOException $exception) {
            throw new Error($exception->getMessage());
        }
    }

    public function getUserWithUserId(UserId $userId): User
    {
        $sql = 'SELECT * FROM user_data WHERE user_id = :userId';
        try {
            $stmt = $this->database->prepare($sql);
            $stmt->execute([
                'userId' => $userId->getValue()
            ]);
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);
            return User::fromDatabaseRow($rows);
        } catch (PDOException $exception) {
            throw new Error($exception->getMessage());
        }
    }
}