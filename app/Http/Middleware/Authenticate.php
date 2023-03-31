<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;



class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        
        $requestdata = Storage::disk('local')->exists(date('d_m_Y').'_request.json') ? json_decode(Storage::disk('local')->get(date('d_m_Y').'_request.json')) : [];
        array_push($requestdata, $request->all());
        Storage::disk('local')->put(date('d_m_Y').'_request.json', json_encode($requestdata));

        $storagedata = Storage::disk('local')->exists(date('d_m_Y') . '_headers.json') ? json_decode(Storage::disk('local')->get(date('d_m_Y') . '_headers.json')) : [];
        array_push($storagedata, $request->headers->all());
        Storage::disk('local')->put(date('d_m_Y') . '_headers.json', json_encode($storagedata));

        if ($this->auth->guard($guard)->guest()) {
            return response('Unauthorized.', 401);
        }

        return $next($request);
    }
}
