<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $modelName
     * @param  string|null  $namespace
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $modelName, $namespace = null): Response
    {
        $currentUser = Auth::user();
        
        // Handle the dynamic namespace for the model
        $modelNamespace = $namespace ? "App\\Models\\$namespace\\$modelName" : "App\\Models\\$modelName";
        
        $resource = $modelNamespace::findOrFail($request->id);

        if ($resource->author != $currentUser->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}


