<?php 

namespace Controllers;

use Kernel\Model\ModelParser;
use Models\Configuration;
use Monkey\Services\Auth;
use Monkey\Web\API;
use Monkey\Web\Renderer;
use Monkey\Web\Request;
use Monkey\Web\Response;

class ConfigController
{
    public function config_page()
    {
        return Renderer::render("config");
    }

    public function read()
    {
        $user = Auth::get_user();
        $c = new Configuration;
        $c->user_id = $user->id;
        $res = $c->get_all()->where("user_id", $user->id)->execute();
        return Response::json($res[0]);
    } 

    public function update(Request $req)
    {
        $config = API::retrieve($req, ["config"]);
        $config = (array) json_decode($config["config"]);
        $new_config = new Configuration;
        $parser = new ModelParser($new_config::class);
        $fields = $parser->get_model_fields();
        foreach ($fields as $f){
            if ($config[$f] === null) continue;
            $new_config->$f = $config[$f];
        }
        $new_config->user_id = Auth::get_user()->id;
        $new_config->save();
        return API::ok("done.");
    }

}