<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;

/**
 * Class CustomExceptionController
 */
class CustomExceptionController
{
    /**
     * @param Request $request
     * @param $exception
     * @param DebugLoggerInterface|null $logger
     *
     * @return JsonResponse
     */
    public function showAction(Request $request, $exception, DebugLoggerInterface $logger = null)
    {
        return new JsonResponse([
            'error' => $exception->getStatusText()
        ], $exception->getStatusCode());
    }
}
