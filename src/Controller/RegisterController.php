<?php
declare(strict_types=1);

namespace BotSpireBackend\Controller;

use BotSpireBackend\Repository\RegisterRepository;
use BotSpireBackend\Util\ReturnMessage;
use BotSpireBackend\Value\Email;
use BotSpireBackend\Value\User;
use BotSpireBackend\Value\Username;
use BotSpireBackend\Value\UserPassword;
use InvalidArgumentException;
use JsonException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RegisterController
{
    public function __construct(
        private readonly RegisterRepository $registerRepository,
    )
    {
    }

    /**
     * @throws JsonException
     */
    public function controllRegisterRoute(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $request->getParsedBody();
        if (!isset($data['username'], $data['email'], $data['password'])) {
            return ReturnMessage::sendResponse($response, ReturnMessage::setJsonWithStatus(400, 'Invalid body!'));
        }
        try {
            $username = Username::from($data['username']);
            $email = Email::from($data['email']);
            $password = UserPassword::fromClear($data['password']);

            $registredUser = User::from($username, $email, $password);
            $result = $this->registerRepository->registerNewUser($registredUser);
        } catch (InvalidArgumentException $exception) {
            return ReturnMessage::sendResponse($response, ReturnMessage::setJsonWithStatus(400, $exception->getMessage()));
        }

        return ReturnMessage::sendResponse($response, $result);
    }
}