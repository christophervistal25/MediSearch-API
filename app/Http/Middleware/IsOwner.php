<?php

namespace App\Http\Middleware;

use App\Owner;
use Closure;

class IsOwner
{
    private $owner;
    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Owner $owner)
    {
        $this->owner = $owner;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        if ( !$this->owner->findByEmail($request->email) ) {
            return response()->json(['success' => false, 'message' => 'Please check your username or password.'], 422);
        }

        return $next($request);
    }
}
