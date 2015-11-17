<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Config;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->server->get('PHP_AUTH_USER');
        $password = $request->server->get('PHP_AUTH_PW');
        if ($user && $password && Config::get('users.' . $user) == $password) {
            return $next($request);
        } else {
            $this->auth();
        }
    }
    private function auth()
    {
        header('WWW-Authenticate: Basic realm="Khmm!"');
        header('HTTP/1.0 401 Unauthorized');
        exit;
    }
}