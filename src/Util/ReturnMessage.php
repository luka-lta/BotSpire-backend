<?php
declare(strict_types=1);

namespace BotSpireBackend\Util;

use JsonException;
use Psr\Http\Message\ResponseInterface;

class ReturnMessage
{

    /**
     * @throws JsonException
     */
    public static function setJsonWithStatus(int $statusCode, string $message, array $extra = []): array
    {
        $result = ['status' => $statusCode];
        if ($message) $result['message'] = $message;
        $encodedJson = json_encode(array_merge($result, $extra), JSON_PRETTY_PRINT |JSON_THROW_ON_ERROR);
        return [
            'message' => $encodedJson,
            'status' => $statusCode,
        ];
    }

    public static function sendResponse(ResponseInterface $response, array $messageArray): ResponseInterface
    {
        $response->getBody()->write($messageArray['message']);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($messageArray['status']);
    }
}