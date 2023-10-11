<?php
declare(strict_types=1);

namespace BotSpireBackend\Controller;

use BotSpireBackend\Service\CheckTokenService;
use BotSpireBackend\Util\ReturnMessage;
use JsonException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CheckController
{
    public function __construct(
        private readonly CheckTokenService $checkTokenService,
    )
    {
    }

    /**
     * @throws JsonException
     */
    public function controllCheckRoute(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $request->getHeaders();
        if (!isset($data['Authorization'])) {
            return ReturnMessage::sendResponse($response, ReturnMessage::setJsonWithStatus(400, 'Authorization empty!'));
        }
        $result = $this->checkTokenService->checkToken($data['Authorization'][0]);

        return ReturnMessage::sendResponse($response, $result);
    }
}