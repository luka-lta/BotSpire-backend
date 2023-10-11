<?php
declare(strict_types=1);

namespace BotSpireBackend\Service;

use BotSpireBackend\Repository\UserDataRepository;
use BotSpireBackend\Util\JwtUtil;
use BotSpireBackend\Util\ReturnMessage;
use BotSpireBackend\Value\Email;
use BotSpireBackend\Value\UserPassword;
use Exception;
use JsonException;

class LoginService
{
    public function __construct(
        private readonly UserDataRepository $checkDataRepository,
        private readonly JwtUtil            $jwtUtil,
    )
    {
    }

    /**
     * @throws JsonException
     * @throws Exception
     */
    public function loginUser(Email $email, string $password): array
    {
        if (!$this->checkDataRepository->userExistsWithEmail($email)) {
            return ReturnMessage::setJsonWithStatus(401, 'Email does not exists!');
        }

        if (!$this->checkDataRepository->passwordMatchesWithEmail($email, $password)) {
            return ReturnMessage::setJsonWithStatus(401, 'Password does not match!');
        }

        $user = $this->checkDataRepository->getUserWithEmail($email);
        return ReturnMessage::setJsonWithStatus(200, '', [
            'token' => $this->jwtUtil->encodeToken((string)$user->getUserId()->getValue())
        ]);
    }
}