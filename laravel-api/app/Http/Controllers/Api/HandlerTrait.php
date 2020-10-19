<?php

namespace App\Http\Controllers\Api;

use Chaos\Service\Exception;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

/**
 * Trait HandlerTrait.
 *
 * @author t(-.-t) <ntd1712@mail.com>
 */
trait HandlerTrait
{
    /**
     * {@inheritDoc}
     *
     * @param Throwable $exception Exception.
     *
     * @return Throwable
     */
    protected function prepareException(Throwable $exception)
    {
        if ($exception instanceof Exception\ModelNotFoundException) {
            $exception = new NotFoundHttpException($exception->getMessage(), $exception);
        } elseif ($exception instanceof Exception\ValidationException) {
            $exception = new NotAcceptableHttpException($exception->getMessage(), $exception);
        }
        /*
        else if (
            $exception instanceof \Tymon\JWTAuth\Exceptions\JWTException ||
            $exception instanceof \League\OAuth2\Client\Provider\Exception\IdentityProviderException
        ) {
            $exception = new \Illuminate\Auth\AuthenticationException;
        }
        */

        return parent::prepareException($exception);
    }
}
