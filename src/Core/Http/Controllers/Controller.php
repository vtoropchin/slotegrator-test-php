<?php declare(strict_types=1);


namespace Src\Core\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class Controller
 * @package Src\Core\Http\Controllers
 */
class Controller
{
    /**
     * @param array $content
     *
     * @return Response
     * @throws \JsonException
     */
    protected function success(array $content): Response
    {
        return new Response(
            json_encode($content, JSON_THROW_ON_ERROR),
            200,
            [
                'Content-Type' => 'application/json',
            ]
        );
    }

    /**
     * @param array $errors
     * @param int   $code
     *
     * @return Response
     * @throws \JsonException
     */
    protected function false(array $errors, int $code): Response
    {
        return new Response(
            json_encode(
                [
                    'errors' => $errors,
                ],
                JSON_THROW_ON_ERROR
            ),
            $code,
            [
                'Content-Type' => 'application/json',
            ]
        );
    }
}
