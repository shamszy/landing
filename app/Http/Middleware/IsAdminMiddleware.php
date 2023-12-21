<?php

namespace App\Http\Middleware;

use App\Http\Resources\UserResource;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class IsAdminMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return JsonResponse
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        if ($request->user()->role != 'admin') {
            return response()->json([
                'message' => 'Sorry you can not access this route',
                'data' => new UserResource($request->user()),
                'success' => false
            ], HttpResponse::HTTP_NOT_ACCEPTABLE);
        }
        return $next($request);
    }
    
}
