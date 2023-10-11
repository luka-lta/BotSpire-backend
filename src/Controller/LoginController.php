<?php
declare(strict_types=1);

namespace BotSpireBackend\Controller;

use BotSpireBackend\Service\LoginService;
use BotSpireBackend\Util\ReturnMessage;
use BotSpireBackend\Value\Email;
use BotSpireBackend\Value\UserPassword;
use InvalidArgumentException;
use JsonException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LoginController
{
    public function __construct(
        private readonly LoginService $loginService,
    )
    {
    }

    /**
     * @throws JsonException
     */
    public function controllLoginRoute(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $request->getParsedBody();
        if (!isset($data['email'], $data['password'])) {
            return ReturnMessage::sendResponse($response, ReturnMessage::setJsonWithStatus(400, 'Invalid body!'));
        }
        try {
            $email = Email::from($data['email']);
            $password = $data['password'];

            $result = $this->loginService->loginUser($email, $password);
        } catch (InvalidArgumentException $exception) {
            return ReturnMessage::sendResponse($response, ReturnMessage::setJsonWithStatus(400, $exception->getMessage()));
        }

        return ReturnMessage::sendResponse($response, $result);
    }
}