<?php
declare(strict_types=1);

namespace BotSpireBackend\Repository;

use BotSpireBackend\Util\JwtUtil;
use BotSpireBackend\Util\ReturnMessage;
use BotSpireBackend\Value\User;
use JsonException;
use PDO;
use PDOException;

class RegisterRepository
{
    public function __construct(
        private readonly PDO                $database,
        private readonly UserDataRepository $checkDataRepository,
    )
    {
    }

    /**
     * @throws JsonException
     */
    public function registerNewUser(User $user): array
    {
        if ($this->checkDataRepository->userExistsWithUsername($user->getUsername())) {
            return ReturnMessage::setJsonWithStatus(422, 'User with this name already exists');
        }

        if ($this->checkDataRepository->userExistsWithEmail($user->getEmail())) {
            return ReturnMessage::setJsonWithStatus(422, 'User with this email already exists');
        }

        $sql = 'INSERT INTO user_data (username, email, password) VALUES (:username, :email, :password)';
        try {
            $stmt = $this->database->prepare($sql);
            $stmt->execute([
                'username' => $user->getUsername()->getValue(),
                'email' => $user->getEmail()->getValue(),
                'password' => $user->getPassword()->getValue(),
            ]);
            $result = ReturnMessage::setJsonWithStatus(201, 'User created successfully!');
        } catch (PDOException $exception) {
            $result = ReturnMessage::setJsonWithStatus(400, $exception->getMessage());
        }

        return $result;
    }
}