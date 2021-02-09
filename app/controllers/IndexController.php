<?php 

namespace Controllers;

use Models\Configuration;
use Monkey\Services\Auth;
use Monkey\Web\Renderer;
use Monkey\Web\Response;

class IndexController 
{
    public function index()
    {
        return Renderer::render("index");
    }
    
    public function home()
    {
        return Renderer::render("home");
    }

    public function proxy()
    {
        ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0)'); 
        $c = new Configuration();
        $u = Auth::get_user();
        $configuration = $c->get("api_url")->where("user_id", $u->id)->execute();
        $url = $configuration[0]->api_url;
        $data = json_decode(file_get_contents($url));
        return Response::json($data);
    }

}