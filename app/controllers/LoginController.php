<?php 

namespace Controllers;

use Models\Configuration;
use Models\Utilisateurs;
use Monkey\Dist\DB;
use Monkey\Router;
use Monkey\Services\Auth;
use Monkey\Web\API;
use Monkey\Web\Renderer;
use Monkey\Web\Request;
use Monkey\Web\Response;

class LoginController 
{

    public function logout_user()
    {
        Auth::logout();
        return Router::redirect("/login");
    }

    public function login_page()
    {
        if (Auth::is_logged()) return Router::redirect("/home");
        return Renderer::render("login");
    }

    public function login_user(Request $req)
    {
        $login = $req->post["login"];
        $pass = $req->post["pass"];
        if ($login === null || $pass === null) Router::redirect("/login");
        if (Auth::attempt($login, $pass))
        {
            $user = Auth::get_user();
            $c = new Configuration;
            $res = $c->get_all()->where("user_id", $user->id)->execute();
            if (count($res)===0) {
                $c->insert("user_id")->values($user->id)->execute();
                $res = $c->get_all()->where("user_id", $user->id)->execute();
            }
            $_SESSION["config"] = $res[0];

            Router::redirect("/home");
        }
        else 
        {
            Router::redirect("/login");
        }
    }

    public function register_page(){
        return Renderer::render("register");
        
    }


    public function register_user(Request $req){
        $login = $req->post["login"];
        $pass = $req->post["pass"];
        if ($login === null || $pass === null) Router::redirect("/login");

        $u = new Utilisateurs();
        $exists = $u->get("login")->where("login", $login)->limit(1)->execute();
        if (count($exists)>0){
            Router::redirect("/login?error=exists");
        }

        $u->insert("login", "pass")->values($login, Auth::create_password($pass))->execute();
        Router::redirect("/home");

    }

    public function change_pass(Request $req)
    {
        $pass = API::retrieve($req, ["password"])["password"];
        $user = Auth::get_user();
        $user->pass = Auth::create_password($pass);
        $user->save();
        Auth::logout();
        return API::ok("done.");
    }


    public function unregister()
    {
        $user = Auth::get_user();
        $c = new Configuration();
        $c->delete_from()->where("user_id", $user->id)->execute();
        $user->delete();
        Auth::logout();
        Router::redirect(router("login"));
    }
}