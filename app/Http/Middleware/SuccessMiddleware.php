<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class SuccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof JsonResponse) {
            $data = $response->getData(true);

            $success = $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;

            $data = array_merge(['success' => $success], $data);

            $response->setData($data);
        }

        return $response;
    }

}
