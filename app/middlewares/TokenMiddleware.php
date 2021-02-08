<?php 

namespace Middlewares;

use Monkey\Services\Auth;
use Monkey\Web\API;
use Monkey\Web\Request;

class TokenMiddleware 
{
    public function handle(Request $req){
        $token = API::retrieve($req, ["token"]);
        $token = $token["token"];
        if (Auth::token() !== $token){
            return API::error("Bad User Token");
        }
    }
}