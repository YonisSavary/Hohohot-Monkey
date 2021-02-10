<?php 
 
namespace Controllers;

use Models\Configuration;
use Models\HistoCapteurs;
use Monkey\Services\Auth;
use Monkey\Web\Response;

class HistoController
{
    public function get()
    {
        $c = new Configuration();
        $u = Auth::get_user();

        $config = $c->get_all()->where("user_id", $u->id)->execute()[0];
        
        $config->domain = preg_replace("/.+:\/\//", "", $config->api_url);
        $config->domain = preg_replace("/\/.+/", "", $config->domain);

        $h = new HistoCapteurs();

        $results = $h->get_all()->where("domain", $config->domain)->limit(100)->execute();

        return Response::json($results);
    }
}