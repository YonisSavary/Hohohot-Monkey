<?php 

namespace Middlewares;

use Monkey\Router;
use Monkey\Services\Auth;

class AuthMiddleware 
{
    const NOT_LOGGED_REDIRECT = "/login";

    public function handle()
    {
        if (!Auth::is_logged()) Router::redirect(AuthMiddleware::NOT_LOGGED_REDIRECT);
    }
}