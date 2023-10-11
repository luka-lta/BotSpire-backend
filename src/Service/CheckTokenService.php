<?php
declare(strict_types=1);

namespace BotSpireBackend\Service;

use BotSpireBackend\Repository\UserDataRepository;
use BotSpireBackend\Util\JwtUtil;
use BotSpireBackend\Util\ReturnMessage;
use BotSpireBackend\Value\UserId;
use JsonException;

class CheckTokenService
{
    public function __construct(
        private readonly JwtUtil            $jwtUtil,
        private readonly UserDataRepository $dataRepository,
    )
    {
    }

    /**
     * @throws JsonException
     */
    public function checkToken(string $token): array
    {
        $data = $this->jwtUtil->decodeToken($token);
        $userId = UserId::from((int)$data);
        if (isset($data['message'])) {
            $userId = UserId::from();
        }
        if (!$this->dataRepository->userExistsWithId($userId)) {
            return ReturnMessage::setJsonWithStatus(400, 'Invalid JWT Token!');
        }

        $user = $this->dataRepository->getUserWithUserId($userId);
        return ReturnMessage::setJsonWithStatus(200, 'User found!', $user->toArray());
    }
}